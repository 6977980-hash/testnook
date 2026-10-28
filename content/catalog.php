<?php
/**
 * Master list of hubs and planned tools.
 *
 * A tool is "live" only when content/tools/<slug>.php exists. Planned tools
 * without a content file show as "Coming soon" on the homepage and hubs,
 * and are never linked. The order of tools follows the launch plan.
 */

defined( 'ABSPATH' ) || exit;

return array(
	'hubs'  => array(
		'keyboard'   => array( 'name' => 'Keyboard', 'title' => 'Keyboard Tests', 'icon' => 'keyboard', 'blurb' => 'Check every key, rollover and spacebar speed.' ),
		'mouse'      => array( 'name' => 'Mouse', 'title' => 'Mouse Tests', 'icon' => 'mouse', 'blurb' => 'Buttons, double clicks, scroll wheel, DPI and polling rate.' ),
		'controller' => array( 'name' => 'Controller', 'title' => 'Controller & Gamepad Tests', 'icon' => 'controller', 'blurb' => 'Buttons, triggers and stick drift for PS5, Xbox and PC pads.' ),
		'screen'     => array( 'name' => 'Screen', 'title' => 'Screen & Monitor Tests', 'icon' => 'screen', 'blurb' => 'Dead pixels, refresh rate, FPS, burn-in and solid colour screens.' ),
		'audio'      => array( 'name' => 'Audio', 'title' => 'Audio, Speaker & Mic Tests', 'icon' => 'audio', 'blurb' => 'Speakers, headphones, microphones, tones and hearing range.' ),
		'camera'     => array( 'name' => 'Camera', 'title' => 'Webcam & Camera Tests', 'icon' => 'camera', 'blurb' => 'Webcam, phone camera and an online mirror.' ),
		'benchmark'  => array( 'name' => 'Benchmark', 'title' => 'Reaction & Speed Benchmarks', 'icon' => 'benchmark', 'blurb' => 'Reaction time, clicks per second and other skill tests.' ),
		'phone'      => array( 'name' => 'Phone', 'title' => 'Phone Tests', 'icon' => 'phone', 'blurb' => 'Touch screen, speaker, camera and display tests for phones.' ),
	),

	// slug => name, card blurb, primary hub, extra hubs it is listed in.
	'tools' => array(
		'speaker-cleaner'         => array( 'name' => 'Speaker Cleaner', 'blurb' => 'Play a low tone that pushes water and dust out of a phone speaker.', 'hub' => 'audio', 'also' => array( 'phone' ) ),
		'webcam-test'             => array( 'name' => 'Webcam Test', 'blurb' => 'See your webcam live with resolution and frame rate.', 'hub' => 'camera', 'also' => array() ),
		'mouse-tester'            => array( 'name' => 'Mouse Tester', 'blurb' => 'Check every mouse button, the wheel and side buttons.', 'hub' => 'mouse', 'also' => array() ),
		'dead-pixel-test'         => array( 'name' => 'Dead Pixel Test', 'blurb' => 'Cycle full-screen colours to spot dead or stuck pixels.', 'hub' => 'screen', 'also' => array( 'phone' ) ),
		'stuck-pixel-fixer'       => array( 'name' => 'Stuck Pixel Fixer', 'blurb' => 'Flash rapid colours over a stuck pixel to try to revive it.', 'hub' => 'screen', 'also' => array() ),
		'fps-test'                => array( 'name' => 'FPS Test', 'blurb' => 'Measure the frame rate your browser and screen can show.', 'hub' => 'screen', 'also' => array( 'benchmark' ) ),
		'sound-test'              => array( 'name' => 'Sound Test', 'blurb' => 'Check your speakers with test tones, music and channel checks.', 'hub' => 'audio', 'also' => array() ),
		'double-click-test'       => array( 'name' => 'Double Click Test', 'blurb' => 'Catch a mouse that double clicks when you click once.', 'hub' => 'mouse', 'also' => array() ),
		'refresh-rate-test'       => array( 'name' => 'Refresh Rate Test', 'blurb' => 'Find your monitor\'s real refresh rate in hertz.', 'hub' => 'screen', 'also' => array() ),
		'headphone-test'          => array( 'name' => 'Headphone Test', 'blurb' => 'Left and right channels, stereo and bass for headphones.', 'hub' => 'audio', 'also' => array( 'phone' ) ),
		'touch-screen-test'       => array( 'name' => 'Touch Screen Test', 'blurb' => 'Draw and multi-touch to find dead zones on a touch screen.', 'hub' => 'phone', 'also' => array( 'screen' ) ),
		'online-mirror'           => array( 'name' => 'Online Mirror', 'blurb' => 'Use your front camera as a mirror, right in the browser.', 'hub' => 'camera', 'also' => array( 'phone' ) ),
		'stick-drift-test'        => array( 'name' => 'Stick Drift Test', 'blurb' => 'Measure joystick drift and dead zone on any controller.', 'hub' => 'controller', 'also' => array() ),
		'gamepad-tester'          => array( 'name' => 'Gamepad Tester', 'blurb' => 'Test every button, trigger and stick on a connected controller.', 'hub' => 'controller', 'also' => array() ),
		'mic-test'                => array( 'name' => 'Mic Test', 'blurb' => 'Check your microphone level and record a playback sample.', 'hub' => 'audio', 'also' => array( 'camera' ) ),
		'keyboard-tester'         => array( 'name' => 'Keyboard Tester', 'blurb' => 'Press keys and see each one light up on a full keyboard.', 'hub' => 'keyboard', 'also' => array() ),
		'reaction-time-test'      => array( 'name' => 'Reaction Time Test', 'blurb' => 'Click as soon as the screen turns green and get your average.', 'hub' => 'benchmark', 'also' => array() ),
		'cps-test'                => array( 'name' => 'CPS Test', 'blurb' => 'Count your clicks per second over 1 to 100 seconds.', 'hub' => 'benchmark', 'also' => array( 'mouse' ) ),
		'spacebar-clicker'        => array( 'name' => 'Spacebar Clicker', 'blurb' => 'Count spacebar presses and test your spacebar speed.', 'hub' => 'keyboard', 'also' => array( 'benchmark' ) ),
		'white-screen'            => array( 'name' => 'White Screen', 'blurb' => 'A full white screen for light, cleaning and display checks.', 'hub' => 'screen', 'also' => array() ),
		'black-screen'            => array( 'name' => 'Black Screen', 'blurb' => 'A full black screen for backlight bleed and OLED checks.', 'hub' => 'screen', 'also' => array() ),
		'tone-generator'          => array( 'name' => 'Tone Generator', 'blurb' => 'Generate sine, square and other waves at any frequency.', 'hub' => 'audio', 'also' => array() ),
		'dpi-analyzer'            => array( 'name' => 'DPI Analyzer', 'blurb' => 'Measure your mouse\'s real DPI by moving a set distance.', 'hub' => 'mouse', 'also' => array() ),
		'online-ruler'            => array( 'name' => 'Online Ruler', 'blurb' => 'An actual-size ruler in cm and inches, calibrated to your screen.', 'hub' => 'screen', 'also' => array( 'phone' ) ),
		'ps5-controller-test'     => array( 'name' => 'PS5 Controller Test', 'blurb' => 'Test DualSense buttons, triggers and sticks for drift.', 'hub' => 'controller', 'also' => array() ),
		'xbox-controller-test'    => array( 'name' => 'Xbox Controller Test', 'blurb' => 'Test Xbox One and Series controller buttons and sticks.', 'hub' => 'controller', 'also' => array() ),
		'ps4-controller-test'     => array( 'name' => 'PS4 Controller Test', 'blurb' => 'Test DualShock 4 buttons, triggers and sticks.', 'hub' => 'controller', 'also' => array() ),
		'mouse-polling-rate-test' => array( 'name' => 'Mouse Polling Rate Test', 'blurb' => 'Measure your mouse\'s polling rate in Hz.', 'hub' => 'mouse', 'also' => array() ),
		'scroll-test'             => array( 'name' => 'Scroll Test', 'blurb' => 'Check your scroll wheel for skipping and wrong-way scrolls.', 'hub' => 'mouse', 'also' => array() ),
		'camera-test'             => array( 'name' => 'Camera Test', 'blurb' => 'Test front and back cameras on phones and laptops.', 'hub' => 'camera', 'also' => array( 'phone' ) ),
		'burn-in-test'            => array( 'name' => 'Burn-in Test', 'blurb' => 'Spot screen burn-in and image retention on OLED and LCD.', 'hub' => 'screen', 'also' => array( 'phone' ) ),
		'hearing-frequency-test'  => array( 'name' => 'Hearing Frequency Test', 'blurb' => 'Find the highest frequency you can hear with headphones.', 'hub' => 'audio', 'also' => array() ),
	),
);
