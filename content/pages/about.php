<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'About Testnook',
	'seo_title'   => 'About Testnook: Free Browser-Based Hardware Tests',
	'description' => 'Testnook is a free set of browser-based tests for keyboards, mice, controllers, screens, speakers, microphones and cameras. Learn who runs it and why.',
	'updated'     => '2026-10-28',
	'body'        => '<p>Testnook is a free collection of hardware tests that run in your web browser. You can check a keyboard, mouse, game controller, monitor, speakers, headphones, microphone or webcam in a few seconds, without installing anything.</p>
<h2>Why we built it</h2>
<p>Most people only find out a device is faulty at the worst moment: a key fails in the middle of a game, a microphone is silent on an important call, or a new monitor turns out to have a dead pixel after the return window has closed. Good tests for these problems already existed, but they were spread across dozens of single-purpose sites, many of them cluttered or out of date. Testnook brings them together in one fast, clean place, with plain-English explanations of what each result means and what to do about it.</p>
<h2>How Testnook works</h2>
<p>Every test uses standard browser features such as the Gamepad API, Web Audio and the camera and microphone permissions built into your browser. All processing happens on your own device. We do not record, upload or store video, audio or anything you type into a test. You can read the details in our <a href="/privacy-policy/">privacy policy</a>.</p>
<h2>Our standards</h2>
<ul>
<li><strong>Accurate:</strong> each tool shows what your hardware actually reports, and we explain the limits of a browser test where they matter (for example, browsers cap some timing measurements).</li>
<li><strong>Useful:</strong> every test page includes how to use it, how to read the result and how to fix the most common problems.</li>
<li><strong>Honest:</strong> hearing and vision checks are for curiosity and screening only, never a medical diagnosis, and we say so on those pages.</li>
<li><strong>Free:</strong> the site is free to use and is supported by advertising on content pages, never inside the tests themselves.</li>
</ul>
<h2>Who runs Testnook</h2>
<p>Testnook was founded and is run by <a href="' . esc_url( TN_FOUNDER_URL ) . '" rel="noopener" target="_blank">' . esc_html( TN_FOUNDER_NAME ) . '</a>. Tools are tested on Windows, macOS, Android and iPhone in current versions of Chrome, Edge, Firefox and Safari before they go live, and are updated when browsers change.</p>
<h2>Get in touch</h2>
<p>Found a bug, a device that behaves oddly or a test you would like us to add? Email <a href="mailto:' . esc_attr( TN_CONTACT_EMAIL ) . '">' . esc_html( TN_CONTACT_EMAIL ) . '</a> or use the <a href="/contact/">contact page</a>. We read every message.</p>',
);
