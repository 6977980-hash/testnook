/* Mouse latency test: a drawn dot that follows the pointer (the gap to the system cursor is render lag), polling interval from coalesced events, browser event delay, event-to-frame time and a click-to-frame pad. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="mouse-latency-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#ml-stage'), canvas = $('#ml-canvas'), g = canvas.getContext('2d'), pad = $('#ml-pad'), statusEl = $('#ml-status'), trailBox = $('#ml-trail');
	var out = { poll: $('#ml-poll'), delay: $('#ml-delay'), frame: $('#ml-frame'), e2f: $('#ml-e2f'), est: $('#ml-est'), click: $('#ml-click'), clicks: $('#ml-clicks') };

	var pos = null, trail = [], pending = [], delays = [], e2f = [], gaps = [], frames = [], clicks = [], lastReport = 0, lastFrame = 0, clickWait = null, moved = 0;
	var dpr = Math.min(2, window.devicePixelRatio || 1);

	function push(arr, v, max) { arr.push(v); if (arr.length > max) { arr.shift(); } }
	function median(a) {
		if (!a.length) { return NaN; }
		var s = a.slice().sort(function (x, y) { return x - y; }), m = s.length >> 1;
		return s.length % 2 ? s[m] : (s[m - 1] + s[m]) / 2;
	}
	function ms(v, d) { return isFinite(v) ? v.toFixed(d === undefined ? 1 : d) + ' ms' : '-'; }

	stage.addEventListener('pointermove', function (e) {
		var now = performance.now(), rect = canvas.getBoundingClientRect();
		var list = e.getCoalescedEvents ? e.getCoalescedEvents() : [];
		if (!list.length) { list = [e]; }
		list.forEach(function (c) {
			if (lastReport && c.timeStamp > lastReport) {
				var gap = c.timeStamp - lastReport;
				if (gap < 40) { push(gaps, gap, 400); }
			}
			lastReport = c.timeStamp;
			if (trailBox.checked) { push(trail, [c.clientX - rect.left, c.clientY - rect.top], 80); }
		});
		push(delays, now - e.timeStamp, 300);
		pending.push(e.timeStamp);
		pos = [e.clientX - rect.left, e.clientY - rect.top];
		moved++;
	});
	stage.addEventListener('pointerleave', function () { pos = null; trail = []; lastReport = 0; });

	pad.addEventListener('pointerdown', function (e) {
		e.preventDefault();
		pad.classList.toggle('is-alt');
		clickWait = e.timeStamp;
	});

	function draw() {
		var w = Math.round(canvas.clientWidth * dpr), h = Math.round(canvas.clientHeight * dpr);
		if (canvas.width !== w || canvas.height !== h) { canvas.width = w; canvas.height = h; }
		g.clearRect(0, 0, w, h);
		var css = getComputedStyle(root);
		if (trail.length > 1) {
			g.strokeStyle = css.getPropertyValue('--muted').trim();
			g.lineWidth = 1.5 * dpr;
			g.beginPath();
			trail.forEach(function (p, i) { if (i) { g.lineTo(p[0] * dpr, p[1] * dpr); } else { g.moveTo(p[0] * dpr, p[1] * dpr); } });
			g.stroke();
		}
		if (pos) {
			g.fillStyle = css.getPropertyValue('--bad').trim();
			g.beginPath(); g.arc(pos[0] * dpr, pos[1] * dpr, 7 * dpr, 0, Math.PI * 2); g.fill();
		}
	}

	function loop(ts) {
		requestAnimationFrame(loop);
		if (lastFrame) { push(frames, ts - lastFrame, 120); }
		lastFrame = ts;
		// Event to frame: how long each pointer event waited for the frame that draws it.
		pending.forEach(function (t) { if (ts >= t) { push(e2f, ts - t, 300); } });
		pending = [];
		if (clickWait !== null) {
			if (ts >= clickWait) {
				push(clicks, ts - clickWait + median(frames), 50);
				out.click.textContent = ms(median(clicks));
				out.clicks.textContent = clicks.length;
			}
			clickWait = null;
		}
		draw();
	}

	setInterval(function () {
		var ft = median(frames), poll = median(gaps), dl = median(delays), ef = median(e2f);
		out.frame.textContent = isFinite(ft) ? ft.toFixed(1) + ' ms (' + Math.round(1000 / ft) + ' Hz)' : '-';
		out.poll.textContent = gaps.length > 20 ? Math.round(1000 / poll) + ' Hz (' + poll.toFixed(2) + ' ms)' : '-';
		out.delay.textContent = delays.length > 20 ? ms(dl, 2) : '-';
		out.e2f.textContent = e2f.length > 20 ? ms(ef) : '-';
		if (e2f.length > 20 && isFinite(ft)) {
			// Half a polling interval before the event exists, the wait for the frame, then about one frame to reach the screen.
			var est = (gaps.length > 20 ? poll / 2 : 0) + ef + ft;
			out.est.textContent = '~' + Math.round(est) + ' ms';
			U.status(statusEl, 'Browser-side latency is about ' + Math.round(est) + ' ms. The red dot trails the cursor by that much when you move fast. The monitor adds its own processing and response time on top.', 'ok');
		} else if (!moved) {
			U.status(statusEl, 'Move the mouse around inside the box for a few seconds.', '');
		}
	}, 500);

	$('#ml-reset').addEventListener('click', function () {
		delays = []; e2f = []; gaps = []; clicks = []; trail = []; moved = 0;
		['poll', 'delay', 'e2f', 'est', 'click'].forEach(function (k) { out[k].textContent = '-'; });
		out.clicks.textContent = '0';
		U.status(statusEl, 'Reset. Move the mouse around inside the box.', '');
	});
	requestAnimationFrame(loop);
}());
