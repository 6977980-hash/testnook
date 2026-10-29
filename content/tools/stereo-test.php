<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Stereo Test',
	'seo_title'      => 'Stereo Test: Left Right Speaker & Stereo Sound Check',
	'description'    => 'Free stereo sound test for speakers and headphones. Play left, right and centre sounds, a pan sweep, ping-pong notes and a phase check, and fix your balance.',
	'intro'          => 'Check that your speakers or headphones really play in stereo: a chime in the left channel, the right channel and the centre, a sound that pans across, notes that bounce side to side, a balance control to find the true centre and a phase check for wiring faults. The speaker icons light up with each channel.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'channel-test' ),
	'scripts'        => array( 'channel-test' ),
	'embed_height'   => 700,
	'tool'           => '<div class="tool-stage ch-stage">
	<div class="ch-speakers"><div class="ch-spk" id="ch-l" aria-hidden="true">L</div><div class="ch-mid">The icons light up for each channel the page is playing</div><div class="ch-spk" id="ch-r" aria-hidden="true">R</div></div>
	<p class="ch-label">Channels</p>
	<div class="ch-grid">
		<button type="button" class="btn" data-ch="left" aria-pressed="false">Left</button>
		<button type="button" class="btn" data-ch="centre" aria-pressed="false">Centre</button>
		<button type="button" class="btn" data-ch="right" aria-pressed="false">Right</button>
	</div>
	<p class="ch-label">Stereo image</p>
	<div class="ch-grid">
		<button type="button" class="btn" data-ch="pan" aria-pressed="false">Pan left to right</button>
		<button type="button" class="btn" data-ch="pingpong" aria-pressed="false">Ping-pong notes</button>
		<button type="button" class="btn" data-ch="inphase" aria-pressed="false">In phase</button>
		<button type="button" class="btn" data-ch="outphase" aria-pressed="false">Out of phase</button>
		<button type="button" class="btn" data-ch="balance" aria-pressed="false">Balance tone</button>
		<button type="button" class="btn btn-primary" id="ch-stop">Stop</button>
	</div>
	<div class="ch-ask" id="ch-ask-side" hidden><strong>Where did you hear it?</strong><button type="button" class="btn btn-sm" data-ans="one">Only on that side</button><button type="button" class="btn btn-sm" data-ans="both">Both sides</button><button type="button" class="btn btn-sm" data-ans="wrong">The other side</button><button type="button" class="btn btn-sm" data-ans="none">Nothing</button></div>
	<div class="ch-ask" id="ch-ask-phase" hidden><strong>How did the out-of-phase noise sound?</strong><button type="button" class="btn btn-sm" data-ans="loud">Clearly audible, wide</button><button type="button" class="btn btn-sm" data-ans="quiet">Very quiet or gone</button></div>
	<label class="ch-row">Balance <input type="range" id="ch-balance" min="-30" max="30" step="1" value="0"><output id="ch-balout" for="ch-balance">Centre</output></label>
	<label class="ch-row">Volume <input type="range" id="ch-volume" min="0" max="100" step="1" value="40"><output id="ch-volout" for="ch-volume">40%</output></label>
</div>
<p class="tool-status" id="ch-status" aria-live="polite">Set your system volume to about half, then press Left.</p>',
	'howto'          => array(
		'Turn your system volume to about half. Sit centred between the speakers, or put headphones on the right way round (L on the left ear).',
		'Press <strong>Left</strong>, then <strong>Right</strong>. Each should come only from that side; answer the question that appears for an explanation.',
		'Press <strong>Centre</strong>. With good stereo the sound seems to come from the middle, between the speakers.',
		'Press <strong>Pan left to right</strong> and <strong>Ping-pong notes</strong>. The sound should travel smoothly across with no hole in the middle.',
		'If the centre leans to one side, press <strong>Balance tone</strong> and move the balance slider until it sits in the middle. The number shows how far your setup is off.',
	),
	'howto_title'    => 'How to test stereo sound',
	'results'        => '<p>Read the results like this:</p>
