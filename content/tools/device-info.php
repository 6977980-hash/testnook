<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Device Info',
	'seo_title'      => 'Device Info: My Browser, OS, Screen, CPU & GPU Details',
	'description'    => 'Free device info page. See your browser, operating system, screen resolution, pixel ratio, CPU threads, RAM, GPU, network and battery, and copy it all.',
	'intro'          => 'Everything your browser can tell about this device, on one page: browser and version, operating system, device model where it is shared, screen size and pixel ratio, CPU threads, memory, graphics card, network and battery. Copy it all with one click for a support ticket.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'device-info' ),
	'scripts'        => array( 'device-info' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-stage di-stage">
	<div class="di-hero"><small>This device</small><strong data-di="device">Reading your device...</strong><span><span data-di="os">-</span> &middot; <span data-di="browser">-</span></span></div>
	<div class="di-table" id="di-table" data-di-groups="system,browser,screen,gpu,network,features"><p class="di-muted">Device details appear here once the page has loaded. They need JavaScript.</p></div>
</div>
<div class="btn-row"><button type="button" class="btn btn-primary" id="di-copy">Copy all device info</button><a class="btn" href="/what-is-my-user-agent/">See my user agent</a></div>
<p class="tool-status" id="di-status" aria-live="polite">Reading what your browser shares...</p>',
	'howto'          => array(
		'Open the page on the device you want to check. The details fill in automatically; there is nothing to install or allow.',
		'Read the <strong>Device and system</strong> group for the operating system, model, CPU threads, memory and battery.',
		'Check <strong>Screen</strong> for the resolution in CSS pixels and in real device pixels, the pixel ratio and an estimated refresh rate.',
		'Press <strong>Copy all device info</strong> to paste the full list into a support ticket, forum post or message.',
	),
	'howto_title'    => 'How to use the device info page',
	'results'        => '<p>Each value comes straight from a browser API, so it is what websites and web apps see, which is not always the full truth about the hardware.</p>
<ul>
<li><strong>Screen size (CSS pixels)</strong> is the size websites lay out for. Multiply it by the <strong>pixel ratio</strong> to get the real panel resolution: a phone with 393 x 852 at 3x has a 1179 x 2556 screen.</li>
<li><strong>CPU threads</strong> is the number of logical processors. A 6 core CPU with hyper-threading shows 12. Some browsers cap or round it for privacy.</li>
<li><strong>Memory</strong> is deliberately rough. Chrome reports 0.25 to 8 GB in steps and stops at 8, so a 32 GB PC shows "8 GB or more". Safari and Firefox do not report it at all.</li>
<li><strong>Graphics</strong> names the GPU the browser renders with. On a laptop with two GPUs it may name the integrated one; on Safari it may only say "Apple GPU".</li>
<li><strong>Model code</strong> appears only on Android in Chrome-based browsers. Apple never shares the iPhone model; the <a href="/what-phone-do-i-have/">what phone do I have</a> page narrows it down from the screen size.</li>
<li><strong>Refresh rate</strong> is measured from animation frames over one second, so it can read low on a busy or battery-saving device. The <a href="/refresh-rate-test/">refresh rate test</a> measures it properly.</li>
</ul>',
	'extra'          => array(
		array(
			'Why some values say "Not shared by the browser"',
			'<p>Browsers have been cutting back what they tell websites, because a long list of exact details can identify a person without cookies (this is called fingerprinting). Safari and Firefox share the least: no memory, no battery, no model, no network type. Chrome, Edge and Samsung Internet share more through <strong>User-Agent Client Hints</strong>, an API that gives details such as the Android model or the Windows version only when a page asks. A blank value is a privacy feature, not a fault in your device.</p>',
			'not-shared',
		),
		array(
			'When device info is useful',
			'<p>Support teams often ask "what browser and version are you on?" or "what is your screen resolution?". Copying this page answers all of it at once. It also helps when buying a used laptop or phone (check the CPU threads, RAM and GPU match the advert), when a game or web app says your browser is unsupported, or when you need your exact screen size for a wallpaper. For screen faults use the <a href="/dead-pixel-test/">dead pixel test</a>, and for a quick check of a phone\'s parts see the <a href="/phone/">phone tests</a>.</p>',
			'uses',
		),
	),
	'fixes'          => array(
		array( 'Windows 11 shows as "Windows 10 or 11"', 'Every browser reports Windows 10 and 11 with the same user agent. Chrome and Edge also send a client hint that tells them apart; Firefox does not, so it can only say "10 or 11". Check Settings > System > About.' ),
		array( 'Memory shows 8 GB but I have more', 'Browsers cap the value at 8 GB on purpose so that it cannot be used to identify you. Check the real amount in Task Manager on Windows, About This Mac on a Mac, or Settings > About phone.' ),
		array( 'The GPU shows the wrong graphics card', 'Laptops often run the browser on the integrated GPU to save power. In Windows Settings > System > Display > Graphics, set the browser to "High performance", restart it and reload the page.' ),
		array( 'The screen size is smaller than my monitor', 'Windows display scaling and browser zoom change the CSS size. At 150% scaling a 2560 x 1440 monitor shows as 1707 x 960 with a pixel ratio of 1.5. The device pixel line undoes the scaling.' ),
	),
	'faq'            => array(
		array( 'How do I find my device info?', 'Open this page on the device. It reads the browser, operating system, screen, CPU threads, memory, GPU and network straight away. On a phone you can also check Settings > About phone, or Settings > General > About on an iPhone.' ),
		array( 'Is any of my information sent or stored?', 'No. Everything is read and shown by your own browser. Nothing is uploaded, logged or saved by this page.' ),
		array( 'How can I find my screen resolution?', 'Look at "Screen resolution (device pixels)" in the Screen group. "Screen size (CSS pixels)" is the scaled size websites use.' ),
		array( 'Why does the page not show my phone model?', 'iPhones never share their model with websites, and on Android only Chrome-based browsers do. Use the <a href="/what-phone-do-i-have/">what phone do I have</a> page, or check the model in the phone\'s settings.' ),
		array( 'What is a user agent?', 'A short text your browser sends with every request, naming the browser, its version and the operating system. See and copy yours on the <a href="/what-is-my-user-agent/">what is my user agent</a> page.' ),
		array( 'Can device info tell my location or IP address?', 'This page does not look up your IP address or location. It only shows the time zone set on the device.' ),
	),
	'related'        => array( 'what-is-my-user-agent', 'what-phone-do-i-have', 'phone-sensor-test', 'battery-health-test', 'refresh-rate-test', 'touch-screen-test', 'dead-pixel-test', 'online-ruler' ),
	'updated'        => '2026-10-29',
);
