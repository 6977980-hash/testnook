<?php
/**
 * Leaderboards: opt-in nicknames on top of the anonymous results (Phase 13b).
 *
 * A result on a board with 'lb' => true (tn_boards()) comes back from /result
 * with its row id and a signed claim. If the visitor presses "Add my score to
 * the leaderboard" and types a nickname, /claim checks the name (length,
 * characters, no links, bad-word list, names hidden by a moderator), the daily
 * limit (10 per client) and whether the score would enter the all-time top 3;
 * such scores are held for review, everything else shows straight away.
 *
 * The lb column of tn_results: 0 no name, 1 shown, 2 held for review,
 * 3 hidden by a moderator. Boards list the best entry per name (one spot per
 * name per board) for today, the last 7 days and all time, cached in
 * transients that are cleared on every claim and moderation action.
 *
 * Front end: tn_leaderboard_section() under the tool, tn_leaderboard_claim()
 * inside it, the /leaderboards/ page (content/pages/leaderboards.php) and
 * assets/js/leaderboard.js. Moderation: Tools > Testnook leaderboards.
 */

defined( 'ABSPATH' ) || exit;

const TN_LB_SIZE     = 10;  // entries per board
const TN_LB_PER_DAY  = 10;  // claims per client per day
const TN_LB_HOLD_TOP = 3;   // scores that would enter this all-time place are held
const TN_LB_SHOWN    = 1;
const TN_LB_HELD     = 2;
const TN_LB_HIDDEN   = 3;

/** Boards with a leaderboard. */
function tn_lb_boards() {
	return array_filter(
		tn_boards(),
		function ( $def ) {
			return ! empty( $def['lb'] );
		}
	);
}

function tn_lb_periods() {
	return array(
		'day'  => 'Today',
		'week' => 'This week',
		'all'  => 'All time',
	);
}

/** First date (UTC) a period covers. "This week" is the last 7 days, today included. */
function tn_lb_since( $period ) {
	if ( 'day' === $period ) {
		return gmdate( 'Y-m-d' );
	}
	if ( 'week' === $period ) {
		return gmdate( 'Y-m-d', time() - 6 * DAY_IN_SECONDS );
	}
	return '1970-01-01';
}

/** Label for the second number on a board's table, or ''. */
function tn_lb_extra_label( $board ) {
	return 0 === strpos( $board, 'typing-' ) || 0 === strpos( $board, 'aim-' ) ? 'Accuracy' : '';
}

/** Short board name for selects and tables. */
function tn_lb_board_label( $board ) {
	if ( preg_match( '/^cps-(\d+)$/', $board, $m ) ) {
		return $m[1] . ' second' . ( '1' === $m[1] ? '' : 's' );
	}
	if ( preg_match( '/^typing-(\d+)$/', $board, $m ) ) {
		return ( (int) $m[1] / 60 ) . ' minute' . ( 60 === (int) $m[1] ? '' : 's' );
	}
	if ( preg_match( '/^aim-(static|shrink)-(\d+)$/', $board, $m ) ) {
		return ( 'static' === $m[1] ? 'Static' : 'Shrinking' ) . ', ' . $m[2] . ' px';
	}
	return tn_boards()[ $board ]['name'];
}

function tn_claim_token( $id, $board ) {
	return substr( hash_hmac( 'sha256', 'claim|' . $id . '|' . $board, tn_ticket_secret() ), 0, 32 );
}

/* ---------- Nicknames ---------- */

/** Trims and collapses spaces. */
function tn_lb_clean_nick( $raw ) {
	return trim( preg_replace( '/\s+/', ' ', (string) $raw ) );
}

/**
 * Bad-word lists. 'part' words are refused anywhere in the name (after the
 * name is lower-cased, leetspeak mapped, separators removed and repeated
 * letters collapsed); 'word' entries only as a whole word or the whole name,
 * because they hide inside harmless words (class, grape, cocktail).
 * Moderators add more on the moderation screen (option tn_lb_words).
 */
