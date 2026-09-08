# Toastmasters Hasselt — upgrade and overhaul plan

Date: 2026-09-04. Owner: Stephen. Site: https://www.toastmastershasselt.be

## Where things stand (verified over FTP, read-only)

| Item | State |
|---|---|
| Hosting | Combell webhosting package `web086whyzzledev`, migrated 2026-09-03 with Prime Mover |
| WordPress core | 7.1 (latest) |
| PHP | unknown — WP 7.1 requires ≥ 7.4; check Site Health, target 8.4 |
| Plugins (13) | every one on its latest release; four are dead weight (below) |
| Active theme | Nictitate Lite 2.1.3 (Kopatheme, abandoned) + Twenty Twenty-Five 1.5 as fallback |
| Our theme | `theme/` (1,117 lines PHP), lint-clean on PHP 8.5, no removed functions |
| Content backup | `backups/2026-08-20/` — REST JSON + 73 MB uploads. No SQL dump |
| Blockers | ~~FTP account cannot write~~ cleared 2026-09-07: read/write/delete confirmed. Plain FTP only (rotate password after cutover). ~~`wp-config.php` is 0666~~ set to 0600 on live 2026-09-07 |

Conclusion: there is nothing left to "update" in the software sense. Core and plugins are
current. The work is (1) housekeeping on the install, (2) bringing our own theme up to
WP 7.1 conventions, and (3) the design overhaul. Because the live site is allowed to
break, we skip staging and cut over on production, protected by a content backup.

## Phase 0 — Access — CLEARED 2026-09-07

The FTP user now has write rights. `scripts/ftp.sh` confirmed STOR, DELE and
SITE CHMOD all work (probe file uploaded to `wp-content/`, listed, deleted;
`wp-config.php` set to 0600). `npm run ftp -- push-theme` is unblocked.

Still outstanding, lower priority:

- **Combell control panel login** — still not held. Needed for the PHP version
  selector (Phase 5 step 2), phpMyAdmin SQL dumps, and DNS (Phase 6 SPF fix).
  Ask `toasty` or Chris.
- Plain FTP only (AUTH TLS refused). Rotate the FTP password after cutover, or
  get SFTP credentials from the FTP & SSH page.

Everything in Phases 1–4 proceeds without the panel.

## Phase 1 — Content safety net (no access needed, ~30 min)

- Prime Mover is already installed and its free tier has no size or feature limit.
  Export to "single-site format" from wp-admin. The `.wprime` package holds the
  database, plugins, theme, and uploads, and imports straight into a localhost site.
  Download it from Prime Mover's package manager.
- Tools → Export → "All content" as a second, tool-independent copy (WXR).
- WPForms → Tools → Export: form 129 as JSON. Lite exports forms, not entries.
- Pull `wp-content/uploads/2026/` over FTP (reads work) to top up the August copy.

Losing content is the only failure that matters. After this phase it cannot happen.

## Phase 2 — Local WordPress 7.1 (no access needed, ~1 h)

Docker 29 and PHP 8.5 are installed. Use `@wordpress/env`:

```
npm install   # @wordpress/env is a devDependency
cd ~/Documents/Toastmasters/toastmasters-hasselt
# .wp-env.json: { "core": "WordPress/WordPress#7.1", "phpVersion": "8.4",
#   "themes": ["./theme"], "plugins": ["wpforms-lite"] }
npm start
```

`core: null` resolves to the latest production release, which is 7.1 today; pin
`"WordPress/WordPress#7.1"` once the tag matters. `phpVersion` accepts `"8.4"`.
Install Prime Mover in the local site and restore the `.wprime` package from Phase 1.
Result: a byte-for-byte copy of the real site on the target stack, where breaking
things costs nothing and the theme can be built to completion before anything
hits Combell.

## Phase 3 — Theme brought to WP 7.1 conventions (local)

Decision point A — theme architecture. Recommendation: **hybrid classic theme**.

| Option | Pros | Cons |
|---|---|---|
| **Hybrid classic + `theme.json`** (recommended) | Keeps our PHP templates (meeting-date logic, JSON-LD, FAQ from category). Editors get the block editor with our palette and type scale enforced. Smallest lift from what exists. | Header/footer stay code-only; members cannot restyle the shell without a developer. |
| Full block theme (FSE) | Members can edit everything visually after Stephen leaves. | Bespoke "flashy" layouts are painful in block markup; meeting-date logic and JSON-LD need a small plugin; roughly a rewrite. |
| Page builder plugin | Fast visual editing. | Lock-in, bloat, slow pages, undercuts the SEO lead we already hold. Rejected. |

Work items:

- `style.css` header: `Requires at least: 6.5`, `Requires PHP: 8.1`, `Tested up to: 7.1`.
- Add `theme.json`: palette (Loyal Blue paint, lifted maroon ink, derived neutrals),
  type scale (Source Serif 4 / Source Sans 3), spacing, `appearanceTools`.
  Editors then pick only sanctioned colours.
