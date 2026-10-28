<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Headphone Test',
	'seo_title'    => 'Headphone Test: Left Right, Stereo and Bass Check Online',
	'description'  => 'Free online headphone test. Check left and right channels, stereo imaging, bass down to 20 Hz and polarity for wired, Bluetooth and wireless headphones.',
	'intro'        => 'Put on your headphones and check that the left and right sides are correct, that stereo sounds centred and that the bass goes deep. Every sound is generated in your browser, so it works on any device.',
	'device'       => 'any',
	'ads'          => 'standard',
	'styles'       => array( 'headphone-test' ),
	'scripts'      => array( 'headphone-test' ),
	'embed_height' => 760,
	'tool'         => '<div class="tool-stage hp-stage">
	<div class="hp-group">
		<h3>Left and right</h3>
		<p>Each sound should be heard only on the side it names.</p>
		<div class="hp-channels">
			<button type="button" class="hp-ch" data-hp="left"><span class="hp-ch-ico">&#9664;</span>Left ear</button>
			<button type="button" class="hp-ch" data-hp="centre"><span class="hp-ch-ico">&#9664;&#9654;</span>Both (centre)</button>
			<button type="button" class="hp-ch" data-hp="right"><span class="hp-ch-ico">&#9654;</span>Right ear</button>
		</div>
		<div class="hp-vu"><span>L</span><div class="meter"><span id="hp-vu-l"></span></div><span>R</span><div class="meter"><span id="hp-vu-r"></span></div></div>
		<div class="btn-row hp-pan"><button type="button" class="btn btn-sm" data-hp="pan">Left &harr; right pan</button></div>
	</div>
	<div class="hp-group">
		<h3>Bass</h3>
		<p>Good over-ear headphones play 30 Hz; small earbuds often fade below 50 Hz.</p>
		<div class="btn-row">
			<button type="button" class="btn btn-sm" data-hp="b30">30 Hz</button>
			<button type="button" class="btn btn-sm" data-hp="b50">50 Hz</button>
			<button type="button" class="btn btn-sm" data-hp="b80">80 Hz</button>
			<button type="button" class="btn btn-sm" data-hp="b120">120 Hz</button>
			<button type="button" class="btn btn-sm" data-hp="bsweep">Bass sweep 20-200 Hz</button>
		</div>
	</div>
	<div class="hp-group">
		<h3>Polarity (phase) and range</h3>
		<p>"In phase" should sound focused in the middle; "out of phase" should sound wide and vague.</p>
		<div class="btn-row">
			<button type="button" class="btn btn-sm" data-hp="inphase">In phase</button>
			<button type="button" class="btn btn-sm" data-hp="outphase">Out of phase</button>
			<button type="button" class="btn btn-sm" data-hp="sweep">Full sweep 20 Hz-20 kHz</button>
		</div>
	</div>
	<div class="hp-foot">
		<div class="field hp-vol"><label for="hp-volume">Volume <output id="hp-volout" for="hp-volume">35%</output></label><input type="range" id="hp-volume" min="0" max="100" step="5" value="35"></div>
		<button type="button" class="btn" id="hp-stop" disabled>Stop</button>
	</div>
</div>
<p class="tool-status" id="hp-status" aria-live="polite">Turn your volume down first, put your headphones on, then press a button.</p>',
	'howto'        => array(
		'Turn your device volume <strong>low</strong>, connect your headphones or earbuds and put them on the right way round (look for the L and R marks).',
		'Press <strong>Left ear</strong>. You should hear the tone only in your left ear. Then press <strong>Right ear</strong>, and <strong>Both</strong>, which should sound centred inside your head.',
		'Press <strong>Left &harr; right pan</strong>. The sound should travel smoothly from ear to ear and back with no gap or jump.',
		'Try the <strong>bass</strong> tones from 120 Hz down to 30 Hz, and the bass sweep. Note where the sound fades or starts to rattle.',
		'Play <strong>In phase</strong> and then <strong>Out of phase</strong>. If "out of phase" sounds more centred than "in phase", one side of your headphones is wired with reversed polarity.',
	),
	'howto_title'  => 'How to test your headphones',
	'results'      => '<ul>
