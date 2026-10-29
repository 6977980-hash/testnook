# Phase 17 handoff: Tier 3, part 4 (system hub)

Date: 29 Oct 2026. Branch `claude/project-thread-ixk9cm`, merged to `main`.
Follows `docs/handoff/phase-16.md`. New 12th hub `system`, 7 new tool pages and
5 new guides: **116 tools, 12 hubs, 35 guides** (13 new URLs, 171 in the
sitemap). `TN_VERSION` 0.7.0.

## Hub and nav

| Hub | URL | Notes |
|---|---|---|
| System | `/system/` | catalog key `system`, nav name "System", title "Internet, Browser & System Tests", new icon `system` (chip) in `inc/icons.php`. Body: internet tests, IP/DNS/VPN, browser/graphics/device, fixing a slow line, privacy. |

- The header has 12 links, so the mobile-nav breakpoint in `assets/css/main.css`
  moved from 1180px to **1240px** (12 links fit from 1181px with Inter, but
  wider system fonts such as Segoe UI need the margin). A 13th hub needs the
  breakpoint raised again or shorter names.
- Moved: `device-info` and `what-is-my-user-agent` now have `hub => system`
  (also `phone`; device-info also `screen`), and sit after the new tools in the
  catalog so the hub grid starts with the new pages. `what-phone-do-i-have`
  stays in `phone` (also `system`); `screen-resolution` is also listed in
  `system`. Breadcrumbs changed; URLs did not.

## The 7 tools

| Page | Ads | Script | What it does |
|---|---|---|---|
| `/internet-speed-test/` | standard | `net` + `internet-speed-test` | 20 pings (first 2 dropped) -> median ping + jitter; download 10 s with 4 streams of 25 MB `__down` chunks (first 2 s skipped); upload 8 s, 3 XHR streams, blob grows 1 -> 32 MB; ping every 0.4 s during each = latency under load and a bufferbloat grade (A+ <5 ms extra ... F >=400). Dial (log scale), "good for" list, 50 GB download time, last 10 results in localStorage `tn-speed-history`. Data saver: 6 s / 5 s and caps 100 MB down / 50 MB up. |
| `/ping-test/` | standard | `net` + `ping-test` | 10/30/60 s, a sample every 250 ms, 1.5 s timeout = lost; nearest Cloudflare (resource timing minus Server-Timing) or Google (`gstatic.com/generate_204`, no-cors wall time). Canvas bar chart (amber spikes, red lost), min/avg/median/max/jitter/p95/spikes/lost, verdicts for gaming, calls, streaming. |
| `/what-is-my-ip/` | standard | `net` + `what-is-my-ip` | IP + colo + country from `speed.cloudflare.com/cdn-cgi/trace`, city/ASN/time zone from `cf-meta-*` headers when Cloudflare sends them (it often does not), IPv4 `api.ipify.org`, IPv6 `api6.ipify.org`, owner and block from RDAP (`rdap.org`, registrant fn). VPN hint: IP time zone != device time zone, or owner matches a hosting/VPN name list. Copy, hide (blur), lookup of any IP via RDAP. |
| `/dns-lookup/` | standard | `net` + `dns-lookup` | DoH JSON at Cloudflare or Google (both CORS), one type or "All common" (8 types in parallel), Compare both (same/different answer), reverse PTR for IPv4/IPv6, status + DNSSEC AD flag + time. DNS server speed: wire-format RFC 8484 GET (`?dns=`) no-cors to 8 resolvers (Cloudflare, Google, Quad9, AdGuard, OpenDNS, NextDNS, Mullvad, Control D), 1 warm-up + 6 popular names each, median. |
| `/what-is-my-browser/` | standard | `device-info` (+ `system.css`) | Reuses device-info.js: hero, full version from `fullVersionList`, up-to-date estimate from release cadence (Chromium 132 = 14 Jan 2025 + 30.3 days per version; Firefox 134 = 7 Jan 2025 + 28 days; Safari = year number from 20 Sep), allowing 2 versions of lag (Safari 1); Firefox ESR 115/128/140/153 recognised; 47 feature checks with a score. |
| `/webgl-test/` | standard | `webgl-test` | WebGL 1/2, GPU name + API parsed from the ANGLE string (Direct3D/Metal/Vulkan/OpenGL), hardware acceleration Off when SwiftShader/llvmpipe/Basic Render, limits table, extensions, WebGPU adapter info. Benchmark: 256-step fragment shader, passes per frame doubled while >40 fps, then 2.5 s measure; score = pixels x steps x passes x fps / 1e7 with rough level bands. |
| `/webrtc-leak-test/` | standard | `net` + `webrtc-leak-test` | ICE gathering via Google and Cloudflare STUN; host/.local/srflx/relay table; public WebRTC IPs compared with the HTTP IPs (Cloudflare + ipify v4/v6, IPv6 compared by /64). Verdicts: leak, no leak, WebRTC off, could not compare. |

Shared code:

- `assets/js/tools/net.js` (`window.TNNet`), documented in `docs/content-format.md`.
- `assets/css/tools/system.css` styles all 7 pages (`sy-*` shared, `st-`, `pg-`, `dn-`, `br-`, `gl-` per page).
- New optional tool key `trust` replaces the "Nothing is uploaded" badge under
  the intro (`templates/tool.php`); the five network pages say "Nothing is sent
  to Testnook", which is accurate (they contact third parties, not us).
- Privacy policy: new section `#network-tools` naming Cloudflare, ipify,
  rdap.org, Google/Cloudflare DNS, the 8 DNS providers and the STUN servers.

## The 5 guides

