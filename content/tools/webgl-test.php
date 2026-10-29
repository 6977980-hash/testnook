<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'WebGL Test',
	'seo_title'      => 'WebGL Test: Check WebGL, WebGPU & Your Graphics Card',
	'description'    => 'Free WebGL test. Check if WebGL 1, WebGL 2 and WebGPU work, see your graphics card and whether hardware acceleration is on, and run a quick GPU benchmark.',
	'intro'          => 'Check whether your browser can draw 3D graphics and which graphics card it uses. The page tests WebGL 1, WebGL 2 and WebGPU, names your GPU and the graphics API behind it, tells you if hardware acceleration is off, lists the limits and extensions, and runs a five second GPU benchmark.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'system' ),
	'scripts'        => array( 'webgl-test' ),
	'embed_height'   => 1050,
	'tool'           => '<div class="tool-stage sy-stage">
	<div class="sy-hero"><small>Your graphics</small><strong id="gl-name">Checking WebGL...</strong><span id="gl-sub">-</span></div>
	<div class="sy-verdict" id="gl-verdict"><strong>Checking...</strong><p>This needs JavaScript.</p></div>
	<dl class="sy-meta" id="gl-summary"></dl>
	<p class="sy-label">GPU benchmark</p>
	<canvas class="gl-canvas" id="gl-canvas" aria-label="Animated shader used for the GPU benchmark"></canvas>
	<div class="btn-row"><button type="button" class="btn btn-primary" id="gl-bench">Run benchmark</button><span class="sy-note" id="gl-live">About 5 seconds</span></div>
	<div id="gl-bench-wrap" hidden>
		<div class="stats">
			<div class="stat"><span class="stat-label">Score</span><span class="stat-value" id="gl-score">-</span></div>
			<div class="stat"><span class="stat-label">Passes per frame</span><span class="stat-value" id="gl-k">-</span></div>
			<div class="stat"><span class="stat-label">Frames per second</span><span class="stat-value" id="gl-fps">-</span></div>
			<div class="stat"><span class="stat-label">Shader steps / s</span><span class="stat-value" id="gl-thr">-</span></div>
		</div>
		<p class="sy-note">Level: <strong id="gl-tier">-</strong></p>
	</div>
	<div class="gl-tables">
		<div><p class="sy-label">WebGL limits</p><dl class="sy-meta" id="gl-limits"></dl></div>
		<div id="gl-gpu-wrap" hidden><p class="sy-label">WebGPU adapter</p><dl class="sy-meta" id="gl-gpu"></dl></div>
	</div>
	<details><summary>WebGL extensions (<span id="gl-ext-n">0</span>)</summary><ul class="gl-ext" id="gl-ext"></ul></details>
</div>
<p class="tool-status" id="gl-status" aria-live="polite">Reading your graphics details...</p>',
	'howto'          => array(
		'Open the page. The top box says straight away whether WebGL works and whether the browser uses your graphics card.',
		'Read <strong>Graphics card (GPU)</strong> and <strong>Graphics API used</strong>. On a laptop with two GPUs, this is the one the browser picked.',
		'Press <strong>Run benchmark</strong> and keep the tab in front for about five seconds. It finds how much drawing your GPU can do per frame and gives a score.',
		'Compare the score after changing a setting, such as turning on hardware acceleration or switching the browser to the high-performance GPU.',
	),
	'howto_title'    => 'How to test WebGL and your GPU',
	'results'        => '<ul>
