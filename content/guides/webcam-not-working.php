<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Webcam Not Working? Fixes for Windows, Mac and Browsers',
	'seo_title'   => 'Webcam Not Working? Fix a Black or Missing Camera',
	'description' => 'Webcam black or missing in Zoom, Teams or your browser? Check the shutter, permissions, which app holds the camera and the driver, fastest cause first.',
	'blurb'       => 'Black screen, "camera not found" or no permission: the checks in the order that finds it fastest.',
	'hub'         => 'camera',
	'tool'        => 'webcam-test',
	'tools'       => array( 'camera-test', 'zoom-test', 'online-mirror', 'mic-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A webcam that shows black, says "no camera found" or works in one app but not another is usually blocked, not broken. These checks go from the most common cause to the least.',
	'summary'     => array(
		'<strong>Test in the browser first.</strong> If our webcam test shows a picture, the camera and driver are fine and the problem is in the app or its permission.',
		'The top three causes: a <strong>privacy shutter or key</strong> (F-key with a camera icon), <strong>another app holding the camera</strong>, and <strong>OS or browser permission</strong> turned off.',
		'On Windows, check Settings &gt; Privacy &amp; security &gt; Camera; on a Mac, System Settings &gt; Privacy &amp; Security &gt; Camera. The toggle for the specific app must be on.',
		'If no app and no browser can see the camera, reinstall the driver (Windows) or reset the camera service; an external camera that fails on two computers is faulty.',
	),
	'sections'    => array(
		array(
			'Step 1: see whether the camera works at all',
			'<p>Open the <a href="/webcam-test/">webcam test</a> in Chrome, Edge, Firefox or Safari and click Start. Allow the camera when the browser asks.</p>
<ul>
<li><strong>You see yourself:</strong> the camera, cable and driver all work. Your problem is in a specific app; jump to the app and permission steps.</li>
<li><strong>The browser asks, you allow, the picture is black:</strong> a shutter is closed, or another app has the camera open.</li>
<li><strong>"No camera found" or the camera is not listed:</strong> the operating system cannot see it. Go to the driver and hardware steps.</li>
<li><strong>The browser never asks:</strong> the site permission was denied earlier. Click the icon left of the address bar and set Camera to Allow, or check the browser\'s site settings.</li>
</ul>
<p>The test also lists the resolution and frame rate. A picture at 640x480 from a camera that should do 1080p usually means an old driver or a USB 2 port.</p>',
			'test-first',
		),
		array(
			'Step 2: privacy shutters, keys and switches',
			'<p>Modern laptops hide the camera in several ways, and all of them look exactly like a broken camera:</p>
<ul>
<li><strong>Sliding shutter:</strong> a tiny plastic slider over the lens. Lenovo, HP and many Dell models have one. Look closely at the lens; a shut shutter often shows as a small red or white dot.</li>
<li><strong>Camera key:</strong> an F-key with a crossed-out camera (F6 on many HP machines, F8 on some Lenovo, F10 on others). Press it with or without Fn. An LED near the camera or on the key may show the state.</li>
<li><strong>Physical kill switch:</strong> on the side of some business and privacy-focused laptops (Purism, some ThinkPads, Framework).</li>
<li><strong>BIOS setting:</strong> some business laptops can disable the camera in the BIOS; IT departments sometimes do this. Look under Security or Integrated Peripherals.</li>
<li><strong>External cameras:</strong> many have a lens cap or a rotating privacy cover; the Logitech Brio and C920 variants ship with one.</li>
</ul>',
			'shutters',
		),
		array(
			'Step 3: another app is using the camera',
			'<p>On Windows, and in most browsers, only one app can hold the camera at a time. If Teams is open in the background, Zoom gets a black picture, and vice versa. Browsers also count: a tab that used the camera earlier may still hold it.</p>
<ol>
<li>Close every meeting app (Zoom, Teams, Meet, Skype, Discord, OBS, Snap Camera and virtual camera tools) completely, including from the system tray on Windows or the menu bar on a Mac.</li>
<li>Close other browser tabs that might use the camera, or restart the browser.</li>
<li>On Windows 11 look for the camera icon in the taskbar tray; it shows which app is using the camera right now. Macs show a green dot by the camera when it is in use.</li>
<li>If nothing is visibly open, restart the computer; a crashed app can keep the camera handle.</li>
</ol>',
			'camera-in-use',
		),
		array(
			'Step 4: operating system and browser permissions',
			'<h3>Windows 10 and 11</h3>
<p>Settings &gt; Privacy &amp; security &gt; Camera. "Camera access" must be on, "Let apps access your camera" must be on, and the switch next to the app you are using must be on. Desktop apps (Zoom, Chrome, OBS) are grouped under "Let desktop apps access your camera" at the bottom; that switch must be on too. On a work laptop, a greyed-out setting means a policy set by your IT team.</p>
<h3>macOS</h3>
<p>System Settings &gt; Privacy &amp; Security &gt; Camera. Turn on the app. If the app is not in the list it has never asked; quit it fully and open it again. Screen recording and meeting apps may also need Microphone and Screen Recording permission here.</p>
<h3>Browsers</h3>
<p>Click the lock or tune icon left of the address bar, find Camera and set it to Allow, then reload the page. In Chrome and Edge: Settings &gt; Privacy and security &gt; Site settings &gt; Camera, which also lists sites you have blocked and lets you pick the default camera. In Safari: Safari &gt; Settings &gt; Websites &gt; Camera. Camera access requires HTTPS; a page on plain http:// cannot get it at all.</p>
<h3>Phones</h3>
<p>iPhone: Settings &gt; Privacy &amp; Security &gt; Camera, and the browser must be on. Android: Settings &gt; Apps &gt; the browser &gt; Permissions &gt; Camera. The <a href="/camera-test/">camera test</a> lets you switch between front and back cameras to confirm each works.</p>',
			'permissions',
		),
		array(
			'Step 5: drivers, USB and the camera service',
			'<h3>Windows</h3>
<ol>
<li>Open Device Manager (right-click Start). Look under <strong>Cameras</strong>, <strong>Imaging devices</strong> or <strong>Sound, video and game controllers</strong>.</li>
<li>No camera listed at all: for a built-in camera, check for a shutter or key (step 2), then update the chipset and camera driver from the laptop maker\'s support site. For an external camera, try another USB port directly on the computer, not a hub, and another cable if it is detachable.</li>
<li>Camera listed with a yellow triangle or a down arrow: right-click &gt; Enable device, or Uninstall device (tick "delete driver" if offered) and restart; Windows installs a fresh driver.</li>
<li>Camera listed and healthy but black in every app: Settings &gt; Apps &gt; Installed apps &gt; Camera &gt; Advanced options &gt; Reset, then test in the Camera app. If Windows Hello face login still works, the hardware is fine.</li>
<li>A recent Windows update broke it: Device Manager &gt; the camera &gt; Properties &gt; Driver &gt; Roll Back Driver.</li>
</ol>
<h3>macOS</h3>
<p>Built-in cameras have no driver to reinstall. If no app sees the camera, quit all apps and run <code>sudo killall VDCAssistant</code> and <code>sudo killall AppleCameraAssistant</code> in Terminal, or simply restart. A camera that is still missing in About This Mac &gt; System Report &gt; Camera is a hardware fault (often the cable through the hinge on older MacBooks).</p>
<h3>External cameras</h3>
<p>Try the camera on a second computer or a phone with a USB-C adapter. If it fails there too, the camera or its cable is dead. Many external cameras also need a USB 3 port or a short cable for 1080p at 30 fps; a long or thin cable gives a black picture or a low frame rate.</p>',
			'drivers',
		),
		array(
			'Picture problems that are not a dead camera',
			'<ul>
<li><strong>Dark or grainy picture:</strong> not enough light, not a fault. Put a lamp in front of you, not behind. The <a href="/zoom-test/">Zoom test</a> measures face lighting against the background.</li>
<li><strong>Flicker or rolling bands:</strong> the camera\'s anti-flicker setting does not match your mains frequency. Set 50 Hz (Europe, Asia, most of the world) or 60 Hz (Americas) in the camera or meeting app settings.</li>
<li><strong>Blurry:</strong> fingerprint on the lens, or the autofocus hunting. Wipe the lens; turn autofocus off in the camera software if it keeps pulsing.</li>
<li><strong>Low frame rate or lag:</strong> a USB hub, a long cable, or a busy CPU. Close the browser tabs you do not need; plug the camera straight into the computer.</li>
<li><strong>Picture mirrored:</strong> normal. Most apps mirror your own preview so it feels like a mirror; the other side sees you the right way round.</li>
</ul>',
			'picture-problems',
		),
	),
	'faq'         => array(
		array( 'Why is my webcam showing a black screen?', 'In most cases a privacy shutter or camera key is closed, or another app already holds the camera. Check the lens for a slider, press the camera F-key, close every meeting app and browser tab that could be using the camera, then try again.' ),
		array( 'Why does my camera work in the browser but not in Zoom or Teams?', 'The operating system has not given that app permission. On Windows, Settings > Privacy & security > Camera; on a Mac, System Settings > Privacy & Security > Camera. Also make sure the app has the right camera selected in its own video settings.' ),
		array( 'Why does Chrome say the camera is blocked?', 'You denied the permission earlier. Click the icon on the left of the address bar, set Camera to Allow and reload. In Chrome settings under Site settings > Camera you can also clear blocked sites and pick the default camera.' ),
		array( 'How do I know if my laptop camera is broken?', 'If no shutter is closed, the camera does not appear in Device Manager (Windows) or System Report (Mac) after a restart and a driver reinstall, and the camera also fails in the BIOS diagnostics if your laptop has them, the camera or its cable is faulty. On most laptops the camera module is replaceable for a modest cost.' ),
		array( 'Can a Windows update break the webcam?', 'Yes, usually through a driver change. Roll back the camera driver in Device Manager, or download the camera driver from the laptop maker. The Windows Camera app with "Reset" under its advanced options fixes some cases too.' ),
		array( 'Does an external webcam need drivers?', 'Almost all use the standard UVC driver built into Windows, macOS, Linux and ChromeOS, so no. Manufacturer software adds settings such as zoom and exposure but is optional.' ),
	),
);
