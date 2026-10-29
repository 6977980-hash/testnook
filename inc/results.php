<?php
/**
 * Anonymous test results: storage, REST endpoints, hourly stats and embed counts.
 *
 * Phase 13a (design approved 29 Oct 2026). What is stored per result: board
 * (tool + variant), the score, one extra number (typing accuracy, dead pixel
 * type), status and the date. No IP, no time of day, no user agent, no text.
 *
 * Flow: a tool script asks /start for a signed ticket when the test begins,
 * then posts the score with the ticket to /result when it ends. The server
 * checks the signature, that enough time passed for the test length, that the
 * ticket was not used before, the rate limit (hashed IP, one hour) and the
 * plausibility limits in tn_boards(). Stats are computed hourly by WP-cron
 * and cached in transients; /stats and the printed stats block read the cache.
 *
 * Tables (dbDelta, created when TN_RESULTS_DB_VERSION changes):
 *   {prefix}tn_results     one row per result
 *   {prefix}tn_embed_hits  embed loads per site domain, tool and day
 */

defined( 'ABSPATH' ) || exit;

const TN_RESULTS_DB_VERSION = '2';   // 2: lb column for leaderboards (Phase 13b)
const TN_RESULTS_WINDOW_DAYS = 30;   // stats cover the last 30 days
const TN_RESULTS_KEEP_DAYS   = 400;  // older rows are summarised and deleted
const TN_RESULTS_MIN_COUNT   = 20;   // boards with fewer results show no stats
const TN_RESULTS_PER_HOUR    = 60;   // results per client per hour

function tn_results_table() {
	global $wpdb;
	return $wpdb->prefix . 'tn_results';
}

function tn_embed_hits_table() {
	global $wpdb;
	return $wpdb->prefix . 'tn_embed_hits';
}

/**
 * Boards: the score lists a tool can post to.
 *
 * min_s    the shortest time between the ticket and the result
 * min/max  plausibility limits for the score (outside: rejected)
 * higher   true when a bigger score is better
 * unit, dp label and decimals for the printed stats
 * extra    limits for the second number, or null
 * lb       true when the board has a public leaderboard (inc/leaderboards.php)
 */
function tn_boards() {
	static $boards = null;
	if ( null !== $boards ) {
		return $boards;
	}
	$boards = array();
	foreach ( array( 1, 5, 10, 15, 30, 60, 100 ) as $s ) {
		$boards[ 'cps-' . $s ] = array(
			'name'   => $s . ' second click test',
			'min_s'  => $s,
			'min'    => 0.5,
			'max'    => 1 === $s ? 25 : 20,
			'higher' => true,
			'unit'   => 'CPS',
			'dp'     => 1,
			'extra'  => null,
			'lb'     => true,
		);
	}
	$boards['reaction'] = array(
		'name'   => 'Reaction time (average of 5)',
		'min_s'  => 7,
		'min'    => 120,
		'max'    => 1500,
		'higher' => false,
		'unit'   => 'ms',
		'dp'     => 0,
		'extra'  => null,
		'lb'     => true,
	);
	foreach ( array( 15, 30, 60, 120, 300 ) as $s ) {
		$boards[ 'typing-' . $s ] = array(
			'name'   => 'Typing test, ' . ( $s >= 60 ? ( $s / 60 ) . ' min' : $s . ' s' ),
			'min_s'  => $s,
			'min'    => 5,
			'max'    => 220,
			'higher' => true,
			'unit'   => 'WPM',
			'dp'     => 0,
			'extra'  => array( 85, 100 ), // accuracy %
			'lb'     => in_array( $s, array( 60, 300 ), true ),
		);
	}
	foreach ( array( 'static', 'shrink' ) as $mode ) {
		foreach ( array( 16, 28, 40 ) as $size ) {
			$boards[ 'aim-' . $mode . '-' . $size ] = array(
				'name'   => 'Mouse accuracy, ' . $mode . ' ' . $size . ' px',
				'min_s'  => 5,
				'min'    => 1,
				'max'    => 8000,
				'higher' => true,
				'unit'   => 'points',
				'dp'     => 0,
				'extra'  => array( 0, 100 ), // accuracy %
				'lb'     => true,
			);
		}
	}
	$boards['deadpixel'] = array(
		'name'   => 'Dead pixel test',
		'min_s'  => 0,
		'min'    => 0,
		'max'    => 99,       // 10 x 10 grid cell (row * 10 + column)
		'higher' => true,
		'unit'   => '',
		'dp'     => 0,
		'extra'  => array( 0, 2 ), // 0 none found, 1 dead (black), 2 stuck (coloured)
		'map'    => true,     // stats are a heat map, not a distribution
	);
	return $boards;
}

