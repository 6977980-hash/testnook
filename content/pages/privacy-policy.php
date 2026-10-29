<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Privacy Policy',
	'seo_title'   => 'Privacy Policy | Testnook',
	'description' => 'How Testnook handles your data: camera, microphone and input tests run on your device and are never uploaded. Details on cookies, ads and analytics.',
	'updated'     => '2026-10-29',
	'body'        => '<p>This policy explains what information testnook.com ("Testnook", "we", "us") collects and how it is used. The short version: <strong>the tests run on your device, and we never see your camera, microphone or anything you type into a test.</strong> A few tools share your final score anonymously so we can show site averages, and you can turn that off.</p>
<h2>Camera, microphone and input tests</h2>
<p>When a test needs your camera or microphone, your browser asks for your permission. The video and audio are processed only inside your browser on your own device. They are never sent to our servers or to anyone else, and they are not stored. If a test lets you make a short recording for playback, the recording is kept in your browser\'s memory and is deleted when you leave or reload the page.</p>
<p>Keyboard, mouse, controller, touch and sensor tests also run locally. The keys you press and the movements you make are not sent anywhere.</p>
<h2 id="results">Anonymous test results and site statistics</h2>
<p>On the click speed (CPS), reaction time, typing, mouse accuracy and dead pixel tests, your <strong>final score</strong> is sent to our server when a test ends, so that we can show how people score on average and tell you how your result compares. What is stored is the name of the test, the score (for example 6.8 clicks per second, 245 ms, 62 words per minute with 97% accuracy, or the area of the screen where you reported a bad pixel), whether the score passed our checks, and the date. We do not store your IP address, the time of day, your browser or device details, the text you typed, your clicks or anything else with the score, so a stored result cannot be linked back to you.</p>
<p>To stop abuse we keep a hashed form of your IP address for up to one hour, in a counter that limits how many results one connection can send. The hash changes every day and is never stored with a result. Results older than 400 days are reduced to monthly totals and deleted.</p>
<p>You can turn score sharing off with the <strong>Turn off</strong> link under any of these tools. The choice is saved in your browser\'s local storage and applies to every tool on this site until you turn it back on. Tools embedded on other websites never send results.</p>
<h2>Information collected automatically</h2>
<p>Like almost every website, our hosting provider (Hostinger) keeps standard server logs, which include your IP address, browser type, the page requested and the time of the request. These logs are used for security and to keep the site running, and are deleted on a rolling basis.</p>
<h2>Cookies and local storage</h2>
<p>We store a small setting in your browser\'s local storage to remember whether you prefer light or dark mode. Some tools may also remember your own settings, such as screen calibration for the online ruler, your personal best scores and whether you turned score sharing off, in the same way. This data stays on your device.</p>
<h2>Analytics</h2>
<p>We may use Google Analytics and Microsoft Clarity to understand which pages are used and how the site performs. These services use cookies or similar technologies to collect information such as pages visited, approximate location, device type and how you interact with pages. This information is aggregated and does not identify you personally to us. You can learn more in <a href="https://policies.google.com/technologies/partner-sites" rel="noopener" target="_blank">how Google uses information from sites that use its services</a> and the <a href="https://privacy.microsoft.com/privacystatement" rel="noopener" target="_blank">Microsoft privacy statement</a>.</p>
<h2>Advertising</h2>
<p>Testnook is free because it is supported by advertising. We may use Google AdSense to show ads.</p>
<ul>
<li>Third-party vendors, including Google, use cookies to serve ads based on your prior visits to this website or other websites.</li>
<li>Google\'s use of advertising cookies enables it and its partners to serve ads to you based on your visits to this site and/or other sites on the internet.</li>
<li>You may opt out of personalised advertising by visiting <a href="https://adssettings.google.com/" rel="noopener" target="_blank">Google Ads Settings</a>. You can also opt out of some third-party vendors\' use of cookies for personalised advertising at <a href="https://www.aboutads.info/choices/" rel="noopener" target="_blank">www.aboutads.info</a>.</li>
</ul>
<p>Visitors in the European Economic Area, the UK and Switzerland are shown a consent message before personalised ads or analytics cookies are used, and can change their choice at any time.</p>
<h2>Children</h2>
<p>Testnook is a general audience site and is not directed at children under 13. We do not knowingly collect personal information from children.</p>
<h2>Your rights</h2>
<p>Depending on where you live, you may have the right to access, correct or delete personal data held about you, or to object to its use. Because the tests do not send personal data to us, we usually hold nothing beyond standard server logs, anonymous test scores that cannot be linked to you, and any email you send us. To make a request, contact us at the address below.</p>
<h2>Emails you send us</h2>
<p>If you email us, we use your address and message only to reply and to improve the site. We do not sell or share it.</p>
<h2>Changes to this policy</h2>
<p>We will update this page when our practices change. The date at the top shows the latest version.</p>
<h2>Contact</h2>
<p>Questions about privacy: <a href="mailto:' . esc_attr( TN_CONTACT_EMAIL ) . '">' . esc_html( TN_CONTACT_EMAIL ) . '</a>. Testnook is run by ' . esc_html( TN_FOUNDER_NAME ) . '.</p>',
);
