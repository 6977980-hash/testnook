# Phase 10 handoff: Tier 2 batch 4 (device, audio, fixed click tests)

Date: 29 Oct 2026. Branch `claude/project-thread-iwhlam`, merged to `main`.

## What was built

16 new tool pages (76 tools, 10 hubs). No new hub. Same recipe as every
phase: catalog entry, `content/tools/<slug>.php`, script, CSS,
`assets/img/og/<slug>.jpg`.

| Page | Hub (also) | Ads | Device | Script / CSS | Notes |
|---|---|---|---|---|---|
| `/vibration-test/` | phone | content | touch | `vibration-test` | `navigator.vibrate` patterns (short, long, double, pulse, heartbeat, SOS), simulated weak/medium strength by PWM pulses, ramp, 10 s hold, custom 50-3000 ms, pattern timeline + shaking phone icon, "Did you feel it?" advice. iPhone: no Vibration API; on iOS a "haptic tick" button clicks a hidden `<input type=checkbox switch>` label (iOS 18+ system haptic), shown only when `vibrate` is missing on iOS. |
| `/torch-test/` | phone (camera) | standard | touch | `torch-test` | getUserMedia back camera, looks for `getCapabilities().torch`, tries every other camera if the default has none; on/off, strobe 1-10 Hz, SOS; full-screen white "screen light" fallback. |
| `/device-info/` | phone (screen) | standard | any | `device-info` | Grouped list: system, browser, screen, GPU (WebGL debug renderer), network, features; UA-CH high entropy, battery, storage estimate, rAF refresh rate; "Copy all". |
| `/what-is-my-user-agent/` | phone | standard | any | `device-info` | Raw UA + copy, parsed browser/engine/OS/device, Client Hints list, paste-a-UA checker. |
| `/what-phone-do-i-have/` | phone | standard | touch | `device-info` | Android: UA-CH / UA model, Samsung SM- code map (~60 models) to names. iPhone: screen size + DPR table lists matching models (5s to 17 Pro Max / Air). Desktop says "Not a phone". |
| `/voice-recorder/` | audio (phone) | standard | media | `voice-recorder` | MediaRecorder with pause/resume, live waveform + level, takes list in memory, download native (WebM/M4A) or 16-bit WAV (decoded with Web Audio), delete, mic picker, NS/EC toggles. |
| `/stereo-test/` | audio | standard | any | `channel-test` | Left/centre/right chime, pan sweep, ping-pong notes, in/out-of-phase noise, balance tone with slider; L/R icons driven by per-channel analysers; "Where did you hear it?" answers. |
| `/mono-test/` | audio | standard | any | `channel-test` | Two steps: left/right only + out-of-phase cancellation; answers explain mono vs stereo; how to toggle Mono Audio on every OS. |
| `/bass-test/` | audio | standard | any | `bass-test` | 20-200 Hz tones (8 s), slider 10-250 Hz, sweep down/up with "I can't hear it" marker that reports lowest bass, 30-120 Hz rattle sweep, kick at 120 BPM, 808 hits. `disclaimer` set. |
| `/1-second-cps-test/`, `/5-second-cps-test/`, `/10-second-cps-test/`, `/15-second-click-test/`, `/30-second-click-test/`, `/60-second-click-test/`, `/100-second-click-test/` | benchmark | content | desktop | `cps-test` | Fixed length via `data-cps-dur` on the stage, no length buttons; a "Length:" link row to the sibling pages (`aria-current` on the current one). Consistency stat from 10 s up. Each page has its own copy and score table for its length. |

Shared code:

- `content/tools/_click-test.php` returns `$tool( $secs )` (like
  `_typing-test.php`).
- `assets/js/tools/cps-test.js` now finds its root as
  `#cps-stage.closest('[data-tool]')` instead of a slug list, so any page with
  the CPS markup works. Duration falls back to `data-cps-dur`. Best-score
  keys are unchanged (`tn-cps-best-<secs>`), so the fixed pages share bests
  with `/cps-test/`.
- `assets/js/tools/device-info.js` serves three pages; it fills whatever
  elements exist (`[data-di]`, `#di-table` with `data-di-groups`, `#di-ua`,
  `#di-hints`, `#di-parse-*`, `#di-phone*`). Samsung code map and iPhone
  screen table live at the top of the file; add new models there.
