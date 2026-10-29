/* Battery health test: Battery Status API readout, a timed drain test (% per hour and estimated runtime) and a design vs full charge capacity calculator. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="battery-health-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#bt-status'), fillEl = $('#bt-fill'), pctEl = $('#bt-pct'), stateEl = $('#bt-state');
	var out = { full: $('#bt-tofull'), empty: $('#bt-toempty'), rate: $('#bt-rate'), runtime: $('#bt-runtime'), elapsed: $('#bt-elapsed'), used: $('#bt-used') };
	var startBtn = $('#bt-start'), stopBtn = $('#bt-stop'), log = $('#bt-log');
	var bat = null, test = null, timer = 0, lock = null;

	function dur(sec) {
		if (!isFinite(sec) || sec <= 0) { return '-'; }
		var h = Math.floor(sec / 3600), m = Math.round((sec % 3600) / 60);
		if (m === 60) { h++; m = 0; }
		return h ? h + ' h ' + m + ' min' : m + ' min';
	}

	function paint() {
		var pct = Math.round(bat.level * 100);
		pctEl.textContent = pct + '%';
		fillEl.style.width = pct + '%';
		fillEl.className = 'bt-fill' + (pct <= 20 ? ' is-low' : pct <= 50 ? ' is-mid' : '');
		root.classList.toggle('is-charging', bat.charging);
		stateEl.textContent = bat.charging ? (pct >= 100 ? 'Plugged in, fully charged' : 'Charging') : 'On battery';
		out.full.textContent = bat.charging ? dur(bat.chargingTime) : '-';
		out.empty.textContent = bat.charging ? '-' : dur(bat.dischargingTime);
		if (test) { sample(); }
	}

	// Least-squares slope of level (%) over time (hours) from the samples taken at each level change.
	function slope(pts) {
		var n = pts.length, sx = 0, sy = 0, sxx = 0, sxy = 0;
		pts.forEach(function (p) { sx += p[0]; sy += p[1]; sxx += p[0] * p[0]; sxy += p[0] * p[1]; });
		var d = n * sxx - sx * sx;
		return d ? (n * sxy - sx * sy) / d : 0;
	}

	function sample() {
		var h = (performance.now() - test.t0) / 3600000, lvl = bat.level * 100;
		var last = test.pts[test.pts.length - 1];
		if (!last || last[1] !== lvl) {
			test.pts.push([h, lvl]);
			var li = document.createElement('li');
			li.textContent = (h * 60 >= 0.5 ? dur(h * 3600) : '0 min') + ': ' + Math.round(lvl) + '%';
			log.appendChild(li);
		}
		if (bat.charging) {
			U.status(statusEl, 'The device is charging, so the drain test is paused. Unplug the charger to continue.', 'bad');
		}
	}

	function tick() {
		var sec = (performance.now() - test.t0) / 1000, used = test.start - bat.level * 100;
		out.elapsed.textContent = sec >= 30 ? dur(sec) : '0 min';
		out.used.textContent = Math.max(0, Math.round(used)) + '%';
		if (test.pts.length >= 3 && used >= 2) {
			var rate = -slope(test.pts);
			if (rate > 0) {
				out.rate.textContent = rate.toFixed(1) + '% / h';
				out.runtime.textContent = dur(100 / rate * 3600);
				U.status(statusEl, 'At this rate a full charge lasts about ' + dur(100 / rate * 3600) + ' with the screen on. Keep going for a steadier estimate.', 'ok');
			}
		} else if (!bat.charging) {
			U.status(statusEl, 'Measuring... the estimate appears after the battery has dropped 2%. Leave this tab open and the screen on.', '');
		}
	}

	function start() {
		if (bat.charging) { U.status(statusEl, 'Unplug the charger first: the drain test measures how fast the battery empties.', 'bad'); return; }
		test = { t0: performance.now(), start: bat.level * 100, pts: [] };
		log.innerHTML = '';
		out.rate.textContent = out.runtime.textContent = '-';
		sample();
		tick();
		timer = setInterval(tick, 5000);
		startBtn.disabled = true;
		stopBtn.disabled = false;
		if (navigator.wakeLock) { navigator.wakeLock.request('screen').then(function (l) { lock = l; }).catch(function () {}); }
	}

	function stop() {
		clearInterval(timer);
		test = null;
		startBtn.disabled = false;
		stopBtn.disabled = true;
		if (lock) { lock.release().catch(function () {}); lock = null; }
	}

	// Capacity calculator (works without the Battery API).
	var design = $('#bt-design'), fullCap = $('#bt-fullcap'), healthOut = $('#bt-health');
	function calc() {
		var d = parseFloat(design.value), f = parseFloat(fullCap.value);
		if (!(d > 0 && f > 0)) { healthOut.textContent = 'Enter both values'; healthOut.className = ''; return; }
		var h = f / d * 100, verdict = h >= 90 ? 'excellent' : h >= 80 ? 'good' : h >= 70 ? 'worn: expect noticeably shorter runtime' : 'poor: consider a replacement';
		healthOut.textContent = h.toFixed(1) + '% health, ' + verdict + '. The battery has lost ' + Math.max(0, 100 - h).toFixed(1) + '% of its original capacity.';
		healthOut.className = h >= 80 ? 'bt-good' : 'bt-bad';
	}
	[design, fullCap].forEach(function (el) { el.addEventListener('input', calc); });

	startBtn.addEventListener('click', start);
	stopBtn.addEventListener('click', stop);

	if (!navigator.getBattery) {
		root.classList.add('no-api');
		startBtn.disabled = true;
		stateEl.textContent = 'Not available';
		U.status(statusEl, 'This browser does not share battery information (Safari, iPhone and Firefox hide it). Use Chrome or Edge on a laptop or Android phone, or check battery health in your system settings as shown below.', 'bad');
		return;
	}
	navigator.getBattery().then(function (b) {
		bat = b;
		['levelchange', 'chargingchange', 'chargingtimechange', 'dischargingtimechange'].forEach(function (ev) { b.addEventListener(ev, paint); });
		paint();
		if (b.level === 1 && b.charging && b.chargingTime === 0 && b.dischargingTime === Infinity) {
			U.status(statusEl, 'Reported as 100% and plugged in. If this is a desktop PC without a battery, browsers report it this way.', '');
		} else {
			U.status(statusEl, 'Battery found. Unplug the charger and press Start drain test to measure how fast it empties.', 'ok');
		}
	}).catch(function () {
		U.status(statusEl, 'The browser blocked battery information on this page.', 'bad');
	});

	// For automated checks: feed a fake battery object.
	root.btUse = function (fake) { bat = fake; paint(); };
}());
