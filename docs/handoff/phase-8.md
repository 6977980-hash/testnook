# Phase 8 handoff: Tier 2 batch 2

Date: 28 Oct 2026. Branch `claude/project-thread-dfqa30`, merged to `main`.

## What was built

8 new tool pages (48 tools total). Same recipe as every phase: catalog
entry, `content/tools/<slug>.php`, `assets/js/tools/<slug>.js`,
`assets/css/tools/<slug>.css`, `assets/img/og/<slug>.jpg`.

| Page | Hub (also) | Ads | Device | Notes |
|---|---|---|---|---|
| `/ufo-test/` | screen (benchmark) | content | any | Canvas saucers in 1/3/4 rows at 240-3840 px/s, light/dark/stripes background, measured Hz, frame time, px per frame, skipped frames, fullscreen. Copy covers sample-and-hold blur vs ghosting vs overdrive overshoot and how to tune the monitor's overdrive. |
| `/metronome/` | audio | content | any | Web Audio look-ahead scheduler (25 ms timer, 120 ms horizon). 20-300 BPM, 1/4 to 7/8, subdivisions, 3 sounds, accent, tap tempo, Italian markings, Space/arrows/T keys. Stops when the tab is hidden. |
| `/tap-bpm/` | audio (benchmark) | content | any | Pointer or any key taps; average BPM, last-4-tap BPM, stability (100 - SD/mean), beat length ms, genre hint, halve/double, auto reset after 3 s. No mic. |
| `/guitar-tuner/` | audio (phone) | standard | media | getUserMedia (no processing) + AnalyserNode 4096 time-domain -> normalised autocorrelation (first clear peak, parabolic interpolation, median of 5). Presets guitar / drop D / bass / ukulele / chromatic, snaps to the nearest string, A4 400-480, reference tones per string, mic picker, level bar. Verified offline on synthetic tones 41-1150 Hz: within 0.1 cent. |
| `/stroop-test/` | benchmark | content | any | Block 1 congruent, block 2 incongruent (10/20/40 words); R/G/B/Y or 1-4 keys or 4 buttons; mean RT per block, Stroop effect, accuracy; best saved only when accuracy >= 80%. Copy says clearly it is not diagnostic. |
| `/f1-reaction-test/` | benchmark | content | any | 5 columns of red lights, 1 s apart, random 0.2-3 s hold, lights out = go; jump start on early press; times in `0.000 s`; 5/10/endless; Space works after a click (stage focuses itself). |
| `/right-click-cps-test/` | benchmark (mouse) | content | desktop | `cps-test.js` with `data-cps-mode="right"`: counts button 2 only, context menu blocked in the box, own localStorage key. |
| `/jitter-click-test/` | benchmark (mouse) | content | desktop | `cps-test.js` with `data-cps-mode="jitter"`: 5-60 s with 10 s default, own rank ladder (Not jittering yet / Warming up / Jitter / Fast jitter / Pro jitter), extra `#cps-consist` stat (100 - SD/mean of per-second counts). |

Shared code changes:

- `assets/js/tools/cps-test.js`: root matches the three CPS pages; reads
  `data-cps-mode` from the stage (`left` default); `rightOk` checkbox is
  optional; fills `#cps-consist` when present; default duration comes from
  the `aria-pressed="true"` length button instead of a hard-coded 5.
- `assets/js/tools/reaction-time-test.js`: the stage now calls
  `focus({ preventScroll: true })` on pointerdown (the `preventDefault`
  there used to stop the click from focusing the stage, so Space after a
  mouse click did nothing). Same pattern in `f1-reaction-test.js`.
- Hubs: `benchmark.php` (title/description/intro/body/FAQ bullet),
  `audio.php` (title/description/intro + "Tools for musicians" section),
  `screen.php` and `mouse.php` guide text link the new pages. `related`
  lists updated on cps-test, reaction-time-test, refresh-rate-test,
  fps-test, tone-generator.

## Tested

Local WordPress 6.9 on SQLite (Phase 3 recipe, `WP_ENVIRONMENT_TYPE` local).
Playwright over the 8 pages at 1280 px and iPhone 13: 200, title 54-60,
description 154-160, 6 FAQs, 8 related cards, own OG image, valid JSON-LD,
tool script enqueued, no console errors or warnings, no horizontal scroll;
every internal link in the page body resolves 200. Interactions: right
click page ignores a left click and counts 6 right clicks; jitter page
defaults to 10 s and reports consistency; F1 shows 2 lights at 2.3 s, flags
a jump start, then records a Space press after lights out; Stroop 10+10
words answered by key with 100% accuracy and an effect in ms; tap BPM at
500 ms taps reads 112-113 BPM (Playwright click latency), doubles, and Space
taps read after Reset; metronome starts, lights one dot, switches to 3/4,
shows Andante at 90, tap tempo sets ~133; UFO measures 60 Hz and switches
background/rows/speed; tuner lists 6 then 4 strings, plays a reference
tone, starts with the fake mic ("Listening"), stops. Hubs: benchmark 10
cards, audio 9, screen 18, mouse 8, no "Coming soon". Homepage 65 cards.
Embed mode noindex + tool renders. Sitemap 61 URLs with all 8. `debug.log`
clean. Screenshots: `project files/testnook/phase-8-stroop.png`,
`phase-8-guitar-tuner.png`, `phase-8-f1.png`.

