# Phase 12 handoff: Tier 2 batch 5b (monitor pages, misc tools, input devices)

Date: 29 Oct 2026. Branch `claude/project-thread-5a9ri4`, merged to `main`.

## What was built

15 new tool pages (101 tools, 11 hubs). No new hub, so the nav is unchanged.
Same recipe as every phase: catalog entry, `content/tools/<slug>.php`,
script, CSS, `assets/img/og/<slug>.jpg`. This finishes the Tier 2 list
except the optional Urdu/Hindi typing tests (moved to Tier 3 candidates).

| Page | Hub (also) | Ads | Device | Script / CSS | Notes |
|---|---|---|---|---|---|
| `/monitor-test/` | screen | content | any | `monitor-test` | 16 full-screen patterns: black/white/RGB, 50% grey, grey + RGB gradients, black level, white level, gamma (1px stripes vs solid 1.8-2.6), sharpness + text, grid/geometry, colour bars, inversion, dark smearing (animated). |
| `/lcd-test/` | screen | content | any | `monitor-test` | 13 patterns focused on backlight: bleed, IPS glow, 5%/20% grey clouding, inversion, viewing angle. |
| `/display-test/` | screen (phone) | content | any | `monitor-test` | 12 patterns for laptops/TVs/phones/projectors; grid tip covers overscan. |
| `/oled-test/` | screen (phone) | content | any | `monitor-test` | 12 patterns: true black, 5% grey, near-black steps 0-40, mura, burn-in on grey/white/blue, smearing. |
| `/monitor-color-test/` | screen | content | any | `monitor-test` | 15 patterns: colour bars, RGB gradients, hue spectrum, saturation steps, 24 ColorChecker-style patches, gamma, solid primaries/secondaries. |
| `/monitor-calibration/` | screen | content | any | `monitor-test` | 6 steps (brightness, contrast, gamma, colour temperature, sharpness, final check) with step tips; OS calibration tools explained. |
| `/zoom-test/` | camera (audio) | standard | media | `zoom-test` | Camera preview (mirrored) + resolution and real fps (requestVideoFrameCallback), face-lighting check (centre vs background brightness), mic meter, 5 s record and play back, speaker chime (WAV blob, `setSinkId` picker), 4-item ready checklist. Not-affiliated note in `disclaimer`. |
| `/battery-health-test/` | phone | standard | any | `battery-health-test` | Battery Status API (Chrome/Edge/Android only): level, charging, browser time estimates; drain test with wake lock, % per hour by least squares, runtime estimate; design vs full charge capacity calculator; per-OS steps for real battery health. |
| `/dog-whistle/` | audio (phone) | standard | any | `dog-whistle` | Sine 4-22 kHz (capped at sampleRate/2 - 500), hold button, short/long/double/recall/trill patterns, 4 kHz-max sweep, soft 15 ms edges. `disclaimer` (pets, hearing). |
| `/white-noise-generator/` | audio | standard | any | `white-noise-generator` | White, pink (Kellet), brown, grey (white + low shelf/peaking cut), blue, violet; 12 s stereo buffers looped with a 0.5 s cross-fade, equal RMS; warmth low-pass, 2 s fade in, sleep timer 15 min-8 h with 30 s fade out, log spectrum bars. `disclaimer`. |
| `/keyboard-ghosting-test/` | keyboard | content | desktop | `keyboard-ghosting-test` (+ `keyboard-tester.css`) | 60% layout, keys held now, most at once, rollover label, best combo, 8 combo checklist (WASD, sprint-jump, crouch-jump, QWER, ... ten fingers). |
| `/mouse-accuracy-test/` | mouse (benchmark) | content | desktop | `mouse-accuracy-test` | 30 targets, static or shrinking (1.6 s), 3 sizes; accuracy, time per target, distance from centre, score, best per mode+size in localStorage `tn-aim-best-<mode>-<size>`, hit scatter plot and aim-bias sentence. |
| `/mouse-latency-test/` | mouse | content | desktop | `mouse-latency-test` | Drawn dot vs hardware cursor, raw coalesced path, polling rate from coalesced events, event delay, event-to-frame, frame time, estimated browser latency (poll/2 + event-to-frame + 1 frame), click-to-frame pad. States clearly that monitor lag is not included. |
| `/controller-vibration-test/` | controller | standard | gamepad | `controller-vibration-test` | dual-rumble with strong/weak sliders and duration, left/right/both/gentle/pulse/heartbeat/ramp, Xbox trigger-rumble when `vibrationActuator.effects` lists it, Firefox `hapticActuators` fallback, "did you feel it" advice. |
| `/joy-con-drift-test/` | controller | standard | gamepad | `stick-drift-test` | Same markup as stick drift with `data-sd-joycon` on the stage and `#sd-h0/#sd-h1` headings: names the circle "Joy-Con (L/R) stick" from the id, warns when a Joy-Con is read without standard mapping (8-way hat). |

