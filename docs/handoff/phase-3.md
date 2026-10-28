# Phase 3 handoff: tools 9-16

Date: 28 Oct 2026. Branch `claude/project-thread-rk4gzp`, merged to `main`.

## What was built

Eight more live tool pages, same recipe as Phase 2: `content/tools/<slug>.php`,
`assets/js/tools/<slug>.js` (IIFE, bails when `[data-tool="<slug>"]` is absent)
and `assets/css/tools/<slug>.css` (inlined).

| Tool | Ads | Device | Notes |
|---|---|---|---|
| `/refresh-rate-test/` | content | any | Median rAF interval over the last 240 frames -> exact Hz + nominal (24-500 Hz list), frame time, jitter (SD), skipped frames; three saucers (every refresh / every 2nd / 30 Hz), 16-cell frame strip, slow/medium/fast, fullscreen. Not `none`: the page has text around a canvas, not a bare colour surface. |
| `/headphone-test/` | standard | any | Web Audio via a ChannelMerger (hard L / centre / R routing), L<->R pan, bass 30/50/80/120 Hz + 20-200 Hz sweep, in-phase vs out-of-phase brown noise (polarity check), 20 Hz-20 kHz sweep, L/R meters, volume slider default 35%. `disclaimer` set (hearing). |
| `/touch-screen-test/` | content | touch | Pointer Events multi-touch drawing (one colour + number per finger, coalesced events), live rings, max simultaneous touches, input type; Grid mode (fine 28 px / coarse 48 px cells) fills squares green and shows % coverage; fullscreen for edges. |
| `/online-mirror/` | standard | media | getUserMedia front camera, mirrored by default (toggle), zoom 1-3x and brightness 60-180% via CSS transform/filter, white "ring light" frame, freeze to canvas, Save photo (PNG, applies mirror/zoom/brightness), camera picker, fullscreen. |
| `/stick-drift-test/` | standard | gamepad | Both sticks drawn live with trail, adjustable dead zone ring, "Check drift": 3 s countdown + 3 s resting measurement -> % at rest per stick (green <5%, amber <12%, red) and a suggested dead zone; outer range (circularity) trace from 72 angle bins; controller picker. |
| `/gamepad-tester/` | standard | gamepad | Standard-mapping diagram (18 buttons, analog LT/RT bars, sticks with XY); labels switch to PlayStation / Nintendo symbols from the id; buttons go green once tested; raw buttons/axes list; `vibrationActuator` rumble test; multi-controller picker. |
| `/mic-test/` | standard | media | Audio getUserMedia + AnalyserNode: RMS dBFS meter with peak-hold marker and clip flag, waveform / log-spaced spectrum canvas, echo cancellation / noise suppression / auto gain toggles (restart the stream), MediaRecorder sample 5/10/20 s with `<audio>` playback + download, mic picker. |
| `/keyboard-tester/` | content | desktop | Full size (104) / TKL (87) / 60% (61) layouts built from `e.code`; keys light while held and stay green; held-now and max-at-once (rollover); key / code / keyCode; typing textarea; most keys `preventDefault` (F5, F11, F12, Ctrl+C/V/A/X/Z and Meta pass through). Touch devices default to the 60% layout. |

Also changed: `mouse-tester.php` and `double-click-test.php` `device_message`
now link to `/touch-screen-test/`; `fps-test.php` links to `/refresh-rate-test/`
instead of "coming soon". Theme core (`inc/`, templates, `main.css`) untouched.
16 of 32 tools are live; the other 16 remain "Coming soon".

## Tested

Local WordPress 6.9 on SQLite via Composer (see setup below). Playwright over
all 8 pages at 1280 px (light + dark) and iPhone 13, with fake camera/mic:
every page 200, `<title>` 54-58 chars, meta description 152-160 chars, 6 FAQs,
8 related cards, valid JSON-LD, tool script enqueued, no console errors or
warnings, no horizontal page scroll, embed mode noindex. Interactions verified:
refresh rate reports 60 Hz / 60.00 Hz; headphone buttons activate and stop;
touch draw + grid coverage counts; mirror starts, freezes, ring light toggles;
mic detects sound, records 5 s and plays back; keyboard counts keys, held = 3,
layout switch; gamepad pages show the "no controller" state correctly
(Playwright has no gamepad emulation).

Not testable headless: real controllers (stick drift + gamepad tester), real
multi-touch, real headphones. Ali should try `/gamepad-tester/` and
`/stick-drift-test/` with a controller in Chrome, and `/touch-screen-test/` and
`/online-mirror/` on a phone after the deploy.

