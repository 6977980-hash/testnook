<?php
defined( 'ABSPATH' ) || exit;

/*
 * Yaw = degrees the camera turns per mouse count at sensitivity 1. Only games
 * whose yaw is listed by a public source we could open are included (see
 * 'sources'). The same list drives the JS through data-yaw attributes, so the
 * page text and the maths cannot drift apart.
 */
$tn_edpi_games = array(
	'cs2'      => array( 'Counter-Strike 2', '0.022' ),
	'valorant' => array( 'Valorant', '0.07' ),
	'apex'     => array( 'Apex Legends', '0.022' ),
	'ow2'      => array( 'Overwatch 2', '0.0066' ),
	'cod'      => array( 'Call of Duty (MW III, Warzone, Black Ops 6)', '0.0066' ),
	'destiny2' => array( 'Destiny 2', '0.0066' ),
	'tf2'      => array( 'Team Fortress 2', '0.022' ),
	'quake'    => array( 'Quake Live / Quake Champions', '0.022' ),
);

$tn_edpi_options = function ( $selected ) use ( $tn_edpi_games ) {
	$html = '';
	foreach ( $tn_edpi_games as $key => $g ) {
		$html .= '<option value="' . $key . '" data-yaw="' . $g[1] . '"' . ( $key === $selected ? ' selected' : '' ) . '>' . $g[0] . '</option>';
	}
	return $html . '<option value="custom">Other game (enter its yaw)</option>';
};

$tn_edpi_rows = '';
foreach ( $tn_edpi_games as $key => $g ) {
	$tn_edpi_rows .= '<tr><td>' . $g[0] . '</td><td>' . $g[1] . '</td></tr>';
}

