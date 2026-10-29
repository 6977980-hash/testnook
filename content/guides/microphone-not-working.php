<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Microphone Not Working? Fixes for Windows, Mac and Browsers',
	'seo_title'   => 'Microphone Not Working: Fix No Sound, Low Volume and Static',
	'description' => 'Microphone not working or too quiet? Test the level in your browser, then fix the input device, mutes, permissions, input volume, drivers and headset wiring.',
	'blurb'       => 'No sound, too quiet or static: check the level, then the device, mute, permission and volume.',
	'hub'         => 'audio',
	'tool'        => 'mic-test',
	'tools'       => array( 'voice-recorder', 'zoom-test', 'headphone-test', 'webcam-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A microphone that nobody can hear is rarely broken. It is usually the wrong device, muted somewhere, or blocked by a permission. These steps find which, from the most common cause down.',
	'summary'     => array(
		'<strong>Test the level first.</strong> If our mic test shows the bar moving and plays your voice back, the microphone works and the fault is in one app.',
		'The usual suspects: the <strong>wrong input device</strong> selected (a webcam mic, a disconnected headset, "Stereo Mix"), a <strong>mute switch</strong> on the headset or cable, and the <strong>OS permission</strong> for that app turned off.',
		'Quiet mic: raise <strong>input volume</strong> to 80 to 100 and enable mic boost where offered; turn off "exclusive mode" and extra enhancements if the sound cuts out.',
		'Static or hum: a loose 3.5 mm plug, a TRRS/TRS mismatch, or a USB power problem. A mic that is silent on two computers is faulty.',
	),
	'sections'    => array(
		array(
			'Step 1: measure the microphone',
			'<p>Open the <a href="/mic-test/">mic test</a>, click Start and allow the microphone. Talk at a normal volume.</p>
<ul>
<li><strong>The level bar moves and the playback sounds like you:</strong> the mic, cable and driver are fine. The problem is in a particular app or its device choice; go to the app step.</li>
<li><strong>The bar barely moves:</strong> the input volume is low, the mic is far away, or the wrong mic is selected (for example a laptop\'s built-in mic instead of your headset). Pick another device in the test\'s device list.</li>
<li><strong>The bar is flat at zero:</strong> muted, blocked by a permission, or the device is not connected. Continue below.</li>
<li><strong>The browser never asks for permission:</strong> it was denied before. Click the icon left of the address bar and set Microphone to Allow.</li>
</ul>
<p>The device list in the test is the same list your meeting apps see. If your headset is missing from it, the operating system does not see it either.</p>',
			'measure',
		),
		array(
			'Step 2: the right device, and nothing muted',
			'<h3>Pick the right input</h3>
<p>Computers often have three or four inputs: the built-in mic, a webcam mic, a headset, and a virtual device such as "Stereo Mix" or a streaming tool. Apps do not always follow the system default.</p>
<ul>
<li><strong>Windows:</strong> Settings &gt; System &gt; Sound &gt; Input. Choose the device and watch the "Test your microphone" bar. Also check Settings &gt; System &gt; Sound &gt; Volume mixer, where each app can have its own input device.</li>
<li><strong>Mac:</strong> System Settings &gt; Sound &gt; Input. Choose the device and watch the input level.</li>
<li><strong>In the app:</strong> Zoom, Teams, Meet and Discord all have their own microphone selector in audio settings. Set it to the specific device, not "Default", if the default keeps changing.</li>
</ul>
<h3>Find every mute</h3>
<ul>
<li>Headset mute: a button on the ear cup, a switch on the inline remote, or a boom that mutes when flipped up.</li>
<li>Keyboard mute: an F-key with a crossed-out microphone on many laptops, with an LED on the key.</li>
<li>App mute: the microphone icon in the meeting, and in Discord the per-server mute.</li>
<li>Windows: the microphone can be muted in Settings &gt; System &gt; Sound &gt; Input &gt; device properties, and separately for each app in the Volume mixer.</li>
</ul>',
			'device-mute',
		),
		array(
			'Step 3: permissions',
			'<p><strong>Windows 10 and 11:</strong> Settings &gt; Privacy &amp; security &gt; Microphone. "Microphone access" on, "Let apps access your microphone" on, the switch next to your app on, and "Let desktop apps access your microphone" on at the bottom (Zoom, Chrome, Discord and OBS count as desktop apps). A grayed-out switch means a company policy.</p>
<p><strong>macOS:</strong> System Settings &gt; Privacy &amp; Security &gt; Microphone. Turn the app on. If it is missing, quit it fully and open it again so it asks.</p>
<p><strong>Browsers:</strong> the lock or tune icon left of the address bar &gt; Microphone &gt; Allow, then reload. Chrome and Edge list blocked sites under Settings &gt; Privacy and security &gt; Site settings &gt; Microphone, where you can also choose the default device. Microphone access needs HTTPS.</p>
<p><strong>Phones:</strong> iPhone, Settings &gt; Privacy &amp; Security &gt; Microphone; Android, Settings &gt; Apps &gt; the app &gt; Permissions &gt; Microphone.</p>',
			'permissions',
		),
		array(
			'Step 4: too quiet, cutting out, or robotic',
			'<h3>Too quiet</h3>
<ol>
<li>Raise the input volume to 80 to 100 (Windows: Sound &gt; Input &gt; device properties; Mac: Sound &gt; Input level).</li>
<li>On Windows, some devices offer a <strong>Microphone Boost</strong> (+10 to +30 dB) under Properties &gt; Levels in the old Sound control panel (Control Panel &gt; Sound &gt; Recording).</li>
<li>Move the mic closer. A headset boom should sit two fingers from the corner of your mouth; a desk mic needs to be within 20 to 30 cm.</li>
<li>Check which capsule is active on a USB mic: many have a pickup pattern switch, and speaking into the wrong side of a side-address mic (Blue Yeti, AT2020 USB) sounds distant.</li>
</ol>
<h3>Cutting out or robotic</h3>
<ul>
<li>Turn off "Allow applications to take exclusive control" in the device\'s Advanced tab (Control Panel &gt; Sound &gt; Recording &gt; Properties).</li>
<li>Turn off audio enhancements and the manufacturer\'s noise-suppression effects one at a time; stacked noise suppression (Windows + Nvidia Broadcast + Discord) chops words.</li>
<li>For Bluetooth headsets: when the mic is in use, Bluetooth drops to the low-quality hands-free profile. Output sounds bad and the mic may lag. A wired or 2.4 GHz headset avoids it.</li>
<li>USB mics on a hub or a front port can drop out under load; plug straight into the computer.</li>
</ul>',
			'quiet-cutting-out',
		),
		array(
			'Step 5: drivers, the 3.5 mm jack, and hardware',
			'<h3>Windows drivers</h3>
<p>Device Manager &gt; Audio inputs and outputs. A device with a yellow triangle or missing: right-click &gt; Uninstall device and restart, or download the audio driver (Realtek, Conexant, Cirrus) from the laptop maker. Settings &gt; System &gt; Troubleshoot &gt; Other troubleshooters &gt; Recording Audio also fixes muted or disabled devices automatically.</p>
<h3>The 3.5 mm jack</h3>
<ul>
<li>A laptop with <strong>one combined jack</strong> needs a headset with a 4-pole (TRRS) plug. A gaming headset with two plugs (pink mic, green headphone) needs a splitter in reverse: a Y adapter that combines them into TRRS.</li>
<li>Desktops: the mic goes in the <strong>pink</strong> jack. Front-panel jacks fail more often than rear ones; try the rear.</li>
<li>Push the plug in fully; half-inserted plugs give static or one-sided audio.</li>
<li>Apple-style TRRS headsets and some Android ones use different wiring standards (CTIA and OMTP). Most modern devices are CTIA; an old OMTP headset will not work without an adapter.</li>
</ul>
<h3>Is it the hardware?</h3>
<p>Try the microphone on another computer or a phone. A mic that is silent in our test on two devices, with the right permissions, is faulty. For built-in laptop mics that is usually the small flex cable near the screen; for headsets it is the cable at the plug or the boom hinge.</p>',
			'drivers-jack',
		),
	),
	'faq'         => array(
		array( 'Why can nobody hear me on Zoom or Teams even though the mic works elsewhere?', 'The app is using a different input device or the OS has not given it microphone permission. In the app\'s audio settings choose your microphone by name, then check Settings > Privacy & security > Microphone (Windows) or System Settings > Privacy & Security > Microphone (Mac).' ),
		array( 'Why is my microphone so quiet?', 'Low input volume, the mic too far away, or the wrong mic selected. Set the input level to 80 to 100, enable Microphone Boost if your device has it, and bring the mic within a hand\'s width of your mouth.' ),
		array( 'Why does my headset mic not work on my laptop?', 'Most laptops have one combined jack that needs a 4-pole TRRS plug. A headset with separate pink and green plugs needs a TRRS combiner adapter. USB headsets avoid the issue.' ),
		array( 'Why does my mic sound robotic or cut out?', 'Usually stacked noise suppression, exclusive mode, a Bluetooth headset switching to its hands-free profile, or a USB hub. Turn off enhancements one at a time, disable exclusive mode, and connect USB mics directly.' ),
		array( 'How do I test my microphone?', 'Open the mic test on this site, allow the microphone, and speak. You see the live level, can record five seconds and play it back, and can switch between devices to find the one that is working.' ),
		array( 'Why does my microphone pick up static or hum?', 'A loose or dirty 3.5 mm plug, a ground loop with a desktop PC, or interference from a phone or charger near the cable. Reseat the plug, try the rear jack, move chargers away, and for USB mics try a different port.' ),
	),
);
