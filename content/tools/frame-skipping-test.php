<?php
defined( 'ABSPATH' ) || exit;

/* Inline SVG "photos" for the pass/fail examples: 12 cells, lit ones white. */
$tn_fs_photo = function ( $lit, $label ) {
	$out = '<svg viewBox="0 0 360 70" width="360" height="70" role="img" aria-label="' . $label . '" focusable="false" xmlns="http://www.w3.org/2000/svg"><rect x="0" y="0" width="360" height="70" rx="8" fill="#0b0f14"></rect>';
	for ( $i = 0; $i < 12; $i++ ) {
		$x    = 10 + $i * 28.5;
		$fill = isset( $lit[ $i ] ) ? $lit[ $i ] : '#1f2933';
		$out .= '<rect x="' . $x . '" y="12" width="24" height="30" rx="3" fill="' . $fill . '"></rect><text x="' . ( $x + 12 ) . '" y="60" text-anchor="middle" font-size="10" fill="#8b98a5">' . $i . '</text>';
	}
	return $out . '</svg>';
};
$tn_fs_pass = $tn_fs_photo( array( 3 => '#9aa5b1', 4 => '#ffffff', 5 => '#ffffff', 6 => '#9aa5b1' ), 'Pass: cells 3 to 6 lit in a row with no gap' );
$tn_fs_fail = $tn_fs_photo( array( 3 => '#9aa5b1', 4 => '#ffffff', 6 => '#ffffff', 7 => '#9aa5b1' ), 'Fail: cells 3, 4, 6 and 7 lit, cell 5 dark' );

