<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Bass Test',
	'seo_title'      => 'Bass Test: Subwoofer & Speaker Bass Test Tones (20-200 Hz)',
	'description'    => 'Free bass test for subwoofers, speakers and headphones. Play 20 to 200 Hz tones, sweep to find your lowest note, check for rattles, try kick and 808 hits.',
	'intro'          => 'How low does your setup go? Play pure bass tones from 20 to 200 Hz, sweep down until the sound fades to find your speaker\'s real low end, run a slow sweep to catch rattles, and try a kick drum and a long 808 hit to hear how punchy and clean the bass is. Works for subwoofers, speakers, headphones and car audio.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'bass-test' ),
	'scripts'        => array( 'bass-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-stage bt-stage">
	<div class="bt-top"><div class="bt-cone" id="bt-cone" aria-hidden="true"></div><div class="bt-read"><strong id="bt-freq">- Hz</strong><span id="bt-note"></span></div></div>
	<p class="bt-label">Bass tones (8 s each)</p>
	<div class="bt-grid">
		<button type="button" class="btn" data-bt-f="20" aria-pressed="false">20 Hz</button>
		<button type="button" class="btn" data-bt-f="25" aria-pressed="false">25 Hz</button>
		<button type="button" class="btn" data-bt-f="30" aria-pressed="false">30 Hz</button>
		<button type="button" class="btn" data-bt-f="40" aria-pressed="false">40 Hz</button>
		<button type="button" class="btn" data-bt-f="50" aria-pressed="false">50 Hz</button>
		<button type="button" class="btn" data-bt-f="60" aria-pressed="false">60 Hz</button>
		<button type="button" class="btn" data-bt-f="80" aria-pressed="false">80 Hz</button>
		<button type="button" class="btn" data-bt-f="100" aria-pressed="false">100 Hz</button>
		<button type="button" class="btn" data-bt-f="120" aria-pressed="false">120 Hz</button>
		<button type="button" class="btn" data-bt-f="150" aria-pressed="false">150 Hz</button>
		<button type="button" class="btn" data-bt-f="200" aria-pressed="false">200 Hz</button>
	</div>
	<p class="bt-label">Sweeps and beats</p>
	<div class="bt-grid is-wide">
		<button type="button" class="btn" data-bt="down" aria-pressed="false">Sweep down</button>
		<button type="button" class="btn" data-bt="up" aria-pressed="false">Sweep up</button>
		<button type="button" class="btn" data-bt="rattle" aria-pressed="false">Rattle check</button>
		<button type="button" class="btn" data-bt="kick" aria-pressed="false">Kick drum</button>
		<button type="button" class="btn" data-bt="808" aria-pressed="false">808 bass</button>
		<button type="button" class="btn btn-primary" id="bt-stop">Stop</button>
	</div>
	<button type="button" class="btn btn-primary" id="bt-mark" hidden>I can\'t hear it any more</button>
	<div class="bt-row"><button type="button" class="btn btn-sm" data-bt="slider" aria-pressed="false">Play</button><input type="range" id="bt-slider" min="10" max="250" step="1" value="45" aria-label="Frequency in hertz"><output id="bt-sliderout" for="bt-slider">45 Hz</output></div>
	<label class="bt-row">Volume <input type="range" id="bt-volume" min="0" max="100" step="1" value="30"><output id="bt-volout" for="bt-volume">30%</output></label>
	<div class="stats"><div class="stat"><span class="stat-label">Lowest bass you marked</span><span class="stat-value" id="bt-low">-</span></div></div>
</div>
<p class="tool-status" id="bt-status" aria-live="polite">Start with your system volume low, then press 50 Hz.</p>',
	'howto'          => array(
		'Turn your system volume down before you start. Bass needs more power than other sounds and can surprise you.',
		'Press <strong>50 Hz</strong> and raise the volume slider until you hear or feel it clearly. That is your reference level.',
		'Press <strong>Sweep down</strong> (200 to 15 Hz) and press <strong>I can\'t hear it any more</strong> the moment the tone fades. The result is your setup\'s lowest usable bass.',
		'Run the <strong>Rattle check</strong> and listen for buzzing from the speaker, the room or loose objects.',
		'Play the <strong>Kick drum</strong> and <strong>808 bass</strong> to judge punch and clarity with real music sounds.',
	),
	'howto_title'    => 'How to test your bass',
	'results'        => '<p>Compare your lowest marked frequency with what your speakers usually reach:</p>
<div class="table-scroll"><table>
<thead><tr><th>Lowest bass</th><th>Typical of</th></tr></thead>
<tbody>
<tr><td>20-30 Hz</td><td>A good subwoofer, large floor-standing speakers, or closed-back headphones with a good seal.</td></tr>
<tr><td>30-50 Hz</td><td>Small subwoofers, bookshelf speakers, good headphones and earbuds that seal well.</td></tr>
<tr><td>50-90 Hz</td><td>Laptop speakers, soundbars without a sub, small Bluetooth speakers.</td></tr>
<tr><td>Above 90 Hz</td><td>Phone speakers and tiny laptop speakers.</td></tr>
</tbody></table></div>
<p>Very low tones are felt as much as heard, and human hearing is much less sensitive below 40 Hz, so the low end depends on volume. Test at a level you would actually listen at. A tone that sounds higher than it should, or has a buzz on top, is distortion: the speaker cannot play that note cleanly.</p>',
	'extra'          => array(
		array(
			'Testing a subwoofer',
			'<p>Set the subwoofer\'s crossover to 80 Hz if it has one, which is the usual setting for most speakers. Play 30, 40, 50 and 60 Hz in turn at the same volume: they should sound roughly equally strong. If one is much louder, that is a room mode, a resonance of your room; moving the subwoofer even 30 to 50 cm along the wall often fixes it. If the sub is quiet at 80 to 120 Hz while the main speakers are thin there, the crossover is set too low. Then use the <a href="/stereo-test/">stereo test</a> to check the main speakers are balanced.</p>',
			'subwoofer',
		),
		array(
			'Headphones, earbuds and car audio',
			'<p>Headphone bass depends almost entirely on the seal. If earbuds sound thin on the 40 Hz tone, try a larger ear tip; if over-ear headphones lose bass, the pads may be worn or glasses are breaking the seal. In a car, run the rattle check at moderate volume to find buzzing door panels or a loose number plate, and play the 808 bass to hear whether the subwoofer and door speakers blend. For checking the whole range above the bass, use the <a href="/tone-generator/">tone generator</a>.</p>',
			'headphones',
		),
	),
	'fixes'          => array(
		array( 'I hear nothing below 60 Hz', 'That is normal on laptops, phones and small speakers, which cannot move enough air. Use headphones or a subwoofer for deep bass.' ),
		array( 'The subwoofer does not play', 'Check it is switched on and its volume is up, the cable goes to the SUB or LFE output, and the amplifier or TV has the subwoofer enabled. Play 40 Hz and put a hand on the sub to feel for movement.' ),
		array( 'Buzzing or rattling on some tones', 'Find the source: a loose grille, a screw, an object on the shelf, or the speaker itself. If the buzz comes from inside the speaker at moderate volume, the cone or surround may be damaged.' ),
		array( 'The bass is boomy on one note', 'A room resonance. Move the speaker or subwoofer away from corners, or reduce the bass level a little.' ),
	),
	'faq'            => array(
		array( 'What frequency is bass?', 'Bass covers roughly 20 to 250 Hz. Sub-bass, the deep rumble you feel, is 20 to 60 Hz. Most bass guitars and kick drums sit between 40 and 120 Hz.' ),
		array( 'What is the best frequency to test a subwoofer?', 'Start at 50 Hz, then check 30 and 40 Hz for depth and 80 Hz for how well it blends with the speakers.' ),
		array( 'Can a bass test damage my speakers?', 'Very low tones at high volume can damage small speakers, because the cone moves further at low frequencies. Start quietly, raise it slowly and stop if you hear distortion or a knocking sound.' ),
		array( 'Why can I feel the bass but not hear it?', 'Below about 30 Hz your ears are much less sensitive, but your body still feels the pressure. That is normal.' ),
		array( 'Can I test bass on my phone?', 'Yes, with headphones. Phone speakers play little below 150 Hz, so the low tones will sound silent on the speaker.' ),
		array( 'What is an 808?', 'The bass drum sound of the Roland TR-808 drum machine, a long low boom used in hip hop and trap. It is a demanding test because it holds deep bass for over a second.' ),
	),
	'disclaimer'     => 'Low frequencies at high volume can damage speakers and your hearing even when they do not sound loud. Start at a low volume, raise it gradually, and stop if you hear distortion or feel discomfort.',
	'related'        => array( 'stereo-test', 'tone-generator', 'headphone-test', 'sound-test', 'speaker-cleaner', 'mono-test' ),
	'updated'        => '2026-10-29',
);
