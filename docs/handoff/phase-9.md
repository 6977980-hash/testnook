# Phase 9 handoff: Tier 2 batch 3 (memory, typing, auto clicker)

Date: 29 Oct 2026. Branch `claude/project-thread-ejsfe8`, merged to `main`.

## What was built

12 new tool pages and 2 new hubs (60 tools, 10 hubs). Same recipe as every
phase: catalog entry, `content/tools/<slug>.php`, script, CSS,
`assets/img/og/<slug>.jpg`.

### Hubs

| Hub | URL | Notes |
|---|---|---|
| Memory | `/memory-test/` | catalog key `memory-test`, icon `memory`. 6 tools. Guide text covers phonological loop vs visuospatial sketchpad, typical scores, "not diagnostic". |
| Typing | `/typing-test/` | catalog key `typing-test`, icon `typing`. 5 tools. Guide text covers the WPM formula, averages, how to type faster. |

The header nav now has 10 links, so the mobile-nav breakpoint in
`assets/css/main.css` moved from 900px to 1000px (10 links overflowed and
caused horizontal scroll between 900 and 960px).

### Tools

| Page | Hub (also) | Ads | Device | Notes |
|---|---|---|---|---|
| `/memory-game/` | memory-test | content | any | Card pairs, 4x3 to 8x6, pictures (emoji) / numbers / letters, moves, time, accuracy, best per board size. |
| `/chimp-test/` | memory-test (benchmark) | content | any | 8x5 grid, numbers hide on clicking 1, starts at 4, three strikes. Score = level reached when the third strike lands (same convention as the best score). |
| `/number-memory-test/` | memory-test | content | any | Digit span, shown for max(2 s, 1 s + 1 s/digit), typed back; wrong digits underlined red. `<form>` is not in the KSES allow-list: the answer box is a `div` with Enter handled in JS. |
| `/visual-memory-test/` | memory-test | content | any | Pattern of level+2 tiles on a grid that grows 3x3 to 10x10 every two levels; 3 misses in a level = 1 life, 3 lives. |
| `/sequence-memory-test/` | memory-test | content | any | Simon on 3x3; gap shrinks 700 to 380 ms with level; one mistake ends it. |
| `/verbal-memory-test/` | memory-test | content | any | ~200 everyday nouns, SEEN/NEW buttons or S/N/arrow keys, 3 lives; the chance of a repeat grows with the seen pool (15% + 3%/word, max 50%). |
| `/typing-speed-test/` | typing-test (benchmark, keyboard) | content | any | 30 s / 1 / 2 / 5 min on common words. |
| `/1-minute-typing-test/` | typing-test | content | any | Fixed 60 s on sentences. |
| `/5-minute-typing-test/` | typing-test | content | any | Fixed 300 s on sentences. |
| `/wpm-test/` | typing-test | content | any | 15 / 30 / 60 s on words; copy explains the formula and WPM vs CPM. |
| `/typing-test-english/` | typing-test | content | any | 1 / 2 / 5 min on sentences with punctuation. |
| `/auto-clicker-test/` | benchmark (mouse) | content | desktop | `cps-test.js` with `data-cps-mode="auto"`. |

Shared code:

- `assets/css/tools/memory.css` is shared by all six memory pages
  (`styles => array('memory')`); each has its own script.
- `assets/js/tools/typing-test.js` + `typing-test.css` are shared by the five
  typing pages. `content/tools/_typing-test.php` returns a function
  `$tool( $lengths, $default, $source )` that builds the markup (like
  `_colour-screen.php`). The stage carries `data-tt-text` (`words` |
  `sentences`) and `data-tt-dur`; `[data-tt-t]` buttons change the length.
  Word source: 483 common English words; sentence source: 40 plain prose
  sentences, never the same one twice in a row. Scoring: net WPM = correct
  characters (incl. the space after a correct word) / 5 / minutes; raw WPM
  counts everything; accuracy = correct / typed; a partially typed last word
  counts its correct letters. Best per page and length saved only at
  accuracy >= 90%. Hidden input on desktop (overlay says click to start),
  visible input on coarse pointers. Tab restarts, paste is blocked, hiding
  the tab resets.
- `assets/js/tools/cps-test.js` auto mode: counts left and right buttons,
  ignores `touchstart` (synthetic taps come through as pointer events), the
  duplicate-event guard drops from 8 ms to 0.5 ms, every press time is
  recorded, and `#cps-interval` / `#cps-spread` show the mean gap and
  SD (+ CV%). Verdict: `Automated` when CV < 8% over >= 20 clicks,
  `Probably automated` under 20%, otherwise `Looks human`. Note the stage
  starts a new run on the first click after a run ends (same as cps-test),
  so a clicker left running past the timer begins a second run.
- `inc/helpers.php` input allow-list gains `autocorrect`, `autocapitalize`,
  `spellcheck`, `enterkeyhint`, `pattern`.
- `inc/icons.php`: `memory` and `typing` icons.
- Hubs `benchmark` (seo_title shortened to 55 chars, new section linking
  typing, memory and auto clicker), `keyboard` and `mouse` link the new pages.
  `related` updated on cps-test, jitter-click-test, right-click-cps-test,
  stroop-test, keyboard-tester, spacebar-clicker.

## Tested

Local WordPress 6.9 on SQLite (Phase 3 recipe). Playwright audit over the 12
tool pages and the memory-test, typing-test, benchmark, keyboard and mouse
hubs at 1280 px and iPhone 13: 200, title 50-60, description 140-160, 6
FAQs, 8 related cards, own OG image, valid JSON-LD, tool script enqueued, no
console errors or page errors, no horizontal scroll, no "Coming soon"; every
internal link in each page body resolves 200. Embed mode noindex + tool
renders. Sitemap 75 URLs incl. both hubs and `/1-minute-typing-test/`.
Homepage 81 cards, 10 hub sections, 10 nav links; header checked at 1024,
1001, 1000, 960 and 920 px (no overflow). `debug.log` clean.

