/* Verbal memory test: words appear one at a time; press SEEN if the word was shown before in this round, NEW if not. Three strikes. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="verbal-memory-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#vb-stage'), intro = $('#vb-intro'), play = $('#vb-play'), wordEl = $('#vb-word'), scoreEl = $('#vb-score'), livesEl = $('#vb-lives');
	var statusEl = $('#vb-status'), pbEl = $('#vb-pb'), startBtn = $('#vb-start'), seenBtn = $('#vb-seen'), newBtn = $('#vb-new');
	var KEY = 'tn-verbal-memory-best';
	var WORDS = ('apple river candle mirror pencil garden thunder window basket silver copper meadow lantern pillow velvet marble oyster saddle ribbon anchor ' +
		'bridge castle desert eagle forest glacier harbour island jungle kettle ladder magnet needle orchard parcel quarry rocket shadow tunnel umbrella ' +
		'valley walnut yogurt zipper beacon cactus dragon ember falcon goblet helmet ivory jacket kernel locket mantle nectar oracle pepper quiver ' +
		'raven scarf tiger urchin violin wagon yarrow zephyr almond biscuit cobalt dolphin engine fossil gravel hammer iceberg jasmine kitten lemon ' +
		'monkey napkin ocean pebble quartz rabbit sparrow turnip unicorn vessel willow yellow zinc blanket cherry diamond feather ginger hazel ' +
		'insect jewel kiosk lobster mustard noodle olive parrot quilt radish spider tomato usher vortex whistle yacht amber bronze crystal ' +
		'daisy echo fabric galaxy honey igloo jigsaw karate lilac meteor nugget otter pumpkin quail ripple saffron temple utopia vapour wander').split(/\s+/);
	var seen = {}, score = 0, lives = 3, word = '', state = 'idle', shownCount = 0;

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best in this browser: ' + v + ' words' : '';
		return v;
	}
	function hearts() {
		livesEl.innerHTML = '';
		for (var i = 0; i < 3; i++) { livesEl.innerHTML += '<span' + (i < lives ? '' : ' class="is-lost"') + '>&#9679;</span>'; }
	}

	function next() {
		var keys = Object.keys(seen), useSeen = keys.length > 1 && Math.random() < Math.min(0.5, 0.15 + keys.length * 0.03);
		if (useSeen) { word = keys[Math.floor(Math.random() * keys.length)]; }
		else {
			do { word = WORDS[Math.floor(Math.random() * WORDS.length)]; } while (seen[word] && keys.length < WORDS.length);
		}
		shownCount++;
		wordEl.textContent = word;
		state = 'run';
	}

	function answer(saidSeen) {
		if (state !== 'run') { return; }
		var wasSeen = !!seen[word];
		seen[word] = true;
		stage.classList.remove('is-ok', 'is-bad');
		void stage.offsetWidth;
		if (saidSeen === wasSeen) {
			score++;
			scoreEl.textContent = String(score);
			stage.classList.add('is-ok');
			next();
		} else {
			lives--;
			hearts();
			stage.classList.add('is-bad');
			if (lives <= 0) { return gameOver(); }
			U.status(statusEl, (wasSeen ? '"' + word + '" was shown before.' : '"' + word + '" was new.') + ' ' + lives + (lives === 1 ? ' life' : ' lives') + ' left.', 'bad');
			next();
		}
	}

	function gameOver() {
		state = 'idle';
		var msg;
		if (score < 20) { msg = 'Below the typical range. Try linking each word to a picture.'; }
		else if (score < 50) { msg = 'Average. Most people end between 20 and 50 words.'; }
		else if (score < 100) { msg = 'Above average verbal memory.'; }
		else { msg = 'Excellent. Over 100 words takes real recall.'; }
		var best = pb();
		if (score > best) { try { localStorage.setItem(KEY, String(score)); } catch (e) { /* ignore */ } pb(); }
		play.hidden = true;
		intro.hidden = false;
		intro.querySelector('h2').textContent = 'Score: ' + score + ' words';
		intro.querySelector('p').textContent = msg;
		startBtn.textContent = 'Start again';
		U.status(statusEl, 'Game over with ' + score + ' correct answers over ' + shownCount + ' words. ' + msg, '');
		if (window.TNShare && score) { TNShare.show('I scored ' + score + ' words on the Testnook verbal memory test'); }
	}

	startBtn.addEventListener('click', function () {
		if (window.TNShare) { TNShare.hide(); }
		seen = {}; score = 0; lives = 3; shownCount = 0;
		hearts();
		scoreEl.textContent = '0';
		intro.hidden = true;
		play.hidden = false;
		stage.classList.remove('is-ok', 'is-bad');
		U.status(statusEl, 'SEEN if the word already appeared in this round, NEW if it did not. Keys: S and N, or left and right arrows.', '');
		next();
		stage.focus({ preventScroll: true });
	});
	seenBtn.addEventListener('click', function () { answer(true); });
	newBtn.addEventListener('click', function () { answer(false); });
	root.addEventListener('keydown', function (e) {
		var k = e.key.toLowerCase();
		if (state !== 'run' || e.repeat) { return; }
		if (k === 's' || k === 'arrowleft') { e.preventDefault(); answer(true); }
		if (k === 'n' || k === 'arrowright') { e.preventDefault(); answer(false); }
	});
	play.hidden = true;
	hearts();
	pb();
}());
