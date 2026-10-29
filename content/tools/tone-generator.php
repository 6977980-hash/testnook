<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Tone Generator',
	'seo_title'    => 'Online Tone Generator: Sine, Square, Sawtooth at Any Hz',
	'description'  => 'Free online tone generator. Play sine, square, triangle or sawtooth waves from 1 Hz to 22 kHz, set an exact frequency, sweep, and test speakers or hearing.',
	'intro'        => 'Generate a pure test tone at any frequency, straight from your browser. Type a frequency or drag the slider, choose the wave shape, send it to the left, right or both channels, and start at a low volume.',
	'device'       => 'any',
	'ads'          => 'standard',
	'styles'       => array( 'tone-generator' ),
	'scripts'      => array( 'tone-generator' ),
	'embed_height' => 700,
	'tool'         => '<div class="tool-stage tg-stage">
	<div class="tg-freq">
		<label for="tg-hz">Frequency (Hz)</label>
		<div class="tg-freq-row">
			<button type="button" class="btn btn-sm" data-tg-step="-1" aria-label="Down 1 Hz">-1</button>
			<input type="number" id="tg-hz" min="1" max="22000" step="1" value="440" inputmode="decimal">
			<button type="button" class="btn btn-sm" data-tg-step="1" aria-label="Up 1 Hz">+1</button>
		</div>
		<input type="range" id="tg-slider" min="0" max="1000" step="1" value="610" aria-label="Frequency slider">
		<div class="tg-note" id="tg-note">A4 (440 Hz)</div>
	</div>
	<div class="tg-presets btn-row" aria-label="Preset frequencies">
		<button type="button" class="btn btn-sm" data-tg-hz="20">20 Hz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="40">40 Hz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="60">60 Hz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="100">100 Hz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="250">250 Hz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="440">440 Hz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="1000">1 kHz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="4000">4 kHz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="8000">8 kHz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="12000">12 kHz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="15000">15 kHz</button>
		<button type="button" class="btn btn-sm" data-tg-hz="17000">17 kHz</button>
	</div>
	<div class="tg-opts">
		<div class="field"><span class="tg-label">Wave</span>
			<div class="seg" role="group" aria-label="Wave shape">
				<button type="button" data-tg-wave="sine" aria-pressed="true">Sine</button>
				<button type="button" data-tg-wave="square" aria-pressed="false">Square</button>
				<button type="button" data-tg-wave="triangle" aria-pressed="false">Triangle</button>
				<button type="button" data-tg-wave="sawtooth" aria-pressed="false">Sawtooth</button>
			</div>
		</div>
		<div class="field"><span class="tg-label">Channel</span>
			<div class="seg" role="group" aria-label="Channel">
				<button type="button" data-tg-ch="-1" aria-pressed="false">Left</button>
				<button type="button" data-tg-ch="0" aria-pressed="true">Both</button>
				<button type="button" data-tg-ch="1" aria-pressed="false">Right</button>
			</div>
		</div>
		<div class="field tg-vol"><label for="tg-volume">Volume <output id="tg-volout" for="tg-volume">25%</output></label><input type="range" id="tg-volume" min="0" max="100" value="25"></div>
	</div>
	<canvas class="tg-wave" id="tg-canvas" width="800" height="120" aria-hidden="true"></canvas>
	<div class="tg-controls btn-row">
		<button type="button" class="btn btn-primary" id="tg-play">Play</button>
		<button type="button" class="btn" id="tg-sweep">Sweep 20 Hz &rarr; 20 kHz</button>
		<label class="tg-sweeplen">over <select id="tg-sweeptime"><option value="10">10 s</option><option value="20" selected>20 s</option><option value="60">60 s</option></select></label>
	</div>
</div>
<p class="tool-status" id="tg-status" aria-live="polite">Start at a low volume. Pure tones sound louder than music at the same setting.</p>',
	'howto'        => array(
		'Turn your speakers or headphones down to a low level before you start.',
		'Type a frequency in Hz or drag the slider. The slider is logarithmic, so bass frequencies get as much room as treble. Use the <strong>-1</strong> / <strong>+1</strong> buttons for exact values.',
		'Choose a wave shape. <strong>Sine</strong> is a pure tone with no harmonics; square, triangle and sawtooth add overtones and sound harsher.',
		'Pick <strong>Left</strong>, <strong>Both</strong> or <strong>Right</strong> to send the tone to one speaker or earpiece.',
		'Press <strong>Play</strong>. Change the frequency while it plays; the tone follows instantly. Press <strong>Sweep</strong> to glide from 20 Hz to 20 kHz.',
	),
	'howto_title'  => 'How to use the tone generator',
	'results'      => '<p>The tone generator makes a steady wave at exactly the frequency you set. What you hear depends on your gear and your ears:</p>
