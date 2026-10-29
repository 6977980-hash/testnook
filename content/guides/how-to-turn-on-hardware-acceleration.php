<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Turn On Hardware Acceleration in Your Browser',
	'seo_title'   => 'How to Turn On Hardware Acceleration in Chrome, Edge, Firefox',
	'description' => 'Turn on hardware (graphics) acceleration in Chrome, Edge, Firefox, Brave and Opera, check that the GPU is really used, and fix it when it stays off.',
	'blurb'       => 'Turn on graphics acceleration in every major browser and check that your GPU is really in use.',
	'hub'         => 'system',
	'tool'        => 'webgl-test',
	'tools'       => array( 'fps-test', 'what-is-my-browser', 'refresh-rate-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'When hardware acceleration is off, the browser draws everything with the processor instead of the graphics chip. Videos stutter, scrolling is jerky, 3D pages crawl and the fan spins up. It is usually one switch in the settings, but sometimes the browser turns it off by itself because of a driver problem. Here is where the switch is in each browser and how to check that it worked.',
	'summary'     => array(
		'<strong>Chrome, Edge and Brave:</strong> Settings &gt; System &gt; <strong>Use graphics acceleration when available</strong> (older versions say "hardware acceleration"), then Relaunch.',
		'<strong>Firefox:</strong> Settings &gt; General &gt; Performance, untick "Use recommended performance settings" and tick <strong>Use hardware acceleration when available</strong>, then restart.',
		'<strong>Safari</strong> has no switch; it always uses the GPU on a Mac, iPhone and iPad.',
		'Check with the <a href="/webgl-test/">WebGL test</a>: "Hardware acceleration: On" and your real graphics card name mean it worked. "Off (software rendering)" means it is still off.',
	),
	'sections'    => array(
		array(
			'Step 1: check whether it is on',
			'<p>Open the <a href="/webgl-test/">WebGL test</a>. It shows the graphics card the browser uses and a line that says whether hardware acceleration is on. If the renderer is named <strong>SwiftShader</strong>, <strong>llvmpipe</strong> or <strong>Microsoft Basic Render Driver</strong>, the browser is drawing with the processor in software, and acceleration is off or blocked. Its five second GPU benchmark gives you a number to compare before and after.</p>
<p>A second quick check is the <a href="/fps-test/">FPS test</a>: with acceleration off, animations often drop well below your screen\'s refresh rate even on a fast computer.</p>',
			'check',
		),
		array(
			'Step 2: turn it on in your browser',
			'<p><strong>Google Chrome</strong></p>
<ol>
<li>Open the menu (three dots) &gt; <strong>Settings</strong> &gt; <strong>System</strong>, or type <code>chrome://settings/system</code> in the address bar.</li>
<li>Turn on <strong>Use graphics acceleration when available</strong>. Older versions call it "Use hardware acceleration when available".</li>
<li>Click <strong>Relaunch</strong>. Chrome reopens your tabs.</li>
</ol>
<p><strong>Microsoft Edge:</strong> Settings &gt; <strong>System and performance</strong> &gt; turn on <strong>Use graphics acceleration when available</strong> &gt; Restart. Or type <code>edge://settings/system</code>.</p>
<p><strong>Brave and Opera:</strong> both are based on Chromium. Brave: Settings &gt; System. Opera: Settings &gt; Browser &gt; System. Turn on the graphics or hardware acceleration option and relaunch.</p>
<p><strong>Firefox:</strong> Settings &gt; <strong>General</strong> &gt; scroll to <strong>Performance</strong>, untick <strong>Use recommended performance settings</strong>, tick <strong>Use hardware acceleration when available</strong>, then close and reopen Firefox.</p>
<p><strong>Safari:</strong> there is nothing to switch on. If a page is slow in Safari, update macOS or iOS and check Low Power Mode, which limits graphics performance.</p>',
			'turn-on',
		),
		array(
			'Step 3: if it stays off',
			'<p>If the setting is on but the WebGL test still reports software rendering, the browser has decided your graphics driver is unsafe and blocked the GPU. Chrome and Edge show the reason on <code>chrome://gpu</code> or <code>edge://gpu</code>: look for lines that say "Software only" or "Hardware acceleration disabled" and the problem listed under them. Firefox shows it on <code>about:support</code> under Graphics.</p>
<ol>
<li><strong>Update the graphics driver</strong> from the maker of the chip (NVIDIA, AMD or Intel) or through Windows Update. Old drivers are the most common reason for a block.</li>
<li><strong>Pick the right GPU on laptops with two.</strong> In Windows: Settings &gt; System &gt; Display &gt; Graphics, choose the browser and set it to <strong>High performance</strong>. This makes it use the dedicated graphics card instead of the integrated one.</li>
<li><strong>Check remote sessions and virtual machines.</strong> Remote Desktop, some VPN clients and virtual machines hide the real GPU, so the browser falls back to software. Test on the computer itself.</li>
<li><strong>Turn off extensions</strong> that change graphics or privacy settings, or try a guest profile. Some anti-fingerprinting extensions hide or fake the graphics card.</li>
<li><strong>Reset the browser flags.</strong> If you changed anything on <code>chrome://flags</code>, click "Reset all" and relaunch.</li>
</ol>',
			'stays-off',
		),
		array(
			'Should hardware acceleration be on?',
			'<p>For almost everyone, yes. The graphics chip decodes video, draws pages and runs 3D far more efficiently than the processor, so pages are smoother and the battery lasts longer. The few reasons to turn it off are specific: a buggy driver that makes the browser flicker, show black boxes or crash, or screen-sharing tools that capture a black window. In those cases update the driver first; turning acceleration off is a workaround, not a fix.</p>
<p>Windows also has a separate setting called <strong>Hardware-accelerated GPU scheduling</strong> (Settings &gt; System &gt; Display &gt; Graphics &gt; Change default graphics settings). It changes how Windows hands work to the graphics card and has nothing to do with the browser switch above; leave it at its default unless a game asks for it.</p>',
			'should-it-be-on',
		),
	),
	'faq'         => array(
		array( 'What is hardware acceleration in a browser?', 'It lets the browser use the graphics chip (GPU) to draw pages, play video and run 3D content, instead of doing all of it on the main processor. It is on by default in every major browser.' ),
		array( 'Why is hardware acceleration grayed out or not working?', 'Usually the browser has blocked your graphics driver as unstable. Update the driver, relaunch the browser and check chrome://gpu or about:support for the reason.' ),
		array( 'Does hardware acceleration use more battery?', 'Normally less. Video and animation are cheaper on the GPU. On some laptops with two graphics chips, forcing the dedicated GPU for the browser uses more power than the integrated one.' ),
		array( 'Will turning it on improve my FPS in games?', 'No. The browser switch affects the browser only. Games always use the graphics card; their performance depends on the game settings and drivers.' ),
		array( 'How do I turn on hardware acceleration on Android?', 'Chrome on Android uses the GPU automatically and has no switch. If pages are slow, update Chrome and Android System WebView from the Play Store and turn off battery saver.' ),
		array( 'Is WebGL the same as hardware acceleration?', 'No, but WebGL is the easiest way to see it. WebGL is the browser\'s 3D graphics feature; with acceleration on it runs on your graphics card, with it off it runs slowly in software.' ),
	),
	'sources'     => array(
		array( 'Chromium: Debugging GPU related code (chrome://gpu and the GPU blocklist)', 'https://www.chromium.org/developers/how-tos/debugging-gpu-related-code/' ),
		array( 'Mozilla Support: Performance settings in Firefox', 'https://support.mozilla.org/kb/performance-settings' ),
		array( 'Microsoft DirectX blog: Hardware-accelerated GPU scheduling', 'https://devblogs.microsoft.com/directx/hardware-accelerated-gpu-scheduling/' ),
	),
	'ads'         => 'standard',
);