/* ---------- Tables ---------- */

function tn_results_install() {
	if ( get_option( 'tn_results_db_version' ) === TN_RESULTS_DB_VERSION ) {
		return;
	}
	global $wpdb;
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$charset = $wpdb->get_charset_collate();
	$results = tn_results_table();
	$embeds  = tn_embed_hits_table();
	dbDelta(
		"CREATE TABLE $results (
	id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	board varchar(32) NOT NULL,
	value decimal(10,2) NOT NULL,
	extra smallint(5) unsigned NOT NULL DEFAULT 0,
	nick varchar(16) DEFAULT NULL,
	status varchar(8) NOT NULL DEFAULT 'ok',
	lb tinyint(3) unsigned NOT NULL DEFAULT 0,
	created date NOT NULL,
	PRIMARY KEY  (id),
	KEY board_status_created (board,status,created),
	KEY board_lb_created (board,lb,created)
) $charset;"
	);
	dbDelta(
		"CREATE TABLE $embeds (
	id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	domain varchar(100) NOT NULL,
	slug varchar(64) NOT NULL,
	day date NOT NULL,
	hits int(10) unsigned NOT NULL DEFAULT 1,
	PRIMARY KEY  (id),
	KEY domain_slug_day (domain,slug,day)
) $charset;"
	);
	update_option( 'tn_results_db_version', TN_RESULTS_DB_VERSION, true );
}
add_action( 'init', 'tn_results_install', 5 );
add_action( 'after_switch_theme', function () { delete_option( 'tn_results_db_version' ); } );

/* ---------- Cron ---------- */

add_action(
	'init',
	function () {
		if ( ! wp_next_scheduled( 'tn_results_refresh' ) ) {
			wp_schedule_event( time() + 300, 'hourly', 'tn_results_refresh' );
		}
		if ( ! wp_next_scheduled( 'tn_results_prune' ) ) {
			wp_schedule_event( time() + 3600, 'daily', 'tn_results_prune' );
		}
	},
	30
);
add_action( 'tn_results_refresh', 'tn_stats_refresh_all' );
add_action( 'tn_results_prune', 'tn_results_prune' );

/* ---------- Tickets, client keys, rate limits ---------- */

function tn_ticket_secret() {
	return wp_salt( 'nonce' ) . '|tn-ticket';
}

/** A signed, single-use ticket for one board: "<base64 payload>.<hmac>". */
function tn_ticket_issue( $board ) {
	$payload = $board . '|' . time() . '|' . wp_generate_password( 12, false );
	$b64     = rtrim( strtr( base64_encode( $payload ), '+/', '-_' ), '=' );
	return $b64 . '.' . substr( hash_hmac( 'sha256', $payload, tn_ticket_secret() ), 0, 32 );
}

/**
 * Checks a ticket for a board and marks it used.
 *
 * @return true|string true, or the reason it was refused.
 */
