# Phase 20 handoff: audit fix phase 3 (content and trust)

Date: 29 Oct 2026. Source: site audit of 29 Oct 2026, fix phase 3
(`phase-3-content-trust.md` in the project files). `TN_VERSION` stays **0.7.1**
(no CSS or JS changed; the guide author box reuses `.section-box`).

## What changed

| ID | File(s) | Fix |
|---|---|---|
| F-02 | `content/home.php`, `footer.php`, 10 stats tools (`cps-test`, the 7 click-length pages, `reaction-time-test`, `mouse-accuracy-test`), 5 typing tools, `content/hubs/benchmark.php`, `content/pages/{about,privacy-policy}.php`, `bin/make-og-images.py` | Homepage intro, meta description (also the llms.txt summary) and footer: "Your camera, microphone and keystrokes never leave your device; a few tests share only your final score, anonymously, and you can turn that off." Every FAQ on a tool with `stats` now says the clicks/keystrokes stay in the browser and only the final score is shared unless sharing is turned off. Benchmark hub FAQ no longer says "no leaderboard". OG images said "Nothing uploaded" in the footer line; now "Runs in your browser" (all 169 regenerated). The remaining "nothing is sent" lines are on tools without `stats`, where they are true. |
| F-08 | `content/pages/privacy-policy.php` | Rate-limit hash kept "up to 24 hours". Analytics and ads are described as **not switched on**, with "when enabled ..." wording. Consent: "When ads or analytics are switched on, visitors in the EEA, UK and Switzerland are shown a consent message first". |
| F-10 | `inc/config.php` (`TN_FOUNDER_BIO`), `content/pages/about.php`, new `content/pages/how-we-test.php`, `footer.php`, `templates/guide.php`, 3 vision guides | Bio from Ali's own words (IT and hardware work, repairs hardware, gamer; no years or credentials, he gave none). About: why the site exists (AI/search cannot run a test), no medical reviewer stated plainly, the unsupported "tested on Windows, macOS, Android and iPhone" claim replaced by the real method and a link. New page `/how-we-test/` (release checks, per-family method and limits, browsers, corrections), linked from About, the footer and the author box. Author box at the end of every guide. `what-is-20-20-vision`, `types-of-colour-blindness`, `astigmatism-explained`: "screening, not a diagnosis; see an optometrist/ophthalmologist" now in the intro too. |
| F-11 | `content/guides/average-reaction-time.php`, new `content/tools/_bands.php`, CPS/typing tools, `content/hubs/{benchmark,typing-test}.php`, `content/guides/{what-is-a-good-cps,average-typing-speed}.php`, `content/pages/contact.php` | Reaction: Woods 2015 is "a widely cited study of about 1,400 people" (231 ms mean, 213 ms corrected, 0.55 ms/year); the age table now covers 18-82 only, the 66-82 row is labelled "estimate, small group", no child rows; "10 to 30 ms gains" replaced by Dye, Green & Bavelier 2009 (cited, no invented number). One CPS scale and one WPM scale in `_bands.php`, printed on `cps-test`, `5-second-cps-test`, `what-is-a-good-cps`, the 5 typing tools, `average-typing-speed` and the typing hub; the benchmark hub uses the one-line versions. "Forearm fills with lactate" and "9 or 10 CPS normal clicking in 1 s" removed. CHI 2018 52 WPM is a **mean**; guide says average about 40, good 50-70. Contact: "iOS 26". Typing FAQs and hub state both thresholds: best saved at 90%, site averages and leaderboard accept 85%. |
| F-32 | `content/tools/{refresh-rate-test,fps-test,ufo-test}.php`, `content/guides/is-144hz-worth-it.php` | Fix entry + FAQ: iPhone/iPad Safari draws near 60 fps unless "Prefer Page Rendering Updates near 60fps" is off (Settings > Apps > Safari > Advanced > Feature Flags); Low Power Mode caps at 60 too. Paragraph in the 144Hz guide. |
| F-12 | 7 click-length pages, 10 colour screens | Each length page has a new first section no sibling has: 1 s = first click and gap maths, 5 s = reading the five bars, 10 s = rhythm (metronome, CV-based consistency), 15 s = how consistency is computed, 30 s = comparing halves, 60 s = fatigue curve, 100 s = second wind; each points to its own `#leaderboard`. Colour screens: dropped the duplicated "Is this screen free?" and "How do I make my screen X?" FAQs; no pages merged or redirected (owner decision 8). |
| F-33 | 131 files under `content/` | en-US sweep (~950 words: color, gray, center, meter, fiber, practice, aging, neighbor, -ize ...). Kept: slugs, CSS classes, `data-*` values, pattern ids (`grey50`), the `$tool('...')` identifiers. "Grey Screen" page is now "Gray Screen", SEO title "Gray Screen (Grey): ...", FAQ explains both spellings. Rule added to `docs/content-format.md`. |
| S-08 | 6 new guides + OG images | `bufferbloat-test-explained` (system), `how-to-test-a-used-monitor` (screen), `does-my-phone-have-a-gyroscope` (phone), `how-to-turn-on-hardware-acceleration` (system), `why-is-my-upload-speed-slow` (system), `mouse-accuracy-and-aim-training` (mouse, with an `aim-static-28` data block). All sources checked to load. Guides: 35 -> 41. |

## Tested

Local WordPress 7.1 (SQLite, recipe in phase-3.md), `WP_ENVIRONMENT_TYPE=local`:

- `php -l` clean on every PHP file; no PHP notices in `debug.log`.
- Gate on **all 178 URLs** (home + every URL in `/llms.txt`) at 375 px
  (iPhone 13) and 1366 px, share off and stats endpoints blocked: 0 page
  errors, no horizontal overflow, all JSON-LD parses, 178 internal link
  targets all 200.
- The CPS rank table text is identical on `cps-test`, `5-second-cps-test` and
  `what-is-a-good-cps`; the WPM table on `typing-speed-test`,
  `1-minute-typing-test`, `typing-test` hub and `average-typing-speed`.
- `/guides/` lists the 6 new guides; sitemap and `/llms.txt` include them and
  `/how-we-test/`. Privacy policy shows "up to 24 hours".
- Screenshots checked at 375 px: author box, How we test table, CPS bands.

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so the homepage, footer and
   privacy policy show the new wording; open `/how-we-test/` and one guide
   (author box at the end) once.
2. **Before switching ads on** (`TN_ADS_ENABLED`): in AdSense -> Privacy &
   messaging, create and publish the EEA/UK/Switzerland consent message
   (Google-certified CMP). The privacy policy promises it "when ads or
   analytics are switched on". When GA4 or Clarity IDs are added, update the
   Analytics section of the policy from "not switched on" to "we use".
3. Check the About bio and tell us if anything should change (years of
   experience, devices you own). It lives in `TN_FOUNDER_BIO` in
   `inc/config.php`. Pending from phase 19: replace the `admin` user and turn
   off the Hostinger llms.txt.
4. Optional, real device: on an iPhone Pro, open `/refresh-rate-test/` before
   and after turning off the Safari 60fps feature flag.

## Next

Audit fix phase 4 (`phase-4-ux-mobile-a11y.md`, repo `docs/handoff/phase-21.md`).
Phase 4 can style `.author-box` if it wants more spacing; this phase did not
touch CSS. The two overflowing guide tables (`how-to-change-dns-server`,
`what-is-a-good-ping`) were left for phase 4 as planned.