return array(
	'title'          => 'eDPI Calculator and Sensitivity Converter',
	'seo_title'      => 'eDPI Calculator & Sensitivity Converter (cm/360)',
	'description'    => 'Free eDPI calculator: DPI x in-game sensitivity, your cm/360, and your sensitivity converted between CS2, Valorant, Apex, Overwatch 2, CoD and more.',
	'intro'          => 'Work out your eDPI (mouse DPI times in-game sensitivity), see how far you move the mouse for a full 360° turn, and convert your sensitivity to another game or another DPI so your aim feels the same. Everything is calculated in your browser.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'screen-info', 'edpi-calculator' ),
	'scripts'        => array( 'edpi-calculator' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-stage si-stage ed-stage">
	<div class="si-form">
		<label>Mouse DPI<input type="number" id="ed-dpi" min="50" max="50000" step="any" value="800" inputmode="numeric"></label>
		<label>In-game sensitivity<input type="number" id="ed-sens" min="0" step="any" value="0.5" inputmode="decimal"></label>
		<label>Game<select id="ed-from">' . $tn_edpi_options( 'valorant' ) . '</select></label>
		<label class="ed-yaw" hidden>Yaw of that game (degrees per count)<input type="number" id="ed-yaw-from" min="0" step="any" placeholder="e.g. 0.022" inputmode="decimal"></label>
	</div>
	<p class="si-note is-bad" id="ed-msg" role="alert"></p>
	<div class="si-hero" style="margin-top:12px"><small>Your eDPI</small><strong id="ed-edpi">-</strong><span id="ed-edpi-note"></span></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">cm/360</span><span class="stat-value" id="ed-cm360">-</span></div>
		<div class="stat"><span class="stat-label">inches/360</span><span class="stat-value" id="ed-in360">-</span></div>
		<div class="stat"><span class="stat-label">Counts per 360°</span><span class="stat-value" id="ed-counts">-</span></div>
	</div>
	<h2 class="si-sub" id="ed-convert-title">Convert your sensitivity</h2>
	<div class="si-form">
		<label>To game<select id="ed-to">' . $tn_edpi_options( 'cs2' ) . '</select></label>
		<label class="ed-yaw" hidden>Yaw of that game (degrees per count)<input type="number" id="ed-yaw-to" min="0" step="any" placeholder="e.g. 0.022" inputmode="decimal"></label>
		<label>At DPI (optional)<input type="number" id="ed-dpi2" min="50" max="50000" step="any" placeholder="same DPI" inputmode="numeric"></label>
	</div>
	<div class="si-hero ed-out" style="margin-top:12px"><small id="ed-to-name">Sensitivity in Counter-Strike 2</small><strong id="ed-out-sens">-</strong><span id="ed-out-note"></span></div>
	<h2 class="si-sub">Same aim in every game</h2>
	<div class="table-scroll"><table class="ed-table"><thead><tr><th>Game</th><th>Sensitivity</th><th>eDPI there</th></tr></thead><tbody id="ed-all"></tbody></table></div>
	<p class="si-note">Hip-fire sensitivity at your DPI, keeping the same cm/360. Scoped and ADS multipliers are separate settings in each game.</p>
</div>',
	'howto'          => array(
		'Type the <strong>DPI</strong> set in your mouse software. If you are not sure it is accurate, measure it with the <a href="/dpi-analyzer/">DPI analyzer</a> and use that number.',
		'Type your <strong>in-game sensitivity</strong> and pick the game it comes from. Your eDPI and cm/360 appear at once.',
		'Under <strong>Convert your sensitivity</strong>, pick the game you are moving to. Add a new DPI too if you are changing mice or DPI steps.',
		'Copy the new sensitivity into the game. The table shows the matching value for every game in the list.',
	),
	'howto_title'    => 'How to use the eDPI calculator',
	'results'        => '<p><strong>eDPI</strong> (effective DPI) is <code>DPI &times; in-game sensitivity</code>. 800 DPI at 0.5 gives 400 eDPI, the same as 400 DPI at 1.0, and both feel identical in that game. eDPI only compares players <em>within one game</em>, because each game turns the camera by a different amount per mouse count.</p>
<p><strong>cm/360</strong> is how far you move the mouse to turn a full circle. It works across games, so it is the number to keep when you switch. The formula is <code>cm/360 = 360 / (yaw &times; sensitivity &times; DPI) &times; 2.54</code>, where <strong>yaw</strong> is the angle the game turns per mouse count at sensitivity 1. Valorant at 800 DPI and 0.5 sensitivity: 360 / (0.07 &times; 0.5 &times; 800) = 12.86 inches, or 32.7 cm.</p>
<p><strong>Converting</strong> keeps cm/360 the same: <code>new sensitivity = old sensitivity &times; old yaw / new yaw</code> (times old DPI / new DPI if you change DPI). Valorant 0.5 becomes 0.5 &times; 0.07 / 0.022 = 1.59 in CS2.</p>
<div class="table-scroll"><table>
<thead><tr><th>Style</th><th>Typical cm/360</th></tr></thead>
<tbody>
<tr><td>Low sensitivity, arm aiming (common in CS2 and Valorant)</td><td>40-60 cm</td></tr>
<tr><td>Medium</td><td>25-40 cm</td></tr>
<tr><td>High sensitivity, wrist aiming (common in fast arena shooters)</td><td>15-25 cm</td></tr>
</tbody></table></div>
<p>These ranges are rough habits, not rules. The right value is the one where you neither overshoot targets nor run out of mousepad in a turn.</p>',
	'extra'          => array(
		array(
			'Yaw values used',
			'<p>Each game\'s yaw is the angle in degrees the camera turns for one mouse count at sensitivity 1. These are the values the calculator uses, taken from the sources listed below. Source engine games set it with the <code>m_yaw</code> console variable (default 0.022); for Valorant, Overwatch 2, Call of Duty and Destiny 2 the publishers do not document it, so the values are the ones published by sensitivity converter sites.</p>
<div class="table-scroll"><table><thead><tr><th>Game</th><th>Yaw (degrees per count)</th></tr></thead><tbody>' . $tn_edpi_rows . '</tbody></table></div>
<p>Your game is not in the list? Choose <strong>Other game</strong> and type its yaw. We only list games whose value we could check in a public source.</p>',
			'yaw',
		),
		array(
			'eDPI or cm/360: which to compare',
			'<p>Use <strong>eDPI</strong> when you compare yourself with players of the same game, for example a pro\'s Valorant settings. Use <strong>cm/360</strong> when you move between games or want a number that does not depend on the game at all. Both ignore field of view: at a different FOV the same cm/360 can feel a little faster or slower near the crosshair, which is why some players fine-tune by a few percent after converting.</p>
<p>Converting also assumes your DPI is what the software says. A sensor that is 5% off changes your real cm/360 by 5% too. If two mice set to the same DPI feel different, measure both with the <a href="/dpi-analyzer/">DPI analyzer</a> and enter the measured values here. For choosing a DPI in the first place, see <a href="/what-dpi-should-i-use/">what DPI should I use</a>.</p>',
			'edpi-vs-cm360',
		),
	),
	'fixes'          => array(
		array( 'The converted sensitivity feels faster or slower', 'Check that mouse acceleration is off in both the game and Windows ("Enhance pointer precision"), that raw input is on where the game offers it, and that your DPI really is what you entered. A different field of view can also change the feel near the crosshair even at the same cm/360.' ),
		array( 'My game only accepts two decimal places', 'Round to the nearest value it allows. A change of 0.01 at a sensitivity of 1.5 is less than 1% of your cm/360, which few people can feel.' ),
		array( 'My scoped or ADS sensitivity feels wrong', 'This calculator converts hip-fire sensitivity. Scope and aim-down-sights multipliers work differently in each game; start from the game\'s default multiplier after converting.' ),
	),
	'faq'            => array(
		array( 'What is eDPI?', 'Effective DPI: your mouse DPI multiplied by your in-game sensitivity. 800 DPI at 0.5 sensitivity is 400 eDPI.' ),
		array( 'What is a good eDPI for Valorant?', 'Many Valorant players sit around 200-400 eDPI, which at the game\'s yaw of 0.07 is about 33-65 cm/360. Higher works too if you aim with your wrist.' ),
		array( 'What is a good eDPI for CS2?', 'Many CS2 players use about 600-1200 eDPI, roughly 35-69 cm/360. CS2 uses a yaw of 0.022, so the same feel needs a bigger number than in Valorant.' ),
		array( 'How do I convert Valorant sensitivity to CS2?', 'Multiply by 0.07 / 0.022, about 3.18. Valorant 0.4 becomes 1.27 in CS2 at the same DPI. To go back, divide by 3.18.' ),
		array( 'Does changing DPI change my eDPI?', 'Yes, unless you change the sensitivity too. To keep the same feel at double the DPI, halve the in-game sensitivity. Use the "At DPI" box to get the exact value.' ),
		array( 'Is cm/360 better than eDPI?', 'cm/360 works across all games, eDPI only within one game. Use cm/360 when switching games, eDPI when comparing with players of the same game.' ),
	),
	'sources'        => array(
		array( 'Valve Developer Community: List of Counter-Strike 2 console commands and variables (m_yaw, default 0.022)', 'https://developer.valvesoftware.com/wiki/List_of_Counter-Strike_2_console_commands_and_variables' ),
		array( 'CSDB: m_yaw command, default 0.022', 'https://csdb.gg/command/m-yaw/' ),
		array( 'CSDB: sensitivity converter, yaw table for 30 games', 'https://csdb.gg/sensitivity-converter/' ),
		array( 'VCRDB: sensitivity converter (1.0 Valorant = 3.1818 CS2)', 'https://www.vcrdb.net/converter' ),
	),
	'related'        => array( 'dpi-analyzer', 'mouse-accuracy-test', 'mouse-polling-rate-test', 'mouse-tester', 'mouse-latency-test', 'online-ruler' ),
	'updated'        => '2026-11-01',
);
