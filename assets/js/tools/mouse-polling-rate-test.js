/* Mouse polling rate test: counts mouse movement reports per second while the mouse moves, using coalesced events so the browser's frame rate does not cap the count. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="mouse-polling-rate-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#pr-stage'), startBtn = $('#pr-start'), resetBtn = $('#pr-reset'), statusEl = $('#pr-status'), hint = $('#pr-hint');
	var out = { live: $('#pr-live'), avg: $('#pr-avg'), max: $('#pr-max'), nominal: $('#pr-nominal'), interval: $('#pr-interval'), samples: $('#pr-samples') };
	var canvas = $('#pr-graph'), cx = canvas.getContext('2d');
	var RATES = [125, 250, 500, 1000, 2000, 4000, 8000];
	var MIN_PER_SEC = 20; // seconds with fewer reports than this mean the mouse was not moving: ignored

	var running = false, times = [], seconds = [], secTimer = 0, count = 0, lastT = 0, gaps = [], total = 0, bestSec = 0, useCoalesced = false;

	function nearest(hz) {
		var best = RATES[0];
		RATES.forEach(function (r) { if (Math.abs(Math.log(hz / r)) < Math.abs(Math.log(hz / best))) { best = r; } });
		return best;
	}

	function median(a) {
		if (!a.length) { return 0; }
		var s = a.slice().sort(function (x, y) { return x - y; });
		var m = s.length >> 1;
		return s.length % 2 ? s[m] : (s[m - 1] + s[m]) / 2;
	}

	function fmtHz(hz) { return hz >= 1000 ? (hz / 1000).toFixed(hz % 1000 ? 2 : 0) + ' kHz' : Math.round(hz) + ' Hz'; }

	function onMove(e) {
		if (!running) { return; }
		var list = (useCoalesced && e.getCoalescedEvents) ? e.getCoalescedEvents() : null;
		var n = list && list.length ? list.length : 1;
		var now = performance.now();
		if (list && list.length > 1) {
			// Each coalesced event carries its own timestamp; use those for the interval.
			for (var i = 0; i < list.length; i++) {
				var t = list[i].timeStamp;
				if (lastT && t > lastT && t - lastT < 50) { gaps.push(t - lastT); }
				lastT = t;
			}
		} else {
			var ts = e.timeStamp || now;
			if (lastT && ts > lastT && ts - lastT < 50) { gaps.push(ts - lastT); }
			lastT = ts;
		}
		count += n;
		total += n;
		if (gaps.length > 4000) { gaps.splice(0, gaps.length - 4000); }
	}

	function tick() {
		var c = count;
		count = 0;
		if (c >= MIN_PER_SEC) {
			seconds.push(c);
			if (seconds.length > 10) { seconds.shift(); }
			bestSec = Math.max(bestSec, c);
			var med = median(seconds);
			// The interval between reports (median of gaps) is more exact than a 1 s count when the mouse pauses.
			var gap = median(gaps.slice(-1500));
			var hz = gap ? 1000 / gap : med;
			out.live.textContent = c;
			out.avg.textContent = fmtHz(Math.max(med, 0));
			out.max.textContent = bestSec;
			out.nominal.textContent = fmtHz(nearest(hz));
			out.interval.textContent = gap ? gap.toFixed(2) + ' ms' : '-';
			out.samples.textContent = total;
			U.status(statusEl, 'Measuring: about ' + fmtHz(hz) + ' (nearest standard rate ' + fmtHz(nearest(hz)) + '). Keep the mouse moving in fast circles.', 'ok');
			hint.hidden = true;
		} else if (running) {
			hint.hidden = false;
			out.live.textContent = c;
			U.status(statusEl, 'Move the mouse in fast circles inside the box to get a reading.', '');
		}
		draw();
	}

	function draw() {
		var w = canvas.width, h = canvas.height;
		cx.clearRect(0, 0, w, h);
		var styles = getComputedStyle(root);
		var brand = styles.getPropertyValue('--brand').trim() || '#0f766e', line = styles.getPropertyValue('--border').trim() || '#ccc', muted = styles.getPropertyValue('--muted').trim() || '#888';
		var maxV = Math.max(1100, bestSec * 1.1);
		cx.strokeStyle = line;
		cx.fillStyle = muted;
		cx.font = '11px sans-serif';
		cx.textAlign = 'left';
		RATES.forEach(function (r) {
			if (r > maxV) { return; }
			var y = h - (r / maxV) * h;
			cx.beginPath(); cx.moveTo(0, y); cx.lineTo(w, y); cx.stroke();
			cx.fillText(r + ' Hz', 4, y - 3);
		});
		var bw = w / 10;
		cx.fillStyle = brand;
		seconds.forEach(function (v, i) {
			var bh = (v / maxV) * h;
			cx.fillRect(i * bw + 4, h - bh, bw - 8, bh);
		});
	}

	function start() {
		running = true;
		stage.classList.add('is-on');
		startBtn.textContent = 'Stop';
		startBtn.classList.add('is-on');
		clearInterval(secTimer);
		secTimer = setInterval(tick, 1000);
		U.status(statusEl, 'Move the mouse in fast circles inside the box.', '');
	}

	function stop() {
		running = false;
		stage.classList.remove('is-on');
		startBtn.textContent = 'Start';
		startBtn.classList.remove('is-on');
		clearInterval(secTimer);
		if (seconds.length) {
			var gap = median(gaps.slice(-1500)), hz = gap ? 1000 / gap : median(seconds);
			U.status(statusEl, 'Result: about ' + fmtHz(hz) + ', which matches a ' + fmtHz(nearest(hz)) + ' polling rate.', 'ok');
		} else {
			U.status(statusEl, 'Stopped before a reading was taken.', '');
		}
	}

	function reset() {
		seconds = []; gaps = []; count = 0; total = 0; bestSec = 0; lastT = 0;
		Object.keys(out).forEach(function (k) { out[k].textContent = '-'; });
		draw();
		hint.hidden = !running;
		U.status(statusEl, running ? 'Reset. Keep moving the mouse.' : 'Press Start, then move the mouse in fast circles inside the box.', '');
	}

	useCoalesced = 'getCoalescedEvents' in PointerEvent.prototype;
	$('#pr-mode').textContent = useCoalesced ? 'Coalesced events: on (every report counted)' : 'Coalesced events: off (count limited to the screen refresh rate)';
	stage.addEventListener('pointermove', function (e) { if (e.pointerType === 'mouse' || !e.pointerType) { onMove(e); } });
	stage.addEventListener('pointerdown', function () { if (!running) { start(); } });
	startBtn.addEventListener('click', function () { if (running) { stop(); } else { start(); } });
	resetBtn.addEventListener('click', reset);
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { stop(); } });
	if (U.isTouch() && !U.hasFinePointer()) {
		U.status(statusEl, 'This test needs a mouse. Touch screens do not have a polling rate the browser can read.', 'bad');
	}
	draw();
}());
