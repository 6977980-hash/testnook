# Phase 11 handoff: Tier 2 batch 5a (eye tests, screen info pages)

Date: 29 Oct 2026. Branch `claude/project-thread-p5g0l0`, merged to `main`.

## What was built

10 new tool pages and 1 new hub (86 tools, 11 hubs). Same recipe as every
phase: catalog entry, `content/tools/<slug>.php`, script, CSS,
`assets/img/og/<slug>.jpg`.

### Hub

| Hub | URL | Notes |
|---|---|---|
| Eyes | `/vision-test/` | catalog key `vision-test`, nav name "Eyes", new icon `eye` in `inc/icons.php`. The tool slug `eye-test` is the acuity chart, so the hub uses `vision-test`. The body opens with the medical disclaimer box, then which test to take, how to get a fair result, when to see an eye doctor. |

The header now has 11 links, so the mobile-nav breakpoint in
`assets/css/main.css` moved from 1000px to 1180px (at 1001-1170px the logo
was squeezed and the theme toggle clipped). Checked: one row and no
overflow from 1181px up.

### Tools

| Page | Hub (also) | Ads | Device | Script / CSS | Notes |
|---|---|---|---|---|---|
| `/red-green-color-blind-test/` | vision-test | standard | any | `red-green-color-blind-test` | 12 generated dot plates (not Ishihara copies): 1 luminance control, 9 red-green plates getting fainter, 2 two-digit classification plates. Colours come from the Machado 2009 dichromat matrices: screening plates differ along a direction between the protan and deutan null vectors around an olive centre (sRGB 150,150,95); classification plates draw the left digit along the protan null vector and the right along the deutan one, so protans read only the right digit and deutans only the left. Every dot gets a random brightness (x0.72-1.22) to hide luminance cues. Checked by simulating protan/deutan on screenshots: the number vanishes. |
| `/color-vision-test/` | vision-test | standard | any | `color-vision-test` | D-15 style: reference cap + 15 caps on a CIELAB hue circle (L60 C34, "Pale" L72 C16), tap to place, tap to take back, Undo/Reset. Score: major crossings (gap > 2 caps), confusion index (path dE / perfect path dE), type = the simulated dichromat (protan/deutan/tritan) whose view makes the order smoothest. SVG score diagram. `root.cvSimulate(type)` / `root.cvPlace(order)` exist for automated checks. |
| `/eye-test/` | vision-test | content | any | `screen-cal` + `eye-test` | Tumbling E on exact 5x5 units, 20/20 = 5 arcmin at the chosen distance (40 cm, 1, 2, 3, 6 m); 5 letters per line, 3 right pass, 3 wrong end; lines under 5 device px or taller than the stage are skipped ("or better (screen limit)"). Per-eye results in 20/x and 6/x. Letter chart mode (bold Arial letters from the Sloan set, labelled as approximate). Arrow keys or on-screen buttons, full screen. |
| `/astigmatism-test/` | vision-test | standard | any | `astigmatism-test` | Clock dial (triple lines every 30°) and fan (single lines every 15°); tap the darkest lines -> clock pair + axis by the rule of 30; per eye. |
| `/blind-spot-test/` | vision-test | content | any | `screen-cal` + `blind-spot-test` | Measure mode: dot moves out from the cross at 1.6°/s, space / tap / button marks gone and back -> start, end, centre, width in degrees (normal 12-18°). Classic mode (dot at 15.5°), Fill-in demo. Warns when the screen is too narrow for 20°. |
| `/screen-resolution/` | screen (phone) | standard | any | `screen-info` | Physical px (CSS x DPR), CSS size, scaling %, DPR, viewport, available area, depth, megapixels, name (Full HD, QHD...), copy button, common resolutions table with your row highlighted. |
| `/screen-size/` | screen (phone) | standard | any | `screen-cal` + `screen-info` | Diagonal/width/height from the card calibration (says "rough guess" when uncalibrated), plus diagonal + ratio calculator. |
| `/screen-ratio/` | screen | standard | any | `screen-info` | Common name, exact reduced ratio (long:short), decimal, viewport ratio, outline of your screen next to 4:3...32:9 boxes. |
| `/aspect-ratio-calculator/` | screen | standard | any | `screen-info` | W1/H1 -> W2 or H2, presets (16:9, 4:3, 16:10, 21:9, 1:1, 3:2, 4:5, 9:16, my screen), rounding, swap, preview box, standard sizes list. |
| `/ppi-calculator/` | screen | standard | any | `screen-info` | Resolution + diagonal (in/cm) -> PPI, PPCM, dot pitch, size, ratio, MP, "pixels vanish beyond" (1 arcmin), verdict; 12 presets; "Use my screen". |