function tn_lb_bad_words() {
	static $lists = null;
	if ( null !== $lists ) {
		return $lists;
	}
	$part  = array(
		// English profanity and sexual terms.
		'fuck', 'fuk', 'fck', 'shit', 'cunt', 'bitch', 'bastard', 'whore', 'slut', 'pussy', 'penis', 'vagina', 'boob', 'dildo',
		'porn', 'blowjob', 'handjob', 'orgasm', 'masturb', 'wank', 'jizz', 'horny', 'milf', 'hentai', 'nude', 'naked', 'rapist',
		'pedo', 'paedo', 'incest', 'asshole', 'arsehole', 'motherf', 'dickhead', 'cocksuck', 'retard', 'onlyfans',
		// Slurs and hate.
		'nigg', 'niga', 'faggot', 'tranny', 'chink', 'wetback', 'hitler', 'nazi', 'heilh', 'kkk', 'isis',
		// Urdu and Hindi (Roman script).
		'chutiy', 'chutia', 'bhench', 'behench', 'bhenchod', 'madarch', 'maderch', 'bhosd', 'gaand', 'gandu', 'randi', 'harami',
		'haramzad', 'kanjar', 'lauda', 'lavda', 'lund', 'chod', 'kamina', 'kutiya', 'kuttiy',
	);
	$word  = array(
		'ass', 'arse', 'tit', 'tits', 'dick', 'cock', 'cum', 'sex', 'sexy', 'xxx', 'anal', 'rape', 'hoe', 'fag', 'spic', 'kike', 'coon',
		'gook', 'paki', 'jew', 'gay', 'kys', 'die', 'kill', 'suck', 'nsfw', 'stfu', 'wtf', 'lmao',
		// Names we keep for ourselves.
		'admin', 'administrator', 'moderator', 'mod', 'testnook', 'official', 'staff', 'support', 'owner', 'system', 'null', 'undefined',
	);
	$extra = preg_split( '/[\s,]+/', strtolower( (string) get_option( 'tn_lb_words', '' ) ), -1, PREG_SPLIT_NO_EMPTY );
	$lists = array(
		'part' => array_unique( array_merge( array_map( 'tn_lb_squash', $part ), array_map( 'tn_lb_squash', $extra ) ) ),
		'word' => array_map( 'tn_lb_squash', $word ),
	);
	return $lists;
}

/** Lower case, leetspeak mapped to letters, only a-z0-9 left, repeated letters collapsed. */
function tn_lb_squash( $text ) {
	$text = strtr( strtolower( $text ), array( '0' => 'o', '1' => 'i', '3' => 'e', '4' => 'a', '5' => 's', '7' => 't', '8' => 'b', '@' => 'a', '$' => 's', '!' => 'i' ) );
	$text = preg_replace( '/[^a-z0-9]/', '', $text );
	return preg_replace( '/(.)\1+/', '$1', $text );
}

/** Lower-cased names a moderator hid with "Hide all from this name". */
function tn_lb_blocked_names() {
	return (array) get_option( 'tn_lb_blocked_names', array() );
}

/**
 * Checks a cleaned nickname.
 *
 * @return true|string true, or the reason it was refused.
 */
function tn_lb_check_nick( $nick ) {
	$len = strlen( $nick );
	if ( $len < 3 || $len > 16 ) {
		return 'nick_length';
	}
	if ( ! preg_match( '/^[A-Za-z0-9 _-]+$/', $nick ) || preg_match_all( '/[A-Za-z0-9]/', $nick ) < 2 ) {
		return 'nick_chars';
	}
	$lower = strtolower( $nick );
	if ( preg_match( '/https?|www|dotcom|dotnet|\b(com|net|org|xyz|io|gg)\b/', str_replace( array( '_', '-' ), ' ', $lower ) ) ) {
		return 'nick_link';
	}
	if ( in_array( $lower, tn_lb_blocked_names(), true ) ) {
		return 'nick_blocked';
	}
	$lists  = tn_lb_bad_words();
	$whole  = tn_lb_squash( $nick );
	$tokens = array_map( 'tn_lb_squash', preg_split( '/[\s_-]+|(?<=[a-z])(?=[A-Z])/', $nick, -1, PREG_SPLIT_NO_EMPTY ) );
	foreach ( $lists['part'] as $bad ) {
		if ( '' !== $bad && false !== strpos( $whole, $bad ) ) {
			return 'nick_blocked';
		}
	}
	foreach ( $lists['word'] as $bad ) {
		if ( $whole === $bad || in_array( $bad, $tokens, true ) ) {
			return 'nick_blocked';
		}
	}
	return true;
}

/* ---------- Boards ---------- */

/** SQL ORDER BY for a board: best first, then higher accuracy, then the earlier entry. */
function tn_lb_order( $def ) {
	return ( $def['higher'] ? 'value DESC' : 'value ASC' ) . ', extra DESC, id ASC';
}

/** True when score a (value, extra) beats score b on this board. */
function tn_lb_beats( $def, $a_value, $a_extra, $b_value, $b_extra ) {
	$a_value = (float) $a_value;
	$b_value = (float) $b_value;
	if ( $a_value !== $b_value ) {
		return $def['higher'] ? $a_value > $b_value : $a_value < $b_value;
	}
	return (int) $a_extra > (int) $b_extra;
}

