<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Audio, Speaker & Mic Tests',
	'seo_title'   => 'Audio Tests & Tools: Speaker, Mic, Tuner, Metronome (Free)',
	'description' => 'Free online audio tests and tools. Check speakers, headphones and mic, clean a phone speaker, generate tones, test hearing, tune a guitar, keep time with a metronome.',
	'intro'       => 'Test every part of your sound setup in the browser: speaker and headphone channel checks, a microphone test with recording and playback, a water-ejecting speaker cleaner, a tone generator and a hearing frequency test. Musicians get a guitar tuner, a metronome and a tap BPM counter. Nothing is uploaded.',
	'body'        => '<h2>Which audio test do you need?</h2>
<p>No sound, or sound from only one side? The <a href="/sound-test/">sound test</a> plays tones through the left, right and both channels so you can tell a dead speaker from a balance setting. The <a href="/headphone-test/">headphone test</a> adds a left-right pan, a bass sweep and a polarity check for earphones and headsets.</p>
<p>For a speaker system, the <a href="/stereo-test/">stereo test</a> checks the left, right and phantom centre, pans a sound across and has a balance tone to find the true middle. The <a href="/mono-test/">mono test</a> tells you in two steps whether your output is mono or stereo, and the <a href="/bass-test/">bass test</a> plays 20 to 200 Hz tones, sweeps down to find how low a subwoofer or headphones really go, and checks for rattles.</p>
<p>People cannot hear you on calls? Run the <a href="/mic-test/">mic test</a>. It shows a live level meter, records a short sample and plays it back, so you hear exactly what others hear. To record longer takes and download them as WAV, use the <a href="/voice-recorder/">online voice recorder</a>. If your phone sounds muffled after rain or a swim, the <a href="/speaker-cleaner/">speaker cleaner</a> plays a low tone that pushes water and dust out of the speaker grille.</p>
<p>The <a href="/tone-generator/">tone generator</a> produces sine, square, triangle and sawtooth waves at any frequency for testing speakers, tuning or finding a rattle. The <a href="/hearing-frequency-test/">hearing frequency test</a> steps through high frequencies with headphones on and tells you the highest you can hear, with a note on what is typical for each age.</p>

<h2>Tools for musicians</h2>
<p>The <a href="/guitar-tuner/">online guitar tuner</a> listens through your microphone and shows the note, the cents sharp or flat and a needle, with presets for guitar, drop D, bass and ukulele and a chromatic mode for anything else. The <a href="/metronome/">online metronome</a> keeps a sample-accurate click from 20 to 300 BPM with time signatures, subdivisions and tap tempo. The <a href="/tap-bpm/">tap BPM counter</a> works the other way round: tap along to a song and it tells you the tempo.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>A dead channel:</strong> sound from one side only. A balance setting, a half-inserted plug or a broken speaker.</li>
<li><strong>Swapped channels:</strong> left plays on the right. Usually headphones worn backwards or a driver setting.</li>
<li><strong>A quiet or silent microphone:</strong> wrong input device selected, a muted mic, or a privacy setting blocking the browser.</li>
<li><strong>Distortion and rattles:</strong> a buzz at certain frequencies in the tone generator points to a loose grille or a damaged driver.</li>
<li><strong>Reduced high-frequency hearing:</strong> expected with age; a sudden change in one ear is worth a professional check.</li>
</ul>

<h2>Before you blame the hardware</h2>
<p>Check the output and input device the browser is using, because a laptop with Bluetooth headphones nearby often sends sound to the wrong place. Unmute the microphone in the system settings and allow the browser to use it when asked. Start every test at a low volume, especially with earphones, and raise it slowly.</p>

<h2>A note on hearing tests</h2>
<p>The hearing frequency test depends on your headphones and volume and is not a medical test. It can show that one ear hears less than the other or that you have lost the top of your range, but a real audiogram is done by an audiologist with calibrated equipment.</p>',
	'faq'         => array(
		array( 'Why do I hear nothing at all?', 'Check the volume and mute on both the system and the page, then confirm the browser is sending sound to the device you expect in the sound settings. Some browsers block sound until you click on the page, so press a test button first.' ),
		array( 'Is my microphone recorded or uploaded?', 'No. The mic test runs in your browser. The playback sample is held in memory only, is never sent to a server and is gone when you close the page.' ),
		array( 'Does the speaker cleaner really remove water?', 'It helps with light moisture and dust: the low-frequency tone vibrates the speaker membrane and pushes droplets out of the grille. It cannot dry a phone that was fully submerged. Keep the phone speaker-side down and repeat a few times.' ),
		array( 'Which test should I use for a headset mic?', 'Use the mic test and pick the headset in the microphone list. Record a sample and play it back. If the headset has a mute switch on the cable, check that first; it is the most common cause of a silent headset mic.' ),
		array( 'What frequency should I be able to hear?', 'Most people under 30 hear up to around 17 to 19 kHz. The top of the range falls with age, so 14 to 16 kHz is typical in the 40s and 50s. Cheap earphones also roll off the highest frequencies, so test with the best headphones you have.' ),
		array( 'Can loud test tones damage my speakers or ears?', 'Loud tones at any frequency can damage small speakers and your hearing. Every tool starts at a safe level. Raise the volume gradually, stop if you hear distortion, and never run a tone at full volume through earphones.' ),
	),
	'updated'     => '2026-10-29',
	'ads'         => 'standard',
);