- Register block patterns for the recurring sections (hero, next-meeting card, FAQ
  item, CTA band) so members can compose new pages from approved pieces.
- Move `inc/meeting.php` date logic and `inc/seo.php` JSON-LD into a tiny
  site plugin (`tmhasselt-core`). Survives a future theme swap.
- Replace the hand-coded WPForms embed with the block; keep form 129.
- Run `wp theme check` (Theme Check plugin) and the PHP 8.4 lint in wp-env.

## Phase 4 — Design overhaul (design canvas, then port)

Decision point B — starting point. The 2026-08-20 prototype still exists:

- Prototype artifact: https://claude.ai/code/artifact/71cfbed6-31cd-48a1-b1e4-a1cc37e1fb00
- Local copy: `prototype.html` (936 KB)
- Runbook: https://claude.ai/code/artifact/da055ad1-bb2e-4467-bb5a-578d3a540c7b

That prototype is deliberately restrained (brand-compliant, paint-vs-ink). "New flashy"
is a different brief. Two routes:

1. **Evolve it** — keep the structure and copy (hero, next meeting, why Hasselt, FAQ,
   pricing, contact) and turn up motion, photography, and scale. Fastest.
2. **Restart** — new art direction on a design canvas, then port. Better if "flashy"
   means a different personality, not a louder version of the same one.

Constraints that survive either route: official TI logo unaltered, yellow only on dark
grounds, member conversion is the only metric, Dutch-only copy, no invented
testimonials, hero photo needs consent before use.

Steps: canvas with 3–4 artboards (home, meeting/FAQ, contact, blog post) → sign-off →
port into the hybrid theme as templates + patterns in wp-env → locale and mobile pass
→ Lighthouse ≥ 90 on mobile.

## Phase 5 — Cutover on production (needs Phase 0)

Order matters. Each step is reversible until step 6.

1. Fresh SQL dump from phpMyAdmin (or Prime Mover export) — belt and braces.
2. Set PHP to 8.4 in the Combell panel. Site Health must show no critical issues.
3. ~~`chmod wp-config.php`~~ — done 2026-09-07, set to 0600.
4. Upload `tmhasselt-core` plugin and the theme via file manager / SFTP. Nothing changes yet.
5. Activate the plugin, then the theme. Rollback = activate Nictitate Lite again.
6. Delete dead plugins: `kopatheme`, `nictitate-toolkit`, `image-widget`,
   `google-maps-widget` (if the map moves into the theme), `prime-mover` + its
   `uploads/prime-mover-*` folders, and `worker` (ManageWP) unless the admin
   identifies who holds it. Then delete Nictitate Lite. Keep Twenty Twenty-Five as
   the fallback theme, Loginizer, GDPR cookie, GTM, Pretty Link, Simple 301,
   WPForms Lite, WP Mail Logging.
7. Verify live: home, `/faq/`, `/blog/`, one post, 404, contact form submission lands in
   Gmail, `lang="nl-BE"`, JSON-LD validates, next-meeting date correct, mobile.
8. Rotate the FTP password if plain FTP was used.

## Phase 6 — After launch (separate tickets)

- Fix the SPF record (non-breaking space before `-all`) in Combell DNS.
- Claim and recategorise the Google Business Profile.
- Answer the 12-month lead list in `private/gemiste-aanvragen-12mnd.md`, then delete the file.
- Gather real first-name quotes at a club evening for the testimonials section.
- Take the wordpress.com duplicate offline.

## Verified online (2026-09-04)

| Assumption | Verdict | Source |
|---|---|---|
| Combell panel: file manager, PHP switch, phpMyAdmin, DNS | Confirmed | combell.com/en/help/kb (file-manager, change-the-php-version, how-do-i-open-phpmyadmin, what-are-dns-records) |
| FTP 550 cause | Per-user write permission toggle in the panel | combell.com/en/help/kb/adjusting-the-rights-of-an-ftp-user |
| Combell offers SFTP | Confirmed, credentials under FTP & SSH | kb.combell-sre.net/faq/connect_ftp |
| wp-env `core` git-ref pin and `phpVersion` 8.4 | Confirmed; Docker required | github.com/WordPress/gutenberg packages/env README |
| Hybrid classic theme + theme.json v3 + patterns on current WP | Confirmed, documented practice | developer.wordpress.org/news/2024/12/bridging-the-gap-hybrid-themes |
| Prime Mover free export → localhost import | Confirmed, no size limit | wordpress.org/plugins/prime-mover, codexonics.com FAQ |
| WPForms Lite form export | Forms yes (JSON), entries no | wpforms.com/how-to-export-a-form-in-wordpress |

## Open questions for Stephen

1. Decision A: hybrid classic theme (recommended) or full block theme?
2. Decision B: evolve the August prototype or restart the art direction?
3. Does the admin know who runs ManageWP Worker? If nobody, it goes.