function tn_ticket_consume( $ticket, $board ) {
	$parts = explode( '.', (string) $ticket, 2 );
	if ( 2 !== count( $parts ) ) {
		return 'bad_ticket';
	}
	$payload = base64_decode( strtr( $parts[0], '-_', '+/' ), true );
	if ( ! $payload || ! hash_equals( substr( hash_hmac( 'sha256', $payload, tn_ticket_secret() ), 0, 32 ), $parts[1] ) ) {
		return 'bad_ticket';
	}
	list( $t_board, $issued ) = array_pad( explode( '|', $payload, 3 ), 3, '' );
	$issued = (int) $issued;
	if ( $t_board !== $board || $issued < time() - 2 * HOUR_IN_SECONDS || $issued > time() + 60 ) {
		return 'stale_ticket';
	}
	$boards = tn_boards();
	if ( time() - $issued < $boards[ $board ]['min_s'] - 1 ) { // whole seconds: a 1 s test can end in the same second it started
		return 'too_fast';
	}
	$used_key = 'tn_tk_' . substr( $parts[1], 0, 24 );
	if ( get_transient( $used_key ) ) {
		return 'used_ticket';
	}
	set_transient( $used_key, 1, 2 * HOUR_IN_SECONDS );
	return true;
}

/** Hash of the visitor's IP that changes every day; never stored past the hour. */
function tn_client_key() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	return substr( hash( 'sha256', $ip . '|' . wp_salt( 'auth' ) . '|' . gmdate( 'Y-m-d' ) ), 0, 16 );
}

/**
 * Counts a request against a limit per client; true when the limit is exceeded.
 * $ttl is the window (one hour by default; the client key itself changes daily).
 * $peek only checks, without counting.
 */
function tn_rate_limited( $bucket, $limit, $ttl = HOUR_IN_SECONDS, $peek = false ) {
	$key = 'tn_rl_' . $bucket . '_' . tn_client_key();
	$n   = (int) get_transient( $key );
	if ( $n >= $limit ) {
		return true;
	}
	if ( ! $peek ) {
		set_transient( $key, $n + 1, $ttl );
	}
	return false;
}

/* ---------- REST ---------- */

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'testnook/v1',
			'/start',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true',
				'callback'            => 'tn_rest_start',
				'args'                => array( 'board' => array( 'required' => true, 'type' => 'string' ) ),
			)
		);
		register_rest_route(
			'testnook/v1',
			'/result',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true',
				'callback'            => 'tn_rest_result',
				'args'                => array(
					'board'  => array( 'required' => true, 'type' => 'string' ),
					'ticket' => array( 'required' => true, 'type' => 'string' ),
					'value'  => array( 'required' => true, 'type' => 'number' ),
					'extra'  => array( 'type' => 'integer', 'default' => 0 ),
					'cv'     => array( 'type' => 'number', 'default' => -1 ), // spread of click gaps, % (CPS only)
				),
			)
		);
		register_rest_route(
			'testnook/v1',
			'/stats',
			array(
				'methods'             => 'GET',
				'permission_callback' => '__return_true',
				'callback'            => 'tn_rest_stats',
				'args'                => array( 'board' => array( 'required' => true, 'type' => 'string' ) ),
			)
		);
		register_rest_route(
			'testnook/v1',
			'/embed',
			array(
				'methods'             => 'POST',
				'permission_callback' => '__return_true',
				'callback'            => 'tn_rest_embed',
				'args'                => array(
					'slug' => array( 'required' => true, 'type' => 'string' ),
					'ref'  => array( 'type' => 'string', 'default' => '' ),
				),
			)
		);
	}
);

function tn_rest_error( $code, $status ) {
	return new WP_Error( $code, $code, array( 'status' => $status ) );
}

function tn_rest_start( WP_REST_Request $req ) {
	$board = sanitize_key( $req['board'] );
	if ( ! isset( tn_boards()[ $board ] ) ) {
		return tn_rest_error( 'unknown_board', 400 );
	}
	if ( tn_rate_limited( 'start', TN_RESULTS_PER_HOUR * 3 ) ) {
		return tn_rest_error( 'rate_limited', 429 );
	}
	$res = new WP_REST_Response( array( 'ticket' => tn_ticket_issue( $board ) ) );
	$res->header( 'Cache-Control', 'no-store' );
	return $res;
}

