<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Speaker Cleaner',
	'seo_title'    => 'Speaker Cleaner: Remove Water From Your Phone Speaker',
	'description'  => 'Free speaker cleaner that plays a 165 Hz water eject sound to push water and dust out of your phone speaker. Works on iPhone, Android and laptops, no app needed.',
	'intro'        => 'Got water in your phone speaker? Press start and this speaker cleaner plays a low 165 Hz tone that shakes water and dust out of the grille, the same idea as the Apple Watch water lock.',
	'device'       => 'any',
	'ads'          => 'standard',
	'styles'       => array( 'speaker-cleaner' ),
	'scripts'      => array( 'speaker-cleaner' ),
	'embed_height' => 560,
	'tool'         => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Cleaning mode">
		<button type="button" data-sc-mode="tone" aria-pressed="true">Tone 165 Hz</button>
		<button type="button" data-sc-mode="pulse" aria-pressed="false">Pulse</button>
		<button type="button" data-sc-mode="sweep" aria-pressed="false">Sweep</button>
	</div>
	<label class="sc-dur">Run for
		<select id="sc-duration">
			<option value="30">30 seconds</option>
			<option value="60" selected>1 minute</option>
			<option value="120">2 minutes</option>
		</select>
	</label>
</div>
<div class="tool-stage sc-stage">
	<div class="sc-rings" aria-hidden="true"><span></span><span></span><span></span></div>
	<button type="button" class="sc-go" id="sc-go"><span id="sc-label">Start cleaning</span><span class="sc-time" id="sc-time">1:00</span></button>
</div>
<div class="meter sc-meter"><span id="sc-progress"></span></div>
<div class="field sc-vol">
	<label for="sc-volume">Volume <output id="sc-volout" for="sc-volume">40%</output></label>
	<input type="range" id="sc-volume" min="5" max="100" step="5" value="40">
</div>
<p class="tool-status" id="sc-status" aria-live="polite">Turn your phone so the speaker faces down, turn off silent mode, then press Start.</p>',
	'howto'        => array(
		'Turn off silent mode (on iPhone, flip the ring/silent switch so no orange shows) and take off any case that covers the speaker.',
		'Hold the phone with the speaker grille facing <strong>down</strong>, so gravity helps the water drip out.',
		'Press <strong>Start cleaning</strong>. The tone starts quietly and rises to the volume you set over two seconds.',
		'Raise the volume slider and your device volume to about 70-100% if the sound is still muffled. Watch for tiny droplets on the grille and wipe them away.',
		'Repeat two or three times. Try <strong>Pulse</strong> or <strong>Sweep</strong> mode if the plain tone is not enough.',
	),
	'howto_title'  => 'How to use the speaker cleaner',
	'results'      => '<p>There is no score here: the result is how your speaker sounds afterwards. A wet speaker sounds quiet, crackly or "underwater". After one or two runs of the water eject sound most people hear the tone get louder and clearer as the water leaves. If the sound is fully back to normal, you are done.</p>
<p>If the tone stays muffled after three or four runs, let the phone dry for a few hours in a warm, airy spot (not on a heater) and try again. Water deep inside the speaker chamber can take time to evaporate.</p>',
	'results_title' => 'How to tell if it worked',
	'extra'        => array(
		array(
			'How does a speaker cleaner sound work?',
			'<p>A phone speaker has a small diaphragm behind a mesh grille. When water sits in the mesh, its surface tension holds it in place and blocks the sound. A low frequency tone makes the diaphragm move further on each cycle than speech or music does, so it pushes air hard against the mesh and flicks the water out. 165 Hz is a popular choice because it is low enough to move a lot of air, yet still inside the range that small phone speakers can actually play.</p>
<p>Pulse mode switches the tone on and off twice a second, which gives the water a series of sharp kicks. Sweep mode glides between 120 and 300 Hz so the speaker passes through its own resonant frequency, where it moves the most. This is the same principle as the Water Lock eject on an Apple Watch and the "water eject" shortcuts for iPhone, but it runs right in your browser with nothing to install.</p>',
			'how-it-works',
		),
		array(
			'Safety tips',
			'<ul><li>Do not plug in or charge a phone that is still wet. Wait until the port is dry.</li><li>Do not use a hair dryer, oven or rice. Heat can damage the battery and rice adds dust.</li><li>Keep the phone away from your ear while the tone plays at high volume.</li><li>A speaker cleaner removes water and loose dust. It cannot repair a speaker that was damaged by salt water, a drop or corrosion.</li></ul>',
			'safety',
		),
	),
	'fixes'        => array(
		array( 'I cannot hear anything on iPhone', 'Web audio is muted when the ring/silent switch is on. Flip the switch (or use the Action button) to ring mode, turn the volume up with the side buttons, and press Start again.' ),
		array( 'The sound is still muffled after cleaning', 'Run the cleaner two or three more times with the speaker facing down, then try Pulse mode. If that does not help, leave the phone to dry for a few hours. Gently brushing the grille with a soft, dry toothbrush can remove lint that holds water.' ),
		array( 'The tone stops when the screen locks', 'Phones pause browser audio when the screen turns off. Keep the screen on and the page open while the speaker cleaner runs.' ),
		array( 'Only the earpiece or only the bottom speaker is wet', 'Phones with stereo speakers play the tone through both the bottom speaker and the earpiece, but older phones use only the bottom one. If the earpiece stays muffled, hold the phone with the earpiece facing down, run the cleaner again, and give it some drying time.' ),
	),
	'faq'          => array(
		array( 'Does a speaker cleaner really work?', 'Yes, for water that is sitting in the speaker grille. The low 165 Hz tone makes the speaker move a lot of air, which pushes droplets out. It will not fix a speaker that is broken or corroded.' ),
		array( 'What frequency removes water from a speaker?', 'Most water eject sounds use a tone between 150 and 200 Hz. This tool uses 165 Hz by default and its Sweep mode covers 120 to 300 Hz to reach the resonant point of different speakers.' ),
		array( 'How long should I play the water eject sound?', 'One minute per run is usually enough. Repeat two or three times with the speaker facing down. If the sound is still muffled, let the phone dry naturally and try again later.' ),
		array( 'Is the speaker cleaner safe for my phone?', 'Yes. It is an ordinary tone at a volume you control, similar to music with a lot of bass. It starts quietly and rises slowly. Avoid running it for very long periods at full volume.' ),
		array( 'Does it work on iPhone and Android?', 'Yes. It works in Safari, Chrome and other modern browsers on iPhone, Android, Windows and Mac. On iPhone, turn off silent mode first or you will hear nothing.' ),
		array( 'Can I use it to clean dust from my speaker?', 'It can shake out loose dust and lint, especially in Pulse mode. Stuck-on dirt needs a soft dry brush. Never push pins or liquids into the grille.' ),
	),
	'related'      => array( 'sound-test', 'headphone-test', 'mic-test', 'tone-generator', 'touch-screen-test', 'dead-pixel-test' ),
	'updated'      => '2026-10-28',
);