/**
 * Top entries of a board for a period, best entry per name.
 *
 * @return array[] rank, nick, value, extra, date.
 */
function tn_lb_query( $board, $period, $size = TN_LB_SIZE ) {
	global $wpdb;
	$def   = tn_boards()[ $board ];
	$table = tn_results_table();
	$order = tn_lb_order( $def );
	$rows  = $wpdb->get_results( $wpdb->prepare( "SELECT id, nick, value, extra, created FROM $table WHERE board = %s AND lb = %d AND created >= %s AND nick IS NOT NULL ORDER BY $order LIMIT 400", $board, TN_LB_SHOWN, tn_lb_since( $period ) ), ARRAY_A ); // phpcs:ignore
	$seen  = array();
	$out   = array();
	foreach ( $rows as $r ) {
		$name = strtolower( $r['nick'] );
		if ( isset( $seen[ $name ] ) ) {
			continue;
		}
		$seen[ $name ] = true;
		$out[]         = array(
			'rank'  => count( $out ) + 1,
			'nick'  => $r['nick'],
			'value' => (float) $r['value'],
			'extra' => (int) $r['extra'],
			'date'  => $r['created'],
		);
		if ( count( $out ) >= $size ) {
			break;
		}
	}
	return $out;
}

function tn_lb_cache_key( $board, $period ) {
	return 'tn_lb_' . $board . '_' . $period . ( 'all' === $period ? '' : '_' . gmdate( 'md' ) );
}

/** Cached board (10 minutes; cleared on claims and moderation). */
function tn_lb_get( $board, $period ) {
	$key  = tn_lb_cache_key( $board, $period );
	$rows = get_transient( $key );
	if ( false === $rows ) {
		$rows = tn_lb_query( $board, $period );
		set_transient( $key, $rows, 10 * MINUTE_IN_SECONDS );
	}
	return $rows;
}

function tn_lb_flush( $board ) {
	foreach ( array_keys( tn_lb_periods() ) as $period ) {
		delete_transient( tn_lb_cache_key( $board, $period ) );
	}
}

/** Place a score would take in a period: 1 + other names with a better entry. */
function tn_lb_rank( $board, $period, $value, $extra, $nick ) {
	global $wpdb;
	$def   = tn_boards()[ $board ];
	$table = tn_results_table();
	$cmp   = $def['higher'] ? '>' : '<';
	$n     = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT LOWER(nick)) FROM $table WHERE board = %s AND lb = %d AND created >= %s AND nick IS NOT NULL AND LOWER(nick) <> %s AND ( value $cmp %f OR ( value = %f AND extra > %d ) )", $board, TN_LB_SHOWN, tn_lb_since( $period ), strtolower( $nick ), $value, $value, $extra ) ); // phpcs:ignore
	return $n + 1;
}

/**
 * Scores that would take an all-time top-3 place (once a board has 3 names),
 * or that are beyond the best 1% of all results, wait for a moderator.
 */
function tn_lb_needs_review( $board, $value, $extra ) {
	$def = tn_boards()[ $board ];
	$top = tn_lb_query( $board, 'all', TN_LB_HOLD_TOP );
	if ( count( $top ) >= TN_LB_HOLD_TOP && tn_lb_beats( $def, $value, $extra, $top[ TN_LB_HOLD_TOP - 1 ]['value'], $top[ TN_LB_HOLD_TOP - 1 ]['extra'] ) ) {
		return true;
	}
	$stats = tn_stats_get( $board );
	if ( $stats && isset( $stats['p99'] ) ) {
		return $def['higher'] ? $value > $stats['p99'] : $value < $stats['p1'];
	}
	return false;
}

/* ---------- REST ---------- */

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'testnook/v1',
			'/claim',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true',
				'callback'            => 'tn_rest_claim',
				'args'                => array(
					'id'    => array( 'required' => true, 'type' => 'integer' ),
					'claim' => array( 'required' => true, 'type' => 'string' ),
					'nick'  => array( 'required' => true, 'type' => 'string' ),
				),
			)
		);
		register_rest_route(
			'testnook/v1',
			'/board',
			array(
				'methods'             => 'GET',
				'permission_callback' => '__return_true',
				'callback'            => 'tn_rest_board',
				'args'                => array(
					'board'  => array( 'required' => true, 'type' => 'string' ),
					'period' => array( 'type' => 'string', 'default' => 'all' ),
				),
			)
		);
	}
);

