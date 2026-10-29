<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'OLED Burn-In: How to Fix It, and How to Prevent It',
	'seo_title'   => 'OLED Burn-In Fix: Image Retention vs Burn-In and Prevention',
	'description' => 'Ghost images on an OLED TV, monitor or phone? The difference between image retention and permanent burn-in, what pixel refresh does, and how to prevent it.',
	'blurb'       => 'Retention clears, burn-in does not. What pixel refresh does, and the habits that prevent it.',
	'hub'         => 'screen',
	'tool'        => 'burn-in-test',
	'tools'       => array( 'oled-test', 'grey-screen', 'dead-pixel-test', 'white-screen' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A faint logo, a taskbar outline or a news ticker that stays on screen after the content changes is the OLED owner\'s nightmare. Often it is temporary. Here is how to tell, what the built-in tools do, and how to stop it getting worse.',
	'summary'     => array(
		'<strong>Image retention</strong> fades within minutes to hours of showing varied content. <strong>Burn-in</strong> is uneven wear of the organic pixels and does not fade.',
		'Check with a <strong>uniform gray screen</strong>: burn-in shows as a darker ghost of the static element, because worn pixels are dimmer.',
		'Run the TV or monitor\'s <strong>pixel refresh / panel refresh</strong> once; it re-measures and compensates the pixels. Run it rarely, not weekly, as it also consumes panel life.',
		'True burn-in cannot be reversed at home. Prevention: hide static elements, use dark modes, avoid hours of one channel at high brightness, and leave the panel\'s automatic protections on.',
	),
	'sections'    => array(
		array(
			'Image retention or burn-in? How to tell',
			'<p>Both show a ghost of something that was on screen. The difference is whether it goes away.</p>
<p><strong>Image retention</strong> is a temporary charge imbalance in the pixels after a static image. It fades within minutes or, at most, a few hours of normal mixed content. LCDs get it too. Phones that show a keyboard outline for a minute after a long typing session are a classic case.</p>
<p><strong>Burn-in</strong> is permanent. Organic light-emitting pixels dim as they age, and they age in proportion to how hard and how long they are driven. A pixel that has displayed a bright white logo for a thousand hours has aged more than its neighbors, so it is dimmer forever. The ghost is a shadow of the static element.</p>
<p>To tell them apart, run the <a href="/burn-in-test/">burn-in test</a>. It shows full-screen uniform colors and grays; the 5 to 20% grays are the most revealing. Note what you see, then watch varied content (a film, not a news channel) for two hours and look again. A ghost that has faded or shrunk is retention; one that looks the same is burn-in.</p>',
			'retention-vs-burn-in',
		),
		array(
			'Step 1: give retention time to clear',
			'<p>If the ghost appeared after a long static session (a game HUD for six hours, a day of spreadsheets), do nothing drastic. Play two or three hours of varied full-screen video at normal brightness, or simply turn the screen off for a few hours. Most retention is gone by the next day.</p>
<p>Full-screen color cycling (white, then each primary, then grays) for 20 to 30 minutes can speed this up on LCDs and does no harm on OLEDs at moderate brightness. Avoid the "burn-in fix" videos on YouTube that run noise at full brightness for hours: on OLED, that is just extra wear.</p>',
			'clear-retention',
		),
		array(
			'Step 2: run the built-in pixel refresh',
			'<p>Every OLED TV and monitor has a compensation cycle that measures each pixel\'s wear and adjusts the drive so the picture looks even again. It does not heal the pixels; it dims the healthy ones slightly to match the worn ones, which makes mild burn-in invisible.</p>
<ul>
<li><strong>Short cycle (automatic):</strong> runs for a few minutes after every 4 hours of use when the screen is turned off. Keep the TV plugged in and let it go to standby rather than cutting the power at a switch, or the cycle never runs.</li>
<li><strong>Long cycle (manual):</strong> about an hour. LG: Settings &gt; Support &gt; OLED Care &gt; Pixel Cleaning. Sony: Settings &gt; Display &amp; Sound &gt; Expert panel settings &gt; Panel refresh. Samsung: Settings &gt; Support &gt; Device Care &gt; Self Diagnosis &gt; Pixel Refresh. Monitors: look under the OLED care or panel protection menu; Alienware, ASUS, LG and Samsung all have it.</li>
</ul>
<p>Run the long cycle once when you notice a ghost, with the screen warm. Do not run it weekly: each cycle drives every pixel and uses some panel life, and makers limit how often it can be triggered for that reason. Many TVs run a long cycle automatically after about 2,000 hours.</p>',
			'pixel-refresh',
		),
		array(
			'What does not work (and can make it worse)',
			'<ul>
<li><strong>Burn-in "fixer" videos at maximum brightness</strong> for hours. On OLED these age the whole panel; the ghost does not get better, the rest gets worse until, eventually, it matches. That is not a fix.</li>
<li><strong>Burning in the opposite image.</strong> Some people display an inverted version of the ghost to even things out. In theory it ages the surrounding pixels to match; in practice it is impossible to do precisely and it just adds wear.</li>
<li><strong>Repeated manual pixel refreshes.</strong> One is the treatment; ten shorten the panel\'s life.</li>
<li><strong>Third-party apps and screensavers that claim to repair burn-in.</strong> They show moving colors, which is harmless for retention and useless for burn-in.</li>
</ul>
<p>When the ghost is real burn-in that compensation cannot hide, the fix is a panel replacement. Some makers cover burn-in under warranty for a few years (LG\'s OLED monitors and several monitor brands state it explicitly; most TV warranties exclude it). Check your exact terms.</p>',
			'what-does-not-work',
		),
		array(
			'How to prevent OLED burn-in',
			'<p>Modern OLEDs are far more resistant than the 2016 generation, and most owners never see burn-in. The ones who do almost always had one static, bright element for thousands of hours. The habits that matter:</p>
<ol>
<li><strong>Leave the automatic protections on.</strong> Logo dimming, pixel shift (the image moves a pixel every few minutes), automatic brightness limiting and the screensaver all exist for this. Turning them off for a "purer" picture is how burn-in happens.</li>
<li><strong>Vary the content.</strong> Eight hours a day of one news channel with a ticker, or one game with a bright HUD, is the high-risk pattern. Mixing content lets the pixels age evenly.</li>
<li><strong>Hide or move static elements.</strong> On a PC monitor: auto-hide the taskbar and dock, use a dark theme, hide the desktop icons, and set the screensaver or screen-off to 5 minutes. In games, lower HUD opacity where the option exists.</li>
<li><strong>Keep brightness reasonable.</strong> Pixel wear rises steeply with brightness. 60 to 80% for daytime viewing is plenty; HDR peaks are brief and fine.</li>
<li><strong>Let the panel run its cycles.</strong> Use standby, not the mains switch, and leave the TV plugged in overnight sometimes.</li>
<li><strong>Phones:</strong> dark mode, auto-brightness, a short screen timeout, and avoid leaving navigation or a game open for hours at full brightness in a car mount.</li>
</ol>
<p>Then check once in a while: the <a href="/oled-test/">OLED test</a> has near-black and gray patterns designed for exactly this, and takes a minute.</p>',
			'prevention',
		),
	),
	'faq'         => array(
		array( 'Can OLED burn-in be fixed?', 'Real burn-in (uneven pixel wear) cannot be reversed, but the panel\'s pixel refresh cycle can compensate for mild cases so the ghost becomes invisible. Temporary image retention, which looks similar, clears on its own with varied content.' ),
		array( 'How long does image retention take to go away?', 'Minutes to a few hours of mixed content. If a ghost is unchanged after a day of normal use and a pixel refresh cycle, it is burn-in.' ),
		array( 'Does pixel refresh damage the panel?', 'A single cycle when needed is what it is designed for. Running it repeatedly consumes panel life because it drives every pixel for an hour. Let the automatic short cycles do the routine work.' ),
		array( 'How long does it take for OLED to burn in?', 'With varied content and the protections on, current panels show no visible burn-in in multi-year tests. With a static bright element on screen for most of every day, it can appear within 1,000 to 2,000 hours. Brightness and static time are what matter, not age.' ),
		array( 'Is an OLED monitor safe for desktop work?', 'Yes with sensible settings: dark theme, auto-hidden taskbar, screen-off after a few minutes, moderate brightness, and the monitor\'s care features on. Monitor OLEDs ship with stronger protections than TVs for this reason, and several brands warranty burn-in for two or three years.' ),
		array( 'Does burn-in happen on LCD screens?', 'LCDs get image retention, which clears, and in rare cases long-term retention from a static image shown for months, but they do not wear unevenly the way OLED emitters do. QLED and mini-LED TVs are LCDs and do not burn in.' ),
	),
);
