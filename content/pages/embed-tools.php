<?php
/**
 * /embed-tools/: every live tool (the /embed/ slug is reserved by WordPress for oEmbed) with its iframe code, grouped by hub.
 */

defined( 'ABSPATH' ) || exit;

$tn_embed_list = '';
foreach ( tn_hubs() as $tn_hub_slug => $tn_hub ) {
	$tn_items = '';
	foreach ( tn_tools_in_hub( $tn_hub_slug ) as $tn_slug => $tn_tool ) {
		if ( ! $tn_tool['live'] || $tn_tool['hub'] !== $tn_hub_slug ) {
			continue;
		}
		$tn_def = tn_get_def( 'tool:' . $tn_slug );
		if ( ! $tn_def ) {
			continue;
		}
		$tn_height = isset( $tn_def['embed_height'] ) ? (int) $tn_def['embed_height'] : 620;
		$tn_items .= '<details><summary>' . esc_html( $tn_def['name'] ) . '</summary>'
			. '<p>' . esc_html( $tn_tool['blurb'] ) . ' <a href="' . esc_url( tn_tool_url( $tn_slug ) ) . '">Open the tool</a>.</p>'
			. '<label class="visually-hidden" for="embed-' . esc_attr( $tn_slug ) . '">Embed code for the ' . esc_attr( $tn_def['name'] ) . '</label>'
			. '<textarea id="embed-' . esc_attr( $tn_slug ) . '" readonly rows="4">' . esc_textarea( tn_embed_code( $tn_def, '100%', $tn_height ) ) . '</textarea>'
			. '<button class="btn btn-sm" type="button" data-tn-copy="#embed-' . esc_attr( $tn_slug ) . '">Copy code</button>'
			. '</details>';
	}
	if ( $tn_items ) {
		$tn_embed_list .= '<h2 id="' . esc_attr( $tn_hub_slug ) . '">' . esc_html( $tn_hub['title'] ) . '</h2>' . $tn_items;
	}
}

return array(
	'title'       => 'Embed Testnook Tools on Your Site',
	'seo_title'   => 'Embed Free Hardware Test Tools on Your Website | Testnook',
	'description' => 'Add any Testnook tool to your site with one line of iframe code: CPS test, reaction time, typing test, dead pixel, webcam and mic tests. Free, no ads in the frame.',
	'updated'     => '2026-10-29',
	'body'        => '<p>Every tool on Testnook can be embedded on your own website, blog, forum or school page for free. Paste the code for a tool where you want it to appear. The tool runs inside the frame on your visitor\'s device, exactly as it does here, with no ads inside the frame and no sign-up.</p>
<h2 id="how">How it works</h2>
<ol>
<li>Find the tool below and click <strong>Copy code</strong>.</li>
<li>Paste the code into your page\'s HTML (in WordPress, use a Custom HTML block).</li>
<li>Change the <code>width</code> and <code>height</code> values if you like. Each tool page also has an embed box with width, height, light or dark theme and a live preview.</li>
</ol>
<p>The code is two lines: the iframe, and a credit link under it. Please keep the credit link, as it is the only thing we ask for in return. Camera, microphone and controller tests need the <code>allow</code> attribute that is already in the code, and your page must be served over HTTPS for them to work.</p>
<h2 id="terms">Embed terms</h2>
<ul>
<li>Free for personal, educational and commercial sites, including repair shops and computer stores.</li>
<li>Keep the credit link under the frame and do not present the tool as your own product.</li>
<li>Do not cover the frame with your own ads or overlays, and do not change how the tool works.</li>
<li>Tests inside a frame do not take part in Testnook\'s anonymous site statistics; only the tool loads are counted, by domain, so we can see where the tools are used.</li>
<li>We may change or retire a tool at any time. The full <a href="/terms/">terms of use</a> apply.</li>
</ul>
<div class="embed-list">' . $tn_embed_list . '</div>',
);