<ul>
<li><strong>Left and right each from one side, centre in the middle:</strong> stereo works.</li>
<li><strong>Left and right both from everywhere:</strong> the output is mono. The <a href="/mono-test/">mono test</a> confirms it and shows how to switch Mono Audio off.</li>
<li><strong>Left plays on the right:</strong> the channels are swapped, usually speakers on the wrong sides or headphones worn backwards.</li>
<li><strong>Centre leans to one side:</strong> the system balance is off, one speaker is louder, or you are sitting off-centre. The balance tone tells you by how much.</li>
<li><strong>In phase sounds wide and vague, out of phase sounds focused:</strong> one speaker is wired with plus and minus reversed. Swap the two wires on one speaker.</li>
</ul>',
	'extra'          => array(
		array(
			'Speakers vs headphones',
			'<p>On headphones, left and right are completely separate, so a left-only sound is in your left ear only. On speakers, both ears hear both speakers, so the effect is softer: left comes from the left speaker\'s direction rather than only one ear. That is why the centre sound appears to float between the speakers, a "phantom centre". If it does not, the speakers are not at the same distance or one is louder.</p>
<p>For speakers, place them at an equal distance from you, about as far apart as you sit from them, forming a triangle. Point them slightly towards your head. For a deeper check of headphones, including bass and polarity, use the <a href="/headphone-test/">headphone test</a>.</p>',
			'speakers',
		),
		array(
			'Phones and laptops',
			'<p>Most phones only play stereo when held sideways, with the earpiece working as the second speaker; in portrait many sum to mono. Small laptops have two speakers close together, so the stereo effect is narrow, and some send both channels to one speaker. A single Bluetooth speaker is almost always mono unless it is paired with a second one. None of these are faults; they are limits of the device.</p>',
			'phones',
		),
	),
	'fixes'          => array(
		array( 'Sound only comes from one side', 'Check the balance in system settings (Windows: Settings > System > Sound > device > Left and Right; Mac: System Settings > Sound > Balance). Push the plug fully in. Try other headphones to see whether the fault is the device or the computer.' ),
		array( 'Left and right are swapped', 'Swap the speakers or the cables, or wear the headphones the other way round. Some sound drivers have a channel swap option.' ),
		array( 'Both sides play everything', 'Mono Audio is on, or the device is mono. Turn it off in the accessibility settings and check with the <a href="/mono-test/">mono test</a>.' ),
		array( 'No sound at all', 'Click on the page first (browsers block sound until you interact), raise the volume slider and the system volume, and check the right output device is selected.' ),
	),
	'faq'            => array(
		array( 'How do I test if my speakers are stereo?', 'Press Left and Right. If each plays from only one side, the speakers are in stereo. If both play from both sides, the output is mono.' ),
		array( 'What is a stereo test?', 'A set of sounds sent to the left channel, the right channel or both, which shows whether your speakers or headphones keep the two channels separate and the right way round.' ),
		array( 'What does out of phase mean?', 'The right channel is the exact opposite of the left. On correctly wired speakers it sounds wide and strange; in mono it cancels out and nearly disappears.' ),
		array( 'Why does the centre sound not come from the middle?', 'One speaker is louder, the balance setting is off, or you are sitting nearer one speaker. Use the balance tone to measure the offset.' ),
		array( 'Can I use the stereo test on a phone?', 'Yes. Use headphones, or hold the phone sideways so both speakers are used.' ),
		array( 'Is the stereo test safe for my speakers?', 'Yes. The sounds are short and start at a moderate level. Raise the volume gradually and stop if you hear distortion.' ),
	),
	'related'        => array( 'mono-test', 'headphone-test', 'sound-test', 'bass-test', 'tone-generator', 'speaker-cleaner' ),
	'updated'        => '2026-10-29',
);
