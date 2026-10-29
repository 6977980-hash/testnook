<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Tap BPM Counter',
	'seo_title'    => 'Tap BPM: Tap Tempo Counter to Find the BPM of Any Song',
	'description'  => 'Free tap BPM counter. Tap along to any song with your mouse, finger or keyboard and get its tempo in beats per minute, with a stability score and halve/double.',
	'intro'        => 'Find the tempo of any song by tapping along. Tap the big area, press Space or hit any key on each beat and the counter shows the beats per minute, how steady your taps are and what genre usually sits at that tempo. The count resets by itself after a pause, so you can measure one track after another.',
	'device'       => 'any',
	'ads'          => 'content',
	'styles'       => array( 'tap-bpm' ),
	'scripts'      => array( 'tap-bpm' ),
	'embed_height' => 620,
	'tool'         => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn btn-sm" id="tb-half">&frac12; Halve</button>
		<button type="button" class="btn btn-sm" id="tb-double">&times;2 Double</button>
	</div>
	<label class="tb-opt"><input type="checkbox" id="tb-auto" checked> Auto reset after a pause</label>
</div>
<div class="tool-stage tb-stage" id="tb-stage" tabindex="0" role="button">
	<div class="tb-ring" id="tb-ring">Tap</div>
	<div class="tb-msg"><strong id="tb-big">Tap here</strong><span id="tb-small">Tap in time with the music. Space or any key works too.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">BPM (average)</span><span class="stat-value" id="tb-avg">-</span></div>
	<div class="stat"><span class="stat-label">BPM (last taps)</span><span class="stat-value" id="tb-last">-</span></div>
	<div class="stat"><span class="stat-label">Taps</span><span class="stat-value" id="tb-count">0</span></div>
	<div class="stat"><span class="stat-label">Stability</span><span class="stat-value" id="tb-stab">-</span></div>
	<div class="stat"><span class="stat-label">Beat length</span><span class="stat-value" id="tb-ms">-</span></div>
</div>
<div class="btn-row tb-foot"><button type="button" class="btn btn-sm" id="tb-reset">Reset</button></div>
<p class="tool-status" id="tb-status" aria-live="polite">Tap the big area, press Space or any key in time with the beat.</p>',
	'howto'        => array(
		'Play the song you want to measure, on any device: speakers, headphones, or the radio in the room.',
		'Tap the big area with your mouse or finger on every beat, or press <strong>Space</strong> or any letter key. Tap the main pulse, the one you would clap or nod to.',
		'Keep tapping for at least 8 beats. The BPM settles as you go: the <strong>average</strong> uses every tap in the run, the <strong>last taps</strong> number follows the most recent four.',
		'If the number looks half or double what you expect (a song can feel like 70 or 140), press <strong>Halve</strong> or <strong>Double</strong>.',
		'Stop tapping for 3 seconds and the reading is frozen, so you can note it; the next tap starts a fresh count. Press <strong>Reset</strong> to clear at any time.',
	),
	'howto_title'  => 'How to use the tap BPM counter',
	'results'      => '<p><strong>BPM</strong> is beats per minute, the tempo of the music. The counter measures the time between your taps and converts the average gap to BPM: a 500 ms gap is 120 BPM, a 750 ms gap is 80 BPM.</p>
