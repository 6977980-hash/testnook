# Phase 25 handoff: audit 2, fix phase 1 (content accuracy and trust)

Date: 1 Nov 2026. From the 1 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-01/`), approved by Ali.
Text and template changes only: no CSS or JS changed, so `TN_VERSION` stays **0.7.4**.

## What changed

| ID | File(s) | Change |
|---|---|---|
| F-41 | `content/pages/about.php`, `inc/config.php` | About now says the site *will be* supported by ads on content pages, never inside a test, and that ads are not switched on yet (matches the privacy policy). `TN_FOUNDER_BIO` no longer starts with "Ali Ahmad founded Testnook and runs it", so "founded" appears once on /about/. The guide author box reads "Written by Ali Ahmad" then "He has worked in IT...". |
| F-38 | `content/guides/average-typing-speed.php` | "How WPM is calculated" describes Testnook's method first (correct characters incl. the space after each correct word, / 5 / minutes; raw WPM; a wrong word also costs its space), then gross/net as what other tests and employers use (300 chars, 4 errors example kept). Job section: our 1 and 5 minute tests are "close to how employers test". Summary bullet no longer says "most tests subtract errors". Tool untouched. |
| F-39 | `content/guides/what-is-a-good-cps.php`, `content/pages/how-we-test.php` | Short answer and FAQ: "most people land between 4 and 7 on a 5 second test; 6 to 7 is a good one-finger score", matching `_bands.php` (still the single source). No CPS sources added (none we could verify), so how-we-test now says CPS bands are our reading of public click-test results and will be replaced by Testnook's own distribution once the leaderboards have enough results. |
| F-40 | `content/guides/average-reaction-time.php` | Sprinter line: the ear turns sound into a nerve signal faster than the eye turns light into one (no uncited number). Age table is one column, "Published average (PC test, gaming mouse)"; the "+20-50 ms computer" column is gone and replaced by a sentence that an everyday screen and mouse often read 20-50 ms higher. Short answer and FAQ: 215 to 255 ms (agrees with the table). |
| F-51 + S-13 | `inc/registry.php`, `templates/tool.php`, `docs/content-format.md`, `content/tools/hearing-frequency-test.php` | New optional tool key `sources` (default `array()`), printed after the FAQ with the guide's Sources markup (`#sources`, `.sources` CSS already in `main.css`). Hearing test: table header "Typical for (approximate, varies widely)", a sentence that the bands are approximate, and two sources: ISO 7029:2017 and Rodriguez Valiente et al. 2014 (Int J Audiol, extended high-frequency thresholds, 645 subjects). `AGES` in the JS is unchanged (phase 2 owns scripts). |
| F-52 | `content/pages/how-we-test.php` | 390 pixels (iPhone 13). |
| F-61 | `content/pages/terms.php` | New section "Who runs Testnook and governing law": run by Ali Ahmad in Pakistan; laws and courts of Pakistan, unless the visitor's own country gives them a right to sue there. Ali gave the country (Pakistan) in the thread on 1 Nov 2026. |
| F-48 | `content/guides/what-is-a-good-internet-speed.php` | 50 GB at 100 Mbps: "a little over an hour". |
| S-22 | `content/guides/does-my-phone-have-a-gyroscope.php` | New section "Built-in checks from the phone maker": Samsung Members > Diagnostics (or Settings > Device care > Diagnostics) and `*#0*#`; Xiaomi/Redmi/POCO `*#*#6484#*#*` or tap Kernel version five times; iPhone has no public sensor menu. Three maker pages added to `sources`. The handoff's Xiaomi code `*#*#64663#*#*` was **dropped**: Xiaomi's own FAQ documents `*#*#6484#*#*` only. Samsung's pages document `*#0*#` as a hardware test menu but do not name a sensor screen, so the text does not promise one. |

`updated` dates set to 2026-11-01 on every changed page and guide.

## Tested

Local WordPress (SQLite, phase-3 recipe, `WP_ENVIRONMENT_TYPE=local`):

- `bin/check.sh`: lint OK.
- `bin/check.sh http://127.0.0.1:8080 --wide`: 358/358 page loads pass (179 URLs at 390 and 1366 px).
- Text checks on the rendered pages: /about/ has "founded" once and no "is supported by advertising"; typing guide describes the same method as the /typing-test/ hub; CPS short answer and FAQ say 4 to 7; /how-we-test/ has 390 and the CPS-bands sentence; reaction guide has no "more quickly than light"; /hearing-frequency-test/ shows a Sources block with 2 links; speed guide says "a little over an hour"; /terms/ names Ali Ahmad and Pakistan; gyroscope guide has the built-in checks section.

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache).
2. Nothing else. (Still open from before: switch the WP Administration Email and make the new Gmail owner in Hostinger/GSC/AdSense/GA4.)

## Notes for later phases

- Phase 2 (repo phase 26) also edits `templates/tool.php` (F-60): the new Sources block sits between `tn_faq()` and the disclaimer.
- Any tool page can now cite sources with `'sources' => array( array( 'Label', 'https://...' ) )`.
- When the CPS boards have enough results, replace the CPS bands with Testnook's own distribution and update the how-we-test sentence.
