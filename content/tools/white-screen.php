<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'White Screen',
	'seo_title'    => 'White Screen: Full Screen Pure White Page for Any Display',
	'description'  => 'Free full-screen white screen. Use it as a soft light, to clean your monitor, to spot dead pixels and uneven backlight, or as a ring light for video calls.',
	'intro'        => 'Turn your whole screen pure white with one click. Use it as a soft light, to see dust and smudges while cleaning, to check a display for dark spots and uneven brightness, or to compare monitors side by side.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => '<div class="tool-bar cs-bar">
	<button type="button" class="btn btn-primary" id="cs-start">Open full white screen</button>
	<label class="cs-timer">Auto close <select id="cs-timer"><option value="0">never</option><option value="1">after 1 min</option><option value="5">after 5 min</option><option value="15">after 15 min</option><option value="60">after 1 hour</option></select></label>
</div>
<div class="tool-stage cs-stage">
	<div class="cs-preview" id="cs-preview" role="button" tabindex="0" aria-label="Open full screen"><span>Click to go full screen</span></div>
	<div class="cs-swatches" aria-label="Shades">
		<button type="button" class="cs-swatch" data-cs-color="#ffffff" style="background:#ffffff" aria-label="White" aria-pressed="true"></button>
		<button type="button" class="cs-swatch" data-cs-color="#f2f2f2" style="background:#f2f2f2" aria-label="95% white"></button>
		<button type="button" class="cs-swatch" data-cs-color="#d9d9d9" style="background:#d9d9d9" aria-label="85% white"></button>
		<button type="button" class="cs-swatch" data-cs-color="#bfbfbf" style="background:#bfbfbf" aria-label="75% grey"></button>
		<button type="button" class="cs-swatch" data-cs-color="#808080" style="background:#808080" aria-label="50% grey"></button>
		<button type="button" class="cs-swatch" data-cs-color="#fff4e0" style="background:#fff4e0" aria-label="Warm white"></button>
		<button type="button" class="cs-swatch" data-cs-color="#e8f1ff" style="background:#e8f1ff" aria-label="Cool white"></button>
	</div>
	<p class="cs-keys">In full screen: <kbd>Esc</kbd> or <kbd>tap</kbd> to exit.</p>
</div>
<div class="cs-screen" id="cs-screen" hidden tabindex="-1"><div class="cs-hint" id="cs-hint"></div></div>
<p class="tool-status" id="cs-status" aria-live="polite">Turn your screen brightness up for the brightest light.</p>',
	'howto'        => array(
		'Press <strong>Open full white screen</strong>. The whole screen turns white and the mouse pointer hides after a moment.',
		'Pick a shade before or during the test: pure white, lighter greys, or a warm or cool white for a softer light.',
		'Set <strong>Auto close</strong> if you are using the screen as a lamp, so it turns off on its own.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the white screen',
	'results'      => '<p>A healthy screen shows one even sheet of white from corner to corner. Things to look for:</p>
<ul>
<li><strong>Dark or black dots</strong> are dead pixels. Confirm them with the <a href="/dead-pixel-test/">dead pixel test</a>, which cycles other colours too.</li>
<li><strong>Darker corners or edges</strong> on an LCD are normal to a small degree (vignetting). A strong difference points to a weak backlight.</li>
<li><strong>Yellow or pink patches</strong> are uneven backlight or panel ageing. Compare at 50% grey, where tints show most clearly.</li>
<li><strong>Dust and fingerprints</strong> stand out against white, which is why cleaning with the white screen on works so well. Switch to the <a href="/black-screen/">black screen</a> to see greasy smudges instead.</li>
</ul>',
	'extra'        => array(
		array(
			'What a white screen is used for',
			'<p><strong>Light source.</strong> A laptop or monitor at full brightness makes a soft, flattering fill light for video calls, selfies and product photos. Use the warm white shade for skin tones and the cool white to match daylight. Phones make a handy reading light or a torch that does not blind.</p>
<p><strong>Cleaning.</strong> Dust, hair and streaks are nearly invisible on a dark desktop but obvious on white. Open the white screen, wipe with a dry microfibre cloth, and check again.</p>
<p><strong>Display checks.</strong> White reveals dead pixels, backlight unevenness and colour tints. Open the same page on two monitors to compare their white point: one will usually look warmer than the other, and you can adjust its colour temperature to match.</p>
<p><strong>Tracing and scanning.</strong> Put a sheet of paper on a bright white tablet to trace a drawing, or use a white phone screen as a backlight for negatives and slides.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The white looks grey or dim', 'Raise the screen brightness to 100%, turn off night mode, blue light filters and auto brightness, and disable any "eco" or "power saver" display setting. On Windows, also check HDR is off for SDR content.' ),
		array( 'One side is yellower than the other', 'Backlight unevenness is common on cheap or old LCDs and cannot be fixed in software. If the monitor is new, it may be covered by warranty; take a photo of the 50% grey screen as evidence.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not allow websites to go fully full screen, so the white fills the browser window instead. Rotate to landscape or add the page to your home screen for the cleanest view.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen completely white?', 'Open this page and press "Open full white screen". The browser fills the entire screen with pure white (#FFFFFF). Press Esc or tap to exit.' ),
		array( 'Can I use a white screen as a light?', 'Yes. At full brightness a monitor or tablet gives a soft, even light that works well for video calls and photos. Choose the warm shade for a more natural tone.' ),
		array( 'Does a white screen damage an OLED display?', 'A bright static image for hours can contribute to burn-in on OLED screens. Use the auto close option and keep sessions short on OLED phones and TVs.' ),
		array( 'Why does the white screen show dust so clearly?', 'Dust and smudges scatter the light coming from the panel, so they look dark against a bright, even white. It makes cleaning much easier.' ),
		array( 'Can I pick a different brightness?', 'Yes. The grey shades give a less bright surface, and the warm and cool whites change the colour temperature. Your device brightness controls the rest.' ),
		array( 'Is this page free to use?', 'Yes. It runs entirely in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'black-screen', 'dead-pixel-test', 'stuck-pixel-fixer', 'online-mirror', 'refresh-rate-test', 'burn-in-test' ),
	'updated'      => '2026-10-28',
);
