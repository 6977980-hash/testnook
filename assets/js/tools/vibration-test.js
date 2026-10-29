/* Vibration test: plays vibration patterns through navigator.vibrate, draws the pattern as a timeline and shakes a phone icon while it runs.
   Lower "strength" levels are simulated with fast on/off pulses, since the API has no intensity. iPhones have no Vibration API; on iOS 18+
   tapping a switch control gives a system haptic tick, which the iPhone button triggers. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="vibration-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var phone = $('#vb-phone'), line = $('#vb-line'), statusEl = $('#vb-status'), support = $('#vb-support'), lastLen = $('#vb-lastlen');
	var len = $('#vb-len'), lenOut = $('#vb-lenout'), ask = $('#vb-ask'), iosBtn = $('#vb-ios');
	var can = 'vibrate' in navigator, isIOS = /iPhone|iPad|iPod/.test(navigator.userAgent) || (/Macintosh/.test(navigator.userAgent) && navigator.maxTouchPoints > 1);
	var endTimer = 0, last = '';

	function repeat(p, n) { var out = []; for (var i = 0; i < n; i++) { out = out.concat(p); } return out; }
	function pwm(on, off, total) { return repeat([on, off], Math.round(total / (on + off))); }
	var dot = 150, dash = 450;
	var PATTERNS = {
		short: { p: [120], label: 'Short buzz (0.12 s)' },
		long: { p: [1000], label: 'Long buzz (1 s)' },
		double: { p: [120, 120, 120], label: 'Double tap' },
		pulse: { p: repeat([250, 250], 5), label: 'Pulse, five times' },
		heartbeat: { p: repeat([90, 110, 150, 650], 4), label: 'Heartbeat' },
		sos: { p: [dot, dot, dot, dot, dot, dash, dash, dot, dash, dot, dash, dash, dot, dot, dot, dot, dot], label: 'SOS in Morse code' },
		weak: { p: pwm(12, 38, 1200), label: 'Weak (simulated with short pulses)' },
		medium: { p: pwm(30, 20, 1200), label: 'Medium (simulated with pulses)' },
		strong: { p: [1200], label: 'Strong (continuous)' },
		ramp: { p: pwm(10, 40, 800).concat([0], pwm(25, 25, 800), [0], pwm(45, 5, 800)), label: 'Ramp from weak to strong' },
		hold: { p: [10000], label: 'Continuous for 10 seconds' }
	};

	function total(p) { return p.reduce(function (a, b) { return a + b; }, 0); }

	function draw(p) {
		line.innerHTML = '';
		var t = total(p) || 1;
		p.forEach(function (ms, i) {
			if (!ms) { return; }
			var s = document.createElement('span');
			s.className = i % 2 ? 'off' : 'on';
			s.style.width = (ms / t * 100) + '%';
			line.appendChild(s);
		});
		line.style.setProperty('--dur', t + 'ms');
		line.classList.remove('is-play');
		void line.offsetWidth;
		line.classList.add('is-play');
	}

	function shake(ms) {
		clearTimeout(endTimer);
		phone.classList.add('is-buzz');
		endTimer = setTimeout(stopVisual, ms);
	}
	function stopVisual() {
		phone.classList.remove('is-buzz');
		line.classList.remove('is-play');
		U.$$('[data-vb]', root).forEach(function (b) { b.setAttribute('aria-pressed', 'false'); });
	}

	function play(name, pattern, label, btn) {
		if (!can) {
			U.status(statusEl, isIOS ? 'iPhone and iPad browsers do not support the Vibration API, so patterns cannot play. Use the haptic tick button below instead, or check the motor in Settings > Sounds & Haptics.' : 'This browser does not support vibration. Try Chrome on an Android phone.', 'bad');
			return;
		}
		navigator.vibrate(0);
		var ok = navigator.vibrate(pattern);
		last = name;
		lastLen.textContent = U.fmt(total(pattern) / 1000, 1) + ' s';
		draw(pattern);
		U.$$('[data-vb]', root).forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
		shake(total(pattern));
		if (ok === false) {
			U.status(statusEl, 'The browser refused to vibrate. Tap the button again directly (vibration needs a tap on the page), and check that the phone is not in silent or battery saver mode.', 'bad');
			return;
		}
		ask.hidden = false;
		U.status(statusEl, 'Playing: ' + label + '. Did you feel it?', '');
	}

	U.$$('[data-vb]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			var k = b.getAttribute('data-vb'), d = PATTERNS[k];
			play(k, d.p, d.label, b);
		});
	});
	$('#vb-custom').addEventListener('click', function () {
		var ms = Number(len.value);
		play('custom', [ms], 'Custom buzz, ' + ms + ' ms', null);
	});
	len.addEventListener('input', function () { lenOut.textContent = len.value + ' ms'; });
	$('#vb-stop').addEventListener('click', function () {
		if (can) { navigator.vibrate(0); }
		clearTimeout(endTimer);
		stopVisual();
		U.status(statusEl, 'Stopped.', '');
	});

	$('#vb-yes').addEventListener('click', function () {
		ask.hidden = true;
		U.status(statusEl, last === 'weak' || last === 'medium' || last === 'ramp'
			? 'Good: the motor responds to short pulses too, so it is working normally.'
			: 'Your vibration motor works. Try the weak and ramp patterns: a healthy motor is felt even with short pulses.', 'ok');
	});
	$('#vb-no').addEventListener('click', function () {
		ask.hidden = true;
		U.status(statusEl, last === 'weak' || last === 'medium'
			? 'Weak pulses are hard to feel on some phones. Try Long or Strong; if those work, the motor is fine.'
			: 'Nothing felt: check that vibration is on in the phone settings (Sound and vibration > Vibration intensity on Android), that Do Not Disturb and battery saver are off, and try again. If system vibrations also do nothing, the motor or its connector is likely faulty.', 'bad');
	});

	// iOS 18+: a click on a native switch control gives a haptic tick.
	if (iosBtn) {
		var sw = document.createElement('label'), input = document.createElement('input');
		input.type = 'checkbox';
		input.setAttribute('switch', '');
		sw.appendChild(input);
		sw.className = 'vb-switch';
		sw.setAttribute('aria-hidden', 'true');
		root.appendChild(sw);
		iosBtn.hidden = !(isIOS && !can);
		iosBtn.addEventListener('click', function () {
			sw.click();
			phone.classList.add('is-buzz');
			setTimeout(function () { phone.classList.remove('is-buzz'); }, 150);
			U.status(statusEl, 'Haptic tick sent. On iOS 18 or later you should feel a light tap. If not, check Settings > Sounds & Haptics > System Haptics.', '');
		});
	}

	if (can) {
		support.textContent = 'Supported';
		support.className = 'stat-value is-ok';
		U.status(statusEl, 'Tap a pattern. The phone should buzz and the icon shakes while it plays.', '');
	} else {
		support.textContent = isIOS ? 'Not on iPhone' : 'Not supported';
		support.className = 'stat-value is-bad';
		U.status(statusEl, isIOS
			? 'iPhone browsers do not support vibration patterns. Use the haptic tick button, which works in Safari on iOS 18 or later.'
			: (U.isTouch() ? 'This browser does not support vibration. Open the page in Chrome on Android.' : 'Computers have no vibration motor. Open this page on your phone.'), 'bad');
	}
	window.addEventListener('pagehide', function () { if (can) { navigator.vibrate(0); } });
}());
