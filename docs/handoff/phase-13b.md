# Phase 13b handoff: moat phase, part B (leaderboards)

Date: 29 Oct 2026. Branch `claude/project-thread-tk47s2`, merged to `main`.
Design doc: https://claude.ai/artifact/Q1krAH3pv9TSYnuCR2RXiq (Ali's
choices: names show straight away with filter + moderation; daily, weekly
and all time). Builds on Phase 13a (`docs/handoff/phase-13.md`).

## What was built

Opt-in nicknames on top of the anonymous results. One new page
`/leaderboards/`, no new tools (still 101 tools, 11 hubs). `TN_VERSION` 0.4.0,
`TN_RESULTS_DB_VERSION` 2.

### `inc/leaderboards.php` (new, required from `functions.php`)

- `tn_boards()` entries with `'lb' => true` have a leaderboard: the 7 CPS
  lengths, `reaction`, `typing-60`, `typing-300`, the 6 `aim-*` boards (16
  boards). `typing-15/30/120` and `deadpixel` stay stats-only.
- New column `lb tinyint` on `tn_results` (0 no name, 1 shown, 2 held for
  review, 3 hidden by a moderator) plus index `board_lb_created`; `dbDelta`
  adds them on the first request after deploy. The `nick` column from 13a is
  now used.
- `POST /result` on an `lb` board now also returns `id` and `claim` (HMAC of
  `claim|id|board` with the ticket secret). Suspect results get no claim.
- `POST /claim {id, claim, nick}`: checks the claim signature (403
  `bad_claim`), that the board has a leaderboard and the result passed the
  checks, that the row has no name yet (`already_claimed`) and is from today
  or yesterday (`expired`), then the nickname, then the daily limit (10 claims
  per client per day, `daily_limit`). Refusals other than a forged claim are
  200 `{ok:false, code}` so the console stays clean. Answers `{ok, held,
  nick, ranks:{day, week, all}}`.
- Nickname rules (`tn_lb_check_nick`): 3-16 chars, `A-Z a-z 0-9 space - _`
  with at least two letters/digits, no `http`, `www` or `.com`-style
  domains, not on the blocked-names list, and a bad-word check. The check
  lower-cases, maps leetspeak (0/o, 1/i, 3/e, 4/a, 5/s, 7/t, 8/b, @, $, !),
  strips separators and collapses repeated letters, so `sh1t_head` and
  `fuuuck` are caught. Two lists: substrings (English and Roman Urdu/Hindi
  profanity, slurs) and whole words (`ass`, `sex`, `admin`, `mod`,
  `testnook`...), so `Classy Grape` passes. Extra words come from the option
  `tn_lb_words`, edited on the admin screen.
- Auto-hold (`tn_lb_needs_review`): a claim is stored as held (lb = 2) when
  the score would enter the all-time top 3 of a board that already has 3
  names, or beats the 99th percentile (p99 / p1) of the cached stats. Held
  entries are invisible until approved.
- `GET /board?board=&period=day|week|all` -> `{rows:[{rank, nick, value,
  extra, date}]}`, top 10, best entry per name (case-insensitive), order:
  value (direction per board), then accuracy, then the earlier row. Cached
  10 min in `tn_lb_<board>_<period>[_mmdd]` transients, flushed on every
  claim and moderation action. Cache-Control 60 s. "Today" is UTC; "This
  week" is the last 7 days including today.
- Prune: named, shown entries (lb = 1) are kept past 400 days so the
  all-time boards survive; everything else is folded and deleted as before.
- `tn_leaderboard_claim()` prints the "Add my score to the leaderboard"
  button + nickname form inside the tool section; `tn_leaderboard_section()`
  prints the top 10 widget under the tool (board select across the same test
  family, Today / This week / All time tabs; the all-time table is in the
  HTML from the cache). `tn_leaderboards_hub()` prints the four widgets on
  `/leaderboards/` (CPS, reaction, typing, mouse accuracy).
- wp-admin **Tools > Testnook leaderboards** (badge with the held count):
  "Waiting for review" list with Approve; newest named entries with filters
  (top 50 of one board, name search); per entry Show / Hide / "Hide all from
  this name" (hides every entry with that name and blocks the name, option
  `tn_lb_blocked_names`) / "Remove name" (for removal requests: the name is
  deleted, the anonymous score stays); Unblock; the extra blocked-words box.

### Front end

- `assets/js/leaderboard.js` (enqueued on tool pages with an `lb` board and on
  `/leaderboards/`, never in embed mode): widget tabs and board select fetch
  `/board` and cache per page load; the claim form listens for `tn:result`
  (fired by `stats.js` with the server answer + board) and `tn:begin` (hides
  the form when a new run starts). After a claim the message reads "Added as
  Nick: 2nd today, 4th this week, 6th of all time", the widget switches to
  the first period where the entry is in the top 10 and highlights the row.
  Held: "Great score! It is held for a quick check...". The last nickname is
  remembered in `localStorage` `tn-nick`. Turning score sharing off hides
  everything, since no result is sent.
- `templates/tool.php`: claim form after the share line, leaderboard section
  after the share note (all leaderboard pages use `ads => content`, so no ad
  sits next to the form or table). `templates/static.php`: optional
  `'render'` key (a callable printed after the body) used by
  `/leaderboards/`.