<li><strong>Left and right are swapped:</strong> you are wearing the headphones backwards, or the left and right channels are swapped in software or wiring. Check the L/R marks first.</li>
<li><strong>Sound in both ears for the Left or Right button:</strong> your system is set to mono audio, or the headphones are in a mono or "spatial" mode. Turn mono off in accessibility settings and disable virtual surround while testing.</li>
<li><strong>One side quieter than the other:</strong> check the balance slider in your sound settings. If balance is centred, earwax in the mesh, a damaged cable or a failing driver are the usual causes.</li>
<li><strong>Bass fades at 50 Hz or 80 Hz:</strong> normal for small earbuds and open headphones, especially without a good seal. Try larger ear tips. Rattling or buzzing on the bass tones at a sensible volume points to a damaged driver.</li>
<li><strong>The pan jumps or has a silent gap:</strong> a loose connection or a cable that cuts out when it moves.</li>
</ul>',
	'extra'        => array(
		array(
			'What the polarity (phase) test shows',
			'<p>Each headphone driver pushes air forward and back. If one driver is wired the other way round, it moves backwards while the other moves forwards, and your brain cannot place the sound properly. The <strong>in phase</strong> button sends the same rumble to both ears, so it should feel solid and centred. The <strong>out of phase</strong> button inverts the right channel on purpose, so it should feel wide, hollow and hard to locate. If your headphones make the two sound the other way round, they have a polarity fault. This is rare in new headphones but common in repaired or home-made cables.</p>',
			'polarity',
		),
		array(
			'Testing Bluetooth and wireless headphones',
			'<p>Bluetooth headphones work the same way here. Make sure they are connected as the output device, not just paired. If you use a headset with a microphone on Windows, choose the "Stereo" or "Headphones" output, not the "Hands-Free" one, which is mono and low quality. After this headphone check, you can test the built-in microphone with the <a href="/mic-test/">mic test</a>, or check any speaker with the general <a href="/sound-test/">sound test</a>.</p>',
			'bluetooth',
		),
	),
	'fixes'        => array(
		array( 'Only one side of the headphones works', 'Push the plug fully into the jack: a half-inserted 3.5 mm plug plays one side only. Clean the jack, wiggle the cable near the plug and the earcup while the pan plays to find a break, and check the balance slider (Windows: Settings > System > Sound > your device > Left/Right; Mac: System Settings > Sound > Balance). For true wireless earbuds, put both back in the case, reset them and pair again.' ),
		array( 'Headphones play mono', 'Windows: Settings > Accessibility > Audio > Mono audio off. Mac: System Settings > Accessibility > Audio > Play stereo audio as mono off. iPhone: Settings > Accessibility > Audio/Visual > Mono Audio off. Android: Settings > Accessibility > Mono audio off.' ),
		array( 'Weak or no bass', 'Get a better seal: try a larger ear tip or adjust the headband. Turn off any "bass reduction" equaliser preset, and on Bluetooth turn off battery-saving codecs. Weak bass that used to be strong can also mean a torn earcup cushion or a damaged driver.' ),
		array( 'Bluetooth headphones sound tinny', 'Your computer is using the hands-free (call) profile. Pick the "Stereo" output in sound settings, or close apps that are holding the microphone, such as a meeting app.' ),
	),
	'faq'          => array(
		array( 'How do I test my headphones left and right?', 'Press Left ear and Right ear. The tone should come only from the side named. If it is reversed, turn the headphones round; if both sides play, turn off mono audio.' ),
		array( 'Why can I hear the left sound in both ears?', 'Mono audio is on, a spatial or virtual surround mode is active, or the headphones themselves mix the channels. Turn these off and test again.' ),
		array( 'What is a good bass test frequency?', 'A 50 Hz tone shows whether headphones have real bass. 30 Hz is the deep sub-bass that only good over-ear headphones play clearly.' ),
		array( 'Can this test detect a broken headphone cable?', 'Yes. Play the pan and gently move the cable along its length. If the sound cuts out or crackles at one spot, the wire is damaged there.' ),
		array( 'Does the headphone test work with earbuds and AirPods?', 'Yes, with any wired or wireless headphones, earbuds and AirPods, on phones, tablets and computers.' ),
		array( 'Is it safe to play test tones in headphones?', 'Yes, at a low volume. Start quiet, raise the volume slowly, and stop if a tone is uncomfortable. Very low bass can feel louder than it sounds.' ),
	),
	'disclaimer'   => 'Protect your hearing: start with a low volume and raise it slowly. Test tones can be louder than music at the same setting. This headphone test checks your equipment and is not a medical hearing test. If you notice hearing loss, ringing or pain, see a doctor or audiologist.',
	'related'      => array( 'sound-test', 'mic-test', 'hearing-frequency-test', 'tone-generator', 'speaker-cleaner', 'webcam-test' ),
	'updated'      => '2026-10-28',
);
