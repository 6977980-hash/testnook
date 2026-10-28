# Phase 2 handoff: tools 1-8

Date: 28 Oct 2026. Branch `claude/project-thread-f18hlh`, merged to `main`.

## What was built

Eight live tool pages, each with `content/tools/<slug>.php` (title, SEO title,
meta description, intro, how-to, results, extra sections, 3-4 fixes, 6 FAQs,
related list, updated date), `assets/js/tools/<slug>.js` (IIFE, bails when
`[data-tool="<slug>"]` is absent) and `assets/css/tools/<slug>.css` (inlined).

| Tool | Ads | Device | Notes |
|---|---|---|---|
| `/speaker-cleaner/` | standard | any | Web Audio 165 Hz sine, soft 2 s ramp, volume slider, modes: tone / pulse (2 Hz gate) / sweep (120-300 Hz); 30 s / 1 / 2 min timer; stops when the page is hidden. |
| `/webcam-test/` | standard | media | getUserMedia preview, camera picker (shown when 2+ cameras), requested resolution 4K/1080p/720p/480p, live fps via `requestVideoFrameCallback` (falls back to track settings), mirror toggle, PNG snapshot (object URL download), fullscreen. |
| `/mouse-tester/` | standard | desktop | Buttons 0-4 + wheel up/down light up and count. Context menu, autoscroll and back/forward are blocked inside the stage. Taps count as left clicks on touch. |
| `/dead-pixel-test/` | none | any | Fixed full-window overlay + Fullscreen API (pseudo-fullscreen on iPhone). 9 colours; click/tap/arrows advance, Esc exits, optional 3 s auto-advance, cursor hides after 1.5 s. |
| `/stuck-pixel-fixer/` | none | any | Photosensitivity warning + consent checkbox gates the buttons. Draggable (Pointer Events) flashing box, size 40-400 px, fast (every frame) or gentle (10 Hz), whole-screen mode, auto-stop 10-60 min. `disclaimer` set. |
| `/fps-test/` | standard | any | rAF counter: live FPS, average, min/max, frame time, dropped frames (>1.5x), likely refresh rate (nearest of 30/60/75/90/120/144/165/240/360), frame-time graph, three lanes (every frame / 30 / 15 fps). |
| `/sound-test/` | standard | any | Web Audio only, no audio files: left / right / stereo (StereoPanner), 60 Hz, 1 kHz, 8 kHz, 20 Hz-20 kHz sweep, white noise, L→R pan, 12-bar synthesised music clip. Per-channel level meters via AnalyserNodes. |
| `/double-click-test/` | content | desktop | Times the gap between `mousedown` events for the chosen button; a gap under the threshold (30-150 ms, default 80) counts as a faulty double. Bar timeline, min gap. |

Nothing in the theme core changed except these new files; `inc/`, templates and
`main.css` are untouched. Homepage and the "Related tools" lists now show the 8
live tools; the other 24 remain "Coming soon".

## Tested

Local WordPress 6.9 on SQLite (installed via Composer: `johnpbloch/wordpress-core`
+ `wpackagist-plugin/sqlite-database-integration`, theme symlinked, served with
`php -S` + router). Playwright script over all 8 pages at 1280px and iPhone 13
(light + dark), with a fake camera: every page is 200, `<title>` 44-59 chars,
meta description 153-163 chars, 570-680 words of prose, 6 FAQs, 7 related cards,
one valid JSON-LD graph, tool script enqueued, no console errors or warnings,
no horizontal scroll. Interactions verified: speaker tone starts/stops and
switches mode; webcam shows resolution + fps and makes a snapshot; mouse counts
L/R/M + wheel both ways; dead pixel starts black, arrow → white, Esc closes;
stuck pixel box appears and whole-screen mode runs; fps shows a number and a Hz
guess; sound buttons go active; double click counts 7 clicks and flags 1 fast
pair. Embed mode still noindex.

Not testable headless: real audio output, real camera on phones, iPhone Safari
pseudo-fullscreen. Ali should try `/speaker-cleaner/`, `/sound-test/` and
`/dead-pixel-test/` on a real phone after the deploy.

