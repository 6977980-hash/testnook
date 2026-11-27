<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Audio Latency Test',
	'seo_title'      => 'Audio Latency Test: Check Bluetooth Headphone Delay in ms',
	'description'    => 'Free audio latency test. Tap along with clicks to measure the sound delay of Bluetooth headphones, earbuds or speakers in milliseconds, then compare with wired.',
	'intro'          => 'Do your Bluetooth headphones lag behind the video or the game? This test plays a steady click and you tap along with what you hear. The average gap between the clicks and your taps shows the delay in milliseconds. Run it once wired and once on Bluetooth: the difference is the delay your wireless connection adds.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'audio-latency-test' ),
	'scripts'        => array( 'audio-latency-test' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-bar al-bar">
	<div class="seg" role="group" aria-label="What you are testing">
		<button type="button" data-al-label="Wired" aria-pressed="true">Wired</button>
		<button type="button" data-al-label="Bluetooth" aria-pressed="false">Bluetooth</button>
		<button type="button" data-al-label="Speakers" aria-pressed="false">Speakers</button>
	</div>
	<div class="seg" role="group" aria-label="Number of clicks">
		<button type="button" data-al-beats="12" aria-pressed="false">12 clicks</button>
		<button type="button" data-al-beats="16" aria-pressed="true">16 clicks</button>
		<button type="button" data-al-beats="20" aria-pressed="false">20 clicks</button>
	</div>
	<label class="al-vol" for="al-volume">Volume <input type="range" id="al-volume" min="5" max="100" value="40"> <output id="al-volout" for="al-volume">40%</output></label>
</div>
<div class="tool-stage al-stage" id="al-stage" tabindex="0" role="button" aria-label="Tap area: tap here or press any key with each click you hear">
	<div class="al-ring" id="al-ring" aria-hidden="true"></div>
	<div class="al-msg"><strong id="al-big">Press Start</strong><span id="al-small">Put on your headphones, press Start, then tap here with each click.</span></div>
</div>
<div class="btn-row al-foot"><button type="button" class="btn" id="al-start">Start</button></div>
<div class="stats">
	<div class="stat"><span class="stat-label">Average offset</span><span class="stat-value" id="al-avg">-</span></div>
	<div class="stat"><span class="stat-label">Spread</span><span class="stat-value" id="al-sd">-</span></div>
	<div class="stat"><span class="stat-label">Taps counted</span><span class="stat-value" id="al-n">-</span></div>
	<div class="stat"><span class="stat-label">Browser-reported delay</span><span class="stat-value" id="al-os">-</span></div>
</div>
<p class="tool-status" id="al-status" aria-live="polite">Pick Wired or Bluetooth, press Start and tap with the clicks. Nothing is recorded or sent.</p>
<div class="al-runs" id="al-runs-box" hidden>
	<div class="table-scroll"><table><thead><tr><th scope="col">Run</th><th scope="col">Connection</th><th scope="col">Average offset</th><th scope="col">Spread</th></tr></thead><tbody id="al-runs"></tbody></table></div>
</div>',
	'howto'          => array(
		'Connect the headphones, earbuds or speakers you want to test and set the volume to a comfortable level. Press <strong>Wired</strong>, <strong>Bluetooth</strong> or <strong>Speakers</strong> so the run is labeled.',
		'Press <strong>Start</strong>. Four count-in clicks play while the circle flashes, so you can find the beat.',
		'After the count-in the circle stops flashing. Close your eyes and tap the box, or press Space or any key, exactly with each click you <em>hear</em>. Do not try to guess ahead; just tap in time with the sound.',
		'After 16 clicks (about 17 seconds) the test shows your <strong>average offset</strong> in milliseconds and the <strong>spread</strong> of your taps.',
		'Switch to the other connection, press its label and run the test again. The difference between the wired and Bluetooth runs is the delay Bluetooth adds. Run each twice if the two runs disagree by more than 20 ms.',
	),
	'howto_title'    => 'How to test audio latency',
	'results'        => '<p>The <strong>average offset</strong> is how long after each click left the browser your tap arrived, on average. It is the sound delay of your device <em>plus</em> your own timing, which is why one run on its own is only a rough number and two runs are better than one.</p>
<ul>
<li><strong>Wired headphones:</strong> the offset is mostly you. People who tap to a beat usually land a little early or late by a few tens of milliseconds, and that habit stays about the same from run to run.</li>
<li><strong>Bluetooth:</strong> the offset grows by the delay of the wireless link. Classic Bluetooth audio adds roughly 100 to 200 ms; the newer LE Audio standard aims for 20 to 30 ms. Game modes and low-latency codecs sit in between.</li>
<li><strong>The difference</strong> between a wired run and a Bluetooth run is the best number this test gives, because your own timing cancels out. Under about 50 ms most people do not notice a lip-sync gap; above 100 ms speech in videos looks out of sync and rhythm games feel late.</li>
<li><strong>Spread</strong> is how much your taps varied. Under 30 ms is steady; above 60 ms, run again with your eyes closed.</li>
<li><strong>Browser-reported delay</strong> is the output latency the browser itself estimates (the Web Audio <code>outputLatency</code> value). Some browsers report the Bluetooth delay here, many report only their own buffer or nothing at all.</li>
</ul>',
	'extra'          => array(
		array(
			'Why Bluetooth audio is late',
			'<p>A wired headphone gets the signal as it is played. A Bluetooth headphone gets it in compressed packets: the phone or computer encodes the sound, sends it over the radio, and the headphone buffers a little before playing it so a lost packet does not cause a dropout. Each step adds delay, and the buffer is the biggest part. That is why the same headphones can be late on one phone and better on another, and why "game mode" settings, which shrink the buffer, help.</p>
<p>Video apps such as YouTube and Netflix delay the picture to match the sound on many phones, so lip sync can look fine there while a game or a music app still feels late. This test hears the delay the way a game does: raw sound, with no picture correction.</p>',
			'why-bluetooth-lags',
		),
		array(
			'How to reduce headphone latency',
			'<ul>
<li>Turn on the game mode or low latency mode in the headphone\'s app.</li>
<li>Use the headphones\' own 2.4 GHz USB dongle if they came with one; it is usually much faster than Bluetooth.</li>
<li>On Android, the codec can be chosen in Developer options; some codecs and devices support low-latency modes.</li>
<li>Keep the phone close, with no body or wall between it and the earbuds, so fewer packets need resending.</li>
<li>For rhythm games, use the game\'s audio offset setting. The offset from this test is a good starting value.</li>
<li>For music production and competitive games, use wired headphones.</li>
</ul>
<p>If one side is silent or quieter, start with the <a href="/headphone-test/">headphone test</a> instead; a delay test needs both ears working.</p>',
			'reduce',
		),
	),
	'fixes'          => array(
		array( 'I hear no clicks', 'Raise the volume slider and the system volume, and check that the right output is selected. On iPhone, turn off silent mode. If you hear nothing in any test, try the <a href="/sound-test/">sound test</a> first.' ),
		array( 'The result says too few taps', 'A tap only counts if it lands within a quarter second before to a half second after a click. Tap once per click, steadily, and keep going until the end.' ),
		array( 'The two runs give very different numbers', 'Your timing changes a little from run to run. Run each connection twice and compare the averages. A spread above 60 ms means the taps were uneven: close your eyes and tap with the sound only.' ),
		array( 'Bluetooth shows a negative difference', 'Your Bluetooth run was more relaxed or the wired one was late. Run both again. A modern low-latency mode can also be within 20 ms of wired, which is inside your own tapping variation.' ),
	),
	'faq'            => array(
		array( 'How do I check my Bluetooth headphone latency?', 'Run this test once with wired headphones (or the phone speaker) and once with your Bluetooth headphones, tapping with the clicks each time. The difference between the two averages is the Bluetooth delay.' ),
		array( 'What is a normal Bluetooth audio delay?', 'Classic Bluetooth audio usually adds about 100 to 200 ms. Low-latency codecs and game modes cut that, and the newer LE Audio standard targets 20 to 30 ms.' ),
		array( 'Why does the test include my reaction time?', 'It does not use reaction time: you tap in rhythm, not in response to each click, so your hand moves with the beat rather than after it. What remains is your small timing habit, which is about the same on every run and cancels out when you compare two connections.' ),
		array( 'Is any audio recorded?', 'No. The page plays clicks and reads the time of your taps. It does not use the microphone, and nothing is sent to Testnook.' ),
		array( 'Can a browser measure the delay without me tapping?', 'Not reliably. The browser only knows when it hands the sound to the system; what the headphone does after that is invisible to it. Some browsers report an estimate, shown under Browser-reported delay, but many leave out the Bluetooth part.' ),
		array( 'How much delay is noticeable?', 'Most people notice lip-sync errors from around 100 ms, and musicians and rhythm game players feel delays well below that. Under 50 ms feels close to instant for most uses.' ),
	),
	'sources'        => array(
		array( 'Wikipedia: Bluetooth (LE Audio latency vs Bluetooth Classic audio)', 'https://en.wikipedia.org/wiki/Bluetooth' ),
		array( 'MDN: AudioContext.outputLatency', 'https://developer.mozilla.org/en-US/docs/Web/API/AudioContext/outputLatency' ),
	),
	'trust'          => 'No microphone, nothing is sent to Testnook',
	'related'        => array( 'headphone-test', 'sound-test', 'channel-test', 'mic-test', 'tap-bpm', 'metronome' ),
	'updated'        => '2026-11-27',
);
