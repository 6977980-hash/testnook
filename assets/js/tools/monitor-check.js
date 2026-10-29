/* Guided monitor check: five steps that open the shared monitor-test.js patterns, a pass/problem mark and note per step, a requestAnimationFrame refresh rate measurement and a copyable summary. */
(function () {
	'use strict';
	var list = document.getElementById('mc-steps');
	var root = list && list.closest('[data-tool]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var summary = $('#mc-summary'), hzOut = $('#mc-hz'), hzBtn = $('#mc-hz-run');
	var steps = U.$$('[data-mc-step]', root);
	var result = {}, hz = 0;

	function name(step) { return step.querySelector('.mc-name').textContent; }

	function paint() {
		var lines = ['Monitor check (testnook.com/monitor-check/)', 'Screen: ' + screen.width + ' x ' + screen.height + ' at ' + (window.devicePixelRatio || 1) + 'x scaling'];
		var done = 0, problems = 0;
		steps.forEach(function (step, i) {
			var id = step.getAttribute('data-mc-step'), r = result[id], note = step.querySelector('[data-mc-note]').value.trim();
			var state = r === 'pass' ? 'Looks fine' : r === 'problem' ? 'Problem' : 'Not checked';
			if (id === 'refresh' && hz) { state = (r ? state + ', ' : '') + 'measured ' + hz + ' Hz'; }
			if (r) { done++; }
			if (r === 'problem') { problems++; }
			step.querySelector('[data-mc-state]').textContent = state;
			step.classList.toggle('is-pass', r === 'pass');
			step.classList.toggle('is-problem', r === 'problem');
			lines.push((i + 1) + '. ' + name(step) + ': ' + state + (note ? ' (' + note + ')' : ''));
		});
		lines.push(done === steps.length ? (problems ? problems + ' of ' + steps.length + ' steps showed a problem.' : 'All ' + steps.length + ' steps look fine.') : done + ' of ' + steps.length + ' steps checked.');
		summary.value = lines.join('\n');
	}

	steps.forEach(function (step) {
		var id = step.getAttribute('data-mc-step'), note = step.querySelector('[data-mc-note]');
		U.$$('[data-mc-result]', step).forEach(function (b) {
			b.addEventListener('click', function () {
				var v = b.getAttribute('data-mc-result');
				result[id] = result[id] === v ? '' : v;
				U.$$('[data-mc-result]', step).forEach(function (o) { o.setAttribute('aria-pressed', o.getAttribute('data-mc-result') === result[id] ? 'true' : 'false'); });
				note.hidden = result[id] !== 'problem';
				if (!note.hidden) { note.focus(); }
				paint();
			});
		});
		note.addEventListener('input', paint);
		var open = step.querySelector('[data-mc-open]');
		if (open) {
			open.addEventListener('click', function () {
				var pat = root.querySelector('.mt-pat[data-mt="' + open.getAttribute('data-mc-open') + '"]');
				if (pat) { pat.click(); }
			});
		}
	});

	/* Refresh rate: median frame interval over two seconds, after a short warm-up, snapped to a common rate when close. */
	hzBtn.addEventListener('click', function () {
		var times = [], start = 0;
		hzBtn.disabled = true;
		hzOut.textContent = 'Measuring...';
		function frame(t) {
			if (!start) { start = t; }
			if (t - start > 300) { times.push(t); }
			if (t - start < 2300) { requestAnimationFrame(frame); return; }
			var d = [];
			for (var i = 1; i < times.length; i++) { d.push(times[i] - times[i - 1]); }
			d.sort(function (a, b) { return a - b; });
			var med = d.length ? d[Math.floor(d.length / 2)] : 0;
			var raw = med ? 1000 / med : 0;
			var common = [24, 30, 48, 50, 60, 75, 90, 100, 120, 144, 165, 170, 175, 180, 200, 240, 280, 300, 360, 480, 500];
			var snap = common.filter(function (c) { return Math.abs(c - raw) / c < 0.03; })[0];
			hz = Math.round(snap || raw);
			hzBtn.disabled = false;
			hzBtn.textContent = 'Measure again';
			hzOut.textContent = hz ? 'About ' + hz + ' Hz' : 'Could not measure. Keep the page in front and try again.';
			paint();
		}
		requestAnimationFrame(frame);
	});

	$('#mc-reset').addEventListener('click', function () {
		result = {}; hz = 0; hzOut.textContent = ''; hzBtn.textContent = 'Measure refresh rate';
		steps.forEach(function (step) {
			U.$$('[data-mc-result]', step).forEach(function (o) { o.setAttribute('aria-pressed', 'false'); });
			var note = step.querySelector('[data-mc-note]');
			note.value = ''; note.hidden = true;
		});
		paint();
	});

	paint();
}());
