<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'How We Test and Check Our Tools',
	'seo_title'   => 'How We Test and Check Our Tools | Testnook',
	'description' => 'How every Testnook tool is checked before it goes live, which browsers and screen sizes it runs on, and what a browser test can and cannot measure.',
	'updated'     => '2026-10-29',
	'body'        => '<p>Every tool on Testnook reads what your browser reports through standard web features, then explains it. This page says how we check that the tools report the right thing, which parts are simulated in those checks, and where a browser test reaches its limit. If a result on your device looks wrong, <a href="/contact/">tell us</a>: real devices are the best test we have.</p>

<h2 id="release-checks">Checks every release goes through</h2>
<ul>
<li><strong>Scripted runs in a real browser engine.</strong> Each changed page is opened by script in a desktop window (1366 pixels wide) and a phone-sized window (375 pixels, the width of an iPhone 13). The page must load with no script errors, must not scroll sideways, its structured data must parse and every internal link on it must load.</li>
<li><strong>Known inputs, known answers.</strong> Each tool is driven with inputs whose answer we know in advance, for example 60 clicks in 5 seconds must read 12.0 CPS, a click 20 ms after the reaction screen turns green must be rejected as anticipation, and a 24 inch diagonal must convert to 60.96 cm with the same pixel density.</li>
<li><strong>Simulated hardware where a script cannot reach.</strong> A test browser has no real camera, microphone, motion sensor or game controller, so those runs use the browser\'s simulated devices or pre-recorded readings. That proves the page logic, not your hardware, which is why the tools in those families also depend on checks on real phones and computers and on reports from readers.</li>
<li><strong>Figures from named sources.</strong> Numbers in the guides (average reaction time, typing speed, CPS bands, internet speed needs) come from the studies and documents listed under Sources on each guide. When a figure comes from users of a typing or clicking site rather than a controlled study, we say so.</li>
</ul>

<h2 id="families">Tool by tool family</h2>
<div class="table-scroll"><table>
<thead><tr><th>Family</th><th>How it measures</th><th>What a browser cannot tell you</th></tr></thead>
<tbody>
<tr><td><a href="/keyboard/">Keyboard</a> and <a href="/mouse/">mouse</a></td><td>Key and pointer events with the timestamps the browser gives them; polling rate from the gap between coalesced mouse reports.</td><td>Keys that the operating system or keyboard software remaps or swallows (Fn, some media keys), and rollover beyond what the USB or Bluetooth report carries.</td></tr>
<tr><td><a href="/benchmark/">Click, reaction and typing benchmarks</a></td><td>High-resolution timers. Reaction clicks under 100 ms are rejected as anticipation; shared scores pass server checks (test length, single-use ticket, plausible range).</td><td>The delay your screen, mouse and browser add. A 60 Hz screen can add up to 16 ms to a reaction time, so compare scores on the same setup.</td></tr>
<tr><td><a href="/screen/">Screen and monitor</a></td><td>Full-screen colors and patterns; refresh rate from the browser\'s frame callbacks; sizes from your own calibration with a card or ruler.</td><td>Color accuracy and brightness need a colorimeter. The frame rate is capped by the browser (iPhone Safari draws near 60 fps by default). Physical sizes are only right after calibration.</td></tr>
<tr><td><a href="/audio/">Audio</a></td><td>Tones and channel tests generated with Web Audio; the mic test reads the live input level.</td><td>A speaker\'s real frequency response (it needs a measurement microphone). The hearing test is a screening check with your own headphones, not an audiogram.</td></tr>
<tr><td><a href="/camera/">Camera</a></td><td>The resolution and frame rate the browser actually negotiates with the camera.</td><td>The sensor\'s full photo resolution: browsers stream video at a lower resolution than the camera app takes photos.</td></tr>
<tr><td><a href="/controller/">Controllers</a></td><td>The Gamepad API: buttons, triggers and stick positions as the controller reports them, and vibration where the browser supports it.</td><td>Vibration works in Chrome and Edge only. Some controllers need Steam or a driver before the browser sees them at all.</td></tr>
<tr><td><a href="/phone/">Phone sensors</a></td><td>Motion, orientation, light and location events from the browser, after the permission prompt on iPhone.</td><td>Axis signs and compass headings differ between iPhone and Android; light and proximity sensors are hidden by most browsers.</td></tr>
<tr><td><a href="/system/">Network and system</a></td><td>Requests from your browser straight to Cloudflare, ipify, rdap.org and public DNS services; nothing passes through Testnook.</td><td>Speed and ping depend on the nearest Cloudflare server and on what else uses your connection at that moment. Browser and phone model detection is an estimate.</td></tr>
<tr><td><a href="/vision-test/">Vision</a> and hearing</td><td>Charts, plates and tones based on the published test they name, with distance and brightness instructions.</td><td>A diagnosis. Screens vary in color and brightness, so these are screening checks; see an optometrist or audiologist for an exam.</td></tr>
</tbody>
</table></div>

<h2 id="browsers">Browsers and devices</h2>
<p>The scripted runs use the Chromium engine (the base of Chrome and Edge) at desktop and phone sizes. Firefox and Safari behave differently in a few places that matter here: Safari on iPhone asks for permission before motion sensors work and caps page drawing near 60 fps, Firefox has no vibration for controllers, and only Chrome and Edge report battery health. Each tool page names the browser limits that apply to it in its "Common problems and fixes" section.</p>

<h2 id="corrections">Corrections</h2>
<p>When a reader reports that a tool gives a wrong answer on their device, we try to reproduce it, fix the page or the explanation, and change the "Last updated" date. Email <a href="mailto:' . esc_attr( TN_CONTACT_EMAIL ) . '">' . esc_html( TN_CONTACT_EMAIL ) . '</a> with the page address, your device and browser, and what you saw. Who runs the site is on the <a href="/about/">About page</a>.</p>',
);
