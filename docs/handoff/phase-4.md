# Phase 4 handoff: tools 17-24

Date: 28 Oct 2026. Branch `claude/project-thread-oj2spd`, merged to `main`.

## What was built

Eight more live tool pages, same recipe as Phases 2-3: `content/tools/<slug>.php`,
`assets/js/tools/<slug>.js` (IIFE, bails when `[data-tool="<slug>"]` is absent)
and `assets/css/tools/<slug>.css` (inlined).

| Tool | Ads | Device | Notes |
|---|---|---|---|
| `/reaction-time-test/` | content | any | Blue idle -> red random wait (1.5-5 s) -> green; earliest `pointerdown` / `touchstart` / Space timed from the rAF after the green paint. 5 / 10 / endless tries, average, best, "too soon" handling, per-try chips, best average in localStorage (`tn-rt-best`), fullscreen. |
| `/cps-test/` | content | desktop | 1 / 5 / 10 / 30 / 60 / 100 s, timer starts on the first press, counts raw `pointerdown` (optional right button), conic countdown ring, live CPS, peak second, rank Turtle -> Lightning, per-second bar graph, best per length in localStorage. |
| `/spacebar-clicker/` | content | desktop | Counter mode (endless) or 5 / 10 / 30 / 60 s. Counts Space `keydown` without `repeat`; held repeats counted separately; fastest gap flags chatter (< 25 ms); key picture is a tap target on touch. Stage must be focused (click), Space never scrolls. |
| `/white-screen/` | none | any | Shares `colour-screen.js` / `.css` with black screen (the script matches either `data-tool`). Fixed overlay + Fullscreen API, 7 shades, auto close 1 / 5 / 15 / 60 min, preview box, Esc / tap / click exits, cursor hides. |
| `/black-screen/` | none | any | Same script; black + near-black shades + deep blue / red for bleed and stuck pixel checks. |
| `/tone-generator/` | standard | any | One oscillator, sine / square / triangle / sawtooth, 1-22000 Hz via number input, log slider and ±1 buttons, note name + cents, 12 presets, L / both / R via ChannelMerger, volume (default 25%), waveform canvas, 20 Hz -> 20 kHz sweep over 10 / 20 / 60 s. `disclaimer` set. Stops when the tab is hidden. |
| `/dpi-analyzer/` | standard | desktop | Pointer lock with `unadjustedMovement: true` where supported (falls back to plain lock, then to normal movement); sums `movementX` over a user-entered distance (cm / inch) -> counts per inch; averages up to 5 runs, deviation vs the DPI typed in (green ≤ 5%, amber ≤ 12%, red). Space / click finishes, Esc cancels. |
| `/online-ruler/` | standard | any | Canvas ruler at devicePixelRatio, cm (1 mm ticks) or inches (1/16), horizontal / vertical, fullscreen, drag to measure. Calibration: bank card slider (85.60 mm), screen diagonal (uses `screen.width/height` CSS px), ±0.2% / ±1% fine tune; px per inch stored in localStorage (`tn-ruler-ppi`). Redraws on resize, theme change and fullscreen. |

Also changed: `mouse-tester.php` FAQ now links to `/dpi-analyzer/`. Theme core
(`inc/`, templates, `main.css`) untouched. 24 of 32 tools are live; the other 8
remain "Coming soon".

## Tested

Local WordPress 6.9 on SQLite via Composer (recipe in the Phase 3 handoff, it
worked unchanged). Playwright over all 8 pages at 1280 px (light + dark) and
iPhone 13: every page 200, `<title>` 52-57 chars, meta description 150-158
chars, 525-814 words of prose, 6 FAQs, 8 related cards, valid JSON-LD, tool
script enqueued, no console errors or warnings, no horizontal scroll, embed mode
noindex, homepage links all 8. Interactions verified: reaction time records a
try and flags "too soon"; CPS 1 s test counts 12 clicks -> 12.0 CPS, Lightning;
spacebar counts 10 presses, page does not scroll, timed mode starts; white and
black screens open with the right colour, switch shade, close on Esc and on
click; tone generator plays / stops, follows a typed frequency, names the note,
sweeps; DPI analyzer enters pointer lock and rejects an empty run; ruler
measures a 96 px drag as 2.54 cm / 1.00 in, flips vertical, calibrates from a
screen diagonal.

