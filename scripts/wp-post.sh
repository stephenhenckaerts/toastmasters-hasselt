#!/usr/bin/env bash
# Read and update post content on the live site as the wp-admin Administrator.
# Credentials never touch argv or the transcript: they come from
# ../toastmasters-ftp.env and go to curl as a config on stdin, the same way
# scripts/ftp.sh handles the FTP login.
#
# Goes through the WordPress REST API with a normal admin session, so posts
# keep their revisions and every filter WordPress would normally run. This is
# not a direct database edit.
#
#   scripts/wp-post.sh get <post-id>              print the post's raw content
#   scripts/wp-post.sh title <post-id>            print the post's title
#   scripts/wp-post.sh set <post-id> <local-file>  replace the content
#
# A "set" prints the revision count before and after so the change can be
# rolled back from wp-admin (Post → Revisies).
set -euo pipefail

ENV_FILE="$(cd "$(dirname "$0")/../.." && pwd)/toastmasters-ftp.env"
[ -f "$ENV_FILE" ] || { echo "missing $ENV_FILE" >&2; exit 1; }
# shellcheck disable=SC1090
. "$ENV_FILE"

: "${WP_ADMIN_USER:?WP_ADMIN_USER not set in $ENV_FILE}"
: "${WP_ADMIN_PASS:?WP_ADMIN_PASS not set in $ENV_FILE}"

SITE="${WP_SITE_URL:-https://www.toastmastershasselt.be}"
JAR="$(mktemp -t tmhcookies)"
trap 'rm -f "$JAR"' EXIT

login() {
	printf 'data-urlencode = "log=%s"\ndata-urlencode = "pwd=%s"\ndata-urlencode = "wp-submit=Log In"\ndata-urlencode = "testcookie=1"\n' \
		"$WP_ADMIN_USER" "$WP_ADMIN_PASS" \
		| curl -sS -K - -c "$JAR" -b "$JAR" -o /dev/null \
			"$SITE/wp-login.php"
	grep -q 'wordpress_logged_in' "$JAR" || {
		echo "login failed — check WP_ADMIN_USER / WP_ADMIN_PASS" >&2
		exit 1
	}
}

nonce() {
	curl -sS -b "$JAR" -c "$JAR" "$SITE/wp-admin/" \
		| grep -oE '"nonce":"[a-f0-9]+"' | head -1 | cut -d'"' -f4
}

api() {
	local method="$1" path="$2"
	shift 2
	curl -sS -b "$JAR" -c "$JAR" -X "$method" \
		-H "X-WP-Nonce: $(cat "$JAR.nonce")" \
		-H "Content-Type: application/json" \
		"$SITE/wp-json/wp/v2/$path" "$@"
}

case "${1:-}" in
	get|title)
		login
		nonce > "$JAR.nonce"
		api GET "posts/$2?context=edit" | python3 -c "
import sys, json
d = json.load(sys.stdin)
if 'code' in d:
    sys.exit(f\"FAILED: {d.get('code')} {d.get('message')}\")
print(d['$1' == 'get' and 'content' or 'title']['raw'])"
		;;
	set)
		[ -f "$3" ] || { echo "no such file: $3" >&2; exit 1; }
		login
		nonce > "$JAR.nonce"
		before=$(api GET "posts/$2/revisions" | python3 -c "import sys,json; print(len(json.load(sys.stdin)))")
		payload=$(python3 -c "
import json, sys
print(json.dumps({'content': open(sys.argv[1], encoding='utf-8').read()}))" "$3")
		result=$(api POST "posts/$2" --data-binary "$payload")
		echo "$result" | python3 -c "
import sys, json
d = json.load(sys.stdin)
if 'code' in d:
    print('FAILED:', d.get('code'), d.get('message')); sys.exit(1)
print('updated post', d['id'], '—', d['title']['rendered'])
print('modified:', d['modified'])"
		after=$(api GET "posts/$2/revisions" | python3 -c "import sys,json; print(len(json.load(sys.stdin)))")
		echo "revisions: $before -> $after (roll back from wp-admin → Revisies)"
		;;
	*)
		sed -n '2,16p' "$0"
		exit 1
		;;
esac