function tn_rest_result( WP_REST_Request $req ) {
	global $wpdb;
	$boards = tn_boards();
	$board  = sanitize_key( $req['board'] );
	if ( ! isset( $boards[ $board ] ) ) {
		return tn_rest_error( 'unknown_board', 400 );
	}
	$def   = $boards[ $board ];
	$value = (float) $req['value'];
	$extra = (int) $req['extra'];
	// Out of human range: answered with 200 so the browser console stays clean; the JS shows a short note.
	if ( ! is_finite( $value ) || $value < $def['min'] || $value > $def['max'] || ( $def['extra'] && ( $extra < $def['extra'][0] || $extra > $def['extra'][1] ) ) ) {
		return array( 'ok' => false, 'code' => 'implausible' );
	}
	if ( tn_rate_limited( 'result', TN_RESULTS_PER_HOUR ) ) {
		return tn_rest_error( 'rate_limited', 429 );
	}
	$ok = tn_ticket_consume( $req['ticket'], $board );
	if ( true !== $ok ) {
		return tn_rest_error( $ok, 403 );
	}

	// Near-identical gaps between clicks are a program, not a finger.
	$status = 'ok';
	$cv     = (float) $req['cv'];
	if ( 0 === strpos( $board, 'cps-' ) && $cv >= 0 && $cv < 3 && $value * $def['min_s'] >= 20 ) {
		$status = 'suspect';
	}

	$wpdb->insert( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		tn_results_table(),
		array(
			'board'   => $board,
			'value'   => round( $value, 2 ),
			'extra'   => $extra,
			'status'  => $status,
			'created' => gmdate( 'Y-m-d' ),
		),
		array( '%s', '%f', '%d', '%s', '%s' )
	);

	$id    = (int) $wpdb->insert_id;
	$stats = tn_stats_get( $board );
	$out   = array(
		'ok'         => true,
		'status'     => $status,
		'count'      => $stats ? (int) $stats['count'] : 0,
		'percentile' => $stats && 'ok' === $status ? tn_percentile( $stats, $def, $value ) : null,
	);
	// Leaderboard boards: the row id and a signed claim so the visitor can add a nickname (POST /claim).
	if ( ! empty( $def['lb'] ) && 'ok' === $status && $id ) {
		$out['id']    = $id;
		$out['claim'] = tn_claim_token( $id, $board );
	}
	$res = new WP_REST_Response( $out );
	$res->header( 'Cache-Control', 'no-store' );
	return $res;
}

function tn_rest_stats( WP_REST_Request $req ) {
	$board = sanitize_key( $req['board'] );
	if ( ! isset( tn_boards()[ $board ] ) ) {
		return tn_rest_error( 'unknown_board', 400 );
	}
	$res = new WP_REST_Response( tn_stats_get( $board ) ?: array( 'count' => 0 ) );
	$res->header( 'Cache-Control', 'public, max-age=600' );
	return $res;
}

function tn_rest_embed( WP_REST_Request $req ) {
	global $wpdb;
	$slug = sanitize_key( $req['slug'] );
	if ( ! tn_tool_is_live( $slug ) ) {
		return tn_rest_error( 'unknown_tool', 400 );
	}
	if ( tn_rate_limited( 'embed', 30 ) ) {
		return tn_rest_error( 'rate_limited', 429 );
	}
	$host = strtolower( (string) wp_parse_url( (string) $req['ref'], PHP_URL_HOST ) );
	$host = preg_replace( '/^www\./', '', $host );
	if ( ! $host || ! preg_match( '/^[a-z0-9.-]{1,100}$/', $host ) ) {
		$host = 'unknown';
	}
	$own = preg_replace( '/^www\./', '', strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) ) );
	if ( $host === $own ) {
		return array( 'ok' => true ); // our own preview
	}
	$table = tn_embed_hits_table();
	$day   = gmdate( 'Y-m-d' );
	$id    = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $table WHERE domain = %s AND slug = %s AND day = %s", $host, $slug, $day ) ); // phpcs:ignore
	if ( $id ) {
		$wpdb->query( $wpdb->prepare( "UPDATE $table SET hits = hits + 1 WHERE id = %d", $id ) ); // phpcs:ignore
	} else {
		$wpdb->insert( $table, array( 'domain' => $host, 'slug' => $slug, 'day' => $day, 'hits' => 1 ), array( '%s', '%s', '%s', '%d' ) ); // phpcs:ignore
	}
	return array( 'ok' => true );
}

