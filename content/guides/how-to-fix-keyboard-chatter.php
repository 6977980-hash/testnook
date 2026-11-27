<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Fix Keyboard Chatter (Keys Typing Twice)',
	'seo_title'   => 'How to Fix Keyboard Chatter: Keys Typing Twice, Tested',
	'description' => 'Why a key types two letters for one press, how to confirm chatter with a free online tester, and the fixes that work: cleaning, debounce and new switches.',
	'blurb'       => 'Why one press types twice, how to confirm it and the fixes that work.',
	'hub'         => 'keyboard',
	'tool'        => 'keyboard-tester',
	'tools'       => array( 'keyboard-ghosting-test', 'double-click-test' ),
	'published'   => '2026-11-27',
	'updated'     => '2026-11-27',
	'intro'       => 'You press E once and "ee" appears. Or a key you hit quickly types two, three or none at all. That is keyboard chatter: the switch reports more than one press for a single tap. Here is what causes it, how to prove it in a minute with the <a href="/keyboard-tester/">keyboard tester</a>, and the fixes in the order worth trying.',
	'summary'     => array(
		'Chatter is <strong>contact bounce</strong>: the metal contacts in a switch spring apart and touch again for a few milliseconds, and the keyboard reads each touch as a press.',
		'Every keyboard filters bounce with a short <strong>debounce</strong> delay. Chatter starts when dirt or wear makes a switch bounce longer than that delay.',
		'Confirm it with the <strong>keyboard tester</strong>: a key pressed again within 30 ms of its release turns red and the log shows "Chatter: E twice in 12 ms". No finger is that fast.',
		'Fix it in this order: <strong>clean</strong> the switch, raise the <strong>debounce</strong> time in the keyboard software, <strong>replace the switch</strong> (easy on hot-swap boards), then use the <strong>warranty</strong>.',
	),
	'sections'    => array(
		array(
			'What keyboard chatter is',
			'<p>Inside most mechanical switches, two small metal contacts touch when you press the key. Metal is springy, so the contacts do not meet cleanly: they touch, bounce apart and touch again several times within a few milliseconds before they settle. Engineers call this contact bounce, and "chatter" is the older name for the same thing.</p>
<p>The keyboard\'s controller hides bounce by <strong>debouncing</strong>: after it sees a change, it waits a short time and only counts the press once the signal is steady. The open-source QMK keyboard firmware, for example, waits 5 ms by default. As long as the switch settles inside that window, you never see the bounce.</p>
<p>When a switch gets dirty, oxidized or worn, it bounces for longer. Some of those bounces now land after the debounce window, and the controller reports them as a second press. You see a doubled letter, or a key that seems to release and press again while you hold it.</p>',
			'what-it-is',
		),
		array(
			'Chatter or something else?',
			'<p>Three other problems look like chatter, and the fixes are different:</p>
<ul>
<li><strong>Key repeat:</strong> a key you hold types a long run of letters. That is the system repeat setting, not hardware. It starts only after about half a second of holding.</li>
<li><strong>A stuck key:</strong> the key stays pressed or fires by itself without being touched. See the guide on a <a href="/keyboard-key-not-working/">keyboard key not working</a>.</li>
<li><strong>Ghosting:</strong> keys go missing when you hold several at once. That is a rollover limit; the <a href="/keyboard-ghosting-test/">keyboard ghosting test</a> shows it.</li>
</ul>
<p>Chatter is the one where a single, short press counts twice, and it usually affects one or two keys rather than the whole board. A mouse button that double clicks is the same fault in a mouse switch; the <a href="/double-click-test/">double click test</a> catches it.</p>',
			'or-something-else',
		),
		array(
			'How to confirm chatter with the keyboard tester',
			'<ol>
<li>Open the <a href="/keyboard-tester/">keyboard tester</a> and click the keyboard diagram.</li>
<li>Tap the suspect key 20 to 30 times at a normal typing pace. Press it fully and let it come all the way up each time.</li>
<li>Watch the key. If it turns <strong>red</strong>, the tester saw it pressed again within 30 ms of being released, and the <strong>Chatter</strong> counter goes up.</li>
<li>Open the key log: each bounce has its own line, such as "Chatter: E twice in 12 ms".</li>
<li>If the letter doubles in normal typing but nothing turns red, raise the <strong>Chatter window</strong> to 50 or 80 ms and test again. Very worn switches can bounce that late.</li>
<li>Test two or three keys you know are fine. They should never turn red at a normal pace; if they do, lower the window to 20 ms.</li>
</ol>
<p>A person cannot release a key and press it again in 12 or 20 ms. The fastest real double taps are several times slower, so anything in that range is the switch, not you.</p>',
			'confirm',
		),
		array(
			'Fixes that work, in order',
			'<ol>
<li><strong>Blow it out.</strong> Unplug the keyboard, hold it at an angle and blow compressed air around the key from several sides. Then press the key 50 times quickly to work the contacts. Dust and crumbs are a common cause, and this costs nothing.</li>
<li><strong>Clean the switch.</strong> Pull the keycap with a keycap puller. With the keyboard unplugged, put one drop of electronics contact cleaner (one that is safe on plastic) or 99% isopropyl alcohol into the top of the switch, press the switch 50 to 100 times, and let it dry completely, at least 15 minutes, before plugging the board back in. Never use water or a cleaner that leaves a film.</li>
<li><strong>Raise the debounce time.</strong> Many gaming keyboards have a debounce or "key response" setting in the maker\'s software, and boards with QMK or VIA firmware can be built with a longer debounce. Raising it a few milliseconds hides mild chatter. It also makes very fast double taps a little slower to register, so raise it only as far as needed.</li>
<li><strong>Update the firmware.</strong> Makers sometimes fix debounce bugs in firmware, especially on new boards and wireless boards. Use the official software only.</li>
<li><strong>Replace the switch.</strong> On a hot-swap keyboard, pull the switch with a switch puller and press in a new one of the same type; it takes a minute. On a soldered board, the switch must be desoldered and replaced, which a repair shop can do. Membrane and laptop keyboards cannot have one switch replaced; the keyboard or the laptop top case is replaced instead.</li>
<li><strong>Use the warranty.</strong> Chatter on a keyboard less than a year or two old is a classic warranty fault. Record the tester showing the red key and the log lines, and send that to support with your receipt.</li>
</ol>
<p>After each step, run the keyboard tester again. Stop at the first fix that keeps the key from turning red over 30 or more presses.</p>',
			'fixes',
		),
		array(
			'Why chatter comes back',
			'<p>Cleaning removes dirt, but it cannot undo wear on the contacts. If a key starts chattering again a few weeks after a cleaning, the switch is worn and should be replaced. Switches in the most used spots (space, E, W, A, S, D, the arrow keys) wear first, so it is normal for one of them to fail long before the rest of the board.</p>
<p>Spills are the other common cause. Sugary drinks leave a sticky film on the contacts that compressed air cannot reach. Clean the switch with contact cleaner as soon as you can after a spill, or replace it.</p>',
			'comes-back',
		),
	),
	'faq'         => array(
		array( 'What causes keyboard chatter?', 'Contact bounce in the switch lasting longer than the keyboard\'s debounce delay, usually because of dirt, a spill, oxidation or worn contacts.' ),
		array( 'How do I test for keyboard chatter?', 'Open the keyboard tester, tap the key 20 to 30 times at a normal pace and watch for it turning red. The key log lists each chatter press with the time between release and the next press.' ),
		array( 'Can software fix chatter?', 'It can hide mild chatter by raising the debounce time in the keyboard software or firmware. It cannot repair a switch that keeps getting worse; that switch needs cleaning or replacing.' ),
		array( 'Is chatter covered by warranty?', 'Usually yes, because it is a switch fault, not damage. Keep a recording of the tester showing the chatter as evidence.' ),
		array( 'Do optical switches chatter?', 'Optical and magnetic (Hall effect) switches have no metal contacts to bounce, so they do not suffer from classic contact chatter, though a dirty or faulty sensor can still misfire.' ),
		array( 'Why does only one key type twice?', 'Each key has its own switch. The one that chatters is the one that is dirty or worn, often a key you press more than the others.' ),
	),
	'sources'     => array(
		array( 'Wikipedia: Switch, contact bounce (also called chatter)', 'https://en.wikipedia.org/wiki/Switch#Contact_bounce' ),
		array( 'Wikipedia: Keyboard technology, debouncing', 'https://en.wikipedia.org/wiki/Keyboard_technology' ),
		array( 'QMK Firmware: Contact bounce / contact chatter (default debounce 5 ms)', 'https://docs.qmk.fm/feature_debounce_type' ),
	),
	'ads'         => 'standard',
);
