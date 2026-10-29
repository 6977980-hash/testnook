# Phase 18 handoff: audit fix phase 1 (tools)

Date: 29 Oct 2026. Source: site audit of 29 Oct 2026, fix phase 1
(`phase-1-tools.md` in the project files). `TN_VERSION` 0.7.0 -> **0.7.1**
(JS and CSS changed).

## What changed

| ID | File(s) | Fix |
|---|---|---|
| F-01 | `assets/js/tools/reaction-time-test.js` | A click under 100 ms after green shows "Too early (anticipated)", is not added to the tries, the round count or the best. A click before the green frame was painted counts the same way. The rule is in the idle status line. Server minimum of 120 ms unchanged. |
| F-04 | `assets/js/tools/cps-test.js` (all CPS, click-length, right-click, jitter and auto-clicker pages) | `stop()` records `endedAt`; presses in the next 800 ms are ignored, then the stage adds "Result saved. Click again to restart." A press that arrives after the timer ran out but before the next frame ends the run instead of counting. Peak CPS updates live on every press. |
| F-09 | `assets/js/tools/typing-test.js` | US spellings: color, center, harbor, neighbor, gray, lumber yard. Lists stay ASCII. |
| F-28 | same | Live and final WPM use the same time base (seconds since the first key, capped at the test length) and both count the correct letters of the word in progress, so they agree at the end. The result text says "a wrong word also counts the space after it". |
| F-13 | `assets/js/tools/screen-info.js`, `content/tools/ppi-calculator.php`, `content/tools/aspect-ratio-calculator.php` | PPI: invalid input resets every output and the verdict explains the limits (1-32,768 px, diagonal 1-200 in / 2.54-508 cm); switching in <-> cm converts the diagonal (24 in -> 60.96 cm); `max` attributes added. Aspect ratio: invalid input resets ratio, decimal, note, preview label and sizes; inputs capped at 32,768; when the size is a rounded standard ratio (1366 x 768) the sizes list uses the standard ratio and says "(16:9, rounded)". |
| F-14 | `assets/js/tools/dpi-analyzer.js`, `content/tools/dpi-analyzer.php` | Distance must be 0.5-100 (cm or in) before a run starts, otherwise a status message. |
| F-22 | `assets/js/tools/internet-speed-test.js` | An upload failure keeps ping and download, shows "Not measured" for upload, and the summary says "upload could not be measured (...)". The "good for" rows that need upload say "Upload not measured". History saves the run with upload "-". |
| F-23 | `assets/js/tools/what-is-my-ip.js`, `content/tools/what-is-my-ip.php`, `assets/css/tools/system.css` | New `ISP` keyword list. When the RDAP owner matches neither `HOSTING` nor `ISP`, the verdict reads "Owner: X (business or hosting network)". When the hero IPv4 and the ipify IPv4 differ, the IPv4 row adds "Your network uses more than one exit address" (`#ip-multi`). |
| F-21 | `inc/leaderboards.php` | `tn_leaderboard_widget()` keeps `$boards[0]` as the board shown first but lists the select in natural order and marks it `selected` (CPS 1, 5*, 10 ...; aim Static 16, 28*, 40 ...). Applies to tool pages too. |
| S-01 | `inc/results.php`, `assets/css/main.css`, `docs/content-format.md` | `TN_RESULTS_MIN_COUNT` 20 -> 10. The stats block now prints, for boards under the minimum, "5 second click test: 4 results so far, stats appear at 10." (or "no results yet"). Empty leaderboard text: "No scores yet. Be the first: ...". Plausibility caps unchanged. Guide data sections also unlock at 10. |
| S-07 | `content/catalog.php`, `inc/helpers.php`, `inc/guides.php`, `assets/js/site.js` | Optional `keywords` per tool (36 tools: hz, ping, ip, mic, cam, wpm, cps, dpi ...). Search matches every word at a word start; name matches rank first, then keywords, then blurb/hub; tools before guides; a tool in two hubs shows once in a "Search results" section; the hub chips hide while searching. Guide cards now carry `data-search` too, and the Guides section on the homepage is no longer hidden by the filter. |

## Tested

Local WordPress (recipe in phase-3.md) with Playwright:

- Reaction: click 20 ms after green -> "Too early (anticipated)", log empty;
  a 250 ms click is recorded.
- CPS: 60 clicks in 5 s then 3 clicks over the next 600 ms -> result still
  "12.0 CPS", Peak CPS 14.0 shown during the run, "Result saved" after 800 ms,
  next click restarts. 1-second test keeps its result after a late click;
  1 s / 100 s / right-click pages load.
- Typing script has no British spellings and is ASCII only.
- PPI: diagonal "" -> all 7 outputs "-"; 24 in -> 60.96 cm -> 24 in with the
  same PPI; width 99,999 and diagonal 500 rejected. Aspect: 1366 x 768 lists
  "1920 x 1080 (16:9, rounded)"; empty height resets everything.
- DPI: distance -10 -> "Enter a distance between 0.5 and 100 cm".
- Leaderboards: CPS select 1, 5 (selected), 10, 15, 30, 60, 100.
- Home search: "hz" -> Refresh Rate first, then polling rate, FPS, UFO;
  "ping" -> Ping Test first; mic, headphone, speaker, dead pix, wpm,
  controller -> no duplicates.
- Mocked network: upload blocked -> download kept, upload "Not measured";
  RDAP owner "Acme Widgets GmbH" -> business verdict; different IPv4s -> note.
- Stats block with 4 seeded cps-5 results -> "4 results so far"; 12 reaction
  results -> full stats.
- Gate: 22 changed pages at 375 px (iPhone 13) and 1366 px: 0 page errors, no
  horizontal overflow, JSON-LD parses, 171 internal links all 200.

## Ali's steps after this merge

1. Purge the cache in Hostinger (hPanel -> Website -> Cache) if a page still
   shows the old behaviour.
2. Try `/reaction-time-test/` (click too early on purpose) and `/cps-test/`
   (keep clicking after the timer ends) once.

## Next

Audit fix phase 2 (`phase-2-crawl-seo.md`, repo `docs/handoff/phase-19.md`).
Phase 3 (content and trust) still owns the "nothing leaves your device" text
(F-02) seen on the homepage hero; this phase did not touch it.
The remaining roadmap from phase-17.md carries forward unchanged.
