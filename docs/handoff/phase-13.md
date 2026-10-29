# Phase 13 handoff: moat phase, part A (anonymous stats + embeds)

Date: 29 Oct 2026. Branch `claude/project-thread-83c01y`, merged to `main`.
Design doc (approved by Ali, all five recommendations):
https://claude.ai/artifact/Q1krAH3pv9TSYnuCR2RXiq. Part B (leaderboards with
nicknames, moderation screen, `/leaderboards/` hub) is the next phase.

## What was built

The first server-side code in the theme. No new tool pages; 101 tools,
11 hubs, plus one static page `/embed-tools/`.

### `inc/results.php` (new, required from `functions.php`; `TN_VERSION` 0.3.0)

- Two tables via `dbDelta` on `init` when `TN_RESULTS_DB_VERSION` changes:
  `{prefix}tn_results` (id, board, value decimal(10,2), extra smallint, nick
  varchar(16) null (for 13b), status ok|suspect, created DATE) and
  `{prefix}tn_embed_hits` (domain, slug, day, hits). No IP, no time of day,
  no UA, no text.
- `tn_boards()`: the 21 boards with min test length, plausibility limits,
  unit and whether higher is better: `cps-1/5/10/15/30/60/100` (0.5-20 CPS,
  25 for 1 s), `reaction` (120-1500 ms, average of 5, lower is better),
  `typing-15/30/60/120/300` (5-220 WPM, extra = accuracy 85-100),
  `aim-static|shrink-16|28|40` (1-8000 points, extra = accuracy),
  `deadpixel` (value = 10 x 10 grid cell, extra 0 none / 1 dead / 2 stuck;
  stats are a heat map).
- REST under `/wp-json/testnook/v1/` (all `permission_callback`
  `__return_true`, fetched with `credentials: 'omit'`):
  - `POST start {board}` -> `{ticket}`: HMAC-signed (`wp_salt('nonce')`)
    payload `board|issued|random`.
  - `POST result {board, ticket, value, extra, cv}` -> `{ok, status, count,
    percentile}`. Refuses: unknown board 400; bad/stale (2 h)/wrong-board/
    reused ticket 403; result earlier than the board's `min_s` (minus 1 s
    for whole-second rounding) 403 `too_fast`; over 60 results per client
    per hour 429. Out-of-range scores answer 200 `{ok:false,
    code:'implausible'}` (so the browser console stays clean). CPS results
    with `cv` (spread of click gaps, %) under 3 and 20+ clicks are stored as
    `suspect` and never counted.
  - `GET stats?board=` -> the cached stats (Cache-Control 10 min).
  - `POST embed {slug, ref}`: counts one load per embedding domain (host of
    the referrer, `www.` stripped, our own host ignored, else `unknown`).
- Client key for rate limits: `sha256(ip | auth salt | date)` truncated,
  counters in transients for one hour. Used tickets are remembered in
  transients for two hours.
- Stats per board (`tn_stats_compute`): last 30 days of `ok` rows (up to
  50,000): count, all-time total, mean after trimming 1% each end, median,
  top-10% line, p1/p99, 101 quantiles (percentile answers) and a 12-bin
  histogram. Dead pixel: counts per cell and per type. Cached in
  `tn_stats_<board>` transients (2 h), refreshed by the hourly WP-cron event
  `tn_results_refresh`; computed on the spot on a cache miss. Boards under
  20 results print nothing.
- `tn_results_prune` (daily cron): rows older than 400 days are folded into
  the `tn_results_archive` option (count + mean per board and month) and
  deleted; old embed-hit rows deleted.
- `tn_stats_block( $boards )`: the "How other people score on Testnook"
  section (median, average, top 10%, tests in 30 days, histogram; the pixel
  map for dead pixel with the share of screens with a bad pixel and the
  share of reports on the outer edge). Printed in the HTML from the cache,
  between the results section and the in-content ad slot.
- wp-admin: **Tools > Testnook stats**: results per board (ok / suspect /
  median / all time), sites embedding tools (domain, loads, tools, last
  seen) and a "Refresh stats now" button.

### Front end

- `assets/js/stats.js` (enqueued only on tool pages with a `stats` list, never
  in embed mode): `TNStats.begin(board)` fetches a ticket when a test
  starts, `TNStats.submit(board, value, extra, cv)` posts the score when it
  ends and writes the `[data-tn-share-line]` under the tool: "Better/Faster
  than 64% of 18,240 tests on Testnook in the last 30 days", or "Shared
  anonymously, averages appear once enough people have taken this test", or
  the suspect / out-of-range notes. `localStorage` `tn-share-off` = `1`
  disables everything; the `[data-tn-share-note]` line under the tool has
  the Turn off / Turn on links and a link to `/privacy-policy/#results`.
- Hooks added: `cps-test.js` (left-click mode only, lengths 1-100, not when
  "count right clicks" is on; sends the click-gap CV), `reaction-time-test.js`
  (5-try mode only), `typing-test.js` (any length; only when accuracy >= 85),
  `mouse-accuracy-test.js` (per mode and size), `dead-pixel-test.js` (new
  report panel after the full-screen test closes: No bad pixels / Dead /
  Stuck, a 10 x 10 grid, Send or Skip; shown once per page load).
- `templates/tool.php`: the trust line reads "Only your score is shared,
  anonymously" on stats pages; share line + share note; `tn_stats_block`;
  the embed box now has width (full/800/600/400), height, theme
  (visitor's choice/light/dark) controls, a live preview iframe (loads when
  the box opens) and a link to `/embed-tools/`. Code generation lives in
  `tn_embed_code()` (`inc/helpers.php`) and in `site.js` for the live box.
