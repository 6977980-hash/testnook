#!/usr/bin/env bash
# Theme checks (audit F-37 / S-11). Run from anywhere:
#   bin/check.sh                         lint only (PHP + JS syntax)
#   bin/check.sh https://testnook.com    lint, then the page gate over the sitemap
# Extra arguments after the URL go to bin/check-pages.js (--wide, --limit=N ...).
set -euo pipefail
cd "$(dirname "$0")/.."

echo "PHP lint"
fail=0
while IFS= read -r -d '' f; do
	out=$(php -l "$f" 2>&1) || { echo "$out"; fail=1; }
done < <(find . -path ./.git -prune -o -path ./node_modules -prune -o -name '*.php' -print0)
[ "$fail" -eq 0 ] || { echo "PHP lint failed"; exit 1; }

echo "JS syntax"
while IFS= read -r -d '' f; do
	node --check "$f" || fail=1
done < <(find assets/js bin -name '*.js' -print0)
[ "$fail" -eq 0 ] || { echo "JS syntax check failed"; exit 1; }
echo "Lint OK"

if [ $# -gt 0 ]; then
	node bin/check-pages.js "$@"
fi
