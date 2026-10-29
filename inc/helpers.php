<?php
/**
 * Small rendering helpers shared by templates.
 */

defined( 'ABSPATH' ) || exit;

function tn_tool_url( $slug ) {
	return home_url( '/' . $slug . '/' );
}

/** The iframe + credit link for a tool. $theme is '', 'light' or 'dark'. */
function tn_embed_code( $def, $width = '100%', $height = 620, $theme = '' ) {
	$src = add_query_arg( 'embed', '1', tn_tool_url( $def['slug'] ) );
	if ( $theme ) {
		$src = add_query_arg( 'theme', $theme, $src );
	}
	return sprintf(
		'<iframe src="%1$s" width="%2$s" height="%3$d" style="border:0;max-width:100%%" title="%4$s" allow="camera; microphone; gamepad; fullscreen; autoplay; accelerometer; gyroscope; magnetometer; geolocation" loading="lazy"></iframe>' . "\n" . '<p><a href="%5$s">%4$s</a> by %6$s</p>',
		esc_url( $src ),
		esc_attr( $width ),
		(int) $height,
		esc_html( $def['name'] ),
		esc_url( tn_tool_url( $def['slug'] ) ),
		esc_html( TN_SITE_NAME )
	);
}

/** Hub page URL, or a homepage anchor while the hub page is not built yet. */
function tn_hub_url( $hub ) {
	return tn_hub_is_live( $hub ) ? home_url( '/' . $hub . '/' ) : home_url( '/#' . $hub );
}

/** Breadcrumb trail for the current theme page: list of [name, url]. */
function tn_breadcrumb_items( $def ) {
	$items = array( array( 'Home', home_url( '/' ) ) );
	if ( 'tool' === $def['type'] ) {
		$hub     = tn_hubs()[ $def['hub'] ];
		$items[] = array( $hub['name'], tn_hub_url( $def['hub'] ) );
		$items[] = array( $def['name'], tn_tool_url( $def['slug'] ) );
	} elseif ( 'hub' === $def['type'] ) {
		$items[] = array( $def['name'], tn_hub_url( $def['slug'] ) );
	} elseif ( 'guide' === $def['type'] ) {
		$items[] = array( 'Guides', home_url( '/guides/' ) );
		$items[] = array( $def['title'], tn_guide_url( $def['slug'] ) );
	} else {
		$items[] = array( $def['title'], home_url( '/' . $def['slug'] . '/' ) );
	}
	return $items;
}

function tn_breadcrumbs( $def ) {
	$items = tn_breadcrumb_items( $def );
	$last  = count( $items ) - 1;
	echo '<nav class="crumbs" aria-label="Breadcrumb"><ol>';
	foreach ( $items as $i => $item ) {
		if ( $i === $last ) {
			echo '<li aria-current="page">' . esc_html( $item[0] ) . '</li>';
		} else {
			echo '<li><a href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a></li>';
		}
	}
	echo '</ol></nav>';
}

/**
 * One tool card. Planned tools without a page render as a muted "Coming soon"
 * card with no link.
 */
function tn_tool_card( $tool ) {
	$hub  = $tool['hub'];
	$icon = tn_icon( tn_hubs()[ $hub ]['icon'] );
	if ( $tool['live'] ) {
		printf(
			'<a class="card" href="%1$s" data-search="%2$s" data-name="%6$s" data-keywords="%7$s"><span class="card-icon">%3$s</span><span class="card-body"><span class="card-title">%4$s</span><span class="card-text">%5$s</span></span></a>',
			esc_url( tn_tool_url( $tool['slug'] ) ),
			esc_attr( strtolower( $tool['name'] . ' ' . $tool['blurb'] . ' ' . $hub ) ),
			$icon, // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG
			esc_html( $tool['name'] ),
			esc_html( $tool['blurb'] ),
			esc_attr( strtolower( $tool['name'] ) ),
			esc_attr( strtolower( isset( $tool['keywords'] ) ? $tool['keywords'] : '' ) )
		);
	} else {
		printf(
			'<div class="card card--soon" data-search="%1$s"><span class="card-icon">%2$s</span><span class="card-body"><span class="card-title">%3$s <span class="badge">Coming soon</span></span><span class="card-text">%4$s</span></span></div>',
			esc_attr( strtolower( $tool['name'] . ' ' . $tool['blurb'] . ' ' . $hub ) ),
			$icon, // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG
			esc_html( $tool['name'] ),
			esc_html( $tool['blurb'] )
		);
	}
}

