<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'White Noise Generator',
	'seo_title'      => 'White Noise Generator: White, Pink and Brown Noise Online',
	'description'    => 'Free white noise generator: play white, pink, brown, blue, violet or grey noise with a warmth control and a sleep timer that fades out, for sleep and focus.',
	'intro'          => 'Steady noise to sleep, focus, calm a baby or mask a noisy room. Choose from six noise colours, make the sound softer with the warmth control, and set a sleep timer that fades the noise out gently. The noise is generated in your browser and loops with no gaps.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'white-noise-generator' ),
	'scripts'        => array( 'white-noise-generator' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-stage wn-stage">
	<div class="wn-colours" role="group" aria-label="Noise colour">
		<button type="button" class="wn-colour" data-wn-colour="white" aria-pressed="true" style="--wn-c:#e5e7eb">White<small>Even hiss, all frequencies</small></button>
		<button type="button" class="wn-colour" data-wn-colour="pink" aria-pressed="false" style="--wn-c:#f9a8d4">Pink<small>Softer, like steady rain</small></button>
		<button type="button" class="wn-colour" data-wn-colour="brown" aria-pressed="false" style="--wn-c:#92400e">Brown<small>Deep rumble, like a waterfall</small></button>
		<button type="button" class="wn-colour" data-wn-colour="grey" aria-pressed="false" style="--wn-c:#9ca3af">Grey<small>Sounds equally loud at all pitches</small></button>
		<button type="button" class="wn-colour" data-wn-colour="blue" aria-pressed="false" style="--wn-c:#60a5fa">Blue<small>Bright, like a spraying hose</small></button>
		<button type="button" class="wn-colour" data-wn-colour="violet" aria-pressed="false" style="--wn-c:#a78bfa">Violet<small>Very high hiss</small></button>
	</div>
	<canvas class="wn-canvas" id="wn-canvas" aria-hidden="true"></canvas>
</div>
<div class="wn-controls">
	<button type="button" class="btn btn-primary wn-play" id="wn-play" aria-pressed="false">Play</button>
	<div class="field"><label for="wn-vol">Volume <output id="wn-volout" for="wn-vol">40%</output></label><input type="range" id="wn-vol" min="1" max="100" step="1" value="40"></div>
	<div class="field"><label for="wn-warm">Warmth <output id="wn-warmout" for="wn-warm">Off</output></label><input type="range" id="wn-warm" min="0" max="100" step="1" value="0"></div>
	<div class="field wn-timer"><label for="wn-timer">Sleep timer <span class="wn-left" id="wn-left"></span></label><select id="wn-timer"><option value="0">Off (play until stopped)</option><option value="15">15 minutes</option><option value="30">30 minutes</option><option value="45">45 minutes</option><option value="60">1 hour</option><option value="90">1.5 hours</option><option value="120">2 hours</option><option value="480">8 hours</option></select></div>
</div>
<p class="tool-status" id="wn-status" aria-live="polite">Press Play. You can change the colour while it plays.</p>',
	'howto'          => array(
		'Pick a noise colour. White is the classic hiss; pink and brown are softer and deeper, and most people find them easier to sleep to.',
		'Press <strong>Play</strong>. The sound fades in over two seconds.',
		'Set the <strong>Volume</strong> as low as still masks the noise you want to cover. For sleep, quieter than a normal conversation is enough.',
		'Turn up <strong>Warmth</strong> to cut the high hiss and make any colour sound softer.',
		'Choose a <strong>Sleep timer</strong> if you want the noise to stop by itself. It fades out over the last 30 seconds.',
	),
	'howto_title'    => 'How to use the white noise generator',
	'results'        => '<p>Noise "colours" describe how the sound energy is spread from low to high pitches:</p>
<div class="table-scroll"><table>
<thead><tr><th>Colour</th><th>How it sounds</th><th>Good for</th></tr></thead>
<tbody>
<tr><td>White</td><td>Equal energy at every frequency; a bright hiss like TV static</td><td>Masking speech and sharp sounds, focus</td></tr>
<tr><td>Pink</td><td>Energy falls by 3 dB per octave; rain or wind in leaves</td><td>Sleep, relaxing background, studies on deep sleep</td></tr>
<tr><td>Brown</td><td>Falls by 6 dB per octave; a deep rumble like a waterfall or engine</td><td>Sleep, tinnitus relief for some, ADHD focus playlists</td></tr>
<tr><td>Grey</td><td>Shaped so every pitch sounds about equally loud to human ears</td><td>A neutral, balanced background</td></tr>
<tr><td>Blue</td><td>Rises by 3 dB per octave; bright and sharp</td><td>Short masking of high sounds</td></tr>
<tr><td>Violet</td><td>Rises by 6 dB per octave; very high hiss</td><td>Some tinnitus sound therapy</td></tr>
</tbody></table></div>
<p>The spectrum under the colours shows the live sound from low (left) to high (right) pitches, so you can see the difference between the colours.</p>',
	'extra'          => array(
		array(
			'White noise for sleep, babies and focus',
			'<p>Steady noise works by masking: a sudden sound such as a door, traffic or a snore stands out less against a constant background, so it is less likely to wake you or pull your attention. For adults, pink and brown noise are usually more pleasant than white. For babies, keep the device at least 2 metres from the cot and the level low, around 50 dB (a quiet conversation); paediatric guidance warns against loud machines placed right next to an infant. For work, many people prefer brown noise or white noise at a low level through headphones.</p>',
			'sleep-babies-focus',
		),
		array(
			'Playing noise all night',
			'<p>On a computer or Android phone the noise keeps playing with the screen off as long as the tab stays open. iPhone and iPad pause web audio when the screen locks, so keep the screen on (Settings > Display &amp; Brightness > Auto-Lock > Never while you use it) and turn the brightness down. To check that your speaker handles low rumble without buzzing, try the <a href="/bass-test/">bass test</a>; for single tones use the <a href="/tone-generator/">tone generator</a>.</p>',
			'all-night',
		),
	),
	'fixes'          => array(
		array( 'The noise stops when my phone locks', 'iPhone and iPad suspend web audio when the screen locks. Keep the screen on with a low brightness, or use a computer or Android phone, which keep playing in the background.' ),
		array( 'I hear a regular pattern or click', 'The noise loops every 12 seconds with a cross-fade, so there should be no click. If you hear one, your device may be busy: close other tabs. A low warmth setting also hides any small pattern in the hiss.' ),
		array( 'The sound is too harsh', 'Switch to pink or brown noise, turn up Warmth to cut the high frequencies, and lower the volume. Small phone speakers make white noise sound harsher than headphones or a larger speaker.' ),
	),
	'faq'            => array(
		array( 'Is white noise good for sleep?', 'Many people sleep better with a steady background sound because it masks noises that would otherwise wake them. Pink and brown noise are often found more relaxing than white.' ),
		array( 'What is the difference between white, pink and brown noise?', 'White noise has equal energy at all frequencies and sounds like a hiss. Pink noise has less high-frequency energy and sounds like rain. Brown noise has even less and sounds like a deep rumble.' ),
		array( 'Can I use white noise for a baby?', 'Yes, at a low volume and with the speaker at least 2 metres from the baby. Use the sleep timer so it does not play loudly all night.' ),
		array( 'Is brown noise good for focus?', 'Many people with and without ADHD say brown noise helps them concentrate because it covers distractions without being shrill. Research is still limited, so try it and see.' ),
		array( 'Does the noise loop?', 'Yes. Each colour is a 12 second stereo recording generated in your browser that loops with a cross-fade, so it plays without gaps for as long as you like.' ),
		array( 'Can white noise damage hearing?', 'At sensible levels, no. Keep it below about 60-70 dB (a normal conversation) and lower for sleep or babies. Avoid loud noise through headphones for hours.' ),
	),
	'disclaimer'     => 'Keep the volume moderate, especially through headphones and for babies or long listening. Long exposure to loud sound can damage hearing. White noise is not a medical treatment; for ongoing sleep problems or tinnitus, talk to a doctor.',
	'related'        => array( 'tone-generator', 'bass-test', 'dog-whistle', 'metronome', 'headphone-test', 'sound-test', 'hearing-frequency-test', 'stereo-test' ),
	'updated'        => '2026-10-29',
);
