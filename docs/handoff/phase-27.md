# Phase 27 handoff: audit 2, fix phase 3 (SEO and new content)

Date: 1 Nov 2026. From the 1 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-01/`), approved by Ali.
New CSS and JS, so `TN_VERSION` is now **0.7.6**. 117 -> **118 tools**,
41 -> **43 guides** (local sitemap: 182 URLs).

## What changed

| ID | File(s) | Change |
|---|---|---|
| S-14 | `content/tools/edpi-calculator.php`, `assets/js/tools/edpi-calculator.js`, `assets/css/tools/edpi-calculator.css`, `content/catalog.php` | New `/edpi-calculator/` (mouse hub): eDPI = DPI x sens, cm/360, inches/360, counts per 360, converter to another game and/or DPI, and a "same aim in every game" table. Yaw list lives once in the PHP file (`$tn_edpi_games`) and reaches the JS through `<option data-yaw>`. Games: CS2, Apex, TF2, Quake Live/Champions 0.022; Valorant 0.07; Overwatch 2, CoD (MW III/Warzone/BO6), Destiny 2 0.0066; plus "Other game (enter its yaw)". Fortnite, R6, Marvel Rivals left out on purpose (settings-dependent or unclear values). Validation: DPI 50-50,000, sens > 0, optional new DPI 50-50,000, custom yaw > 0, message in `#ed-msg` (`role="alert"`). Sources listed on the page (Valve wiki m_yaw, CSDB m_yaw + yaw table, VCRDB). Uses `screen-info.css` layout classes. No `share`, no stats. Catalog: `edpi effective` keywords moved from `dpi-analyzer` to the new tool (plus sensitivity converter, cm/360, game names). |
| S-14 links | `dpi-analyzer.php`, guides `what-dpi-should-i-use.php`, `mouse-accuracy-and-aim-training.php` | "sensitivity calculators" now link to the eDPI calculator; both guides link it in text and list it in `tools`. |
| S-15 | `content/guides/input-lag-vs-response-time.php` | New guide (screen hub; tool `ufo-test`, tools `refresh-rate-test`, `mouse-latency-test`): input lag vs GtG response time, half-frame floor table, what the UFO test can/cannot show, why a browser cannot measure monitor input lag, how RTINGS measures both (incl. their newer CAD metric). Sources: 3 RTINGS methodology pages, Wikipedia Display lag, TestUFO. Contextual links added in `ufo-test.php` FAQ and `mouse-latency-test.php` results. |
| S-17 | `content/guides/world-records-cps-typing-reaction-time.php` | New guide (benchmark hub; tool `cps-test`, tools `typing-speed-test`, `reaction-time-test`, `60-second-click-test`, `1-minute-typing-test`): Guinness most mouse clicks in one minute = 760 (Yigit Arslan, 10 Feb 2026, about 12.7 CPS); Guinness fastest typist on an electronic typewriter = 216 WPM (Stella Pajunas, 1946); Monkeytype 15 s = 304.76 WPM by Rocket (reported May 2024) clearly labelled a website leaderboard; reaction time: no record, World Athletics 0.100 s false-start rule, 2009 IAAF study (~0.08 s), Devon Allen 0.099 s (2022). Our leaderboards are called "a website leaderboard like any other". The unsourced CPS FAQ in `cps-test.php` ("well above 50 CPS") now gives the Guinness figure and links the guide. |
| F-59 | `dead-pixel-test.php`, `monitor-test.php`, `burn-in-test.php`, `refresh-rate-test.php`, guide `how-to-test-a-used-monitor.php` | Intro line "Check a whole monitor in 5 steps" / "guided monitor check" linking `/monitor-check/` (4 -> 9 inlinks). |
| F-46 | guides `how-to-test-a-used-monitor`, `mouse-accuracy-and-aim-training`, `why-is-my-upload-speed-slow`; `cps-test.php` | Descriptions now 149, 150, 145 and 157 characters (cps-test was 162 after phase 2's 15 s button). |
| F-46 check | `bin/check-pages.js` | Prints a warning (never fails) when `<title>` is over 65 characters (homepage exempt) or the meta description is over 160. |
| S-20 | `inc/config.php` | Not changed: Ali has not created the Testnook X/YouTube/Reddit accounts yet (asked 1 Nov 2026), so `TN_SOCIAL_PROFILES` stays `array()`. |

OG images generated and committed for the three new pages.

## Tested

Local WordPress (SQLite, phase-3 recipe, `WP_ENVIRONMENT_TYPE=local`):

- `bin/check.sh`: lint OK.
- `bin/check.sh http://127.0.0.1:8080 --wide`: 364/364 page loads pass (182 URLs at 390 and 1366 px), 0 length warnings after the fixes above (the first run flagged cps-test 162 and the input lag guide 171).
- Sitemap and `/llms.txt` list `/edpi-calculator/`, `/input-lag-vs-response-time/` and `/world-records-cps-typing-reaction-time/`.
- Playwright on `/edpi-calculator/`, 0 page errors. Cases worked by hand from the cited yaw values, all match the tool:
  - Valorant 800 DPI x 0.5 -> eDPI 400, 32.7 cm/360, CS2 1.591
  - CS2 2.0 @ 800 -> Valorant 0.629 (26.0 cm/360)
  - CS2 1.5 -> Overwatch 2 5.000
  - Overwatch 2 6.0 -> Valorant 0.566
  - Apex 2.0 -> CoD 6.667
  - Valorant 0.5 @ 1600 -> Destiny 2 5.303
  - Valorant 0.4 -> CS2 1.273 (40.8 cm/360)
  - CS2 1.0 @ 800 -> CS2 at 1600 DPI = 0.5; custom yaw 0.022 -> CS2 1.0 (51.95 cm/360, shown as "52 cm")
  - DPI 10, sensitivity 0, new DPI 60,000 and an empty custom target yaw each show their message and blank the affected outputs.
- Home search: "edpi", "sensitivity converter" and "cm/360" find the eDPI calculator.
- Link checks: cps-test, reaction-time-test, typing-speed-test link the records guide; ufo-test, mouse-latency-test, refresh-rate-test link the input lag guide; dpi-analyzer links the eDPI calculator; refresh-rate-test links /monitor-check/.
- All external sources in both guides and the tool opened (HTTP 200, or the page text was read) on 1 Nov 2026. The Valve wiki shows a bot check to scripts but opens in a browser.

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so `TN_VERSION` 0.7.6 assets load.
2. In Google Search Console, request indexing for the 3 new URLs (IndexNow fires on its own).
3. When the Testnook social accounts exist, send the URLs; they go into `TN_SOCIAL_PROFILES` in `inc/config.php` (one-line change).

## Notes for later phases

- New games for the eDPI tool: add a row to `$tn_edpi_games` with a yaw you can source, and add the source to `sources`.
- Monkeytype top scores change often; the records guide says so and links the live leaderboard. Re-check the Guinness click record on the next audit.
- Phase 4 (repo phase 28, speed/security incl. GA4 idle load) shares no files with this phase.
