# Content files

All public pages except the homepage are defined by PHP files under `content/`.
The theme syncs them into WordPress pages automatically (`inc/sync.php`) the
first time a request arrives after the files change. Nobody edits pages in
wp-admin; edit the file, push, and Hostinger deploys it.

| Kind | File | Needs |
|---|---|---|
| Tool | `content/tools/<slug>.php` | the slug must also be listed in `content/catalog.php` |
| Hub | `content/hubs/<slug>.php` | the slug must be a hub in `content/catalog.php` |
| Static page | `content/pages/<slug>.php` | nothing else |

A tool listed in the catalog without a content file shows as "Coming soon"
(no link) on the homepage and hubs. Deleting a content file sets its
WordPress page to draft (404 for visitors) on the next request.

Each file `return`s an array. Strings may contain HTML; it is filtered with
`wp_kses` using the allow-list in `inc/helpers.php` (`tn_allowed_html()`),
which covers normal post HTML plus `button`, `input`, `select`, `canvas`,
`video`, `audio`, `meter`, `svg`, `details` and any `data-*` attribute.

## Tool file

```php
<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'          => 'Webcam Test',                        // H1
	'seo_title'      => 'Webcam Test: Check Your Camera Online (Free)', // <title>, 50-60 chars
	'description'    => 'Meta description, 140-160 chars.',
	'intro'          => 'One or two sentences under the H1.',
	'device'         => 'any',     // any | desktop | touch | gamepad | media  (shows a warning on the wrong device)
	'device_message' => 'Text of that warning (optional).',
	'ads'            => 'standard', // standard | content | none  (see inc/ads.php)
	'styles'         => array( 'webcam' ),   // assets/css/tools/webcam.css, inlined (optional)
	'scripts'        => array( 'webcam' ),   // assets/js/tools/webcam.js, deferred (optional)
	'embed_height'   => 620,       // iframe height in the embed code (optional)
	'tool'           => '<div class="tool-bar">...</div><div class="tool-stage">...</div>', // the tool markup
	'howto'          => array( 'Step one.', 'Step two.' ),            // ordered list
	'howto_title'    => 'How to use the Webcam Test',                  // optional
	'results'        => '<p>HTML explaining the result.</p>',
	'results_title'  => 'What the results mean',                        // optional
	'extra'          => array( array( 'Heading', '<p>HTML</p>', 'anchor-id' ) ), // more H2 sections (optional)
	'fixes'          => array( array( 'Problem', 'Fix text, paragraphs separated by blank lines.' ) ),
	'faq'            => array( array( 'Question?', 'Answer (HTML ok).' ) ),  // 6 recommended; also emitted as FAQPage schema
	'disclaimer'     => 'Shown in a warning box after the FAQ (hearing/eye tests).', // optional
	'related'        => array( 'online-mirror', 'mic-test' ),  // preferred related tools; the rest is filled from the hub
	'updated'        => '2026-10-28',                          // shown as "Last updated"
);
```

Name, blurb and hub come from `content/catalog.php` and are merged in.

### Ads modes

- `standard`: slot under the tool, one in the content, one after the FAQ.
- `content`: no slot under the tool. Use for anything the user clicks or taps
  quickly (CPS, double click, spacebar, reaction time) so an ad is never next
  to the click area.
- `none`: no ads at all. Use for solid colour screens, dead pixel, burn-in,
  and any tool that is mostly a full-screen surface without text.

Embed mode (`?embed=1`), legal pages and the 404 never show ads.

### Tool markup conventions

Use the shared classes so every tool looks the same:

- `.tool-bar` (buttons row, `.btn`, `.btn-primary`, `.btn-sm`, `.seg` toggles),
- `.tool-stage` (the main area, min-height 320px),
- `.tool-status` (`aria-live="polite"`; set with `TNUtil.status(el, msg, 'ok'|'bad'|'')`),
- `.stats > .stat` (`.stat-label` + `.stat-value`) for numbers,
- `.meter > span` for level bars.

Add `data-tn-fullscreen="#tool"` to a button to toggle fullscreen (with a
CSS fallback on iPhone). `TNUtil` in `assets/js/site.js` has the helpers:
`$`, `$$`, `isTouch()`, `hasFinePointer()`, `enterFullscreen(el)`,
`exitFullscreen()`, `isFullscreen()`, `status()`, `mediaError(err, 'camera')`.

Tool scripts run after `site.js` (deferred). Wrap in an IIFE and bail if
`document.querySelector('[data-tool="<slug>"]')` is missing, so the script is
safe on any page.

## Hub file

```php
return array(
	'title'       => 'Screen & Monitor Tests',  // H1 (defaults to catalog title)
	'seo_title'   => '...',
	'description' => '...',
	'intro'       => 'Lede under the H1.',
	'body'        => '<h2>...</h2><p>...</p>',  // guide text after the tool grid
	'faq'         => array( array( 'Q', 'A' ) ),
	'ads'         => 'standard',
);
```

## Static page file

```php
return array(
	'title'       => 'About Testnook',
	'seo_title'   => '...',
	'description' => '...',
	'updated'     => '2026-10-28',  // optional
	'body'        => '<p>HTML</p>',
	'ads'         => 'none',        // default for static pages
);
```

## Images

- `assets/img/og-default.jpg` is the share image for every page.
- Drop `assets/img/og/<slug>.jpg` (1200x630) to give a tool or hub its own.
- Favicons live in `assets/img/` and are used unless a Site Icon is set in the Customizer.
