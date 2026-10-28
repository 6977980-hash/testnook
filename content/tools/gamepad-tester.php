<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Gamepad Tester',
	'seo_title'      => 'Gamepad Tester: Test Controller Buttons and Sticks Online',
	'description'    => 'Free online gamepad tester for PS5, PS4, Xbox, Switch Pro and PC controllers. Check every button, trigger and stick live, see raw values and test vibration.',
	'intro'          => 'Connect a controller and press any button. Every button, trigger and stick lights up on the diagram as you use it, with raw values below, so a dead button or a weak trigger shows up straight away.',
	'device'         => 'gamepad',
	'device_message' => 'This browser cannot read game controllers. Use an up-to-date Chrome, Edge, Firefox or Safari on a computer, or a phone with a Bluetooth controller connected.',
	'ads'            => 'standard',
	'styles'         => array( 'gamepad-tester' ),
	'scripts'        => array( 'gamepad-tester' ),
	'embed_height'   => 820,
	'tool'           => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn" id="gp-rumble" disabled>Test vibration</button>
		<button type="button" class="btn" id="gp-reset">Reset</button>
	</div>
	<label class="visually-hidden" for="gp-pad">Controller</label>
	<select id="gp-pad" class="gp-select" hidden></select>
</div>
<div class="tool-stage gp-stage">
	<div class="gp-pad" aria-hidden="true">
		<div class="gp-shoulders">
			<div class="gp-shoulder">
				<div class="gp-trig" data-gp-btn="6"><span id="gp-lt"></span><b class="gp-t">LT</b></div>
				<div class="gp-b" data-gp-btn="4"><span class="gp-t">LB</span></div>
			</div>
			<div class="gp-shoulder">
				<div class="gp-trig" data-gp-btn="7"><span id="gp-rt"></span><b class="gp-t">RT</b></div>
				<div class="gp-b" data-gp-btn="5"><span class="gp-t">RB</span></div>
			</div>
		</div>
		<div class="gp-body">
			<div class="gp-side">
				<div class="gp-dpad">
					<div class="gp-b" data-gp-btn="12"><span class="gp-t">Up</span></div>
					<div class="gp-b" data-gp-btn="14"><span class="gp-t">Left</span></div>
					<div class="gp-b" data-gp-btn="15"><span class="gp-t">Right</span></div>
					<div class="gp-b" data-gp-btn="13"><span class="gp-t">Down</span></div>
				</div>
				<div class="gp-stick" id="gp-ls" data-gp-btn="10"><div class="gp-dot"></div><span class="gp-xy">0.00, 0.00</span></div>
			</div>
			<div class="gp-mid">
				<div class="gp-row">
					<div class="gp-b" data-gp-btn="8"><span class="gp-t">View</span></div>
					<div class="gp-b" data-gp-btn="9"><span class="gp-t">Menu</span></div>
				</div>
				<div class="gp-row">
					<div class="gp-b" data-gp-btn="16"><span class="gp-t">Home</span></div>
					<div class="gp-b" data-gp-btn="17"><span class="gp-t">Extra</span></div>
				</div>
			</div>
			<div class="gp-side">
				<div class="gp-face">
					<div class="gp-b" data-gp-btn="3"><span class="gp-t">Y</span></div>
					<div class="gp-b" data-gp-btn="2"><span class="gp-t">X</span></div>
					<div class="gp-b" data-gp-btn="1"><span class="gp-t">B</span></div>
					<div class="gp-b" data-gp-btn="0"><span class="gp-t">A</span></div>
				</div>
				<div class="gp-stick" id="gp-rs" data-gp-btn="11"><div class="gp-dot"></div><span class="gp-xy">0.00, 0.00</span></div>
			</div>
		</div>
	</div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Controller</span><span class="stat-value gp-name" id="gp-name">None</span></div>
	<div class="stat"><span class="stat-label">Mapping</span><span class="stat-value" id="gp-map">-</span></div>
	<div class="stat"><span class="stat-label">Buttons / axes</span><span class="stat-value" id="gp-counts">-</span></div>
	<div class="stat"><span class="stat-label">Buttons tested</span><span class="stat-value" id="gp-tested">0</span></div>
</div>
<div class="gp-raw" id="gp-raw"></div>
<p class="tool-status" id="gp-status" aria-live="polite">No controller found yet. Connect it by USB or Bluetooth, then press any button on it.</p>',
	'howto'          => array(
		'Connect your controller with a USB cable or pair it by Bluetooth, then <strong>press any button</strong>. Browsers only reveal a controller after a button press.',
		'Press every button one by one: face buttons, D-pad, bumpers, the menu buttons and both sticks (click them in). Each one lights up while held and turns green once it has worked.',
		'Squeeze both triggers slowly. The bar should fill smoothly from 0 to 100%. A trigger that jumps or stops short is worn or dirty.',
		'Move both sticks in full circles. The dots should reach the edge in every direction and return to the centre. For a detailed drift check, use the <a href="/stick-drift-test/">stick drift test</a>.',
		'Press <strong>Test vibration</strong> to check the rumble motors, and read the raw list below the diagram for exact values.',
	),
	'howto_title'    => 'How to test your controller',
	'results'        => '<ul>
