# Phase 23 handoff: typing test blur fix and GA4

Date: 29 Oct 2026. Small fix phase asked for by Ali. `TN_VERSION` **0.7.2 -> 0.7.3**.

## What changed

| Area | File(s) | Change |
|---|---|---|
| Typing test blur | `assets/css/main.css` | New base rule `[hidden] { display: none !important; }`. The typing overlay (`.tt-overlay`, `display: grid`) ignored its `hidden` attribute, so the blurred "Click here or press any key" layer stayed over the words while the test ran. Bug since phase 9 (not a phase 4 regression); it hit all five typing pages (`typing-speed-test`, `1-minute-typing-test`, `5-minute-typing-test`, `wpm-test`, `typing-test-english`, one shared script). |
| Same rule, other tools | (same) | A sweep of all 179 live pages found 20 more elements with `hidden` that still showed because a class set `display`: memory-test boards before Start, the empty `#tt-result` box, camera flip/torch buttons, GPS copy/map buttons, ping verdicts, dead-pixel grid, ruler measure, touch-screen grid sizes, mirror Save, bubble-level Clear, light/proximity sensor buttons, what-is-my-ip lookup list, and the embed preview iframe. Every one is toggled by its script on purpose, so they now appear only when meant to. Memory tests checked: board hidden before Start, shown after. |
| Typing test start | `assets/js/tools/typing-test.js` | "Press any key" now works: a printable key anywhere on the page (not inside another field, button or link, no Ctrl/Alt/Meta, not Space) focuses the test and the key lands in it. `begin()` also hides the overlay. |
| GA4 | new `inc/analytics.php`, `inc/config.php`, `functions.php` | `TN_GA4_ID = 'G-RS6YGDD3HR'`. `wp_head` priority 2 prints the async gtag.js tag plus Consent Mode v2 defaults: `ad_storage`, `ad_user_data`, `ad_personalization`, `analytics_storage` **denied** for EEA + UK + CH (`wait_for_update: 500`), **granted** everywhere else; `ads_data_redaction` on. Skipped when `wp_get_environment_type()` is not `production`, on `?embed=1` tool iframes, and for logged-in admins (`manage_options`). |
| Old loader | `assets/js/site.js`, `inc/assets.php` | Removed the on-`load` GA4 loader in site.js and `ga4` from `window.TN` (it would have loaded gtag twice). Clarity loader unchanged (`TN_CLARITY_ID` still empty). |
| Privacy policy | `content/pages/privacy-policy.php` | Analytics section rewritten (`#analytics`): GA4 is on, what it collects, `_ga` cookies, IP not stored by Google, nothing from inside tests, retention 2-14 months per the GA setting, cookieless consent mode in EEA/UK/CH, not loaded in embeds, opt-out add-on link, no Clarity. Cookies section, rights section, meta description and the consent-message sentence updated to match. |
| Docs | `README.md` | Layout + setup step mention `inc/analytics.php`. |

## Tested

- `bin/check.sh` lint clean; local WordPress 7.1 (SQLite, phase-3 recipe) gate
  `bin/check.sh http://127.0.0.1:8080`: 179/179 pass.
- `WP_ENVIRONMENT_TYPE=local`: no gtag in the page. `production`: gtag + consent
  defaults in `<head>`; `?embed=1`: no gtag; privacy page shows the new text.
- Playwright on all 5 typing pages (1280 px): overlay `grid` before focus,
  `none` on click/focus and while typing, back on blur, `none` again on click;
  12 characters counted after typing "hello world "; 0 page errors; GA4
  `g/collect` request fires. Pressing keys with nothing focused starts the test
  and types into it. iPhone 13: overlay hidden (touch uses the visible input).

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache).
2. GA4 -> Admin -> Data collection and modification -> Data retention: set
   14 months (default is 2; the policy says 2-14).
3. Check GA4 Realtime in an incognito window (logged-in admins are not tracked).
4. Before turning on AdSense, publish the AdSense / Funding Choices consent
   message for EEA/UK/CH: it updates the consent mode defaults set here.

## Notes for later phases

- Use the `hidden` attribute freely now; the base rule beats any component
  `display`. Do not add `display` rules that rely on `[hidden]` still showing.
- Track custom events with `window.gtag` only when it exists (`if (window.gtag)`),
  since dev, embeds and admins have no tag.
- Adding Clarity: set `TN_CLARITY_ID`, and update the privacy policy's Analytics
  section (it now says no Clarity).
