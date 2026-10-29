/* Device info: reads what the browser exposes (user agent, client hints, screen, CPU, memory, GPU, network, battery) and shows it.
   Shared by device-info, what-is-my-user-agent and what-phone-do-i-have. Each page has its own markup; this script fills whatever is there:
   [data-di="key"] gets one value, #di-table gets the grouped list (data-di-groups picks the groups), #di-ua the raw string,
   #di-parse-* the paste-a-user-agent parser, #di-phone* the phone model guess, #br-* the browser page (up-to-date
   estimate from the release cadence, feature support list). Nothing is sent anywhere. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="device-info"], [data-tool="what-is-my-user-agent"], [data-tool="what-phone-do-i-have"], [data-tool="what-is-my-browser"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };
	var nav = navigator, ua = nav.userAgent || '';
	var statusEl = $('#di-status');

	/* ---------- User agent parsing ---------- */
	function ver(s, re) { var m = s.match(re); return m ? m[1].replace(/_/g, '.') : ''; }

	function parse(s, live) {
		var r = { browser: 'Unknown browser', version: '', engine: '', os: 'Unknown OS', osVersion: '', type: 'desktop', model: '', vendor: '' };
		var browsers = [
			[/Edg(?:e|A|iOS)?\/([\d.]+)/, 'Microsoft Edge'],
			[/OPR\/([\d.]+)|Opera\/([\d.]+)/, 'Opera'],
			[/SamsungBrowser\/([\d.]+)/, 'Samsung Internet'],
			[/YaBrowser\/([\d.]+)/, 'Yandex Browser'],
			[/Vivaldi\/([\d.]+)/, 'Vivaldi'],
			[/UCBrowser\/([\d.]+)/, 'UC Browser'],
			[/MiuiBrowser\/([\d.]+)/, 'Mi Browser'],
			[/FxiOS\/([\d.]+)/, 'Firefox'],
			[/Firefox\/([\d.]+)/, 'Firefox'],
			[/CriOS\/([\d.]+)/, 'Chrome'],
			[/Chrome\/([\d.]+)/, 'Chrome'],
			[/Version\/([\d.]+).*Safari\//, 'Safari']
		];
		for (var i = 0; i < browsers.length; i++) {
			var m = s.match(browsers[i][0]);
			if (m) { r.browser = browsers[i][1]; r.version = m[1] || m[2] || ''; break; }
		}
		if (live && nav.brave && r.browser === 'Chrome') { r.browser = 'Brave'; }
		if (/; wv\)/.test(s) && r.browser === 'Chrome') { r.browser = 'Android WebView'; }

		if (/iPhone|iPad|iPod/.test(s)) { r.engine = 'WebKit'; }
		else if (/Gecko\/\d/.test(s) && /Firefox\//.test(s)) { r.engine = 'Gecko'; }
		else if (/Chrome\/|Chromium\//.test(s)) { r.engine = 'Blink'; }
		else if (/AppleWebKit\//.test(s)) { r.engine = 'WebKit'; }

		if (/Windows NT/.test(s)) {
			var nt = ver(s, /Windows NT ([\d.]+)/);
			r.os = 'Windows';
			r.osVersion = { '10.0': '10 or 11', '6.3': '8.1', '6.2': '8', '6.1': '7', '6.0': 'Vista', '5.1': 'XP' }[nt] || nt;
		} else if (/iPhone|iPod/.test(s)) {
			r.os = 'iOS'; r.osVersion = ver(s, /OS ([\d_]+) like Mac/); r.type = 'phone'; r.vendor = 'Apple'; r.model = 'iPhone';
		} else if (/iPad/.test(s)) {
			r.os = 'iPadOS'; r.osVersion = ver(s, /OS ([\d_]+) like Mac/); r.type = 'tablet'; r.vendor = 'Apple'; r.model = 'iPad';
		} else if (/Android/.test(s)) {
			r.os = 'Android'; r.osVersion = ver(s, /Android ([\d.]+)/);
			r.type = /Mobile/.test(s) ? 'phone' : 'tablet';
			var mm = s.match(/Android [\d.]+; (?:[a-z]{2}[-_][a-z]{2}; )?([^;)]+?)(?: Build\/[^;)]*)?\)/i);
			if (mm && mm[1] && mm[1] !== 'K' && !/^wv$|^Linux$/.test(mm[1])) { r.model = mm[1].trim(); }
		} else if (/CrOS/.test(s)) {
			r.os = 'ChromeOS';
		} else if (/Macintosh|Mac OS X/.test(s)) {
			r.os = 'macOS'; r.osVersion = ver(s, /Mac OS X ([\d_.]+)/);
			// iPadOS asks for desktop sites with a Mac user agent; touch support gives it away.
			if (live && nav.maxTouchPoints > 1) { r.os = 'iPadOS'; r.osVersion = ''; r.type = 'tablet'; r.vendor = 'Apple'; r.model = 'iPad'; }
		} else if (/Linux/.test(s)) {
			r.os = 'Linux';
		}
		if (/bot|crawl|spider|slurp/i.test(s)) { r.type = 'bot'; }
		return r;
	}

	/* ---------- Phone model names ---------- */
	var SAMSUNG = {
		S938: 'Galaxy S25 Ultra', S936: 'Galaxy S25+', S931: 'Galaxy S25', S928: 'Galaxy S24 Ultra', S926: 'Galaxy S24+', S921: 'Galaxy S24',
		S918: 'Galaxy S23 Ultra', S916: 'Galaxy S23+', S911: 'Galaxy S23', S908: 'Galaxy S22 Ultra', S906: 'Galaxy S22+', S901: 'Galaxy S22',
		S721: 'Galaxy S24 FE', S711: 'Galaxy S23 FE', G998: 'Galaxy S21 Ultra', G996: 'Galaxy S21+', G991: 'Galaxy S21', G990: 'Galaxy S21 FE',
		F956: 'Galaxy Z Fold6', F946: 'Galaxy Z Fold5', F936: 'Galaxy Z Fold4', F741: 'Galaxy Z Flip6', F731: 'Galaxy Z Flip5', F721: 'Galaxy Z Flip4',
		A556: 'Galaxy A55', A546: 'Galaxy A54', A536: 'Galaxy A53', A528: 'Galaxy A52s', A526: 'Galaxy A52 5G', A525: 'Galaxy A52',
		A356: 'Galaxy A35', A346: 'Galaxy A34', A336: 'Galaxy A33', A325: 'Galaxy A32', A256: 'Galaxy A25', A245: 'Galaxy A24', A235: 'Galaxy A23',
		A166: 'Galaxy A16 5G', A165: 'Galaxy A16', A156: 'Galaxy A15 5G', A155: 'Galaxy A15', A146: 'Galaxy A14 5G', A145: 'Galaxy A14',
		A136: 'Galaxy A13 5G', A135: 'Galaxy A13', A125: 'Galaxy A12', A057: 'Galaxy A05s', A055: 'Galaxy A05', A715: 'Galaxy A71', A515: 'Galaxy A51', A505: 'Galaxy A50'
	};
	// CSS screen size (portrait) and pixel ratio -> iPhones that share it.
	var IPHONES = {
		'320x568@2': ['iPhone SE (1st gen)', 'iPhone 5s'],
		'375x667@2': ['iPhone SE (2nd or 3rd gen)', 'iPhone 8', 'iPhone 7', 'iPhone 6s'],
		'414x736@3': ['iPhone 8 Plus', 'iPhone 7 Plus', 'iPhone 6s Plus'],
		'375x812@3': ['iPhone 13 mini', 'iPhone 12 mini', 'iPhone 11 Pro', 'iPhone XS', 'iPhone X'],
		'414x896@2': ['iPhone 11', 'iPhone XR'],
		'414x896@3': ['iPhone 11 Pro Max', 'iPhone XS Max'],
		'390x844@3': ['iPhone 16e', 'iPhone 14', 'iPhone 13', 'iPhone 13 Pro', 'iPhone 12', 'iPhone 12 Pro'],
		'428x926@3': ['iPhone 14 Plus', 'iPhone 13 Pro Max', 'iPhone 12 Pro Max'],
		'393x852@3': ['iPhone 16', 'iPhone 15', 'iPhone 15 Pro', 'iPhone 14 Pro'],
		'430x932@3': ['iPhone 16 Plus', 'iPhone 15 Plus', 'iPhone 15 Pro Max', 'iPhone 14 Pro Max'],
		'402x874@3': ['iPhone 17', 'iPhone 17 Pro', 'iPhone 16 Pro'],
		'420x912@3': ['iPhone Air'],
		'440x956@3': ['iPhone 17 Pro Max', 'iPhone 16 Pro Max']
	};

	function samsungName(model) {
		var m = model.match(/^SM-([A-Z]\d{3})/i);
		return m && SAMSUNG[m[1].toUpperCase()] ? 'Samsung ' + SAMSUNG[m[1].toUpperCase()] : '';
	}

	function iphoneCandidates() {
		var w = Math.min(screen.width, screen.height), h = Math.max(screen.width, screen.height);
		return IPHONES[w + 'x' + h + '@' + Math.round(window.devicePixelRatio || 1)] || [];
	}

	/* ---------- Collect ---------- */
	var info = parse(ua, true), hints = {}, extra = {};

	function gpu() {
		try {
			var c = document.createElement('canvas'), gl = c.getContext('webgl2') || c.getContext('webgl');
			if (!gl) { return { renderer: 'WebGL not available', vendor: '-', webgl2: false }; }
			var dbg = gl.getExtension('WEBGL_debug_renderer_info');
			return {
				renderer: dbg ? gl.getParameter(dbg.UNMASKED_RENDERER_WEBGL) : gl.getParameter(gl.RENDERER),
				vendor: dbg ? gl.getParameter(dbg.UNMASKED_VENDOR_WEBGL) : gl.getParameter(gl.VENDOR),
				webgl2: typeof WebGL2RenderingContext !== 'undefined' && gl instanceof WebGL2RenderingContext
			};
		} catch (e) { return { renderer: '-', vendor: '-', webgl2: false }; }
	}

	function mq(q) { return window.matchMedia && matchMedia(q).matches; }
	function yes(v) { return v ? 'Yes' : 'No'; }

	function refreshRate(done) {
		var n = 0, t0 = 0;
		function f(t) {
			if (!t0) { t0 = t; }
			n++;
			if (t - t0 < 1000) { requestAnimationFrame(f); return; }
			done(Math.round((n - 1) / ((t - t0) / 1000)));
		}
		requestAnimationFrame(f);
	}

	function osLabel() {
		var os = info.os, v = info.osVersion;
		if (hints.platformVersion && info.os === 'Windows') {
			v = parseInt(hints.platformVersion, 10) >= 13 ? '11' : '10';
		} else if (hints.platformVersion && (info.os === 'Android' || info.os === 'macOS')) {
			v = hints.platformVersion.replace(/(\.0)+$/, '');
		}
		return os + (v ? ' ' + v : '');
	}

	function model() { return hints.model || info.model; }

	function deviceName() {
		var md = model();
		if (info.os === 'iOS') {
			var c = iphoneCandidates();
			return c.length === 1 ? c[0] : c.length ? c[0] + ' or similar' : 'iPhone';
		}
		if (info.os === 'iPadOS') { return 'iPad'; }
		if (md) { return samsungName(md) || md; }
		if (info.type === 'phone') { return 'Android phone'; }
		if (info.type === 'tablet') { return 'Android tablet'; }
		return info.os === 'macOS' ? 'Mac' : info.os === 'ChromeOS' ? 'Chromebook' : 'Computer';
	}

	function rows() {
		var g = gpu(), s = screen, dpr = window.devicePixelRatio || 1, c = nav.connection || {};
		var cores = nav.hardwareConcurrency, mem = nav.deviceMemory;
		return {
			browser: [
				['Browser', info.browser + (info.version ? ' ' + info.version : '')],
				['Engine', info.engine || '-'],
				['Languages', (nav.languages || [nav.language]).join(', ')],
				['Cookies enabled', yes(nav.cookieEnabled)],
				['Do Not Track', nav.doNotTrack === '1' ? 'On' : 'Off'],
				['Online', yes(nav.onLine)]
			],
			system: [
				['Operating system', osLabel()],
				['Device type', info.type.charAt(0).toUpperCase() + info.type.slice(1)],
				['Device', deviceName()],
				['Model code', model() || 'Not shared by the browser'],
				['CPU architecture', hints.architecture ? hints.architecture + (hints.bitness ? ' (' + hints.bitness + '-bit)' : '') : 'Not shared by the browser'],
				['CPU threads', cores ? String(cores) : 'Not shared by the browser'],
				['Memory (RAM)', mem ? (mem >= 8 ? '8 GB or more' : 'About ' + mem + ' GB') : 'Not shared by the browser'],
				['Battery', extra.battery || 'Not shared by the browser'],
				['Time zone', (Intl.DateTimeFormat().resolvedOptions().timeZone || '-') + ' (UTC' + utc() + ')']
			],
			screen: [
				['Screen size (CSS pixels)', s.width + ' x ' + s.height],
				['Screen resolution (device pixels)', Math.round(s.width * dpr) + ' x ' + Math.round(s.height * dpr)],
				['Pixel ratio', String(Math.round(dpr * 100) / 100)],
				['Browser window', window.innerWidth + ' x ' + window.innerHeight],
				['Colour depth', s.colorDepth + '-bit'],
				['Colour gamut', mq('(color-gamut: rec2020)') ? 'Rec. 2020' : mq('(color-gamut: p3)') ? 'Display P3' : 'sRGB'],
				['HDR', mq('(dynamic-range: high)') ? 'Supported' : 'No'],
				['Refresh rate', extra.hz ? 'About ' + extra.hz + ' Hz' : 'Measuring...'],
				['Orientation', (s.orientation && s.orientation.type) ? s.orientation.type.replace('-primary', '').replace('-secondary', ' (flipped)') : (window.innerWidth > window.innerHeight ? 'landscape' : 'portrait')],
				['Touch points', String(nav.maxTouchPoints || 0)],
				['Pointer', mq('(any-pointer: fine)') ? (mq('(any-pointer: coarse)') ? 'Mouse and touch' : 'Mouse or touchpad') : 'Touch'],
				['Dark mode', mq('(prefers-color-scheme: dark)') ? 'On' : 'Off']
			],
			gpu: [
				['Graphics (GPU)', String(g.renderer)],
				['GPU vendor', String(g.vendor)],
				['WebGL 2', yes(g.webgl2)],
				['WebGPU', yes('gpu' in nav)]
			],
			network: [
				['Connection', c.effectiveType ? c.effectiveType.toUpperCase() + (c.type ? ', ' + c.type : '') : 'Not shared by the browser'],
				['Estimated speed', c.downlink ? c.downlink + ' Mbps' : '-'],
				['Estimated latency', c.rtt ? c.rtt + ' ms' : '-'],
				['Data saver', c.saveData ? 'On' : 'Off']
			],
			features: [
				['Vibration', yes('vibrate' in nav)],
				['Camera and microphone API', yes(nav.mediaDevices && nav.mediaDevices.getUserMedia)],
				['Gamepad API', yes('getGamepads' in nav)],
				['Bluetooth API', yes('bluetooth' in nav)],
				['USB API', yes('usb' in nav)],
				['Motion sensors', yes('DeviceMotionEvent' in window)],
				['Service workers', yes('serviceWorker' in nav)],
				['WebAssembly', yes(typeof WebAssembly === 'object')],
				['Storage quota', extra.storage || '-']
			]
		};
	}

	var TITLES = { browser: 'Browser', system: 'Device and system', screen: 'Screen', gpu: 'Graphics', network: 'Network', features: 'Features' };

	function utc() {
		var o = -new Date().getTimezoneOffset(), sign = o >= 0 ? '+' : '-';
		o = Math.abs(o);
		return sign + Math.floor(o / 60) + (o % 60 ? ':' + ('0' + o % 60).slice(-2) : '');
	}

	/* ---------- Render ---------- */
	var table = $('#di-table');
	function render() {
		var data = rows();
		if (table) {
			var groups = (table.getAttribute('data-di-groups') || 'browser,system,screen,gpu,network,features').split(',');
			table.innerHTML = '';
			groups.forEach(function (k) {
				var sec = document.createElement('div'), h = document.createElement('h3'), dl = document.createElement('dl');
				sec.className = 'di-group';
				h.textContent = TITLES[k];
				data[k].forEach(function (row) {
					var dt = document.createElement('dt'), dd = document.createElement('dd');
					dt.textContent = row[0];
					dd.textContent = row[1];
					dl.appendChild(dt);
					dl.appendChild(dd);
				});
				sec.appendChild(h);
				sec.appendChild(dl);
				table.appendChild(sec);
			});
		}
		var flat = {};
		Object.keys(data).forEach(function (k) { data[k].forEach(function (row) { flat[row[0]] = row[1]; }); });
		var single = {
			device: deviceName(), os: osLabel(), browser: info.browser + (info.version ? ' ' + info.version.split('.')[0] : ''),
			screen: screen.width + ' x ' + screen.height, engine: info.engine || '-', type: info.type, model: model() || '-'
		};
		U.$$('[data-di]', root).forEach(function (el) {
			var k = el.getAttribute('data-di');
			el.textContent = single[k] !== undefined ? single[k] : (flat[k] || '-');
		});
		var uaEl = $('#di-ua');
		if (uaEl) { uaEl.textContent = ua; }
		var hintsEl = $('#di-hints');
		if (hintsEl) {
			var list = [];
			if (nav.userAgentData) {
				list.push(['Brands', nav.userAgentData.brands.filter(function (b) { return !/Not.?A.?Brand/i.test(b.brand); }).map(function (b) { return b.brand + ' ' + b.version; }).join(', ')]);
				list.push(['Mobile', yes(nav.userAgentData.mobile)]);
				list.push(['Platform', nav.userAgentData.platform || '-']);
				['platformVersion', 'model', 'architecture', 'bitness', 'uaFullVersion'].forEach(function (k) {
					if (hints[k] !== undefined) { list.push([k, hints[k] === '' ? '(empty)' : hints[k]]); }
				});
			}
			hintsEl.innerHTML = '';
			if (!list.length) {
				var p = document.createElement('p');
				p.className = 'di-muted';
				p.textContent = 'This browser does not send User-Agent Client Hints (Safari and Firefox do not). The user agent string above is all it shares.';
				hintsEl.appendChild(p);
			} else {
				var dl = document.createElement('dl');
				list.forEach(function (row) {
					var dt = document.createElement('dt'), dd = document.createElement('dd');
					dt.textContent = row[0];
					dd.textContent = row[1];
					dl.appendChild(dt);
					dl.appendChild(dd);
				});
				hintsEl.appendChild(dl);
			}
		}
		renderPhone();
		renderBrowser();
	}

	/* ---------- Browser page ---------- */
	// Expected current major version from each release train: Chromium and Firefox ship every ~4 weeks,
	// Safari takes the year number each September (Safari 26 in 2025).
	function expected(kind) {
		var t = Date.now(), day = 864e5;
		if (kind === 'chromium') { return 132 + Math.floor((t - Date.UTC(2025, 0, 14)) / (day * 30.3)); }
		if (kind === 'firefox') { return 134 + Math.floor((t - Date.UTC(2025, 0, 7)) / (day * 28)); }
		var d = new Date(), y = d.getUTCFullYear();
		return d >= new Date(Date.UTC(y, 8, 20)) ? y - 1999 : y - 2000;
	}
	function chromiumMajor() {
		var b = nav.userAgentData && nav.userAgentData.brands, v = 0;
		(b || []).forEach(function (x) { if (/Chromium|Google Chrome/.test(x.brand)) { v = Math.max(v, parseInt(x.version, 10) || 0); } });
		return v || parseInt(ver(ua, /(?:Chrome|CriOS)\/(\d+)/), 10) || 0;
	}
	function fullVersion() {
		var list = hints.fullVersionList || [], name = info.browser, v = '';
		list.forEach(function (x) {
			if ((name === 'Microsoft Edge' && /Edge/.test(x.brand)) || (name === 'Chrome' && x.brand === 'Google Chrome') || (name === 'Opera' && /Opera/.test(x.brand))) { v = x.version; }
		});
		return v || info.version;
	}
	function upToDate() {
		var b = info.browser, major = parseInt(info.version, 10) || 0, r = { cls: '', title: '', text: '' };
		var store = info.os === 'iOS' || info.os === 'iPadOS' ? 'Settings > General > Software Update' : info.os === 'Android' ? 'the Play Store or Galaxy Store' : '';
		if (b === 'Safari' || ((info.os === 'iOS' || info.os === 'iPadOS') && info.engine === 'WebKit')) {
			var sv = parseInt(ver(ua, /Version\/(\d+)/), 10) || 0, se = expected('safari');
			if (!sv) { r.title = 'Update check not possible'; r.text = 'On iPhone and iPad every browser uses Safari\'s engine, which updates with iOS. Check Settings > General > Software Update.'; return r; }
			if (sv >= se - 1) { r.cls = 'is-ok'; r.title = 'Safari ' + sv + ' looks up to date'; r.text = 'The newest Safari is about version ' + se + '. Safari updates come with ' + (info.os === 'macOS' ? 'macOS updates (System Settings > General > Software Update).' : 'iOS updates (Settings > General > Software Update).'); }
			else { r.cls = 'is-bad'; r.title = 'Safari ' + sv + ' is out of date'; r.text = 'The newest Safari is about version ' + se + '. Install the latest ' + (info.os === 'macOS' ? 'macOS' : 'iOS') + ' update. Devices too old for it may still get security fixes for this version.'; }
			return r;
		}
		if (b === 'Firefox') {
			var fe = expected('firefox');
			if (major >= fe - 2) { r.cls = 'is-ok'; r.title = 'Firefox ' + major + ' looks up to date'; r.text = 'The newest Firefox is about version ' + fe + '. Firefox updates itself; check Menu > Help > About Firefox.'; }
			else if (major === 115 || major === 128 || major === 140 || major === 153) { r.cls = 'is-ok'; r.title = 'Firefox ' + major + ' ESR'; r.text = 'This looks like the Extended Support Release, which stays on an older version but still gets security fixes. The newest regular Firefox is about version ' + fe + '.'; }
			else { r.cls = 'is-bad'; r.title = 'Firefox ' + major + ' is out of date'; r.text = 'The newest Firefox is about version ' + fe + '. Open Menu > Help > About Firefox to update' + (store ? ', or update it from ' + store : '') + '.'; }
			return r;
		}
		if (info.engine === 'Blink' && ['Chrome', 'Microsoft Edge', 'Opera', 'Brave', 'Vivaldi'].indexOf(b) >= 0) {
			var cm = chromiumMajor(), ce = expected('chromium');
			var how = b === 'Chrome' ? 'Menu > Help > About Google Chrome' : b === 'Microsoft Edge' ? 'Settings > About Microsoft Edge' : b === 'Brave' ? 'Menu > About Brave' : b === 'Opera' ? 'Menu > Update & Recovery' : 'Help > Check for updates';
			if (store) { how = store; }
			if (cm >= ce - 2) { r.cls = 'is-ok'; r.title = b + ' looks up to date'; r.text = 'It runs on Chromium ' + cm + '; the newest is about ' + ce + '. Browsers update in the background, and a restart finishes the update.'; }
			else { r.cls = 'is-bad'; r.title = b + ' is out of date'; r.text = 'It runs on Chromium ' + cm + ', but the newest is about ' + ce + '. Old versions miss security fixes. Update it from ' + how + ', then restart it.'; }
			return r;
		}
		r.title = 'Update check not available for ' + b;
		r.text = 'This browser follows its own release schedule. Update it from ' + (store || 'its menu or the developer\'s website') + '.';
		return r;
	}
	function features() {
		var c = document.createElement('canvas'), v = document.createElement('video'), a = document.createElement('audio');
		var cs = function (q) { try { return window.CSS && CSS.supports(q); } catch (e) { return false; } };
		var play = function (el, t) { try { return !!el.canPlayType(t); } catch (e) { return false; } };
		var ls = false;
		try { localStorage.setItem('tn-br', '1'); localStorage.removeItem('tn-br'); ls = true; } catch (e) {}
		var gl2 = false;
		try { gl2 = !!c.getContext('webgl2'); } catch (e) {}
		return [
			['Cookies', nav.cookieEnabled], ['Local storage', ls], ['IndexedDB', 'indexedDB' in window], ['Service workers', 'serviceWorker' in nav],
			['WebAssembly', typeof WebAssembly === 'object'], ['WebGL 2', gl2], ['WebGPU', 'gpu' in nav], ['WebCodecs', 'VideoEncoder' in window],
			['WebRTC (video calls)', 'RTCPeerConnection' in window], ['WebSockets', 'WebSocket' in window], ['WebTransport', 'WebTransport' in window],
			['Passkeys (WebAuthn)', 'PublicKeyCredential' in window], ['Payment Request', 'PaymentRequest' in window], ['Notifications', 'Notification' in window], ['Push messages', 'PushManager' in window],
			['Web Share', !!nav.share], ['Clipboard API', !!nav.clipboard], ['File System Access', 'showOpenFilePicker' in window],
			['Camera and microphone', !!(nav.mediaDevices && nav.mediaDevices.getUserMedia)], ['Screen sharing', !!(nav.mediaDevices && nav.mediaDevices.getDisplayMedia)], ['Media recording', 'MediaRecorder' in window],
			['Speech recognition', 'SpeechRecognition' in window || 'webkitSpeechRecognition' in window], ['Text to speech', 'speechSynthesis' in window],
			['Picture-in-picture', !!document.pictureInPictureEnabled], ['Screen wake lock', 'wakeLock' in nav], ['Fullscreen', !!(document.fullscreenEnabled || document.webkitFullscreenEnabled)],
			['Gamepad API', 'getGamepads' in nav], ['Vibration', 'vibrate' in nav], ['Motion sensors', 'DeviceMotionEvent' in window], ['Geolocation', 'geolocation' in nav],
			['Web Bluetooth', 'bluetooth' in nav], ['WebUSB', 'usb' in nav], ['Web Serial', 'serial' in nav], ['WebHID', 'hid' in nav], ['Web MIDI', 'requestMIDIAccess' in nav], ['WebXR (VR and AR)', 'xr' in nav],
			['H.264 video', play(v, 'video/mp4; codecs="avc1.42E01E"')], ['HEVC (H.265) video', play(v, 'video/mp4; codecs="hvc1.1.6.L93.B0"')], ['VP9 video', play(v, 'video/webm; codecs="vp9"')], ['AV1 video', play(v, 'video/mp4; codecs="av01.0.05M.08"')],
			['Opus audio', play(a, 'audio/webm; codecs="opus"') || play(a, 'audio/ogg; codecs="opus"') || play(a, 'audio/mp4; codecs="opus"')], ['AAC audio', play(a, 'audio/mp4; codecs="mp4a.40.2"')],
			['CSS :has()', cs('selector(:has(a))')], ['CSS container queries', cs('container-type: inline-size')], ['CSS nesting', cs('selector(&)')], ['View transitions', 'startViewTransition' in document], ['Popover', typeof HTMLElement !== 'undefined' && HTMLElement.prototype.hasOwnProperty('popover')]
		];
	}
	var featCache = null;
	function renderBrowser() {
		var verdictEl = $('#br-verdict'), list = $('#br-feats');
		if (!verdictEl) { return; }
		var r = upToDate();
		verdictEl.className = 'sy-verdict ' + r.cls;
		verdictEl.querySelector('strong').textContent = r.title;
		verdictEl.querySelector('p').textContent = r.text;
		var fv = $('#br-version');
		if (fv) { fv.textContent = fullVersion() || '-'; }
		if (!list || featCache) { return; }
		featCache = features();
		var yesN = 0;
		featCache.forEach(function (f) {
			var li = document.createElement('li');
			li.textContent = f[0];
			if (!f[1]) { li.className = 'no'; } else { yesN++; }
			li.setAttribute('aria-label', f[0] + (f[1] ? ': supported' : ': not supported'));
			list.appendChild(li);
		});
		var sc = $('#br-score');
		if (sc) { sc.textContent = yesN + ' of ' + featCache.length; }
	}

	function renderPhone() {
		var head = $('#di-phone'), note = $('#di-phone-note'), cand = $('#di-candidates');
		if (!head) { return; }
		var md = model(), name = '', msg = '';
		cand.innerHTML = '';
		if (info.os === 'iOS') {
			var c = iphoneCandidates();
			name = c.length === 1 ? c[0] : 'An iPhone';
			msg = c.length > 1
				? 'Apple does not let websites read the exact model. Your screen size (' + Math.min(screen.width, screen.height) + ' x ' + Math.max(screen.width, screen.height) + ' points at ' + Math.round(window.devicePixelRatio) + 'x) matches these models. To be certain, open Settings > General > About > Model Name.'
				: c.length ? 'Matched from the screen size. Confirm in Settings > General > About > Model Name.'
				: 'Apple does not let websites read the exact model, and this screen size is not in our list. Open Settings > General > About > Model Name.';
			c.forEach(function (n) { var li = document.createElement('li'); li.textContent = n; cand.appendChild(li); });
		} else if (info.os === 'iPadOS') {
			name = 'An iPad';
			msg = 'Apple does not let websites read the iPad model. Open Settings > General > About > Model Name.';
		} else if (info.os === 'Android') {
			var sam = md ? samsungName(md) : '';
			if (sam) {
				name = sam;
				msg = 'Model code ' + md + '. The letters after the number show the region or carrier version. Confirm in Settings > About phone.';
			} else if (md) {
				name = md;
				msg = 'This is the model code your phone reports. Search it with your brand name to see the marketing name, or check Settings > About phone.';
			} else {
				name = 'An Android ' + (info.type === 'tablet' ? 'tablet' : 'phone');
				msg = nav.userAgentData
					? 'The browser did not share the model. Open Settings > About phone > Model name, or try Chrome.'
					: 'This browser hides the model (newer browsers reduce the user agent). Open this page in Chrome, or check Settings > About phone > Model name.';
			}
		} else {
			name = 'Not a phone: ' + deviceName().replace(/^Computer$/, 'a computer');
			msg = 'This page is running on ' + osLabel() + ' in ' + info.browser + '. Open it on the phone you want to identify.';
		}
		head.textContent = name;
		note.textContent = msg;
		cand.hidden = !cand.children.length;
	}

	/* ---------- Copy and parser ---------- */
	function asText() {
		var data = rows(), out = ['Device info from testnook.com', 'User agent: ' + ua, ''];
		Object.keys(data).forEach(function (k) {
			out.push('[' + TITLES[k] + ']');
			data[k].forEach(function (r) { out.push(r[0] + ': ' + r[1]); });
			out.push('');
		});
		return out.join('\n');
	}
	function copy(text, msg) {
		var done = function () { U.status(statusEl, msg, 'ok'); };
		if (nav.clipboard && nav.clipboard.writeText) {
			nav.clipboard.writeText(text).then(done, function () { U.status(statusEl, 'Copy was blocked. Select the text and copy it by hand.', 'bad'); });
		} else { U.status(statusEl, 'Copy is not available here. Select the text and copy it by hand.', 'bad'); }
	}
	var copyAll = $('#di-copy'), copyUa = $('#di-copy-ua');
	if (copyAll) { copyAll.addEventListener('click', function () { copy(asText(), 'All device info copied. Paste it into a support ticket or a message.'); }); }
	if (copyUa) { copyUa.addEventListener('click', function () { copy(ua, 'User agent copied.'); }); }

	var pin = $('#di-parse-in'), pbtn = $('#di-parse-btn'), pout = $('#di-parse-out');
	function runParse() {
		var s = pin.value.trim();
		pout.innerHTML = '';
		if (!s) { U.status(statusEl, 'Paste a user agent string first.', 'bad'); return; }
		var r = parse(s, false), name = r.model ? (samsungName(r.model) || r.model) : '';
		[['Browser', r.browser + (r.version ? ' ' + r.version : '')], ['Engine', r.engine || '-'], ['Operating system', r.os + (r.osVersion ? ' ' + r.osVersion : '')], ['Device type', r.type], ['Device', name || r.model || '-']].forEach(function (row) {
			var dt = document.createElement('dt'), dd = document.createElement('dd');
			dt.textContent = row[0];
			dd.textContent = row[1];
			pout.appendChild(dt);
			pout.appendChild(dd);
		});
		pout.hidden = false;
		U.status(statusEl, 'Parsed the pasted user agent.', 'ok');
	}
	if (pin && pbtn) {
		pbtn.addEventListener('click', runParse);
		pin.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); runParse(); } });
	}

	/* ---------- Async extras ---------- */
	render();
	var waits = [];
	if (nav.userAgentData && nav.userAgentData.getHighEntropyValues) {
		waits.push(nav.userAgentData.getHighEntropyValues(['platformVersion', 'model', 'architecture', 'bitness', 'uaFullVersion', 'fullVersionList']).then(function (h) { hints = h || {}; }, function () {}));
	}
	if (nav.getBattery) {
		waits.push(nav.getBattery().then(function (b) { extra.battery = Math.round(b.level * 100) + '%' + (b.charging ? ', charging' : ''); }, function () {}));
	}
	if (nav.storage && nav.storage.estimate) {
		waits.push(nav.storage.estimate().then(function (e) { if (e.quota) { extra.storage = (e.quota / 1073741824 >= 1 ? U.fmt(e.quota / 1073741824, 1) + ' GB' : Math.round(e.quota / 1048576) + ' MB') + ' available to sites'; } }, function () {}));
	}
	Promise.all(waits).then(render);
	refreshRate(function (hz) { extra.hz = hz; render(); });
	var resizeT = 0;
	window.addEventListener('resize', function () { clearTimeout(resizeT); resizeT = setTimeout(render, 200); });
	U.status(statusEl, 'Everything here is read by your browser on this device. Nothing is sent to a server.', '');
}());