<li><strong>A button never turns green:</strong> it is not registering. Press it firmly a few times; sticky or dead buttons are usually dirt under the button or a worn contact.</li>
<li><strong>A button lights up without being pressed:</strong> a stuck or shorted button, or a damaged ribbon cable.</li>
<li><strong>Trigger stops below 100%:</strong> the trigger sensor is worn, or a game\'s trigger setting limits it. Many triggers top out at 95-99%, which is fine.</li>
<li><strong>Stick dot does not return to the centre:</strong> stick drift. Run the dedicated drift test for a measurement.</li>
<li><strong>Mapping says Non-standard:</strong> the browser does not know this controller\'s layout, so the diagram may show the wrong buttons. The raw list is always correct: use it to check each input.</li>
</ul>',
	'extra'          => array(
		array(
			'Which controllers work with this gamepad tester?',
			'<p>Any controller your browser can read: PS5 DualSense and DualSense Edge, PS4 DualShock 4, Xbox One, Series X|S and Elite controllers, Xbox 360 pads, the Switch Pro Controller, 8BitDo and most generic USB or Bluetooth gamepads. The diagram uses the browser\'s standard layout and switches the labels to PlayStation or Nintendo symbols when it recognises the controller. There are dedicated pages with model-specific tips for the <a href="/ps5-controller-test/">PS5 controller</a>, <a href="/xbox-controller-test/">Xbox controller</a> and <a href="/ps4-controller-test/">PS4 controller</a>.</p>
<p>Chrome and Edge give the best support, including vibration. Firefox and Safari show buttons and sticks but may not support vibration from a web page.</p>',
			'controllers',
		),
		array(
			'Test your controller before a game or a sale',
			'<p>This controller test takes a minute and catches the most common faults: dead buttons, sticky triggers, drift and broken rumble motors. It is worth running when you buy a used controller, before you send one in for warranty, or when a game stops responding to an input. If your keyboard or mouse is acting up instead, check them with the <a href="/keyboard-tester/">keyboard tester</a> and the <a href="/mouse-tester/">mouse tester</a>.</p>',
			'before-buying',
		),
	),
	'fixes'          => array(
		array( 'Controller not detected', 'Press a button after connecting. Use a USB cable that carries data (some charge-only cables do not), try another port, and close Steam or DS4Windows, which can take exclusive control. For Bluetooth, remove the controller from the system list and pair it again.' ),
		array( 'Buttons are mixed up', 'The browser reports a non-standard mapping for this controller. On Windows, Xbox controllers and DualSense pads in Chrome or Edge usually map correctly; for other pads, Steam Input or the maker\'s app can present it as a standard controller.' ),
		array( 'A button or trigger is sticky or unresponsive', 'Turn the controller off and clean around the button with a cotton swab and a little isopropyl alcohol, pressing it repeatedly. If it still fails, the membrane or switch underneath is worn and needs repair.' ),
		array( 'Vibration test does nothing', 'Vibration from web pages works best in Chrome and Edge. Check that vibration is not turned off in the controller or system settings, and that the battery is charged: low battery can disable rumble.' ),
	),
	'faq'            => array(
		array( 'How do I test my controller on PC?', 'Connect it, open this page, press any button and then press every button and move the sticks. Each input lights up when it works.' ),
		array( 'Why is my controller not showing up?', 'Browsers only show a controller after you press a button on it. If it still does not appear, try another cable or port, or pair it again.' ),
		array( 'Can I test a PS5 controller here?', 'Yes. Connect the DualSense by USB-C or Bluetooth. The labels switch to PlayStation symbols, and the touchpad click is shown as an extra button.' ),
		array( 'Does the gamepad tester work on a phone?', 'Yes, if a Bluetooth controller is paired with the phone. Use Chrome on Android or Safari on iPhone and iPad.' ),
		array( 'What does Non-standard mapping mean?', 'The browser does not know where each button sits on your controller. All inputs still show in the raw list, but the diagram may not match.' ),
		array( 'Can I test two controllers at once?', 'Yes. Connect both and pick one from the controller list. Switch between them to test each one.' ),
	),
	'related'        => array( 'stick-drift-test', 'ps5-controller-test', 'xbox-controller-test', 'ps4-controller-test', 'keyboard-tester', 'mouse-tester', 'fps-test' ),
	'updated'        => '2026-10-28',
);
