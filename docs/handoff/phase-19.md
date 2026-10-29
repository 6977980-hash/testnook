# Phase 19 handoff: audit fix phase 2 (crawl, index, technical SEO)

Date: 29 Oct 2026. Source: site audit of 29 Oct 2026, fix phase 2
(`phase-2-crawl-seo.md` in the project files). `TN_VERSION` stays **0.7.1**
(no CSS or JS changed).

## What changed

| ID | File(s) | Fix |
|---|---|---|
| F-03 | `inc/setup.php`, `inc/seo.php` | `template_redirect` at priority 1 (before `redirect_canonical`, which would send `/?author=1` to `/author/<username>/`) 301s author, date and attachment archives and every feed to `/`. `wp_robots` adds `noindex, follow` to any archive or search page that is left (categories). Logged-out REST requests no longer have `/wp/v2/users` routes (404 instead of `[]`); wp-admin is unaffected. |
| F-25 | `inc/setup.php` | `feed_links` removed from `<head>` (`feed_links_extra` already was); feeds 301 to home (above); `xmlrpc_enabled` false and `xmlrpc_methods` empty, so XML-RPC answers no method, pingback included. |
| F-06 | new `inc/llms.php` (required from `functions.php`) | `/llms.txt` served on `parse_request` (same pattern as `/ads.txt`): site name, the homepage description, then `## Hubs` (12), `## Tools` (116, grouped by primary hub), `## Guides` (35, newest first), `## Pages` (7), each `- [Title](https://testnook.com/slug/): description`. Built from the registry, so new content appears by itself. Sent with `X-Robots-Tag: noindex`. |
| S-12 | `inc/seo.php` | `robots_txt` filter appends a comment: AI crawlers are allowed (decision H-4), plus the `/llms.txt` URL. Not linked from the UI. |
| S-10 | `inc/config.php`, `inc/seo.php` | New `TN_SOCIAL_PROFILES` (empty array). When it has URLs they go into the Organization `sameAs`; the founder's LinkedIn stays on the Person node. |
| F-24 | `content/pages/leaderboards.php`, `content/tools/{fps-test,sound-test,speaker-cleaner}.php`, plus `content/pages/{about,embed-tools,guides}.php` | Leaderboards SEO title 68 -> 60. Descriptions: fps 165 -> 150, sound 162 -> 155, speaker cleaner 161 -> 155. A full scan found three more over 160 (about 166, embed-tools 163, guides 161), now 150/153/153. Every page is now title <= 60 (homepage 67, brand first, left as is) and description <= 160. |
| F-26 | new `assets/.htaccess` | `Cache-Control: public, max-age=31536000, immutable` (mod_headers) and 1-year `Expires` (mod_expires) for js, css, svg, images and fonts under the theme's `assets/`. Safe because every asset URL carries `?ver=TN_VERSION.filemtime`. |
| F-29 | `content/pages/guides.php` | Intro now says guides "will also show anonymous results ... once enough people have taken it" (phase 1 already prints "n results so far" on tool pages). |

## Tested

Local WordPress 7.1 (SQLite, recipe in phase-3.md) with curl and Playwright:

- `/?author=1`, `/author/admin/`, `/feed/`, `/comments/feed/`, `/?feed=rss2` -> 301 to `/`. Date archives 404 (no posts). Category archive 200 with `noindex, follow`.
- `/wp-json/wp/v2/users` and `/users/1` logged out -> 404 `rest_no_route`; `testnook/v1/stats` still 200.
- XML-RPC POST `system.listMethods` / `pingback.ping` -> fault (no methods).
- `/robots.txt` ends with the AI-crawler comment and the llms.txt URL, after the core `Sitemap:` line.
- `/llms.txt`: 170 links (12 + 116 + 35 + 7) plus the homepage = all 171 URLs, no duplicates.
- Lengths checked for every page key with wp-cli eval.
- Gate: 9 pages (home, leaderboards, guides, fps, sound, speaker cleaner, cps, about, embed-tools) at 375 px (iPhone 13) and 1366 px: 0 page errors, no horizontal overflow, JSON-LD parses, 171 internal links all 200.
- `assets/.htaccess` cannot be tested on `php -S`; checked live after the deploy (see the PR).

## Ali's steps (outside the repo)

1. **Replace the `admin` user** (F-03): wp-admin -> Users -> Add New User, role
   Administrator, a username nobody can guess (not your name, not "testnook"),
   a strong password, a display name such as "Testnook". Log out, log in as the
   new user, Users -> All Users -> `admin` -> Delete -> "Attribute all content
   to" the new user -> Confirm. Check: logging in with `admin` fails.
2. **Turn off the Hostinger llms.txt** (F-06): wp-admin -> Hostinger (Tools)
   -> the LLMs.txt / AI option -> off, so the plugin's 4-page file does not
   compete with the theme's. Then purge the cache (hPanel -> Website -> Cache)
   and open `https://testnook.com/llms.txt`: it should start with `# Testnook`
   and list the tools.
3. **Optional server rules** (F-25): in hPanel -> File manager ->
   `public_html/.htaccess`, above `# BEGIN WordPress`, add
   `<FilesMatch "^(readme\.html|license\.txt|xmlrpc\.php)$">Require all denied</FilesMatch>`.
   Phase 5 (security headers) edits the same file, so it can do this there.
4. **Social profiles** (S-10): if Testnook gets X, YouTube, Facebook or other
   accounts, put the URLs in `TN_SOCIAL_PROFILES` in `inc/config.php`.

## Next

Audit fix phase 3 (`phase-3-content-trust.md`, repo `docs/handoff/phase-20.md`).
The homepage description still says "nothing uploaded"; it feeds the llms.txt
summary line, so phase 3's F-02 rewrite fixes both at once.
