# Phase 16 handoff: Tier 3, part 3 (phone sensors)

Date: 29 Oct 2026. Branch `claude/project-thread-l4pwq3`, merged to `main`.
Follows `docs/handoff/phase-15.md`. 8 new tool pages in the `phone` hub and 6
new guides: **109 tools, 11 hubs, 30 guides** (14 new URLs). `TN_VERSION`
0.6.0. No new hub, so the nav is unchanged.

## The 8 tools

| Page | Ads | Device | Script | What it does |
|---|---|---|---|---|
| `/phone-sensor-test/` | standard | touch | `phone-sensor-test` | One tap: 12 rows (accelerometer, gyroscope, orientation, compass, location, light, proximity, raw magnetometer, vibration, battery, touch, screen rotation), live value per row, "N of 12" score, each name links to its full test. Location only on its own button. |
| `/gyroscope-test/` | content | touch | `gyroscope-test` | CSS 3D phone following alpha/beta/gamma, rotation rate X/Y/Z graph, peak, sample rate, "Gyroscope: Yes/No" (No = motion events without `rotationRate`, i.e. budget phone), 10 s drift check (bias + noise), full-turn check (integrates Z rate, compares with 360). |
| `/accelerometer-test/` | content | touch | `accelerometer-test` | X/Y/Z with gravity or movement only (seg toggle), total g, peak, shake counter, "Sensor says" pose vs "Screen is" (auto-rotate hint box when they disagree), 5 s gravity check vs 9.81. |
| `/compass-test/` | content | touch | `compass-test` | Rose (SVG built in JS), heading + 16-point direction, source (iPhone `webkitCompassHeading` or Android `deviceorientationabsolute`), iPhone accuracy, 3 s steadiness (circular SD), flat warning, target bearing arrow, raw `Magnetometer` uT where exposed, figure-8 tip when iPhone accuracy is bad. Corrected for screen rotation. |
| `/gps-test/` | standard | any | `gps-test` | `watchPosition` high accuracy: coordinates (blur toggle, copy, Google Maps link), accuracy + rating, best, time to first fix, source guess (satellite = <=30 m with altitude), altitude, speed, heading, update interval, 50%/95% wander radius and a scatter plot in metres. Nothing sent. |
| `/bubble-level/` | content | touch | `bubble-level` | Round level when flat (beta/gamma), bar level on an edge (gravity angle), screen-rotation aware, Set zero (localStorage `tn-level-cal`), Hold, short buzz on level (Android). |
| `/light-sensor-test/` | standard | touch | `light-sensor-test` | `AmbientLightSensor` lux if exposed (almost never), camera light meter (front camera mean luma; compensated "light index" when the track reports exposureTime + ISO, else relative), 3-step auto-brightness pass/fail with verdict. |
| `/proximity-sensor-test/` | standard | touch | `proximity-sensor-test` | `ProximitySensor` / old `deviceproximity` if present, guided call test (3 pass/fail steps + verdict), hidden test codes table (Samsung `*#0*#`, Xiaomi `*#*#6484#*#*`). |

Shared code:

- `assets/js/tools/sensors.js` (`window.TNSensor`) is loaded before each sensor
  script: `request()` for the motion permission (iOS 13+, and recent Chromium
  also has `requestPermission`, so it is called there too; both prompts start
  in the same tap), `message(state)`, `Rate`, `Graph` (rolling canvas chart),
  `gravity` + `learnFlip` (iPhone's inverted `accelerationIncludingGravity` sign
  is detected by comparing with the orientation angles, UA as first guess),
  `screenAngle`, `cardinal`, `stats`, `circStats`, `angleDiff`, `steps`.
  Documented in `docs/content-format.md`.
- `assets/css/tools/sensors.css` styles all 8 pages.
- Embed iframe `allow` now includes `accelerometer; gyroscope; magnetometer;
  geolocation` (`inc/helpers.php` and the embed box in `site.js`).
- Phone hub: new "Phone sensor tests" section, new SEO title/description, sensor
  line in "What the tests can find", sensor test in the used-phone order, FAQ
  updated. `related` now lists the sensor test on device-info, vibration-test
  and what-phone-do-i-have.

## The 6 guides

| Slug | Main tool | Sources |
|---|---|---|
| `gyroscope-vs-accelerometer` | gyroscope-test | |
| `auto-rotate-not-working` | accelerometer-test | |
| `how-to-calibrate-phone-compass` | compass-test | Google Maps Help |
| `how-to-improve-gps-accuracy` | gps-test | GPS.gov (4.9 m figure), Apple Location Services |
| `proximity-sensor-not-working` | proximity-sensor-test | |
| `auto-brightness-not-working` | light-sensor-test | Apple brightness article |

Each 1,400-1,500 words on the page, 4-point short answer, 6 FAQs, SEO title
52-58, description 151-157. Every source URL opened and checked (two wrong
Apple URLs were replaced or dropped). No live data blocks (no boards for
sensors).