Shared code:

- `content/tools/_monitor-patterns.php` returns `$patterns( $list, $start, $status )`.
  `$list` is pattern ids in order, or `id => array( label, tip )` to override
  the default label/tip (calibration uses this for its steps). Default
  labels and tips for all 25 patterns live in that file, so the tips are in
  the HTML. `assets/js/tools/monitor-test.js` draws each id on a canvas at
  device-pixel resolution (thumbnails too), full screen with
  click/tap/arrows, `H` toggles tips, idle nav buttons for touch.
  `root.mtOpen(i)` exists for automated checks. To add a pattern: a draw
  function in `P` (and `ANIMATED` if it moves) plus a default in the PHP.
- `assets/js/tools/stick-drift-test.js` now finds its root as
  `#sd-c0.closest('[data-tool]')` (like `cps-test.js`), so any page with the
  stick markup works.
- Hubs: screen (new "Full monitor tests and calibration" section, intro),
  camera (Zoom test), audio (white noise + dog whistle), phone (battery),
  keyboard (ghosting), mouse (accuracy + latency, intro), controller
  (vibration + Joy-Con, intro). `related` updated on dead-pixel-test,
  keyboard-tester, stick-drift-test, gamepad-tester, webcam-test, mic-test,
  burn-in-test, tone-generator, mouse-polling-rate-test, device-info.
- `docs/content-format.md` lists `_monitor-patterns.php` as a helper.

## Tested

Local WordPress (Phase 3 recipe, Composer now installs WP 7.1) on SQLite.
Playwright audit over all 117 sitemap pages at 1280 px and iPhone 13: 200,
no console or page errors, no horizontal scroll, no "Coming soon", valid
JSON-LD, every internal link 200. All 15 new pages: title 53-60, description
152-160, 6 FAQs, 8 related cards, own OG image. The audit still flags older
pages outside 150-160 / 50-60 (privacy, about, contact, terms, webcam-test
title 44, fps-test, sound-test, speaker-cleaner, number-memory, wpm,
typing-test-english, memory-test and typing-test hubs): not this phase's
pages; a future SEO tidy-up can trim them. `debug.log` clean.

Interactions (Playwright): every pattern of all six monitor pages opens and
draws (screenshot sheet checked by eye). Zoom test with fake camera/mic:
1280 x 720, fps counted from video frames, lighting OK, mic detected,
recording plays back, speaker answer ticks. Battery with a mocked battery:
level/state, drain test rate and runtime, calculator 56000/48500 = 86.6%.
White noise: all six colours build, warmth 60 = 1.9 kHz, timer counts down,
stop fades to 0. Dog whistle: presets, recall pattern, hold on/off, sweep
to 21.6 kHz at 44.1 kHz. Ghosting: W+A+Shift+Space and 10 keys register,
combos tick. Accuracy: 30 targets, misses, bias sentence, best saved;
shrinking mode expires targets. Latency: all stats fill, 10 clicks counted.
Controller vibration with a mocked Xbox pad: dual-rumble 1/0, trigger
rumble right, pulse x5, reset on stop. Joy-Con with a mocked "Joy-Con (L)":
heading renamed, 16.8% drift detected; stick drift page still works.

