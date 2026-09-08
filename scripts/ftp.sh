#!/usr/bin/env bash
# Read-only-safe FTP helper for the live site. Credentials never touch argv or
# the transcript: they come from ../toastmasters-ftp.env and go to curl as a
# config on stdin.
#
#   scripts/ftp.sh ls  [remote-dir]          list a directory
#   scripts/ftp.sh get <remote-file> [local]  download one file
#   scripts/ftp.sh put <local-file> <remote-path>   upload (needs write rights)
#   scripts/ftp.sh chmod <octal> <remote-path>      set permissions (needs write rights)
#   scripts/ftp.sh rm <remote-path>                 delete one file (needs write rights)
#   scripts/ftp.sh push-theme                  upload ./theme as wp-content/themes/toastmasters-hasselt
#   scripts/ftp.sh push-plugin                  upload ./plugins/tmhasselt-core as wp-content/plugins/tmhasselt-core
set -euo pipefail
ENV_FILE="$(cd "$(dirname "$0")/../.." && pwd)/toastmasters-ftp.env"
[ -f "$ENV_FILE" ] || { echo "missing $ENV_FILE" >&2; exit 1; }
# shellcheck disable=SC1090
. "$ENV_FILE"
BASE="ftp://$FTP_HOST:${FTP_PORT:-21}"
cfg() { printf 'user = "%s:%s"\n' "$FTP_USER" "$FTP_PASS"; }
run() { cfg | curl -sS -K - "$@"; }

case "${1:-}" in
  ls)   run "$BASE/${2:-}/" ;;
  get)  run "$BASE/$2" -o "${3:-$(basename "$2")}" && echo "saved ${3:-$(basename "$2")}" ;;
  put)  run --ftp-create-dirs -T "$2" "$BASE/$3" && echo "uploaded $3" ;;
  chmod) run -Q "SITE CHMOD $2 /${3#/}" "$BASE/" && echo "chmod $2 $3" ;;
  rm)   run -Q "DELE /${2#/}" "$BASE/" && echo "deleted $2" ;;
  push-theme)
    cd "$(dirname "$0")/../theme"
    find . -type f ! -name '_prototype-template.html' ! -name '.DS_Store' | sort | while read -r f; do
      rel="${f#./}"
      run --ftp-create-dirs -T "$f" "$BASE/wp-content/themes/toastmasters-hasselt/$rel" && echo "  $rel"
    done ;;
  push-plugin)
    cd "$(dirname "$0")/../plugins/tmhasselt-core"
    find . -type f ! -name '.DS_Store' | sort | while read -r f; do
      rel="${f#./}"
      run --ftp-create-dirs -T "$f" "$BASE/wp-content/plugins/tmhasselt-core/$rel" && echo "  $rel"
    done ;;
  *) sed -n '2,11p' "$0"; exit 1 ;;
esac
