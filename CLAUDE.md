# Toastmasters Hasselt — club website

Personal side project: Stephen inherited **www.toastmastershasselt.be**, a
WordPress site for the only fully Dutch-language Toastmasters club in Flanders.
**The only goal is more members.** Judge every change by whether a visitor is
more likely to turn up on a club evening. Breaking the live site is acceptable;
losing content is not. Stay on WordPress so non-technical members can edit after
Stephen leaves — decided, don't re-litigate.

## Stack

| Layer | Truth |
|---|---|
| Live | WordPress 7.1 on Combell webhosting (`web086whyzzledev`), PHP version set in the Combell panel |
| Local | `@wordpress/env` (Docker): WP latest, PHP 8.4, http://localhost:8888, admin/password |
| Theme | `theme/` — `toastmasters-hasselt` block theme (FSE): `theme.json`, `templates/*.html`, `parts/*.html`, `patterns/*.php`, `assets/css/app.css`. Text domain `tmhasselt`, Dutch only. Built in wp-env 2026-09-07; not yet on live. See `docs/2026-09-07-block-theme-conversion-plan.md` |
| Plugin | `plugins/tmhasselt-core/` — meeting-date engine, SEO/JSON-LD head tags, `tmhasselt/meeting` binding, `tmhasselt/faq` block. Must be active for the theme to work |
| Forms | WPForms Lite form 129 → hasselt.toastmasters@gmail.com |
| Access | wp-admin Administrator; FTP creds in `../toastmasters-ftp.env` (outside the repo) |

## Layout

```
theme/            the shipped theme (style.css header, templates, assets/)
plugins/          tmhasselt-core — request-time logic that outlives a theme swap
docs/             plans and decisions, English, dated YYYY-MM-DD-*.md
design/           prototype.html — the August 2026 design canvas export
backups/          content + built-theme snapshots (gitignored)
private/          exported personal data, e.g. the lead list (gitignored, delete when answered)
scripts/ftp.sh    ls / get / put / push-theme against the live host
.wp-env.json      local WordPress definition
```

## Commands

- `npm start` / `npm stop` — local WordPress (Docker must be running); wp-env has Home + Blog pages set as front/posts pages
- Block theme: no PHP templates. Edit `theme/templates/*.html`, `theme/parts/*.html`, `theme/patterns/*.php`, `theme/theme.json`, `theme/assets/css/app.css`. Dynamic dates come from the `tmhasselt/meeting` binding (plugin); the FAQ accordion is the `tmhasselt/faq` block (plugin)
- `npm run wp -- <args>` — WP-CLI inside the container (`npm run wp -- theme list`)
- `npm run lint:php` — `php -l` on every theme file
- `npm run ftp -- ls wp-content/themes` — read the live host
- `npm run ftp -- push-theme` — deploy `theme/` to the live host (FTP write access confirmed 2026-09-07)
- `npm run ftp -- push-plugin` — deploy `plugins/tmhasselt-core/` to the live host

## Working rules

- **Secrets never enter the transcript.** Credentials come from the env file
  via `scripts/ftp.sh`; never `cat` it, never pass a password on a command line.
- **Content safety first.** Before any change on live: Prime Mover export or
  Tools → Export. Uploading a theme changes nothing; activating it is the flip,
  and Appearance → Themes flips it back.
- **Files go over FTP, everything else through wp-admin.** Never edit the
  database by hand. Drive wp-admin in the browser for activation, plugins,
  menus, pages, form settings.
- **Build locally, ship finished.** Every theme change is built and verified in
  wp-env before it goes to the live host.
- **A UI claim is unverified until seen in a browser** (`live-verify` skill).
  Walk every template: front page, `/faq/`, `/blog/`, one post, one page, 404,
  contact form. Check mobile width. Dutch copy only.
- **PHP**: WordPress coding standards, tabs, `tmh_` prefix, escape every output
  (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`). No syntax the live PHP
  version lacks. Self-documenting code; no inline comments explaining what code
  does, docblocks for public functions only.
- **Copy**: plain Dutch, no translated idioms, no invented testimonials or
  quotes (real first-name quotes only, with consent). Pricing: €197 new /
  €177 renewal per year. No named contact person; "een van onze bestuursleden".
- **Brand**: official Toastmasters logo unaltered; palette and type rules in the
  `design-system` skill (paint vs ink).
- **Docs in English** under `docs/`; chat may be Dutch.
- **Commits**: conventional messages (`feat(theme): …`, `fix(faq): …`), one
  topic per commit. Solo repo, `main` is fine. No changesets here.
- Durable lessons go to Claude auto-memory, one fact per file, not into skills.

## Current plan

`docs/2026-09-04-upgrade-and-overhaul-plan.md` — six phases: access, content
safety net, local wp-env, theme conversion, design overhaul, cutover,
post-launch. Phase 0 (access) cleared 2026-09-07. Phase 2 (local wp-env)
running. Decision A resolved: **full block theme (FSE)**, not hybrid — see
`docs/2026-09-07-block-theme-conversion-plan.md`. Build order: `tmhasselt-core`
plugin (done 2026-09-07) → Phase 4 design canvas + sign-off → block theme
templates/patterns built once against the final design.
