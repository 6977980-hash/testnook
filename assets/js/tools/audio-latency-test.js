/* Audio latency test (tap-sync): Web Audio schedules clicks 800 ms apart on the audio clock; after a 4-beat count-in the user taps with the sound only. Each tap is matched to the nearest beat (window -250..+550 ms) and the offset from the scheduled click is averaged after outlier removal. Runs can be labeled (wired / Bluetooth / speakers) and compared. Nothing is recorded or sent. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="audio-latency-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#al-stage'), ring = $('#al-ring'), big = $('#al-big'), small = $('#al-small'), startBtn = $('#al-start');
	var avgEl = $('#al-avg'), sdEl = $('#al-sd'), nEl = $('#al-n'), osEl = $('#al-os'), statusEl = $('#al-status');
	var vol = $('#al-volume'), volOut = $('#al-volout'), runsBody = $('#al-runs'), runsBox = $('#al-runs-box');
	var INTERVAL = 800, COUNTIN = 4, EARLY = 250;
	var beats = 16, label = 'Wired', ctx = null, master = null, running = false;
	var beat0 = 0, taps = {}, timers = [], runs = [];

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio, so this test cannot run here.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC({ latencyHint: 'interactive' });
			master = ctx.createGain();
			master.connect(ctx.destination);
			setVol();
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	function setVol() {
		if (master) { master.gain.value = Math.pow(vol.value / 100, 2); }
		volOut.textContent = vol.value + '%';
	}

	function click(time, accent) {
		var osc = ctx.createOscillator(), g = ctx.createGain();
		osc.type = 'square';
		osc.frequency.value = accent ? 1600 : 1000;
		g.gain.setValueAtTime(0.0001, time);
		g.gain.exponentialRampToValueAtTime(accent ? 1 : 0.7, time + 0.002);
		g.gain.exponentialRampToValueAtTime(0.0001, time + 0.03);
		osc.connect(g).connect(master);
		osc.start(time);
		osc.stop(time + 0.05);
	}

	function pulse(cls) {
		ring.classList.remove(cls);
		void ring.offsetWidth;
		ring.classList.add(cls);
	}

	function later(fn, at) { timers.push(setTimeout(fn, Math.max(0, at - performance.now()))); }

	function sign(v) { var r = Math.round(v); return (r > 0 ? '+' : (r < 0 ? '\u2212' : '')) + Math.abs(r) + ' ms'; }

	function start() {
		if (running || !ensure()) { return; }
		running = true;
		taps = {};
		timers.forEach(clearTimeout);
		timers = [];
		var total = COUNTIN + beats;
		// Map the audio clock to performance.now() in the same tick: these are the times the browser hands each click to the audio output.
		var lead = 0.4, t0 = ctx.currentTime + lead;
		beat0 = performance.now() + lead * 1000;
		for (var k = 0; k < total; k++) { click(t0 + k * INTERVAL / 1000, k < COUNTIN); }
		root.setAttribute('data-al-state', 'running');
		root.setAttribute('data-al-beat0', String(beat0));
		root.setAttribute('data-al-interval', String(INTERVAL));
		root.setAttribute('data-al-countin', String(COUNTIN));
		root.setAttribute('data-al-count', String(beats));
		startBtn.disabled = true;
		stage.classList.add('is-live');
		big.textContent = 'Get ready';
		small.textContent = 'Four count-in clicks, then tap with the sound.';
		for (k = 0; k < COUNTIN; k++) {
			(function (n) { later(function () { pulse('is-hit'); big.textContent = String(COUNTIN - n); }, beat0 + n * INTERVAL); }(k));
		}
		later(function () {
			big.textContent = 'Tap now';
			small.textContent = 'Close your eyes and tap with each click you hear. Space or any key works too.';
		}, beat0 + COUNTIN * INTERVAL - EARLY);
		later(finish, beat0 + (total - 1) * INTERVAL + 700);
		U.status(statusEl, 'Running: ' + beats + ' clicks to tap after the count-in, about ' + Math.round(total * INTERVAL / 1000) + ' seconds.', '');
	}

	function tap(t) {
		if (!running) { return; }
		var k = Math.floor((t - beat0 + EARLY) / INTERVAL);
		if (k < COUNTIN || k >= COUNTIN + beats || taps[k] !== undefined) { return; }
		taps[k] = t - (beat0 + k * INTERVAL);
		big.textContent = Object.keys(taps).length + ' / ' + beats;
		pulse('is-tap');
	}

	function stats(list) {
		var s = list.slice().sort(function (a, b) { return a - b; });
		var med = s[s.length >> 1];
		var mad = s.map(function (v) { return Math.abs(v - med); }).sort(function (a, b) { return a - b; })[s.length >> 1];
		var lim = Math.max(40, mad * 3);
		var keep = s.filter(function (v) { return Math.abs(v - med) <= lim; });
		var mean = keep.reduce(function (a, b) { return a + b; }, 0) / keep.length;
		var sd = Math.sqrt(keep.reduce(function (a, b) { return a + (b - mean) * (b - mean); }, 0) / keep.length);
		return { mean: mean, sd: sd, n: keep.length, dropped: s.length - keep.length };
	}

	function last(name) {
		for (var i = runs.length - 1; i >= 0; i--) { if (runs[i].label === name) { return runs[i]; } }
		return null;
	}

	function renderRuns() {
		runsBody.innerHTML = '';
		runs.forEach(function (r, i) {
			var tr = document.createElement('tr');
			[String(i + 1), r.label, sign(r.mean), '±' + Math.round(r.sd) + ' ms'].forEach(function (v) {
				var td = document.createElement('td');
				td.textContent = v;
				tr.appendChild(td);
			});
			runsBody.appendChild(tr);
		});
		runsBox.hidden = runs.length === 0;
	}

	function finish() {
		running = false;
		startBtn.disabled = false;
		stage.classList.remove('is-live');
		root.setAttribute('data-al-state', 'done');
		var list = Object.keys(taps).map(function (k) { return taps[k]; });
		if (list.length < Math.min(6, beats)) {
			big.textContent = 'Too few taps';
			small.textContent = 'Press Start and tap along with at least 6 clicks.';
			U.status(statusEl, 'Only ' + list.length + ' taps landed near a click. Press Start and tap with every click you hear.', 'bad');
			return;
		}
		var r = stats(list);
		root.setAttribute('data-al-result', U.fmt(r.mean, 1));
		avgEl.textContent = sign(r.mean);
		sdEl.textContent = '±' + Math.round(r.sd) + ' ms';
		nEl.textContent = r.n + (r.dropped ? ' (' + r.dropped + ' ignored)' : '');
		big.textContent = sign(r.mean);
		small.textContent = 'Average tap offset (' + label + '). Press Start to run again.';
		runs.push({ label: label, mean: r.mean, sd: r.sd });
		renderRuns();
		var msg = 'Your taps landed ' + Math.abs(Math.round(r.mean)) + ' ms ' + (r.mean >= 0 ? 'after' : 'before') + ' the clicks left the browser (spread ±' + Math.round(r.sd) + ' ms). ';
		var wired = last('Wired'), bt = last('Bluetooth');
		if (wired && bt) {
			msg += 'Bluetooth vs wired: about ' + Math.round(bt.mean - wired.mean) + ' ms extra delay.';
		} else {
			msg += 'Run it again on the other connection (wired or Bluetooth): the difference between the two runs is the extra delay, because your own timing cancels out.';
		}
		if (r.sd > 60) { msg += ' Your taps were spread widely; run again for a steadier number.'; }
		U.status(statusEl, msg, 'ok');
	}

	function showOutputLatency() {
		if (!ctx) { return; }
		var o = (ctx.outputLatency || 0) + (ctx.baseLatency || 0);
		osEl.textContent = o > 0 ? Math.round(o * 1000) + ' ms' : 'Not reported';
	}

	stage.addEventListener('pointerdown', function (e) {
		if (!running) { return; }
		e.preventDefault();
		tap(e.timeStamp);
	});
	root.addEventListener('keydown', function (e) {
		if (!running || e.repeat || e.ctrlKey || e.metaKey || e.altKey) { return; }
		if (e.target.closest && e.target.closest('input, select')) { return; }
		e.preventDefault();
		tap(e.timeStamp);
	});
	startBtn.addEventListener('click', function () { start(); setTimeout(showOutputLatency, 1000); stage.focus(); });
	vol.addEventListener('input', setVol);
	U.$$('[data-al-beats]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			if (running) { return; }
			beats = Number(b.getAttribute('data-al-beats'));
			U.$$('[data-al-beats]', root).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
		});
	});
	U.$$('[data-al-label]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			label = b.getAttribute('data-al-label');
			U.$$('[data-al-label]', root).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
		});
	});
	setVol();
}());