<ul>
<li><strong>Below 40 Hz</strong>: only subwoofers and good over-ear headphones reproduce this. Laptop speakers go silent or buzz; a buzz or rattle at low frequencies means something in the speaker or the desk is resonating.</li>
<li><strong>100 Hz to 4 kHz</strong>: every speaker should play these clearly and at a steady level. A drop or wobble at a certain frequency points to a damaged driver or a room resonance.</li>
<li><strong>Above 12 kHz</strong>: adults gradually lose the top of their hearing range. If a tone at 15 kHz is silent for you but a younger person hears it, that is normal age-related change, not a speaker fault. Our <a href="/hearing-frequency-test/">hearing frequency test</a> measures this step by step.</li>
<li><strong>Left / Right</strong>: the tone should come from the side you chose. Swapped sides mean the cable or balance setting is reversed. The <a href="/sound-test/">sound test</a> has more channel checks.</li>
</ul>
<p>The waveform display shows the shape of the wave, not the sound coming out of your speaker.</p>',
	'extra'        => array(
		array(
			'Wave shapes and what they are for',
			'<p>A <strong>sine</strong> wave contains a single frequency and is the standard test signal: it reveals speaker resonances, hearing thresholds and room modes without any harmonics muddying the result. A <strong>square</strong> wave contains every odd harmonic and sounds hollow and buzzy, which is useful for hearing how a speaker handles sharp edges, and for synth and chiptune sounds. A <strong>triangle</strong> wave has the same odd harmonics but much weaker, so it sounds like a softer sine. A <strong>sawtooth</strong> wave contains every harmonic and sounds bright and brassy, which is how most synthesizer leads start.</p>
<p>Musicians use the tone generator for tuning: 440 Hz is A4, the standard concert pitch; the note name under the slider updates for any frequency. Audio engineers use 1 kHz as a reference level, 60 Hz to find mains hum, and sweeps to find rattles and resonances in cabinets and rooms. Pest-deterrent and dog-whistle uses above 17 kHz depend on speakers that most laptops and phones cannot reproduce well, so do not rely on them.</p>',
			'waves',
		),
		array(
			'Frequency ranges to try',
			'<p><strong>20-60 Hz</strong>: sub-bass; feel it more than hear it. <strong>60-250 Hz</strong>: bass; kick drums and bass guitar. <strong>250 Hz-2 kHz</strong>: midrange; most of the voice. <strong>2-6 kHz</strong>: presence; speech clarity and sibilance. <strong>6-20 kHz</strong>: brilliance; cymbals and air. A speaker that sounds even across a slow sweep is well balanced; one that jumps in loudness at certain spots is colouring the sound.</p>',
			'ranges',
		),
	),
	'fixes'        => array(
		array( 'I hear nothing', 'Check the volume slider here and the system volume, and that the right output device is selected. Browsers only start audio after a click, so press Play again if you changed tabs. Frequencies above 16 kHz may be inaudible to you even though the speaker is producing them.' ),
		array( 'The tone crackles or distorts', 'Lower the volume here. Square and sawtooth waves peak much higher than a sine at the same slider position. Bluetooth speakers often distort below 60 Hz.' ),
		array( 'The tone is on the wrong side', 'Swap the left/right cable or check the balance setting in your sound settings. On headphones, make sure the L and R cups are on the right ears.' ),
		array( 'The sweep seems to drop out in the middle', 'A dip at one frequency is a resonance or cancellation in the speaker or the room. Move the speaker or your head a little and sweep again; if the dip moves, it is the room, not the speaker.' ),
	),
	'faq'          => array(
		array( 'What is a tone generator used for?', 'Testing speakers and headphones, tuning instruments, finding rattles and room resonances, checking hearing range, and making synth-like sounds for experiments.' ),
		array( 'What frequency should I use to test speakers?', 'Start with 1 kHz for a level reference, then try 60 Hz for bass, 250 Hz for low mids and 8 kHz for treble. A slow sweep from 20 Hz to 20 kHz shows the whole range.' ),
		array( 'What frequency is 440 Hz?', 'The musical note A4, used as the tuning standard for most instruments. Press the 440 Hz preset and tune to it.' ),
		array( 'Is a high frequency tone dangerous?', 'Any loud sound can harm your hearing, whatever the pitch. High tones feel quieter than they are, so keep the volume low and sessions short.' ),
		array( 'Why can I not hear above 15 kHz?', 'The upper limit of hearing drops with age: teenagers hear up to about 18-20 kHz, adults around 14-16 kHz, and over 50 often 12 kHz or less. That is normal.' ),
		array( 'Does the tone generator work on a phone?', 'Yes, but phone speakers reproduce very little below 150 Hz. Use headphones to hear bass frequencies.' ),
	),
	'disclaimer'   => 'Protect your hearing: start at a low volume and raise it slowly. A steady tone is louder than it seems, especially at high frequencies. This tone generator tests equipment and is not a medical hearing test. If you notice ringing, pain or hearing loss, stop and see a doctor or audiologist.',
	'related'      => array( 'guitar-tuner', 'metronome', 'sound-test', 'headphone-test', 'hearing-frequency-test', 'white-noise-generator', 'dog-whistle' ),
	'updated'      => '2026-10-28',
);
