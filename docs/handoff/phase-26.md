# Phase 26 handoff: audit 2, fix phase 2 (tools and small UX)

Date: 1 Nov 2026. From the 1 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-01/`), approved by Ali.
CSS and JS changed, so `TN_VERSION` is now **0.7.5**.

## What changed

| ID | File(s) | Change |
|---|---|---|
| F-49 | `content/tools/cps-test.php` | Intro: "a rank from Turtle to Lightning" (top rank in `_bands.php`). |
| F-58 | `content/tools/cps-test.php`, `assets/css/tools/cps-test.css` | New 15 s button (`data-cps-t="15"`, already mapped to board `cps-15` in `cps-test.js`); description lists 15. Under 560 px the length buttons sit on one row in equal grid columns (works for the 4-7 button variants on the right-click, jitter and auto-clicker pages too). |
| F-60 | `assets/js/tools/cps-test.js`, `templates/tool.php`, `assets/js/stats.js` | After a run: "Your best is kept in this browser. Click again to restart." (no "Result saved"). On every stats tool the trust badge is `<span data-tn-share-badge>`; `stats.js` sets it to "Score sharing is off" when `tn-share-off` is set and flips it when the visitor uses Turn off / Turn on. Tools with a custom `trust` string are unchanged. |
| F-42 | `assets/js/tools/screen-info.js` | New `ppiVerdict(ppi, diagonalInches)`: class by diagonal (< 11 phone/tablet, 11-18 laptop, 18-50 monitor, >= 50 TV) with PPI steps and viewing distance per class. Maths unchanged. 15.6" FHD -> laptop wording, 55" 4K -> TV wording. |
| F-45 | `content/tools/aspect-ratio-calculator.php`, `screen-info.js` | Preset is `data-ar="64:27"`, label "21:9 (64:27)", sizes include 2560 x 1080 and 5120 x 2160. When the closest ratio is 21:9 the note adds that 2560 x 1080 is 64:27 and 3440 x 1440 is 43:18. Common-ratios table row updated. |
| F-57 | `assets/js/tools/screen-cal.js`, `content/tools/_screen-cal.php`, `screen-info.js`, `assets/css/tools/screen-cal.css` | `TNScreenCal.source()` returns `card`, `diag` or ''. A typed diagonal is remembered in `localStorage['tn-ruler-ppi-src'] = 'diag:<ppi>'` and only counts while it matches the stored ppi (the ruler writes `tn-ruler-ppi` alone). Screen size note has separate wording for card vs typed diagonal. Out-of-range diagonal shows "Enter a diagonal between 3 and 100 inches." (`#sc-diag-msg`, `role="alert"`). |
| F-47 | `assets/js/tools/refresh-rate-test.js` | 60 Hz line: "it is probably running at 60 Hz right now: check the display setting, the cable and port, power saving and the browser notes below." |
| F-53 | `content/catalog.php`, `assets/js/site.js` | Keywords: grey/gray/color/colour on the colour screens and colour tests, "stuck pixel"/"dead pixel" both ways, edpi on the DPI analyzer, bluetooth/gamepad on the controller pages, grey on white noise. Home search now forgives one typo (missing, extra, changed or swapped letter) for words of 5+ letters, matched against names and keywords only, ranked below real matches ("controler", "keybaord" work). |
| F-54 | `content/tools/_typing-test.php`, `assets/css/tools/typing-test.css` | Overlay text centered with padding; under `(pointer: coarse)` it reads "Tap here to start typing" (the overlay is still hidden on touch devices by the JS, as before). |
| F-56 | `assets/js/tools/online-ruler.js` | "centimeters (1 mm marks)". |
| S-16 | `content/tools/_stick-drift.php`, `content/tools/stick-drift-test.php`, `assets/js/tools/stick-drift-test.js`, CSS | Second table under the drift tiers: circularity under 10% Round, 10-20% Fair, over 20% Check, with a note that these are rules of thumb and Xbox/PlayStation pads read past 100% on diagonals. `#sd-circ0/1` is coloured by band (`sd-good/warn/bad`, title Round/Fair/Check this stick). Shared with the Joy-Con page. Results text mentions the bands. |
| S-21 | `inc/leaderboards.php`, `assets/js/leaderboard.js`, `assets/css/main.css` | Board with 1-2 entries: a "First scores" label (`.lb__first`, a `<p>`, not a heading) above the table and the invite line stays visible: "Early days: this board has just started. Be one of the first scores: ...". 0 entries keeps "No scores yet. Be the first: ...". Ali's real typing entry is untouched. |

## Tested

Local WordPress (SQLite, phase-3 recipe, `WP_ENVIRONMENT_TYPE=local`):

- `bin/check.sh`: lint OK.
- `bin/check.sh http://127.0.0.1:8080 --wide`: 358/358 page loads pass (179 URLs at 390 and 1366 px).
- Playwright (35 checks, all pass, 0 page errors): CPS intro says Lightning; 15 s button runs a 15 s test (fake clock); with sharing off the badge says "Score sharing is off" and the end text has no "Result saved"; badge default with sharing on; 7 length buttons on one row with no clipping at a 375 px window and on iPhone 13. PPI 1920x1080 15.6" -> laptop, 3840x2160 55" -> TV, 2560x1440 27" -> monitor, 1170x2532 6.1" -> phone. 21:9 button -> 2560 x 1080. Refresh 60 Hz message has no "it is set". Home search: grey, colour, edpi, stuck pixel, dead pixel, bluetooth, controler, keybaord each find the right tool. Ruler says centimeters. Screen size: 500 shows the range message, 15.6 gives the typed-diagonal note (also after reload). Typing overlay centered at 375 px. Stick drift with a fake gamepad: 25% circularity -> red, 0% -> green, table visible. /leaderboards/ with one seeded entry per board shows "First scores" and the early-days line; empty board keeps "No scores yet".

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so `TN_VERSION` 0.7.5 assets load.
2. Optional: open `/stick-drift-test/` with a controller and rotate each stick to see the coloured circularity value.

## Notes for later phases

- Phase 3 (repo phase 27) adds an eDPI tool: move the `edpi` keyword from `dpi-analyzer` to the new tool in `content/catalog.php` (or keep both).
- `TNScreenCal.source()` is available to any tool that uses `screen-cal.js`.
- Stats tools without a custom `trust` string get the live badge automatically.