function tn_rest_claim( WP_REST_Request $req ) {
	global $wpdb;
	$table = tn_results_table();
	$id    = (int) $req['id'];
	$row   = $id ? $wpdb->get_row( $wpdb->prepare( "SELECT id, board, value, extra, nick, status, lb, created FROM $table WHERE id = %d", $id ), ARRAY_A ) : null; // phpcs:ignore
	if ( ! $row || ! hash_equals( tn_claim_token( $id, $row['board'] ), (string) $req['claim'] ) ) {
		return tn_rest_error( 'bad_claim', 403 );
	}
	$boards = tn_lb_boards();
	if ( ! isset( $boards[ $row['board'] ] ) || 'ok' !== $row['status'] ) {
		return tn_rest_error( 'not_allowed', 403 );
	}
	if ( null !== $row['nick'] ) {
		return array( 'ok' => false, 'code' => 'already_claimed' );
	}
	if ( $row['created'] < gmdate( 'Y-m-d', time() - DAY_IN_SECONDS ) ) {
		return array( 'ok' => false, 'code' => 'expired' );
	}
	$nick  = tn_lb_clean_nick( $req['nick'] );
	$check = tn_lb_check_nick( $nick );
	if ( true !== $check ) {
		return array( 'ok' => false, 'code' => $check );
	}
	if ( tn_rate_limited( 'claim', TN_LB_PER_DAY, DAY_IN_SECONDS ) ) {
		return array( 'ok' => false, 'code' => 'daily_limit' );
	}

	$board = $row['board'];
	$value = (float) $row['value'];
	$extra = (int) $row['extra'];
	$held  = tn_lb_needs_review( $board, $value, $extra );
	$wpdb->update( $table, array( 'nick' => $nick, 'lb' => $held ? TN_LB_HELD : TN_LB_SHOWN ), array( 'id' => $id ), array( '%s', '%d' ), array( '%d' ) ); // phpcs:ignore
	tn_lb_flush( $board );
	if ( $held ) {
		delete_transient( 'tn_lb_held_count' );
	}

	$out = array( 'ok' => true, 'held' => $held, 'nick' => $nick, 'board' => $board );
	if ( ! $held ) {
		$out['ranks'] = array();
		foreach ( array_keys( tn_lb_periods() ) as $period ) {
			$out['ranks'][ $period ] = tn_lb_rank( $board, $period, $value, $extra, $nick );
		}
	}
	$res = new WP_REST_Response( $out );
	$res->header( 'Cache-Control', 'no-store' );
	return $res;
}

function tn_rest_board( WP_REST_Request $req ) {
	$board  = sanitize_key( $req['board'] );
	$period = sanitize_key( $req['period'] );
	if ( ! isset( tn_lb_boards()[ $board ] ) ) {
		return tn_rest_error( 'unknown_board', 400 );
	}
	if ( ! isset( tn_lb_periods()[ $period ] ) ) {
		return tn_rest_error( 'unknown_period', 400 );
	}
	$res = new WP_REST_Response( array( 'board' => $board, 'period' => $period, 'rows' => tn_lb_get( $board, $period ) ) );
	$res->header( 'Cache-Control', 'public, max-age=60' );
	return $res;
}

/* ---------- Front end ---------- */

/**
 * Leaderboards for a tool page: the lb boards in its 'stats' list, then the
 * other lengths or modes of the same test (a 5 second CPS page can show the
 * 10 second board too), so every score the tool can send has a board here.
 */
function tn_lb_boards_for( $def ) {
	if ( empty( $def['stats'] ) ) {
		return array();
	}
	$lb   = tn_lb_boards();
	$list = array();
	foreach ( (array) $def['stats'] as $board ) {
		if ( isset( $lb[ $board ] ) ) {
			$list[] = $board;
		}
	}
	foreach ( $list as $board ) {
		$family = strtok( $board, '-' ) . '-';
		foreach ( array_keys( $lb ) as $other ) {
			if ( 0 === strpos( $other, $family ) && ! in_array( $other, $list, true ) ) {
				$list[] = $other;
			}
		}
	}
	return $list;
}

/** True when a page prints leaderboards (tool pages with lb boards, the /leaderboards/ page). */
function tn_lb_page_has_boards( $def ) {
	if ( tn_is_embed() ) {
		return false;
	}
	return ( 'page' === $def['type'] && 'leaderboards' === $def['slug'] ) || ( 'tool' === $def['type'] && tn_lb_boards_for( $def ) );
}