/* ---------- Stats ---------- */

/** Cached stats for a board; computed on the spot the first time. */
function tn_stats_get( $board ) {
	$stats = get_transient( 'tn_stats_' . $board );
	if ( false === $stats ) {
		$stats = tn_stats_compute( $board );
		set_transient( 'tn_stats_' . $board, $stats, 2 * HOUR_IN_SECONDS );
	}
	return $stats;
}

function tn_stats_refresh_all() {
	foreach ( array_keys( tn_boards() ) as $board ) {
		set_transient( 'tn_stats_' . $board, tn_stats_compute( $board ), 2 * HOUR_IN_SECONDS );
	}
	update_option( 'tn_stats_refreshed', time(), false );
}

/**
 * Distribution of the last 30 days of a board: count, trimmed mean, median,
 * top 10 % line, 101 quantiles (for percentiles) and a 12-bin histogram.
 * Dead pixel: counts per grid cell and per type instead.
 */
function tn_stats_compute( $board ) {
	global $wpdb;
	$def   = tn_boards()[ $board ];
	$table = tn_results_table();
	$since = gmdate( 'Y-m-d', time() - TN_RESULTS_WINDOW_DAYS * DAY_IN_SECONDS );
	$total = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE board = %s AND status = 'ok'", $board ) ); // phpcs:ignore
	$out   = array( 'board' => $board, 'total' => $total, 'count' => 0, 'days' => TN_RESULTS_WINDOW_DAYS, 'at' => gmdate( 'c' ) );

	if ( ! empty( $def['map'] ) ) {
		$rows = $wpdb->get_results( $wpdb->prepare( "SELECT value, extra, COUNT(*) AS n FROM $table WHERE board = %s AND status = 'ok' AND created >= %s GROUP BY value, extra", $board, $since ), ARRAY_A ); // phpcs:ignore
		$cells = array_fill( 0, 100, 0 );
		$types = array( 0, 0, 0 );
		foreach ( $rows as $r ) {
			$n = (int) $r['n'];
			$t = min( 2, max( 0, (int) $r['extra'] ) );
			$types[ $t ] += $n;
			if ( $t > 0 ) {
				$cells[ min( 99, max( 0, (int) $r['value'] ) ) ] += $n;
			}
		}
		$out['count'] = array_sum( $types );
		$out['types'] = $types;
		$out['cells'] = $cells;
		return $out;
	}

	$values = $wpdb->get_col( $wpdb->prepare( "SELECT value FROM $table WHERE board = %s AND status = 'ok' AND created >= %s ORDER BY value ASC LIMIT 50000", $board, $since ) ); // phpcs:ignore
	$n      = count( $values );
	$out['count'] = $n;
	if ( $n < TN_RESULTS_MIN_COUNT ) {
		return $out;
	}
	$values = array_map( 'floatval', $values );
	$q      = function ( $p ) use ( $values, $n ) {
		$i = ( $n - 1 ) * $p;
		$lo = (int) floor( $i );
		$hi = min( $n - 1, $lo + 1 );
		return $values[ $lo ] + ( $values[ $hi ] - $values[ $lo ] ) * ( $i - $lo );
	};
	$trim   = (int) floor( $n * 0.01 );
	$middle = array_slice( $values, $trim, $n - 2 * $trim );
	$out['mean']   = round( array_sum( $middle ) / count( $middle ), 2 );
	$out['median'] = round( $q( 0.5 ), 2 );
	$out['top10']  = round( $q( $def['higher'] ? 0.9 : 0.1 ), 2 );
	$out['p1']     = round( $q( 0.01 ), 2 );
	$out['p99']    = round( $q( 0.99 ), 2 );
	$quant = array();
	for ( $p = 0; $p <= 100; $p++ ) {
		$quant[] = round( $q( $p / 100 ), 2 );
	}
	$out['quantiles'] = $quant;
	$bins  = 12;
	$lo    = $out['p1'];
	$hi    = max( $out['p99'], $lo + 0.01 );
	$hist  = array_fill( 0, $bins, 0 );
	foreach ( $values as $v ) {
		if ( $v < $lo || $v > $hi ) {
			continue;
		}
		$hist[ min( $bins - 1, (int) floor( ( $v - $lo ) / ( $hi - $lo ) * $bins ) ) ]++;
	}
	$out['hist'] = array( 'from' => $lo, 'to' => $hi, 'bins' => $hist );
	return $out;
}

