<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Dog Whistle',
	'seo_title'      => 'Dog Whistle Online: High Frequency Sound From 4 to 22 kHz',
	'description'    => 'Free online dog whistle. Play a high-pitched whistle sound from 4 kHz to 22 kHz with hold, short, double and recall patterns for training. Works on phones and PCs.',
	'intro'          => 'A training whistle in your browser. Pick a pitch from an audible 4 kHz up to a near-silent 22 kHz, then hold the button or play a short, long, double or recall pattern. Dogs hear these high frequencies far better than people, so the sound carries to them without being shrill for everyone else.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'dog-whistle' ),
	'scripts'        => array( 'dog-whistle' ),
	'embed_height'   => 700,
	'tool'           => '<div class="tool-stage dw-stage">
	<div class="dw-freq" id="dw-hzout" aria-live="polite">15.0 kHz</div>
	<div class="dw-wave" id="dw-wave" aria-hidden="true"></div>
	<button type="button" class="dw-hold" id="dw-hold">Hold to whistle</button>
	<p class="dw-note" id="dw-note"></p>
</div>
<div class="dw-controls">
	<div>
		<div class="field"><label for="dw-hz">Frequency</label><input type="range" id="dw-hz" min="4000" max="22000" step="100" value="15000"></div>
		<div class="dw-presets" role="group" aria-label="Frequency presets">
			<button type="button" class="btn btn-sm" data-dw-hz="4000">4 kHz</button>
			<button type="button" class="btn btn-sm" data-dw-hz="8000">8 kHz</button>
			<button type="button" class="btn btn-sm" data-dw-hz="12000">12 kHz</button>
			<button type="button" class="btn btn-sm" data-dw-hz="16000">16 kHz</button>
			<button type="button" class="btn btn-sm" data-dw-hz="18000">18 kHz</button>
			<button type="button" class="btn btn-sm" data-dw-hz="20000">20 kHz</button>
			<button type="button" class="btn btn-sm" data-dw-hz="22000">22 kHz</button>
		</div>
	</div>
	<div>
		<div class="field"><label for="dw-vol">Volume <output id="dw-volout" for="dw-vol">50%</output></label><input type="range" id="dw-vol" min="5" max="100" step="1" value="50"></div>
		<div class="dw-patterns" role="group" aria-label="Whistle patterns">
			<button type="button" class="btn btn-sm" data-dw-pattern="short">Short</button>
			<button type="button" class="btn btn-sm" data-dw-pattern="long">Long</button>
			<button type="button" class="btn btn-sm" data-dw-pattern="double">Double</button>
			<button type="button" class="btn btn-sm" data-dw-pattern="recall">Recall (3 short)</button>
			<button type="button" class="btn btn-sm" data-dw-pattern="trill">Trill</button>
			<button type="button" class="btn btn-sm" id="dw-sweep">Sweep 4-22 kHz</button>
		</div>
	</div>
</div>
<p class="tool-status" id="dw-status" aria-live="polite">Start at a low volume. Phone and laptop speakers may not play the highest pitches.</p>',
	'howto'          => array(
		'Turn your device volume to about half and keep the page volume low to start with.',
		'Choose a frequency. For training, 4-12 kHz is a clear whistle that you can hear too; 16-22 kHz is the classic "silent" dog whistle range that most adults barely hear.',
		'Press and hold <strong>Hold to whistle</strong> for as long as you want the sound, or tap a pattern: <strong>Short</strong>, <strong>Long</strong>, <strong>Double</strong>, <strong>Recall</strong> or <strong>Trill</strong>.',
		'Use the same pitch and pattern for the same command every time, and reward your dog straight after it responds.',
		'Use <strong>Sweep</strong> once to hear where the sound disappears for you and what your speaker can still play.',
	),
	'howto_title'    => 'How to use the online dog whistle',
	'results'        => '<p>Humans hear up to about 20 kHz as children, falling to around 15-17 kHz for many adults. Dogs hear up to roughly 45 kHz, so a 16-22 kHz whistle sounds faint or silent to you but clear to them. That is the whole idea of a "silent" dog whistle: it is not silent, just above most human hearing.</p>