/** FAQ list as native <details> elements (works without JS). */
function tn_faq( $faq, $heading = 'Frequently asked questions' ) {
	if ( ! $faq ) {
		return;
	}
	echo '<section id="faq" class="faq"><h2>' . esc_html( $heading ) . '</h2>';
	foreach ( $faq as $qa ) {
		echo '<details><summary>' . esc_html( $qa[0] ) . '</summary><div class="faq-a">' . wp_kses_post( $qa[1] ) . '</div></details>';
	}
	echo '</section>';
}

/** Content strings in content/ files are trusted theme code, but still pass through KSES for safety. */
function tn_html( $html ) {
	echo wp_kses( $html, tn_allowed_html() );
}

/** Post HTML plus the form controls, media and data attributes tools need. */
function tn_allowed_html() {
	static $allowed = null;
	if ( null !== $allowed ) {
		return $allowed;
	}
	$allowed = wp_kses_allowed_html( 'post' );
	$common  = array( 'id' => true, 'class' => true, 'style' => true, 'hidden' => true, 'role' => true, 'tabindex' => true, 'title' => true, 'aria-label' => true, 'aria-live' => true, 'aria-hidden' => true, 'aria-pressed' => true, 'aria-describedby' => true, 'aria-controls' => true, 'aria-expanded' => true );
	$extra   = array(
		'button'   => array( 'type' => true, 'disabled' => true, 'value' => true, 'name' => true ),
		'input'    => array( 'type' => true, 'min' => true, 'max' => true, 'step' => true, 'value' => true, 'name' => true, 'checked' => true, 'disabled' => true, 'placeholder' => true, 'readonly' => true, 'inputmode' => true, 'autocomplete' => true, 'autocorrect' => true, 'autocapitalize' => true, 'spellcheck' => true, 'enterkeyhint' => true, 'pattern' => true, 'for' => true, 'list' => true ),
		'select'   => array( 'name' => true, 'disabled' => true ),
		'textarea' => array( 'rows' => true, 'cols' => true, 'readonly' => true, 'name' => true ),
		'option'   => array( 'value' => true, 'selected' => true ),
		'label'    => array( 'for' => true ),
		'output'   => array( 'for' => true, 'name' => true ),
		'canvas'   => array( 'width' => true, 'height' => true ),
		'video'    => array( 'autoplay' => true, 'muted' => true, 'playsinline' => true, 'controls' => true, 'width' => true, 'height' => true ),
		'audio'    => array( 'controls' => true, 'src' => true ),
		'meter'    => array( 'min' => true, 'max' => true, 'low' => true, 'high' => true, 'optimum' => true, 'value' => true ),
		'progress' => array( 'max' => true, 'value' => true ),
		'kbd'      => array(),
		'svg'      => array( 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true, 'xmlns' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'focusable' => true ),
		'path'     => array( 'd' => true, 'fill' => true, 'stroke' => true ),
		'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true ),
		'rect'     => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'fill' => true, 'stroke' => true ),
		'line'     => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true ),
		'g'        => array( 'transform' => true, 'fill' => true, 'stroke' => true ),
		'text'     => array( 'x' => true, 'y' => true, 'text-anchor' => true, 'font-size' => true, 'fill' => true ),
		'details'  => array( 'open' => true ),
		'summary'  => array(),
		'dialog'   => array( 'open' => true ),
		'template' => array(),
	);
	foreach ( $extra as $tag => $attrs ) {
		$allowed[ $tag ] = array_merge( isset( $allowed[ $tag ] ) ? $allowed[ $tag ] : array(), $attrs );
	}
	foreach ( $allowed as $tag => $attrs ) {
		$allowed[ $tag ] = array_merge( $attrs, $common, array( 'data-*' => true ) );
	}
	return $allowed;
}

/**
 * Up to 8 related live tools: the page's own list first, then tools from the
 * same hub, then any other live tool.
 */
function tn_related_tools( $def, $limit = 8 ) {
	$tools = tn_tools();
	$pick  = array();
	$pools = array(
		(array) $def['related'],
		array_keys( tn_tools_in_hub( $def['hub'] ) ),
		array_keys( $tools ),
	);
	foreach ( $pools as $pool ) {
		foreach ( $pool as $slug ) {
			if ( count( $pick ) >= $limit ) {
				break 2;
			}
			if ( $slug !== $def['slug'] && isset( $tools[ $slug ] ) && $tools[ $slug ]['live'] && ! isset( $pick[ $slug ] ) ) {
				$pick[ $slug ] = $tools[ $slug ];
			}
		}
	}
	return $pick;
}
