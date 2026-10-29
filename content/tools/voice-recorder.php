<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Online Voice Recorder',
	'seo_title'      => 'Online Voice Recorder: Record Audio Free, Download WAV',
	'description'    => 'Free online voice recorder. Record from your microphone in the browser, pause and resume, play it back and download WAV or WebM. No sign-up, nothing uploaded.',
	'intro'          => 'Record your voice straight from the browser on a computer or phone. Pause and resume in the same take, watch the live waveform, play it back and download it as a WAV or the browser\'s compact format. Recordings stay on your device; nothing is uploaded.',
	'device'         => 'media',
	'device_message' => 'This browser cannot use the microphone. Update it, or open the page in Chrome, Edge, Firefox or Safari.',
	'ads'            => 'standard',
	'styles'         => array( 'voice-recorder' ),
	'scripts'        => array( 'voice-recorder' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-stage vr-stage">
	<div class="vr-head"><span class="vr-time" id="vr-time" aria-live="off">0:00.0</span><select class="vr-select" id="vr-device" aria-label="Microphone" hidden></select></div>
	<canvas class="vr-wave" id="vr-wave" aria-hidden="true"></canvas>
	<div class="vr-level"><div class="meter"><span id="vr-meter" style="width:0%"></span></div></div>
	<div class="vr-controls">
		<button type="button" class="btn btn-primary" id="vr-rec">Record</button>
		<button type="button" class="btn" id="vr-pause" hidden>Pause</button>
		<button type="button" class="btn btn-primary" id="vr-stop" hidden>Stop and save</button>
	</div>
	<div class="vr-opts">
		<label><input type="checkbox" id="vr-ns" checked> Noise suppression and auto level</label>
		<label><input type="checkbox" id="vr-ec" checked> Echo cancellation</label>
	</div>
	<ol class="vr-list" id="vr-list" aria-label="Recordings"></ol>
	<p class="vr-empty" id="vr-empty">Your recordings will appear here.</p>
</div>
<p class="tool-status" id="vr-status" aria-live="polite">Press Record and allow the microphone.</p>',
	'howto'          => array(
		'Press <strong>Record</strong> and allow the microphone when the browser asks. If you have several microphones, pick one from the list that appears.',
		'Speak normally, about a hand\'s width from the microphone. The level bar should reach the yellow on loud words but not the red.',
		'Press <strong>Pause</strong> to stop for a moment and <strong>Resume</strong> to carry on in the same recording. The timer only counts recorded time.',
		'Press <strong>Stop and save</strong>. The take appears in the list with a player.',
		'Press <strong>Download WAV</strong> for a file that opens anywhere, or the other download button for a smaller file. Close the tab only after downloading.',
	),
	'howto_title'    => 'How to record your voice online',
	'results'        => '<p>Each recording shows its length, size and format, with two downloads:</p>
<ul>
<li><strong>WebM or M4A</strong> is what the browser recorded: Opus audio in WebM on Chrome, Edge and Firefox, AAC in M4A on Safari. About 0.5 to 1 MB per minute, ideal for sending in a message.</li>
<li><strong>WAV</strong> is uncompressed 16-bit audio that every editor, phone and computer can open, at about 5 to 10 MB per minute. Use it for editing in Audacity, a video editor or a DAW.</li>
</ul>
<p>For a clear voice, keep the level bar mostly in the green with peaks in the yellow. If it hits the red, move back or speak softer; if it barely moves, move closer or check the microphone with the <a href="/mic-test/">mic test</a>.</p>',
	'extra'          => array(
		array(
			'Getting a better recording',
			'<p>Room sound matters more than the microphone. Record in a small room with soft furnishings, away from hard walls and windows, and turn off fans. Keep the microphone at a steady distance and slightly to the side of your mouth to avoid pops on "p" and "b". A headset or earphone microphone often beats a laptop\'s built-in one because it stays close to your mouth.</p>
<p><strong>Noise suppression and auto level</strong> make speech clear for calls and voice notes. Turn them off for music or singing, where they cut quiet notes and pump the volume. <strong>Echo cancellation</strong> is only needed when a speaker is playing nearby.</p>',
			'better',
		),
		array(
			'Privacy: where your recordings go',
			'<p>Nowhere. The recorder uses your browser\'s built-in MediaRecorder, and the takes are held in the memory of this tab. They are not uploaded, stored on a server or kept after you close or reload the page, so download what you want to keep. The microphone is released when you leave the page.</p>',
			'privacy',
		),
	),
	'fixes'          => array(
		array( 'The browser does not ask for the microphone', 'The permission was blocked earlier. Click the lock or microphone icon in the address bar, allow the microphone and reload. On a phone, also check the browser is allowed to use the microphone in system settings.' ),
		array( 'The recording is silent', 'The wrong input is selected or the microphone is muted. Pick another microphone in the list, check a mute switch on a headset, and in Windows open Sound settings > Input to see the level move.' ),
		array( 'The WAV download does not start', 'Some older browsers cannot decode their own recordings. Use the WebM or M4A download and convert it with any audio app.' ),
		array( 'My recording disappeared', 'Recordings live only in the open tab. Reloading, closing the tab or the browser freeing memory on a phone removes them. Download each take as soon as you are happy with it.' ),
	),
	'faq'            => array(
		array( 'Is this online voice recorder free?', 'Yes, completely free with no sign-up, no watermark and no time limit beyond your device\'s memory.' ),
		array( 'Are my recordings uploaded?', 'No. Everything is recorded and stored in your browser tab. Nothing is sent to a server.' ),
		array( 'Can I record as MP3?', 'Browsers cannot write MP3 directly. Download the WAV, which any app can open, and convert it to MP3 if you need that format.' ),
		array( 'Does it work on iPhone and Android?', 'Yes. Use Safari on iPhone or Chrome on Android. iPhones record M4A; Android records WebM. Both can also be downloaded as WAV.' ),
		array( 'How long can I record?', 'There is no set limit. A long recording uses memory in the tab, so for more than an hour, record in parts and download each one.' ),
		array( 'Can I record system sound or a call?', 'No, only a microphone. Browsers do not let a page record other apps\' sound through this recorder.' ),
	),
	'related'        => array( 'mic-test', 'headphone-test', 'sound-test', 'guitar-tuner', 'speaker-cleaner', 'webcam-test' ),
	'updated'        => '2026-10-29',
);
