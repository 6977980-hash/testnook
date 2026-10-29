<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Mono Test',
	'seo_title'      => 'Mono Test: Is My Audio Playing in Mono or Stereo? (Free)',
	'description'    => 'Free mono audio test. Find out in ten seconds whether your phone, computer or headphones play in mono or stereo, and how to turn Mono Audio on or off.',
	'intro'          => 'Is your audio mono or stereo? Two quick sounds tell you. A chime sent only to the left channel is heard on both sides when the output is mono, and a special out-of-phase noise almost disappears in mono. Answer one question after each sound and the page tells you what you have, then how to switch.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'channel-test' ),
	'scripts'        => array( 'channel-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-stage ch-stage">
	<div class="ch-speakers"><div class="ch-spk" id="ch-l" aria-hidden="true">L</div><div class="ch-mid">Headphones give the clearest answer</div><div class="ch-spk" id="ch-r" aria-hidden="true">R</div></div>
	<p class="ch-label">Step 1: one-sided sound</p>
	<div class="ch-grid">
		<button type="button" class="btn" data-ch="left" aria-pressed="false">Left only</button>
		<button type="button" class="btn" data-ch="right" aria-pressed="false">Right only</button>
	</div>
	<p class="ch-label">Step 2: cancellation check</p>
	<div class="ch-grid">
		<button type="button" class="btn" data-ch="outphase" aria-pressed="false">Out-of-phase noise</button>
		<button type="button" class="btn" data-ch="inphase" aria-pressed="false">Normal noise</button>
		<button type="button" class="btn btn-primary" id="ch-stop">Stop</button>
	</div>
	<div class="ch-ask" id="ch-ask-side" hidden><strong>Where did you hear it?</strong><button type="button" class="btn btn-sm" data-ans="one">Only on that side</button><button type="button" class="btn btn-sm" data-ans="both">Both sides</button><button type="button" class="btn btn-sm" data-ans="wrong">The other side</button><button type="button" class="btn btn-sm" data-ans="none">Nothing</button></div>
	<div class="ch-ask" id="ch-ask-phase" hidden><strong>Compared with the normal noise, the out-of-phase noise was:</strong><button type="button" class="btn btn-sm" data-ans="loud">About as loud, but wider</button><button type="button" class="btn btn-sm" data-ans="quiet">Much quieter or gone</button></div>
	<label class="ch-row">Volume <input type="range" id="ch-volume" min="0" max="100" step="1" value="40"><output id="ch-volout" for="ch-volume">40%</output></label>
</div>
<p class="tool-status" id="ch-status" aria-live="polite">Put on headphones if you have them, then press Left only.</p>',
	'howto'          => array(
		'Put on headphones or earphones if you have them; they make the answer obvious. On speakers, sit in the middle.',
		'Press <strong>Left only</strong> and answer where you heard it. On a stereo output it is only in your left ear; on a mono output it is in both.',
		'Press <strong>Normal noise</strong>, then <strong>Out-of-phase noise</strong>, and compare. In stereo both are about as loud; in mono the out-of-phase noise nearly vanishes.',
		'Read the result in the status line, then use the steps below to turn Mono Audio on or off.',
	),
	'howto_title'    => 'How to check for mono audio',
	'results'        => '<p>The two steps check the same thing in different ways, so together they leave little doubt:</p>
<div class="table-scroll"><table>
<thead><tr><th>Left only</th><th>Out-of-phase noise</th><th>Your output is</th></tr></thead>
<tbody>
<tr><td>Left ear only</td><td>About as loud as normal</td><td><strong>Stereo</strong></td></tr>
<tr><td>Both ears</td><td>Nearly silent</td><td><strong>Mono</strong> (Mono Audio on, or a mono device)</td></tr>
<tr><td>Both ears</td><td>About as loud</td><td>Mono by a different route, such as a single-speaker device that mixes in hardware</td></tr>
<tr><td>Right ear only</td><td>About as loud</td><td>Stereo with the channels swapped</td></tr>
</tbody></table></div>
<p>The out-of-phase noise is the same sound in both channels with one copy turned upside down. When a device mixes the two channels into one, the copies cancel, which is why it disappears in mono. For a full speaker check after switching, use the <a href="/stereo-test/">stereo test</a>.</p>',
	'extra'          => array(
		array(
			'How to turn Mono Audio on or off',
			'<p><strong>iPhone and iPad:</strong> Settings > Accessibility > Audio & Visual > Mono Audio. <strong>Android:</strong> Settings > Accessibility > Audio adjustment (or Hearing enhancements on Samsung) > Mono audio. <strong>Windows 11:</strong> Settings > Accessibility > Audio > Mono audio. <strong>Windows 10:</strong> Settings > Ease of Access > Audio > Turn on mono audio. <strong>Mac:</strong> System Settings > Accessibility > Audio > Play stereo audio as mono. <strong>Chromebook:</strong> Settings > Accessibility > Audio and captions > Play the same audio through all speakers.</p>',
			'switch',
		),
		array(
			'When mono audio helps',
			'<p>Mono sends everything to both ears. It is the right choice if you hear better in one ear, wear a single earbud, or share a pair of earphones, because in stereo some instruments or a speaker in a video may be only in the ear you are not using. It is also safer for some podcasts and calls recorded with a voice on one side. For music, games and films, stereo gives you direction and space, so turn mono off unless you need it.</p>',
			'when',
		),
	),
	'fixes'          => array(
		array( 'Mono Audio is off but the test still says mono', 'The device itself may be mono: a single Bluetooth speaker, a phone in portrait, or a headset in hands-free (call) mode. On Bluetooth headphones, pick the "stereo" or "A2DP" device, not "Hands-Free".' ),
		array( 'I hear nothing on one side', 'That is a dead channel, not mono. Check the balance setting, the plug and the headphones with the <a href="/headphone-test/">headphone test</a>.' ),
		array( 'The out-of-phase noise sounds odd on speakers', 'On speakers some cancellation happens in the room, especially in bass, so it can sound thin even in stereo. Headphones give the clearest result.' ),
	),
	'faq'            => array(
		array( 'How do I know if my audio is mono or stereo?', 'Press Left only. If you hear it in both ears, your audio is mono. If only in the left ear, it is stereo.' ),
		array( 'What is mono audio?', 'Mono mixes the left and right channels into one and plays the same sound on every speaker or earbud.' ),
		array( 'Is mono or stereo better?', 'Stereo is better for music, films and games because it carries direction. Mono is better for hearing loss in one ear or for using a single earbud.' ),
		array( 'Why does my phone play in mono?', 'Mono Audio may be on in accessibility settings, or the phone uses one speaker in portrait. Turn the phone sideways, or check the setting.' ),
		array( 'Does a mono test work on speakers?', 'Yes, but headphones give a clearer answer, because on speakers both ears hear both speakers.' ),
		array( 'Do AirPods or Bluetooth earbuds play mono?', 'They play stereo, unless Mono Audio is on in the phone or you use only one earbud, which then plays a mix of both channels.' ),
	),
	'related'        => array( 'stereo-test', 'headphone-test', 'sound-test', 'bass-test', 'hearing-frequency-test', 'speaker-cleaner' ),
	'updated'        => '2026-10-29',
);