/** Share of results (0-100) this value beats, from the cached quantiles. */
function tn_percentile( $stats, $def, $value ) {
	if ( empty( $stats['quantiles'] ) ) {
		return null;
	}
	$beats = 0;
	foreach ( $stats['quantiles'] as $qv ) {
		if ( $def['higher'] ? $value > $qv : $value < $qv ) {
			$beats++;
		}
	}
	return (int) min( 99, max( 1, round( $beats / count( $stats['quantiles'] ) * 100 ) ) );
}

/**
 * Rolls rows older than 400 days into a monthly summary option, then deletes
 * them. Named leaderboard entries that are shown (lb = 1) are kept, so the
 * all-time boards do not lose their old records.
 */
function tn_results_prune() {
	global $wpdb;
	$table  = tn_results_table();
	$before = gmdate( 'Y-m-d', time() - TN_RESULTS_KEEP_DAYS * DAY_IN_SECONDS );
	$rows   = $wpdb->get_results( $wpdb->prepare( "SELECT board, SUBSTR(created, 1, 7) AS month, COUNT(*) AS n, AVG(value) AS mean FROM $table WHERE created < %s AND status = 'ok' AND lb <> 1 GROUP BY board, SUBSTR(created, 1, 7)", $before ), ARRAY_A ); // phpcs:ignore
	if ( $rows ) {
		$archive = (array) get_option( 'tn_results_archive', array() );
		foreach ( $rows as $r ) {
			$key = $r['board'] . ':' . $r['month'];
			$old = isset( $archive[ $key ] ) ? $archive[ $key ] : array( 'n' => 0, 'mean' => 0 );
			$n   = $old['n'] + (int) $r['n'];
			$archive[ $key ] = array( 'n' => $n, 'mean' => round( ( $old['n'] * $old['mean'] + (int) $r['n'] * (float) $r['mean'] ) / $n, 2 ) );
		}
		update_option( 'tn_results_archive', $archive, false );
	}
	$wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE created < %s AND lb <> 1", $before ) ); // phpcs:ignore
	$embeds = tn_embed_hits_table();
	$wpdb->query( $wpdb->prepare( "DELETE FROM $embeds WHERE day < %s", $before ) ); // phpcs:ignore
}

/* ---------- Printed stats block ---------- */

function tn_fmt_value( $v, $def ) {
	return number_format_i18n( (float) $v, $def['dp'] ) . ( $def['unit'] ? ' ' . $def['unit'] : '' );
}

/**
 * The "Testnook stats" section for a tool page. $boards is the tool's 'stats'
 * list. Printed from the hourly cache so the HTML (and Google) carries real
 * numbers; returns nothing while a board has under 20 results. Guides pass
 * their own heading, a lead paragraph (HTML) and a section id.
 */
