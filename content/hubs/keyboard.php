<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Keyboard Tests',
	'seo_title'   => 'Keyboard Tests: Key Tester, Rollover & Spacebar (Free)',
	'description' => 'Free online keyboard tests. Check every key on a full, TKL or 60% layout, find dead and stuck keys, test rollover and ghosting, and count spacebar presses.',
	'intro'       => 'Everything you need to check a keyboard in the browser: a key-by-key tester for dead, stuck and chattering keys, a rollover check for gaming boards, and a spacebar counter. No download, works with laptop, mechanical and wireless keyboards.',
	'body'        => '<h2>Which keyboard test do you need?</h2>
<p>Start with the <a href="/keyboard-tester/">keyboard tester</a> if you want to know whether every key works. It draws a full size, TKL or 60% layout, lights up each key as you press it and keeps it green once it has registered, so a key that never responds or one that fires on its own stands out at once. The same page shows how many keys the board can register at the same time, which is the practical rollover and ghosting check that gaming keyboards are sold on.</p>
<p>Use the <a href="/spacebar-clicker/">spacebar clicker</a> when the question is speed rather than function: it counts presses per second and over a set time, and it doubles as a quick check that the spacebar does not double-register or stick on one side.</p>
<p>For typing problems that only show up in one program, run the key tester first. If every key goes green here, the keyboard is fine and the fault is a shortcut, a layout setting or the program itself.</p>
<p>Gamers should also run the <a href="/keyboard-ghosting-test/">keyboard ghosting test</a>. Hold several keys together and it shows exactly which ones register, measures your rollover (2KRO, 6KRO or NKRO) and checks common combos such as W + A + Shift + Space, which cheaper keyboards often block.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>Dead keys:</strong> a key that never lights up. On laptops a whole row or cluster of dead keys usually means the ribbon cable, not the keys.</li>
<li><strong>Stuck keys:</strong> a key that stays lit or lights up without a press, almost always something under the keycap.</li>
<li><strong>Key chatter:</strong> one press typed twice, common on worn mechanical switches.</li>
<li><strong>Ghosting and limited rollover:</strong> a third or fourth key that is ignored while two others are held. Budget membrane boards do this on some combinations; gaming boards should register six or more keys at once.</li>
<li><strong>Layout mismatches:</strong> the key lights up in the right place but types the wrong character. That is a system language setting, not hardware.</li>
</ul>

<h2>Before you blame the keyboard</h2>
<p>Try another USB port or a different cable, turn Bluetooth off and on for wireless boards, and close any program that remaps keys, such as game launchers or macro software. If an external keyboard works but the laptop\'s own does not, the problem is inside the laptop. Media keys, the Fn row on some laptops and a few special keys are handled by the operating system and never reach the browser, so they can look dead here while doing their job elsewhere.</p>

<h2>Tests that go well with these</h2>
<p>If a key feels slow rather than broken, the <a href="/reaction-time-test/">reaction time test</a> and the <a href="/cps-test/">CPS test</a> give you a feel for input latency against a known number. Once the keyboard checks out, measure how fast you type with the <a href="/typing-speed-test/">typing speed test</a> or the <a href="/1-minute-typing-test/">1 minute typing test</a>. Mouse owners with a similar problem should start at the <a href="/mouse-tester/">mouse tester</a>.</p>',
	'faq'         => array(
		array( 'Does the keyboard tester work with laptop keyboards?', 'Yes. Pick the layout closest to your laptop (usually TKL or 60%) and press every key. Laptop-specific keys such as brightness or volume may be handled by the system and not show up, which is normal.' ),
		array( 'Can it test a wireless or Bluetooth keyboard?', 'Yes. Any keyboard your computer recognises sends the same key events to the browser, wired or not. If keys drop out only when wireless, move the receiver closer or replace the battery before suspecting the keys.' ),
		array( 'How many keys should my keyboard register at once?', 'Most office and laptop keyboards register 2 to 6 keys together, which is enough for typing. Gaming keyboards with N-key rollover register every key you hold. The keyboard tester shows your maximum under "Max at once".' ),
		array( 'A key works here but not in my game. Why?', 'The browser saw the key, so the switch works. Check the game\'s key bindings, make sure another program has not captured the key, and look for a layout mismatch between what the key prints and what the game expects.' ),
		array( 'How do I fix a key that types twice?', 'That is switch chatter. Blow compressed air around the key, or on a mechanical keyboard pull the keycap and clean the switch with contact cleaner. If it keeps happening, the switch needs replacing. Some keyboard software also has a chatter filter.' ),
		array( 'Is anything recorded when I type here?', 'No. Key presses are read in your browser to light up the diagram and are never sent anywhere. The typing area is only for your own eyes and is cleared when you leave the page.' ),
	),
	'updated'     => '2026-10-29',
	'ads'         => 'standard',
);