## Tested

Local WordPress 7.1 on SQLite (Phase 3 recipe, `WP_ENVIRONMENT_TYPE` local).

- Full audit, all 158 sitemap URLs at 1280 px and iPhone 13: 200, no console
  errors/warnings, no page errors, no horizontal scroll, valid JSON-LD, every
  `#` anchor resolves, no "Coming soon"; all 157 internal links 200.
  New tool pages: title 51-59, description 156-160, 6 FAQs, 8 related cards.
  `/guides/` lists 30. `debug.log` clean.
- Interactions with synthetic `deviceorientation`, `deviceorientationabsolute`
  and `devicemotion` events at 60 Hz (iPhone 13 emulation, sensor permissions
  granted): gyroscope Yes, angles, 62 Hz, drift check "Steady", full turn
  90 deg/s x 4 s = 360 deg; no-gyro phone says "accelerometer but no
  gyroscope". Accelerometer with iPhone-inverted signs: flat reads
  0 / 0 / 9.81, 1.00 g (flip learnt), upright = Portrait, landscape shows the
  auto-rotate hint, 4 shakes counted, gravity check exact. Compass: alpha 270
  = 90 E, target 120 = "Turn right 30", iPhone heading 200 with accuracy -1 =
  "Not calibrated" + tip. Level: bubble moves to the high side, Set zero gives
  0.0/0.0 and green ring, edge mode switches and names the low side. GPS with
  moving mocked fixes: +-4 m Excellent, 5 fixes, 50%/95% radius, plot, blur.
  Light: camera meter with fake camera, verdict text. Proximity: verdict.
  Sensor test: 8 of 12.

Not testable here: real sensors, the real iOS permission prompt, true north
offsets, real GPS satellites, real lux/exposure readings. Screenshots in
project files: `phase-16-*.png`.

## Decisions

- 8 tools instead of the 6 in the plan: the all-in-one sensor test and the
  bubble level reuse the same code and target big keywords.
- Light and proximity: browsers do not expose these sensors (the APIs are
  feature-detected, never assumed), so the pages say so plainly and test from
  the outside (camera meter, auto-brightness and call checklists).
- Compass shows magnetic north and says so; it assumes a flat phone and warns
  above 25 deg tilt.
- GPS source is a labelled guess. Coordinates never leave the browser; the
  Maps button is a plain link.
- Motion tools use `ads => content` (no slot under the tool, since people hold
  and tap the phone there); GPS, light, proximity and sensor test `standard`.
- No anonymous stats or leaderboards for sensor pages (nothing worth ranking).

## Ali's steps after this merge

1. After Hostinger deploys, open on your phone: `https://testnook.com/phone-sensor-test/`,
   then `/gyroscope-test/`, `/compass-test/` (outdoors, check N against a map),
   `/gps-test/` outdoors and `/bubble-level/` on a table. On iPhone tap Allow
   when Safari asks for motion access. Tell the next thread anything that
   looks wrong on a real phone (direction of the 3D phone, bubble side,
   compass heading).
2. Search Console: resubmit `https://testnook.com/wp-sitemap.xml` (14 new URLs)
   and request indexing for `/phone-sensor-test/`, `/gyroscope-test/` and
   `/auto-rotate-not-working/`.

## Remaining roadmap (carry this forward in every handoff)

1. **Phase 17: system hub** (`system`): internet speed and ping, browser
   info, IP and DNS, WebGL/GPU info, then move device-info, user agent,
   what-phone and the screen info pages there by changing their `hub` key.
   A 12th hub needs the nav breakpoint raised or the hub names shortened
   (see phase-12). The phone sensor pages stay in `phone`.
2. **Fixes from Ali's real-phone check of phase 16**, if any (small, can ride
   along with phase 17).
3. **More guides later** (same one-file recipe), ideas not yet written:
   mouse accuracy / aim training (aim boards), average number memory and
   sequence memory, hearing frequency by age, what is a good refresh rate
   for phones, how to calibrate a monitor, controller deadzone settings,
   how to test a used monitor, average 10 second CPS, does my phone have a
   gyroscope, how to use a phone as a level.
4. Optional `typing-test-urdu` / `typing-test-hindi`; the SEO tidy-up of the
   older titles/descriptions listed in phase-12; later leaderboard ideas
   from phase-13b only if Ali asks.

Recipe for a tool page: catalog entry, `content/tools/<slug>.php`, script,
CSS, `python3 bin/make-og-images.py` and commit the JPEG, Playwright pass
(desktop + iPhone 13: console, scroll, JSON-LD), merge to `main`, write
`docs/handoff/phase-N.md`. Sensor pages: mock sensors by dispatching
`DeviceOrientationEvent` / `DeviceMotionEvent` from an init script and grant
`accelerometer`, `gyroscope`, `magnetometer` permissions in the context
(Chromium now has `requestPermission` and denies without them). Recipe for a
guide: see phase-15.
