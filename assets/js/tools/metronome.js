/* Metronome: Web Audio look-ahead scheduler (25 ms timer, 120 ms horizon) with accents, subdivisions, tap tempo, tempo markings and visual beats. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="metronome"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var bpmIn = $('#mn-bpm'), slider = $('#mn-slider'), markEl = $('#mn-mark'), playBtn = $('#mn-play'), tapBtn = $('#mn-tap');
	var beatsEl = $('#mn-beats'), vol = $('#mn-volume'), volOut = $('#mn-volout'), statusEl = $('#mn-status'), stage = $('#mn-stage');
	var sigSel = U.$$('[data-mn-sig]', root), subSel = U.$$('[data-mn-sub]', root), soundSel = U.$$('[data-mn-sound]', root), stepBtns = U.$$('[data-mn-step]', root);

	var MIN = 20, MAX = 300, MARKS = [[40, 'Grave'], [60, 'Largo'], [66, 'Larghetto'], [76, 'Adagio'], [108, 'Andante'], [120, 'Moderato'], [156, 'Allegro'], [176, 'Vivace'], [200, 'Presto'], [301, 'Prestissimo']];
	var bpm = 120, beats = 4, noteVal = 4, sub = 1, sound = 'click', accent = true;
	var ctx = null, master = null, playing = false, timer = 0, nextTime = 0, beat = 0, tick = 0, queue = [], raf = 0;
	var taps = [], tapTimer = 0;

	function marking(b) {
		for (var i = 0; i < MARKS.length; i++) { if (b < MARKS[i][0]) { return MARKS[i][1]; } }
		return 'Prestissimo';
	}

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC();
			master = ctx.createGain();
			master.connect(ctx.destination);
			setVol();
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	function setVol() { if (master) { master.gain.value = Math.pow(vol.value / 100, 2); } volOut.textContent = vol.value + '%'; }

	/* One click: kind 0 = accent, 1 = beat, 2 = subdivision. */
	function click(time, kind) {
		var osc = ctx.createOscillator(), g = ctx.createGain(), f, len = 0.03;
		if (sound === 'wood') {
			osc.type = 'triangle';
			f = kind === 0 ? 1800 : (kind === 1 ? 1200 : 900);
			len = 0.025;
		} else if (sound === 'beep') {
			osc.type = 'sine';
			f = kind === 0 ? 1760 : (kind === 1 ? 880 : 660);
			len = 0.06;
		} else {
			osc.type = 'square';
			f = kind === 0 ? 1600 : (kind === 1 ? 1000 : 800);
		}
		osc.frequency.value = f;
		var peak = kind === 0 ? 1 : (kind === 1 ? 0.6 : 0.3);
		g.gain.setValueAtTime(0.0001, time);
		g.gain.exponentialRampToValueAtTime(peak, time + 0.002);
		g.gain.exponentialRampToValueAtTime(0.0001, time + len);
		osc.connect(g).connect(master);
		osc.start(time);
		osc.stop(time + len + 0.01);
	}

	function schedule() {
		var perBeat = 60 / bpm * (4 / noteVal), perTick = perBeat / sub;
		while (nextTime < ctx.currentTime + 0.12) {
			var isBeat = tick % sub === 0, b = Math.floor(tick / sub) % beats;
			var kind = isBeat ? (b === 0 && accent && beats > 1 ? 0 : 1) : 2;
			click(nextTime, kind);
			if (isBeat) { queue.push({ t: nextTime, b: b }); }
			nextTime += perTick;
			tick++;
		}
	}

	function animate() {
		raf = requestAnimationFrame(animate);
		var now = ctx.currentTime;
		while (queue.length && queue[0].t <= now) {
			var q = queue.shift();
			var dots = beatsEl.children;
			for (var i = 0; i < dots.length; i++) { dots[i].classList.toggle('is-on', i === q.b); }
			stage.classList.toggle('is-accent', q.b === 0 && accent);
			stage.classList.remove('is-pulse');
			void stage.offsetWidth;
			stage.classList.add('is-pulse');
		}
	}

	function start() {
		if (!ensure()) { return; }
		playing = true;
		tick = 0; queue = [];
		nextTime = ctx.currentTime + 0.05;
		schedule();
		timer = setInterval(schedule, 25);
		animate();
		playBtn.textContent = 'Stop';
		playBtn.classList.add('is-on');
		playBtn.setAttribute('aria-pressed', 'true');
		U.status(statusEl, 'Playing at ' + bpm + ' BPM, ' + beats + '/' + noteVal + '. Space starts and stops; arrow keys change the tempo.', 'ok');
	}

	function stop() {
		playing = false;
		clearInterval(timer);
		cancelAnimationFrame(raf);
		U.$$('span', beatsEl).forEach(function (d) { d.classList.remove('is-on'); });
		stage.classList.remove('is-pulse', 'is-accent');
		playBtn.textContent = 'Start';
		playBtn.classList.remove('is-on');
		playBtn.setAttribute('aria-pressed', 'false');
		U.status(statusEl, 'Stopped at ' + bpm + ' BPM.', '');
	}

	function setBpm(v, fromSlider) {
		v = Math.round(Math.min(MAX, Math.max(MIN, Number(v) || bpm)));
		bpm = v;
		bpmIn.value = v;
		if (!fromSlider) { slider.value = v; }
		markEl.textContent = marking(v) + ' · ' + U.fmt(60000 / v, 0) + ' ms per beat';
		if (playing) { U.status(statusEl, 'Playing at ' + bpm + ' BPM, ' + beats + '/' + noteVal + '.', 'ok'); }
	}

	function buildBeats() {
		beatsEl.innerHTML = '';
		for (var i = 0; i < beats; i++) {
			var d = document.createElement('span');
			if (i === 0 && accent && beats > 1) { d.className = 'is-first'; }
			beatsEl.appendChild(d);
		}
	}

	function tap() {
		var now = performance.now();
		clearTimeout(tapTimer);
		if (taps.length && now - taps[taps.length - 1] > 2500) { taps = []; }
		taps.push(now);
		if (taps.length > 8) { taps.shift(); }
		if (taps.length >= 2) {
			var gaps = [];
			for (var i = 1; i < taps.length; i++) { gaps.push(taps[i] - taps[i - 1]); }
			var avg = gaps.reduce(function (a, b) { return a + b; }, 0) / gaps.length;
			setBpm(60000 / avg);
			tapBtn.textContent = 'Tap (' + taps.length + ')';
			if (playing) { tick = 0; queue = []; nextTime = ctx.currentTime + 0.02; }
		}
		tapTimer = setTimeout(function () { taps = []; tapBtn.textContent = 'Tap tempo'; }, 2500);
	}

	playBtn.addEventListener('click', function () { if (playing) { stop(); } else { start(); } });
	tapBtn.addEventListener('click', tap);
	bpmIn.addEventListener('change', function () { setBpm(bpmIn.value); });
	bpmIn.addEventListener('input', function () { var v = Number(bpmIn.value); if (v >= MIN && v <= MAX) { setBpm(v); } });
	slider.addEventListener('input', function () { setBpm(slider.value, true); });
	vol.addEventListener('input', setVol);
	stepBtns.forEach(function (b) { b.addEventListener('click', function () { setBpm(bpm + Number(b.getAttribute('data-mn-step'))); }); });
	U.$$('[data-mn-preset]', root).forEach(function (b) { b.addEventListener('click', function () { setBpm(b.getAttribute('data-mn-preset')); }); });

	function seg(list, attr, fn) {
		list.forEach(function (btn) {
			btn.addEventListener('click', function () {
				fn(btn.getAttribute(attr));
				list.forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
			});
		});
	}
	seg(sigSel, 'data-mn-sig', function (v) { var p = v.split('/'); beats = Number(p[0]); noteVal = Number(p[1]); buildBeats(); if (playing) { tick = 0; queue = []; nextTime = ctx.currentTime + 0.02; } });
	seg(subSel, 'data-mn-sub', function (v) { sub = Number(v); if (playing) { tick = 0; queue = []; nextTime = ctx.currentTime + 0.02; } });
	seg(soundSel, 'data-mn-sound', function (v) { sound = v; });
	$('#mn-accent').addEventListener('change', function (e) { accent = e.target.checked; buildBeats(); });

	root.addEventListener('keydown', function (e) {
		if (e.target === bpmIn) { return; }
		if (e.key === ' ') { e.preventDefault(); if (!e.repeat) { playBtn.click(); } }
		else if (e.key === 'ArrowUp' || e.key === 'ArrowRight') { e.preventDefault(); setBpm(bpm + (e.shiftKey ? 10 : 1)); }
		else if (e.key === 'ArrowDown' || e.key === 'ArrowLeft') { e.preventDefault(); setBpm(bpm - (e.shiftKey ? 10 : 1)); }
		else if (e.key.toLowerCase() === 't') { e.preventDefault(); tap(); }
	});
	document.addEventListener('visibilitychange', function () { if (document.hidden && playing) { stop(); } });

	buildBeats();
	setBpm(120);
	setVol();
}());