## Decisions

- Refresh rate test uses `ads => content` (not `none`): it is a normal text page
  with a canvas, so one slot below the tool would sit next to moving objects but
  the in-content and after-FAQ slots are fine. Change to `none` if AdSense
  policy review flags it.
- The gamepad diagram uses the W3C standard mapping indexes 0-17 only; extra
  buttons (paddles, touchpad on some pads) appear in the raw list, which is
  always complete.
- Recent Chromium applies `justify-items` from `.tool-stage` (grid) to block
  children even after `display: block` is set on the same element, so block-
  layout stages set `place-items: normal` (`.tool-stage.<x>-stage`). Reuse that
  for any future tool that overrides the stage to `display: block`.
- Mic test defaults to the browser's processing on (echo cancellation, noise
  suppression, auto gain) because that is what calls use; the toggles restart
  the stream.
- Keyboard tester never blocks F5/F11/F12/Ctrl+C-V-A-X-Z/Meta so the browser
  stays usable; everything else is `preventDefault`ed inside the tool.

## Ali's steps after this merge

Nothing new. The 8 pages appear on the first visit after Hostinger deploys
(the sync runs on the first request). Check `/keyboard-tester/`, `/mic-test/`
and the homepage.

## What Phase 4 should do

Per the master plan, Phase 4 is the SEO layer; if the plan is instead to keep
shipping tools, the next 8 in catalog order are: `reaction-time-test`,
`cps-test`, `spacebar-clicker`, `white-screen`, `black-screen`,
`tone-generator`, `dpi-analyzer`, `online-ruler`.

Same recipe (Phase 1 handoff checklist, Phase 2 notes). Specifics:

1. Ads: `none` for white-screen and black-screen (full colour surfaces);
   `content` for reaction-time-test, cps-test and spacebar-clicker (click/press
   areas); `standard` for tone-generator, dpi-analyzer, online-ruler.
2. Device: `desktop` for dpi-analyzer, cps-test and spacebar-clicker
   (`device_message` links to `/touch-screen-test/`); `any` for the rest.
3. Reuse: `dead-pixel-test.js` has the fullscreen colour overlay for the
   white/black screens; `sound-test.js` / `headphone-test.js` have the
   oscillator + envelope helpers for tone-generator (add wave type, frequency
   input, slider, and a hearing disclaimer); `double-click-test.js` has the
   timing pattern for reaction time; `keyboard-tester.js` the keydown handling
   for spacebar-clicker; `mouse-tester.js` the stage for dpi-analyzer (count
   `movementX` over a known physical distance; `online-ruler` needs a
   calibration step with a card or coin and stores the px/mm in localStorage).
4. tone-generator and hearing-related pages set `'disclaimer'`.
5. Dedicated controller pages (ps5/xbox/ps4) later can reuse
   `gamepad-tester.js` with a `LABELS` default per page.
6. Test with the same Playwright script (desktop + iPhone 13, console, scroll,
   JSON-LD, meta lengths), merge to `main`, write `docs/handoff/phase-4.md`.

Local test setup (worked this phase, ~5 min): in an empty dir,
`composer init -n`, add repo `https://wpackagist.org` (type composer), set
`allow-plugins` for `composer/installers` and `johnpbloch/wordpress-core-installer`,
`composer require johnpbloch/wordpress-core wp-cli/wp-cli-bundle wpackagist-plugin/sqlite-database-integration`
(the proxy sometimes aborts GitHub zips; a second `composer install` finishes).
Then `cp -r vendor/johnpbloch/wordpress-core site`, copy the plugin into
`site/wp-content/plugins/`, `sed` its `db.copy` placeholders into
`site/wp-content/db.php`, symlink this repo to `site/wp-content/themes/testnook`,
write a minimal `wp-config.php` (`WP_HOME`/`WP_SITEURL` = `http://127.0.0.1:8080`),
`php vendor/wp-cli/wp-cli/php/boot-fs.php --path=site --allow-root core install ...`
(email must be valid, e.g. admin@example.com), `theme activate testnook`,
`rewrite structure '/%postname%/'`. Serve from INSIDE `site/`:
`php -S 127.0.0.1:8080 router.php` where router returns `false` for existing
files and otherwise requires `index.php` (serving from the parent dir 404s the
JS). Chromium flags `--use-fake-ui-for-media-stream --use-fake-device-for-media-stream`
plus context `permissions: ['camera', 'microphone']`.
