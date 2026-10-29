<?php
/**
 * Titles, meta description, canonical, Open Graph and JSON-LD.
 *
 * If Yoast SEO or Rank Math is active, this file leaves titles, descriptions,
 * canonicals and OG tags to the plugin and only prints the tool/hub schema the
 * plugins cannot know about.
 *
 * Schema notes (agreed in research): FAQPage and HowTo no longer give rich
 * results, so HowTo is not used; FAQPage stays because it is still valid and
 * read by other engines. No rating/review schema (we have no real ratings).
 */

defined( 'ABSPATH' ) || exit;

function tn_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' );
}

/** Homepage content (content/home.php). */
function tn_home_def() {
	static $def = null;
	if ( null === $def ) {
		$def = require TN_DIR . '/content/home.php';
	}
	return $def;
}

/** SEO fields for the current request: title, description, url, image. */
function tn_seo_fields() {
	$fields = array(
		'title'       => '',
		'description' => '',
		'url'         => '',
		'image'       => TN_URI . '/assets/img/og-default.jpg',
	);
	if ( is_front_page() ) {
		$home                  = tn_home_def();
		$fields['title']       = $home['seo_title'];
		$fields['description'] = $home['description'];
		$fields['url']         = home_url( '/' );
	} elseif ( $def = tn_current_def() ) { // phpcs:ignore
		$fields['title']       = isset( $def['seo_title'] ) ? $def['seo_title'] : $def['title'] . ' | ' . TN_SITE_NAME;
		$fields['description'] = isset( $def['description'] ) ? $def['description'] : '';
		$fields['url']         = get_permalink();
		$og                    = '/assets/img/og/' . $def['slug'] . '.jpg';
		if ( is_readable( TN_DIR . $og ) ) {
			$fields['image'] = TN_URI . $og;
		}
	}
	return $fields;
}

add_filter(
	'pre_get_document_title',
	function ( $title ) {
		if ( tn_seo_plugin_active() ) {
			return $title;
		}
		$fields = tn_seo_fields();
		return $fields['title'] ? $fields['title'] : $title;
	},
	20
);

add_filter( 'document_title_separator', function () { return '|'; } );

/** Embed copies of tools must not compete with the real pages. */
add_filter(
	'wp_robots',
	function ( $robots ) {
		if ( tn_is_embed() ) {
			$robots['noindex'] = true;
			$robots['follow']  = true;
		} elseif ( ! is_404() ) {
			$robots['max-image-preview'] = 'large';
		}
		return $robots;
	}
);

// Search Console verification tag, on every page, before the SEO output.
add_action(
	'wp_head',
	function () {
		if ( defined( 'TN_GSC_VERIFICATION' ) && TN_GSC_VERIFICATION ) {
			echo '<meta name="google-site-verification" content="' . esc_attr( TN_GSC_VERIFICATION ) . '">' . "\n";
		}
	},
	0
);

add_action(
	'wp_head',
	function () {
		if ( tn_seo_plugin_active() ) {
			return;
		}
		$f = tn_seo_fields();
		if ( ! $f['url'] ) {
			return;
		}
		if ( $f['description'] ) {
			echo '<meta name="description" content="' . esc_attr( $f['description'] ) . '">' . "\n";
		}
		if ( is_front_page() ) {
			// WordPress prints rel=canonical for singular pages itself; add it for the homepage.
			echo '<link rel="canonical" href="' . esc_url( $f['url'] ) . '">' . "\n";
		}
		$def = tn_current_def();
		$og  = array(
			'og:type'        => $def && 'guide' === $def['type'] ? 'article' : 'website',
			'og:site_name'   => TN_SITE_NAME,
			'og:title'       => $f['title'],
			'og:description' => $f['description'],
			'og:url'         => $f['url'],
			'og:image'       => $f['image'],
			'og:locale'      => 'en_US',
		);
		foreach ( $og as $prop => $val ) {
			echo '<meta property="' . esc_attr( $prop ) . '" content="' . esc_attr( $val ) . '">' . "\n";
		}
		// Every share image is 1200x630 (assets/img/og-default.jpg and bin/make-og-images.py).
		echo '<meta property="og:image:width" content="1200">' . "\n";
		echo '<meta property="og:image:height" content="630">' . "\n";
		echo '<meta property="og:image:alt" content="' . esc_attr( $f['title'] ) . '">' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $f['title'] ) . '">' . "\n";
		echo '<meta name="twitter:description" content="' . esc_attr( $f['description'] ) . '">' . "\n";
		echo '<meta name="twitter:image" content="' . esc_attr( $f['image'] ) . '">' . "\n";
	},
	2
);

/** Organization node with founder, reused on every page. */
function tn_schema_org() {
	$org = array(
		'@type'        => 'Organization',
		'@id'          => home_url( '/#organization' ),
		'name'         => TN_SITE_NAME,
		'url'          => home_url( '/' ),
		'logo'         => array(
			'@type' => 'ImageObject',
			'url'   => TN_URI . '/assets/img/logo-512.png',
		),
		'email'        => TN_CONTACT_EMAIL,
		'founder'      => array( '@id' => home_url( '/#founder' ) ),
		'contactPoint' => array(
			'@type'       => 'ContactPoint',
			'email'       => TN_CONTACT_EMAIL,
			'contactType' => 'customer support',
		),
	);
	$founder = array(
		'@type'  => 'Person',
		'@id'    => home_url( '/#founder' ),
		'name'   => TN_FOUNDER_NAME,
		'sameAs' => array( TN_FOUNDER_URL ),
	);
	return array( $org, $founder );
}