- `?theme=light|dark` on any page (meant for embeds) wins over the saved
  theme (head script in `inc/assets.php`). `window.TN` now carries `rest`
  (REST base) and `slug`. In embed mode `site.js` posts one embed hit.
- `content/pages/embed-tools.php`: all 101 tools by hub, each a `<details>`
  with its code and a copy button, plus how-to and embed terms. The slug is
  `embed-tools` because WordPress reserves `embed` (oEmbed endpoint and
  `wp_unique_post_slug` rename it to `embed-2`). Footer link "Embed our
  tools"; terms page links it.
- 16 content files got `'stats' => array( ... )`: the 8 CPS pages, reaction,
  the 5 typing pages (`typing-speed-test` shows 60 + 30, `wpm-test` 60 + 15,
  `5-minute` 300), mouse accuracy (static + shrink 28) and dead pixel.
- Privacy policy: new section "Anonymous test results and site statistics"
  (`#results`), the opening line, local storage and your-rights paragraphs
  updated. `wp_kses` allow-list now includes `textarea`.
- `docs/content-format.md`: `stats` key and a short "Anonymous results"
  section.

## Tested

Local WordPress 7.1 on SQLite (Phase 3 recipe, `WP_ENVIRONMENT_TYPE` local).
Seeded 300 fake results per board, then Playwright:

- All 16 stats pages, `/embed-tools/`, privacy, terms and two embed-mode
  URLs at 1280 px and iPhone 13: 200, no console errors or page errors, no
  horizontal scroll, valid JSON-LD, 6 FAQs / 8 related cards, stats block,
  share note and `stats.js` present where expected, `?theme=dark` applied in
  embed mode, 101 code boxes on the embed page.
- Interactions: 1 s CPS -> "Better than 93% of 300 tests"; Turn off -> no
  requests and no line, Turn on restores; 5 s CPS with machine-regular
  clicks -> suspect note; reaction 5 tries -> "Faster than 74%"; 15 s typing
  and mouse accuracy by a bot -> out-of-range note (390 WPM, 8232 points);
  dead pixel report (Dead, cell 34) -> thanks message; embed box: width 600,
  dark theme, height 500 rewrite the code and the preview loads.
- API by curl: unknown board 400; missing/forged ticket, wrong board, same
  second, reused ticket -> 403 with the reason; out of range -> 200
  `ok:false`; valid -> percentile 87; cv 1% -> `suspect`; embed hit with a
  referrer -> row for `example.org`; 62nd result in an hour -> 429.
- Admin page renders counts and domains. `debug.log` clean.

Not tested here: MySQL on Hostinger (SQLite locally; the SQL is plain
`dbDelta` + prepared statements, nothing MySQL-specific), WP-cron timing on
Hostinger, LiteSpeed cache behaviour for `/wp-json/` (REST is normally not
cached; if the stats block looks stale, that is page cache, refreshed within
hours). Screenshots: `phase-13-*.png` in project files.

## Decisions

- Sharing is on by default with a visible off switch (Ali's choice 2).
- Scores only, no personal data, so no consent banner change; the privacy
  policy explains the one-hour hashed IP counter.
- Tickets instead of WP nonces (nonces break on cached pages and for
  logged-out visitors after 12-24 h).
- Stats use the median first and trim 1% each end; percentiles come from
  cached quantiles, so a result costs one INSERT and no aggregate query.
- `/embed/` is impossible as a page slug in WordPress; `/embed-tools/` it is.
- Mouse accuracy cap 8000: a bot scores about 8200, strong humans about
  3000-5000.
- The admin page is read-only; moderation (hide a name, hide all from a
  name) comes with 13b when nicknames exist.

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/1-second-cps-test/`,
   do a run, and check the line under the tool reads "Shared anonymously..."
   (the stats block appears on each page once 20 real results exist for it).
2. Open `https://testnook.com/wp-admin/tools.php?page=tn-stats` to watch
   results arrive. If tables are missing, visit any page once more (they are
   created on the first request after deploy).
3. Search Console: resubmit `https://testnook.com/wp-sitemap.xml` (new
   `/embed-tools/` page). IndexNow pings on the first production request.
4. Optional: paste the embed code for one tool into another site you own and
   check the domain appears under "Sites embedding our tools".

## Remaining roadmap (carry this forward in every handoff)

1. **Phase 13b (next): leaderboards.** Per the design doc: opt-in nickname
   (3-16 chars, letters/digits/space/dash/underscore, no links, bad-word
   list, one spot per name per board), daily / weekly / all-time views on
   one URL, top 10 under the tool on the CPS, typing (60 s and 300 s),
   reaction and mouse accuracy pages, a `/leaderboards/` hub page with the
   rules, admin moderation (hide entry, hide all from a name, auto-hold
   top-3 entries), 10 entries per client per day. The `nick` column exists
   already; add `POST /wp-json/testnook/v1/claim {id or ticket, nick}` (the
   `result` endpoint should return the row id for this) and `GET /board`.
   Names show straight away with filter + moderation (Ali's choice 3).
2. **Phase 14+: Tier 3** as listed in `docs/handoff/phase-12.md`: 3-5
   troubleshooting guides per tool (quote the site stats: "median CPS on
   Testnook is X"), phone sensor pages, internet and browser info tools (a
   `system` hub), optional Urdu/Hindi typing tests, SEO tidy-up of older
   titles/descriptions.

Recipe for tool pages unchanged (see phase-12). For a new board: entry in
`tn_boards()`, `TNStats.begin/submit` in the tool script, `'stats'` in the
content file. Local test setup: as in `docs/handoff/phase-3.md`; a seed
script that inserts 300 rows per board and calls `tn_stats_refresh_all()`
makes the stats blocks appear.
