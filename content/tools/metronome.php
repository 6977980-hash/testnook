<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Online Metronome',
	'seo_title'    => 'Online Metronome: Free Metronome 20-300 BPM with Tap Tempo',
	'description'  => 'Free online metronome. Set any tempo from 20 to 300 BPM, pick a time signature and subdivision, tap the tempo, accent the first beat and practice to a click.',
	'intro'        => 'A precise metronome in your browser, with nothing to install. Type a tempo or drag the slider, pick a time signature, add eighth-note or triplet subdivisions, tap along to find a tempo, and press Space to start and stop. The click is scheduled by the audio engine, so it stays steady even when the page is busy.',
	'device'       => 'any',
	'ads'          => 'content',
	'styles'       => array( 'metronome' ),
	'scripts'      => array( 'metronome' ),
	'embed_height' => 720,
	'tool'         => '<div class="tool-stage mn-stage" id="mn-stage" tabindex="0" aria-label="Metronome">
	<div class="mn-bpm">
		<label for="mn-bpm">Tempo (BPM)</label>
		<div class="mn-bpm-row">
			<button type="button" class="btn btn-sm" data-mn-step="-10" aria-label="Down 10 BPM">-10</button>
			<button type="button" class="btn btn-sm" data-mn-step="-1" aria-label="Down 1 BPM">-1</button>
			<input type="number" id="mn-bpm" min="20" max="300" step="1" value="120" inputmode="numeric">
			<button type="button" class="btn btn-sm" data-mn-step="1" aria-label="Up 1 BPM">+1</button>
			<button type="button" class="btn btn-sm" data-mn-step="10" aria-label="Up 10 BPM">+10</button>
		</div>
		<input type="range" id="mn-slider" min="20" max="300" step="1" value="120" aria-label="Tempo slider">
		<div class="mn-mark" id="mn-mark">Moderato · 500 ms per beat</div>
	</div>
	<div class="mn-beats" id="mn-beats" aria-hidden="true"></div>
	<div class="mn-presets btn-row" aria-label="Common tempos">
		<button type="button" class="btn btn-sm" data-mn-preset="60">60</button>
		<button type="button" class="btn btn-sm" data-mn-preset="80">80</button>
		<button type="button" class="btn btn-sm" data-mn-preset="100">100</button>
		<button type="button" class="btn btn-sm" data-mn-preset="120">120</button>
		<button type="button" class="btn btn-sm" data-mn-preset="140">140</button>
		<button type="button" class="btn btn-sm" data-mn-preset="160">160</button>
		<button type="button" class="btn btn-sm" data-mn-preset="180">180</button>
	</div>
	<div class="mn-opts">
		<div class="field"><span class="mn-label">Time signature</span>
			<div class="seg" role="group" aria-label="Time signature">
				<button type="button" data-mn-sig="1/4" aria-pressed="false">1/4</button>
				<button type="button" data-mn-sig="2/4" aria-pressed="false">2/4</button>
				<button type="button" data-mn-sig="3/4" aria-pressed="false">3/4</button>
				<button type="button" data-mn-sig="4/4" aria-pressed="true">4/4</button>
				<button type="button" data-mn-sig="5/4" aria-pressed="false">5/4</button>
				<button type="button" data-mn-sig="6/8" aria-pressed="false">6/8</button>
				<button type="button" data-mn-sig="7/8" aria-pressed="false">7/8</button>
			</div>
		</div>
		<div class="field"><span class="mn-label">Subdivision</span>
			<div class="seg" role="group" aria-label="Subdivision">
				<button type="button" data-mn-sub="1" aria-pressed="true">Beat</button>
				<button type="button" data-mn-sub="2" aria-pressed="false">Eighths</button>
				<button type="button" data-mn-sub="3" aria-pressed="false">Triplets</button>
				<button type="button" data-mn-sub="4" aria-pressed="false">Sixteenths</button>
			</div>
		</div>
		<div class="field"><span class="mn-label">Sound</span>
			<div class="seg" role="group" aria-label="Click sound">
				<button type="button" data-mn-sound="click" aria-pressed="true">Click</button>
				<button type="button" data-mn-sound="wood" aria-pressed="false">Wood</button>
				<button type="button" data-mn-sound="beep" aria-pressed="false">Beep</button>
			</div>
		</div>
		<div class="field"><label class="mn-check"><input type="checkbox" id="mn-accent" checked> Accent the first beat</label></div>
		<div class="field"><label for="mn-volume">Volume <output id="mn-volout" for="mn-volume">60%</output></label><input type="range" id="mn-volume" min="0" max="100" value="60"></div>
	</div>
	<div class="mn-controls btn-row">
		<button type="button" class="btn btn-primary" id="mn-play" aria-pressed="false">Start</button>
		<button type="button" class="btn" id="mn-tap">Tap tempo</button>
	</div>
</div>
<p class="tool-status" id="mn-status" aria-live="polite">Set a tempo and press Start. Space starts and stops, arrow keys change the tempo, T taps.</p>',
	'howto'        => array(
		'Set the tempo: type a number from 20 to 300 BPM, drag the slider, use the -10/-1/+1/+10 buttons, or click a preset. The Italian marking (Andante, Allegro...) updates as you go.',
		'Pick the <strong>time signature</strong>. The first beat of each bar is accented and shown in orange; untick "Accent the first beat" for an even click.',
		'Add a <strong>subdivision</strong> if you want eighth notes, triplets or sixteenths between the beats. They play quieter than the beats.',
		'Press <strong>Start</strong> (or Space with the metronome focused). The dots show the current beat and the frame pulses on every click.',
		'Do not know the tempo? Press <strong>Tap tempo</strong> (or T) four or more times in time with the music and the BPM is set from your taps.',
	),
	'howto_title'  => 'How to use the online metronome',
	'results'      => '<p>BPM means <strong>beats per minute</strong>: 60 BPM is one beat per second, 120 BPM is two. The metronome shows the length of one beat in milliseconds and the traditional Italian tempo marking for the range you are in.</p>