function tn_stats_block( $boards, $heading = 'How other people score on Testnook', $lead = '', $id = 'site-stats' ) {
	$all    = tn_boards();
	$blocks = '';
	foreach ( (array) $boards as $board ) {
		if ( ! isset( $all[ $board ] ) ) {
			continue;
		}
		$def   = $all[ $board ];
		$stats = tn_stats_get( $board );
		if ( ! $stats || $stats['count'] < TN_RESULTS_MIN_COUNT ) {
			continue;
		}
		$count = number_format_i18n( $stats['count'] );
		if ( ! empty( $def['map'] ) ) {
			$found = $stats['types'][1] + $stats['types'][2];
			$pct   = round( $found / $stats['count'] * 100 );
			$max   = max( 1, max( $stats['cells'] ) );
			$grid  = '';
			for ( $i = 0; $i < 100; $i++ ) {
				$share = $stats['cells'][ $i ] / $max;
				$grid .= '<i style="--h:' . round( $share, 2 ) . '" title="' . esc_attr( $stats['cells'][ $i ] . ' report' . ( 1 === $stats['cells'][ $i ] ? '' : 's' ) ) . '"></i>';
			}
			$edge = 0;
			foreach ( $stats['cells'] as $i => $c ) {
				$r = intdiv( $i, 10 );
				$col = $i % 10;
				if ( 0 === $r || 9 === $r || 0 === $col || 9 === $col ) {
					$edge += $c;
				}
			}
			$edge_pct = $found ? round( $edge / $found * 100 ) : 0;
			$blocks .= '<div class="site-stats__board">'
				. '<p><strong>' . esc_html( $pct ) . '%</strong> of ' . esc_html( $count ) . ' screens tested on Testnook in the last ' . TN_RESULTS_WINDOW_DAYS . ' days had a bad pixel reported'
				. ( $found ? ' (' . esc_html( number_format_i18n( $stats['types'][1] ) ) . ' dead, ' . esc_html( number_format_i18n( $stats['types'][2] ) ) . ' stuck). ' . esc_html( $edge_pct ) . '% of reported pixels sat in the outer edge of the screen.' : '.' ) . '</p>'
				. '<div class="pixel-map" role="img" aria-label="Where on the screen bad pixels were reported, darker is more common">' . $grid . '</div>'
				. '</div>';
			continue;
		}
		$bars = '';
		if ( ! empty( $stats['hist'] ) ) {
			$max = max( 1, max( $stats['hist']['bins'] ) );
			$w   = ( $stats['hist']['to'] - $stats['hist']['from'] ) / count( $stats['hist']['bins'] );
			foreach ( $stats['hist']['bins'] as $i => $n ) {
				$from  = $stats['hist']['from'] + $i * $w;
				$bars .= '<i style="--h:' . round( $n / $max * 100 ) . '%" title="' . esc_attr( tn_fmt_value( $from, $def ) . ' to ' . tn_fmt_value( $from + $w, $def ) . ': ' . number_format_i18n( $n ) ) . '"></i>';
			}
		}
		$blocks .= '<div class="site-stats__board">'
			. '<h3>' . esc_html( $def['name'] ) . '</h3>'
			. '<div class="stats">'
			. '<div class="stat"><span class="stat-label">Median</span><span class="stat-value">' . esc_html( tn_fmt_value( $stats['median'], $def ) ) . '</span></div>'
			. '<div class="stat"><span class="stat-label">Average</span><span class="stat-value">' . esc_html( tn_fmt_value( $stats['mean'], $def ) ) . '</span></div>'
			. '<div class="stat"><span class="stat-label">Top 10% ' . ( $def['higher'] ? 'above' : 'below' ) . '</span><span class="stat-value">' . esc_html( tn_fmt_value( $stats['top10'], $def ) ) . '</span></div>'
			. '<div class="stat"><span class="stat-label">Tests, ' . TN_RESULTS_WINDOW_DAYS . ' days</span><span class="stat-value">' . esc_html( $count ) . '</span></div>'
			. '</div>'
			. ( $bars ? '<div class="site-stats__hist" role="img" aria-label="Distribution of results from ' . esc_attr( tn_fmt_value( $stats['hist']['from'], $def ) ) . ' to ' . esc_attr( tn_fmt_value( $stats['hist']['to'], $def ) ) . '">' . $bars . '</div><p class="site-stats__axis"><span>' . esc_html( tn_fmt_value( $stats['hist']['from'], $def ) ) . '</span><span>' . esc_html( tn_fmt_value( $stats['hist']['to'], $def ) ) . '</span></p>' : '' )
			. '</div>';
	}
	if ( ! $blocks ) {
		return;
	}
	echo '<section id="' . esc_attr( $id ) . '" class="site-stats"><h2>' . esc_html( $heading ) . '</h2>'
		. ( $lead ? wp_kses( $lead, tn_allowed_html() ) : '' )
		. '<p>Anonymous results from the last ' . esc_html( TN_RESULTS_WINDOW_DAYS ) . ' days on this site, updated hourly. The top and bottom 1% are left out of the average, and results that fail our checks are not counted.</p>'
		. $blocks // phpcs:ignore WordPress.Security.EscapeOutput -- built above from escaped parts
		. '</section>';
}