function tn_schema_website() {
	return array(
		'@type'           => 'WebSite',
		'@id'             => home_url( '/#website' ),
		'name'            => TN_SITE_NAME,
		'url'             => home_url( '/' ),
		'description'     => TN_TAGLINE,
		'publisher'       => array( '@id' => home_url( '/#organization' ) ),
		'inLanguage'      => 'en',
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?q={search_term_string}' ),
			),
			'query-input' => 'required name=search_term_string',
		),
	);
}

function tn_schema_breadcrumbs( $def ) {
	$list = array();
	foreach ( tn_breadcrumb_items( $def ) as $i => $item ) {
		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $item[0],
			'item'     => $item[1],
		);
	}
	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => get_permalink() . '#breadcrumb',
		'itemListElement' => $list,
	);
}

function tn_schema_faq( $faq, $url ) {
	$items = array();
	foreach ( $faq as $qa ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => $qa[0],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => wp_strip_all_tags( $qa[1] ),
			),
		);
	}
	return array(
		'@type'      => 'FAQPage',
		'@id'        => $url . '#faq',
		'mainEntity' => $items,
	);
}

function tn_schema_graph() {
	$graph = array();
	if ( ! tn_seo_plugin_active() ) {
		$graph   = tn_schema_org();
		$graph[] = tn_schema_website();
	}

	if ( is_front_page() ) {
		$home = tn_home_def();
		if ( ! empty( $home['faq'] ) ) {
			$graph[] = tn_schema_faq( $home['faq'], home_url( '/' ) );
		}
		return $graph;
	}

	$def = tn_current_def();
	if ( ! $def || tn_is_embed() ) {
		return $graph;
	}
	$url    = get_permalink();
	$fields = tn_seo_fields();
	$dates  = array();
	if ( ! empty( $def['updated'] ) ) {
		$dates['dateModified'] = $def['updated'];
	}

	if ( 'tool' === $def['type'] ) {
		$graph[] = array(
			'@type'               => 'WebApplication',
			'@id'                 => $url . '#app',
			'name'                => $def['name'],
			'url'                 => $url,
			'description'         => $def['description'],
			'image'               => $fields['image'],
			'inLanguage'          => 'en',
			'isPartOf'            => array( '@id' => home_url( '/#website' ) ),
			'breadcrumb'          => array( '@id' => $url . '#breadcrumb' ),
			'applicationCategory' => 'UtilitiesApplication',
			'operatingSystem'     => 'Any (runs in a web browser)',
			'browserRequirements' => 'Requires JavaScript and a modern browser',
			'isAccessibleForFree' => true,
			'offers'              => array(
				'@type'         => 'Offer',
				'price'         => '0',
				'priceCurrency' => 'USD',
			),
			'publisher'           => array( '@id' => home_url( '/#organization' ) ),
		) + $dates;
	} elseif ( 'hub' === $def['type'] ) {
		$items = array();
		$pos   = 0;
		foreach ( tn_tools_in_hub( $def['slug'] ) as $tool ) {
			if ( $tool['live'] ) {
				$items[] = array(
					'@type'    => 'ListItem',
					'position' => ++$pos,
					'url'      => tn_tool_url( $tool['slug'] ),
					'name'     => $tool['name'],
				);
			}
		}
		$graph[] = array(
			'@type'       => 'CollectionPage',
			'@id'         => $url . '#page',
			'name'        => $def['title'],
			'url'         => $url,
			'description' => $def['description'],
			'image'       => $fields['image'],
			'inLanguage'  => 'en',
			'isPartOf'    => array( '@id' => home_url( '/#website' ) ),
			'breadcrumb'  => array( '@id' => $url . '#breadcrumb' ),
			'mainEntity'  => array(
				'@type'           => 'ItemList',
				'numberOfItems'   => count( $items ),
				'itemListElement' => $items,
			),
		) + $dates;
	} elseif ( 'guide' === $def['type'] ) {
		$graph[] = array(
			'@type'            => 'Article',
			'@id'              => $url . '#article',
			'headline'         => $def['title'],
			'description'      => $def['description'],
			'url'              => $url,
			'mainEntityOfPage' => $url,
			'image'            => $fields['image'],
			'inLanguage'       => 'en',
			'datePublished'    => $def['published'],
			'dateModified'     => $def['updated'],
			'wordCount'        => tn_guide_words( $def ),
			'author'           => array(
				'@type' => 'Person',
				'@id'   => home_url( '/#founder' ),
				'name'  => TN_FOUNDER_NAME,
				'url'   => home_url( '/about/' ),
			),
			'publisher'        => array( '@id' => home_url( '/#organization' ) ),
			'isPartOf'         => array( '@id' => home_url( '/#website' ) ),
			'breadcrumb'       => array( '@id' => $url . '#breadcrumb' ),
		);
	} else {
		$types   = array(
			'about'   => 'AboutPage',
			'contact' => 'ContactPage',
		);
		$graph[] = array(
			'@type'       => isset( $types[ $def['slug'] ] ) ? $types[ $def['slug'] ] : 'WebPage',
			'@id'         => $url . '#page',
			'name'        => $def['title'],
			'url'         => $url,
			'description' => isset( $def['description'] ) ? $def['description'] : '',
			'inLanguage'  => 'en',
			'isPartOf'    => array( '@id' => home_url( '/#website' ) ),
			'breadcrumb'  => array( '@id' => $url . '#breadcrumb' ),
		) + $dates;
	}

	$graph[] = tn_schema_breadcrumbs( $def );
	if ( ! empty( $def['faq'] ) ) {
		$graph[] = tn_schema_faq( $def['faq'], $url );
	}
	return $graph;
}

add_action(
	'wp_head',
	function () {
		$graph = tn_schema_graph();
		if ( $graph ) {
			echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
		}
	},
	30
);
