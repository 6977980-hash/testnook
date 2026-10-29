/* Typing test: a stream of words or sentences, typed into a hidden input; WPM, raw WPM, accuracy, errors and a per-page best.
   Shared by typing-speed-test, 1-minute-typing-test, 5-minute-typing-test, wpm-test and typing-test-english.
   The stage's data-tt-text (words | sentences) picks the source; data-tt-dur is the default length in seconds; [data-tt-t] buttons change it. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="typing-speed-test"], [data-tool="1-minute-typing-test"], [data-tool="5-minute-typing-test"], [data-tool="wpm-test"], [data-tool="typing-test-english"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };
	var slug = root.getAttribute('data-tool');

	var WORDS = ["the", "of", "and", "to", "in", "is", "you", "that", "it", "he", "was", "for", "on", "are", "as", "with", "his", "they", "at", "be", "this", "have", "from", "or", "one", "had", "by", "word", "but", "not", "what", "all", "were", "we", "when", "your", "can", "said", "there", "use", "an", "each", "which", "she", "do", "how", "their", "if", "will", "up", "other", "about", "out", "many", "then", "them", "these", "so", "some", "her", "would", "make", "like", "him", "into", "time", "has", "look", "two", "more", "write", "go", "see", "number", "no", "way", "could", "people", "my", "than", "first", "water", "been", "call", "who", "oil", "its", "now", "find", "long", "down", "day", "did", "get", "come", "made", "may", "part", "over", "new", "sound", "take", "only", "little", "work", "know", "place", "year", "live", "me", "back", "give", "most", "very", "after", "thing", "our", "just", "name", "good", "sentence", "man", "think", "say", "great", "where", "help", "through", "much", "before", "line", "right", "too", "mean", "old", "any", "same", "tell", "boy", "follow", "came", "want", "show", "also", "around", "form", "three", "small", "set", "put", "end", "does", "another", "well", "large", "must", "big", "even", "such", "because", "turn", "here", "why", "ask", "went", "men", "read", "need", "land", "different", "home", "us", "move", "try", "kind", "hand", "picture", "again", "change", "off", "play", "spell", "air", "away", "animal", "house", "point", "page", "letter", "mother", "answer", "found", "study", "still", "learn", "should", "world", "high", "every", "near", "add", "food", "between", "own", "below", "country", "plant", "last", "school", "father", "keep", "tree", "never", "start", "city", "earth", "eye", "light", "thought", "head", "under", "story", "saw", "left", "late", "run", "while", "press", "close", "night", "real", "life", "few", "north", "open", "seem", "together", "next", "white", "children", "begin", "got", "walk", "example", "ease", "paper", "group", "always", "music", "those", "both", "mark", "often", "until", "mile", "river", "car", "feet", "care", "second", "book", "carry", "took", "science", "eat", "room", "friend", "began", "idea", "fish", "mountain", "stop", "once", "base", "hear", "horse", "cut", "sure", "watch", "color", "face", "wood", "main", "enough", "plain", "girl", "usual", "young", "ready", "above", "ever", "red", "list", "though", "feel", "talk", "bird", "soon", "body", "dog", "family", "direct", "pose", "leave", "song", "measure", "door", "product", "black", "short", "numeral", "class", "wind", "question", "happen", "complete", "ship", "area", "half", "rock", "order", "fire", "south", "problem", "piece", "told", "knew", "pass", "since", "top", "whole", "king", "space", "heard", "best", "hour", "better", "true", "during", "hundred", "five", "remember", "step", "early", "hold", "west", "ground", "interest", "reach", "fast", "verb", "sing", "listen", "six", "table", "travel", "less", "morning", "ten", "simple", "several", "vowel", "toward", "war", "lay", "against", "pattern", "slow", "center", "love", "person", "money", "serve", "appear", "road", "map", "rain", "rule", "govern", "pull", "cold", "notice", "voice", "unit", "power", "town", "fine", "certain", "fly", "fall", "lead", "cry", "dark", "machine", "note", "wait", "plan", "figure", "star", "box", "noun", "field", "rest", "correct", "able", "pound", "done", "beauty", "drive", "stood", "contain", "front", "teach", "week", "final", "gave", "green", "oh", "quick", "develop", "ocean", "warm", "free", "minute", "strong", "special", "mind", "behind", "clear", "tail", "produce", "fact", "street", "inch", "multiply", "nothing", "course", "stay", "wheel", "full", "force", "blue", "object", "decide", "surface", "deep", "moon", "island", "foot", "system", "busy", "test", "record", "boat", "common", "gold", "possible", "plane", "stead", "dry", "wonder", "laugh", "thousand", "ago", "ran", "check", "game", "shape", "equate", "hot", "miss", "brought", "heat", "snow", "tire", "bring", "yes", "distant", "fill", "east", "paint", "language", "among"];
	var SENTENCES = [
		"The quick brown fox jumps over the lazy dog while the farmer watches from the gate.",
		"Every morning she walks to the harbor to watch the fishing boats come in with the tide.",
		"The library closes early on Fridays, so bring your books back before five if you can.",
		"A good cup of coffee needs fresh beans, clean water and a little patience at the start of the day.",
		"He fixed the old bicycle in the garage and rode it down the hill without using the brakes.",
		"Rain fell steadily all afternoon, drumming on the roof and filling the gutters along the street.",
		"The museum has a new exhibition about the history of printing and the first paper mills in Europe.",
		"We planted tomatoes along the fence in April and picked the first ripe ones in the middle of July.",
		"The train to the coast leaves at nine, stops twice in the valley and arrives just before lunch.",
		"My neighbor keeps bees at the end of his garden and gives us a jar of honey every autumn.",
		"The children built a fort out of cushions and blankets and refused to come out until dinner.",
		"She learned to play the piano by ear, picking out the tunes her grandmother used to sing.",
		"The bakery on the corner sells bread that is still warm if you get there before eight.",
		"Clouds gathered over the mountains in the late afternoon, and by evening the first snow was falling.",
		"The old map showed a path through the forest that no longer appears on any modern chart.",
		"A small stream runs behind the school, and in spring it is full of tadpoles and bright green weed.",
		"He wrote letters to his sister every week for thirty years, and she kept every single one.",
		"The market opens at dawn, and by the time the sun is up the best vegetables are already gone.",
		"They painted the kitchen a pale yellow that makes the whole room feel warmer on gray days.",
		"The lighthouse keeper climbed the spiral stairs twice a day to trim the wick and polish the glass.",
		"After the storm the beach was covered in driftwood, shells and tangles of dark seaweed.",
		"The orchestra tuned up slowly, a few notes at a time, until the hall was full of sound.",
		"A fox crossed the road in front of the car and vanished into the hedge without a sound.",
		"The recipe calls for two eggs, a cup of flour, a pinch of salt and enough milk to make a thin batter.",
		"We spent the whole weekend sorting through boxes of photographs that had been in the attic for years.",
		"The river freezes in January, and the village children skate on it until the thaw in March.",
		"Her garden is small but full of color from the first crocus in February to the last rose in November.",
		"The clock on the town hall has been five minutes slow for as long as anyone can remember.",
		"He built the bookshelves himself from planks he found at the back of the lumber yard.",
		"The ferry crosses the lake four times a day in summer and twice a day for the rest of the year.",
		"Birds gather on the telephone wires every evening in September before they fly south for the winter.",
		"The cafe at the station serves the best toasted sandwiches in town, and everybody knows it.",
		"A long path winds up through the pines to a clearing where you can see the whole valley.",
		"She kept a diary of the weather for fifty years, noting every frost, flood and heatwave.",
		"The engine coughed twice, caught, and settled into a steady hum that carried us out of the bay.",
		"Fresh snow covered the fields, and the only marks on it were the tracks of a single hare.",
		"The shop sells pencils, string, candles and a hundred other things you did not know you needed.",
		"We watched the sun go down from the top of the hill and walked home by the light of the moon.",
		"The carpenter measured the doorway twice before cutting the wood, as his father had taught him.",
		"On market day the square fills with stalls, music and the smell of roasting chestnuts."
	];

	var stage = $('#tt-stage'), textEl = $('#tt-text'), input = $('#tt-input'), overlay = $('#tt-overlay'), resultEl = $('#tt-result');
	var timeEl = $('#tt-time'), wpmLive = $('#tt-live'), wpmEl = $('#tt-wpm'), rawEl = $('#tt-raw'), accEl = $('#tt-acc'), errEl = $('#tt-err'), charsEl = $('#tt-chars');
	var statusEl = $('#tt-status'), pbEl = $('#tt-pb'), restartBtn = $('#tt-restart'), tSel = U.$$('[data-tt-t]', root);
	var source = stage.getAttribute('data-tt-text') || 'words';
	var pressed = root.querySelector('[data-tt-t][aria-pressed="true"]');
	var dur = pressed ? Number(pressed.getAttribute('data-tt-t')) : Number(stage.getAttribute('data-tt-dur')) || 60;

	var words = [], idx = 0, typed = [], running = false, done = false, t0 = 0, timer = 0, raf = 0;
	var okChars = 0, badChars = 0, keyChars = 0, lastSentence = -1;

	function key() { return 'tn-typing-best-' + slug + '-' + dur; }
	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(key())) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best for ' + label(dur) + ' in this browser: ' + v + ' WPM' : '';
		return v;
	}
	function label(s) { return s >= 60 ? (s / 60) + ' min' : s + ' s'; }
	function fmtTime(s) { s = Math.max(0, Math.ceil(s)); return s >= 60 ? Math.floor(s / 60) + ':' + ('0' + (s % 60)).slice(-2) : s + ' s'; }

	function more(n) {
		if (source === 'sentences') {
			while (words.length < n) {
				var i;
				do { i = Math.floor(Math.random() * SENTENCES.length); } while (i === lastSentence);
				lastSentence = i;
				SENTENCES[i].split(' ').forEach(function (w) { words.push(w); });
			}
		} else {
			while (words.length < n) {
				var w = WORDS[Math.floor(Math.random() * WORDS.length)];
				if (w !== words[words.length - 1]) { words.push(w); }
			}
		}
	}

	function render(from) {
		for (var i = from; i < words.length; i++) {
			var span = textEl.children[i];
			if (!span) {
				span = document.createElement('span');
				span.className = 'tt-w';
				textEl.appendChild(span);
			}
			var target = words[i], got = typed[i] || '', html = '';
			for (var c = 0; c < target.length; c++) {
				var cls = c < got.length ? (got[c] === target[c] ? 'is-ok' : 'is-bad') : '';
				html += '<span class="tt-c ' + cls + '">' + esc(target[c]) + '</span>';
			}
			for (c = target.length; c < got.length; c++) { html += '<span class="tt-c is-extra">' + esc(got[c]) + '</span>'; }
			span.innerHTML = html;
			span.className = 'tt-w' + (i === idx ? ' is-cur' : '') + (i < idx && got !== target ? ' is-wrong' : '');
		}
	}
	function esc(s) { return s.replace(/&/g, '&amp;').replace(/</g, '&lt;'); }

	function scroll() {
		var cur = textEl.children[idx];
		if (!cur) { return; }
		var line = cur.offsetTop, lineH = cur.offsetHeight || 1;
		var shift = Math.max(0, line - lineH); // keep the current line as the second visible line
		textEl.style.transform = 'translateY(-' + shift + 'px)';
	}

	// Correct letters of the word being typed; the live and final figures both count them, so they agree at the end.
	function partialOk() {
		var target = words[idx] || '', got = typed[idx] || '', ok = 0;
		for (var c = 0; c < Math.min(got.length, target.length); c++) { if (got[c] === target[c]) { ok++; } }
		return ok;
	}

	function stats(final) {
		// Same time base for both: seconds since the first key, capped at the test length.
		var el = (final ? dur : Math.min(dur, Math.max(0.5, (performance.now() - t0) / 1000))) / 60;
		var ok = okChars + (final ? 0 : partialOk());
		var wpm = Math.round((ok / 5) / el), raw = Math.round((keyChars / 5) / el);
		var acc = keyChars ? Math.round(okChars / keyChars * 100) : 100;
		return { wpm: wpm, raw: raw, acc: acc };
	}

	function tick() {
		var left = dur - (performance.now() - t0) / 1000;
		timeEl.textContent = fmtTime(left);
		wpmLive.textContent = String(stats(false).wpm);
		if (left <= 0) { finish(); return; }
		raf = requestAnimationFrame(tick);
	}

	function begin() {
		running = true;
		t0 = performance.now();
		if (window.TNStats) { TNStats.begin('typing-' + dur); }
		raf = requestAnimationFrame(tick);
		U.status(statusEl, 'Go. Type the words; press space after each one.', '');
	}

	function commit() {
		// Space: score the current word and move on.
		var target = words[idx], got = typed[idx] || '';
		if (!got) { return; }
		var ok = 0;
		for (var c = 0; c < Math.min(got.length, target.length); c++) { if (got[c] === target[c]) { ok++; } }
		var bad = got.length - ok + Math.max(0, target.length - got.length);
		okChars += ok + (got === target ? 1 : 0); // the space counts when the word is right
		badChars += bad + (got === target ? 0 : 1);
		keyChars += got.length + 1;
		idx++;
		more(idx + 60);
		render(idx - 1);
		scroll();
		errEl.textContent = String(badChars);
		charsEl.textContent = String(keyChars);
	}

	function onInput() {
		if (done) { input.value = ''; return; }
		var v = input.value;
		if (!running && v.trim()) { begin(); }
		if (v.indexOf(' ') > -1) {
			typed[idx] = v.replace(/\s+$/, '');
			commit();
			input.value = '';
			return;
		}
		typed[idx] = v;
		render(idx);
		scroll();
	}

	function finish() {
		done = true; running = false;
		cancelAnimationFrame(raf);
		if (typed[idx]) { // partial last word counts its correct letters
			var got = typed[idx], ok = partialOk();
			okChars += ok; badChars += got.length - ok; keyChars += got.length;
		}
		var s = stats(true), best = pb();
		wpmEl.textContent = String(s.wpm); rawEl.textContent = String(s.raw); accEl.textContent = s.acc + '%';
		errEl.textContent = String(badChars); charsEl.textContent = String(keyChars);
		timeEl.textContent = fmtTime(0);
		stage.classList.add('is-done');
		overlay.hidden = true;
		input.blur();
		resultEl.innerHTML = '<strong>' + s.wpm + ' WPM</strong><span>' + s.acc + '% accuracy, ' + idx + ' words, ' + keyChars + ' characters in ' + label(dur) + '</span>';
		resultEl.hidden = false;
		var verdict;
		if (s.acc < 90) { verdict = 'Accuracy under 90% is dragging the score down: slow down a little and let the speed come.'; }
		else if (s.wpm < 30) { verdict = 'Below the average of about 40 WPM. Regular practice with all ten fingers lifts this fastest.'; }
		else if (s.wpm < 50) { verdict = 'Around the average for adults.'; }
		else if (s.wpm < 70) { verdict = 'Faster than most people, at the level expected for office and data entry work.'; }
		else if (s.wpm < 100) { verdict = 'Fast. Professional typists and keen programmers land here.'; }
		else { verdict = 'Very fast. Competitive typing territory.'; }
		var msg = s.wpm + ' words per minute with ' + s.acc + '% accuracy (raw ' + s.raw + ' WPM, ' + badChars + ' errors; a wrong word also counts the space after it). ' + verdict;
		if (s.acc >= 90 && s.wpm > best) {
			try { localStorage.setItem(key(), String(s.wpm)); } catch (e) { /* ignore */ }
			pb();
			if (best) { msg += ' New best!'; }
		}
		U.status(statusEl, msg, s.acc >= 90 && s.wpm >= 40 ? 'ok' : '');
		restartBtn.textContent = 'Try again';
		if (window.TNStats && s.acc >= 85) { TNStats.submit('typing-' + dur, s.wpm, s.acc); }
	}

	function reset() {
		cancelAnimationFrame(raf);
		clearTimeout(timer);
		words = []; typed = []; idx = 0; running = false; done = false;
		okChars = 0; badChars = 0; keyChars = 0;
		more(80);
		textEl.innerHTML = '';
		textEl.style.transform = '';
		render(0);
		input.value = '';
		timeEl.textContent = fmtTime(dur);
		wpmLive.textContent = '0';
		wpmEl.textContent = rawEl.textContent = '-'; accEl.textContent = '-'; errEl.textContent = '0'; charsEl.textContent = '0';
		resultEl.hidden = true;
		stage.classList.remove('is-done');
		restartBtn.textContent = 'Restart';
		U.status(statusEl, 'Click the text and start typing. The clock starts on your first key.', '');
		pb();
	}

	function focus() { if (!done) { input.focus({ preventScroll: true }); } }
	stage.addEventListener('pointerdown', function (e) { if (e.target !== input) { e.preventDefault(); } focus(); });
	input.addEventListener('focus', function () { stage.classList.add('is-focus'); overlay.hidden = true; });
	input.addEventListener('blur', function () { stage.classList.remove('is-focus'); if (!done && !U.isTouch()) { overlay.hidden = false; } });
	input.addEventListener('input', onInput);
	input.addEventListener('keydown', function (e) {
		if (e.key === 'Tab') { e.preventDefault(); reset(); focus(); }
		if (e.key === 'Enter' && source === 'sentences') { e.preventDefault(); input.value += ' '; onInput(); }
	});
	input.addEventListener('paste', function (e) { e.preventDefault(); });
	restartBtn.addEventListener('click', function () { reset(); focus(); });
	tSel.forEach(function (b) {
		b.addEventListener('click', function () {
			dur = Number(b.getAttribute('data-tt-t'));
			tSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			reset();
		});
	});
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { reset(); U.status(statusEl, 'The test was stopped because the tab was hidden. Click the text to start again.', ''); } });
	window.addEventListener('resize', scroll);
	reset();
	overlay.hidden = U.isTouch();
}());