/** Board settings the script needs to print values. */
function tn_lb_board_meta( $boards ) {
	$all  = tn_boards();
	$meta = array();
	foreach ( $boards as $board ) {
		$meta[ $board ] = array(
			'label'  => tn_lb_board_label( $board ),
			'unit'   => $all[ $board ]['unit'],
			'dp'     => $all[ $board ]['dp'],
			'extra'  => tn_lb_extra_label( $board ),
		);
	}
	return $meta;
}

/** Table rows for a board (printed from the cache; the script replaces them when the tab changes). */
function tn_lb_rows_html( $board, $rows ) {
	$def   = tn_boards()[ $board ];
	$extra = tn_lb_extra_label( $board );
	$html  = '';
	foreach ( $rows as $r ) {
		$html .= '<tr><td class="lb__rank">' . (int) $r['rank'] . '</td><td class="lb__name">' . esc_html( $r['nick'] ) . '</td>'
			. '<td class="lb__score">' . esc_html( tn_fmt_value( $r['value'], $def ) ) . '</td>'
			. ( $extra ? '<td class="lb__extra">' . (int) $r['extra'] . '%</td>' : '' )
			. '<td class="lb__date">' . esc_html( mysql2date( 'j M Y', $r['date'] ) ) . '</td></tr>';
	}
	return $html;
}

/**
 * One leaderboard widget: board select (when there are several), Today /
 * This week / All time tabs and the top 10. Printed with the all-time board.
 */
function tn_leaderboard_widget( $boards, $heading, $id, $intro = '' ) {
	// The first board is the one shown first; the select lists them all in their natural order (1, 5, 10 s ...).
	$board = $boards[0];
	$order = array_keys( tn_lb_boards() );
	usort(
		$boards,
		function ( $a, $b ) use ( $order ) {
			return (int) array_search( $a, $order, true ) - (int) array_search( $b, $order, true );
		}
	);
	$rows  = tn_lb_get( $board, 'all' );
	$extra = tn_lb_extra_label( $board );
	echo '<section class="lb" id="' . esc_attr( $id ) . '" data-tn-lb data-board="' . esc_attr( $board ) . '" data-period="all" data-meta="' . esc_attr( wp_json_encode( tn_lb_board_meta( $boards ) ) ) . '" aria-labelledby="' . esc_attr( $id ) . '-title">';
	echo '<div class="lb__head"><h2 id="' . esc_attr( $id ) . '-title">' . esc_html( $heading ) . '</h2>';
	if ( count( $boards ) > 1 ) {
		echo '<label class="lb__pick"><span class="visually-hidden">Board</span><select data-tn-lb-board>';
		foreach ( $boards as $b ) {
			echo '<option value="' . esc_attr( $b ) . '"' . selected( $b, $board, false ) . '>' . esc_html( tn_lb_board_label( $b ) ) . '</option>';
		}
		echo '</select></label>';
	}
	echo '</div>';
	if ( $intro ) {
		tn_html( $intro );
	}
	echo '<div class="lb__tabs" role="tablist" aria-label="Period">';
	foreach ( tn_lb_periods() as $period => $label ) {
		echo '<button type="button" role="tab" data-tn-lb-period="' . esc_attr( $period ) . '" aria-selected="' . ( 'all' === $period ? 'true' : 'false' ) . '">' . esc_html( $label ) . '</button>';
	}
	echo '</div>';
	echo '<div class="lb__wrap"><table class="lb__table"><thead><tr><th scope="col">#</th><th scope="col">Name</th><th scope="col">Score</th><th scope="col" data-tn-lb-extra' . ( $extra ? '' : ' hidden' ) . '>' . esc_html( $extra ? $extra : 'Accuracy' ) . '</th><th scope="col">Date</th></tr></thead>';
	echo '<tbody data-tn-lb-rows>' . tn_lb_rows_html( $board, $rows ) . '</tbody></table></div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in tn_lb_rows_html
	echo '<p class="lb__empty" data-tn-lb-empty' . ( $rows ? ' hidden' : '' ) . '>No scores yet. Be the first: finish a test and press <strong>Add my score to the leaderboard</strong>.</p>';
	echo '</section>';
}

/** The leaderboard section under the tool on pages with leaderboard boards. */
function tn_leaderboard_section( $def ) {
	$boards = tn_lb_boards_for( $def );
	if ( ! $boards ) {
		return;
	}
	tn_leaderboard_widget( $boards, 'Leaderboard: top 10', 'leaderboard' );
	echo '<p class="lb__foot">Nicknames are optional and public. Scores pass the same checks as the site stats, and the best score per name is shown. <a href="' . esc_url( home_url( '/leaderboards/' ) ) . '">All leaderboards and rules</a>.</p>';
}