<ul>
<li><strong>BPM (average):</strong> based on the time from your first tap to your last, divided by the number of gaps. The more taps, the more accurate; after 8 taps the result is shown to one decimal.</li>
<li><strong>BPM (last taps):</strong> the tempo of your most recent four taps. If it drifts from the average, either the song changed tempo or your tapping did.</li>
<li><strong>Stability:</strong> how even your taps were. 90% or more means a steady beat and a trustworthy reading; under 80% means you lost the pulse for a moment, so reset and tap again.</li>
<li><strong>Beat length:</strong> one beat in milliseconds. Handy for setting delay times and loop lengths in a DAW.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>BPM</th><th>Typical genres</th></tr></thead>
<tbody>
<tr><td>60-80</td><td>Ballads, downtempo, slow R&amp;B</td></tr>
<tr><td>80-100</td><td>Hip hop, reggae, dub</td></tr>
<tr><td>100-120</td><td>Pop, funk, disco</td></tr>
<tr><td>120-130</td><td>House, dance pop, techno (slow)</td></tr>
<tr><td>130-150</td><td>Techno, trance, dubstep (half time 140)</td></tr>
<tr><td>160-180</td><td>Drum and bass, punk, fast rock</td></tr>
</tbody></table></div>',
	'extra'        => array(
		array(
			'Half time, double time and why your BPM can be off by a factor of two',
			'<p>Tempo is a feel, not a fixed number. A track with a snare on beats 2 and 4 at 140 BPM can also be felt at 70 BPM if you tap on the snare only, and dubstep at 140 is usually written at 140 but moves at a half-time 70. DJs and producers agree on conventions (drum and bass is 170-175, not 85), so if your reading is far from the range you expect for the genre, use Halve or Double rather than retapping. The same applies to fast songs: tapping eighth notes by mistake doubles the result.</p>
<p>Waltzes and other 3/4 music are measured per beat too, so a waltz at 180 BPM has 60 bars a minute. For setting a practice tempo once you know the BPM, open the <a href="/metronome/">online metronome</a>.</p>',
			'half-double',
		),
		array(
			'Getting an accurate BPM',
			'<p>Tap for at least 8 beats, ideally 16, and tap the downbeat of the bar as well as the beats in between so you stay anchored. Tap on a surface you can feel: a mouse button, a keyboard key or the screen of a phone all work, but a laptop touchpad can miss fast taps. Watch the stability number: a song with a live drummer will show 85-95%, a programmed track tapped carefully will show 95% or more. If the average and last-taps numbers diverge by more than a couple of BPM, the song has a tempo change, a rubato intro or a slowing outro; tap only through the steady section. Finally, remember that the counter measures <em>your</em> taps, so a reading of 123.4 on a track produced at 124 BPM is your timing, not the song.</p>',
			'accuracy',
		),
	),
	'fixes'        => array(
		array( 'The BPM is twice or half what it should be', 'You tapped a different subdivision of the beat than the song is written in. Press Halve or Double; the stats update immediately.' ),
		array( 'Keys do not register', 'Click once on the page so it has focus. Space, Enter, letters and numbers all count as taps; keys that control the browser (Tab, Escape, function keys) are ignored.' ),
		array( 'The count resets while I am still tapping', 'The counter starts over after a 3 second pause. If the song has long gaps between beats (under 20 BPM), untick "Auto reset after a pause".' ),
		array( 'Stability is low', 'You lost the pulse or your device missed some taps. Reset, listen for a bar first, then tap on a mouse button or key rather than a touchpad.' ),
	),
	'faq'          => array(
		array( 'How do I find the BPM of a song?', 'Play the song, tap along on every beat for at least 8 beats, and read the BPM. If it looks half or double what you expect, press Halve or Double.' ),
		array( 'How accurate is a tap BPM counter?', 'With 16 steady taps the average is within about 1 BPM of the true tempo. Your own timing, not the tool, is the limit; the stability score tells you how steady you were.' ),
		array( 'What is the most common BPM for songs?', 'Most popular music sits between 100 and 130 BPM, with 120 the single most common tempo. Hip hop is usually slower (85-100) and drum and bass much faster (170-175).' ),
		array( 'Can I use this tap tempo on my phone?', 'Yes. Tap the large area with your thumb. Phones register taps precisely, and the auto reset lets you measure track after track.' ),
		array( 'What does beat length in ms mean?', 'The time of one beat in milliseconds, which is 60000 divided by the BPM. Producers use it to set delay and reverb times that lock to the tempo.' ),
		array( 'Does the tap BPM counter listen to the music?', 'No. It does not use the microphone; it only measures the timing of your taps. Nothing is recorded or sent anywhere.' ),
	),
	'related'      => array( 'metronome', 'guitar-tuner', 'tone-generator', 'spacebar-clicker', 'sound-test', 'reaction-time-test' ),
	'updated'      => '2026-10-28',
);
