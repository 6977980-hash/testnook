<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Fix Keyboard Ghosting',
	'seo_title'   => 'How to Fix Keyboard Ghosting: Causes, Tests and Fixes',
	'description' => 'Why your keyboard drops keys when you press several at once, how to test for ghosting and rollover, and the fixes that work: USB mode, key binds and new boards.',
	'blurb'       => 'Why keys vanish when you hold several at once, how to test it and what fixes it.',
	'hub'         => 'keyboard',
	'tool'        => 'keyboard-ghosting-test',
	'tools'       => array( 'keyboard-tester', 'spacebar-clicker' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'You hold W, Shift and Space to sprint and jump, and the jump never happens. That is keyboard ghosting or blocking: the keyboard cannot report that many keys at once. Here is what causes it, how to find your exact limit and which fixes actually help.',
	'summary'     => array(
		'Ghosting happens when a keyboard <strong>cannot tell which keys are held</strong> once three or more are down, so it drops some presses or, on very old boards, adds phantom ones.',
		'It is a hardware limit of the key matrix, not a driver bug. Most office and laptop keyboards handle only <strong>2 or 3 keys</strong> in some combinations.',
		'Test it by holding your game combos in a <strong>ghosting test</strong>. If a combo fails, rebind one of its keys to a key in another part of the board.',
		'The only full fix is a keyboard with <strong>NKRO</strong> or at least 6KRO, which is now common even on cheap mechanical boards.',
	),
	'sections'    => array(
		array(
			'What keyboard ghosting is',
			'<p>A keyboard does not wire every key to its own input. To save cost, keys sit on a grid of rows and columns, called the matrix. The controller scans one row at a time and checks which columns are active. With one or two keys down that works perfectly. With three keys that form three corners of a rectangle on the grid, the current can flow back through the third key and make the fourth corner look pressed too.</p>
<p>That phantom key is true <strong>ghosting</strong>. Because a phantom key press is worse than a missing one, almost every keyboard made in the last twenty years blocks it: when the controller sees an ambiguous pattern, it ignores the new key. That is <strong>key blocking</strong>, and it is what most people mean when they say their keyboard ghosts. The symptom is the same either way: you press a key and nothing happens while other keys are held.</p>
<p>The number of keys a keyboard can always report together is its <strong>key rollover</strong>, written as 2KRO, 6KRO or NKRO (N-key rollover, any number of keys).</p>',
			'what-it-is',
		),
		array(
			'Signs that your keyboard is ghosting',
			'<ul>
<li>In a game, a move fails only while you hold two other keys, such as jumping while running diagonally (W + A + Space) or crouching while strafing.</li>
<li>Two players sharing one keyboard keep losing inputs when both press keys at the same moment.</li>
<li>Fast typists see a missing letter in quick rolls such as "ing" or "the", where keys overlap for a split second.</li>
<li>The same key works perfectly on its own in a <a href="/keyboard-tester/">keyboard tester</a>.</li>
</ul>
<p>That last point is the key difference from a broken key. A key that fails on its own has a dirty or worn switch (see the guide on <a href="/keyboard-key-not-working/">a keyboard key not working</a>). A key that only fails in certain combinations is a rollover limit.</p>',
			'signs',
		),
		array(
			'How to test for ghosting',
			'<p>Open the <a href="/keyboard-ghosting-test/">keyboard ghosting test</a> and hold keys down one by one without letting go. The test lights each key it receives and counts how many it can see at once. Then try the exact combinations you use:</p>
<ol>
<li>Hold your movement keys together: W + A, then W + D, then add Shift.</li>
<li>While holding those, press Space, Ctrl, E, Q and the number keys one at a time.</li>
<li>Note every key that stays dark. Those are the combos the board blocks.</li>
<li>Repeat with the arrow keys and the right-hand side if you play with them.</li>
</ol>
<p>What the count means:</p>
<div class="table-scroll"><table>
<thead><tr><th>Keys at once</th><th>Rollover</th><th>Typical keyboard</th></tr></thead>
<tbody>
<tr><td>2 to 3</td><td>2KRO / 3KRO</td><td>Cheap membrane and many laptop keyboards</td></tr>
<tr><td>4 to 5</td><td>Partial anti-ghosting</td><td>Budget gaming boards, often only on WASD</td></tr>
<tr><td>6 plus modifiers</td><td>6KRO</td><td>Many mechanical boards, or any board in USB boot mode</td></tr>
<tr><td>10 or more</td><td>NKRO</td><td>Gaming and enthusiast mechanical boards</td></tr>
</tbody></table></div>
<p>Results depend on which keys you pick, because blocking depends on where the keys sit in the matrix. A board can handle eight keys in one corner and fail on three in another. Always test the combos you really use.</p>',
			'test',
		),
		array(
			'Fixes that work',
			'<p>You cannot rewire the matrix, but you can work around it or remove the limit:</p>
<ol>
<li><strong>Rebind the failing key.</strong> If W + A + Space fails, move jump to a key that works with W and A, such as a mouse side button or a key the test showed as clear. This is free and usually solves the problem in one game.</li>
<li><strong>Turn on NKRO mode.</strong> Many gaming keyboards ship in 6KRO mode for compatibility and have NKRO behind a key combo (often Fn + N, Fn + Insert or a switch on the back) or in the maker\'s software. Check the manual, then test again.</li>
<li><strong>Try another USB port or mode.</strong> Some boards only offer NKRO over USB, not Bluetooth or a 2.4 GHz dongle, and some hubs and KVM switches reduce them to 6KRO. Plug straight into the computer.</li>
<li><strong>Update the firmware.</strong> Makers sometimes fix rollover bugs, especially on wireless boards. Use the official software only.</li>
<li><strong>Disable conflicting software.</strong> Macro tools and key remappers can swallow key events. Close them and test again to rule them out.</li>
<li><strong>Replace the keyboard.</strong> If the board is a basic membrane or laptop keyboard with 2KRO, the limit is in hardware. A mechanical keyboard with 6KRO or NKRO costs little today and ends the problem for every game.</li>
</ol>',
			'fixes',
		),
		array(
			'Is 6KRO enough, or do I need NKRO?',
			'<p>For almost everyone, 6KRO is enough. It means any six normal keys plus all the modifiers (Shift, Ctrl, Alt, Windows) register together, which covers every common game input. NKRO matters for rhythm games that use many keys, for stenography, for two players on one keyboard and for people who want no limit at all.</p>
<p>Laptops are the weak spot. Their keyboards are built thin and cheap, and many only guarantee two keys outside the WASD area. If you game on a laptop and keep losing inputs, an external keyboard is often the simplest fix.</p>
<p>A board that says "anti-ghosting" on the box usually means only some keys are protected. Look for "NKRO" or "full anti-ghosting" in the specs, and test it in the shop or as soon as it arrives.</p>',
			'6kro-vs-nkro',
		),
	),
	'faq'         => array(
		array( 'What is keyboard ghosting?', 'Ghosting is when a keyboard misreads key presses because several keys are held at once. Most modern keyboards block the extra key instead of adding a fake one, so the symptom is a key press that does not register.' ),
		array( 'Can ghosting be fixed with software?', 'Not the hardware limit itself. Software can only help by rebinding keys to a combination the keyboard can report, or by turning on an NKRO mode that the keyboard already supports.' ),
		array( 'Do all keyboards have ghosting?', 'All matrix keyboards have some limit unless they are built with NKRO, which uses a diode on every switch. Most mechanical gaming keyboards are NKRO or 6KRO; most office and laptop keyboards are not.' ),
		array( 'Is ghosting the same as a key not working?', 'No. A key that never works has a hardware or dirt problem. A key that works alone but fails while other keys are held is a rollover limit.' ),
		array( 'Does wireless cause ghosting?', 'It can. Some wireless and Bluetooth keyboards report fewer keys at once than the same model on a cable. Test both connections.' ),
		array( 'How many keys can a normal keyboard press at once?', 'A basic office keyboard can usually report 2 or 3 keys in any combination and more in some areas. A 6KRO board handles 6 plus modifiers and an NKRO board handles all of them.' ),
	),
);