/** The "Add my score" button and nickname form, shown by the script after a result that can be claimed. */
function tn_leaderboard_claim( $def ) {
	if ( ! tn_lb_boards_for( $def ) ) {
		return;
	}
	?>
	<div class="lb-claim" data-tn-lb-claim hidden>
		<button type="button" class="btn btn-sm" data-tn-lb-open>Add my score to the leaderboard</button>
		<form class="lb-claim__form" data-tn-lb-form hidden>
			<label for="lb-nick">Nickname</label>
			<div class="lb-claim__row">
				<input id="lb-nick" name="nick" type="text" minlength="3" maxlength="16" pattern="[A-Za-z0-9 _\-]{3,16}" autocomplete="nickname" autocapitalize="off" spellcheck="false" required>
				<button class="btn btn-sm" type="submit">Add</button>
			</div>
			<p class="lb-claim__hint">Your nickname will be public. Do not use your real name. 3 to 16 letters, digits, spaces, dashes or underscores.</p>
		</form>
		<p class="lb-claim__msg" data-tn-lb-msg aria-live="polite" hidden></p>
	</div>
	<?php
}

/** The boards on the /leaderboards/ page, one widget per test. */
function tn_leaderboards_hub() {
	$groups = array(
		'cps'      => array( 'Click speed (CPS)', 'cps-test', 'Clicks per second with the left mouse button. Pick the test length.' ),
		'reaction' => array( 'Reaction time', 'reaction-time-test', 'Average of five tries in milliseconds. Lower is better.' ),
		'typing'   => array( 'Typing speed', 'typing-test-english', 'Words per minute with at least 85% accuracy. Ties go to the higher accuracy.' ),
		'aim'      => array( 'Mouse accuracy', 'mouse-accuracy-test', 'Points from the aim trainer, by mode and target size.' ),
	);
	$lb     = array_keys( tn_lb_boards() );
	foreach ( $groups as $family => $g ) {
		$boards = array_values(
			array_filter(
				$lb,
				function ( $b ) use ( $family ) {
					return $b === $family || 0 === strpos( $b, $family . '-' );
				}
			)
		);
		if ( 'cps' === $family ) {
			// The 5 second test is the most played; start there.
			$boards = array_values( array_unique( array_merge( array( 'cps-5' ), $boards ) ) );
		}
		if ( 'aim' === $family ) {
			$boards = array_values( array_unique( array_merge( array( 'aim-static-28' ), $boards ) ) );
		}
		if ( ! $boards ) {
			continue;
		}
		$link = tn_tool_is_live( $g[1] ) ? ' <a href="' . esc_url( tn_tool_url( $g[1] ) ) . '">Take the test</a>.' : '';
		tn_leaderboard_widget( $boards, $g[0], 'lb-' . $family, '<p class="lb__intro">' . esc_html( $g[2] ) . $link . '</p>' );
	}
}

/* ---------- Admin: Tools > Testnook leaderboards ---------- */

function tn_lb_held_count() {
	global $wpdb;
	$n = get_transient( 'tn_lb_held_count' );
	if ( false === $n ) {
		$table = tn_results_table();
		$n     = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE lb = %d", TN_LB_HELD ) ); // phpcs:ignore
		set_transient( 'tn_lb_held_count', $n, HOUR_IN_SECONDS );
	}
	return (int) $n;
}

add_action(
	'admin_menu',
	function () {
		$held  = tn_lb_held_count();
		$title = 'Testnook leaderboards' . ( $held ? ' <span class="awaiting-mod">' . $held . '</span>' : '' );
		add_management_page( 'Testnook leaderboards', $title, 'manage_options', 'tn-leaderboards', 'tn_admin_lb_page' );
	}
);

