<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Contact Testnook',
	'seo_title'   => 'Contact Testnook',
	'description' => 'Contact the Testnook team to report a bug, suggest a new hardware test, ask about embedding a tool or send a business enquiry.',
	'body'        => '<p>The quickest way to reach us is by email:</p>
<p class="section-box"><strong>Email:</strong> <a href="mailto:' . esc_attr( TN_CONTACT_EMAIL ) . '">' . esc_html( TN_CONTACT_EMAIL ) . '</a></p>
<p>We usually reply within two working days.</p>
<h2>Reporting a problem with a test</h2>
<p>To help us reproduce the issue, please include:</p>
<ul>
<li>the page address (URL) of the test,</li>
<li>your device and operating system, for example "Windows 11 laptop" or "iPhone 15, iOS 26",</li>
<li>your browser and its version,</li>
<li>the hardware you were testing (brand and model), and</li>
<li>what you expected to happen and what happened instead.</li>
</ul>
<h2>Suggesting a test</h2>
<p>Tell us what you wanted to check and which device you have. Many of our tools started as reader suggestions.</p>
<h2>Embedding and partnerships</h2>
<p>Every tool has free embed code at the bottom of its page. For anything else, including corrections, press or advertising, email us at the address above.</p>
<p>Testnook is run by ' . esc_html( TN_FOUNDER_NAME ) . '. Read more on the <a href="/about/">About page</a>.</p>',
);
