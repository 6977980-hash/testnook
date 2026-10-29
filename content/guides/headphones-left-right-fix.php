<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Headphones Left and Right Not Working: How to Fix It',
	'seo_title'   => 'One Side of Headphones Not Working? Left and Right Fixes',
	'description' => 'Fix headphones when only one side works or left and right are swapped: test each channel, check balance and mono settings, the jack, Bluetooth and the cable.',
	'blurb'       => 'One earcup silent, quieter or swapped? Test each side and fix settings, plugs and cables.',
	'hub'         => 'audio',
	'tool'        => 'headphone-test',
	'tools'       => array( 'stereo-test', 'mono-test', 'sound-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'When only one side of your headphones plays, or the left and right sound wrong, the fault can be in a setting, the plug, the Bluetooth link or the headphones themselves. A few quick tests tell you which. Here is how to find it and fix it, starting with the free fixes.',
	'summary'     => array(
		'First run a <strong>left / right test</strong>. If you hear the "left" sound on the right, the headphones are on backwards or the channels are swapped; if one side is silent, keep going.',
		'Check the <strong>balance slider</strong> and <strong>mono audio</strong> setting on your phone or computer. Both are common causes of one quiet or silent side.',
		'For wired headphones, push the plug <strong>fully in</strong>, clean the jack, and wiggle the cable near the plug while sound plays to find a broken wire.',
		'For wireless earbuds, <strong>reset and re-pair</strong> both buds and clean the charging contacts. If one side still fails on two devices, it is a hardware fault.',
	),
	'sections'    => array(
		array(
			'Step 1: test each side',
			'<p>Put the headphones on the right way round (look for the small L and R marks) and open the <a href="/headphone-test/">headphone test</a>. Play the left, right and center sounds.</p>
<div class="table-scroll"><table>
<thead><tr><th>What you hear</th><th>Likely cause</th></tr></thead>
<tbody>
<tr><td>Left sound in the right ear, and the reverse</td><td>Headphones on backwards, swapped channels in software, or a wiring fault in a repaired cable</td></tr>
<tr><td>Both sounds in both ears equally</td><td>Mono audio is on, or a mono adapter or headset port</td></tr>
<tr><td>One side silent for every sound</td><td>Balance setting, a bad plug contact, a broken wire or a dead driver</td></tr>
<tr><td>One side much quieter</td><td>Balance setting, earwax on the mesh, or a damaged driver</td></tr>
<tr><td>Center sounds thin or hollow, voices quiet</td><td>One driver wired backwards (out of phase)</td></tr>
</tbody></table></div>
<p>The <a href="/stereo-test/">stereo test</a> adds a pan sweep and a phase check, and the <a href="/mono-test/">mono test</a> tells you in seconds whether your device is sending stereo at all.</p>',
			'test-each-side',
		),
		array(
			'Step 2: check balance and mono settings',
			'<p>These two settings cause more "broken" headphones than any hardware fault:</p>
<ul>
<li><strong>iPhone:</strong> Settings > Accessibility > Audio & Visual. Turn Mono Audio off and set the Balance slider to the middle.</li>
<li><strong>Android:</strong> Settings > Accessibility > Audio (or Hearing enhancements). Check Mono audio and the left/right balance slider.</li>
<li><strong>Windows:</strong> Settings > System > Sound > your output device > Properties. Check that the left and right levels match, and that Mono audio is off under Settings > Accessibility > Audio.</li>
<li><strong>Mac:</strong> System Settings > Sound > Output, select the headphones and center the Balance slider. Mono is under Accessibility > Audio.</li>
</ul>
<p>Also check the app you are using. Some music players, games and video calls have their own balance or "spatial audio" options, and some headsets have a mic monitoring or sidetone setting that can make one side seem louder.</p>',
			'settings',
		),
		array(
			'Step 3: fixes for wired headphones',
			'<ol>
<li><strong>Push the plug all the way in.</strong> A 3.5 mm plug that stops one click short connects only some contacts, which often leaves one side silent. Thick phone cases can stop it going fully in.</li>
<li><strong>Clean the jack.</strong> Pocket lint packs into headphone jacks. Turn the device off and lift lint out gently with a wooden or plastic toothpick. A few short puffs of air help; do not use metal tools.</li>
<li><strong>Find a broken wire.</strong> Play the left/right test and slowly bend the cable near the plug and near each earcup. If the sound cuts in and out, a wire is broken at that point. Short-term, a cable tie or tape at the right angle can keep it working; long-term, replace the cable (many headphones have a detachable one) or the headphones.</li>
<li><strong>Try another device and adapter.</strong> A cheap USB-C or Lightning adapter can fail on one channel, and some laptop combo jacks need a headset (TRRS) plug to work correctly.</li>
</ol>
<p>Left and right swapped on wired headphones after a cable repair usually means the two signal wires were soldered to the wrong contacts.</p>',
			'wired',
		),
		array(
			'Step 4: fixes for Bluetooth and earbuds',
			'<ol>
<li><strong>Put both buds in the case</strong> for 10 seconds, then take them out together. Many earbuds stay paired to one bud if they come out of the case at different times.</li>
<li><strong>Clean the charging contacts</strong> on the buds and in the case with a dry cotton swab. A bud that never charges shows up as "not connected".</li>
<li><strong>Clean the mesh.</strong> Earwax on the speaker mesh is the most common cause of one earbud being quieter. Brush it gently with a dry, soft toothbrush.</li>
<li><strong>Forget and re-pair.</strong> Remove the headphones from the Bluetooth list, reset them (usually by holding the case button for 10 to 15 seconds; check the maker\'s guide) and pair again.</li>
<li><strong>Update the firmware</strong> through the maker\'s app. Updates often fix sync problems between buds.</li>
<li><strong>Turn off "mono" call modes.</strong> Some headsets switch to a mono hands-free profile during calls, which sounds flat and can affect one bud only. Choose the stereo (A2DP) profile for music.</li>
</ol>',
			'bluetooth',
		),
		array(
			'When it is a hardware fault',
			'<p>If one side stays silent or distorted on two different devices, after the settings check, cleaning and a reset, the driver or the wiring inside the headphones has failed. Signs of a dead driver: a rattle or buzz at bass, no sound at all at any volume, or crackle that does not change when you move the cable.</p>
<p>Check the warranty first; one-sided failure is a common claim and many makers replace a single earbud. Repairing a driver in a sealed earbud is rarely practical. In over-ear headphones with a removable cable, a new cable fixes most one-sided faults.</p>
<p>Out-of-phase sound (thin center, voices that seem to come from inside your head or nowhere) after a home repair means one driver is wired with plus and minus reversed. Swap the two wires on that driver.</p>',
			'hardware',
		),
	),
	'faq'         => array(
		array( 'Why does only one side of my headphones work?', 'The most common causes are the balance setting, a plug not fully inserted, lint in the jack, a broken wire near the plug, or one earbud not connected. Run a left/right test and work through the settings first.' ),
		array( 'How do I know which side is left on headphones?', 'Look for an L and R mark on the band, the earcups or inside the earbuds. On the headphone test the left sound should come only from the left ear.' ),
		array( 'Why are my left and right swapped?', 'Usually the headphones are on backwards. Otherwise a software option, a game\'s "reverse stereo" setting or a cable repaired with the wires crossed can swap them.' ),
		array( 'Can I fix one earbud not working?', 'Often yes: clean the charging contacts and the mesh, put both buds in the case, reset and re-pair. If it still fails on another phone, it needs a warranty replacement.' ),
		array( 'Why is one earbud quieter than the other?', 'Earwax on the speaker mesh is the most common reason. Clean it gently and check the balance slider in accessibility settings.' ),
		array( 'Does mono audio make one side silent?', 'No. Mono sends the same sound to both ears, so a left or right test sound plays on both sides. Turn it off to test each channel properly.' ),
	),
);
