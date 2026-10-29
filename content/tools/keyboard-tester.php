<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Keyboard Tester',
	'seo_title'      => 'Keyboard Tester: Test Every Key Online (Free Key Checker)',
	'description'    => 'Free online keyboard tester. Press any key and watch it light up on a full, TKL or 60% layout, find dead or stuck keys, check rollover and see key codes.',
	'intro'          => 'Press every key on your keyboard and watch it light up below. Keys turn green once they work, so a dead, stuck or double-typing key stands out in seconds. Works with laptop, mechanical, wireless and gaming keyboards.',
	'device'         => 'desktop',
	'device_message' => 'This test needs a physical keyboard. Connect a keyboard to your phone or tablet by Bluetooth or USB, or open the page on a computer. For the screen itself, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'keyboard-tester' ),
	'scripts'        => array( 'keyboard-tester' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Keyboard layout">
		<button type="button" data-kb-layout="full" aria-pressed="true">Full size</button>
		<button type="button" data-kb-layout="tkl" aria-pressed="false">TKL</button>
		<button type="button" data-kb-layout="sixty" aria-pressed="false">60%</button>
	</div>
	<button type="button" class="btn" id="kb-reset">Reset</button>
</div>
<div class="tool-stage kb-stage">
	<div class="kb-board" id="kb-board" tabindex="0" role="application" aria-label="Keyboard diagram. Click here, then press keys on your keyboard."></div>
</div>
<label class="visually-hidden" for="kb-typing">Typing area</label>
<textarea class="kb-typing" id="kb-typing" rows="2" placeholder="Or type here to check for repeated or missing characters..." spellcheck="false" autocomplete="off"></textarea>
<div class="stats kb-stats">
	<div class="stat"><span class="stat-label">Last key</span><span class="stat-value" id="kb-key">-</span></div>
	<div class="stat"><span class="stat-label">Code</span><span class="stat-value" id="kb-code">-</span></div>
	<div class="stat"><span class="stat-label">Key code</span><span class="stat-value" id="kb-which">-</span></div>
	<div class="stat"><span class="stat-label">Held now</span><span class="stat-value" id="kb-held">0</span></div>
	<div class="stat"><span class="stat-label">Max at once</span><span class="stat-value" id="kb-max">0</span></div>
	<div class="stat"><span class="stat-label">Keys tested</span><span class="stat-value"><span id="kb-tested">0</span> / <span id="kb-total">0</span></span></div>
</div>
<p class="tool-status" id="kb-status" aria-live="polite">Click here and press every key. Each one turns green when it works.</p>',
	'howto'          => array(
		'Click anywhere on the keyboard diagram so the page receives your key presses. Pick the layout that matches your keyboard: <strong>Full size</strong> with a number pad, <strong>TKL</strong> without one, or <strong>60%</strong> for compact boards.',
		'Press every key, one at a time, including Shift, Ctrl, Alt, the function keys and the arrows. Each key lights up while held and turns green once it has registered.',
		'Hold several keys together and read <strong>Max at once</strong>. Most keyboards register at least 6 keys (6-key rollover); gaming keyboards with NKRO register all of them.',
		'Type a sentence in the typing area. Watch for letters that appear twice, appear late or do not appear at all.',
		'Any key still grey after you have pressed it is a dead key. A key that lights up on its own is stuck.',
	),
	'howto_title'    => 'How to test your keyboard',
	'results'        => '<ul>
<li><strong>All keys turn green:</strong> every switch and the keyboard\'s controller work. If a key still fails in one program, the problem is a shortcut or setting in that program.</li>
<li><strong>A key never lights up:</strong> dead key. Dirt under the keycap, a worn membrane or a failed switch. On laptops a cluster of dead keys often means a damaged ribbon cable.</li>
<li><strong>A key lights up without being pressed, or stays lit:</strong> stuck key. Usually something spilled or crumbs under the cap.</li>
<li><strong>A letter appears twice when typed once:</strong> chatter, common on worn mechanical switches. Cleaning or a switch replacement fixes it.</li>
<li><strong>Max at once stays at 2 or 3 on certain combinations:</strong> ghosting or limited rollover. Normal on budget keyboards; gaming keyboards should handle 6 or more.</li>
<li><strong>The wrong character shows in the typing area:</strong> a layout mismatch (for example a UK keyboard set to US), not a hardware fault. Change the keyboard layout in your system settings.</li>
</ul>',
	'extra'          => array(
		array(
			'Key, code and key code',
			'<p><strong>Last key</strong> is the character or name your operating system produced, so it follows your language layout. <strong>Code</strong> is the physical position of the key (such as <code>KeyQ</code> or <code>ShiftLeft</code>), which is the same on every layout and is what this diagram uses to light keys up. <strong>Key code</strong> is the older numeric value some programs and games still read. If a game ignores a key, compare the code shown here with the game\'s key binding screen.</p>
<p>Media keys, Fn-combinations and some laptop special keys are handled by the system and may not reach the browser at all, so they can appear not to work here even though they do their job.</p>',
			'key-codes',
		),
		array(
			'Test a laptop, mechanical or wireless keyboard',
			'<p>This keyboard checker works with any keyboard your computer sees, including laptop keyboards, mechanical and membrane desktop keyboards, Bluetooth keyboards and keyboards connected to a phone or tablet. For wireless keyboards, a key that works only sometimes usually points to a low battery or interference rather than a broken switch. To test the spacebar at speed, or your other input devices, try the <a href="/mouse-tester/">mouse tester</a> and <a href="/gamepad-tester/">gamepad tester</a>.</p>',
			'keyboard-types',
		),
	),
	'fixes'          => array(
		array( 'A key does not work', 'Turn the keyboard over and shake out debris, then blow compressed air around the key. On desktop keyboards pull the keycap off and clean under it. Try the keyboard on another computer or port; if the same key fails everywhere, the switch or membrane is faulty.' ),
		array( 'Keys type twice or repeat', 'For mechanical keyboards this is switch chatter: clean the switch with contact cleaner or replace it. On any keyboard also check Settings > Accessibility > Keyboard for Filter Keys (Windows) or the key repeat delay, which can mimic the problem.' ),
		array( 'Whole keyboard stopped working', 'Unplug and reconnect it, or replace the batteries and re-pair a wireless keyboard. On laptops, restart; if keys still fail after a restart and in the BIOS or boot menu, the keyboard or its cable is faulty.' ),
		array( 'Wrong characters appear', 'Your system keyboard layout does not match the printed keys. Windows: Settings > Time & language > Language & region > choose the right layout. Mac: System Settings > Keyboard > Input Sources. Also check that Num Lock is on if the number pad types nothing.' ),
	),
	'faq'            => array(
		array( 'How do I test if my keyboard keys are working?', 'Click the diagram and press every key. Keys that work turn green; keys that stay grey after you press them are dead.' ),
		array( 'Why does a key not light up even though it types?', 'Some keys, such as Fn, media keys and the Windows key in some games, are handled by the system and never reach the browser. If the key does its job elsewhere, it works.' ),
		array( 'How many keys should I be able to press at once?', 'At least 6 on most keyboards. Gaming keyboards with N-key rollover register every key at the same time.' ),
		array( 'Can I test a laptop keyboard here?', 'Yes. Pick the TKL or 60% layout to match your laptop. The number pad block only applies to full-size keyboards.' ),
		array( 'What is key chatter?', 'When one press registers twice, so letters appear doubled. It happens when a mechanical switch\'s contacts bounce, usually because of dirt or wear.' ),
		array( 'Does this keyboard test work for Mac?', 'Yes. The Win key position shows the Command key on Mac keyboards, and the layout is otherwise the same.' ),
	),
	'related'        => array( 'keyboard-ghosting-test', 'spacebar-clicker', 'typing-speed-test', 'mouse-tester', 'gamepad-tester', 'double-click-test', 'reaction-time-test' ),
	'updated'        => '2026-10-28',
);
