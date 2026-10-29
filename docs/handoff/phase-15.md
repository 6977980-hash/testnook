# Phase 15 handoff: Tier 3, part 2 (12 more guides)

Date: 29 Oct 2026. Branch `claude/project-thread-7fpp1c`, merged to `main`.
Follows `docs/handoff/phase-14.md`. Content only: 12 new files in
`content/guides/` and their 12 OG JPEGs in `assets/img/og/`. No theme code,
CSS or JS changed. Still 101 tools and 11 hubs; 24 guides in total, so 12 new
URLs. `TN_VERSION` unchanged (0.5.0, no asset changes).

## The 12 guides

| Slug | Hub | Main tool | Live data | Sources |
|---|---|---|---|---|
| `how-to-fix-keyboard-ghosting` | keyboard | keyboard-ghosting-test | | |
| `mouse-polling-rate-explained` | mouse | mouse-polling-rate-test | | |
| `what-dpi-should-i-use` | mouse | dpi-analyzer | aim-static-28 | |
| `average-wpm-for-programmers` | typing-test | 1-minute-typing-test | typing-60 | |
| `how-to-clean-phone-speaker` | phone | speaker-cleaner | | |
| `backlight-bleed-fix` | screen | lcd-test | | |
| `what-is-20-20-vision` | vision-test | eye-test | | AAO, GOV.UK driving eyesight rules |
| `astigmatism-explained` | vision-test | astigmatism-test | | NEI |
| `how-to-test-a-used-phone` | phone | touch-screen-test | | |
| `battery-health-explained` | phone | battery-health-test | | Apple, Battery University |
| `headphones-left-right-fix` | audio | headphone-test | | |
| `what-is-a-good-chimp-test-score` | memory-test | chimp-test | | Inoue & Matsuzawa 2007 |

Each: 5-6 sections, 1,000-1,280 words, a 4-point short answer, 6 FAQs, 2-9
linked tools, SEO title 53-59 chars, description 154-160 chars. The two
vision guides carry the eye-test disclaimer. Every source URL was opened and
checked (the NEI link uses its new `/eye-health-information/` path).

Guides cross-link where it helps: used phone -> battery health; 20/20 ->
astigmatism; backlight bleed -> OLED burn-in and dead vs stuck pixel; WPM for
programmers -> average typing speed; keyboard ghosting -> keyboard key not
working.

The `phone` and `memory-test` hubs now have a "Guides" section on their hub
pages for the first time.

The chimp test has no results board, so its guide has no live data. The aim
board is used on the DPI guide (no separate mouse accuracy guide this phase).

## Tested

Local WordPress 6.9 on SQLite (Phase 3 recipe, `WP_ENVIRONMENT_TYPE` local).

- PHP lint on all 24 guide files. A checker script confirmed for every guide:
  `tool` / `tools` slugs exist, every internal `href="/slug/"` resolves to a
  tool, guide, page or hub, section ids unique, `data.after` names a real
  section, SEO title and description lengths.
- curl: all 24 guides 200 with `<title>`, Article JSON-LD and `og:type`
  article; `/guides/` lists 24 cards. Data blocks are absent before seeding
  and appear after seeding 120 results each on `typing-60` and
  `aim-static-28` (`tn_stats_refresh_all()`), with every token filled.
- Playwright, 32 pages (home, `/guides/`, 4 tool pages, 3 hubs, 24 guides)
  at 1280 px and iPhone 13: all 200, no console errors or warnings, no page
  errors, no horizontal scroll, valid JSON-LD, every "On this page" anchor
  resolves. "Guides for this test" shows on the tool pages the new guides name.
  `debug.log` not created (no PHP notices).
- OG images: 12 written, checked two visually (longest titles wrap fine).

Screenshots in project files: `phase-15-guide-dpi.png`,
`phase-15-guide-chimp-iphone.png`, `phase-15-guide-wpm-iphone.png`,
`phase-15-guide-used-phone.png`, `phase-15-guides-index.png`.

## Decisions

- Claims kept conservative: where there is no study (programmer WPM, DPI and
  cm/360 ranges, polling rate feel), the text gives typical ranges and says so,
  and lists no sources rather than vague ones.
- "Colour" spelling in prose as before; tool slugs untouched.
- All dated `published` / `updated` 2026-10-29, same as phase 14, so lists
  sort by file order within the day. When revising a guide, change `updated`.

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/guides/` (24 guides)
   and `https://testnook.com/how-to-test-a-used-phone/`.
2. Search Console: resubmit `https://testnook.com/wp-sitemap.xml` (12 new
   URLs) and request indexing for two or three of the new guides.

## Remaining roadmap (carry this forward in every handoff)

1. **Phase 16: phone sensors** (gyroscope, accelerometer, compass,
   proximity, light sensor, GPS) as tools in the phone hub, each with a
   guide; `DeviceOrientation` / `DeviceMotion` need the iOS permission
   prompt (`requestPermission`) and HTTPS. The phone hub now has three guides
   to link from.
2. **Phase 17: system hub** (`system`): internet speed and ping, browser
   info, IP and DNS, WebGL/GPU info, then move device-info, user agent,
   what-phone and the screen info pages there by changing their `hub` key.
   A 12th hub needs the nav breakpoint raised or the hub names shortened
   (see phase-12).
3. **More guides later** (same one-file recipe), ideas not yet written:
   mouse accuracy / aim training (aim boards), average number memory and
   sequence memory, hearing frequency by age, what is a good refresh rate
   for phones, how to calibrate a monitor, controller deadzone settings,
   how to test a used monitor, average 10 second CPS.
4. Optional `typing-test-urdu` / `typing-test-hindi`; the SEO tidy-up of the
   older titles/descriptions listed in phase-12; later leaderboard ideas
   from phase-13b only if Ali asks.

Recipe for a guide: copy any file in `content/guides/`, change every field,
keep section ids unique, run `python3 bin/make-og-images.py` and commit the
JPEG, then the Playwright pass (desktop + iPhone 13: console, scroll,
JSON-LD, TOC anchors), merge to `main`, write `docs/handoff/phase-N.md`.
Recipe for tool pages unchanged (see phase-12 and phase-13b).
