<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'What Is My User Agent?',
	'seo_title'      => 'What Is My User Agent? See, Copy & Parse Your UA String',
	'description'    => 'See your browser user agent string, copy it in one click and read it parsed into browser, engine, OS and device. Includes Client Hints and a user agent checker.',
	'intro'          => 'Your user agent is the line of text your browser sends to every website to say what it is. Here it is in full, ready to copy, with a plain-English breakdown, the newer User-Agent Client Hints, and a checker for any user agent you paste in.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'device-info' ),
	'scripts'        => array( 'device-info' ),
	'embed_height'   => 820,
	'tool'           => '<div class="tool-stage di-stage">
	<div class="di-hero"><small>Your user agent</small></div>
	<p class="di-ua" id="di-ua">Your user agent appears here. It needs JavaScript.</p>
	<div class="btn-row"><button type="button" class="btn btn-primary" id="di-copy-ua">Copy user agent</button></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Browser</span><span class="stat-value" data-di="browser">-</span></div>
		<div class="stat"><span class="stat-label">Engine</span><span class="stat-value" data-di="engine">-</span></div>
		<div class="stat"><span class="stat-label">Operating system</span><span class="stat-value" data-di="os">-</span></div>
		<div class="stat"><span class="stat-label">Device</span><span class="stat-value" data-di="device">-</span></div>
	</div>
	<h3 class="di-sub">User-Agent Client Hints</h3>
	<div class="di-hints" id="di-hints"><p class="di-muted">Loading...</p></div>
	<h3 class="di-sub">User agent checker</h3>
	<div class="di-parse"><input type="text" id="di-parse-in" placeholder="Paste any user agent string" autocomplete="off" autocapitalize="off" spellcheck="false" aria-label="User agent to check"><button type="button" class="btn" id="di-parse-btn">Check</button></div>
	<dl class="di-parse-out" id="di-parse-out" hidden></dl>
</div>
<p class="tool-status" id="di-status" aria-live="polite">Reading your user agent...</p>',
	'howto'          => array(
		'Open this page in the browser you want to check. Your user agent string appears at the top straight away.',
		'Press <strong>Copy user agent</strong> to put the exact string on the clipboard for a bug report or a developer.',
		'Read the boxes below it for the browser, rendering engine, operating system and device in plain words.',
		'To identify someone else\'s browser, paste their user agent into the <strong>user agent checker</strong> and press <strong>Check</strong>.',
	),
	'howto_title'    => 'How to find your user agent',
	'results'        => '<p>A typical user agent looks like this: <code>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36</code>. Read it in parts:</p>
<ul>
<li><strong>Mozilla/5.0</strong>: a leftover from the 1990s that every browser still sends. It means nothing today.</li>
<li><strong>(Windows NT 10.0; Win64; x64)</strong>: the operating system and CPU type. Windows 10 and 11 both say NT 10.0. Phones show something like <code>(Linux; Android 10; K)</code> or <code>(iPhone; CPU iPhone OS 18_0 like Mac OS X)</code>.</li>
<li><strong>AppleWebKit/537.36 (KHTML, like Gecko)</strong>: the engine family. Chrome, Edge and Opera use Blink, which grew out of WebKit, so they still say it.</li>
<li><strong>Chrome/130.0.0.0</strong>: the browser and its major version. Edge adds <code>Edg/</code>, Opera adds <code>OPR/</code>, Samsung adds <code>SamsungBrowser/</code>.</li>
<li><strong>Safari/537.36</strong>: another compatibility token that non-Safari browsers send so old sites do not block them.</li>
</ul>
<p>Since 2023 Chrome-based browsers send a <strong>reduced</strong> user agent: the minor version is always 0.0.0, Android always says "Android 10; K" and the model is hidden. The real details are in the Client Hints section, which only Chromium browsers support.</p>',
	'extra'          => array(
		array(
			'What a user agent is used for',
			'<p>Websites read the user agent to send a mobile or desktop layout, to warn about an outdated browser, to offer the right download (Windows, Mac or Android), and to count visitors by browser in analytics. Developers ask for it in bug reports because the same page can behave differently in Safari and Chrome. Crawlers such as Googlebot send their own user agent so sites can recognise them.</p>
<p>Because it is easy to change, a user agent proves nothing about who is visiting. Browser developer tools can switch it to any phone or browser, and some privacy extensions randomise it.</p>',
			'used-for',
		),
		array(
			'User agent vs Client Hints',
			'<p>The user agent string is sent with every request, whether the site needs it or not, and it grew so long and detailed that it helped track people. User-Agent Client Hints replace it in Chrome, Edge, Opera and Samsung Internet: the browser sends only the brand, major version, platform and whether it is mobile, and a site has to ask for more, such as the exact version, the phone model or the CPU architecture. Safari and Firefox do not support Client Hints and still rely on the classic string. The <a href="/device-info/">device info</a> page combines both into one list.</p>',
			'client-hints',
		),
	),
	'fixes'          => array(
		array( 'My Android phone says "Android 10; K"', 'That is the reduced user agent Chrome sends on every Android phone, whatever the real version. The Client Hints section shows the real Android version and model.' ),
		array( 'My iPad shows as a Mac', 'Safari on iPad asks for desktop websites by default and sends a Mac user agent. The page spots the touch screen and shows iPadOS anyway. To change it, open Settings > Apps > Safari > Request Desktop Website.' ),
		array( 'The user agent is wrong after I changed it', 'An extension or the developer tools may still be overriding it. Close the developer tools, disable user agent switcher extensions and reload.' ),
	),
	'faq'            => array(
		array( 'What is my user agent?', 'It is the string shown at the top of this page. It is unique to your browser and version, not to you, so millions of people share the same one.' ),
		array( 'How do I copy my user agent?', 'Press "Copy user agent" under the string, or tap and hold it to select it all and copy it.' ),
		array( 'Can I change my user agent?', 'Yes. In Chrome or Edge open the developer tools, then Network conditions, and untick "Use browser default". Firefox has the general.useragent.override setting in about:config. Mobile browsers have a "Desktop site" option that switches to a desktop user agent.' ),
		array( 'Does my user agent identify me?', 'Not on its own, since everyone on the same browser version sends the same string. Combined with many other details it can help fingerprint a device, which is why browsers now reduce it.' ),
		array( 'Why do all browsers say Mozilla and Safari?', 'For compatibility. Old websites only sent modern pages to browsers that claimed to be Mozilla or Safari, so every new browser copied those words.' ),
		array( 'Is my user agent stored by this page?', 'No. It is shown by your own browser and not sent anywhere or saved.' ),
	),
	'related'        => array( 'device-info', 'what-phone-do-i-have', 'refresh-rate-test', 'keyboard-tester', 'touch-screen-test', 'webcam-test' ),
	'updated'        => '2026-10-29',
);
