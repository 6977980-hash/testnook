# Phase 5 handoff: tools 25-32

Date: 28 Oct 2026. Branch `claude/project-thread-puf3q6`, merged to `main`.

## What was built

The last eight Tier 1 tool pages, same recipe as Phases 2-4: `content/tools/<slug>.php`,
`assets/js/tools/<slug>.js` (IIFE, bails when `[data-tool="<slug>"]` is absent)
and `assets/css/tools/<slug>.css` (inlined). All 32 Tier 1 tools are now live;
nothing on the homepage or hubs says "Coming soon" any more.

| Tool | Ads | Device | Notes |
|---|---|---|---|
| `/ps5-controller-test/` | standard | gamepad | Shares `gamepad-tester.js` / `.css`. Markup comes from `content/tools/_gamepad-diagram.php` (a closure, not a tool: it is not in the catalog, so the registry ignores it) with PlayStation labels (✕ ○ □ △, L1/L2, Create, Options, Touchpad). Copy: DualSense drift causes and fixes, pairing (Create + PS), what browsers cannot see (adaptive triggers, haptics, mic). |
| `/xbox-controller-test/` | standard | gamepad | Same diagram, Xbox labels (A B X Y, LB/LT, View, Menu, Share). Copy: One / Series / Elite differences, bumper and D-pad wear, Bluetooth pairing, Game Bar stealing the Xbox button. |
| `/ps4-controller-test/` | standard | gamepad | Same diagram, DualShock 4 labels (Share instead of Create). Copy: DS4Windows notes, micro-USB port and battery faults, used-pad checklist. |
| `/mouse-polling-rate-test/` | standard | desktop | Counts `pointermove` reports inside a stage using `getCoalescedEvents()` (each coalesced event's own `timeStamp` feeds a median gap); rate = 1000 / median gap, nearest of 125 / 250 / 500 / 1000 / 2000 / 4000 / 8000 Hz, per-second bar graph over the last 10 s, best second, total. Seconds with < 20 reports (mouse still) are ignored. Click in the box or Start begins; stops when the tab is hidden. Note under the graph says whether coalesced events are on (Safari: off). |
| `/scroll-test/` | standard | desktop | `wheel` events in a stage (`preventDefault`, no autoscroll): up / down counts, **wrong-way scrolls** (A-B-A within 300 ms), **double steps** (a notch ≥ 1.9x the median notch, pixel mode only), last deltaY with the notch size, notches per second, delta mode, moving stripe strip, chip log of the last 40 notches. |
| `/camera-test/` | standard | media | Front / back switching via `facingMode` (`user` / `environment`), camera picker with an "Auto" entry, resolution + MP, live fps (`requestVideoFrameCallback`), aspect ratio, facing, cameras found, torch button when `getCapabilities().torch` exists, PNG photo, list of every camera tested so far. Front camera preview is mirrored, back is not. Stops when the tab is hidden. The switch button is hidden on non-touch devices. |
| `/burn-in-test/` | none | any | Full-screen overlay like `colour-screen.js`: 50% grey, white, R, G, B, black, grey gradient, checkerboard, colour bars. Click / arrows / Space step, Esc exits. A consent checkbox (as on the stuck pixel fixer) unlocks the **auto cycle** (every 1 / 3 / 10 s for 5-60 min) for image retention; it stops on Esc, when the tab is hidden, or at the time limit. Copy explains burn-in vs retention and links black / white screen and dead pixel test. |
| `/hearing-frequency-test/` | standard | any | Web Audio sine via the tone-generator routing (L / both / R). Stepped test: 8 kHz up to 20 kHz in 1 kHz or 500 Hz steps, each tone 2.5 s, repeated once if not answered, "I can hear it" (or Space / Enter) advances, "I can't hear it" or silence ends it. Result = highest heard + age band + note; ticks go green. Any tick can be tapped outside the test to hear it (free play). Volume default 15%. `disclaimer` set. |

Also changed: `gamepad-tester.js` now also mounts on the three controller pages,
reads `data-pad` from the diagram to set labels before a controller connects,
recognises DualShock 4 ids (`05c4` / `09cc`) as a separate `ps4` label set, and
appends a hint when the connected pad does not match the page. Prose links
updated: `mouse-tester.php` -> polling rate test, `webcam-test.php` -> camera
test, `gamepad-tester.php` -> the three controller pages. Theme core (`inc/`,
templates, `main.css`) untouched.

## Tested

Local WordPress 6.9 on SQLite via Composer (Phase 3 recipe, worked unchanged).
Playwright over all 8 pages at 1280 px (light + dark) and iPhone 13 with a fake
camera: every page 200, `<title>` 51-59 chars, meta description 153-160 chars,
661-900 words of prose, 6 FAQs, 8 related cards, valid JSON-LD, tool script
enqueued, no console errors or warnings, no horizontal scroll, embed mode
noindex, homepage links all 8, cross links resolve. Interactions verified:
controller pages show their own labels and the no-controller state; polling
rate reads a rate while the pointer circles (59 Hz under Playwright, which
moves once per frame) and reports a result on Stop; scroll test counts 7 down /
4 up and flags one wrong-way scroll from a down-up-down burst without scrolling
the page; camera test starts the fake camera at 1920x1080, measures fps, takes a
photo, lists the camera and stops; burn-in opens full screen on grey, steps to
white with the arrow key, closes on Esc, the cycle stays locked until the box is
ticked and then runs; hearing test starts at 8 kHz, steps to 9 kHz on "I can
hear it", ends on "I can't hear it" with "9 kHz, typical for people 60s or
over", two green ticks, free play works.

Not testable headless: real controllers, a real high-rate mouse, a real scroll
wheel encoder fault, phone back cameras and torch, real audio. Ali should try
`/mouse-polling-rate-test/` with a gaming mouse in Chrome (expect ~1000 Hz),
`/camera-test/` on a phone (switch to the back camera, try Flash), and
`/hearing-frequency-test/` with headphones after the deploy.

## Decisions

- One gamepad script for four pages, keyed by `data-pad` on the diagram, as the
  Phase 4 handoff suggested. The diagram markup lives in
  `content/tools/_gamepad-diagram.php` so the four content files only differ in
  labels and copy. Keep the underscore prefix for any future shared markup
  helper under `content/tools/`; the registry only treats catalog slugs as
  tools.
- Polling rate uses the median gap between coalesced timestamps rather than a
  per-second count, because the count dips whenever the hand slows; the count
  is still shown per second as a sanity check.
- Scroll test treats a lone opposite notch between two same-direction notches
  within 300 ms as a wrong-way scroll; a deliberate reversal takes longer than
  that, so it is not flagged.
- Burn-in auto cycle is gated by a consent tick (fastest step 1 s = 1 Hz, far
  below the 3 Hz photosensitivity threshold, but the whole screen changes
  colour so the gate stays). Manual stepping needs no consent. `ads => none`.
- Hearing test starts at 15% volume and never raises it; the copy repeats that
  the number depends on headphones and is not a medical result.
- Camera test asks for 1080p only; the resolution picker stays on the webcam
  test page so the two pages do not duplicate each other.

## Ali's steps after this merge

Nothing new. The 8 pages appear on the first visit after Hostinger deploys.
Check `/burn-in-test/` on a phone and the homepage (no "Coming soon" cards
should remain).

## What Phase 6 should do

Phase 6 is the SEO layer, per the Phase 1 handoff "What is left overall":

1. Hub pages: `content/hubs/<slug>.php` for all 8 hubs (keyboard, mouse,
   controller, screen, audio, camera, benchmark, phone) with intro, body guide,
   FAQ. Check `docs/content-format.md` for the hub file shape and
   `inc/registry.php` `tn_hub_is_live()` for how a hub goes live.
2. OG images: `assets/img/og/<slug>.jpg` (1200x630) per tool and hub, or a
   generator; the theme already picks them up when present.
3. IndexNow: key file + a ping on sync (see `inc/sync.php` for where pages are
   created/updated) and a sitemap check (WordPress core `wp-sitemap.xml` unless `inc/seo.php` overrides it).
4. Any remaining schema / meta polish (BreadcrumbList is already there; verify
   `SoftwareApplication` or `WebApplication` per tool if the plan calls for it).
5. Then Tier 2 tools + guides in later phases.

Local test setup: as in `docs/handoff/phase-3.md`, worked first time again.
Serve from inside `site/` with the router.