- `content/pages/leaderboards.php`: intro, "How the boards work" (periods,
  one spot per name, same checks as the stats, nicknames public, 10 per
  day), "What counts" per test, removal by email, then the boards. Footer
  link "Leaderboards". Privacy policy: new section "Leaderboards and
  nicknames" (`#leaderboards`).
- CSS: `.lb*` and `.lb-claim*` in `main.css`; the date column hides under
  520 px.
- `docs/content-format.md`: "Leaderboards" section and the `render` key.

## Tested

Local WordPress 7.1 on SQLite (Phase 3 recipe). Seeded 300 results per board
with 25 named entries each, one held and one hidden entry.

- curl: result -> `id` + `claim`; forged claim 403; `ab` -> `nick_length`;
  `ali<b>` -> `nick_chars`; `sh1t_head`, `chutiya99`, `Admin` ->
  `nick_blocked`; `Classy Grape` -> ok with ranks; second claim ->
  `already_claimed`; suspect CPS result -> no claim; 12.2 CPS on 5 s (top 1)
  -> `held: true`; 11th claim of the day -> `daily_limit`; unknown period
  400; dead pixel result has no claim.
- Playwright, 14 pages (`/leaderboards/`, the 11 leaderboard tool pages, dead
  pixel, privacy, one embed URL) at 1280 px and iPhone 13: all 200, no
  console errors or page errors, no horizontal scroll, valid JSON-LD,
  widgets and `leaderboard.js` only where expected, nothing in embed mode.
- Interaction on 1 s CPS: 9 clicks -> share line, Add my score -> `sh1t head`
  refused with the message, `Play Tester` -> "2nd today, 4th this week, 6th
  of all time", row highlighted on the Today tab, All time + board select to
  5 s reloads the table, nickname remembered, sharing off -> no claim box.
  `/leaderboards/`: tabs and board select work (Today shows the empty-state
  text when a board has no entry today).
- Admin: badge "2", Approve moves the entry to Shown, "Hide all from this
  name" removes Top Dog from `/board` and blocks the name, Unblock, Save
  words. `debug.log` never created (no PHP notices). `tn_results_prune()`
  runs without SQL errors with the new `lb <> 1` condition.
- Upgrade path: `tn_results_db_version` set back to 1 -> next request runs
  `dbDelta` to version 2 without errors (on SQLite the column already
  existed; on MySQL `dbDelta` issues `ALTER TABLE ADD COLUMN lb` and the
  key, which is its standard behaviour).

Not tested here: MySQL on Hostinger (plain `dbDelta`, prepared statements,
`LOWER()`, `COUNT(DISTINCT)`; nothing MySQL-specific), LiteSpeed cache on
`/wp-json/testnook/v1/board` (60 s Cache-Control is intended; a stale table
for a minute is fine). Screenshots: `phase-13b-*.png` in project files.

## Decisions

- Claims are tied to the result row (id + HMAC) rather than a second ticket,
  so the score can never be changed when the name is added, and a claim
  cannot be replayed for another row.
- Held = all-time top 3 (design doc) **or** beyond p99 of the stats: a board
  with under 3 names would otherwise show a 25 CPS bot on day one.
- One spot per name is enforced at read time (best entry per lower-cased
  name), so a player can improve their score without the old row blocking.
- Removal requests: "Remove name" keeps the anonymous score, matching the
  privacy policy ("the score then stays as an anonymous result only").
- "This week" = rolling 7 days, not calendar week, so the tab is never empty
  on a Monday morning.
- Typing boards are 60 s and 300 s only (design doc); 15/30/120 s pages still
  send stats and show the 1-minute and 5-minute boards in the widget, with
  the claim form appearing only after a 60 s or 300 s run.

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/1-second-cps-test/`,
   do a run, press **Add my score to the leaderboard** and add a nickname.
   It should appear in the table under the tool straight away.
2. Open `https://testnook.com/wp-admin/tools.php?page=tn-leaderboards`.
   Check the held list now and then (the badge on the Tools menu shows the
   count); approve real-looking records, hide the rest.
3. Search Console: resubmit `https://testnook.com/wp-sitemap.xml` (new
   `/leaderboards/` page).

## Remaining roadmap (carry this forward in every handoff)

1. **Phase 14+: Tier 3** as listed in `docs/handoff/phase-12.md`: 3-5
   troubleshooting guides per tool (quote the site stats: "median CPS on
   Testnook is X"; link the leaderboards), phone sensor pages, internet and
   browser info tools (a `system` hub), optional Urdu/Hindi typing tests,
   SEO tidy-up of older titles/descriptions.
2. Later leaderboard ideas, only if Ali asks: country flags (would need the
   IP country at claim time, a privacy policy change), monthly boards, a
   "beat the median" badge on share images.

Recipe for tool pages unchanged (see phase-12). For a new board with a
leaderboard: entry in `tn_boards()` with `'lb' => true`, `TNStats.begin/submit`
in the tool script, `'stats'` in the content file; the claim form, widget
and `/leaderboards/` group (add the family to `tn_leaderboards_hub()`) follow.
Local test setup: as in `docs/handoff/phase-3.md`; the seed script in this
phase inserted rows with `nick` + `lb = 1` and called `tn_lb_flush()`.