<div class="table-scroll"><table>
<thead><tr><th>BPM</th><th>Marking</th><th>Feel</th></tr></thead>
<tbody>
<tr><td>Under 40</td><td>Grave</td><td>Very slow and solemn</td></tr>
<tr><td>40-60</td><td>Largo</td><td>Broad, slow</td></tr>
<tr><td>66-76</td><td>Adagio</td><td>Slow and expressive</td></tr>
<tr><td>76-108</td><td>Andante</td><td>Walking pace</td></tr>
<tr><td>108-120</td><td>Moderato</td><td>Moderate</td></tr>
<tr><td>120-156</td><td>Allegro</td><td>Fast and bright</td></tr>
<tr><td>156-176</td><td>Vivace</td><td>Lively</td></tr>
<tr><td>176-200</td><td>Presto</td><td>Very fast</td></tr>
<tr><td>Over 200</td><td>Prestissimo</td><td>As fast as possible</td></tr>
</tbody></table></div>
<p>In 6/8 and 7/8 the click counts eighth notes, so set the BPM for the eighth note (a 6/8 piece felt in two at 60 BPM is 180 BPM here). Most pop and rock sits between 100 and 130 BPM, hip hop around 85-100, house 120-128, drum and bass 170-175. If you have a song and want its tempo, use the <a href="/tap-bpm/">tap BPM counter</a>.</p>',
	'extra'        => array(
		array(
			'How to practice with a metronome',
			'<p>Start slower than you think you need: pick a tempo at which you can play the passage perfectly, then raise it by 3-5 BPM each time you get three clean repetitions. Use subdivisions to lock in fast passages, and switch them off once the pulse is internal. For rhythm training, set the accent off and try to feel the click on beats 2 and 4, or halve the tempo so the click lands only on beat 1 and you fill the rest yourself. Drummers often practice with the click on the off-beat; set 2/4 at half tempo and count the click as the "and".</p>
<p>A metronome is a reference, not a cage: once a piece is steady, play it without the click and record yourself to check that the tempo holds. Short daily sessions with the metronome beat long occasional ones.</p>',
			'practice',
		),
		array(
			'Why this metronome stays in time',
			'<p>A naive browser metronome uses a JavaScript timer, which can drift by tens of milliseconds whenever the page is busy, the tab is scrolled or the device saves power. This metronome instead schedules every click a fraction of a second ahead on the Web Audio clock, which runs on the audio hardware and is accurate to a sample. The JavaScript timer only tops up the schedule, so a hiccup in the page never moves a click. The visual beat dots are driven by the same schedule, and Bluetooth headphones add their own fixed delay of 100-200 ms to both sound and screen, so for serious practice use wired headphones or speakers. If you need a tone rather than a click, the <a href="/tone-generator/">tone generator</a> plays a continuous pitch.</p>',
			'accuracy',
		),
	),
	'fixes'        => array(
		array( 'No sound', 'Press Start once more, because browsers only allow sound after a click on the page. Check the volume slider on the page and the system volume, and that the browser is sending audio to the device you expect. On iPhone, turn off the silent switch on the side.' ),
		array( 'The click is late or uneven with Bluetooth headphones', 'Bluetooth adds 100-200 ms of delay, which is constant but makes the click arrive after the visual pulse. Use wired headphones or the built-in speaker for practice, or play along by ear and ignore the dots.' ),
		array( 'The metronome stops when I switch tabs', 'It stops when the page is hidden, so it does not keep clicking in the background by mistake. Keep the tab open in front, or in a separate window beside your sheet music.' ),
		array( 'The tempo from tap tempo is wrong', 'Tap at least four times at a steady pace and let the counter settle. Taps more than 2.5 seconds apart start a new measurement. Tap the beat, not the subdivision, or halve or double the result.' ),
	),
	'faq'          => array(
		array( 'Is this metronome accurate?', 'Yes. Clicks are scheduled on the Web Audio clock, which is sample-accurate, rather than with a JavaScript timer. Any delay from Bluetooth audio is constant and does not change the tempo.' ),
		array( 'What tempo should I practice at?', 'Slow enough to play every note correctly, which is often 50-70% of the final tempo. Raise it in small steps only when the passage is clean.' ),
		array( 'Can I use the metronome on my phone?', 'Yes. It works in any mobile browser. Keep the screen on, because some phones pause audio from a browser tab when the screen locks.' ),
		array( 'What is 6/8 time on a metronome?', 'Six eighth notes per bar, usually felt in two groups of three. Set 6/8 here and the accent falls on beat 1 of each group of six; choose the BPM of the eighth note, or set 2/4 with triplet subdivision to feel it in two.' ),
		array( 'What do the Italian words mean?', 'They are the traditional tempo markings used in sheet music: Largo is slow, Andante a walking pace, Allegro fast, Presto very fast. The ranges overlap and are a guide, not a rule.' ),
		array( 'Does the metronome work offline?', 'Once the page has loaded, the click is generated in your browser without any further downloads, but the page itself needs an internet connection to open.' ),
	),
	'related'      => array( 'tap-bpm', 'tone-generator', 'guitar-tuner', 'sound-test', 'headphone-test', 'speaker-cleaner' ),
	'updated'      => '2026-10-28',
);
