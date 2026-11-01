# Phase 28 handoff: audit 2, fix phase 4 (speed and security)

Date: 1 Nov 2026. From the 1 Nov 2026 audit
(`/mnt/project-files/testnook/audit/2026-11-01/`), approved by Ali. This is
the last audit-2 fix phase. CSS changed, so `TN_VERSION` is now **0.7.7**.
No content, tool or guide changes (still 118 tools, 43 guides, 182 URLs).

## What changed

| ID | File | Change |
|---|---|---|
| F-43 / H-3 | `inc/analytics.php` | The inline block is unchanged (dataLayer, `gtag()` stub, both `consent default` calls, `ads_data_redaction`, `js`, `config`), so consent defaults are still set before anything else. The `<script async src=".../gtag/js">` tag is gone; the same inline block now injects it after `window` `load`, via `requestIdleCallback(load, {timeout: 2000})`, or `setTimeout(load, 1500)` where `requestIdleCallback` is not a function (Safari). If the page is already loaded when the block runs, it schedules straight away. **Never** tied to a click or keypress (Ali's decision). Events pushed before the script arrives (e.g. `share.js` `gtag('event','share',...)`) wait in `dataLayer` and are sent when it loads. Skip rules unchanged: production only, not in `?embed=1`, not for admins. Privacy policy needs no change (it does not mention load timing). |
| F-55 | `assets/css/tools/keyboard-tester.css` | `.kb-stage` is a size container (`container-type: inline-size`); `.kb-board:empty` gets a `min-height` from the same maths as `fit()` in `keyboard-tester.js`: full layout width = 22.8u + 76 px, height = 6u + 20 px; 60% layout (default when there is no fine pointer) width = 15u + 56 px, height = 5u + 16 px; u floored (`round(down, ...)` where supported) and clamped to 22-46 px. `:empty` stops applying once the script fills the board, so layout switches are not affected. JS untouched. If the key sizes in `keyboard-tester.js` change, update these numbers. |
| F-50 | `inc/setup.php` | New `parse_request` hook (priority 1) sends every author request home with 301 before WordPress looks the user up: path `/author` or `/author/...` (incl. feeds), `?author=`, `?author_name=`. Real and unknown users now answer the same. The old `template_redirect` hook for date/attachment/feed archives stays. `/authority-test/`-style slugs are not caught (checked: 404). |

## Tested (local WordPress, SQLite, phase-3 recipe)

Two servers on the same site: `:8080` with `WP_ENVIRONMENT_TYPE=local`, `:8081`
with `production` (GA requests aborted in Playwright, nothing sent to Google).

- `bin/check.sh`: lint OK. `bin/check.sh http://127.0.0.1:8080 --wide`: 364/364 page loads pass. Local env prints no gtag.
- GA injection (`:8081`, Playwright): the `gtag/js` tag is absent until `load`, then added ~10-20 ms after it (idle); with `requestIdleCallback` removed, added ~1.5 s after load; `dataLayer[0]` is the region `consent default`; `?embed=1` has no dataLayer and makes no Google request.
- Author URLs (local): `/author/a/` (real), `/author/nobody/`, `/?author=1`, `/?author=999`, `/?author_name=a`, `/?author_name=zz`, `/author/a/feed/`, `/author/` all 301 -> `/`.
- Keyboard tester: board height before the script = height after, at 320-1920 px desktop and 375-1024 px touch (both layouts). Layout-shift observer: 0 at 768 px and up and on all touch sizes; 0.004-0.008 on non-touch windows under 600 px (that is the "scroll sideways" hint appearing, not the board).
- Lighthouse 12 (simulated throttling, Google Analytics collect requests blocked, gtag.js allowed to load and run), local `:8081`:

| Page | Before (0.7.6) | After (0.7.7) |
|---|---|---|
| `/keyboard-tester/` desktop | 99, CLS 0.074 | 100, CLS 0.003 |
| `/` mobile | 97, TBT 170 ms | 95, TBT 210 ms (run-to-run noise) |
| `/keyboard-tester/` mobile | - | 95, TBT 260 ms, CLS 0 |

**Lighthouse TBT does not drop with idle loading, and that is expected.** Lighthouse keeps recording until the CPU has been quiet for 5 s, so gtag.js's ~300 ms of script (3 long tasks, 70-155 ms) still lands inside its TBT window, now just after `load` instead of before it. The real gain is for visitors: gtag.js no longer downloads alongside the page's own files and no longer runs while the page is still loading or during the first input. The audit's goal "mobile TBT < 100 ms, Performance >= 98" can only be met in the lab by loading gtag.js more than ~5 s after load or on first input; the first loses page views from short visits and the second is what Ali ruled out, so neither was done.

## After merge (live)

See "Live checks" below (added after the deploy).

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache) so `TN_VERSION` 0.7.7 loads.
2. Optional, outside the theme: limit login attempts on `/wp-login.php` (Hostinger hPanel security tools, or a small plugin such as Limit Login Attempts Reloaded). Author URLs no longer confirm usernames, and the admin login name is not `admin`, but a limit is still good practice.

## Notes for later

- Audit 2 fix phases are all done (repo phases 25-28).
- If Ali ever wants the Lighthouse number over the field data, the only lever left for GA4 is a longer delay (see above). Field data (Search Console Core Web Vitals) is what counts for Google.