Not testable headless: real mouse counts under pointer lock (Playwright's
synthetic moves give no `movementX`), real audio, real screen size. Ali should
try `/dpi-analyzer/` with a mouse and ruler in Chrome, `/online-ruler/` with a
bank card, and `/tone-generator/` with headphones after the deploy.

## Decisions

- White and black screen share one script and stylesheet (`colour-screen`),
  keyed off the page's `data-tool`. Reuse it for any future solid-colour page.
- Reaction time test uses `ads => content` and starts timing on the rAF after
  the green is painted, so the number is as close to what the user sees as the
  browser allows.
- CPS and spacebar count `pointerdown` / `keydown` and ignore key repeat, so a
  held key never inflates a score; an 8 ms dedupe guards against touch + mouse
  duplicates.
- DPI analyzer asks the user for the DPI they set so it can show deviation; it
  does not guess. Mode text under the stage says whether raw input is active.
- Online ruler stores CSS px per inch, not physical; browser zoom changes the
  result and the copy says so.
- Scope order agreed with the coordinator: finish all 32 Tier 1 tools first
  (Phase 5 = tools 25-32), then the SEO layer, then Tier 2 + guides.

## Ali's steps after this merge

Nothing new. The 8 pages appear on the first visit after Hostinger deploys.
Check `/reaction-time-test/`, `/online-ruler/` and the homepage.

## What Phase 5 should do

Build the last 8 Tier 1 tools, in catalog order: `ps5-controller-test`,
`xbox-controller-test`, `ps4-controller-test`, `mouse-polling-rate-test`,
`scroll-test`, `camera-test`, `burn-in-test`, `hearing-frequency-test`.

Same recipe. Specifics:

1. Ads: `none` for burn-in-test (full-screen colour / pattern surface);
   `standard` for the rest. Device: `gamepad` for the three controller pages,
   `desktop` for polling rate and scroll test, `media` for camera-test, `any`
   for burn-in and hearing.
2. Controller pages: reuse `gamepad-tester.js`. Make its `LABELS` default come
   from a `data-pad` attribute on the tool section (or a small per-page script
   that sets `window.TN_PAD = 'ps5' | 'xbox' | 'ps4'` before the shared script)
   so one script serves four pages; the content files differ in copy, button
   names (Cross/Circle vs A/B, L2/R2 vs LT/RT, touchpad, Share/Create) and
   fixes (DualSense drift, Xbox Bluetooth pairing, DS4 PC driver notes).
3. Polling rate: count `mousemove` events per second while the user moves the
   mouse in circles; report the median of the last few seconds and the nearest
   of 125 / 250 / 500 / 1000 / 2000 / 4000 / 8000 Hz. Use `getCoalescedEvents`
   so Chrome's event coalescing does not cap the count at the frame rate.
4. Scroll test: `wheel` events in a stage, count up / down, direction flips,
   skipped steps (delta sign changes mid-scroll), deltaY per notch; reuse the
   wheel part of `mouse-tester.js`.
5. Camera test: `webcam-test.js` with front / back switching
   (`facingMode: environment`), resolution and fps per camera, snapshot;
   mostly a phone page.
6. Burn-in test: consent gate like `stuck-pixel-fixer.js`, then full-screen
   cycling of solid colours + a grey gradient + a checkerboard, with a note on
   image retention vs burn-in. Link to `/black-screen/` and `/white-screen/`.
7. Hearing frequency test: `tone-generator.js` logic with a stepped sweep
   (8 kHz up to 20 kHz in 1 kHz steps, user presses "I can hear it"), result =
   highest audible frequency with an age table; `disclaimer` required; start
   volume low.
8. After these ship, update the "coming soon" wording in `webcam-test.php`
   (camera test) and `mouse-tester.php` (polling rate) to links.
9. Test with the same Playwright script (desktop + iPhone 13, light + dark,
   console, scroll, JSON-LD, meta lengths), merge to `main`, write
   `docs/handoff/phase-5.md`. Phase 6 is then the SEO layer + hub pages + OG
   images + IndexNow (see Phase 1 handoff "What is left overall").

Local test setup: exactly as written in `docs/handoff/phase-3.md`; it worked
first time this phase. Serve from inside `site/` with the router.
