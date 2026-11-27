# Phase 30 handoff: audit 3, fix phase 2 (SEO, search, hearing test, GSC snippets)

Date: 27 Nov 2026. From the 27 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-27/`, handoff
`phase-2-seo-content.md`), approved by Ali. JS and CSS changed, so
`TN_VERSION` is now **0.7.9**. No new tools or guides (still 118 tools, 43
guides, 182 URLs).

## What changed

| ID | Files | Change |
|---|---|---|
| F-64 | `content/hubs/screen.php`, `content/tools/monitor-test.php`, `content/guides/backlight-bleed-fix.php` | Hub title "Screen & Monitor Tests: Refresh Rate, Burn-in, Colors & Pixels", description no longer leads with dead pixels. First line of the hub body: "Looking for dead pixels? Open the dead pixel test". Monitor test gets a new sentence linking "dead pixel test"; the backlight bleed guide's anchor changed from "dead pixels" to "dead pixel test". `dead-pixel-vs-stuck-pixel` and `how-to-test-a-used-monitor` already linked with that exact anchor, so they were left alone. The optional "pixel policy" section was not added: no source we could open gives the ISO 9241-307 class numbers (Wikipedia's "Defective pixel" page names ISO 13406-2 but has no table). |
| S-28 | `content/tools/hearing-frequency-test.php` | Title "Frequency Test: Highest Pitch You Can Hear (8-20 kHz)", description starts "Free online frequency hearing test: tones from 8 to 20 kHz...". |
| F-76, S-26 | `assets/js/tools/hearing-frequency-test.js`, `.css`, content file | About 1 in 5 sweep trials (never the first, never two in a row) is a silent catch trial with the same display and timing. A press during it shows "No tone was playing; press only when you are sure." and the run goes on to the real tone. After the sweep, a confirm pass plays the top tone, the step below and one silent trial in random order (no repeats): top heard again = confirmed; only the lower one heard = result lowered one step; neither = "Not confirmed... Re-run". Ear choice gained **Each ear** (left sweep + confirm, then right), routed through the existing channel gains; the result shows both ears and flags a gap of 3 kHz or more. Result box always shows "Press only when you are sure; re-run once to confirm." False presses are counted in the result note. The root element carries `data-hf-route` (L/R/LR) and `data-hf-tone` (Hz or `silent`) while a trial runs, for tests. Disclaimer and sources unchanged. |
| S-23 | `content/catalog.php`, `assets/js/site.js` | Problem-phrase keywords on ~30 tools (chatter, not working, not detected, no sound, drift, hdr, vrr, gsync/freesync, one side, ghost touch, auto brightness, what phone is this, webgl renderer, gps signal...). Search: filler words (my, is, not, no, working, broken, fix, test, how...) add score when they match but never rule a card out. With no match, the empty message lists up to 3 hubs whose heading, blurb or cards share words with the query; if none, the old message stays. |
| S-27 | `content/hubs/benchmark.php`, `typing-test.php`, `mouse.php` | A first line on each hub linking the leaderboards (`#lb-cps`, `#lb-reaction`, `#lb-typing`, `#lb-aim`). Not added to the desktop nav: the header is capped at 1280 px and the 13 nav items already take 1016 of the 1089 px free, so a 14th item would wrap or force a smaller font. The memory hub has no leaderboard board, so it got no link. |
| S-33 | `content/hubs/phone.php`, `content/guides/auto-brightness-not-working.php`, `proximity-sensor-not-working.php`, `how-to-improve-gps-accuracy.php`, `content/tools/gps-test.php` | Phone hub opens with "Most used: light sensor test, proximity sensor test, GPS test". Each sensor guide's intro now links the other sensor's test with the exact anchor. GPS guide intro links "GPS test". GPS title "GPS Test & GPS Tester: Check Accuracy and Signal Online". |
| S-34 | `content/tools/what-phone-do-i-have.php` | Title "What Phone Do I Have? Instant Phone Model Checker", description leads with the instant answer, new first FAQ "What phone is this?" (Android model code -> name, iPhone narrowed by screen size). Not called a quiz. |
| S-35 | `content/tools/webgl-test.php`, `webgl-test.js`, `system.css` | Title "WebGL Test: Your WebGL Renderer, GPU & WebGPU Support", first H2 "How to check your WebGL renderer and GPU". New box "Your WebGL renderer (UNMASKED_RENDERER_WEBGL)" shows the raw string verbatim with a Copy button (clipboard API, falls back to selecting the text). |

## Tested (local WordPress, SQLite, phase-3 recipe)

- `bin/check.sh`: lint OK. `bin/check.sh http://127.0.0.1:8080 --wide`: **364/364** page loads pass (titles <= 65, descriptions <= 160).
- Home search at 1366 px, first results: "keyboard chatter" / "chatter" -> Keyboard Tester; "mic not working" -> Mic Test; "webcam not working" -> Webcam Test; "controller not detected" -> PS5/Xbox/PS4 controller tests; "no sound" -> Sound Test; "stick drift" / "drift" -> Stick Drift Test; "hdr" -> Monitor Test; "vrr", "gsync", "freesync" -> Refresh Rate Test; "headphones one side not working" -> Headphone Test; "my keyboard is broken" -> Keyboard Tester; "auto brightness not working" -> Light Sensor Test; "what phone is this" -> What Phone Do I Have; "frequency test" -> Hearing Frequency Test; "webgl renderer" -> WebGL Test; "gps signal" -> GPS Test. "xyzzy" -> old message; a no-match query with hub words lists hubs. No page errors.
- Hearing test (Playwright, `Math.random` pinned): run A with catch trials every other step: a press on the first silent trial showed the message, run continued; confirm pass with 14 kHz not heard and 13 kHz heard -> "13 kHz", note "did not hear 14 kHz but did hear 13 kHz... You pressed during 1 of 8 silent checks". Run B "Each ear": every left trial routed L only, every right trial R only; result "Left 12 kHz · Right 16 kHz", both confirmed, 4 kHz gap flagged. Result tip present.
- WebGL at 390 px: raw string shown, Copy puts the identical string on the clipboard.

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so 0.7.9 loads.
2. In Search Console, URL Inspection -> Request indexing for: `/screen/`, `/dead-pixel-test/`, `/hearing-frequency-test/`, `/gps-test/`, `/what-phone-do-i-have/`, `/webgl-test/`.
3. Recheck in GSC in 3-4 weeks (around 20 Dec 2026): "dead pixel test" should land on `/dead-pixel-test/`, not `/screen/`; "frequency test" CTR above 0.

## Notes for the next phase

- Phase 3 (repo phase 31, new tools) edits `content/catalog.php` and hubs: keep the new problem-phrase keywords, and give the chatter detector "chatter" keywords too (the keyboard tester has them now).
- Search fallback reads hub sections from the home page markup (`.hub-section` with an id, `h2`, `.hub-blurb`), so keep that structure.
