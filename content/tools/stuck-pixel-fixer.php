<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Stuck Pixel Fixer',
	'seo_title'    => 'Stuck Pixel Fixer: Fix Stuck Pixels Online for Free',
	'description'  => 'Free stuck pixel fixer that flashes rapid colours over a stuck pixel to revive it. Drag the flashing box onto the spot or flash the whole screen. No download.',
	'intro'        => 'Found a pixel stuck on red, green, blue or white? Drag the flashing box over it and let it run for 10-20 minutes. Rapid colour changes often get a stuck pixel working again.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'stuck-pixel-fixer' ),
	'scripts'      => array( 'stuck-pixel-fixer' ),
	'embed_height' => 600,
	'tool'         => '<p class="notice notice--warn spf-warn"><strong>Flashing light warning.</strong> This tool flashes bright colours very quickly. Do not use it, or look at it, if you have photosensitive epilepsy or are sensitive to flashing lights. Look away from the screen while it runs.</p>
<label class="spf-agree"><input type="checkbox" id="spf-agree"> I understand. Nobody watching is sensitive to flashing lights.</label>
<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="spf-start" disabled>Start fixer box</button>
		<button type="button" class="btn" id="spf-full" disabled>Flash whole screen</button>
		<button type="button" class="btn" id="spf-stop" disabled>Stop</button>
	</div>
	<div class="seg" role="group" aria-label="Flash speed">
		<button type="button" data-spf-speed="fast" aria-pressed="true">Fast</button>
		<button type="button" data-spf-speed="gentle" aria-pressed="false">Gentle</button>
	</div>
</div>
<div class="tool-stage spf-stage">
	<div class="spf-preview" id="spf-preview" aria-hidden="true"></div>
	<div class="spf-opts">
		<div class="field"><label for="spf-size">Box size <output id="spf-sizeout" for="spf-size">120 px</output></label><input type="range" id="spf-size" min="40" max="400" step="10" value="120"></div>
		<div class="field"><label for="spf-mins">Stop automatically after</label>
			<select id="spf-mins"><option value="10">10 minutes</option><option value="20" selected>20 minutes</option><option value="30">30 minutes</option><option value="60">1 hour</option></select>
		</div>
	</div>
</div>
<div class="spf-box" id="spf-box" hidden><button type="button" class="spf-close" id="spf-close" aria-label="Stop the fixer">&times;</button></div>
<div class="spf-screen" id="spf-screen" hidden></div>
<p class="tool-status" id="spf-status" aria-live="polite">Tick the box above to unlock the fixer.</p>',
	'howto'        => array(
		'Find the stuck pixel first with the <a href="/dead-pixel-test/">dead pixel test</a>, and note where it is.',
		'Read the flashing light warning and tick the box to unlock the tool.',
		'Press <strong>Start fixer box</strong>. A small flashing square appears. Drag it with your mouse or finger until it covers the stuck pixel. Use the size slider to make it bigger if you are not sure of the exact spot.',
		'Leave it running for 10-20 minutes and look away from the screen. Press <kbd>Esc</kbd>, the &times; button or <strong>Stop</strong> to end it.',
		'Run the dead pixel test again. If the pixel is still stuck, repeat for up to an hour, or try <strong>Flash whole screen</strong> if there are several stuck pixels.',
	),
	'howto_title'  => 'How to fix a stuck pixel',
	'results'      => '<p>If the fix worked, the pixel shows the same colour as its neighbours on every background in the dead pixel test. Many stuck pixels recover within 10-20 minutes; stubborn ones can need several sessions over a few days.</p>
<p>If nothing changes after a few hours in total, the sub-pixel is probably physically damaged or it is actually a <strong>dead</strong> pixel (black on every colour), which software cannot repair. A pixel that comes back but sticks again later is likely to fail for good, so report it while the device is under warranty.</p>',
	'results_title' => 'Did it work?',
	'extra'        => array(
		array(
			'How a stuck pixel fixer works',
			'<p>Each pixel on an LCD or OLED screen is made of red, green and blue sub-pixels. A stuck pixel is one where a sub-pixel stays on (or partly on) instead of following the picture. Flashing red, green, blue, black and white many times a second rapidly switches that sub-pixel on and off. On LCD screens this can loosen liquid crystals that are stuck in one position; on OLED it exercises the pixel circuit. This is the same idea as JScreenFix and other pixel fixer apps, built into the page so there is nothing to install.</p>
<p>The fixer is safe for your screen: it only shows normal colours, just very fast. The risk is to people, not to hardware, which is why the warning above matters.</p>',
			'how-it-works',
		),
	),
	'fixes'        => array(
		array( 'The pixel is still stuck after 20 minutes', 'Run it again for 30-60 minutes, and repeat once a day for a few days. Make sure the box really covers the pixel: make it larger to be sure. Switch to the Fast speed if you were on Gentle.' ),
		array( 'Try the pressure method (with care)', 'Turn the screen off, wrap a soft cloth around a blunt, rounded object such as a stylus cap, and press very gently on the exact spot. Turn the screen on while still pressing, then release. Pressing too hard can create more dead pixels, so this is at your own risk.' ),
		array( 'The box will not stay on a phone pixel', 'Make the box bigger so a small slip does not matter, or use Flash whole screen. Set the screen timeout to a longer value so the phone does not lock while the fixer runs.' ),
	),
	'faq'          => array(
		array( 'Can a stuck pixel be fixed?', 'Often, yes. Stuck pixels (stuck on red, green, blue or white) can respond to rapid colour flashing. Dead pixels that stay black on every colour usually cannot be fixed at home.' ),
		array( 'How long should I run a stuck pixel fixer?', 'Start with 10-20 minutes. If the pixel is still stuck, try longer sessions of up to an hour and repeat over a few days.' ),
		array( 'Is the stuck pixel fixer safe for my monitor?', 'Yes. It only shows ordinary colours, changing quickly. It cannot harm an LCD or OLED panel. Do not look at it if you are sensitive to flashing lights.' ),
		array( 'Is this the same as JScreenFix?', 'It works on the same principle: a flashing area of changing colours placed over the stuck pixel. You can drag it anywhere, resize it, or flash the whole screen.' ),
		array( 'Does it work on phones and OLED screens?', 'Yes. It works on Android and iPhone browsers and on LCD and OLED screens. Drag the box with your finger. Keep the screen awake while it runs.' ),
		array( 'Can it fix a dead pixel?', 'Rarely. A dead pixel usually has a failed transistor and no power. It is still worth one try, since what looks dead is sometimes a sub-pixel stuck off.' ),
	),
	'disclaimer'   => 'Flashing light warning: this page shows rapidly flashing colours that may trigger seizures in people with photosensitive epilepsy. Do not use it if you or anyone nearby may be affected. Stop at once if you feel unwell. See our <a href="/terms/">terms</a>.',
	'related'      => array( 'dead-pixel-test', 'burn-in-test', 'refresh-rate-test', 'black-screen', 'white-screen', 'fps-test' ),
	'updated'      => '2026-10-28',
);
