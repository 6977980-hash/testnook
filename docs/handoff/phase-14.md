# Phase 14 handoff: Tier 3, part 1 (guides)

Date: 29 Oct 2026. Branch `claude/project-thread-rrw5cf`, merged to `main`.
First Tier 3 phase, following `docs/handoff/phase-13b.md`. Builds the guide
system and the first 12 guides. Still 101 tools and 11 hubs; 13 new pages
(`/guides/` + 12 articles). `TN_VERSION` 0.5.0.

## What was built

### Guide system

- `content/guides/<slug>.php` is a new content kind (page key `guide:<slug>`,
  no catalog entry needed). Fields are documented in
  `docs/content-format.md` ("Guide file"): title, seo_title, description,
  blurb, hub, tool, tools, published, updated, intro, summary (the "short
  answer" box), sections (heading, HTML, anchor id), optional data (live
  stats), faq, sources, disclaimer, ads.
- `inc/guides.php` (required from `functions.php`): `tn_guides()` (newest
  first), `tn_guides_for_tool()`, `tn_guides_in_hub()`, `tn_guide_card()`,
  `tn_guides_section()`, `tn_guide_words()` / `tn_guide_minutes()`,
  `tn_guide_data_html()` (fills the `{median:board}`, `{mean:}`, `{top10:}`,
  `{count:}` and `{beats:board:value}` tokens from the hourly stats cache and
  returns '' when any board has under 20 results), `tn_guides_index()` (the
  `/guides/` body, grouped by hub in catalog order).