<li><strong>WebGL 1 and 2</strong> let websites draw 3D: maps, product viewers, browser games and many online tools. WebGL 2 is supported by every current browser; if it says "Not supported", the browser has blocked the GPU.</li>
<li><strong>WebGPU</strong> is the newer, faster graphics and compute API used by modern 3D sites and AI tools that run in the browser. Chrome and Edge have it, Safari and Firefox are adding it.</li>
<li><strong>Hardware acceleration Off</strong> means the browser draws with the CPU (SwiftShader, llvmpipe or "Microsoft Basic Render Driver"). Everything works, but slowly: fix it with the steps below.</li>
<li><strong>Graphics API used</strong> is what the browser talks to under the hood: Direct3D 11 on Windows, Metal on Macs, Vulkan or OpenGL ES on Android and Linux.</li>
<li><strong>The score</strong> is shader steps per second, divided by ten million: the page draws a full-screen effect 256 steps deep per pixel, as many times per frame as the GPU can manage above 40 fps, so a fast GPU is not held back by your screen\'s refresh rate. Rough levels: under 300 is very slow or software rendering, 300 to 1,500 is older integrated graphics or a budget phone, 1,500 to 5,000 is modern integrated graphics or a good phone, 5,000 to 15,000 is a strong laptop GPU, Apple M chip or flagship phone, and over 15,000 is a gaming graphics card.</li>
</ul>',
	'extra'          => array(
		array(
			'Why the browser shows a different GPU or "Apple GPU"',
			'<p>Laptops with two graphics chips run the browser on the low-power integrated GPU by default to save battery, so the page may name Intel or AMD Radeon graphics even if you have an NVIDIA card. On Windows, open Settings > System > Display > Graphics, choose your browser, set it to <strong>High performance</strong> and restart it. Safari and Firefox sometimes report a generic name such as "Apple GPU" or "or similar" on purpose, to make it harder for sites to fingerprint you. The benchmark still measures the real chip.</p>',
			'wrong-gpu',
		),
		array(
			'How to turn on hardware acceleration',
			'<ul>
<li><strong>Chrome:</strong> Settings > System > turn on "Use graphics acceleration when available", then Relaunch. Check <code>chrome://gpu</code> for details.</li>
<li><strong>Edge:</strong> Settings > System and performance > turn on "Use graphics acceleration when available", then Restart.</li>
<li><strong>Firefox:</strong> Settings > General > Performance > untick "Use recommended performance settings" and tick "Use hardware acceleration when available", then restart.</li>
<li><strong>Safari:</strong> always on. If WebGL fails, update macOS or iOS.</li>
</ul>
<p>If it is on but the page still says software rendering, the browser has blocked your graphics driver as unstable. Update the driver from NVIDIA, AMD or Intel (or through Windows Update), restart, and test again.</p>',
			'hardware-acceleration',
		),
	),
	'fixes'          => array(
		array( 'WebGL is not supported', 'Update the browser, turn on hardware acceleration (see above) and update the graphics driver. Extensions that block fingerprinting, and some work or school policies, can switch WebGL off; try a private window with extensions disabled.' ),
		array( 'The benchmark score is much lower than expected', 'Plug a laptop into power and turn off battery saver, close other tabs and 3D apps, and set the browser to the high-performance GPU in Windows graphics settings. Check that hardware acceleration says On.' ),
		array( 'The screen flickers or the page freezes during the benchmark', 'The heavy load can expose an unstable driver or overheating. Update the graphics driver; if it keeps happening in games too, check the GPU temperature and fans.' ),
		array( 'WebGPU says not supported', 'WebGPU needs a recent Chrome or Edge on Windows, macOS, ChromeOS or Android, Safari 26 or newer, or a recent Firefox on Windows. Older GPUs and drivers are blocked.' ),
	),
	'faq'            => array(
		array( 'How do I know if WebGL is enabled?', 'Look at the box at the top. If it says WebGL works, it is enabled. If it says WebGL does not work, follow the steps for hardware acceleration and driver updates on this page.' ),
		array( 'What graphics card do I have?', 'The Graphics card line names the GPU your browser uses. On laptops with two GPUs it may be the integrated one. For the full list, open Device Manager > Display adapters on Windows or About This Mac on a Mac.' ),
		array( 'Is WebGL safe?', 'Yes. WebGL runs inside the browser\'s security sandbox and cannot read your files. Browsers block graphics drivers with known problems. Some privacy tools hide the GPU name because it helps fingerprint a device.' ),
		array( 'What is the difference between WebGL and WebGPU?', 'WebGL is based on OpenGL ES and has worked in browsers since 2011. WebGPU is newer, maps better to Direct3D 12, Metal and Vulkan, and adds general GPU computing, which is used for AI models running in the browser.' ),
		array( 'Can this test damage my GPU?', 'No. The benchmark runs for about five seconds at a load similar to a simple game. Graphics cards protect themselves from overheating.' ),
		array( 'Does WebGL use my GPU or CPU?', 'With hardware acceleration on, it uses the GPU. If the page says software rendering, the CPU is doing the drawing, which is many times slower.' ),
	),
	'related'        => array( 'fps-test', 'refresh-rate-test', 'device-info', 'what-is-my-browser', 'ufo-test', 'internet-speed-test', 'monitor-test', 'screen-resolution' ),
	'updated'        => '2026-10-29',
);
