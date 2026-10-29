# Phase 24 handoff: share your score

Date: 29 Oct 2026. Asked for by Ali (light version: plain share links, no SDKs;
the dynamic score OG image stays out of scope). `TN_VERSION` **0.7.3 -> 0.7.4**.

## What changed

| Area | File(s) | Change |
|---|---|---|
| Share box | `templates/tool.php`, `assets/css/main.css` | New "Share your score" box inside the tool section, under the percentile line and above the leaderboard claim: the share sentence, then **Share** (native sheet, only where `navigator.share` exists), **Copy**, **WhatsApp**, **X**, **Facebook**, **Reddit**. Rendered when the tool has `stats` or `share => true`, never with `?embed=1`. Replaces the phase 21 "Copy result" box (`.copy-result` is gone). Links carry visually hidden "Share on ..." / "(opens in a new tab)" text. |
| Script | new `assets/js/share.js`, `inc/assets.php` | `TNShare.show(claim, board)`, `TNShare.hide()`, `TNShare.percentile(board, pct, word)`. Enqueued on the same pages as the box. Sentence: `<claim>[, better/faster than N% of recent scores]. Can you beat me?` + page URL. Intent URLs: `wa.me/?text=`, `twitter.com/intent/tweet?text=&url=`, `facebook.com/sharer/sharer.php?u=`, `reddit.com/submit?url=&title=`. Shared links get `utm_source=<whatsapp/x/facebook/reddit/share_sheet>&utm_medium=social&utm_campaign=score_share`; Copy uses the clean URL. GA4: `gtag('event', 'share', {method, content_type: 'score', item_id: board or slug})` only when `window.gtag` exists. |
| Stats tools | `assets/js/stats.js` | `TNStats.begin` hides the box, `submit` shows it (claims for `cps-*`, `reaction`, `typing-*`, `aim-*`), and the server's percentile is added when it arrives ("faster" for reaction). Shown even when the visitor turned score sharing off. `deadpixel` gets no share line (it is a report, not a skill score). Typing still needs 85% accuracy, as before. |
| Other skill tools | `content/tools/*.php` (`'share' => true`), their scripts | Own score, no percentile: F1 reaction (average), Stroop (effect, only at 80%+ accuracy), chimp, number memory, sequence memory, verbal memory, visual memory, memory game (pairs, moves, time), spacebar clicker (timed modes), right click CPS and jitter click (via `cps-test.js`; auto-clicker mode is excluded). Each hides the box when a new run starts. |
| Registry | `inc/registry.php` | New tool key `share` (default `false`). |
| Privacy | `content/pages/privacy-policy.php` | Analytics section: a share records only that it happened, the button and the test, never the score; share buttons are plain links with no third-party code. |

Tools with the share box (26): cps-test, 1/5/10/15/30/60/100 second click tests,
right-click-cps-test, jitter-click-test, spacebar-clicker, reaction-time-test,
f1-reaction-test, typing-speed-test, 1-minute and 5-minute typing tests,
wpm-test, typing-test-english, mouse-accuracy-test, stroop-test, chimp-test,
number/sequence/verbal/visual memory tests, memory-game. Dead pixel test has
the script loaded (stats page) but never shows the box.

## Tested

Local WordPress (SQLite, phase-3 recipe), `WP_ENVIRONMENT_TYPE=local`:

- `bin/check.sh http://127.0.0.1:8080`: lint OK, 179/179 pages pass.
- Playwright: 1 s CPS with a mocked percentile -> "I scored 9.0 CPS on the Testnook 1 second click test, better than 78% of recent scores. Can you beat me? <url>"; all four intent URLs correct; clicking X opens the x.com intent popup and fires `share` / `method: x` / `item_id: cps-1`; a new run hides the box.
- `?embed=1`: no box, no `TNShare`.
- Chimp (3 strikes), number memory (iPhone 13 with a stubbed `navigator.share`: Share button shows and passes text + `utm_source=share_sheet` URL, no horizontal overflow), spacebar 5 s, right click CPS 1 s (dark mode screenshot): correct sentences, 0 page errors.

## Ali's steps after this merge

1. Purge the cache (hPanel -> Website -> Cache).
2. Finish a CPS test on your phone and press Share to try WhatsApp.
3. In GA4, shares show as the `share` event (Reports -> Engagement -> Events), and visits from shares under the `score_share` campaign.

## Notes for later phases

- New skill tool? Add `'share' => true` and call `if (window.TNShare) { TNShare.show('I scored ... on the Testnook ...'); }` at the end of a run and `TNShare.hide()` at the start. Stats tools get it automatically through `stats.js`.
- Still not built on purpose: the dynamic score OG image (needs a score URL parameter, a GD endpoint and an `og:image` filter).
