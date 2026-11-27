# Phase 31 handoff: audit 3, fix phase 3 (new tools and guide)

Date: 27 Nov 2026. From the 27 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-27/`, handoff
`phase-3-new-tools.md`), approved by Ali. New JS and CSS, so `TN_VERSION` is
now **0.8.0**. Totals: **120 tools, 44 guides, 185 URLs** (was 118 / 43 / 182).

## What changed

| ID | Files | Change |
|---|---|---|
| S-24 | `assets/js/tools/keyboard-tester.js`, `assets/css/tools/keyboard-tester.css`, `content/tools/keyboard-tester.php` | Chatter detector: a keydown (not auto-repeat) that comes within the chatter window after the same key's last keyup is flagged. The key turns red (`.is-chatter`, same size, so the reserved board height from F-55 is unchanged), a new **Chatter** stat counts them, the key log has a `note` column ("Chatter: E twice in 12 ms", also in Copy log) and the status line explains it. Window select under the stats: 10/20/**30**/50/80 ms. New how-to step, result bullets and FAQ link. |
| S-24 | `content/guides/how-to-fix-keyboard-chatter.php` (new, keyboard hub) | What chatter is (contact bounce vs debounce), how to tell it from key repeat / stuck keys / ghosting, how to confirm with the tester, fixes in order (compressed air, contact cleaner or IPA, debounce setting, firmware, hot-swap or desoldered switch, warranty). Sources: Wikipedia Switch (contact bounce, "also called chatter"), Wikipedia Keyboard technology (debouncing), QMK debounce docs (default 5 ms). Linked from `keyboard-tester` (results + FAQ), `keyboard-key-not-working` (chatter step), `double-click-test` ("why" section) and the keyboard hub. |
| S-29 | `content/tools/frame-skipping-test.php`, `assets/js/tools/frame-skipping-test.js`, `.css` (new, screen hub) | `/frame-skipping-test/`: 12 cells on an always-dark box (6x2 under 560 px), one lit per `requestAnimationFrame`. The index advances by elapsed frames, so frames the browser misses also show as gaps; those are counted as **Browser missed** so a user can tell browser stutter from monitor skipping. Refresh rate from the median rAF interval, Pause, Full screen. Pass/fail example "photos" are inline SVG. Safari 60 fps note (N-01) in a section and a fix. Root carries `data-fs-cell`, `data-fs-frame`, `data-fs-hz` for tests. Linked from `ufo-test`, `refresh-rate-test` (fix), `is-144hz-worth-it` and the screen hub. |
| S-30 | `content/tools/audio-latency-test.php`, `assets/js/tools/audio-latency-test.js`, `.css` (new, audio hub) | `/audio-latency-test/`: tap-sync. Clicks every 800 ms scheduled on the Web Audio clock; 4 count-in clicks with a visual flash, then 12/16/20 clicks with no visual cue. Each tap (pointer, Space or any key) is matched to a beat in a -250..+550 ms window, offset = tap time - time the click left the browser; outliers beyond 3 MAD (min 40 ms) dropped; shows average offset, spread (SD), taps counted and the browser's own `outputLatency + baseLatency`. Runs are labeled Wired / Bluetooth / Speakers and listed; with both a wired and a Bluetooth run the status gives the difference. Copy says the result includes the user's timing. Source for "classic Bluetooth 100-200 ms, LE Audio 20-30 ms": Wikipedia Bluetooth (we did not find an openable source for 300 ms, so the page says 100-200). Root carries `data-al-state`, `data-al-beat0`, `data-al-interval`, `data-al-countin`, `data-al-count`, `data-al-result`. Linked from `headphone-test`, `sound-test`, `headphones-left-right-fix` and the audio hub. |
| - | `content/catalog.php` | Entries with keywords: frame-skipping-test (`frameskip`, `testufo`, `overclock`, `dropped frames`...), audio-latency-test (`bluetooth delay`, `lag`, `airpods`, `lip sync`...). The chatter guide is found through the keyboard tester's existing "chatter" keywords. |
| - | `assets/img/og/` | 3 new OG images (`python3 bin/make-og-images.py`). |

Not built: the optional mic loopback method for audio latency. The browser
gives no reliable way to line up the microphone input clock with the output
clock without an AudioWorklet and a calibration step, and the number would
include input delay too. The wired vs Bluetooth tap comparison plus the
browser-reported value cover the use case.

## Tested (local WordPress 7.1, SQLite, phase-3 recipe; serve with `php -S ... -t <wordpress dir> router.php`)

- `bin/check.sh`: lint OK. `bin/check.sh http://127.0.0.1:8080 --wide`: **370/370** page loads pass, no warnings. Sitemap and `/llms.txt` list the 3 new URLs.
- Chatter (Playwright, synthetic keydown/keyup): KeyE released and pressed again 12 ms later -> red, Chatter 1, log "Chatter: E twice in 12 ms"; KeyR 120 ms later -> not flagged. Board height (266 px) and the stats position identical before and after.
- Frame skipping (headless, 60 Hz): reads 60 Hz / 16.67 ms; over 120 consecutive frames every frame lit the next cell (0 non-consecutive steps, 0 browser missed).
- Audio latency (scripted taps): on the beat -> 0 ms (0.2), 150 ms late -> +150 ms (150.2), 16 taps counted, spread 0. Browser-reported delay showed 42 ms in headless Chromium.
- Home search at 1366 px: "frameskip test" -> Frame Skipping Test; "test ufo" -> UFO Test; "bluetooth delay" and "headphone latency" -> Audio Latency Test; "keyboard chatter" -> Keyboard Tester, then the chatter guide.
- 390 px dark screenshots of the three tools: no overflow, cells 6x2.

Not testable headless: a real photo of a skipping monitor, real Bluetooth delay.

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so 0.8.0 loads.
2. In Search Console, URL Inspection -> Request indexing for `/frame-skipping-test/`, `/audio-latency-test/` and `/how-to-fix-keyboard-chatter/`.
3. Optional: try `/audio-latency-test/` once with wired and once with Bluetooth earbuds, and `/frame-skipping-test/` with a phone photo.

## Notes for later

- This was the last of the four 27 Nov 2026 audit phases (29, 30, 31, 32).
- The audio latency test has no stats board on purpose: the number mixes device delay and human timing, so a public average would mean little.