All five eye pages set `disclaimer` (medical) and also show a short
"Screening only" `notice--warn` right under the tool.

Shared code:

- `content/tools/_screen-cal.php` returns `$cal( $open )`, the calibration
  box markup (bank card slider + screen diagonal + reset).
  `assets/js/tools/screen-cal.js` + `screen-cal.css` wire it and expose
  `window.TNScreenCal` (`ppi()`, `pxPerMm()`, `calibrated()`, `onChange(fn)`).
  It stores CSS px per inch in localStorage `tn-ruler-ppi`, the same key as
  the online ruler, so one calibration serves the ruler, eye test, blind
  spot test and screen size. On screens narrower than 560px the card's short
  side (53.98 mm) is matched instead of the long side. List `screen-cal`
  before the tool script in `scripts` (deferred scripts run in order).
- `assets/js/tools/screen-info.js` + `screen-info.css` serve the five screen
  pages and fill whatever exists (`[data-si]`, `#si-res-table`, `#sz-*`,
  `#ar-*`, `#pp-*`). The resolution name map and the ratio list are at the
  top of the file.
- Hubs: screen (new "Screen resolution, size and ratio" section, intro),
  phone (screen resolution/size sentence).

## Tested

Local WordPress 6.9 on SQLite (Phase 3 recipe). Playwright audit over all
97 content pages (86 tools + 11 hubs) at 1280 px and iPhone 13: 200, title
50-60, description 150-160, 6 FAQs, 8 related cards on tools, own OG image,
valid JSON-LD, no console errors or page errors, no horizontal scroll, no
"Coming soon"; every internal link resolves 200. Sitemap 102 URLs, homepage
`debug.log` clean. Four older Tier 1 pages sit just outside the audit's
ranges and were left as they are (not this phase's pages): descriptions of
`fps-test` (165), `sound-test` (162), `speaker-cleaner` (161) and the
`webcam-test` title (44 chars). A future SEO tidy-up can trim them.

Interactions (Playwright): red-green test runs 12 plates and scores; plates
checked through protan/deutan simulation. Colour vision: perfect order =
normal (CI 1.00); simulated protan, deutan and tritan orders are classified
as protan (7 crossings), deutan (12) and tritan (4), in both versions. Eye
test: answering by reading the E off the canvas passes lines down to the
pixel limit; wrong answers end the eye; chart mode draws. Astigmatism: tap
at 12 o'clock gives "6 and 12 o'clock, axis about 180°". Blind spot: marks
at 4.5 s and 7.5 s gave 12.2° to 17.0°, "normal range"; too-narrow warning
on iPhone portrait. Screen pages: resolution at DPR 1.25 and on iPhone 13
(1170 x 2532, 300%, 19.5:9); card calibration changes the size; 34" 21:9
calculator; aspect 1920x1080 -> 1280 x 720 and H2 1440 -> 2560; 1366 x 768
= 683:384, closest 16:9; 4:5 -> 1080 x 1350; PPI 27" 1440p = 108.8, 27" 4K
= 163.2, cm input gives the same. Nav: one row at 1181-1280 px.

Not testable here: real colour vision of a person, real viewing distance,
physical card matching. Ali should try on a laptop and phone after the
deploy: `/vision-test/`, calibrate on `/eye-test/` with a card, and
`/screen-resolution/` on both.

## Decisions

- Hub slug `vision-test` (not `eye-test`), so `/eye-test/` can be the chart
  people search for.
- Dot plates and D-15 caps are generated, not copied (Ishihara and
  Farnsworth materials are copyrighted). The pages say so.
- Eye test and blind spot use `ads => content` (no slot under the chart /
  moving dot); the other eye and screen pages use `standard`.
- Screen size never claims inches without calibration: it shows a "rough
  guess" note at 96 CSS px per inch.
- Screen info pages stay in the screen hub (resolution and size also in
  phone); no separate "system" hub yet.

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/vision-test/` (new
   "Eyes" link in the header) and `https://testnook.com/screen/`.
2. On a laptop: `/eye-test/`, open "Calibrate to your screen", match a bank
   card, then check `/screen-size/` shows your real screen size.
3. Search Console: resubmit `https://testnook.com/wp-sitemap.xml`. IndexNow
   pings the new URLs on the first production request.

## Remaining roadmap (carry this forward in every handoff)

Ali approved on 28 Oct 2026 a dedicated "moat" phase after Tier 2 and
before Tier 3. Suggested order:

1. **Phase 12: Tier 2 batch 5b**: monitor pages (`monitor-test`, `lcd-test`,
   `display-test`, `oled-test`, `monitor-color-test`, `monitor-calibration`),
   `zoom-test`, `battery-health-test`, `dog-whistle`,
   `white-noise-generator`, `keyboard-ghosting-test`, `mouse-accuracy-test`,
   `mouse-latency-test`, `controller-vibration-test`, `joy-con-drift-test`,
   and optionally `typing-test-urdu` / `typing-test-hindi`. Split again if
   it is more than ~12 pages (for example 12a monitor + zoom + battery +
   audio generators, 12b input device pages). `screen-cal.js` can serve
   `monitor-calibration` and `zoom-test`; `dead-pixel-test.js` has the
   full-screen colour overlay for the monitor pages.
2. **Phase 13: Moat phase** (approved by Ali, do not build before Tier 2 is
   done): (a) anonymous aggregate data: average reaction time, average CPS,
   average WPM, dead pixel location stats, collected with consent and shown
   on the tool pages; (b) leaderboards for CPS (the 7 fixed-length pages
   are natural boards), typing and reaction time; (c) an embed widget:
   iframe code for every tool (embed mode `?embed=1` already exists; add a
   copy-the-code box and a per-tool embed page or section). Needs a small
   server side (REST endpoint + table) and an abuse/rate-limit plan; design
   it in its own thread first.
3. **Phase 14+: Tier 3**: 3-5 troubleshooting guides per tool (stick drift
   fixes, keyboard key not working, webcam/mic not working, average reaction
   time by age, what is a good CPS, average typing speed by age, is 144hz
   worth it, what is 20/20 vision, types of colour blindness, etc.), phone
   sensor pages (gyroscope, accelerometer, compass, proximity, GPS),
   internet tools, browser info tools (then consider a `system` hub and move
   device-info, user agent, what-phone and the screen info pages there by
   changing their `hub` key).

Recipe unchanged: catalog entry, `content/tools/<slug>.php`, script, CSS,
`python3 bin/make-og-images.py`, commit the JPEGs, Playwright pass at
1280 px and iPhone 13, merge to `main`, write `docs/handoff/phase-N.md`.
A 12th hub would need the nav breakpoint raised again or the hub names
shortened.

Local test setup: as in `docs/handoff/phase-3.md`, with
`define( 'WP_ENVIRONMENT_TYPE', 'local' );` in `wp-config.php`.
