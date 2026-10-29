# Phase 22 handoff: audit fix phase 5 (speed and security)

Date: 29 Oct 2026. Source: site audit of 29 Oct 2026, fix phase 5
(`phase-5-speed-security.md` in the project files). `TN_VERSION` stays
**0.7.1** (no site CSS or JS changed).

## What changed

| ID | File(s) | Fix |
|---|---|---|
| F-05 | `inc/setup.php` | `send_headers` adds `Strict-Transport-Security: max-age=31536000; includeSubDomains` (HTTPS only, no `preload`), `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin` and `Permissions-Policy: camera=(self), microphone=(self), geolocation=(self), gyroscope=(self), accelerometer=(self), magnetometer=(self)`. No `X-Frame-Options` / `frame-ancestors`: embeds are a feature. `interest-cohort=()` from the audit text was left out on purpose: Chrome no longer knows that feature and logs a console error for it on every page. |
| F-07 | new `.htaccess`, `docs/.htaccess`, `bin/.htaccess`, `.github/.htaccess` | Theme root denies `*.md`, `*.py`, `*.json`, `*.lock`, `*.sh`, `*.yml/yaml` and `.gitignore` anywhere in the theme; the three folders deny everything. Both Apache 2.4 (`Require all denied`) and 2.2 (`Deny from all`) syntax. `style.css`, `assets/**` (JS, CSS, images, `assets/img/og/*.jpg`) stay public. |
| F-37, S-11 | new `bin/check.sh`, `bin/check-pages.js`, `.github/workflows/check.yml`, `README.md` | `bin/check.sh` = `php -l` on every PHP file + `node --check` on every JS file; with a base URL it then runs `bin/check-pages.js`, the audit gate over every sitemap URL at 375 px (iPhone 13; `--wide` adds 1366 px): status 200, 0 page errors, JSON-LD parses, exactly one H1, no horizontal overflow, no unlabeled inputs, no skipped heading levels (`--a11y=warn` makes the last two warnings). `tn-share-off` is set and `testnook/v1/(start|result|claim|embed)` blocked. GitHub Action runs the lint on every PR and push to `main`. Usage in README "Checks". |

## Tested

- `bin/check.sh` lint: clean (all PHP, all JS).
- Local WordPress 7.1 (SQLite, recipe in phase-3.md) on `php -S`: every page
  sends nosniff, Referrer-Policy and Permissions-Policy (HSTS correctly absent
  on plain http). Gate `--wide` over all 178 sitemap URLs (356 page loads):
  all pass; 20 pages x 2 widths warn about the h1 -> h3 skips and
  `#rl-diag` label, which are audit phase 4's F-15/F-16.
- Cross-origin embed: a page on `localhost:8090` iframing
  `127.0.0.1:8080/cps-test/?embed=1` and `/webcam-test/?embed=1` (with the
  embed code's `allow=` list): both load; camera works inside the webcam
  iframe; the CPS iframe without `allow` correctly has no camera.
- Top level `/webcam-test/`, `/mic-test/`, `/gps-test/`, `/compass-test/`:
  camera, mic, geolocation, gyroscope, accelerometer, magnetometer, gamepad and
  fullscreen all allowed by the policy; getUserMedia and geolocation succeed;
  0 console errors or warnings.
- `.htaccess` rules on a real Apache 2.4 with the theme at
  `/wp-content/themes/testnook/`: README.md, docs/**, bin/**, .gitignore,
  .github/** -> 403; style.css, assets/js/site.js, assets/css/main.css,
  favicon.svg, og/cps-test.jpg -> 200, and assets still get the 1-year
  Cache-Control from phase 19.
- Gate against the live site before this merge: only the same 20 phase 4
  a11y failures.

Live after the deploy (29 Oct 2026, ~12:00 UTC):

- `curl -I https://testnook.com/` shows `strict-transport-security:
  max-age=31536000; includeSubDomains`, `x-content-type-options: nosniff`,
  `referrer-policy`, `permissions-policy`; no `x-frame-options`. A fresh URL
  keeps the headers on its LiteSpeed and hCDN cache hits; pages cached before
  the deploy lack them until the cache is purged.
- `docs/handoff/phase-17.md`, `bin/make-og-images.py`, `README.md`,
  `.gitignore` -> 403; `style.css`, `assets/img/og/cps-test.jpg` -> 200.
- A page on another origin iframing `/cps-test/?embed=1` and
  `/webcam-test/?embed=1`: both load, the webcam embed gets the camera.
- `bin/check.sh https://testnook.com --wide --a11y=warn`: 356/356 pass (the 20
  phase 4 pages warn). One earlier run had 12 load failures on a cold cache
  and passed on rerun, so the gate now retries a load failure or 5xx once.
- securityheaders.com blocks scripted requests (403); check the grade in a
  browser (expected A: only X-Frame-Options is missing, on purpose).

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so cached pages get the new
   headers.
2. On the iPhone, open `/webcam-test/`, `/mic-test/` and `/compass-test/` once
   and allow access: each should still ask and work.
3. Optional (from phase 19, F-25): hPanel -> File manager ->
   `public_html/.htaccess`, above `# BEGIN WordPress`, add
   `<FilesMatch "^(readme\.html|license\.txt|xmlrpc\.php)$">Require all denied</FilesMatch>`.
4. Still pending from phase 19: replace the `admin` user and turn off the
   Hostinger llms.txt.

## Notes for later phases

- Run `bin/check.sh https://testnook.com` after every deploy (and
  `bin/check.sh http://127.0.0.1:8080 --wide` before merging). After audit
  phase 4 merges, the gate should pass without `--a11y=warn`.
- HSTS has no `preload`. Add it (and submit to hstspreload.org) only if every
  subdomain of testnook.com will always be HTTPS.
- New tool permissions (e.g. `display-capture`, `midi`, `bluetooth`) default
  to `self` as they are not listed; add a feature to the Permissions-Policy
  line only to grant or restrict it explicitly.

## Next

The five audit fix phases are done once phase 4 (repo `phase-21.md`) merges.
The roadmap from phase-17.md carries forward.
