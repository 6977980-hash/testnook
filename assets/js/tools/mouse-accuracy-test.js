/* Mouse accuracy test: 30 targets at random spots (static or shrinking), hits, misses, accuracy, time per target, distance from centre and a scatter of where clicks land relative to the centre. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="mouse-accuracy-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#ma-stage'), target = $('#ma-target'), statusEl = $('#ma-status'), plot = $('#ma-plot'), pg = plot.getContext('2d');
	var out = { left: $('#ma-left'), acc: $('#ma-acc'), time: $('#ma-time'), dist: $('#ma-dist'), score: $('#ma-score'), best: $('#ma-best') };
	var TOTAL = 30, SHRINK_MS = 1600;
	var mode = 'static', size = 28, run = null, raf = 0;

	function key() { return 'tn-aim-best-' + mode + '-' + size; }
	function loadBest() {
		var b = 0;
		try { b = Number(localStorage.getItem(key())) || 0; } catch (e) { /* private mode */ }
		out.best.textContent = b ? b : '-';
		return b;
	}

	function place() {
		var w = stage.clientWidth, h = stage.clientHeight, pad = size + 6;
		run.tx = pad + Math.random() * (w - pad * 2);
		run.ty = pad + Math.random() * (h - pad * 2);
		run.shown = performance.now();
		run.r = size;
		target.style.left = run.tx + 'px';
		target.style.top = run.ty + 'px';
		target.style.setProperty('--r', size + 'px');
		target.hidden = false;
	}

	function start() {
		run = { n: 0, hits: 0, misses: 0, times: [], dists: [], offs: [], expired: 0 };
		stage.classList.add('is-running');
		$('#ma-intro').hidden = true;
		out.left.textContent = TOTAL;
		['acc', 'time', 'dist', 'score'].forEach(function (k) { out[k].textContent = '-'; });
		place();
		if (mode === 'shrink') { raf = requestAnimationFrame(shrink); }
		U.status(statusEl, 'Go! Click the centre of each target.', '');
	}

	function next() {
		run.n++;
		out.left.textContent = TOTAL - run.n;
		var shots = run.hits + run.misses;
		if (shots) { out.acc.textContent = Math.round(run.hits / shots * 100) + '%'; }
		if (run.n >= TOTAL) { finish(); return; }
		place();
	}

	function shrink(now) {
		if (!run || mode !== 'shrink') { return; }
		raf = requestAnimationFrame(shrink);
		var f = 1 - (now - run.shown) / SHRINK_MS;
		if (f <= 0) { run.expired++; run.misses++; next(); return; }
		run.r = size * f;
		target.style.setProperty('--r', run.r + 'px');
	}

	function finish() {
		cancelAnimationFrame(raf);
		target.hidden = true;
		stage.classList.remove('is-running');
		var shots = run.hits + run.misses, acc = shots ? run.hits / shots * 100 : 0;
		var avgT = run.times.length ? run.times.reduce(function (a, b) { return a + b; }, 0) / run.times.length : 0;
		var avgD = run.dists.length ? run.dists.reduce(function (a, b) { return a + b; }, 0) / run.dists.length : 0;
		// Score: accuracy-weighted targets per second, scaled to a friendly number.
		var score = avgT ? Math.round(acc * (1000 / avgT) * 10 * (1 - Math.min(0.5, avgD / size / 2))) : 0;
		out.acc.textContent = acc.toFixed(0) + '%';
		out.time.textContent = Math.round(avgT) + ' ms';
		out.dist.textContent = avgD.toFixed(1) + ' px';
		out.score.textContent = score;
		var best = loadBest();
		if (score > best) { try { localStorage.setItem(key(), score); } catch (e) { /* ignore */ } out.best.textContent = score; }
		drawPlot();
		var bias = biasText();
		U.status(statusEl, 'Done: ' + run.hits + ' hits, ' + run.misses + ' misses' + (run.expired ? ' (' + run.expired + ' targets ran out)' : '') + '. Accuracy ' + acc.toFixed(0) + '%, ' + Math.round(avgT) + ' ms per target.' + (bias ? ' ' + bias : '') + (score > best ? ' New best score!' : ''), 'ok');
		$('#ma-intro').hidden = false;
		$('#ma-go').textContent = 'Play again';
		run.done = true;
	}

	function biasText() {
		// Hits only: a stray miss far away would swamp the average.
		var hits = run.offs.filter(function (o) { return Math.hypot(o[0], o[1]) <= 1; });
		if (hits.length < 8) { return ''; }
		var mx = 0, my = 0;
		hits.forEach(function (o) { mx += o[0]; my += o[1]; });
		mx /= hits.length; my /= hits.length;
		var parts = [];
		if (Math.abs(my) > 0.12) { parts.push(my > 0 ? 'low' : 'high'); }
		if (Math.abs(mx) > 0.12) { parts.push(mx > 0 ? 'right' : 'left'); }
		return parts.length ? 'You tend to click ' + parts.join(' and ') + ' of centre.' : 'Your clicks are well centred.';
	}

	// Click positions relative to the target centre, scaled to the target radius.
	function drawPlot() {
		var dpr = Math.min(2, window.devicePixelRatio || 1), s = plot.clientWidth;
		plot.width = plot.height = Math.round(s * dpr);
		var W = plot.width, c = W / 2, r = W / 2 - 10 * dpr, css = getComputedStyle(root);
		pg.clearRect(0, 0, W, W);
		pg.strokeStyle = css.getPropertyValue('--border').trim();
		pg.lineWidth = dpr;
		[1, 0.5].forEach(function (k) { pg.beginPath(); pg.arc(c, c, r * k / 1.5, 0, Math.PI * 2); pg.stroke(); });
		pg.beginPath(); pg.moveTo(c - r, c); pg.lineTo(c + r, c); pg.moveTo(c, c - r); pg.lineTo(c, c + r); pg.stroke();
		run.offs.forEach(function (o) {
			var d = Math.hypot(o[0], o[1]);
			pg.fillStyle = d <= 1 ? css.getPropertyValue('--ok').trim() : css.getPropertyValue('--bad').trim();
			pg.beginPath();
			var k = d > 1.45 ? 1.45 / d : 1; // far misses sit on the outer edge
			pg.arc(c + o[0] * k / 1.5 * r, c + o[1] * k / 1.5 * r, 3.5 * dpr, 0, Math.PI * 2);
			pg.fill();
		});
	}

	stage.addEventListener('pointerdown', function (e) {
		if (!run || run.done || target.hidden) { return; }
		e.preventDefault();
		var rect = stage.getBoundingClientRect(), x = e.clientX - rect.left, y = e.clientY - rect.top;
		var dx = x - run.tx, dy = y - run.ty, d = Math.hypot(dx, dy);
		run.offs.push([dx / run.r, dy / run.r]);
		if (d <= run.r) {
			run.hits++;
			run.times.push(performance.now() - run.shown);
			run.dists.push(d);
			target.classList.remove('is-hit'); void target.offsetWidth; target.classList.add('is-hit');
			next();
		} else {
			run.misses++;
			stage.classList.remove('is-miss'); void stage.offsetWidth; stage.classList.add('is-miss');
			if (mode === 'shrink') { next(); }
		}
		if (run.n < TOTAL) { out.acc.textContent = Math.round(run.hits / (run.hits + run.misses) * 100) + '%'; }
	});
	stage.addEventListener('contextmenu', function (e) { if (run && !run.done) { e.preventDefault(); } });

	$('#ma-go').addEventListener('click', function (e) { e.stopPropagation(); start(); });
	U.$$('[data-ma-mode]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			mode = b.getAttribute('data-ma-mode');
			U.$$('[data-ma-mode]', root).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
			loadBest();
		});
	});
	U.$$('[data-ma-size]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			size = Number(b.getAttribute('data-ma-size'));
			U.$$('[data-ma-size]', root).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
			loadBest();
		});
	});
	loadBest();

	// For automated checks.
	root.maTarget = function () { return run && !target.hidden ? { x: run.tx, y: run.ty, r: run.r } : null; };
}());