- `assets/js/tools/channel-test.js` + `channel-test.css` serve stereo and mono.
- Hubs: phone (new copy for vibration/torch/device pages, used-phone order,
  FAQ "vibration and torch" now yes), audio (stereo/mono/bass/recorder
  paragraph, description now 159 chars), benchmark (new "Fixed-length click
  tests" section). `related` updated on cps-test, headphone-test, mic-test,
  camera-test, sound-test, touch-screen-test. cps-test results link all 7
  fixed pages.

## Tested

Local WordPress 6.9 on SQLite (Phase 3 recipe). Playwright audit over the 16
pages + phone, audio, benchmark hubs and cps-test at 1280 px and iPhone 13:
200, title 50-58, description 150-160, 6 FAQs, 8 related cards, own OG
image, valid JSON-LD, no console errors or page errors, no horizontal
scroll, no "Coming soon"; every internal link in each page body resolves
200. Sitemap 91 page URLs; homepage 100 cards. `debug.log` clean.

Interactions (Playwright): 5 s test 40 clicks = 8.0 CPS, best shared with
/cps-test/; 1 s test 6 clicks = 6.0, one graph bar; 100 s shows 100.0 and
consistency. Device info 6 groups / 44 rows, copy puts 59 lines on the
clipboard. UA parser: S23 Ultra, Galaxy A55 on Samsung Internet, Pixel 8
Pro, iOS 17.4 Safari, Edge 130 on Windows, Firefox on macOS all correct.
What phone: iPhone 13 emulation lists iPhone 16e/14/13/13 Pro/12/12 Pro;
Android UA SM-S911B shows "Samsung Galaxy S23"; desktop says not a phone.
Vibration: heartbeat plays 16 segments / 4.0 s, advice on No; with
`vibrate` removed on iPhone emulation the haptic button shows. Torch: fake
camera reports "Not available"; with a mocked torch capability on/off,
strobe at 3 Hz (12 toggles in 1.6 s), SOS and stop work; screen
light opens and closes. Voice recorder: record, pause (timer holds),
resume, stop gives 1 take; WAV download is a valid RIFF/WAVE 44.1 kHz.
Stereo: Left lights only L; answer buttons explain; balance slider reads
R 12. Mono: out-of-phase asks the phase question. Bass: 50 Hz = G1, sweep
marker reports lowest Hz, slider, 808. Screenshots in project files:
`phase-10-*.png`.

Not testable here: a real vibration motor, a real torch LED, iOS 18 haptic
tick, real speakers/subwoofer. Ali should try on his phone:
`/vibration-test/`, `/torch-test/` (Chrome on Android), `/what-phone-do-i-have/`,
`/voice-recorder/`, and `/bass-test/` on speakers.

## Decisions

- No new "device/browser info" hub: device-info, user agent and what-phone
  sit in the phone hub (an 11th nav link would overflow the header). If
  Tier 3 adds more browser/internet tools, make a `system` hub then and move
  these three (`hub` key only).
- Fixed click pages use 'cps' in the 1/5/10 slugs and 'click' for 15/30/60/100,
  matching the keyword list.
- Click ranks (Turtle...Lightning) are the same at every length; each page's
  table gives the typical range for its length instead.
- Recordings are never persisted (memory only); stated on the page.
- Urdu/Hindi typing tests were not built (still candidates).

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/phone/` (vibration,
   torch, device info, user agent, what phone cards) and
   `https://testnook.com/benchmark/`.
2. On your phone: vibration test, torch test (Chrome), what phone do I have.
3. Search Console: resubmit `https://testnook.com/wp-sitemap.xml`. IndexNow
   pings the new URLs on the first production request.

## Remaining roadmap (carry this forward in every handoff)

Ali approved on 28 Oct 2026 a dedicated "moat" phase after Tier 2 and
before Tier 3. Suggested order:

1. **Phase 11: Tier 2 batch 5a**: eye tests (`red-green-color-blind-test`,
   `color-vision-test`, `eye-test`, `astigmatism-test`, `blind-spot-test`,
   all with `disclaimer`), screen info pages (`screen-resolution`,
   `screen-size`, `screen-ratio`, `aspect-ratio-calculator`,
   `ppi-calculator`). `device-info.js` already reads screen size/DPR and can
   be reused for `screen-resolution`.
2. **Phase 12: Tier 2 batch 5b**: monitor pages (`monitor-test`, `lcd-test`,
   `display-test`, `oled-test`, `monitor-color-test`, `monitor-calibration`),
   `zoom-test`, `battery-health-test`, `dog-whistle`,
   `white-noise-generator`, `keyboard-ghosting-test`, `mouse-accuracy-test`,
   `mouse-latency-test`, `controller-vibration-test`, `joy-con-drift-test`,
   and optionally `typing-test-urdu` / `typing-test-hindi`. Split again if
   it is more than ~12 pages.
3. **Phase 13: Moat phase** (approved by Ali, do not build before Tier 2 is
   done): (a) anonymous aggregate data: average reaction time, average CPS,
   average WPM, dead pixel location stats, collected with consent and shown
   on the tool pages; (b) leaderboards for CPS (the 7 fixed-length pages
   are natural boards), typing and reaction time; (c) an embed widget:
   iframe code for every tool (embed mode `?embed=1` already exists; add a
   copy-the-code box and a per-tool embed page or section). Needs a small
   server side (REST endpoint + table) and an abuse/rate-limit plan; design
   it in its own thread first.
4. **Phase 14+: Tier 3**: 3-5 troubleshooting guides per tool (stick drift
   fixes, keyboard key not working, webcam/mic not working, average reaction
   time by age, what is a good CPS, average typing speed by age, is 144hz
   worth it, etc.), phone sensor pages (gyroscope, accelerometer, compass,
   proximity, GPS), internet tools, browser info tools.

Recipe unchanged: catalog entry, `content/tools/<slug>.php`, script, CSS,
`python3 bin/make-og-images.py`, commit the JPEGs, Playwright pass at
1280 px and iPhone 13, merge to `main`, write `docs/handoff/phase-N.md`.

Local test setup: as in `docs/handoff/phase-3.md`, with
`define( 'WP_ENVIRONMENT_TYPE', 'local' );` in `wp-config.php`.