## Decisions

- Sound test is fully synthesised (no MP3), so the page stays under 100 KB and
  needs no media hosting. If a "real music" clip is wanted later, add a short
  CC0 file under `assets/audio/` and a button that plays it.
- Stuck pixel fixer requires an explicit consent tick before anything flashes
  (AdSense/accessibility safety). Keep this pattern for burn-in and any other
  flashing tool.
- Mouse tests use `device => desktop`; the warning text links to the touch
  screen test only in words because that page is not built yet. When
  `/touch-screen-test/` ships (Phase 3), change the `device_message` in
  `mouse-tester.php` and `double-click-test.php` to link to it.
- Copy on several pages mentions "coming soon" tools in words (refresh rate,
  headphone, camera, touch screen, DPI, polling rate). Links were only added
  for tools that exist, plus `/headphone-test/`, `/hearing-frequency-test/` and
  `/touch-screen-test/` in sound-test / mouse-tester prose; those resolve once
  Phase 3 lands (WordPress 404s until then, which is acceptable for a few days,
  but Phase 3 should ship them early).

## Ali's steps after this merge

Nothing new. If the theme was already activated and permalinks set after
Phase 1, the 8 tool pages appear on the first visit after Hostinger deploys
(the sync runs on the first request). Check `/speaker-cleaner/` and the homepage.

## What Phase 3 should do

Build tools 9-16 from the master plan, in order:
`refresh-rate-test`, `headphone-test`, `touch-screen-test`, `online-mirror`,
`stick-drift-test`, `gamepad-tester`, `mic-test`, `keyboard-tester`.

Same recipe as Phase 2 (see Phase 1 handoff for the per-tool checklist):

1. `content/tools/<slug>.php` per `docs/content-format.md`; `assets/js/tools/<slug>.js`;
   optional `assets/css/tools/<slug>.css`.
2. Ads: `none` for refresh-rate-test if it uses a full-screen surface (it should:
   it is mostly a moving pattern), `content` for keyboard-tester (typing area),
   `standard` for the rest.
3. Device: `touch` for touch-screen-test, `gamepad` for stick-drift-test and
   gamepad-tester, `media` for online-mirror and mic-test, `desktop` for
   keyboard-tester.
4. Reuse: `fps-test.js` has the rAF counter and Hz guess (refresh-rate-test
   can share the approach with a UFO-style moving bar); `sound-test.js` has the
   channel/tone/sweep helpers (headphone-test adds bass 20-200 Hz and a
   binaural/phase check); `webcam-test.js` has the getUserMedia flow
   (online-mirror = same with mirror on, no stats, freeze button; mic-test =
   audio getUserMedia + AnalyserNode level meter + MediaRecorder playback).
5. Hearing-related pages set `'disclaimer'` (see stuck-pixel-fixer for the pattern).
6. After touch-screen-test exists, update the two `device_message` strings noted above.
7. Test with the same Playwright script (desktop + iPhone 13, console, scroll,
   JSON-LD), then merge to `main` and write `docs/handoff/phase-3.md`.

Local test setup (recreate in a new session, no downloads outside Composer):
`composer require johnpbloch/wordpress-core wp-cli/wp-cli-bundle`, add the
wpackagist repo and `composer require wpackagist-plugin/sqlite-database-integration`,
copy `wordpress-core` to a site dir, copy the plugin into `wp-content/plugins/`,
copy its `db.copy` to `wp-content/db.php` and fill in the two placeholders,
symlink this repo to `wp-content/themes/testnook`, write a minimal
`wp-config.php` (any DB constants, `WP_HOME`/`WP_SITEURL` = `http://127.0.0.1:8080`),
run `php vendor/wp-cli/wp-cli/php/boot-fs.php core install ...`, `theme activate testnook`,
`rewrite structure '/%postname%/'`, then `php -S 127.0.0.1:8080 router.php` where the
router serves real files and sends everything else to `index.php`.
Launch Chromium with `--use-fake-ui-for-media-stream --use-fake-device-for-media-stream`
for camera/mic tools.
