# Phase 29 handoff: audit 3, fix phase 1 (tool accuracy and stats)

Date: 27 Nov 2026. From the 27 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-27/`, handoff
`phase-1-tools-stats.md`), approved by Ali. JS and CSS changed, so
`TN_VERSION` is now **0.7.8**. No new tools or guides (still 118 tools, 43
guides, 182 URLs).

## What changed

| ID | Files | Change |
|---|---|---|
| F-62 | `assets/js/tools/typing-test.js`, `content/guides/average-typing-speed.php` | Every key that adds a character (and every space) is counted when pressed, by comparing the field with its previous value (`track()`), so keys later removed with Backspace still count. `okKeys` = keys that matched the target letter at that moment; a space is right when the word was right. Accuracy = `floor(okKeys / keys)`, raw WPM = `keys / 5 / minutes`. WPM is unchanged (correct characters / 5). Wrong letters deleted before the word ends are reported as "N corrected" in the result line and status. The "Characters" stat is now "Keys". Guide sentence: accuracy is "the share of the keys you pressed that were right"; raw counts every key pressed incl. deleted mistakes. The leaderboard's 85% accuracy gate now sees the real number. |
| F-74 | `content/tools/_typing-test.php`, `typing-test.css` | One line under the typing result on all 5 typing pages: "WPM = correct characters ÷ 5 per minute; raw counts every key you pressed", linking to `/average-typing-speed/#how-wpm-works`. |
| F-63 | `inc/results.php`, `assets/js/tools/cps-test.js` | `TN_CPS_MIN_PRESSES = 3`: `tn_rest_result` refuses any `cps-*` result with `round(value x seconds) < 3` (answered `implausible`, like other out-of-range scores); `cps-1` `min` is 3. `cps-test.js` only calls `TNStats.submit` with `count >= 3`. One-time cleanup `tn_results_cleanup()` on `init` (priority 31) behind option `tn_cleanup_cps1_v1`: deletes every `cps-*` row under 3 presses, flushes those leaderboards and calls `tn_stats_refresh_all()`. The option is set first, then rewritten as `<date> deleted <n>`; delete the option to run it again. `TN_RESULTS_MIN_COUNT` 10 -> **25** (stats and guide numbers appear at 25 results; under that: "n results so far, stats appear at 25"). |
| F-69 | `cps-test.js`, `screen-info.js` | "1 click in 1 second" singular/plural. Screen size calculator refuses diagonals outside 1-200" ("Enter a diagonal of 1 to 200 inches."). |
| F-67 | `screen-info.js` | Monitor class (18-50") verdict is now worded from the same 1-arcminute distance as "Pixels vanish beyond", against arm's length 60-80 cm: <= 60 cm very sharp, <= 80 sharp, <= 110 standard (visible at arm's length), <= 150 coarse, else low. Phone, laptop and TV classes unchanged. |
| F-68 | `screen-info.js`, `aspect-ratio-calculator.php` | Up to 3 decimal places are scaled to integers before reducing (8.5 x 11 -> 17:22, 21 x 29.7 -> 70:99). Emptying W2 clears H2 and vice versa. FAQ "The ratio shows a long decimal" updated to match. |
| F-71 | `mouse-polling-rate-test.js`, `.php` | When the median report gap is < 0.3 ms (timestamps are rounded to ~0.1 ms at 4-8 kHz), the rate comes from the per-second count and the interval shows "under 0.3 ms". Stat label "Measured rate" -> "Median rate". FAQ updated. |
| F-72 | `reaction-time-test.js`, `reaction-time-test.php`, `content/guides/average-reaction-time.php` | Labels: < 200 Very fast, 200-250 Good, 250-300 Average, >= 300 Slower than average. Log colours: fast < 200, slow >= 300. Tool table and guide list use the same four bands (guide keeps the "over 400 ms, retry rested" advice inside the last band; the tool table notes the screen and mouse add about 20-50 ms). |
| F-75 | `content/tools/edpi-calculator.php` | Default outputs (eDPI, cm/360, in/360, counts, converted sensitivity and note, the 8 "Same aim in every game" rows) are printed in PHP from the same yaw list with the JS formatting, so the script only replaces identical text. |
| F-70 | none | Not changed. The only public converter we could open with a CoD yaw (csdb.gg) lists MW III, Warzone and Black Ops 6 at 0.0066; none we could open names Black Ops 7 (mouse-sensitivity.com answers 403). The label stays "Call of Duty (MW III, Warzone, Black Ops 6)". |
| S-32 | `online-ruler.js`, `online-ruler.php`, `online-ruler.css` | "Show a length" field under the ruler: accepts `1.5 in`, `1.5"`, `1.5inch`, `8.5 cm`, `8,5cm`, `10 mm` (a bare number uses the current unit). Draws the highlighted span from the zero mark (reuses the drag overlay), redrawn on unit, orientation, resize and calibration changes; a drag replaces it. Reads `?show=` on load and writes it with `history.replaceState` (canonical stays `/online-ruler/`). Not calibrated: "Calibrate first: until then the bar assumes 96 px per inch and is only approximate." Too long: says so with the ruler length. Invalid: "Enter a length such as 1.5 in, 8.5 cm or 10 mm." New H2 "Show an exact length on your screen", a how-to step and an FAQ. The field is a `div` (the tool markup goes through `wp_kses`, which strips `<form>`). |

## Tested (local WordPress, SQLite, phase-3 recipe)

- `bin/check.sh`: lint OK. `bin/check.sh http://127.0.0.1:8080 --wide`: **364/364** page loads pass.
- Playwright scripted cases (no page errors):
  - Typing, `/wpm-test/` 15 s: typo-then-Backspace on every 4th key -> 78% shown, 78% expected from the key count (566 keys, 123 wrong), raw > WPM, "0 errors, 123 corrected". Clean run -> 100%, raw = WPM.
  - CPS 1 s with the server faked: 1 and 2 presses -> no `/result` post ("1 click in 1 second"); 3 and 5 presses -> posted.
  - Server: `cps-1` value 1 and 2.9 -> `implausible`; `cps-5` 0.4 -> `implausible`; `cps-5` 0.6 passes the check (fails only on the fake ticket).
  - Cleanup: seeded 5 x 1.0, 2 x 2.0, 1 x 3.0, 24 x 6.5 on `cps-1` and 0.4 on `cps-5`; first request deleted 8 rows, `/stats?board=cps-1` -> count 25, lowest quantile 3.0; second run deletes nothing. `/10-second-cps-test/` with 12 rows -> "12 results so far, stats appear at 25".
  - PPI: 24" 1080p -> "Standard monitor density: pixels are visible at arm's length (60-80 cm) if you look closely; they vanish beyond 95 cm." 27" 4K -> "Very sharp ... invisible at arm's length; ... beyond 54 cm." 27" 1440p -> sharp, 80 cm.
  - Aspect: 8.5 x 11 -> 17:22; 21 x 29.7 -> 70:99; 1.23456 x 1 -> 1.2346:1; emptying W2 clears H2.
  - Screen size: 500 and 1,000,000,000 refused; 27 works.
  - Reaction (pointerdown timed in-page): 179 ms Very fast, 228 Good, 272 Average, 308 Slower than average.
  - eDPI at 1366 px: CLS **0**; HTML already holds 400 / 32.7 cm / 1.591 and 8 rows.
  - Ruler at 96 px/in: `?show=1.5in` and `?show=1.5"` -> 144 px, `8.5cm` -> 321 px, `10mm` -> 37.8 px; `abc` -> message; `500cm` -> too long message; typing "2 in" -> 192 px and URL `?show=2in`; canonical `/online-ruler/`; uncalibrated -> 144 px + "Calibrate first".
- Not testable headless: a real 4-8 kHz mouse for F-71.

## Live checks (27 Nov 2026, after PR #34 deployed)

- Hostinger deployed within a few minutes; fresh pages (`?nc=`) load `ver=0.7.8`.
- `bin/check.sh https://testnook.com`: 182/182 page loads pass.
- Cleanup ran: `/wp-json/testnook/v1/stats?board=cps-1` now has 6 results (the audit saw 10, incl. 3+ single-click runs); `/1-second-cps-test/` prints "6 results so far, stats appear at 25".

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so 0.7.8 loads.
2. Nothing else. The CPS cleanup runs by itself on the first request after the deploy.

## Notes for the next phases

- Stats now need 25 results per board before numbers show; guides with `{median:...}` placeholders keep showing the "results so far" line until then.
- Phase 2 (repo phase 30) owns hubs, guides (except the two sentences edited here), catalog and header/footer.