/** Applies one moderation action from the admin form. Returns a notice. */
function tn_admin_lb_action() {
	global $wpdb;
	if ( empty( $_POST['tn_lb_do'] ) || ! check_admin_referer( 'tn_lb_mod' ) || ! current_user_can( 'manage_options' ) ) {
		return '';
	}
	$table = tn_results_table();
	$do    = sanitize_key( wp_unslash( $_POST['tn_lb_do'] ) );
	$id    = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
	$name  = isset( $_POST['name'] ) ? strtolower( tn_lb_clean_nick( sanitize_text_field( wp_unslash( $_POST['name'] ) ) ) ) : '';
	$row   = $id ? $wpdb->get_row( $wpdb->prepare( "SELECT id, board, nick FROM $table WHERE id = %d", $id ), ARRAY_A ) : null; // phpcs:ignore
	$msg   = '';

	if ( in_array( $do, array( 'show', 'hide', 'clear' ), true ) && $row ) {
		if ( 'clear' === $do ) {
			// Removal request: forget the name, keep the anonymous score for the stats.
			$wpdb->update( $table, array( 'nick' => null, 'lb' => 0 ), array( 'id' => $id ), array( '%s', '%d' ), array( '%d' ) ); // phpcs:ignore
			$msg = 'Name removed from the entry.';
		} else {
			$wpdb->update( $table, array( 'lb' => 'show' === $do ? TN_LB_SHOWN : TN_LB_HIDDEN ), array( 'id' => $id ), array( '%d' ), array( '%d' ) ); // phpcs:ignore
			$msg = 'show' === $do ? 'Entry shown.' : 'Entry hidden.';
		}
		tn_lb_flush( $row['board'] );
	} elseif ( 'hide_name' === $do && $name ) {
		$n = $wpdb->query( $wpdb->prepare( "UPDATE $table SET lb = %d WHERE LOWER(nick) = %s AND lb IN (%d, %d)", TN_LB_HIDDEN, $name, TN_LB_SHOWN, TN_LB_HELD ) ); // phpcs:ignore
		$blocked = tn_lb_blocked_names();
		if ( ! in_array( $name, $blocked, true ) ) {
			$blocked[] = $name;
			update_option( 'tn_lb_blocked_names', $blocked, false );
		}
		foreach ( array_keys( tn_lb_boards() ) as $board ) {
			tn_lb_flush( $board );
		}
		$msg = sprintf( 'Hid %d entries from "%s" and blocked the name.', (int) $n, $name );
	} elseif ( 'unblock' === $do && $name ) {
		update_option( 'tn_lb_blocked_names', array_values( array_diff( tn_lb_blocked_names(), array( $name ) ) ), false );
		$msg = sprintf( '"%s" can be used again. Its hidden entries stay hidden; use Show to bring one back.', $name );
	} elseif ( 'words' === $do ) {
		$words = isset( $_POST['words'] ) ? sanitize_textarea_field( wp_unslash( $_POST['words'] ) ) : '';
		update_option( 'tn_lb_words', strtolower( $words ), false );
		$msg = 'Blocked words saved. They apply to new names only.';
	}
	delete_transient( 'tn_lb_held_count' );
	return $msg;
}

/** A small inline form with one moderation button. */
function tn_admin_lb_button( $do, $label, $id = 0, $name = '', $class = 'button-small' ) {
	return '<form method="post" style="display:inline">' . wp_nonce_field( 'tn_lb_mod', '_wpnonce', true, false )
		. '<input type="hidden" name="tn_lb_do" value="' . esc_attr( $do ) . '">'
		. ( $id ? '<input type="hidden" name="id" value="' . (int) $id . '">' : '' )
		. ( '' !== $name ? '<input type="hidden" name="name" value="' . esc_attr( $name ) . '">' : '' )
		. '<button class="button ' . esc_attr( $class ) . '">' . esc_html( $label ) . '</button></form> ';
}

function tn_admin_lb_rows( $rows ) {
	$all   = tn_boards();
	$state = array( TN_LB_SHOWN => 'Shown', TN_LB_HELD => 'Waiting', TN_LB_HIDDEN => 'Hidden' );
	echo '<table class="widefat striped" style="max-width:980px"><thead><tr><th>Name</th><th>Board</th><th>Score</th><th>Date</th><th>State</th><th>Actions</th></tr></thead><tbody>';
	foreach ( $rows as $r ) {
		$def     = $all[ $r['board'] ];
		$extra   = tn_lb_extra_label( $r['board'] );
		$actions = ( TN_LB_SHOWN !== (int) $r['lb'] ? tn_admin_lb_button( 'show', TN_LB_HELD === (int) $r['lb'] ? 'Approve' : 'Show', $r['id'], '', 'button-small button-primary' ) : '' )
			. ( TN_LB_HIDDEN !== (int) $r['lb'] ? tn_admin_lb_button( 'hide', 'Hide', $r['id'] ) : '' )
			. tn_admin_lb_button( 'hide_name', 'Hide all from this name', 0, strtolower( $r['nick'] ) )
			. tn_admin_lb_button( 'clear', 'Remove name', $r['id'] );
		echo '<tr><td><strong>' . esc_html( $r['nick'] ) . '</strong></td><td>' . esc_html( $r['board'] ) . '</td><td>' . esc_html( tn_fmt_value( $r['value'], $def ) . ( $extra ? ', ' . (int) $r['extra'] . '%' : '' ) ) . '</td><td>' . esc_html( $r['created'] ) . '</td><td>' . esc_html( isset( $state[ (int) $r['lb'] ] ) ? $state[ (int) $r['lb'] ] : '-' ) . '</td><td>' . $actions . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput -- buttons built from escaped parts
	}
	echo '</tbody></table>';
}

