# Testnook theme

WordPress theme for [testnook.com](https://testnook.com), a collection of free
browser-based hardware tests (keyboard, mouse, controller, screen, audio,
camera, benchmarks).

This repository **is** the theme folder. Hostinger deploys the `main` branch
to `public_html/wp-content/themes/testnook`, so every merge to `main` goes
live. Work on a branch per phase, test, then merge.

## Layout

```
style.css            theme header (the real CSS is assets/css/main.css)
functions.php        loads inc/*
inc/config.php       site name, contact email, founder, AdSense/GA4/Clarity ids
inc/registry.php     reads content/ and the catalog
inc/sync.php         creates/updates WordPress pages from content files
inc/routing.php      picks the template for tool / hub / static pages, embed mode
inc/assets.php       inlines CSS, loads JS, favicons
inc/seo.php          title, description, OG, JSON-LD schema
inc/ads.php          ad slot rules, ads.txt
inc/indexnow.php     IndexNow key file and pings after a content sync
inc/helpers.php      breadcrumbs, cards, FAQ, related tools, HTML allow-list
inc/icons.php        inline SVG icons
inc/results.php      anonymous result stats (REST, table, hourly cache)
inc/leaderboards.php nicknames, top-10 boards, moderation screen
inc/guides.php       guide lists, cards, live-stats tokens, /guides/ index
content/catalog.php  the 8 hubs and the full list of planned tools, in launch order
content/home.php     homepage copy
content/tools/       one file per live tool          -> /<slug>/
content/hubs/        one file per hub                -> /<hub>/
content/pages/       about, contact, privacy, terms, guides, leaderboards, embed-tools -> /<slug>/
content/guides/      one file per guide (article)   -> /<slug>/
templates/           tool.php, hub.php, guide.php, static.php, embed.php
assets/css/main.css  the stylesheet (plus assets/css/tools/*.css per tool)
assets/js/site.js    theme toggle, nav, search, fullscreen, lazy ads, analytics
assets/js/tools/     one script per tool
assets/img/          favicons, logo, share images (assets/img/og/<slug>.jpg per tool and hub)
bin/make-og-images.py  regenerates the share images from the catalog and the guides (run locally, commit the output)
docs/                content format and phase handoff notes
```

How to write a tool, hub, guide or page: [docs/content-format.md](docs/content-format.md).
Phase notes: [docs/handoff/](docs/handoff/).

## Local testing

Any WordPress install works. The quickest is WordPress + the
"SQLite Database Integration" plugin, with this folder symlinked into
`wp-content/themes/testnook`, served by `php -S`. Activate the theme once;
pages are created automatically.

## Going live checklist (once)

1. wp-admin > Appearance > Themes > activate **Testnook**.
2. Settings > Permalinks: "Post name" (the theme sets this on activation if the
   site was still on plain links; check it anyway).
3. Settings > Reading: leave "Your latest posts"; the theme serves its own homepage.
4. When AdSense approves: set `TN_ADSENSE_CLIENT` and `TN_ADS_ENABLED` in
   `inc/config.php`. `ads.txt` is then served automatically.
5. Set `TN_GA4_ID` and `TN_CLARITY_ID` in `inc/config.php` when the properties exist.
