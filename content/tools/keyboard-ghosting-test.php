<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Keyboard Ghosting Test',
	'seo_title'      => 'Keyboard Ghosting Test: Check Key Rollover and NKRO Online',
	'description'    => 'Free keyboard ghosting test. Hold several keys at once to see which ones register, find blocked gaming combos and measure your key rollover: 2KRO, 6KRO or NKRO.',
	'intro'          => 'Hold down several keys at the same time and see exactly which ones your keyboard reports. Keys that refuse to light up while others are held are being blocked; keys that light up without being pressed are ghosting. The test also measures your rollover and checks common gaming combos such as sprint-jumping diagonally.',
	'device'         => 'desktop',
	'device_message' => 'This test needs a physical keyboard. Connect a keyboard to your tablet by USB or Bluetooth, or open the page on a computer.',
	'ads'            => 'content',
	'styles'         => array( 'keyboard-tester', 'keyboard-ghosting-test' ),
	'scripts'        => array( 'keyboard-ghosting-test' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<button type="button" class="btn" id="gh-reset">Reset</button>
</div>
<div class="tool-stage kb-stage">
	<div class="kb-board kb-sixty gh-board" id="gh-board" tabindex="0" role="application" aria-label="Keyboard diagram. Click here, then hold several keys at once."></div>
	<p class="gh-focus-hint">Click the keyboard first, then hold keys down together.</p>
</div>
<div class="gh-held" id="gh-held" aria-live="polite">Nothing held</div>
<div class="stats gh-stats">
	<div class="stat"><span class="stat-label">Held now</span><span class="stat-value" id="gh-now">0</span></div>
	<div class="stat"><span class="stat-label">Most at once</span><span class="stat-value" id="gh-max">0</span></div>
	<div class="stat"><span class="stat-label">Rollover</span><span class="stat-value" id="gh-kro">-</span></div>
	<div class="stat"><span class="stat-label">Best combo</span><span class="stat-value" id="gh-best">-</span></div>
</div>
<ul class="gh-combos" id="gh-combos" aria-label="Combos to try"></ul>
<p class="tool-status" id="gh-status" aria-live="polite">Hold the keys of each combo below at the same time. Each one turns green when every key registers.</p>',
	'howto'          => array(
		'Click the keyboard diagram so the page receives your key presses.',
		'Press and hold keys one after another without letting go: for example W, then A, then Shift, then Space. Each held key stays lit and appears in the list under the diagram.',
		'Watch for a key you are holding that does not light up (blocking), or a key that lights up although you did not press it (ghosting).',
		'Work through the combos below the counters. Each turns green when all of its keys are held at the same time.',
		'Then press as many keys as you can at once, with both hands flat on the keyboard. <strong>Most at once</strong> is your rollover.',
	),
	'howto_title'    => 'How to test keyboard ghosting',
	'results'        => '<p><strong>Ghosting</strong> is when the keyboard reports a key you did not press. <strong>Blocking</strong> (often also called ghosting) is when it ignores a key you did press because of the other keys held. Both come from the way cheaper keyboards wire their keys in a grid: with three corners of a rectangle pressed, the fourth can look pressed too, so the keyboard blocks it instead.</p>
<div class="table-scroll"><table>
<thead><tr><th>Most at once</th><th>Rollover</th><th>Typical keyboard</th></tr></thead>
<tbody>
<tr><td>2-3</td><td>2KRO / 3KRO</td><td>Cheap membrane and many laptop keyboards</td></tr>
<tr><td>4-5</td><td>Partial anti-ghosting</td><td>Budget "gaming" keyboards with anti-ghosting on WASD only</td></tr>
<tr><td>6 (plus modifiers)</td><td>6KRO</td><td>Many mechanical keyboards, or any keyboard in USB boot mode</td></tr>
<tr><td>10 or more</td><td>NKRO</td><td>Gaming and enthusiast mechanical keyboards</td></tr>
</tbody></table></div>
<p>Modifier keys such as Shift, Ctrl and Alt are often reported separately, so a 6KRO keyboard can show 6 letters plus several modifiers. For games, it matters most that your own key combos register; 6KRO is enough for almost everyone.</p>',
	'extra'          => array(
		array(
			'Ghosting vs key rollover vs NKRO',
			'<p><strong>Key rollover</strong> (KRO) is how many keys a keyboard can report at once. <strong>NKRO</strong> (N-key rollover) means every key, no matter how many are held. <strong>Anti-ghosting</strong> is a marketing term that usually means the keyboard blocks impossible combinations instead of inventing keys, and often only covers a group of gaming keys such as WASD. A keyboard can be anti-ghosting and still only manage 3 or 4 keys in some areas, which this test shows.</p>
<p>The term "ghosting" is also used for monitors, where it means a trail behind moving objects. For that, use the <a href="/ufo-test/">UFO test</a>. To check that every single key works, use the <a href="/keyboard-tester/">keyboard tester</a>.</p>',
			'kro-explained',
		),
		array(
			'Why your result may be lower than the box says',
			'<p>Some NKRO keyboards only enable NKRO in a special mode (a key combination such as Fn + N, or a setting in the vendor software), and fall back to 6KRO for compatibility. Wireless keyboards and USB hubs can also limit it, and Bluetooth often reports 6 keys at most. Your operating system adds limits of its own: Windows key combinations, Alt + Tab and Ctrl + Alt + Del are handled by the system before the browser sees them.</p>',
			'lower-result',
		),
	),
	'fixes'          => array(
		array( 'My gaming combo is blocked', 'Remap the action to a key that works in combination with the others, for example move crouch from Ctrl to C. Keys far apart on the keyboard are less likely to share a matrix row and block each other.' ),
		array( 'The result is stuck at 6 keys', 'Look for an NKRO mode: many keyboards switch with Fn + N, Fn + Insert, or in their software. Connect by USB cable instead of Bluetooth or a hub, and try another USB port.' ),
		array( 'A key lights up that I did not press', 'That is true ghosting. Note the combination that causes it and avoid it in games, or use a keyboard with NKRO. Also rule out a stuck or chattering key with the <a href="/keyboard-tester/">keyboard tester</a>.' ),
	),
	'faq'            => array(
		array( 'How do I test keyboard ghosting?', 'Click the keyboard on this page and hold several keys down together. Any held key that does not light up is blocked; any key that lights up without being pressed is ghosting.' ),
		array( 'What is a good key rollover?', '6KRO handles almost every game and fast typing. NKRO (10 or more keys at once) is a bonus for rhythm games and stenography. Under 4 keys can cause missed inputs in games.' ),
		array( 'Do laptop keyboards have ghosting?', 'Most laptop keyboards are 2KRO or 3KRO with blocking in some combinations. Gaming laptops often add anti-ghosting for the WASD area.' ),
		array( 'Why does Win, Alt + Tab or Ctrl + Alt + Del not show?', 'The operating system catches these combinations before the browser, so a web page cannot see them. They are not counted as faults.' ),
		array( 'Is ghosting a hardware fault?', 'No, it is a limit of how the keyboard is built. A key that does not work at all, or types twice, is a fault; check those with the keyboard tester.' ),
		array( 'Can I fix keyboard ghosting?', 'Not on the keyboard itself, but you can avoid it: remap the blocked actions to keys that work together, turn on NKRO mode if the keyboard has one, or use a keyboard with NKRO.' ),
	),
	'related'        => array( 'keyboard-tester', 'spacebar-clicker', 'typing-speed-test', 'mouse-tester', 'gamepad-tester', 'reaction-time-test', 'mouse-latency-test', 'ufo-test' ),
	'updated'        => '2026-10-29',
);
