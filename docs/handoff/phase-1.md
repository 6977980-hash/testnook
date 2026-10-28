# Phase 1 handoff: theme base

Date: 28 Oct 2026. Branch `phase-1`, merged to `main`.

## What was built

- A custom WordPress theme that is the whole site. No page builder, no plugins
  required, system fonts, inlined CSS (about 14 KB), one deferred JS file,
  light/dark mode (remembered in localStorage), mobile-first, sticky header
  with the 8 hub links, footer with hubs and legal links.
- **Pages come from files.** `content/tools/<slug>.php`, `content/hubs/<slug>.php`
  and `content/pages/<slug>.php` are synced into WordPress pages on the first
  request after a deploy (`inc/sync.php`). Removing a file drafts the page.
  Nobody edits content in wp-admin. Format: `docs/content-format.md`.
- `content/catalog.php` lists the 8 hubs and all 32 Tier 1 tools in launch
  order with name, blurb and hub. Tools without a content file render as
  "Coming soon" cards (no link) on the homepage; hubs without a file link to
  the homepage anchor `/#<hub>`.
- Templates: `templates/tool.php` (H1, trust line, device warning, tool box,
  How to use, What results mean, extra sections, Common problems and fixes,
  FAQ, disclaimer, related tools (8), embed code, last updated),
  `templates/hub.php`, `templates/static.php`, `templates/embed.php`
  (`?embed=1`, noindex, tool only), `front-page.php`, `404.php`, `index.php`.
- Homepage: hero, live search over the cards, hub chips, tool grid grouped by
  hub, 4 feature boxes, guide text, 6 FAQs.
- Static pages live: `/about/`, `/contact/`, `/privacy-policy/`, `/terms/`
  (AdSense-ready privacy text, founder Ali Ahmad + LinkedIn, contact@testnook.com).
- SEO: `<title>`/meta description per page from the content file, canonical,
  Open Graph + Twitter card, `og-default.jpg` (per-page override via
  `assets/img/og/<slug>.jpg`), JSON-LD graph: Organization (+founder Person),
  WebSite with SearchAction, WebApplication per tool, CollectionPage+ItemList per
  hub, BreadcrumbList, FAQPage. No HowTo, no ratings (research decision).
  Core WP sitemap kept (`/wp-sitemap.xml`; pages are in
  `wp-sitemap-posts-page-1.xml`), users and tags removed from it.
  If Yoast/Rank Math is ever installed the theme steps back from titles/OG.
- Ads: `inc/ads.php`. Slots `below-tool`, `in-content`, `after-faq` with fixed
  min-heights. Modes per page: `standard`, `content` (no slot under click
  tools), `none` (colour screens, dead pixel, burn-in). Nothing prints until
  `TN_ADS_ENABLED` + `TN_ADSENSE_CLIENT` are set in `inc/config.php`;
  `/ads.txt` is served from the client id. AdSense script loads lazily on
  first interaction or after 4 s. GA4 and Clarity load after `load` when ids
  are set.
- JS helpers for tools in `assets/js/site.js` (`window.TNUtil`): fullscreen
  with iPhone fallback (`data-tn-fullscreen="#tool"`), device notes
  (`'device' => desktop|touch|gamepad|media`), status line helper,
  getUserMedia error texts, copy buttons.
- Activation hook sets pretty permalinks (if still plain), closes comments,
  trashes the untouched sample post/page, creates the pages.

## Tested

Local WordPress 6.9 on SQLite with the theme symlinked, Playwright on desktop
(1280px) and iPhone 13 viewport: homepage (light + dark + search), a temporary
tool page (deleted again), embed mode, About, Privacy, 404. No console errors,
no horizontal scroll, valid JSON-LD on every page, sitemap lists all pages,
embed is noindex.

## Decisions

- Stack: WordPress theme in this repo, Hostinger auto-deploys `main`
  (supersedes the master plan's static-HTML stack).
- URLs: `/<slug>/` for tools, `/<hub>/` for hubs, exactly as in the master plan.
- Content lives in PHP arrays in the repo, not in the WP database, so the whole
  site is versioned and reviewable in git.
- FAQ is kept (content + FAQPage schema) but not relied on for rich results.
- Hearing/eye tests must set `'disclaimer'`; `/terms/` already carries the
  general health and flashing-light wording.

## Ali's one-time steps after this merge

1. wp-admin > Appearance > Themes > activate **Testnook**.
2. Settings > Permalinks > "Post name" > Save (even if already set, to flush rules).
3. Visit `/` and `/about/` to confirm. The homepage will show every tool as
   "Coming soon" until Phase 2 lands.

## What is left overall

Phases 2-5: the 32 Tier 1 tools (8 per phase, plan order). Phase 6: the 8 hub
pages, per-tool OG images, IndexNow key + ping, final polish. Later: Tier 2
pages and guides per the master plan.

## What Phase 2 should do

Build tools 1-8 from the master plan, in order:
`speaker-cleaner`, `webcam-test`, `mouse-tester`, `dead-pixel-test`,
`stuck-pixel-fixer`, `fps-test`, `sound-test`, `double-click-test`.

For each tool:
1. `content/tools/<slug>.php` per `docs/content-format.md`: 500-900 words,
   primary keyword in H1/title, secondary keywords from master plan section 7.1
   in the copy, 6 FAQs, 3-5 fixes, `related`, `updated`.
2. `assets/js/tools/<slug>.js` (IIFE, bail if `[data-tool="<slug>"]` is absent)
   and optional `assets/css/tools/<slug>.css`.
3. Ads mode: `none` for dead-pixel-test, stuck-pixel-fixer and any fullscreen
   colour surface; `content` for double-click-test (click area); `standard`
   for the rest.
4. Device: `media` for webcam-test, `desktop` for mouse tests (touch users get
   the warning plus a link to the touch screen test when it exists).
5. Speaker cleaner: 165 Hz tone via Web Audio, start at low volume, warning
   text; sound test: tones + left/right/stereo buttons; fps/refresh: rAF
   counter; dead pixel: fullscreen colour cycle with keyboard/tap to advance.
6. Test every tool in Playwright (desktop + mobile), check console, then merge
   `phase-2` into `main` and write `docs/handoff/phase-2.md`.

Local test setup used in Phase 1 (recreate in a new session): download
WordPress + `sqlite-database-integration` plugin, copy `db.copy` to
`wp-content/db.php`, symlink this repo to `wp-content/themes/testnook`,
`wp core install`, `wp theme activate testnook`, serve with
`php -S 127.0.0.1:8080` and a small router that sends unknown paths to
`index.php`.