return array(
	'title'        => 'Frame Skipping Test',
	'seo_title'    => 'Frame Skipping Test: Check Your Monitor for Dropped Frames',
	'description'  => 'Free frame skipping test for monitors. One cell lights per refresh; take a photo to see if your overclocked or high Hz display really shows every frame.',
	'intro'        => 'A monitor can accept 75, 144 or 165 Hz and still throw frames away, especially when it is overclocked. This test lights one cell per refresh in a fixed order. Take a photo of the screen: lit cells side by side mean every frame was shown, a dark cell in the middle of the lit run is a skipped frame.',
	'device'       => 'any',
	'ads'          => 'content',
	'styles'       => array( 'frame-skipping-test' ),
	'scripts'      => array( 'frame-skipping-test' ),
	'embed_height' => 560,
	'tool'         => '<div class="tool-bar fs-bar">
	<div class="btn-row">
		<button type="button" class="btn btn-sm" id="fs-pause" aria-pressed="false">Pause</button>
		<button type="button" class="btn btn-sm" id="fs-again">Measure again</button>
		<button type="button" class="btn btn-sm" data-tn-fullscreen="#fs-stage">Full screen</button>
	</div>
</div>
<div class="tool-stage fs-stage" id="fs-stage">
	<div class="fs-cells" id="fs-cells" aria-label="12 cells, one lit per screen refresh"></div>
	<p class="fs-caption" id="fs-caption">One cell per refresh, left to right. Photograph this box.</p>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Refresh rate</span><span class="stat-value" id="fs-hz">--</span></div>
	<div class="stat"><span class="stat-label">Frame time</span><span class="stat-value" id="fs-ms">-</span></div>
	<div class="stat"><span class="stat-label">Frames drawn</span><span class="stat-value" id="fs-frames">0</span></div>
	<div class="stat"><span class="stat-label">Browser missed</span><span class="stat-value" id="fs-missed">0</span></div>
</div>
<p class="tool-status" id="fs-status" aria-live="polite">Measuring your display. Keep this tab in front for a few seconds.</p>',
	'howto'        => array(
		'Leave the page in front for three seconds so it can read your refresh rate. Check that the number matches the rate you set (for example 75 Hz on an overclocked 60 Hz panel). If it does not, fix the display setting first with the <a href="/refresh-rate-test/">refresh rate test</a>.',
		'Use a camera with a manual or "pro" mode and set the shutter to about 1/10 s, or to a time longer than 4 frames (1/30 s at 144 Hz). A normal phone photo also works on most screens; it just catches fewer cells.',
		'Hold the camera steady, fill the frame with the cell box and take several photos. <strong>Full screen</strong> makes the cells bigger.',
		'Look at each photo. The lit cells should form one unbroken run, bright in the middle and dimmer at the two ends where the shutter opened and closed.',
		'A dark cell between lit cells is a skipped frame. Take 5 to 10 photos: one gap can be bad timing, a gap in most photos is a monitor that drops frames at this refresh rate.',
	),
	'howto_title'  => 'How to run the frame skipping test',
	'results'      => '<p><strong>Pass:</strong> the lit cells in your photo are consecutive, like this:</p>
<figure class="fs-photo">' . $tn_fs_pass . '<figcaption>Cells 3, 4, 5 and 6 are lit with no gap. Every refresh reached the screen.</figcaption></figure>
<p><strong>Fail:</strong> there is a dark cell inside the lit run:</p>
<figure class="fs-photo">' . $tn_fs_fail . '<figcaption>Cell 5 is dark between lit cells. The monitor received that frame but never showed it.</figcaption></figure>
<ul>
<li><strong>Refresh rate:</strong> the rate the browser is drawing at, read from the time between frames. The cells advance at this rate.</li>
<li><strong>Browser missed:</strong> frames the browser itself drew late (for example when another program was busy). The cells skip ahead to keep time, so these also show as gaps in a photo. If this number rises while you take photos, close other programs and try again: the gap is not the monitor\'s fault.</li>
<li><strong>Gaps with Browser missed at 0:</strong> the browser drew every frame and the monitor dropped some. That is real frame skipping, almost always from a refresh rate overclock the panel or its controller cannot keep up with.</li>
</ul>
<p>The browser cannot see frames the monitor throws away, because the computer sends every frame on time either way. That is why the test needs a camera: only a photo of the screen shows what the panel really displayed.</p>',
	'extra'        => array(
		array(
			'Why overclocked monitors skip frames',
			'<p>When you create a custom resolution at a higher refresh rate (with the NVIDIA Control Panel, AMD Software or CRU), the graphics card starts sending frames faster. Some monitor controllers accept the faster signal but cannot drive the panel that fast, so they quietly show only some of the frames. Your frame counter, the game and Windows all report the higher number, but motion looks no smoother, or even stutters. A 60 Hz monitor overclocked to 75 Hz that skips every fifth frame is still showing 60 frames per second.</p>
<p>The fix is to lower the custom refresh rate a step at a time (for example 75, 72, 70, 65 Hz) and repeat the photo test until the gaps are gone. Use the highest rate with no gaps in several photos. For motion clarity after that, the <a href="/ufo-test/">UFO test</a> shows blur and ghosting.</p>',
			'overclock',
		),
		array(
			'iPhone, iPad and Safari',
			'<p>Safari on iPhone and iPad draws web pages near 60 fps by default, even on 120 Hz ProMotion screens, so this test reads about 60 Hz there. To test at 120 Hz, open Settings &gt; Apps &gt; Safari &gt; Advanced &gt; Feature Flags, turn off <strong>Prefer Page Rendering Updates near 60fps</strong>, turn off Low Power Mode and reload. Phone screens are rarely overclocked, so frame skipping is mostly a desktop monitor question.</p>',
			'safari',
		),
	),
	'fixes'        => array(
		array( 'My photo shows a gap in every shot', 'The monitor is skipping frames at this refresh rate. If you overclocked it, lower the custom refresh rate one step and test again. If it is a stock rate, update the graphics driver, try a different cable (DisplayPort if you can) and turn off any "overclock" option in the monitor menu.' ),
		array( 'The photo shows every cell lit, or none', 'The shutter was too slow or too fast. A shutter of 1/10 s at 60 Hz covers 6 cells; at 144 Hz it covers 14, which lights the whole row. Use a faster shutter (1/30 or 1/60 s) on high refresh monitors.' ),
		array( 'Browser missed keeps rising', 'The computer, not the monitor, is late with frames. Close other tabs and programs, plug in a laptop, turn on hardware acceleration in the browser and keep the window on one monitor.' ),
		array( 'The refresh rate is lower than I set', 'The browser draws at the rate the system gives it. Check the rate in Windows (Settings, System, Display, Advanced display) or macOS (Displays). With two monitors at different rates, move the window to the one you are testing.' ),
		array( 'iPhone shows 60 Hz', 'Safari renders web pages near 60 fps by default. Turn off <strong>Prefer Page Rendering Updates near 60fps</strong> in Settings &gt; Apps &gt; Safari &gt; Advanced &gt; Feature Flags and turn off Low Power Mode, then reload.' ),
	),
	'faq'          => array(
		array( 'What is frame skipping?', 'Frame skipping is when a monitor receives a frame from the computer but never shows it. It happens most often when a monitor is overclocked past what its controller can handle, so the panel keeps showing fewer frames than the refresh rate says.' ),
		array( 'Can software detect frame skipping on its own?', 'No. The computer sends every frame on time, so the browser, the game and the operating system all report the full rate. Only a photo of the screen shows which frames were really displayed, which is why this test uses a camera.' ),
		array( 'What shutter speed should I use?', 'Long enough to catch 4 to 8 frames: about 1/10 s at 60 Hz, 1/30 s at 144 Hz, 1/60 s at 240 Hz. Most phone cameras pick a shutter around 1/30 to 1/60 s indoors, which also works.' ),
		array( 'Is frame skipping the same as stutter?', 'They look alike. Stutter usually comes from frames the computer draws late, which this test counts under Browser missed. Frame skipping is the monitor dropping frames it was given on time.' ),
		array( 'Does a 144 Hz monitor at stock settings skip frames?', 'Rarely. Frame skipping is mostly an overclocking problem. It is still worth checking a used monitor or a new one that seems no smoother at a higher rate.' ),
		array( 'Is this the same as the TestUFO frame skipping test?', 'It is the same method: light one block per refresh and photograph the screen. The physics on your screen is identical, so use whichever you like.' ),
	),
	'related'      => array( 'refresh-rate-test', 'ufo-test', 'fps-test', 'monitor-test', 'dead-pixel-test', 'burn-in-test' ),
	'updated'      => '2026-11-27',
);
