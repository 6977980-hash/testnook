<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Mic Test',
	'seo_title'      => 'Mic Test: Check Your Microphone Online (Free, Private)',
	'description'    => 'Free online mic test. See your microphone level live, view the waveform and spectrum, record a short sample and play it back to hear how you sound. Private.',
	'intro'          => 'Check that your microphone works before a call, stream or recording. Press start, speak, and watch the level meter move. Record a short sample to hear exactly how you sound to others.',
	'device'         => 'media',
	'device_message' => 'Your browser cannot access microphones. Open this page in an up-to-date Chrome, Edge, Firefox or Safari over HTTPS.',
	'ads'            => 'standard',
	'styles'         => array( 'mic-test' ),
	'scripts'        => array( 'mic-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-bar">
	<button type="button" class="btn btn-primary" id="mc-start">Start microphone</button>
	<label class="visually-hidden" for="mc-device">Microphone</label>
	<select id="mc-device" class="mc-select" hidden></select>
</div>
<div class="tool-stage mc-stage">
	<div class="mc-level"><div class="meter"><span id="mc-meter"></span></div><div class="mc-peak" id="mc-peak"></div></div>
	<div class="mc-scale"><span>-60 dB</span><span>-40</span><span>-20</span><span>-6</span><span>0</span></div>
	<canvas id="mc-scope" class="mc-scope" aria-label="Live waveform of your microphone"></canvas>
	<div class="seg mc-view" role="group" aria-label="View">
		<button type="button" data-mc-view="wave" aria-pressed="true">Waveform</button>
		<button type="button" data-mc-view="spectrum" aria-pressed="false">Spectrum</button>
	</div>
	<div class="mc-opts">
		<label><input type="checkbox" id="mc-ec" checked> Echo cancellation</label>
		<label><input type="checkbox" id="mc-ns" checked> Noise suppression</label>
		<label><input type="checkbox" id="mc-agc" checked> Auto gain</label>
	</div>
	<div class="mc-rec">
		<button type="button" class="btn" id="mc-rec" disabled>Record sample</button>
		<label class="visually-hidden" for="mc-len">Length</label>
		<select id="mc-len"><option value="5">5 seconds</option><option value="10" selected>10 seconds</option><option value="20">20 seconds</option></select>
		<audio id="mc-player" controls hidden></audio>
		<a class="btn btn-sm" id="mc-dl" href="#" hidden>Download</a>
	</div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Level</span><span class="stat-value" id="mc-db">-</span></div>
	<div class="stat"><span class="stat-label">Loudest peak</span><span class="stat-value" id="mc-peakv">-</span></div>
	<div class="stat"><span class="stat-label">Sample rate</span><span class="stat-value" id="mc-rate">-</span></div>
	<div class="stat"><span class="stat-label">Microphone</span><span class="stat-value mc-name" id="mc-name">-</span></div>
</div>
<p class="tool-status" id="mc-status" aria-live="polite"></p>',
	'howto'          => array(
		'Press <strong>Start microphone</strong> and choose <strong>Allow</strong> when the browser asks. Nothing is recorded until you press Record.',
		'Speak at a normal volume. The green meter should move with your voice and the waveform should wiggle. If you have several microphones, pick the right one from the list.',
		'Watch the <strong>Level</strong> number. Normal speech should land around -30 to -12 dB, with the meter in the green and only brief trips into orange.',
		'Press <strong>Record sample</strong>, talk for a few seconds and listen to the playback with headphones. This is how you sound on calls.',
		'Toggle <strong>Echo cancellation</strong>, <strong>Noise suppression</strong> and <strong>Auto gain</strong> to hear what the browser\'s processing does to your voice.',
	),
	'howto_title'    => 'How to test your microphone',
	'results'        => '<p>The meter shows the loudness of the signal reaching the page in decibels relative to full scale (dBFS). <strong>0 dB</strong> is the loudest a digital signal can be; everything else is negative.</p>
<ul>
<li><strong>Meter stays empty, Level shows -inf or below -60 dB:</strong> no signal. The microphone is muted, the wrong device is selected, or it is not plugged in. See the fixes below.</li>
<li><strong>Meter barely moves when you talk (quieter than -45 dB):</strong> the input gain is too low or you are too far from the microphone. Raise the input level in your system settings and move closer.</li>
<li><strong>Meter hits the red and the peak shows 0 dB:</strong> you are clipping, which sounds harsh and distorted. Lower the input gain or back away.</li>
<li><strong>Meter moves when you are silent:</strong> background noise, fan hum or electrical interference. Turn on noise suppression and listen to a recording to judge how bad it is.</li>
</ul>
<p>The <strong>spectrum</strong> view shows which frequencies your microphone picks up. Voice sits mostly between 100 Hz and 4 kHz; a tall bar at the far left while you are quiet is hum or rumble, and a hiss across the right side is noise.</p>',
	'extra'          => array(
		array(
			'Is this mic test private?',
			'<p>Yes. The audio goes from your microphone to the meter in your browser and nowhere else. Recordings are kept in your browser\'s memory only and disappear when you leave the page, unless you download them. You can remove the microphone permission any time from the icon in the address bar.</p>',
			'privacy',
		),
		array(
			'Test your mic for Zoom, Teams, Discord and streaming',
			'<p>If the microphone works here, it works in the browser, so a problem in a meeting app is almost always the app picking a different device or a muted input. Open the app\'s audio settings and select the same microphone that shows in the box above. For streaming and recording software (OBS, Audacity), turn off the browser-style processing (echo cancellation, noise suppression, auto gain) in the app if your voice sounds thin, or turn it on if you hear echo. Check your headphones or speakers too with the <a href="/headphone-test/">headphone test</a> or <a href="/sound-test/">sound test</a>.</p>',
			'apps',
		),
	),
	'fixes'          => array(
		array( 'Microphone permission blocked', 'Click the microphone or lock icon at the left of the address bar, set Microphone to Allow and reload. On Windows also check Settings > Privacy & security > Microphone, and on a Mac System Settings > Privacy & Security > Microphone, and make sure your browser is allowed.' ),
		array( 'Microphone not detected', 'Plug it in firmly; a 3.5 mm microphone needs the pink or the combined headset jack, not the headphone jack. For USB and Bluetooth microphones, try another port or pair again. On Windows, Settings > System > Sound > Input should list the device; if not, update the driver in Device Manager.' ),
		array( 'Mic is too quiet', 'Windows: Settings > System > Sound > Input > your device > Volume to 80-100%, and check "Microphone boost" under Advanced in the old Sound control panel. Mac: System Settings > Sound > Input > Input volume. Get closer: 10-20 cm from the microphone is ideal.' ),
		array( 'Mic picks up echo or background noise', 'Use headphones so the speakers are not heard by the microphone, turn on echo cancellation and noise suppression here and in your meeting app, and move the microphone away from fans. A headset microphone is much quieter than a laptop\'s built-in one.' ),
	),
	'faq'            => array(
		array( 'How do I test if my microphone is working?', 'Press Start microphone, allow access and speak. If the meter moves and the waveform reacts, your microphone works. Record a sample to hear the quality.' ),
		array( 'Why does the meter not move?', 'The microphone is muted (check the mute key or button on headsets), the wrong device is selected, or the input volume is at zero. Work through the fixes above.' ),
		array( 'What is a good mic level?', 'Normal speech between -30 and -12 dB with peaks that stay below -6 dB. If peaks hit 0 dB the sound clips and distorts.' ),
		array( 'Can I test my phone microphone here?', 'Yes. Open the page in Safari or Chrome on your phone, allow the microphone and speak. The recording lets you hear how calls sound to others.' ),
		array( 'Does this mic test record me?', 'Only when you press Record sample, and only into your browser\'s memory. Nothing is uploaded or saved unless you press Download.' ),
		array( 'Why do I sound different in the recording?', 'You normally hear your own voice through your head, which adds bass. The recording is what others hear. Browser processing such as noise suppression can also make it sound thinner.' ),
	),
	'related'        => array( 'voice-recorder', 'webcam-test', 'headphone-test', 'sound-test', 'online-mirror', 'speaker-cleaner' ),
	'updated'        => '2026-10-28',
);