<div class="table-scroll"><table>
<thead><tr><th>Frequency</th><th>Who hears it</th><th>Typical use</th></tr></thead>
<tbody>
<tr><td>4-8 kHz</td><td>Everyone</td><td>Audible training whistle, recall at a distance</td></tr>
<tr><td>8-14 kHz</td><td>Most people and dogs</td><td>Sharper training signal</td></tr>
<tr><td>15-18 kHz</td><td>Children, young adults, dogs</td><td>Quieter whistle for shared spaces</td></tr>
<tr><td>18-22 kHz</td><td>Few adults; dogs clearly</td><td>"Silent" dog whistle range</td></tr>
</tbody></table></div>
<p>Small phone and laptop speakers often roll off above 16-18 kHz, so the top of the range may come out weak or not at all. If your dog does not react to 20 kHz, try 12-16 kHz or use headphones held near the dog only for a quick check.</p>',
	'extra'          => array(
		array(
			'Training with a whistle',
			'<p>A whistle sounds the same every time, whoever blows it, and carries further than a voice, which makes it a reliable recall signal. Start indoors: play one pattern (for example the recall pattern) and immediately give a treat, ten times in a row, before you ask for anything. Then play it when your dog is a few steps away and reward it for coming. Increase the distance and distractions slowly. Keep one pattern for one command, and never use the whistle to scold. A whistle is a cue, not a way to stop barking by itself; it works only as well as the training behind it.</p>',
			'training',
		),
		array(
			'Can other animals hear it?',
			'<p>Cats hear even higher than dogs (up to about 64 kHz) and will usually notice the sound too. Rabbits, guinea pigs and many rodents are sensitive to high pitches, so keep the volume low and the sessions short around other pets. To find the highest pitch you can hear yourself, try the <a href="/hearing-frequency-test/">hearing frequency test</a>, and for any other exact tone use the <a href="/tone-generator/">tone generator</a>.</p>',
			'other-animals',
		),
	),
	'fixes'          => array(
		array( 'I cannot hear anything', 'Above about 16 kHz that is normal for adults. Lower the frequency to 8 kHz to check that sound works at all, check the volume and silent switch, and on iPhone make sure the ring/silent switch is not muting the page.' ),
		array( 'My dog does not react', 'Many small speakers cannot play above 18 kHz. Try 10-16 kHz, move closer, or connect a better speaker. Dogs also need training to link the whistle with a reward; at first it is just a sound.' ),
		array( 'The sound clicks or crackles', 'Lower the page volume. Very high tones at full volume can overload small speakers. Using a wired speaker or headphones instead of Bluetooth also helps, as Bluetooth codecs may cut the highest frequencies.' ),
	),
	'faq'            => array(
		array( 'Does an online dog whistle really work?', 'Yes, if your speaker can play the frequency. A browser can produce tones up to about 22 kHz, inside the classic dog whistle range. Phone speakers are usually fine up to 16-18 kHz.' ),
		array( 'What frequency is a dog whistle?', 'Most dog whistles are between 16 and 22 kHz. Adjustable training whistles start lower, around 5-12 kHz, where people can hear them too.' ),
		array( 'Why can I not hear the dog whistle?', 'Human hearing usually tops out at 15-20 kHz and falls with age. Above that you hear nothing even though a dog can.' ),
		array( 'Can a dog whistle stop barking?', 'Only as part of training. Use the whistle as a cue for a behaviour, such as coming to you, and reward it. A loud sound used to startle a dog is not recommended.' ),
		array( 'Is the dog whistle harmful to dogs?', 'Not at sensible volume and short use. Do not play it loudly next to a dog\'s ears or for long periods, and stop if your dog seems distressed.' ),
		array( 'Does it work on iPhone and Android?', 'Yes. Tap and hold the button. If nothing plays on iPhone, turn off silent mode and turn the media volume up.' ),
	),
	'disclaimer'     => 'Use the whistle at a low to moderate volume and for short periods. High-pitched sounds can be uncomfortable or harmful for dogs, cats and other pets at close range, and can damage speakers at full volume. Never play it directly into an animal\'s ear.',
	'related'        => array( 'tone-generator', 'hearing-frequency-test', 'white-noise-generator', 'speaker-cleaner', 'sound-test', 'bass-test', 'metronome', 'headphone-test' ),
	'updated'        => '2026-10-29',
);
