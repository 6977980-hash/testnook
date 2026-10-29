<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'About Testnook',
	'seo_title'   => 'About Testnook: Free Browser-Based Hardware Tests',
	'description' => 'Testnook is a free set of browser-based tests for keyboards, mice, controllers, screens, speakers, microphones and cameras. Learn who runs it and why.',
	'updated'     => '2026-10-29',
	'body'        => '<p>Testnook is a free collection of hardware tests that run in your web browser. You can check a keyboard, mouse, game controller, monitor, speakers, headphones, microphone or webcam in a few seconds, without installing anything.</p>
<h2>Why we built it</h2>
<p>Most people only find out a device is faulty at the worst moment: a key fails in the middle of a game, a microphone is silent on an important call, or a new monitor turns out to have a dead pixel after the return window has closed. Good tests for these problems already existed, but they were spread across dozens of single-purpose sites, many of them cluttered or out of date. Testnook brings them together in one fast, clean place, with plain-English explanations of what each result means and what to do about it.</p>
<p>A search engine or an AI assistant can tell you what a dead pixel or stick drift is, but it cannot light up your screen, listen to your microphone or count your clicks. Testnook is built for that part: when you search for a test, you get a page that actually runs it on your own device, with the result explained next to it.</p>
<h2>How Testnook works</h2>
<p>Every test uses standard browser features such as the Gamepad API, Web Audio and the camera and microphone permissions built into your browser. All processing happens on your own device. We do not record, upload or store video, audio or anything you type into a test. The click speed, reaction time, typing, mouse accuracy and dead pixel tests share only the final score, anonymously, so we can show site averages; you can turn that off under each of those tools. You can read the details in our <a href="/privacy-policy/">privacy policy</a>.</p>
<h2>Our standards</h2>
<ul>
<li><strong>Accurate:</strong> each tool shows what your hardware actually reports, and we explain the limits of a browser test where they matter (for example, browsers cap some timing measurements).</li>
<li><strong>Useful:</strong> every test page includes how to use it, how to read the result and how to fix the most common problems.</li>
<li><strong>Honest:</strong> hearing and vision checks are for curiosity and screening only, never a medical diagnosis, and we say so on those pages.</li>
<li><strong>Free:</strong> the site is free to use and is supported by advertising on content pages, never inside the tests themselves.</li>
</ul>
<h2>Who runs Testnook</h2>
<p>Testnook was founded and is run by <a href="' . esc_url( TN_FOUNDER_URL ) . '" rel="noopener" target="_blank">' . esc_html( TN_FOUNDER_NAME ) . '</a>. ' . esc_html( TN_FOUNDER_BIO ) . '</p>
<p>Testnook is a one-person project with no medical staff. The hearing and vision pages are written from the published sources they cite and are not reviewed by an optometrist or audiologist, which is why they describe themselves as screening checks and point you to a professional for an actual diagnosis.</p>
<h2>How the tools are checked</h2>
<p>Before a tool goes live it is run by script in a desktop browser window and a phone-sized one: the tool has to give the expected result for known inputs (for example 60 clicks in 5 seconds must read 12.0 CPS), the page must load without errors and must not scroll sideways on a phone. Cameras, microphones, motion sensors and network answers are simulated in those runs, so for those tools we also rely on checks on a real phone or computer and on reports from readers, and we fix a page when a real device disagrees with it. The full method, tool family by tool family, and what a browser test cannot measure, is on <a href="/how-we-test/">How we test and check our tools</a>.</p>
<h2>Get in touch</h2>
<p>Found a bug, a device that behaves oddly or a test you would like us to add? Email <a href="mailto:' . esc_attr( TN_CONTACT_EMAIL ) . '">' . esc_html( TN_CONTACT_EMAIL ) . '</a> or use the <a href="/contact/">contact page</a>. We read every message.</p>',
);
