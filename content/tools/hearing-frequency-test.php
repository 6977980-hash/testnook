<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Hearing Frequency Test',
	'seo_title'    => 'Hearing Frequency Test: Highest Pitch You Can Hear (Online)',
	'description'  => 'Free online hearing frequency test. Tones rise from 8 kHz to 20 kHz; press the button while you still hear them to find your upper limit and compare it by age.',
	'intro'        => 'Find the highest frequency you can hear. Put on headphones, set a low volume and start: a tone plays at 8 kHz and rises in steps. Press "I can hear it" every time you hear the tone. The last one you heard is your upper hearing limit.',
	'device'       => 'any',
	'ads'          => 'standard',
	'styles'       => array( 'hearing-frequency-test' ),
	'scripts'      => array( 'hearing-frequency-test' ),
	'embed_height' => 760,
	'tool'         => '<div class="tool-stage hf-stage">
	<div class="hf-now">
		<div class="hf-freq" id="hf-freq">-</div>
		<p class="hf-meterlabel" id="hf-meterlabel">Press Start. Tones begin at 8 kHz.</p>
		<div class="hf-meter" aria-hidden="true"><span id="hf-meter"></span></div>
	</div>
	<div class="btn-row hf-answer">
		<button type="button" class="btn btn-primary" id="hf-start">Start test</button>
		<button type="button" class="btn btn-primary" id="hf-hear" disabled>I can hear it</button>
		<button type="button" class="btn" id="hf-no" disabled>I can\'t hear it</button>
		<button type="button" class="btn" id="hf-stop" disabled>Stop</button>
		<button type="button" class="btn" id="hf-again" hidden>Test again</button>
	</div>
	<div class="hf-result" id="hf-result" hidden>
		<div>Highest tone heard: <b id="hf-reshz">-</b> <span id="hf-resage"></span></div>
		<p id="hf-resnote"></p>
	</div>
	<div class="hf-scale" aria-label="Frequencies in the test; tap one to hear it">
		<button type="button" class="hf-tick" data-hf-hz="8000">8 k</button>
		<button type="button" class="hf-tick" data-hf-hz="9000">9 k</button>
		<button type="button" class="hf-tick" data-hf-hz="10000">10 k</button>
		<button type="button" class="hf-tick" data-hf-hz="11000">11 k</button>
		<button type="button" class="hf-tick" data-hf-hz="12000">12 k</button>
		<button type="button" class="hf-tick" data-hf-hz="13000">13 k</button>
		<button type="button" class="hf-tick" data-hf-hz="14000">14 k</button>
		<button type="button" class="hf-tick" data-hf-hz="15000">15 k</button>
		<button type="button" class="hf-tick" data-hf-hz="16000">16 k</button>
		<button type="button" class="hf-tick" data-hf-hz="17000">17 k</button>
		<button type="button" class="hf-tick" data-hf-hz="18000">18 k</button>
		<button type="button" class="hf-tick" data-hf-hz="19000">19 k</button>
		<button type="button" class="hf-tick" data-hf-hz="20000">20 k</button>
	</div>
	<div class="hf-opts">
		<div class="field"><label for="hf-volume" class="hf-label">Volume <output id="hf-volout" for="hf-volume">15%</output></label><input type="range" id="hf-volume" min="0" max="100" value="15"></div>
		<div class="field"><label for="hf-step" class="hf-label">Step size</label><select id="hf-step"><option value="1000" selected>1 kHz (13 tones)</option><option value="500">500 Hz (25 tones)</option></select></div>
		<div class="field"><span class="hf-label">Ear</span>
			<div class="seg" role="group" aria-label="Ear">
				<button type="button" data-hf-ch="-1" aria-pressed="false">Left</button>
				<button type="button" data-hf-ch="0" aria-pressed="true">Both</button>
				<button type="button" data-hf-ch="1" aria-pressed="false">Right</button>
			</div>
		</div>
	</div>
</div>
<p class="tool-status" id="hf-status" aria-live="polite">Use headphones and start at a low volume. You can tap any frequency above to hear it before the test.</p>',
	'howto'        => array(
		'Put on headphones or earphones. Laptop and phone speakers often cannot play tones above 15 kHz, which would make the result look worse than your hearing. Find a quiet room.',
		'Keep the volume slider low (15% is the default) and tap the <strong>8 k</strong> button to check that you hear a tone at a comfortable level. Raise the volume a little only if 8 kHz is very faint.',
		'Press <strong>Start test</strong>. Each tone plays for 2.5 seconds, then rises by 1 kHz. Press <strong>I can hear it</strong> (or Space) as soon as you hear each one.',
		'When a tone is silent for you, wait: it repeats once, and if you still hear nothing the test ends and shows the last tone you heard. You can also press <strong>I can\'t hear it</strong>.',
		'Test each ear on its own with the <strong>Left</strong> and <strong>Right</strong> buttons, and use the 500 Hz step for a finer result.',
	),
	'howto_title'  => 'How to take the hearing frequency test',
	'results'      => '<p>Your result is the highest tone you heard at a low volume. The top of the hearing range falls with age as the hair cells in the inner ear that detect high frequencies wear out, so the table gives a rough idea of what is typical. Loud music, machinery and headphones at high volume speed this up.</p>