- `templates/guide.php`: breadcrumb Home / Guides / title, H1, lede, byline
  (founder, updated date, reading time), "The short answer" box, the main
  tool's card ("Try it in your browser"), "On this page" contents (when more
  than two entries), the sections, the live-data block after the section
  named in `data.after` (uses `tn_stats_block()` with its new heading, lead
  and id parameters), one in-content ad slot after the second section, FAQ,
  sources, disclaimer, after-FAQ slot, "More guides" (same hub first, up to
  6) and "Tools from this guide" (the guide's tools, filled from the hub).
- `inc/registry.php`: `guide:` keys in `tn_get_def()`, `tn_all_keys()` and
  `tn_content_files()`, so the sync, IndexNow and the sitemap pick guides up
  like any other page. `inc/routing.php` maps `guide` to the template.
- `inc/seo.php`: guides get `Article` schema (headline, datePublished,
  dateModified, wordCount, author = the founder Person node, publisher =
  the Organization) plus BreadcrumbList and FAQPage; `og:type` is `article`
  on guides. OG images: `bin/make-og-images.py` now also reads
  `content/guides/` (kicker "<Hub title> guide", subtitle "A Testnook
  guide"); the 12 JPEGs are committed.
- Links in: tool pages print "Guides for this test" (cards) above Related
  tools for guides whose `tool` or `tools` name the page; hub pages print
  "Guides" after the FAQ; the homepage has a "Guides" section (six newest)
  between the hubs and "Why use Testnook"; the footer has a "Guides" link;
  `content/pages/guides.php` is the index page (`render` =>
  `tn_guides_index`). New icon `book` in `inc/icons.php`.
- CSS: `.byline`, `.guide-top`, `.takeaways`, `.guide-cta`, `.toc`,
  `.sources`, `.guides-group*` at the end of `main.css`.

### The 12 guides

| Slug | Hub | Main tool | Live data |
|---|---|---|---|
| `what-is-a-good-cps` | benchmark | cps-test | cps-5, cps-10 |
| `average-reaction-time` | benchmark | reaction-time-test | reaction |
| `average-typing-speed` | typing-test | typing-test-english | typing-60 |
| `how-to-fix-stick-drift` | controller | stick-drift-test | |
| `keyboard-key-not-working` | keyboard | keyboard-tester | |
| `webcam-not-working` | camera | webcam-test | |
| `microphone-not-working` | audio | mic-test | |
| `dead-pixel-vs-stuck-pixel` | screen | dead-pixel-test | deadpixel (count + map) |
| `is-144hz-worth-it` | screen | refresh-rate-test | |
| `oled-burn-in-fix` | screen | burn-in-test | |
| `types-of-colour-blindness` | vision-test | color-vision-test | |
| `mouse-double-clicking-fix` | mouse | double-click-test | |

Each: 5-6 sections of 900-1,400 words, a 4-point short answer, 6 FAQs,
2-5 linked tools, SEO title 49-59 chars, description 151-160 chars. The
guides with live data quote the site median / top 10% / "X beats Y% of
results" and link `/leaderboards/`. Sources are listed only where a specific
study or standard is cited (Woods 2015 reaction time, Dhakal 2018 typing,
NEI and Colour Blind Awareness, iFixit).

## Tested

Local WordPress on SQLite (Phase 3 recipe, `WP_ENVIRONMENT_TYPE` local).
Seeded 120 results per data board (cps-5, cps-10, reaction, typing-60) and
80 dead pixel results, then `tn_stats_refresh_all()`.

- PHP lint on every changed file; all 12 guides load with unique section
  ids, existing tool slugs in `tool` / `tools` and no dead internal links.
- curl: every guide 200, `<title>` and description present, Article JSON-LD,
  `og:type` article, the data block and its TOC entry appear only on the four
  guides with data and only after seeding (before seeding: no block, no TOC
  entry, text reads fine).
- Playwright, 17 pages (home, `/guides/`, `/cps-test/`, `/benchmark/`,
  `/screen/`, 12 guides) at 1280 px and iPhone 13: all 200, no console
  errors or warnings, no page errors, no horizontal scroll, valid JSON-LD,
  every "On this page" anchor resolves, guide cards present where expected
  (home 6, `/guides/` 12, cps-test 2, benchmark 2, screen 3). Dark mode
  checked on the data block. `debug.log` stays empty (no PHP notices).
- OG images: 12 written, checked `what-is-a-good-cps.jpg` visually.

Not tested here: MySQL on Hostinger (no new queries; the stats come from the
existing transients), the IndexNow ping for the 13 new URLs (runs on the
first production request after deploy, as before).

Screenshots: `phase-14-guide-cps.png`, `phase-14-guide-cps-iphone.png`,
`phase-14-guide-data-dark.png`, `phase-14-guides-index.png`,
`phase-14-guide-stick-drift*.png`, `phase-14-tool-guides-section.png` in
project files.

## Decisions

- Guides are a separate content kind rather than tools with no tool markup,
  so they get Article schema, a byline, reading time and a contents list
  without touching the tool template, and so the catalog (which drives
  "Coming soon" cards and the tool count) stays tools-only.
- Live numbers are tokens in the guide text, filled from the same cache as
  the tool pages, and the whole data section disappears under 20 results.
  The surrounding prose never depends on it, so a quiet board does not leave
  a broken sentence.
- `published` orders lists and is the schema `datePublished`; `updated` is
  what the byline shows. When a guide is revised, change `updated` only.
- The in-content ad slot sits after the second section (long text above and
  below), and the FAQ slot stays; guides use `ads => standard` by default.
- Author is the founder on every guide (one Person node reused from the
  Organization schema). No fake reviewer or "medically reviewed" claims;
  the colour blindness guide carries the eye-test disclaimer.
- English spelling follows the site: "colour" in prose and slugs
  (`types-of-colour-blindness`), but the existing tool slug
  `color-vision-test` stays as it is.

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/guides/` and one
   guide, e.g. `https://testnook.com/what-is-a-good-cps/`. The "What people
   actually score" block appears once the 5 s and 10 s boards each have 20
   results in the last 30 days.
2. Search Console: resubmit `https://testnook.com/wp-sitemap.xml` (13 new
   URLs) and request indexing for two or three guides by hand.
3. Optional: share one guide on LinkedIn to check the article OG card.

## Remaining roadmap (carry this forward in every handoff)

1. **Phase 15: more guides** with the same recipe (one file, no code):
   suggested next 12: how to fix keyboard ghosting, mouse polling rate
   explained (125 vs 1000 Hz), what DPI should I use, average WPM for
   programmers, how to clean a phone speaker (speaker cleaner), fix
   backlight bleed, what is 20/20 vision, astigmatism explained, how to
   test a used phone before buying, battery health explained, headphone
   left/right wiring fixes, what is a good chimp test score. Add a `data`
   block wherever a board exists (aim boards for the mouse accuracy guide).
2. **Phase 16: phone sensors** (gyroscope, accelerometer, compass,
   proximity, light sensor, GPS) as tools in the phone hub, each with a
   guide; `DeviceOrientation` / `DeviceMotion` need the iOS permission
   prompt (`requestPermission`) and HTTPS.
3. **Phase 17: system hub** (`system`): internet speed and ping, browser
   info, IP and DNS, WebGL/GPU info, then move device-info, user agent,
   what-phone and the screen info pages there by changing their `hub` key.
   A 12th hub needs the nav breakpoint raised or the hub names shortened
   (see phase-12).
4. Optional `typing-test-urdu` / `typing-test-hindi`; the SEO tidy-up of the
   older titles/descriptions listed in phase-12; later leaderboard ideas
   from phase-13b only if Ali asks.

Recipe for a guide: copy any file in `content/guides/`, change every field,
keep section ids unique, run `python3 bin/make-og-images.py` and commit the
JPEG, then the Playwright pass (desktop + iPhone 13: console, scroll,
JSON-LD, TOC anchors), merge to `main`, write `docs/handoff/phase-N.md`.
Recipe for tool pages unchanged (see phase-12 and phase-13b).
