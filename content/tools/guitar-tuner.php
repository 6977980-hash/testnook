<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Online Guitar Tuner',
	'seo_title'      => 'Online Guitar Tuner: Free Chromatic Tuner Using Your Mic',
	'description'    => 'Free online guitar tuner. Uses your mic to show the note, cents sharp or flat and a needle, with guitar, bass, ukulele and drop D presets plus a chromatic mode.',
	'intro'          => 'Tune your guitar with the microphone in your laptop or phone. Press Start, allow the microphone, play one string and the tuner shows the note, how many cents you are sharp or flat, and which way to turn the peg. Presets cover standard guitar, drop D, bass and ukulele; chromatic mode tunes any instrument or voice.',
	'device'         => 'media',
	'device_message' => 'This tuner needs a microphone and a browser that allows microphone access over HTTPS. You can still play the reference tones for each string and tune by ear.',
	'ads'            => 'standard',
	'styles'         => array( 'guitar-tuner' ),
	'scripts'        => array( 'guitar-tuner' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar gt-bar">
	<div class="seg" role="group" aria-label="Instrument">
		<button type="button" data-gt-inst="guitar" aria-pressed="true">Guitar</button>
		<button type="button" data-gt-inst="dropd" aria-pressed="false">Drop D</button>
		<button type="button" data-gt-inst="bass" aria-pressed="false">Bass</button>
		<button type="button" data-gt-inst="ukulele" aria-pressed="false">Ukulele</button>
		<button type="button" data-gt-inst="chromatic" aria-pressed="false">Chromatic</button>
	</div>
	<button type="button" class="btn btn-primary" id="gt-start">Start tuner</button>
</div>
<div class="tool-stage gt-stage">
	<div class="gt-dial" id="gt-dial" aria-hidden="true">
		<div class="gt-arc"></div>
		<div class="gt-ticks">
			<span class="is-major"></span><span></span><span></span><span></span><span></span><span class="is-major"></span><span></span><span></span><span></span><span></span><span class="is-major"></span>
		</div>
		<div class="gt-needle" id="gt-needle"></div>
		<div class="gt-pivot"></div>
	</div>
	<div class="gt-labels" aria-hidden="true"><span>-50 flat</span><span>0</span><span>+50 sharp</span></div>
	<div class="gt-read" aria-live="polite">
		<div class="gt-notebox"><span id="gt-note">--</span><small id="gt-oct"></small></div>
		<div class="gt-cents" id="gt-cents"></div>
		<div class="gt-hz" id="gt-hz">-</div>
	</div>
	<p class="gt-target" id="gt-target">Play one string at a time.</p>
	<div class="gt-strings" id="gt-strings" role="group" aria-label="Reference tones"></div>
	<div class="meter gt-level" aria-hidden="true"><span id="gt-level"></span></div>
	<div class="gt-opts">
		<div class="field"><label for="gt-device">Microphone</label><select id="gt-device"><option value="">Default microphone</option></select></div>
		<div class="field"><label for="gt-a4">Reference A4 (Hz)</label><input type="number" id="gt-a4" min="400" max="480" step="1" value="440" inputmode="numeric"></div>
	</div>
</div>
<p class="tool-status" id="gt-status" aria-live="polite">Press Start tuner and allow the microphone, or tap a string button to hear its reference tone.</p>',
	'howto'          => array(
		'Pick your instrument: <strong>Guitar</strong> (E A D G B E), <strong>Drop D</strong>, <strong>Bass</strong>, <strong>Ukulele</strong>, or <strong>Chromatic</strong> for anything else.',
		'Press <strong>Start tuner</strong> and allow the microphone when the browser asks. The level bar moves when the mic hears you.',
		'Play one open string, cleanly, and let it ring. The tuner shows the nearest note and the needle swings left if you are flat, right if sharp.',
		'Turn the tuning peg until the needle sits in the green zone and the reading says <strong>In tune</strong>. Tune up to the note from below: if you overshoot, drop below and come back up.',
		'Repeat for every string, then go round once more, because tuning one string changes the tension on the others. Tap a string button any time to hear its reference tone and tune by ear.',
	),
	'howto_title'    => 'How to tune a guitar with the online tuner',
	'results'        => '<p>The tuner shows three things:</p>
<ul>
<li><strong>Note and octave:</strong> the nearest note to what the microphone hears, using scientific pitch notation (the low E on a guitar is E2, the high E is E4). In an instrument preset the tuner snaps to the nearest string of that instrument, so a badly out of tune string still points you at the right target.</li>
<li><strong>Cents:</strong> how far you are from that note. There are 100 cents in a semitone. Within <strong>±5 cents</strong> counts as in tune and the needle turns green; most people cannot hear a difference under 5 cents, and a guitar\'s own intonation varies by more than that up the neck.</li>
<li><strong>Frequency in Hz:</strong> the measured pitch, for reference. A perfectly tuned A string on a guitar reads 110.0 Hz with A4 at 440.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>Instrument</th><th>Standard tuning</th><th>Frequencies (A4 = 440 Hz)</th></tr></thead>
<tbody>
<tr><td>Guitar</td><td>E2 A2 D3 G3 B3 E4</td><td>82.4, 110.0, 146.8, 196.0, 246.9, 329.6 Hz</td></tr>
<tr><td>Drop D</td><td>D2 A2 D3 G3 B3 E4</td><td>73.4, 110.0, 146.8, 196.0, 246.9, 329.6 Hz</td></tr>
<tr><td>Bass (4 string)</td><td>E1 A1 D2 G2</td><td>41.2, 55.0, 73.4, 98.0 Hz</td></tr>
<tr><td>Ukulele (soprano, concert, tenor)</td><td>G4 C4 E4 A4</td><td>392.0, 261.6, 329.6, 440.0 Hz</td></tr>
</tbody></table></div>
<p>The needle reads <em>flat</em> (left) when the pitch is below the target: tighten the string. <em>Sharp</em> (right) means above: loosen it. Change the <strong>Reference A4</strong> only if you are playing along with a recording or an ensemble that uses a different pitch standard (432 Hz is a common request; orchestras often use 442).</p>',
	'extra'          => array(
		array(
			'How the tuner detects pitch',
			'<p>The browser captures audio from your microphone and the tuner analyzes about 90 milliseconds at a time. It uses a normalized autocorrelation method: the waveform is compared with delayed copies of itself, and the delay at which they match best is the period of the note. That approach is robust to the strong overtones of a plucked string, which is where simple spectrum-peak tuners go wrong by reporting the octave above. The last few readings are smoothed with a median, so a single noisy frame does not jerk the needle. Everything runs on your device; the audio is never sent anywhere.</p>
<p>Low notes need a longer window, which is why a bass E (41 Hz) takes a fraction of a second longer to lock on than a guitar high E. Phone microphones roll off below about 80 Hz, so for bass guitar a laptop mic or an external mic usually tracks better, or tune the 12th-fret harmonic instead of the open string.</p>',
			'how-it-works',
		),
		array(
			'Tuning tips',
			'<p>Tune in a quiet room, with the instrument close to the microphone. Pluck with moderate force and let the note sustain; a hard attack gives an unstable first reading. Mute the other strings with your palm so only one sounds. New strings stretch, so retune a few times during the first hour of playing. If a string reads in tune when open but chords up the neck sound sour, the problem is intonation at the bridge, not tuning. For a steady reference pitch to tune by ear, use the <a href="/tone-generator/">tone generator</a>, and if the tuner does not hear anything at all, check the microphone with the <a href="/mic-test/">mic test</a> first.</p>',
			'tips',
		),
	),
	'fixes'          => array(
		array( 'The tuner says permission was blocked', 'Click the lock or camera icon in the address bar, allow the microphone for this site and reload. The page must be opened over HTTPS. On iPhone, Safari asks each time; tap Allow.' ),
		array( 'The level bar moves but no note is shown', 'The sound is too quiet or too noisy for a stable pitch. Move closer to the microphone, pluck a single string and let it ring, and reduce background noise. Choose a different microphone from the list if your device has several.' ),
		array( 'The note jumps between octaves or shows the wrong string', 'Mute the other strings so only one vibrates, and pluck over the sound hole rather than near the bridge, where overtones dominate. In an instrument preset the tuner snaps to the nearest string; use Chromatic mode to see the raw note.' ),
		array( 'The low E or bass strings will not register', 'Phone microphones cut off very low frequencies. Use a laptop or external mic, play the string a little harder, or tune the harmonic at the 12th fret, which is the same note an octave higher.' ),
	),
	'faq'            => array(
		array( 'Is this guitar tuner accurate?', 'Yes. The pitch detection is accurate to about 1 cent on a clean, sustained note, which is far finer than the 5 cent window shown as in tune and finer than most clip-on tuners.' ),
		array( 'What are the notes for standard guitar tuning?', 'From the thickest string to the thinnest: E2, A2, D3, G3, B3, E4. Many people remember it as Eddie Ate Dynamite Good Bye Eddie.' ),
		array( 'Does the online tuner work on a phone?', 'Yes, in Safari on iPhone and Chrome on Android. Allow the microphone when asked and keep the phone near the sound hole. Very low bass notes track better on a laptop microphone.' ),
		array( 'Can I tune a bass, ukulele or violin with it?', 'Bass and ukulele have presets. For violin, mandolin, banjo or voice, pick Chromatic: it shows the nearest of all twelve notes and the cents, so you can tune to any pitch.' ),
		array( 'What does 432 Hz tuning mean?', 'It sets the reference A4 to 432 Hz instead of the standard 440, about 32 cents lower. Type 432 in the Reference A4 box and every target note shifts accordingly.' ),
		array( 'Is my microphone audio recorded?', 'No. The audio is analyzed in your browser as it arrives and is never stored or sent to a server. Closing the page or pressing Stop releases the microphone.' ),
	),
	'related'        => array( 'tone-generator', 'metronome', 'tap-bpm', 'mic-test', 'sound-test', 'headphone-test' ),
	'updated'        => '2026-10-28',
);
