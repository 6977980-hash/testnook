# Phase 32 handoff: audit 3, fix phase 4 (server, plugin and repo hygiene)

Date: 27 Nov 2026. From the 27 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-27/`, handoff
`phase-4-server-hygiene.md`), approved by Ali. No CSS or JS change, so
`TN_VERSION` stays as phase 29 sets it. No content, tool or guide changes.

## What changed in the repo

| ID | File | Change |
|---|---|---|
| F-73 | `kb-1366.png`, `kb-375.png`, `kb-768.png` | Deleted. They were keyboard-tester test screenshots (commit `5f40081`) served publicly at `/wp-content/themes/testnook/kb-*.png`. Nothing referenced them. |
| F-73 | `.gitignore` | `/*.png` with `!/screenshot.png`, so test screenshots can no longer be committed to the theme root, while a WordPress theme `screenshot.png` still could be. |
| S-20 / S-31 | `inc/config.php` | **Not changed.** `TN_SOCIAL_PROFILES` stays `array()` until Ali gives profile URLs. Adding them is a one-line change; the Organization JSON-LD `sameAs` picks them up. |

Tested: `bin/check.sh` lint OK. No page output changed, so the sitemap gate was not re-run.

## Live state before this phase (27 Nov 2026, checked from outside)

- `/readme.html` 200, `/license.txt` 200 (F-65, back after WordPress 7.1.5). `/wp-config-sample.php` 500 (PHP error page, no content).
- `/wp-content/themes/testnook/kb-{1366,375,768}.png` 200 (F-73, fixed by this PR on deploy).
- `/wp-json/` namespaces include `hostinger-ai-assistant/v1`, `mcp`, `wp-abilities/v1` (F-66).

## Ali's steps (outside the repo)

1. **F-65**: in hPanel -> File manager -> `public_html/.htaccess`, above `# BEGIN WordPress`:
   ```
   <FilesMatch "^(readme\.html|license\.txt|wp-config-sample\.php)$">
   Require all denied
   </FilesMatch>
   ```
   Expected: `/readme.html` and `/license.txt` answer 403, also after the next core update.
2. **F-66**: if the Hostinger AI Assistant / MCP plugin is not used, deactivate and delete it in wp-admin -> Plugins (and turn AI features off in Hostinger Tools). Expected: `/wp-json/` no longer lists those namespaces.
3. **S-25** Google Search Console: Request indexing (a few per day) for `/how-to-fix-stick-drift/`, `/what-is-a-good-internet-speed/`, `/how-to-reduce-ping/`, `/auto-rotate-not-working/`, `/eye-test/`, `/how-to-test-a-used-monitor/`, `/webcam-not-working/`, then `/cps-test/`, `/reaction-time-test/`, `/typing-speed-test/`, `/keyboard-tester/`, `/mouse-tester/`. Add the Domain property `testnook.com` (DNS TXT in hPanel -> DNS). Bing Webmaster Tools: import from GSC. Make `aliahmadventures@gmail.com` an Owner of the GSC property.
4. **S-31**: make Testnook social profiles, send the URLs; then list on AlternativeTo / Product Hunt / Slant, answer real Reddit questions with one disclosed link, offer `/embed-tools/` widgets to small blogs. No paid links or link exchanges.

## Status of Ali's steps (checked from outside, 27 Nov 2026)

- **F-73 done.** Hostinger's git deploy did **not** delete the removed PNGs (still 200 for 15+ min after the merge), so Ali deleted them in File manager. Now 404. Lesson: when a phase deletes a file from the repo, ask Ali to delete it on the server too.
- **F-66 done.** Ali removed the Hostinger AI Assistant / MCP plugin. `/wp-json/` no longer lists `hostinger-ai-assistant/v1` or `mcp`. `wp-abilities/v1` stays; it is WordPress core (Abilities API), not the plugin.
- **F-65 partly done.** Ali deleted `readme.html` and `license.txt` in File manager; both now 404. The `.htaccess` rule was not added, so the next WordPress core update will bring them back. Next audit: re-check, and add the rule if they return.
- **S-25 open** (GSC Request indexing, Domain property, Owner, Bing import): Ali's ongoing task.
- **S-20 / S-31 open:** no social profile URLs yet, `TN_SOCIAL_PROFILES` still empty. When Ali sends URLs, add them in `inc/config.php` (one-line PR).
