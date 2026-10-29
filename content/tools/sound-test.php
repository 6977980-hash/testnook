<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Sound Test',
	'seo_title'    => 'Sound Test: Test Your Speakers Online (Left, Right, Stereo)',
	'description'  => 'Free sound test for speakers and headphones. Play left, right and stereo test sounds, bass, mid and treble tones, a sweep and a music clip in your browser.',
	'intro'        => 'Check that your speakers or headphones work and that left and right are the right way round. Play channel checks, test tones, a frequency sweep and a short music clip, all generated in your browser.',
	'device'       => 'any',
	'ads'          => 'standard',
	'styles'       => array( 'sound-test' ),
	'scripts'      => array( 'sound-test' ),
	'embed_height' => 640,
	'tool'         => '<div class="tool-stage st-stage">
	<div class="st-group">
		<h3>Speaker channels</h3>
		<div class="st-channels">
			<button type="button" class="st-ch" data-st="left"><span class="st-ch-ico">&#9664;</span>Left speaker</button>
			<button type="button" class="st-ch" data-st="stereo"><span class="st-ch-ico">&#9664;&#9654;</span>Both (stereo)</button>
			<button type="button" class="st-ch" data-st="right"><span class="st-ch-ico">&#9654;</span>Right speaker</button>
		</div>
		<div class="st-vu"><div class="meter"><span id="st-vu-l"></span></div><div class="meter"><span id="st-vu-r"></span></div></div>
	</div>
	<div class="st-group">
		<h3>Test sounds</h3>
		<div class="btn-row">
			<button type="button" class="btn btn-sm" data-st="bass">Bass 60 Hz</button>
			<button type="button" class="btn btn-sm" data-st="mid">Mid 1 kHz</button>
			<button type="button" class="btn btn-sm" data-st="treble">Treble 8 kHz</button>
			<button type="button" class="btn btn-sm" data-st="sweep">Sweep 20 Hz-20 kHz</button>
			<button type="button" class="btn btn-sm" data-st="music">Music clip</button>
			<button type="button" class="btn btn-sm" data-st="noise">White noise</button>
			<button type="button" class="btn btn-sm" data-st="pan">Left &rarr; right pan</button>
		</div>
	</div>
	<div class="st-foot">
		<div class="field st-vol"><label for="st-volume">Volume <output id="st-volout" for="st-volume">50%</output></label><input type="range" id="st-volume" min="0" max="100" step="5" value="50"></div>
		<button type="button" class="btn" id="st-stop" disabled>Stop</button>
	</div>
</div>
<p class="tool-status" id="st-status" aria-live="polite">Set your device volume to a comfortable level, then press a button.</p>',
	'howto'        => array(
		'Turn your device volume to about half and unmute it. On a phone, turn off silent mode.',
		'Press <strong>Left speaker</strong>. You should hear a voice-like tone from the left only. Press <strong>Right speaker</strong> and check it comes from the right.',
		'Press <strong>Both</strong> to hear stereo. The sound should seem to come from the middle.',
		'Try the <strong>bass</strong>, <strong>mid</strong> and <strong>treble</strong> tones and the <strong>sweep</strong>. Small speakers may not play the lowest bass, which is normal.',
		'Play the <strong>music clip</strong> for a quick real-world check, and <strong>Stop</strong> when you are done.',
	),
	'howto_title'  => 'How to run the speaker test',
	'results'      => '<ul>
<li><strong>Nothing from one side:</strong> the speaker, cable or channel balance is faulty. See the fixes below.</li>
<li><strong>Left and right are swapped:</strong> your headphones are on backwards or the speakers are plugged into the wrong channels. Some sound settings also let you swap channels.</li>
<li><strong>Both buttons play from the middle:</strong> your output is set to mono. On Windows look for "Mono audio" in Settings > Accessibility > Audio; on iPhone and Mac it is under Accessibility too.</li>
<li><strong>Crackling, buzzing or rattling on the bass test:</strong> a damaged speaker cone, a loose grille, or simply volume too high for the speaker. Phone speakers often rattle below 100 Hz.</li>
<li><strong>Sweep goes quiet at the top:</strong> small speakers and most adults lose the very highest frequencies; that is normal. Use the <a href="/hearing-frequency-test/">hearing frequency test</a> for a proper check with headphones.</li>
</ul>',
	'extra'        => array(
		array(
			'What this sound test checks',
			'<p>This audio test covers the basics that break most often: whether any sound comes out at all, whether both channels work and are the right way round, and whether the speaker can reproduce low, middle and high frequencies without distortion. It works with laptop speakers, desktop speakers, a soundbar, a Bluetooth speaker, wired or wireless headphones and phone speakers. For headphones specifically, including a detailed left-right test and bass check, see the <a href="/headphone-test/">headphone test</a>.</p>
<p>Everything you hear is synthesised in your browser with Web Audio, so nothing is downloaded and there is no video to buffer. The level meters show the signal being sent to each channel, which helps you tell a silent speaker apart from a silent page.</p>',
			'what-it-checks',
		),
	),
	'fixes'        => array(
		array( 'No sound at all', 'Check the volume and mute on the device, in the browser tab (a muted tab shows a crossed speaker icon) and on the speakers themselves. On Windows click the speaker icon in the taskbar and pick the right output device; on a Mac use System Settings > Sound > Output. Bluetooth speakers must be connected, not just paired.' ),
		array( 'Only one speaker works', 'Push the cable all the way in: a half-inserted 3.5 mm jack plays one side only. Check the balance slider in your sound settings is centred. Try the speakers or headphones on another device to see if the fault follows them.' ),
		array( 'Sound is distorted or crackles', 'Lower the volume: distortion at high volume is normal for small speakers. Set the system "enhancements" or equaliser off, update the audio driver, and for USB or Bluetooth speakers try another port or re-pair.' ),
		array( 'Sound works here but not in a game or app', 'The app is using a different output device. Open the app\'s audio settings and select the same device that works in the browser. On Windows, Settings > System > Sound > Volume mixer lets you set the output per app.' ),
	),
	'faq'          => array(
		array( 'How do I test my speakers online?', 'Press Left speaker, Right speaker and Both. If you hear each one from the correct side, your speakers work. Then try the tones and music clip for quality.' ),
		array( 'How do I check left and right speakers?', 'Use the Left and Right buttons. The sound should come only from the named side. If it is reversed, swap the plugs or your headphones; if both sides play, your system is set to mono.' ),
		array( 'Why is there no sound in the browser?', 'Usually a muted tab, a muted device, or the wrong output selected in system sound settings. On iPhone, silent mode mutes web audio: flip the switch.' ),
		array( 'Why does the bass test sound weak?', 'Small speakers, especially in laptops and phones, cannot reproduce 60 Hz well. That is a physical limit, not a fault. Headphones and larger speakers will play it clearly.' ),
		array( 'Can I test surround sound or 5.1 here?', 'Browsers generally output two channels, so this page tests stereo only. For 5.1 or Dolby Atmos use the test built into your receiver or the Windows Sound settings "Test" button.' ),
		array( 'Does this work on phones?', 'Yes, on Android and iPhone. Phone speakers are often mono or have a weaker second speaker, so use headphones for the left-right check.' ),
	),
	'related'      => array( 'stereo-test', 'bass-test', 'headphone-test', 'speaker-cleaner', 'mic-test', 'tone-generator' ),
	'updated'      => '2026-10-28',
);