| Slug | Main tool | Sources |
|---|---|---|
| `what-is-a-good-internet-speed` | internet-speed-test | Netflix (15 Mbps 4K), YouTube (20 Mbps 4K), Zoom bandwidth |
| `what-is-a-good-ping` | ping-test | ITU-T G.114, bufferbloat.net |
| `how-to-reduce-ping` | ping-test | bufferbloat.net |
| `how-to-change-dns-server` | dns-lookup | Cloudflare setup + privacy (logs deleted within 25 h), Google Public DNS, Quad9 addresses |
| `how-to-check-if-vpn-is-working` | what-is-my-ip | RFC 8828 |

About 1,150-1,350 words of body each, 4-point short answer, 6 FAQs, SEO
title 53-59, description 151-160. Every source URL opened; figures checked
against the pages (Netflix 4K is now 15 Mbps, Cloudflare says 25 hours). The
FCC 100/20 Mbps benchmark is mentioned without a link (fcc.gov blocks
automated checks).

## Tested

Local WordPress 7.1 on SQLite (phase-3 recipe), Playwright with real network
access to the third-party services through the sandbox proxy.

- Full audit: all 171 sitemap URLs at 1280 px and iPhone 13: 200, no console
  errors (third-party "Failed to load resource" for the missing IPv6 and the
  WebGPU "No available adapters" warning in headless Chromium excluded), no
  horizontal scroll, valid JSON-LD, every `#` anchor resolves, no "Coming soon";
  all 171 internal links 200. `debug.log` clean. Nav: one row from 1241 px.
- Speed test: ~550 Mbps down / ~500 Mbps up / ping 40-50 ms through the proxy,
  data saver stops at the byte caps, history table, colo IAD. Ping test 10 s:
  36-40 samples, verdicts, Google target and Stop work. IP: v4, "No IPv6", owner
  and block from RDAP, VPN box; RDAP lookup of 8.8.8.8 = Google LLC. DNS: MX for
  gmail.com, Compare both on a pasted URL (CNAME chain, same answer), reverse
  8.8.8.8 = dns.google, resolver speed ranks all 8. Browser: Chrome 153 "up to
  date", 44 of 47 features. WebGL: SwiftShader detected as software rendering,
  name parsed, benchmark score 41 ("very slow"), limits, 29 extensions. WebRTC:
  .local host candidate = no leak; with an injected srflx 203.0.113.77 =
  "Leak found".

Not testable here: real home connections and Wi-Fi, IPv6 users, a VPN, real
GPUs (the benchmark bands are estimates from GPU throughput figures and need
checking on real hardware), Safari/Firefox update messages, real STUN (UDP is
blocked in the sandbox). Screenshots in project files: `phase-17-*.png`.

## Decisions

- Speed and ping use Cloudflare's public speed test endpoints (CORS open,
  nearest edge, no load on Hostinger). If Cloudflare ever closes them, the
  fallback is a small REST endpoint on our own server (would cost Hostinger
  bandwidth), so watch for "Could not reach the test server" reports.
- No server-side IP lookup and nothing stored; everything is browser to
  third party, disclosed in the privacy policy.
- The ISP name comes from RDAP (the registry record), which names the address
  holder, sometimes a parent company rather than the retail brand.
- Browser "latest version" is estimated from the release cadence, not a
  hard-coded list, so it does not go stale; wording says "about".
- The WebGL score is our own unit; the level bands are rough and say so.
- No stats/leaderboards for these pages.

## Ali's steps after this merge

1. After Hostinger deploys, open `https://testnook.com/system/` and try
   `/internet-speed-test/` on Wi-Fi and on mobile data (tick Data saver),
   `/ping-test/` for 30 s, `/what-is-my-ip/` (with and without a VPN if you
   have one), `/webgl-test/` on your laptop and phone (tell the next thread the
   benchmark score and GPU so the level bands can be tuned), and
   `/what-is-my-browser/` on iPhone and laptop.
2. Search Console: resubmit `https://testnook.com/wp-sitemap.xml` (13 new URLs)
   and request indexing for `/internet-speed-test/`, `/what-is-my-ip/`,
   `/ping-test/` and `/system/`.
3. Still open from phase 16: anything that looked wrong on a real phone in the
   sensor pages.

## Remaining roadmap (carry this forward in every handoff)

1. **Fixes from Ali's real-device checks** of phases 16 and 17 (sensor
   directions, WebGL score bands, speed test on a real line).
2. **More guides** (same one-file recipe), not yet written: mouse accuracy /
   aim training, average number memory and sequence memory, hearing frequency
   by age, good refresh rate for phones, how to calibrate a monitor,
   controller deadzone settings, how to test a used monitor, average 10 second
   CPS, does my phone have a gyroscope, phone as a level, how to update your
   browser, why is my upload speed slow, IPv4 vs IPv6, how to turn on hardware
   acceleration.
3. **Possible system tools later:** CPU benchmark (web workers), screen
   recorder, keyboard layout / language info, cookie and storage checker,
   bandwidth calculator (download time), subnet/IP calculator.
4. Optional `typing-test-urdu` / `typing-test-hindi`; the SEO tidy-up of the
   older titles/descriptions listed in phase-12; leaderboard ideas from
   phase-13b only if Ali asks.

Recipe for a tool page: catalog entry, `content/tools/<slug>.php`, script,
CSS, `python3 bin/make-og-images.py` and commit the JPEG, Playwright pass
(desktop + iPhone 13: console, scroll, JSON-LD), merge to `main`, write
`docs/handoff/phase-N.md`. Network pages: load `net` first; Playwright needs
real network access; route-abort `__down?bytes=[1-9]` in bulk audits so the
audit does not download gigabytes. Recipe for a guide: see phase-15.
