<?php
/**
 * Guides: long-form articles under content/guides/<slug>.php (page key guide:<slug>).
 *
 * A guide belongs to a hub and points at the tool it explains ('tool', plus
 * more in 'tools'). Tool pages and hubs list their guides, /guides/ lists them
 * all. The optional 'data' section quotes the live site stats with tokens:
 *   {median:<board>} {mean:<board>} {top10:<board>} {count:<board>}
 *   {beats:<board>:<value>}  share of results that <value> beats, e.g. 63%
 * The section (and its stats block) is printed only when every board it
 * names has enough results, so the rest of the text must stand on its own.
 */

defined( 'ABSPATH' ) || exit;

function tn_guide_url( $slug ) {
	return home_url( '/' . $slug . '/' );
}

/** Every guide definition, newest first (by 'published', then title). */
function tn_guides() {
	static $guides = null;
	if ( null !== $guides ) {
		return $guides;
	}
	$guides = array();
	foreach ( glob( TN_DIR . '/content/guides/*.php' ) as $file ) {
		$slug = basename( $file, '.php' );
		$def  = tn_get_def( 'guide:' . $slug );
		if ( $def ) {
			$guides[ $slug ] = $def;
		}
	}
	uasort(
		$guides,
		function ( $a, $b ) {
			return strcmp( $b['published'], $a['published'] ) ?: strcmp( $a['title'], $b['title'] );
		}
	);
	return $guides;
}

/** Guides that explain a tool ('tool' first, then those listing it in 'tools'). */
function tn_guides_for_tool( $slug ) {
	$main  = array();
	$other = array();
	foreach ( tn_guides() as $g => $guide ) {
		if ( $guide['tool'] === $slug ) {
			$main[ $g ] = $guide;
		} elseif ( in_array( $slug, $guide['tools'], true ) ) {
			$other[ $g ] = $guide;
		}
	}
	return $main + $other;
}

function tn_guides_in_hub( $hub ) {
	return array_filter(
		tn_guides(),
		function ( $guide ) use ( $hub ) {
			return $guide['hub'] === $hub;
		}
	);
}

/** Words in the guide's text (intro, short answer, sections, FAQ). */
function tn_guide_words( $def ) {
	$text = $def['intro'] . ' ' . implode( ' ', (array) $def['summary'] );
	foreach ( $def['sections'] as $section ) {
		$text .= ' ' . $section[1];
	}
	foreach ( $def['faq'] as $qa ) {
		$text .= ' ' . $qa[1];
	}
	return str_word_count( wp_strip_all_tags( $text ) );
}

/** Estimated reading time in minutes. */
function tn_guide_minutes( $def ) {
	return max( 1, (int) round( tn_guide_words( $def ) / 220 ) );
}

function tn_guide_card( $guide ) {
	printf(
		'<a class="card card--guide" href="%1$s" data-search="%5$s" data-name="%6$s"><span class="card-icon">%2$s</span><span class="card-body"><span class="card-title">%3$s</span><span class="card-text">%4$s</span></span></a>',
		esc_url( tn_guide_url( $guide['slug'] ) ),
		tn_icon( 'book' ), // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG
		esc_html( $guide['title'] ),
		esc_html( $guide['blurb'] ),
		esc_attr( strtolower( $guide['title'] . ' ' . $guide['blurb'] . ' guide' ) ),
		esc_attr( strtolower( $guide['title'] ) )
	);
}

/** A "Guides" section with cards; prints nothing for an empty list. */
function tn_guides_section( $guides, $heading = 'Guides', $id = 'guides' ) {
	if ( ! $guides ) {
		return;
	}
	echo '<section class="related related--guides" id="' . esc_attr( $id ) . '" aria-labelledby="' . esc_attr( $id ) . '-title"><h2 id="' . esc_attr( $id ) . '-title">' . esc_html( $heading ) . '</h2><ul class="cards">';
	foreach ( $guides as $guide ) {
		echo '<li>';
		tn_guide_card( $guide );
		echo '</li>';
	}
	echo '</ul></section>';
}

/**
 * The guide's live-data HTML with the tokens filled in, or '' when a board
 * it quotes has too few results (or an unknown board/field).
 */
function tn_guide_data_html( $html ) {
	$boards = tn_boards();
	$ok     = true;
	$out    = preg_replace_callback(
		'/\{(median|mean|top10|count|beats):([a-z0-9-]+)(?::([0-9.]+))?\}/',
		function ( $m ) use ( $boards, &$ok ) {
			if ( ! isset( $boards[ $m[2] ] ) ) {
				$ok = false;
				return '';
			}
			$def   = $boards[ $m[2] ];
			$stats = tn_stats_get( $m[2] );
			if ( ! $stats || $stats['count'] < TN_RESULTS_MIN_COUNT ) {
				$ok = false;
				return '';
			}
			if ( 'count' === $m[1] ) {
				return number_format_i18n( $stats['count'] );
			}
			if ( 'beats' === $m[1] ) {
				$p = isset( $m[3] ) ? tn_percentile( $stats, $def, (float) $m[3] ) : null;
				if ( null === $p ) {
					$ok = false;
					return '';
				}
				return $p . '%';
			}
			if ( ! isset( $stats[ $m[1] ] ) ) {
				$ok = false;
				return '';
			}
			return tn_fmt_value( $stats[ $m[1] ], $def );
		},
		$html
	);
	return $ok ? $out : '';
}

/** /guides/: every guide, grouped by hub in the hub order of the catalog. */
function tn_guides_index() {
	foreach ( tn_hubs() as $hub => $info ) {
		$list = tn_guides_in_hub( $hub );
		if ( ! $list ) {
			continue;
		}
		echo '<section class="guides-group" id="' . esc_attr( $hub ) . '"><h2>' . esc_html( $info['title'] ) . '</h2><ul class="cards">';
		foreach ( $list as $guide ) {
			echo '<li>';
			tn_guide_card( $guide );
			echo '</li>';
		}
		echo '</ul>';
		if ( tn_hub_is_live( $hub ) ) {
			echo '<p class="guides-group__more"><a href="' . esc_url( tn_hub_url( $hub ) ) . '">All ' . esc_html( strtolower( $info['title'] ) ) . '</a></p>';
		}
		echo '</section>';
	}
}
