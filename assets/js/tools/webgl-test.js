/* WebGL test: WebGL 1/2 support, GPU name and graphics API from the (ANGLE) renderer string, hardware acceleration
   verdict, limits and extensions, WebGPU adapter details, and a fragment-shader benchmark in three load stages
   (throughput = pixels x shader iterations x frames per second). */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="webgl-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };
	var statusEl = $('#gl-status');
	var SOFTWARE = /swiftshader|llvmpipe|softpipe|software|basic render|microsoft basic/i;

	function dl(el, rows) {
		el.innerHTML = '';
		rows.forEach(function (r) {
			var dt = document.createElement('dt'), dd = document.createElement('dd');
			dt.textContent = r[0];
			dd.textContent = r[1];
			el.appendChild(dt);
			el.appendChild(dd);
		});
	}
	function verdict(el, cls, title, text) {
		el.className = 'sy-verdict ' + cls;
		el.querySelector('strong').textContent = title;
		el.querySelector('p').textContent = text;
	}

	// "ANGLE (NVIDIA, NVIDIA GeForce RTX 3060 (0x00002504) Direct3D11 vs_5_0 ps_5_0, D3D11)" -> name + API.
	function parseRenderer(r) {
		var out = { name: r || 'Unknown', api: '' };
		var m = /^ANGLE \((.*)\)$/.exec(r || '');
		if (m) {
			var parts = m[1].split(', '), dev = parts[1] || parts[0];
			var vk = /^Vulkan [\d.]+ \((.*)\)$/.exec(dev);
			if (vk) { dev = vk[1]; }
			dev = dev.replace(/\s*\(0x[0-9a-f]+\)/i, '').replace(/\s*(Direct3D\d+.*|OpenGL.*|Vulkan.*)$/i, '').replace(/^ANGLE Metal Renderer: /, '');
			out.name = dev.trim() || r;
			var tail = m[1];
			out.api = /D3D11|Direct3D11/.test(tail) ? 'Direct3D 11' : /D3D9/.test(tail) ? 'Direct3D 9' : /Vulkan/i.test(tail) ? 'Vulkan' : /Metal/i.test(tail) ? 'Metal' : /OpenGL ES/i.test(tail) ? 'OpenGL ES' : /OpenGL/i.test(tail) ? 'OpenGL' : '';
		}
		out.name = out.name.replace(/, or similar$/, '');
		return out;
	}

	/* ---------- WebGL info ---------- */
	var c = document.createElement('canvas'), gl2 = null, gl1 = null;
	try { gl2 = c.getContext('webgl2'); } catch (e) {}
	try { gl1 = gl2 || document.createElement('canvas').getContext('webgl') || document.createElement('canvas').getContext('experimental-webgl'); } catch (e) {}
	var gl = gl2 || gl1, info = {};
	if (gl) {
		var dbg = gl.getExtension('WEBGL_debug_renderer_info');
		info.renderer = dbg ? gl.getParameter(dbg.UNMASKED_RENDERER_WEBGL) : gl.getParameter(gl.RENDERER);
		info.vendor = dbg ? gl.getParameter(dbg.UNMASKED_VENDOR_WEBGL) : gl.getParameter(gl.VENDOR);
		info.parsed = parseRenderer(String(info.renderer));
		var aniso = gl.getExtension('EXT_texture_filter_anisotropic') || gl.getExtension('WEBKIT_EXT_texture_filter_anisotropic');
		var vp = gl.getParameter(gl.MAX_VIEWPORT_DIMS), lw = gl.getParameter(gl.ALIASED_LINE_WIDTH_RANGE), attrs = gl.getContextAttributes() || {};
		info.limits = [
			['WebGL version', String(gl.getParameter(gl.VERSION))],
			['Shading language', String(gl.getParameter(gl.SHADING_LANGUAGE_VERSION))],
			['Max texture size', gl.getParameter(gl.MAX_TEXTURE_SIZE) + ' px'],
			['Max cube map size', gl.getParameter(gl.MAX_CUBE_MAP_TEXTURE_SIZE) + ' px'],
			['Max renderbuffer size', gl.getParameter(gl.MAX_RENDERBUFFER_SIZE) + ' px'],
			['Max viewport', vp ? vp[0] + ' x ' + vp[1] : '-'],
			['Texture units (fragment)', String(gl.getParameter(gl.MAX_TEXTURE_IMAGE_UNITS))],
			['Texture units (total)', String(gl.getParameter(gl.MAX_COMBINED_TEXTURE_IMAGE_UNITS))],
			['Vertex attributes', String(gl.getParameter(gl.MAX_VERTEX_ATTRIBS))],
			['Vertex uniform vectors', String(gl.getParameter(gl.MAX_VERTEX_UNIFORM_VECTORS))],
			['Fragment uniform vectors', String(gl.getParameter(gl.MAX_FRAGMENT_UNIFORM_VECTORS))],
			['Varying vectors', String(gl.getParameter(gl.MAX_VARYING_VECTORS))],
			['Max anisotropy', aniso ? gl.getParameter(aniso.MAX_TEXTURE_MAX_ANISOTROPY_EXT) + 'x' : 'Not supported'],
			['Line width range', lw ? lw[0] + ' - ' + lw[1] : '-'],
			['Antialiasing', attrs.antialias ? 'Yes' : 'No']
		];
		if (gl2) {
			info.limits.push(['Max MSAA samples', String(gl2.getParameter(gl2.MAX_SAMPLES))]);
			info.limits.push(['Max 3D texture size', gl2.getParameter(gl2.MAX_3D_TEXTURE_SIZE) + ' px']);
			info.limits.push(['Max draw buffers', String(gl2.getParameter(gl2.MAX_DRAW_BUFFERS))]);
		}
		info.ext = (gl.getSupportedExtensions() || []).slice().sort();
	}

	var soft = gl && SOFTWARE.test(String(info.renderer));
	$('#gl-name').textContent = gl ? info.parsed.name : 'WebGL is not available';
	$('#gl-sub').textContent = gl ? (info.vendor + (info.parsed.api ? ' · ' + info.parsed.api : '')) : 'This browser or device cannot draw 3D graphics.';
	dl($('#gl-summary'), [
		['WebGL 1', gl1 ? 'Supported' : 'Not supported'],
		['WebGL 2', gl2 ? 'Supported' : 'Not supported'],
		['WebGPU', 'gpu' in navigator ? 'Checking...' : 'Not supported'],
		['Graphics card (GPU)', gl ? info.parsed.name : '-'],
		['Raw renderer string', gl ? String(info.renderer) : '-'],
		['Graphics API used', gl && info.parsed.api ? info.parsed.api : gl ? 'Not reported' : '-'],
		['Hardware acceleration', !gl ? '-' : soft ? 'Off (software rendering)' : 'On']
	]);
	if (!gl) {
		verdict($('#gl-verdict'), 'is-bad', 'WebGL does not work here', 'Turn on hardware acceleration in the browser settings, update the graphics driver and the browser, and make sure WebGL is not blocked by an extension or a work policy.');
	} else if (soft) {
		verdict($('#gl-verdict'), 'is-warn', 'WebGL works, but without your graphics card', 'The browser is drawing with the CPU (' + info.parsed.name + '). 3D sites, maps and games will be slow. Turn on hardware acceleration in the browser settings and update the graphics driver.');
	} else {
		verdict($('#gl-verdict'), 'is-ok', 'WebGL ' + (gl2 ? '2' : '1') + ' works with hardware acceleration', 'The browser draws 3D graphics on ' + info.parsed.name + '. Run the benchmark below to see how fast.');
	}
	if (gl) {
		dl($('#gl-limits'), info.limits);
		var ul = $('#gl-ext');
		info.ext.forEach(function (e) { var li = document.createElement('li'); li.textContent = e; ul.appendChild(li); });
		$('#gl-ext-n').textContent = String(info.ext.length);
	}

	/* ---------- WebGPU ---------- */
	function setGpuRow(v) {
		U.$$('#gl-summary dt', root).forEach(function (dt) { if (dt.textContent === 'WebGPU') { dt.nextSibling.textContent = v; } });
	}
	if ('gpu' in navigator) {
		Promise.resolve().then(function () { return navigator.gpu.requestAdapter(); }).then(function (a) {
			if (!a) { setGpuRow('Available, but no adapter (blocked or unsupported GPU)'); return; }
			var i = a.info || {};
			setGpuRow('Supported' + (a.isFallbackAdapter || (i && i.isFallbackAdapter) ? ' (software fallback)' : ''));
			var L = a.limits || {};
			dl($('#gl-gpu'), [
				['Vendor', i.vendor || 'Not shared'],
				['Architecture', i.architecture || 'Not shared'],
				['Device', i.device || i.description || 'Not shared'],
				['Features', String(a.features ? a.features.size : 0)],
				['Max texture 2D', L.maxTextureDimension2D ? L.maxTextureDimension2D + ' px' : '-'],
				['Max buffer size', L.maxBufferSize ? Math.round(L.maxBufferSize / 1048576) + ' MB' : '-'],
				['Max compute invocations', L.maxComputeInvocationsPerWorkgroup ? String(L.maxComputeInvocationsPerWorkgroup) : '-'],
				['Shader f16', a.features && a.features.has('shader-f16') ? 'Yes' : 'No']
			]);
			$('#gl-gpu-wrap').hidden = false;
		}).catch(function () { setGpuRow('Available, but the adapter request failed'); });
	}

	/* ---------- Benchmark ---------- */
	var bc = $('#gl-canvas'), bgl = null, prog = null, uT, uN, uR, running = false;
	var VS = 'attribute vec2 p;void main(){gl_Position=vec4(p,0.,1.);}';
	var FS = 'precision highp float;uniform float t;uniform float n;uniform vec2 r;' +
		'void main(){vec2 uv=(gl_FragCoord.xy*2.-r)/r.y;vec3 col=vec3(0.);float a=0.;' +
		'for(int i=0;i<512;i++){if(float(i)>=n)break;float f=float(i)/n;' +
		'vec2 q=uv*(1.2+f)+vec2(sin(t*.7+f*6.28),cos(t*.5+f*3.14));' +
		'a+=.012/abs(length(q)-.5+.2*sin(t+f*12.));col+=a*vec3(.2+.8*f,.4,.9-.6*f)*.01;}' +
		'gl_FragColor=vec4(1.-exp(-col*4.),1.);}';

	function setup() {
		if (bgl) { return true; }
		try { bgl = bc.getContext('webgl', { antialias: false, preserveDrawingBuffer: false }); } catch (e) { bgl = null; }
		if (!bgl) { return false; }
		function sh(type, src) { var s = bgl.createShader(type); bgl.shaderSource(s, src); bgl.compileShader(s); return s; }
		prog = bgl.createProgram();
		bgl.attachShader(prog, sh(bgl.VERTEX_SHADER, VS));
		bgl.attachShader(prog, sh(bgl.FRAGMENT_SHADER, FS));
		bgl.linkProgram(prog);
		if (!bgl.getProgramParameter(prog, bgl.LINK_STATUS)) { return false; }
		bgl.useProgram(prog);
		var buf = bgl.createBuffer();
		bgl.bindBuffer(bgl.ARRAY_BUFFER, buf);
		bgl.bufferData(bgl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), bgl.STATIC_DRAW);
		var loc = bgl.getAttribLocation(prog, 'p');
		bgl.enableVertexAttribArray(loc);
		bgl.vertexAttribPointer(loc, 2, bgl.FLOAT, false, 0, 0);
		uT = bgl.getUniformLocation(prog, 't');
		uN = bgl.getUniformLocation(prog, 'n');
		uR = bgl.getUniformLocation(prog, 'r');
		return true;
	}
	function size() {
		var dpr = Math.min(2, window.devicePixelRatio || 1);
		bc.width = Math.round(bc.clientWidth * dpr);
		bc.height = Math.round(bc.clientHeight * dpr);
		bgl.viewport(0, 0, bc.width, bc.height);
	}
	function frame(t, n) {
		bgl.uniform1f(uT, t / 1000);
		bgl.uniform1f(uN, n);
		bgl.uniform2f(uR, bc.width, bc.height);
		bgl.drawArrays(bgl.TRIANGLES, 0, 3);
	}

	/* Draw the full-screen pass K times per frame, doubling K while the frame rate stays above 40 fps, so the
	   result is not capped by the screen's refresh rate; then measure 2.5 s at that load. */
	var STEPS = 256;
	function bench() {
		if (!setup()) { U.status(statusEl, 'The benchmark needs WebGL, which is not available here.', 'bad'); return; }
		running = true;
		$('#gl-bench').disabled = true;
		$('#gl-bench-wrap').hidden = false;
		['gl-k', 'gl-fps', 'gl-thr', 'gl-score', 'gl-tier'].forEach(function (id) { $('#' + id).textContent = '-'; });
		size();
		var k = 1, phase = 'ramp', w0 = 0, frames = 0, px = bc.width * bc.height;
		function loop(t) {
			if (!running) { return; }
			for (var i = 0; i < k; i++) { frame(t, STEPS); }
			if (!w0) { w0 = t; frames = 0; requestAnimationFrame(loop); return; }
			frames++;
			var el = t - w0, fps = frames / (el / 1000);
			$('#gl-live').textContent = (phase === 'ramp' ? 'Finding the load: ' : 'Measuring: ') + k + ' passes per frame, ' + Math.round(fps) + ' fps';
			if (phase === 'ramp' && el >= 400) {
				if (fps > 40 && k < 512) { k *= 2; w0 = 0; }
				else { phase = 'measure'; w0 = 0; }
			} else if (phase === 'measure' && el >= 2500) {
				finish(k, fps, px * STEPS * k * fps / 1e9);
				return;
			}
			requestAnimationFrame(loop);
		}
		U.status(statusEl, 'Running the benchmark for about 5 seconds. Keep this tab in front.', '');
		requestAnimationFrame(loop);
	}
	function finish(k, fps, thr) {
		running = false;
		$('#gl-bench').disabled = false;
		$('#gl-bench').textContent = 'Run again';
		var score = Math.round(thr * 100);
		$('#gl-k').textContent = String(k);
		$('#gl-fps').textContent = fps.toFixed(fps < 10 ? 1 : 0);
		$('#gl-thr').textContent = thr.toFixed(thr < 10 ? 2 : 1) + ' G';
		$('#gl-score').textContent = String(score);
		var tier = score >= 15000 ? 'Gaming graphics card' : score >= 5000 ? 'Strong: recent laptop GPU, Apple M chip or flagship phone' : score >= 1500 ? 'Mid-range: modern integrated graphics or a good phone' : score >= 300 ? 'Entry level: older integrated graphics or a budget phone' : 'Very slow: software rendering or a very old GPU';
		$('#gl-tier').textContent = tier;
		$('#gl-live').textContent = 'Done';
		U.status(statusEl, 'Benchmark done: score ' + score + ' (' + tier.split(':')[0].toLowerCase() + ').', 'ok');
	}
	$('#gl-bench').addEventListener('click', function () { if (!running) { bench(); } });
	bc.addEventListener('webglcontextlost', function (e) { e.preventDefault(); running = false; bgl = null; $('#gl-bench').disabled = false; U.status(statusEl, 'The graphics driver reset during the test. The heavy stage may be too much for this GPU.', 'bad'); });

	U.status(statusEl, gl ? 'Graphics details read. Press Run benchmark to measure speed.' : 'WebGL is not available in this browser.', gl ? '' : 'bad');
}());