Not testable here: real pitch tracking through a microphone (the detector
was verified on synthetic tones in Node), audible click timing of the
metronome, real jitter clicking. Ali should try `/guitar-tuner/` with a
guitar on a phone and a laptop, and `/metronome/` with wired headphones.

## Decisions

- Guitar tuner is `ads => standard` (a normal page with a mic tool, like
  mic-test). Everything else in the batch is `content` because the user
  clicks, taps or watches motion in the stage.
- Tap BPM lives in `audio` (with `benchmark` as secondary) next to the
  metronome, since both serve musicians; keyword research listed it with
  the audio group.
- F1 start: lights 1 s apart, hold 0.2-3 s, jump start threshold is "any
  light still on" (no 0.1 s rule), times shown to three decimals like F1
  timing. No green light, which the copy explains.
- Stroop: button-press version, 4 colours, Stroop effect = incongruent
  minus congruent mean RT of correct answers only; accuracy under 80% is
  shown but not saved. Copy includes a "not diagnostic" statement.
- UFO test does not try to measure response time in ms; it shows motion and
  measures frame timing. The copy is explicit about that.
- Jitter test consistency uses per-second counts, so a 25-click burst in a
  5 s test reads 0%; that is intended (jitter is about holding a rate).

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/benchmark/` (10
   cards) and `https://testnook.com/audio/` (9 cards).
2. Try `/guitar-tuner/` with a real guitar on a phone (Safari and Chrome)
   and on a laptop; `/metronome/` with wired headphones; `/f1-reaction-test/`
   with Space after a click.
3. Search Console: resubmit `https://testnook.com/wp-sitemap.xml`. IndexNow
   pings the 8 new pages on the first production request.

## Remaining roadmap (carry this forward in every handoff)

Ali approved on 28 Oct 2026 a dedicated "moat" phase after Tier 2 and
before Tier 3. Suggested order:

1. **Phase 9: Tier 2 batch 3** (volume order from master plan 7.2):
   `memory-game` + `memory-test` hub (chimp, number, visual, sequence,
   verbal memory), `typing-test` hub with 1 minute / 5 minute / wpm /
   english variants (new hub `benchmark` or own hub), `auto-clicker-test`.
   Memory and typing are new hubs: add to catalog `hubs`, write
   `content/hubs/<slug>.php`, run the OG script.
2. **Phase 10: Tier 2 batch 4**: `vibration-test`, `torch-test`,
   `device-info`, `what-is-my-user-agent`, `what-phone-do-i-have`,
   `voice-recorder`, `stereo-test`, `mono-test`, `bass-test`, the 1/5/10/30/
   60/100 second click pages (reuse `cps-test.js`, fixed `dur` per page).
3. **Phase 11: Tier 2 batch 5**: eye tests (`red-green-color-blind-test`,
   `color-vision-test`, `eye-test`, `astigmatism-test`, `blind-spot-test`,
   all with `disclaimer`), screen info pages (`screen-resolution`,
   `screen-size`, `screen-ratio`, `aspect-ratio-calculator`,
   `ppi-calculator`), monitor pages (`monitor-test`, `lcd-test`,
   `display-test`, `oled-test`, `monitor-color-test`, `monitor-calibration`),
   `zoom-test`, `battery-health-test`, `dog-whistle`,
   `white-noise-generator`, `keyboard-ghosting-test`, `mouse-accuracy-test`,
   `mouse-latency-test`, `controller-vibration-test`, `joy-con-drift-test`.
   Split into two phases if it is more than 10 pages.
4. **Phase 12: Moat phase** (approved by Ali, do not build before Tier 2 is
   done): (a) anonymous aggregate data: average reaction time, average CPS,
   dead pixel location stats, collected with consent and shown on the tool
   pages; (b) leaderboards for CPS, typing and reaction time; (c) an embed
   widget: iframe code for every tool (embed mode `?embed=1` already
   exists; add a copy-the-code box and a per-tool embed page or section).
   Needs a small server side (REST endpoint + table) and an abuse/rate-limit
   plan; design it in its own thread first.
5. **Phase 13+: Tier 3**: 3-5 troubleshooting guides per tool (stick drift
   fixes, keyboard key not working, webcam/mic not working, average reaction
   time by age, what is a good CPS, is 144hz worth it, etc.), phone sensor
   pages, internet tools, browser info tools.

Recipe unchanged: catalog entry, `content/tools/<slug>.php`, script, CSS,
`python3 bin/make-og-images.py`, commit the JPEGs, Playwright pass at
1280 px and iPhone 13, merge to `main`, write `docs/handoff/phase-N.md`.

Local test setup: as in `docs/handoff/phase-3.md`, with
`define( 'WP_ENVIRONMENT_TYPE', 'local' );` in `wp-config.php`.