function tn_admin_lb_page() {
	global $wpdb;
	$msg = tn_admin_lb_action();
	if ( $msg ) {
		echo '<div class="notice notice-success"><p>' . esc_html( $msg ) . '</p></div>';
	}
	$table  = tn_results_table();
	$boards = tn_lb_boards();
	$board  = isset( $_GET['board'] ) && isset( $boards[ sanitize_key( wp_unslash( $_GET['board'] ) ) ] ) ? sanitize_key( wp_unslash( $_GET['board'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$search = isset( $_GET['name'] ) ? strtolower( tn_lb_clean_nick( sanitize_text_field( wp_unslash( $_GET['name'] ) ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$cols   = 'id, board, nick, value, extra, lb, created';

	echo '<div class="wrap"><h1>Testnook leaderboards</h1>';
	echo '<p>Names show straight away. A score that would take an all-time top ' . (int) TN_LB_HOLD_TOP . ' place, or that beats 99% of all results, waits here until you approve it. <strong>Hide all from this name</strong> hides every entry with that name and stops it being used again. <strong>Remove name</strong> is for removal requests: the name is deleted and only the anonymous score stays.</p>';

	$held = $wpdb->get_results( $wpdb->prepare( "SELECT $cols FROM $table WHERE lb = %d ORDER BY id DESC LIMIT 100", TN_LB_HELD ), ARRAY_A ); // phpcs:ignore
	echo '<h2>Waiting for review (' . count( $held ) . ')</h2>';
	if ( $held ) {
		tn_admin_lb_rows( $held );
	} else {
		echo '<p>Nothing to review.</p>';
	}

	echo '<h2>Named entries</h2>';
	echo '<form method="get"><input type="hidden" name="page" value="tn-leaderboards"><select name="board"><option value="">Newest on all boards</option>';
	foreach ( array_keys( $boards ) as $b ) {
		echo '<option value="' . esc_attr( $b ) . '"' . selected( $board, $b, false ) . '>Top 50: ' . esc_html( $b ) . '</option>';
	}
	echo '</select> <input type="search" name="name" value="' . esc_attr( $search ) . '" placeholder="Name"> <button class="button">Filter</button></form><br>';
	$where = 'nick IS NOT NULL';
	$args  = array();
	if ( $board ) {
		$where .= ' AND board = %s';
		$args[] = $board;
	}
	if ( '' !== $search ) {
		$where .= ' AND LOWER(nick) LIKE %s';
		$args[] = '%' . $wpdb->esc_like( $search ) . '%';
	}
	$order = $board ? tn_lb_order( $boards[ $board ] ) : 'id DESC';
	$sql   = "SELECT $cols FROM $table WHERE $where ORDER BY $order LIMIT 50";
	$rows  = $wpdb->get_results( $args ? $wpdb->prepare( $sql, $args ) : $sql, ARRAY_A ); // phpcs:ignore
	if ( $rows ) {
		tn_admin_lb_rows( $rows );
	} else {
		echo '<p>No named entries' . ( $board || $search ? ' match this filter' : ' yet' ) . '.</p>';
	}

	echo '<h2>Blocked names</h2>';
	$blocked = tn_lb_blocked_names();
	if ( $blocked ) {
		echo '<ul>';
		foreach ( $blocked as $name ) {
			echo '<li>' . esc_html( $name ) . ' ' . tn_admin_lb_button( 'unblock', 'Unblock', 0, $name ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</ul>';
	} else {
		echo '<p>None.</p>';
	}

	echo '<h2>Extra blocked words</h2><p>Names containing any of these (separated by spaces or commas) are refused, on top of the built-in list. Letters like 0/o, 1/i, 3/e and repeated letters are matched too.</p>';
	echo '<form method="post">' . wp_nonce_field( 'tn_lb_mod', '_wpnonce', true, false ) . '<input type="hidden" name="tn_lb_do" value="words"><textarea name="words" rows="4" cols="70">' . esc_textarea( (string) get_option( 'tn_lb_words', '' ) ) . '</textarea><p><button class="button">Save words</button></p></form>'; // phpcs:ignore WordPress.Security.EscapeOutput
	echo '</div>';
}
