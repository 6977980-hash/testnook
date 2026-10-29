# Phase 21 handoff: audit fix phase 4 (UX, mobile, accessibility)

Date: 29 Oct 2026. Source: site audit of 29 Oct 2026, fix phase 4
(`phase-4-ux-mobile-a11y.md` in the project files). `TN_VERSION` 0.7.1 ->
**0.7.2** (CSS and JS changed).

## What changed

| ID | File(s) | Fix |
|---|---|---|
| F-17 | `content/guides/{how-to-change-dns-server,what-is-a-good-ping}.php` | Tables wrapped in `.table-scroll`. |
| F-19 | `assets/css/main.css` | `.logo` and `.logo-mark` get `flex-shrink: 0`. |
| F-34 / S-02 | `header.php`, `assets/css/main.css`, `templates/hub.php`, 3 hubs, `docs/content-format.md` | "Guides" after the 12 hubs (with a divider, `aria-current` on `/guides/` and every guide). "Leaderboards" is in the mobile menu only (`.nav-mobile`). Collapse breakpoint 1240 -> **1320 px**; the header wrap is 160 px wider than the content wrap (`calc(var(--wrap) + 160px)`) so 13 items fit from 1321 px. Open mobile menu scrolls (`max-height: calc(100vh - 60px)`). New optional hub key `pick`: bold line under the lede, set on `typing-test`, `memory-test`, `vision-test` ("Pick a test below: ..."). |
| F-15 | `content/tools/online-ruler.php`, `online-ruler.css` | Visible `<label for="rl-diag">Screen diagonal (inches)</label>`. |
| F-16 | 15 listed tool boxes + `zoom-test`, `battery-health-test`, `aspect-ratio-calculator`, `joy-con-drift-test`, `_screen-cal.php`, `device-info.js`, 4 memory scripts | Tool-box headings are `<h2>` (tool CSS selectors now match `h2, h3`; memory scripts query `h2`). Gate: 0 heading skips on all URLs. |
| F-36 | `cps-test.php`, `_click-test.php`, and the same pattern on `reaction-time-test`, `f1-reaction-test`, `jitter-click-test`, `right-click-cps-test`, `auto-clicker-test`, `spacebar-clicker`, `tap-bpm` | The `role="button"` stages no longer carry an `aria-label` that hid their visible text; the accessible name is now the visible text ("Click here to start ..."). Lighthouse `label-content-name-mismatch` passes. Reaction idle blue darkened (#1d4ed8) for 4.5:1 contrast. |
| F-35 | `templates/tool.php`, `assets/css/main.css`, `assets/js/site.js` | Cause was the device note ("needs a mouse/keyboard" on phones, "needs touch" on desktops) being un-hidden by deferred JS above the tool. `desktop`/`touch` notes are now shown by CSS media queries (`(pointer: coarse) and (hover: none)` / `not all and (any-pointer: coarse)`) so they are there on first paint; JS still handles `gamepad` and `media`. Lighthouse mobile `/cps-test/` CLS 0.09 -> **0**. |
| F-18 / S-04 | `content/tools/keyboard-tester.php`, `assets/js/tools/keyboard-tester.js`, `keyboard-tester.css`, `assets/js/site.js` | Sizes Full / TKL / **75%** / 60%; shape **ANSI (US)** / **ISO (UK/EU)** (tall Enter, `#` key, `IntlBackslash` beside left Shift); labels **Windows / Mac** (Control, Option, Cmd in Mac order, Delete, Return, F13-F15, Help, Clear; defaults to Mac on Apple platforms). The script measures the board and sets the key unit to fit the stage (22-46 px); below 22 px the stage scrolls with a fade and a "Scroll sideways ..." hint, and key labels shorten under 32 px. Key log: last 10 presses (key, code, keyCode, "(held)" for repeats) and **Copy log** (tab-separated). New `TNUtil.copyText(text, button)` helper. |
| S-03 | new `content/tools/_stick-drift.php`, `stick-drift-test.php`, `joy-con-drift-test.php`, `stick-drift-test.js/.css` | Shared stick markup + a drift tiers table (<=1% excellent, 1-5% normal, 5-10% noticeable, >10% needs attention); the check marks the row of the worse stick, shows a per-stick **Dead zone** (rest + 2%, max 30) and moves the slider to it. **Circularity error** = mean gap between the traced edge and the full-tilt circle, shown after 90% of a rotation ("Rotate n%" before). Result texts and FAQs updated to the new tiers. |
| S-06 | `templates/tool.php`, `assets/js/stats.js`, `main.css` | "Copy result" box under CPS (all click lengths), reaction (5-try average) and typing results, e.g. "I got 9.4 CPS on the 5 second click test at testnook.com/cps-test/". Shown even with sharing off, never in embeds. **Dynamic OG image not built**: it would need a score URL parameter, a GD endpoint and an `og:image` filter; left as a later idea. |
| S-09 | new `content/tools/monitor-check.php`, `assets/js/tools/monitor-check.js`, `assets/css/tools/monitor-check.css`, `content/catalog.php`, `assets/img/og/monitor-check.jpg` | New tool `/monitor-check/` (Guided Monitor Check, screen hub): 5 steps (dead pixels, uniformity, gradients, text sharpness, refresh rate). Steps 1-4 open the shared `monitor-test.js` full-screen viewer at the right pattern; step 5 measures the rAF median over 2 s and snaps to a common rate. Looks fine / Problem + note per step, a live summary with Copy. Tools: 116 -> **117**. |

## Tested

Local WordPress (SQLite, recipe in phase-3.md), `WP_ENVIRONMENT_TYPE=local`:

- `php -l` clean on every PHP file, `node --check` on every JS file, no PHP notices.
- Gate on **all 179 URLs** (home + `/llms.txt`) at 375 px (iPhone 13) and 1366 px, sharing off and stats endpoints blocked: 0 page errors, 0 horizontal overflow, 0 inputs without a label, 0 heading-level skips, one `h1` per page, JSON-LD parses, 179 internal link targets all 200.
- Lighthouse mobile: `/cps-test/` perf 100, a11y 100, CLS 0 (was 0.09); home, keyboard tester, monitor check, stick drift, typing hub, reaction, F1, tap BPM all a11y 100.
- Header: 13 items fit at 1321-1920 px; menu button at <= 1320 px; mobile menu lists Guides and Leaderboards; logo intact at 1240-1300 px.
- Keyboard tester: unit 41-46 px at 1366, 26-41 px at 768, 22 px + hint at 375; ISO + Mac + key log verified with key presses.
- Stick drift and Joy-Con pages with a fake gamepad (6% resting offset, then a full rotation at 104%): "Noticeable", dead zone 8%, circularity 4.0%, outer range 104%, tier row marked.
- CPS 1 s run with sharing off: copy line "I got 8.0 CPS on the 1 second click test at ...".
- Monitor check: steps mark, note, 60 Hz measured, viewer opens at the right pattern, summary text correct; no overflow at 375.

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache).
2. Try `/keyboard-tester/` on your keyboard (pick ISO if your Enter is tall) and `/stick-drift-test/` with a controller; rotate each stick fully to see the circularity error.
3. Open `/monitor-check/` once. Pending from earlier phases: replace the `admin` user, turn off the Hostinger llms.txt.

## Next

Audit fix phase 5 (`phase-5-speed-security.md`, repo `docs/handoff/phase-22.md`),
running in parallel. Ideas left over: dynamic OG image with the score (S-06),
a "Popular" nav item (skipped to keep the header short).
