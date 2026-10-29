#!/usr/bin/env python3
"""
Generates the Open Graph share images (1200x630 JPEG) for every tool and hub
in content/catalog.php and every guide in content/guides/ into
assets/img/og/<slug>.jpg. The theme picks them up
automatically (inc/seo.php). Re-run after adding a tool or hub, then commit
the new images; the live site never runs this script.

    python3 bin/make-og-images.py          # writes missing/changed images
    python3 bin/make-og-images.py --force  # rewrites every image

Needs Python 3 with Pillow and the Inter font (falls back to DejaVu Sans).
"""

import json
import os
import subprocess
import sys

from PIL import Image, ImageDraw, ImageFont

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
OUT = os.path.join(ROOT, 'assets', 'img', 'og')
W, H = 1200, 630
PAD = 90
SITE = 'Testnook'

FONT_DIRS = [
    '/usr/share/fonts/opentype/inter',
    '/usr/share/fonts/truetype/inter',
    '/usr/local/share/fonts',
    os.path.expanduser('~/Library/Fonts'),
    '/Library/Fonts',
]


def font(weight, size):
    names = {
        'bold': ['Inter-Bold.otf', 'Inter-Bold.ttf', 'DejaVuSans-Bold.ttf'],
        'medium': ['Inter-Medium.otf', 'Inter-Medium.ttf', 'DejaVuSans.ttf'],
    }[weight]
    for d in FONT_DIRS + ['/usr/share/fonts/truetype/dejavu']:
        for n in names:
            p = os.path.join(d, n)
            if os.path.exists(p):
                return ImageFont.truetype(p, size)
    return ImageFont.load_default()


def catalog():
    """Reads content/catalog.php through PHP so there is one source of truth."""
    code = (
        "define('ABSPATH', 1); echo json_encode(require '%s/content/catalog.php');"
        % ROOT.replace("'", "\\'")
    )
    return json.loads(subprocess.check_output(['php', '-r', code]))


def guides():
    """Title and hub of every guide in content/guides/ (keyed by slug)."""
    code = (
        "define('ABSPATH', 1); $out = array();"
        "foreach (glob('%s/content/guides/*.php') as $f) {"
        " $d = require $f; $out[basename($f, '.php')] = array('title' => $d['title'], 'hub' => $d['hub']); }"
        "echo json_encode($out);" % ROOT.replace("'", "\\'")
    )
    return json.loads(subprocess.check_output(['php', '-r', code]))


def gradient():
    """Teal gradient matching assets/img/og-default.jpg."""
    img = Image.new('RGB', (W, H))
    px = img.load()
    a, b = (14, 100, 94), (21, 142, 128)
    for y in range(H):
        for x in range(W):
            t = (x / W * 0.55 + y / H * 0.45)
            px[x, y] = tuple(int(a[i] + (b[i] - a[i]) * t) for i in range(3))
    return img


def wrap(draw, text, fnt, max_w):
    words, lines, cur = text.split(), [], ''
    for w in words:
        test = (cur + ' ' + w).strip()
        if draw.textlength(test, font=fnt) <= max_w:
            cur = test
        else:
            if cur:
                lines.append(cur)
            cur = w
    if cur:
        lines.append(cur)
    return lines


def render(title, subtitle, kicker, path):
    img = gradient()
    d = ImageDraw.Draw(img)

    # Logo badge: white rounded square with a dark "T" and a dot.
    bx, by, bs = PAD, 86, 84
    d.rounded_rectangle((bx, by, bx + bs, by + bs), radius=20, fill='white')
    tf = font('bold', 58)
    d.text((bx + 18, by + 6), 'T', font=tf, fill=(14, 100, 94))
    d.ellipse((bx + 56, by + 56, bx + 68, by + 68), fill=(14, 100, 94))
    d.text((bx + bs + 24, by + 12), SITE, font=font('bold', 50), fill='white')

    # Kicker (hub name / "Free online tool"), small, muted.
    d.text((PAD, 215), kicker.upper(), font=font('medium', 26), fill=(205, 235, 230))

    # Title, wrapped, shrinking until it fits in two lines.
    size = 76
    while True:
        tf = font('bold', size)
        lines = wrap(d, title, tf, W - 2 * PAD)
        if len(lines) <= 2 or size <= 48:
            break
        size -= 4
    y = 258
    for line in lines:
        d.text((PAD, y), line, font=tf, fill='white')
        y += int(size * 1.15)

    # Subtitle (blurb), up to two lines.
    sf = font('medium', 32)
    y += 14
    for line in wrap(d, subtitle, sf, W - 2 * PAD)[:2]:
        d.text((PAD, y), line, font=sf, fill=(225, 243, 240))
        y += 42

    # Footer line.
    d.text((PAD, H - 78), 'Free  ·  No download  ·  Runs in your browser', font=font('medium', 26), fill=(190, 228, 222))

    img.save(path, 'JPEG', quality=82, optimize=True, progressive=True)


def main():
    force = '--force' in sys.argv
    os.makedirs(OUT, exist_ok=True)
    cat = catalog()
    jobs = []
    for slug, hub in cat['hubs'].items():
        jobs.append((slug, hub['title'], hub['blurb'], 'Testnook hub'))
    for slug, tool in cat['tools'].items():
        jobs.append((slug, tool['name'], tool['blurb'], cat['hubs'][tool['hub']]['title']))
    for slug, guide in guides().items():
        jobs.append((slug, guide['title'], 'A Testnook guide', cat['hubs'][guide['hub']]['title'] + ' guide'))
    done = 0
    for slug, title, blurb, kicker in jobs:
        path = os.path.join(OUT, slug + '.jpg')
        if os.path.exists(path) and not force:
            continue
        render(title, blurb, kicker, path)
        done += 1
    print('wrote %d image(s) to %s' % (done, os.path.relpath(OUT, ROOT)))


if __name__ == '__main__':
    main()