Not testable here: real monitors (bleed, gamma, inversion flicker), real
controllers and rumble, a real battery draining, real mouse polling and
latency, real speakers above 18 kHz. Screenshots in project files:
`phase-12-*.png`.

## Decisions

- Monitor pages use `ads => content` (not `none` like dead pixel): they are
  long guide pages; the full-screen overlay (z-index 1000) covers any ad
  while patterns show, and there is no slot right under the launcher.
  Switch to `none` if an AdSense review objects.
- `zoom-test` is a pre-meeting device check (camera, light, mic, speakers),
  matching the keyword intent ("zoom test meeting", "zoom camera test"); it
  does not connect to Zoom and says it is not affiliated.
- Battery health never claims a health % from the browser; the drain test
  measures runtime and the calculator takes numbers from the OS report.
- Mouse latency reports a browser-side estimate only and says end-to-end
  latency needs LDAT or a high-speed camera.
- Joy-Con reuses the stick drift script instead of a new one.
- Urdu/Hindi typing tests not built (Tier 3 candidates).

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/screen/` (new monitor
   section) and `https://testnook.com/monitor-test/` on your monitor.
2. Before your next call, try `/zoom-test/`. On a laptop in Chrome, try
   `/battery-health-test/` unplugged for 20 minutes.
3. With a controller: `/controller-vibration-test/`; with a Joy-Con paired
   to the PC: `/joy-con-drift-test/`.
4. Search Console: resubmit `https://testnook.com/wp-sitemap.xml`. IndexNow
   pings the new URLs on the first production request.

## Remaining roadmap (carry this forward in every handoff)

Tier 2 is done. Ali approved on 28 Oct 2026 a dedicated "moat" phase after
Tier 2 and before Tier 3. Suggested order:

1. **Phase 13: Moat phase** (approved by Ali; next): (a) anonymous
   aggregate data: average reaction time, average CPS, average WPM, dead
   pixel location stats (and now aim accuracy scores), collected with
   consent and shown on the tool pages; (b) leaderboards for CPS (the 7
   fixed-length pages are natural boards), typing, reaction time and the
   mouse accuracy test; (c) an embed widget: iframe code for every tool
   (embed mode `?embed=1` and an embed code box already exist on tool
   pages; add a clear copy-the-code box and a per-tool embed page or
   section, plus attribution link). Needs a small server side (REST endpoint
   + custom table via `dbDelta`), nonce/rate limiting, plausibility checks
   on scores (e.g. CPS caps, minimum durations), a privacy policy update
   and no personal data. Design it in its own thread first and split into
   13a (backend + stats) and 13b (leaderboards + embed) if large.
2. **Phase 14+: Tier 3**: 3-5 troubleshooting guides per tool (stick drift
   fixes, keyboard key not working, webcam/mic not working, average reaction
   time by age, what is a good CPS, average typing speed by age, is 144hz
   worth it, what is 20/20 vision, types of colour blindness, OLED burn-in
   fix, backlight bleed fix, etc.), phone sensor pages (gyroscope,
   accelerometer, compass, proximity, GPS), internet tools, browser info
   tools (then consider a `system` hub and move device-info, user agent,
   what-phone and the screen info pages there by changing their `hub` key),
   optional `typing-test-urdu` / `typing-test-hindi`, and the SEO tidy-up of
   the older titles/descriptions listed under Tested.

Recipe unchanged: catalog entry, `content/tools/<slug>.php`, script, CSS,
`python3 bin/make-og-images.py`, commit the JPEGs, Playwright pass at
1280 px and iPhone 13, merge to `main`, write `docs/handoff/phase-N.md`.
A 12th hub would need the nav breakpoint raised again or the hub names
shortened.

Local test setup: as in `docs/handoff/phase-3.md`, with
`define( 'WP_ENVIRONMENT_TYPE', 'local' );` in `wp-config.php`.
