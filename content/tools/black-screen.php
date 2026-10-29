<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Black Screen',
	'seo_title'    => 'Black Screen: Full Screen Pure Black Page for Any Display',
	'description'  => 'Free full-screen black screen. Check backlight bleed, OLED true black and stuck pixels, spot smudges before cleaning, or dim your screen while music plays.',
	'intro'        => 'Turn your whole screen pure black with one click. Use it to check backlight bleed and clouding on an LCD, to confirm true black on an OLED, to find bright stuck pixels, or simply to black out the screen while audio plays.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => '<div class="tool-bar cs-bar">
	<button type="button" class="btn btn-primary" id="cs-start">Open full black screen</button>
	<label class="cs-timer">Auto close <select id="cs-timer"><option value="0">never</option><option value="1">after 1 min</option><option value="5">after 5 min</option><option value="15">after 15 min</option><option value="60">after 1 hour</option></select></label>
</div>
<div class="tool-stage cs-stage">
	<div class="cs-preview" id="cs-preview" role="button" tabindex="0" aria-label="Open full screen"><span>Click to go full screen</span></div>
	<div class="cs-swatches" aria-label="Shades">
		<button type="button" class="cs-swatch" data-cs-color="#000000" style="background:#000000" aria-label="Black" aria-pressed="true"></button>
		<button type="button" class="cs-swatch" data-cs-color="#0a0a0a" style="background:#0a0a0a" aria-label="Near black 4%"></button>
		<button type="button" class="cs-swatch" data-cs-color="#1a1a1a" style="background:#1a1a1a" aria-label="Dark gray 10%"></button>
		<button type="button" class="cs-swatch" data-cs-color="#333333" style="background:#333333" aria-label="Gray 20%"></button>
		<button type="button" class="cs-swatch" data-cs-color="#808080" style="background:#808080" aria-label="50% gray"></button>
		<button type="button" class="cs-swatch" data-cs-color="#000033" style="background:#000033" aria-label="Deep blue"></button>
		<button type="button" class="cs-swatch" data-cs-color="#330000" style="background:#330000" aria-label="Deep red"></button>
	</div>
	<p class="cs-keys">In full screen: <kbd>Esc</kbd> or <kbd>tap</kbd> to exit.</p>
</div>
<div class="cs-screen" id="cs-screen" hidden tabindex="-1"><div class="cs-hint" id="cs-hint"></div></div>
<p class="tool-status" id="cs-status" aria-live="polite">Dim the room lights to see backlight bleed clearly.</p>',
	'howto'        => array(
		'Dim the room and set your screen brightness to the level you normally use.',
		'Press <strong>Open full black screen</strong>. The whole screen turns black and the pointer hides.',
		'Look at the edges and corners for glowing patches, and across the panel for bright dots. The near-black shades make faint faults easier to see.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back.',
	),
	'howto_title'  => 'How to use the black screen',
	'results'      => '<p>On an <strong>OLED</strong> screen, black means the pixels are off: the screen should be indistinguishable from the bezel in a dark room. On an <strong>LCD</strong> the backlight is still on behind the black, so some faint glow is normal. What to look for:</p>
<ul>
<li><strong>Bright patches at the edges or corners</strong> are backlight bleed. A little is normal on budget IPS and VA panels; large patches on a new monitor are worth a return.</li>
<li><strong>Uneven cloudy blotches</strong> across the panel are "clouding" or "mura", most visible at the 4% and 10% shades.</li>
<li><strong>A single bright red, green, blue or white dot</strong> is a stuck or hot pixel. Try the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>.</li>
<li><strong>A faint ghost of an earlier image</strong> on an OLED is image retention or burn-in. Our <a href="/burn-in-test/">burn-in test</a> looks at this in more detail.</li>
</ul>
<p>A black dot that stays black on the <a href="/white-screen/">white screen</a> too is a dead pixel, not a stuck one.</p>',
	'extra'        => array(
		array(
			'What a black screen is used for',
			'<p><strong>Display checks.</strong> Black is the most revealing test for backlight bleed, IPS glow (a silvery sheen when you look from an angle), clouding and stuck pixels. Reviewers photograph monitors on a black screen in a dark room for exactly this reason. For a fair test, compare at your normal brightness, because bleed grows with backlight power.</p>
<p><strong>Blank the screen.</strong> Play music or a podcast and open the black screen to turn the monitor into a dark surface without switching it off, so audio and downloads continue. On OLED laptops and phones it also saves battery, because black pixels draw almost nothing.</p>
<p><strong>Cleaning.</strong> Oily fingerprints and streaks show best on black, while dust shows best on white. Use both for a thorough clean.</p>
<p><strong>Eyes and sleep.</strong> A black page is restful at night. Pair it with the auto close timer if you fall asleep to audio.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The whole screen glows gray instead of black', 'That is normal for LCD monitors: the backlight never switches fully off. Lower the brightness and check that the monitor is not in a bright "vivid" picture mode. Only OLED and mini-LED local dimming get close to true black.' ),
		array( 'The corners glow', 'Backlight bleed. Gently loosening a tight bezel sometimes helps, but usually it is a panel property. Compare with the manufacturer\'s return policy if the monitor is new.' ),
		array( 'I can see the previous page faintly on black', 'Image retention on an OLED or VA panel. Leave the black screen on for 10-20 minutes; temporary retention fades. If it never fades, it is burn-in.' ),
		array( 'The screen turns off after a minute', 'Your operating system\'s screen saver or sleep timer kicked in. Move the mouse, or raise the sleep timer in your power settings while you test.' ),
	),
	'faq'          => array(
		array( 'Why is my black screen not completely black?', 'On an LCD the backlight shines through the pixels a little, so black looks dark gray in a dim room. OLED screens switch the pixels off and show true black.' ),
		array( 'What is backlight bleed?', 'Light leaking around the edges of an LCD panel, visible as bright patches on a black screen. Small amounts are normal; large bright areas are a panel defect.' ),
		array( 'Does a black screen save battery?', 'On OLED phones and laptops, yes: black pixels are off and draw almost no power. On LCD screens the backlight stays on, so the saving is tiny.' ),
		array( 'Can a black screen help with burn-in?', 'It does not repair burn-in, but a black screen gives temporary image retention time to fade. Use our burn-in test to tell the two apart.' ),
		array( 'Is this black screen page free?', 'Yes. It runs in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'white-screen', 'grey-screen', 'dead-pixel-test', 'stuck-pixel-fixer', 'burn-in-test', 'blue-screen', 'red-screen', 'fps-test' ),
	'updated'      => '2026-10-28',
);