<table class="hf-table">
<tr><th>Highest tone heard</th><th>Typical for</th></tr>
<tr><td>19-20 kHz</td><td>Children and teenagers</td></tr>
<tr><td>17-18 kHz</td><td>People in their 20s</td></tr>
<tr><td>15-16 kHz</td><td>30s</td></tr>
<tr><td>12-14 kHz</td><td>40s</td></tr>
<tr><td>10-11 kHz</td><td>50s</td></tr>
<tr><td>8-9 kHz or lower</td><td>60s and over, or hearing damage</td></tr>
</table>
<p>A result a few kHz below your age band is not a diagnosis. Headphones that roll off at the top, a noisy room, a low volume and tiredness all lower the number. A big difference between the left and right ear, or a limit far below your age band at a normal volume, is worth mentioning to a doctor or audiologist, who can run a proper audiogram.</p>',
	'results_title' => 'What your result means',
	'extra'        => array(
		array(
			'Why this is not a medical hearing test',
			'<p>A clinical hearing test (an audiogram) measures the quietest sound you can hear at each frequency, in a soundproof booth, with calibrated headphones. This page cannot know how loud your headphones are, so it measures only whether you can hear a tone at all at the volume you set. It is useful for checking whether your hearing range is in the normal band for your age, comparing your two ears, and testing whether your headphones reproduce high frequencies. For hearing loss, tinnitus or a sudden change in one ear, see a professional. Checks on your equipment are on the <a href="/headphone-test/">headphone test</a> and <a href="/tone-generator/">tone generator</a> pages.</p>',
			'not-medical',
		),
		array(
			'Hearing range and the "mosquito tone"',
			'<p>Human hearing is usually quoted as 20 Hz to 20 kHz, but 20 kHz is only reachable by young ears. Many adults are surprised to stop hearing anything above 15 or 16 kHz: the high tones are simply gone, and because music and speech have little energy up there, nothing in daily life reveals it. The 17 kHz "mosquito" ringtone and shop deterrents rely on this: teenagers hear it, most adults do not. If you want to see where your limit sits step by step, use the 500 Hz step size and test one ear at a time.</p>',
			'range',
		),
	),
	'fixes'        => array(
		array( 'I hear nothing, even at 8 kHz', 'Check the system volume and that the browser is not muted. Tap the 8 k button to hear a test tone. Pure tones above 8 kHz are quiet on small speakers, so use headphones.' ),
		array( 'The result is lower than expected', 'Try better headphones: many cheap earphones and Bluetooth speakers roll off above 15 kHz. Test in a quiet room, raise the volume a little (not loud) and try again. A low result on good headphones at normal volume is worth a professional check.' ),
		array( 'One ear hears less than the other', 'Swap the earphones between ears and repeat. If the weaker side moves with the earphone, the earphone is at fault. If it stays with the ear, mention it to a doctor.' ),
		array( 'I hear a click or buzz but no tone', 'Some earphones and Bluetooth links distort at high frequencies and produce artefacts. Lower the volume. If you only hear a click when each tone starts, the tone itself is above your range.' ),
	),
	'faq'          => array(
		array( 'How does the hearing frequency test work?', 'A pure tone plays at 8 kHz and rises 1 kHz at a time. You press a button while you can hear it; the last tone you heard is your upper limit.' ),
		array( 'What is a normal hearing range?', '20 Hz to 20 kHz for young ears. The top drops with age: about 17 kHz in your 20s, 15 kHz in your 30s and 12 kHz in your 40s.' ),
		array( 'Is this an accurate hearing test?', 'It finds your highest audible frequency at the volume you set. It does not measure how quiet a sound you can hear, which is what a medical audiogram does.' ),
		array( 'Do I need headphones?', 'Yes for a fair result. Speakers, especially on phones and laptops, often cannot play tones above 15 kHz.' ),
		array( 'Why can I not hear 17 kHz?', 'Most adults past their mid-20s cannot. The hair cells for the highest frequencies wear out first, which is normal.' ),
		array( 'Is the test safe for my ears?', 'Yes at a low volume, which is why it starts at 15% and plays short tones. Do not turn the volume up to chase a higher result.' ),
	),
	'disclaimer'   => 'This hearing frequency test is for information and equipment checking only. It is not a medical test and cannot diagnose hearing loss. Keep the volume low, and if you have ringing, pain, sudden hearing loss or a large difference between your ears, see a doctor or audiologist.',
	'related'      => array( 'tone-generator', 'headphone-test', 'sound-test', 'speaker-cleaner', 'mic-test', 'refresh-rate-test' ),
	'updated'      => '2026-10-28',
);
