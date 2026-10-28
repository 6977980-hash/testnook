# Phase 7 handoff: Tier 2 batch 1, colour screens

Date: 28 Oct 2026. Branch `claude/project-thread-gsx6ye`, merged to `main`.

Also merged separately during this phase: PR #6 (`gsc-verification`) adds
`TN_GSC_VERIFICATION` in `inc/config.php` and prints the
`google-site-verification` meta tag on every page (`inc/seo.php`, `wp_head`
priority 0, independent of the SEO plugin check). Empty value disables it.

## What was built

8 new tool pages, all hub `screen`, `ads => none`, device `any`:

| Page | Main colour | Angle of the copy |
|---|---|---|
| `/red-screen/` | #FF0000 | red subpixel check, night-vision light, evening use |
| `/green-screen/` | #00FF00 (+ chroma key #00B140) | green subpixel check; covers the chroma-key intent and says a monitor only works as a small close-up backdrop |
| `/blue-screen/` | #0000FF (+ chroma key #0047BB) | blue subpixel check, OLED blue ageing; one fix entry and one FAQ cover the Windows BSOD intent and say this page is not that |
| `/yellow-screen/` | #FFFF00 | blue-free warm light, stuck-blue-subpixel check |
| `/orange-screen/` | #FF8000 | sunset light, golden fill light, colour evenness |
| `/pink-screen/` | #FFC0CB (+ magenta) | selfie/makeup light, mood light, magenta pixel check |
| `/purple-screen/` | #800080 | gaming/stream mood light, lavender night light, "not a UV light" |
| `/grey-screen/` | #808080 with 5/10/20/35/75/90% | uniformity, dirty screen effect, burn-in; FAQ covers grey vs gray |

Each page: 54-60 char title, 155-160 char description, 4 how-to steps, a
results section that says what each coloured dot means, a "What it is used
for" section, 3-4 fixes, 6 FAQs, 7 swatches, 700-820 words.

Shared code:

- `content/tools/_colour-screen.php`: returns a closure
  `( $colour, $swatches, $status )` that builds the tool markup (same markup
  as the white/black pages). The first swatch is the page's main colour and
  gets `aria-pressed="true"`. Not in the catalog, like `_gamepad-diagram.php`.
- `assets/js/tools/colour-screen.js` now finds its root from `#cs-screen`
  (`closest('[data-tool]')`) instead of a hard-coded list of slugs, and takes
  the initial colour from the pressed swatch. White and black screens are
  unchanged in behaviour (re-tested).
- `content/catalog.php`: 8 entries appended (40 tools total). The screen hub
  now shows 17 cards.
- `content/hubs/screen.php`: description/intro mention colour screens; the
  guide text links all 8 new pages. `white-screen.php` and `black-screen.php`
  `related` lists include the new pages.
- `assets/img/og/<slug>.jpg` for the 8 pages (`bin/make-og-images.py`).

## Tested

Local WordPress 6.9 on SQLite (Phase 3 recipe, `WP_ENVIRONMENT_TYPE` local).
Playwright over the 8 pages at 1280 px and iPhone 13: 200, title 54-60,
description 155-160, 6 FAQs, 8 related cards, 7 swatches, own OG image, GSC
tag present, valid JSON-LD, **no ad slot markup**, no horizontal scroll, no
console errors; every internal link in the page body resolves 200. Full
screen: button opens with the right main colour, Esc closes, clicking the
second swatch opens with that swatch's colour, click/tap closes. Homepage: 52
cards, no "Coming soon". Screen hub: 17 cards, 10 colour-screen links in the
guide. Embed mode: noindex, tool renders. Sitemap: 53 URLs, all 8 new pages
present. `debug.log` empty apart from WordPress auto-update lines. White and
black screens re-tested after the JS change. Screenshots:
`project files/testnook/phase-7-red-screen.png`, `phase-7-screen-hub.png`.

Not testable here: real IndexNow ping (first production request after deploy
submits the 8 new URLs, plus the homepage and screen hub because the catalog
changed), social previews of the new OG images.

## Decisions

- British "colour"/"grey" in copy, with "gray" covered in the grey page's title
  (`Grey Screen: Full Screen Gray Page...`), intro and an FAQ, because US
  searchers type "gray screen".
- Blue screen: BSOD intent handled in one fix entry and one FAQ, not a full
  troubleshooting guide. A separate `blue-screen-of-death` guide can come in
  Tier 3 if the page attracts that traffic.
- Green screen: honest about monitor-as-backdrop limits (close-ups only) so
  the page does not over-promise to chroma-key searchers.
- No new hub, no new JS or CSS files, no theme core changes: the whole batch
  is content + a tiny JS generalisation.
- Pink/purple main colours are the CSS named colours (#FFC0CB, #800080) so the
  page matches what "pink" and "purple" mean in CSS and on Wikipedia.

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/screen/`: 17 cards, the
   8 colour screens at the end. Try `/red-screen/` and `/grey-screen/` on a
   phone and a monitor.
2. Search Console: the GSC tag is live (PR #6), verify the property if not yet
   done, then request indexing for the 8 new URLs or just resubmit
   `https://testnook.com/wp-sitemap.xml`.
3. Nothing else: IndexNow pings the new pages on the first visit.

## What Phase 8 should do

Next Tier 2 batch (section 7.2 of the master plan, volume order), suggested 8:

1. `ufo-test` (motion blur / ghosting, 500K) - new script: moving objects at
   selectable speeds, frame-skipping check; hub `screen`, `ads => content`.
2. `metronome` and `tap-bpm` - hub `audio` (or `benchmark` for tap-bpm); Web
   Audio scheduling for the metronome; `ads => content` (tapping).
3. `guitar-tuner` - Web Audio pitch detection (autocorrelation), mic
   permission; hub `audio`, `device => media`, `ads => standard`.
4. `stroop-test`, `f1-reaction-test` - hub `benchmark`, `ads => content`,
   reuse the reaction-time page structure.
5. `right-click-cps-test`, `jitter-click-test` - hub `benchmark`/`mouse`,
   reuse `cps-test.js` with a mode parameter, `ads => content`.

Recipe unchanged: catalog entry, `content/tools/<slug>.php`, script, CSS, run
`python3 bin/make-og-images.py`, commit the JPEGs. For another colour page
(e.g. `cyan-screen`, `brown-screen`), copy any of the 8 files: only the
swatches, copy and `related` change.

Local test setup: as in `docs/handoff/phase-3.md`, with
`define( 'WP_ENVIRONMENT_TYPE', 'local' );` in `wp-config.php`.