Interactions (Playwright, desktop): memory game 4x3 solved in 6 moves with
best saved; chimp test 3 rounds then 3 strikes ends at 7 with best 7;
number memory 3 levels correct then a wrong answer scores 3 with the diff
shown; visual memory 3 levels then 3 lives lost at level 4; sequence memory
5 levels replayed then a wrong tile ends at level 5; verbal memory 40
correct by keys then 3 wrong by buttons scores 40/43; WPM test 15 s typed
by script reports WPM/raw/accuracy/errors, Tab/Restart resets, English test
shows sentences with capitals and punctuation, 5 minute page shows 5:00 and
no length buttons; auto clicker: 90 synthetic clicks at 50 ms read 18.0
CPS, gap 50.0 ms, 3% variation, "Automated"; random 100-220 ms gaps read
20% variation, "Looks human". iPhone: typing input visible, chimp grid
fits. Screenshots in project files: `phase-9-memory-game.png`,
`phase-9-wpm-test.png`, `phase-9-auto-clicker.png`, `phase-9-memory-hub.png`,
`phase-9-chimp-iphone.png`.

Not testable here: a real auto clicker program, real phone keyboards
(autocorrect behaviour), emoji rendering on old systems. Ali should try
`/auto-clicker-test/` with an auto clicker at 10 ms and 100 ms, and
`/typing-speed-test/` on a phone.

## Decisions

- Hub slugs are the search terms: `/memory-test/` and `/typing-test/` are
  hubs, not tools; the main typing tool is `/typing-speed-test/`.
- All memory and typing pages are `ads => content` (click/typing areas).
- Scores are kept in localStorage only; leaderboards wait for the moat phase.
- Chimp and visual memory report and save the level at which the game ended
  (humanbenchmark convention), not the last completed level.
- Typing best is saved only at >= 90% accuracy so an error-filled sprint
  does not become the benchmark.
- Urdu / Hindi typing tests are mentioned in copy as "planned" (phase 10 or
  11 candidates: need RTL input handling and word lists).

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/memory-test/` (6
   cards) and `https://testnook.com/typing-test/` (5 cards); check the
   header on a laptop around 1000 px wide.
2. Try `/auto-clicker-test/` with a real auto clicker and
   `/typing-speed-test/` on a phone.
3. Search Console: resubmit `https://testnook.com/wp-sitemap.xml`. IndexNow
   pings the 14 new URLs on the first production request.

## Remaining roadmap (carry this forward in every handoff)

Ali approved on 28 Oct 2026 a dedicated "moat" phase after Tier 2 and
before Tier 3. Suggested order:

1. **Phase 10: Tier 2 batch 4**: `vibration-test`, `torch-test`,
   `device-info`, `what-is-my-user-agent`, `what-phone-do-i-have`,
   `voice-recorder`, `stereo-test`, `mono-test`, `bass-test`, the 1/5/10/30/
   60/100 second click pages (reuse `cps-test.js`, fixed `dur` per page via
   a single `aria-pressed` length button or no buttons). Consider
   `typing-test-urdu` / `typing-test-hindi` here if word lists are ready.
2. **Phase 11: Tier 2 batch 5**: eye tests (`red-green-color-blind-test`,
   `color-vision-test`, `eye-test`, `astigmatism-test`, `blind-spot-test`,
   all with `disclaimer`), screen info pages (`screen-resolution`,
   `screen-size`, `screen-ratio`, `aspect-ratio-calculator`,
   `ppi-calculator`), monitor pages (`monitor-test`, `lcd-test`,
   `display-test`, `oled-test`, `monitor-color-test`, `monitor-calibration`),
   `zoom-test`, `battery-health-test`, `dog-whistle`,
   `white-noise-generator`, `keyboard-ghosting-test`, `mouse-accuracy-test`,
   `mouse-latency-test`, `controller-vibration-test`, `joy-con-drift-test`.
   Split into two phases if it is more than 10 pages.
3. **Phase 12: Moat phase** (approved by Ali, do not build before Tier 2 is
   done): (a) anonymous aggregate data: average reaction time, average CPS,
   average WPM, dead pixel location stats, collected with consent and shown
   on the tool pages; (b) leaderboards for CPS, typing (the five typing
   pages already compute net WPM and accuracy) and reaction time; (c) an
   embed widget: iframe code for every tool (embed mode `?embed=1` already
   exists; add a copy-the-code box and a per-tool embed page or section).
   Needs a small server side (REST endpoint + table) and an abuse/rate-limit
   plan; design it in its own thread first.
4. **Phase 13+: Tier 3**: 3-5 troubleshooting guides per tool (stick drift
   fixes, keyboard key not working, webcam/mic not working, average reaction
   time by age, what is a good CPS, average typing speed by age, is 144hz
   worth it, etc.), phone sensor pages, internet tools, browser info tools.

Recipe unchanged: catalog entry, `content/tools/<slug>.php`, script, CSS,
`python3 bin/make-og-images.py`, commit the JPEGs, Playwright pass at
1280 px and iPhone 13, merge to `main`, write `docs/handoff/phase-N.md`.

Local test setup: as in `docs/handoff/phase-3.md`, with
`define( 'WP_ENVIRONMENT_TYPE', 'local' );` in `wp-config.php`.
