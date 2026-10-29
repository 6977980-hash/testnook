<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'What Is My Browser?',
	'seo_title'      => 'What Is My Browser? Version, Updates & Supported Features',
	'description'    => 'See which browser and version you are using, whether it is up to date, its engine and operating system, and which of 47 web features it supports. Copy it all.',
	'intro'          => 'Find out exactly which browser you are using and whether it needs an update. The page shows the browser name and full version, the engine it runs on, your operating system, an up-to-date check against the current release, and a list of 47 web features with a tick or a cross, from WebGPU and passkeys to AV1 video.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'device-info', 'system' ),
	'scripts'        => array( 'device-info' ),
	'embed_height'   => 1000,
	'tool'           => '<div class="tool-stage di-stage">
	<div class="di-hero"><small>You are using</small><strong data-di="browser">Reading your browser...</strong><span>Version <span id="br-version">-</span> &middot; <span data-di="engine">-</span> engine &middot; <span data-di="os">-</span></span></div>
	<div class="sy-verdict" id="br-verdict"><strong>Checking for updates...</strong><p>If this message stays, JavaScript is turned off in this browser, and most websites will not work fully. Turn it on in the browser settings.</p></div>
	<div class="di-table" id="di-table" data-di-groups="browser,screen"><p class="di-muted">Browser details appear here once the page has loaded. They need JavaScript.</p></div>
	<p class="sy-label">Supported web features: <span id="br-score">-</span></p>
	<ul class="br-feats" id="br-feats"></ul>
</div>
<div class="btn-row"><button type="button" class="btn btn-primary" id="di-copy">Copy browser and device info</button><a class="btn" href="/what-is-my-user-agent/">See my user agent</a></div>
<p class="tool-status" id="di-status" aria-live="polite">Reading what your browser shares...</p>',
	'howto'          => array(
		'Open this page in the browser you want to check. The name and version appear at the top straight away.',
		'Read the <strong>update check</strong>. Green means the version is current or close to it; red means it is behind and missing security fixes.',
		'Scroll through <strong>Supported web features</strong> to see which modern features work, for example if a website says your browser is not supported.',
		'Press <strong>Copy browser and device info</strong> to paste everything into a support ticket.',
	),
	'howto_title'    => 'How to check your browser and version',
	'results'        => '<ul>
<li><strong>Browser and version</strong> come from the browser itself. Chrome, Edge and Opera on desktop and Android also share their exact build (such as 142.0.7444.60) through client hints; Safari and Firefox give the main version.</li>
<li><strong>Engine</strong> is the code that draws pages. <strong>Blink</strong> runs Chrome, Edge, Opera, Brave, Vivaldi and Samsung Internet; <strong>Gecko</strong> runs Firefox; <strong>WebKit</strong> runs Safari and every browser on iPhone and iPad, because Apple requires it there.</li>
<li><strong>The update check</strong> compares your version with the newest one, worked out from each browser\'s release schedule: Chrome and Firefox release a new main version about every four weeks, and Safari gets a new number each September. It allows for a version or two of lag, since updates roll out gradually.</li>
<li><strong>A cross in the feature list</strong> is not a fault. Some features exist only in some browsers (Web Bluetooth and WebUSB are Chromium-only), some need a newer version, and some are blocked by settings or by privacy modes.</li>
</ul>',
	'extra'          => array(
		array(
			'How to update your browser',
			'<ul>
<li><strong>Chrome:</strong> Menu (three dots) > Help > About Google Chrome. It downloads the update; press Relaunch.</li>
<li><strong>Microsoft Edge:</strong> Menu (three dots) > Help and feedback > About Microsoft Edge, then Restart.</li>
<li><strong>Firefox:</strong> Menu > Help > About Firefox. It checks and downloads; press Restart to update.</li>
<li><strong>Safari on a Mac:</strong> System Settings > General > Software Update. Safari updates come with macOS.</li>
<li><strong>Safari and every browser on iPhone or iPad:</strong> Settings > General > Software Update. The engine updates with iOS, even if you use Chrome there.</li>
<li><strong>Android browsers:</strong> Play Store > profile picture > Manage apps and device > Updates. Samsung Internet also updates from the Galaxy Store.</li>
</ul>
<p>Leaving the browser open for weeks can hold an update back; closing and reopening it finishes the install.</p>',
			'update',
		),
		array(
			'Why your browser matters',
			'<p>The browser is the program you use most, and it runs code from every site you open. Each new version fixes security holes that attackers already know about, so an out-of-date browser is one of the easiest ways for malware to get in. Updates also bring speed and new features: a site that says "your browser is not supported" usually needs a newer version, not a different browser. For a deeper look at the device itself, see <a href="/device-info/">device info</a>; for graphics support, the <a href="/webgl-test/">WebGL test</a>.</p>',
			'why',
		),
	),
	'fixes'          => array(
		array( 'A website says my browser is not supported', 'Update the browser first (see above). If it is current, the site may check the name rather than features; try Chrome, Edge or Firefox, or turn off "request desktop site" on a phone.' ),
		array( 'Chrome says it is up to date but this page says it is not', 'A managed work computer can hold Chrome on an older version, or the update is downloaded but waiting for a restart. Relaunch the browser and check again. Ask your IT team if it stays behind.' ),
		array( 'The page shows the wrong browser name', 'Some browsers copy Chrome\'s identity (Brave, Arc, Opera GX and others), and privacy extensions can change it. The engine and feature list are still accurate.' ),
		array( 'Many features show a cross', 'Old versions, private or "lockdown" modes, and strict privacy settings switch features off. Update the browser and try a normal window.' ),
	),
	'faq'            => array(
		array( 'What browser am I using?', 'The name at the top of this page is the browser you have open now, with its version. On iPhone and iPad, Chrome, Firefox and Edge all run on Safari\'s WebKit engine, so the engine line says WebKit.' ),
		array( 'How do I know if my browser is up to date?', 'Look at the update check box. It compares your version with the newest release of that browser. You can also open the browser\'s About page, which checks for updates directly.' ),
		array( 'What is the latest version of Chrome?', 'Chrome releases a new main version about every four weeks. The update check estimates the current number from that schedule; Chrome\'s About page always has the exact latest build.' ),
		array( 'Is JavaScript enabled in my browser?', 'If this page shows your browser name and the feature list, JavaScript is on. If it is off, the update box keeps saying so and most websites will not work properly.' ),
		array( 'What is the difference between a browser and a search engine?', 'The browser is the app (Chrome, Safari, Edge, Firefox). The search engine is a website you use inside it (Google, Bing, DuckDuckGo).' ),
		array( 'Is any of this information sent anywhere?', 'No. Everything is read by your own browser on this page and nothing is uploaded or stored.' ),
	),
	'related'        => array( 'what-is-my-user-agent', 'device-info', 'webgl-test', 'what-is-my-ip', 'internet-speed-test', 'webrtc-leak-test', 'screen-resolution', 'what-phone-do-i-have' ),
	'updated'        => '2026-10-29',
);