/* ---------- Admin page: Tools > Testnook stats ---------- */

add_action(
	'admin_menu',
	function () {
		add_management_page( 'Testnook stats', 'Testnook stats', 'manage_options', 'tn-stats', 'tn_admin_stats_page' );
	}
);

function tn_admin_stats_page() {
	global $wpdb;
	if ( isset( $_POST['tn_refresh'] ) && check_admin_referer( 'tn_refresh_stats' ) ) {
		tn_stats_refresh_all();
		echo '<div class="notice notice-success"><p>Stats refreshed.</p></div>';
	}
	$table   = tn_results_table();
	$since   = gmdate( 'Y-m-d', time() - TN_RESULTS_WINDOW_DAYS * DAY_IN_SECONDS );
	$rows    = $wpdb->get_results( $wpdb->prepare( "SELECT board, status, COUNT(*) AS n FROM $table WHERE created >= %s GROUP BY board, status", $since ), ARRAY_A ); // phpcs:ignore
	$by      = array();
	foreach ( $rows as $r ) {
		$by[ $r['board'] ][ $r['status'] ] = (int) $r['n'];
	}
	$embeds  = tn_embed_hits_table();
	$domains = $wpdb->get_results( $wpdb->prepare( "SELECT domain, SUM(hits) AS hits, COUNT(DISTINCT slug) AS tools, MAX(day) AS last FROM $embeds WHERE day >= %s GROUP BY domain ORDER BY hits DESC LIMIT 100", $since ), ARRAY_A ); // phpcs:ignore
	$at      = (int) get_option( 'tn_stats_refreshed' );
	echo '<div class="wrap"><h1>Testnook stats</h1>';
	echo '<p>Anonymous results from the last ' . esc_html( TN_RESULTS_WINDOW_DAYS ) . ' days. Cached stats last refreshed: ' . esc_html( $at ? human_time_diff( $at ) . ' ago' : 'never' ) . '.</p>';
	echo '<form method="post">' . wp_nonce_field( 'tn_refresh_stats', '_wpnonce', true, false ) . '<p><button class="button" name="tn_refresh" value="1">Refresh stats now</button></p></form>';
	echo '<h2>Results per board</h2><table class="widefat striped" style="max-width:720px"><thead><tr><th>Board</th><th>OK</th><th>Suspect</th><th>Median</th><th>All time</th></tr></thead><tbody>';
	foreach ( tn_boards() as $board => $def ) {
		$stats = tn_stats_get( $board );
		echo '<tr><td>' . esc_html( $board ) . '</td><td>' . esc_html( isset( $by[ $board ]['ok'] ) ? $by[ $board ]['ok'] : 0 ) . '</td><td>' . esc_html( isset( $by[ $board ]['suspect'] ) ? $by[ $board ]['suspect'] : 0 ) . '</td><td>' . esc_html( isset( $stats['median'] ) ? tn_fmt_value( $stats['median'], $def ) : '-' ) . '</td><td>' . esc_html( $stats ? $stats['total'] : 0 ) . '</td></tr>';
	}
	echo '</tbody></table>';
	echo '<h2>Sites embedding our tools</h2>';
	if ( ! $domains ) {
		echo '<p>No embed loads recorded yet.</p>';
	} else {
		echo '<table class="widefat striped" style="max-width:720px"><thead><tr><th>Domain</th><th>Loads</th><th>Tools</th><th>Last seen</th></tr></thead><tbody>';
		foreach ( $domains as $d ) {
			echo '<tr><td>' . esc_html( $d['domain'] ) . '</td><td>' . esc_html( $d['hits'] ) . '</td><td>' . esc_html( $d['tools'] ) . '</td><td>' . esc_html( $d['last'] ) . '</td></tr>';
		}
		echo '</tbody></table>';
	}
	echo '</div>';
}
