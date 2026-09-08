# Phase 3 rework — convert the theme to a full block theme (FSE)

Date: 2026-09-07. Owner: Stephen. Supersedes Phase 3 of
`2026-09-04-upgrade-and-overhaul-plan.md` (Decision A resolved: **full block
theme**, not hybrid classic).

## Why this is a rewrite, not an edit

The current `theme/` is a classic PHP theme: `header.php` / `footer.php` /
`front-page.php` with hand-written markup, `wp_nav_menu()`, `WP_Query` in the
template, `do_shortcode()` for the form, and all layout in `.shell` wrappers +
`style.css`. A block theme replaces every one of those mechanisms. The existing
templates stay in git history as the reference for copy and section order; the
shipped artifact is new.

Two things move out of the theme entirely into a small site plugin
(`tmhasselt-core`), because a block theme has no `functions.php` home for
request-time logic that must survive a future theme swap:

- the meeting-date engine (`inc/meeting.php`)
- the hand-rolled SEO head tags + Organization/Event JSON-LD (`inc/seo.php`)

## Verified against the current stack (2026-09-07)

| Fact | Value | Source |
|---|---|---|
| Live + local WP | 7.1 both | `wp core version` in wp-env; live FTP |
| theme.json schema | v3, needs WP ≥ 6.6 | make.wordpress.org/core 2024-06-19 |
| Block Bindings API | WP ≥ 6.5, PHP `register_block_bindings_source()` on `init` | developer.wordpress.org block-bindings |
| Bindings-capable attrs | paragraph/heading `content`, button `text`/`url`, image `url`/`alt`, post-date `datetime` | same |
| Patterns | auto-registered from `patterns/*.php` with a file header, no PHP call | developer.wordpress.org registering-patterns |
| `templates/index.html` | the one required file; its presence = "block theme" | developer.wordpress.org templates |
| WPForms Lite | 2.0.1.1 in wp-env, ships `wpforms/form-selector` block | `wp plugin list` |
| Local content | wp-env is a stock install, **production content not restored** | `wp theme list` shows all default themes; `show_on_front=posts` |

## Repo layout after this phase

```
theme/                     block theme (was classic)
  style.css                header only + @font-face fallbacks
  theme.json               v3 — palette, type, spacing, layout, styles
  functions.php            enqueue residual CSS + fonts, pattern category, supports
  templates/               index, front-page, single, page, archive, 404 (.html)
  parts/                   header, footer (.html)
  patterns/                hero, promise, fear, evening, belonging, practical,
                           faq, contact, cta-band, front-page (.php)
  assets/
    css/app.css            grain, runsheet timeline, accordion, WPForms overrides,
                           dark scheme — everything theme.json can't express
    img/                   unchanged
  screenshot.jpg           unchanged
plugins/
  tmhasselt-core/
    tmhasselt-core.php     bootstrap
    inc/meeting.php        moved verbatim from theme/inc/
    inc/seo.php            moved verbatim from theme/inc/ (+ tmh_club_email)
    inc/bindings.php       register the tmhasselt/meeting binding source
    inc/blocks.php         register the tmhasselt/faq dynamic block
    blocks/faq/block.json
    blocks/faq/render.php  the WP_Query from front-page.php lines 255-285
```

No build step anywhere. Every block is server-rendered PHP.

## Files to create

### Plugin — `plugins/tmhasselt-core/`

| File | Content |
|---|---|
| `tmhasselt-core.php` | Plugin header (`Text Domain: tmhasselt`), `ABSPATH` guard, `require` the four `inc/` files. Target PHP 7.4 (live floor) — no 8.0+ syntax until Phase 5 bumps PHP. |
| `inc/meeting.php` | Move unchanged: `tmh_timezone`, `tmh_upcoming_meetings`, `tmh_next_meeting`, `tmh_dutch_date`, `tmh_relative_date`. |
| `inc/seo.php` | Move unchanged: `tmh_meta_description`, `tmh_head_meta` (`wp_head` pri 2), `tmh_structured_data` (`wp_head` pri 5). Add `tmh_club_email()` here (it currently lives in theme `functions.php`; SEO + JSON-LD depend on it). |
| `inc/bindings.php` | `register_block_bindings_source( 'tmhasselt/meeting', [...] )` on `init`. One `get_value_callback` switching on `$args['key']`: `next_date`, `next_date_year`, `next_relative`, `next_iso`, `then_sentence`, `strip_line`. Returns plain strings; falls back to `"datum volgt"` when `tmh_next_meeting()` is null. |
| `inc/blocks.php` | `register_block_type( __DIR__ . '/../blocks/faq' )` on `init`. |
| `blocks/faq/block.json` | `apiVersion` 3, `name` `tmhasselt/faq`, `render` `file:./render.php`, no scripts, one attribute `count` (default 12). |
| `blocks/faq/render.php` | The exact `WP_Query( category_name => 'faq', order ASC )` loop from `front-page.php`, emitting the `<details>`/`<summary>` list and the "nog geen vragen" fallback. First item `open`. |

### Theme — `theme/`

| File | Content |
|---|---|
| `style.css` | Keep the WordPress theme header. Bump: `Requires at least: 6.6`, `Requires PHP: 7.4`, `Tested up to: 7.1`, `Version: 2.0.0`. Body of the file shrinks to `@font-face` fallback declarations only. |
| `theme.json` | See "theme.json shape" below. |
| `functions.php` | `after_setup_theme`: `add_theme_support` for `wp-block-styles`, `editor-styles`, `post-thumbnails`, `title-tag`, `html5`, `responsive-embeds`. Drop `register_nav_menus` (Navigation block replaces it). `wp_enqueue_scripts` + `enqueue_block_assets`: Google Fonts (unchanged URL) and `assets/css/app.css`. Register block pattern category `tmhasselt`. Keep `show_admin_bar __return_false`, excerpt filters. Remove `tmh_contact_form`, `tmh_club_email` (moved to plugin), `require inc/*`. |
| `parts/header.html` | The sticky strip (bound paragraph via `tmhasselt/meeting` key `strip_line`), club name (site-title block), `core/navigation`. |
| `parts/footer.html` | TI logo band (`core/image`, `assets/img/ti-logo-band.jpg`), three column groups, both required TI legal paragraphs verbatim, `© {current year}` via a bound date or static. |
| `templates/index.html` | Header part → `core/query` (main loop, archive-card styling) + `core/query-pagination` + `core/query-no-results` → cta-band pattern → footer part. |
| `templates/front-page.html` | Header part → `<!-- wp:pattern {"slug":"tmhasselt/front-page"} /-->` → footer part. Nothing else. |
| `templates/single.html` | Header → post-title, post-date, post-featured-image, post-content (`prose` styling) → cta-band pattern → footer. |
| `templates/page.html` | Header → post-title + post-content → footer. |
| `templates/archive.html` | Header → archive-title + archive-description → query loop (same as index) → cta-band → footer. Fixes the FAQ/blog archive shadowing, same as the classic `archive.php`. |
| `templates/404.html` | Header → "bestaat niet (meer)" heading + two buttons → footer. |
| `patterns/hero.php` | `Title: Hero`, `Slug: tmhasselt/hero`, `Inserter: yes`. H1 + lede + "enige Nederlandstalige club" callout + two buttons + the "volgende meeting" row group. Each dynamic value is its own bound paragraph (`next_date`, `next_relative`, `then_sentence`). |
| `patterns/promise.php` | "Je hoeft niets te zeggen. Kijken mag." + the 4-item list. Static. |
| `patterns/fear.php` | Spreekangst section + the shout blockquote. Static. |
| `patterns/evening.php` | "Zo verloopt een avond" + the 5-step runsheet (static markup, `app.css` draws the timeline lamps). |
| `patterns/belonging.php` | "Gewone mensen die graag beter willen leren spreken" + bar photo. Static. |
| `patterns/practical.php` | The 4 fact cards (one bound paragraph for "volgende keer op…") + Sportcentrum Olympia location + route box. |
| `patterns/faq.php` | Heading + `<!-- wp:tmhasselt/faq /-->`. |
| `patterns/contact.php` | Heading + lede + `wp:wpforms/form-selector {"formId":"129","displayTitle":false,"displayDesc":false}` + the "je krijgt antwoord" routing box + mailto line. Fallback: swap to a `core/shortcode` block `[wpforms id="129"]` if the block name check fails. |
| `patterns/cta-band.php` | `Block Types: core/template-part/…` not needed; reused by hand in single/archive/404. Blue band, "Zin om eens te komen kijken?" + guest button. |
| `patterns/front-page.php` | `Inserter: no`. Composes hero → promise → fear → evening → belonging → practical → faq → contact in that order. |

## theme.json shape (v3)

- `"version": 3`, `"$schema": "https://schemas.wp.org/trunk/theme.json"`.
- **settings.appearanceTools**: `true`. **settings.useRootPaddingAwareAlignments**: `true`.
- **settings.layout**: `contentSize: "37.5rem"` (≈ the 60ch measure), `wideSize: "71.25rem"` (1140px, the old `.shell` max-width).
- **settings.color**: `custom: false`, `customGradient: false`, `defaultPalette: false`, `defaultGradients: false`. `palette` holds **only colours allowed to fill an area** — `blue` `#004165`, `blue-lift` `#006094`, `blue-deep` `#00314E`, `blue-950` `#001626`, `ground` `#F5F5F5`, `surface` `#FFFFFF`, `surface-2` `#E7E9E9`, `ink` `#1A1A1A`, `white` `#FFFFFF`, `yellow` `#F2DF74`. Maroon, ink-2/3, lines, status colours are **not** palette entries — they stay CSS custom properties in `app.css` so the editor cannot offer maroon as a background (paint-vs-ink discipline).
- **settings.typography**: `customFontSize: false`, `defaultFontSizes: false`, `fluid: true`, `fontFamilies` = Source Serif 4 (`slug: display`) and Source Sans 3 (`slug: sans`), `fontSizes` = `sm/base/lg/xl/2xl/3xl` carrying the existing `clamp()` values from `--t-0…--t-4`.
- **settings.spacing**: `customSpacingSize: false`, `defaultSpacingSizes: false`, `units: ["rem","%","vw"]`, `spacingSizes` = a 6-step scale matching the current `clamp()` band padding.
- **styles**: body `backgroundColor: var(--ground-equivalent)` via `ground`, text `ink`, link colour `blue-lift` / hover, `elements.h1-h3` fontFamily `display` + letter-spacing, `elements.button` (blue fill, white text, 6px radius, 48px min height), `blocks.core/pullquote` + `core/quote` maroon left rule.
- **templateParts**: `{name: header, area: header}`, `{name: footer, area: footer}`.
- **customTemplates**: none initially.

## Dynamic data — mechanism decisions

| Surface | Mechanism | Note |
|---|---|---|
| Strip line, hero dates, "daarna is het…", practical "volgende keer op…" | **Block Bindings** source `tmhasselt/meeting` bound to paragraph `content` | Bindings replace the whole attribute, so composite sentences ("Daarna is het **X**.") are returned whole by the callback — the Dutch phrasing lives in `bindings.php`, not the pattern. Documented tradeoff. |
| FAQ accordion from the `faq` category | **Dynamic block** `tmhasselt/faq` (`render.php`) | Core has no accordion block and Query Loop can't put the post title inside `<summary>`. Reuses the existing `WP_Query` verbatim. Club still edits FAQ answers as ordinary posts — workflow unchanged. |
| Organization + Event JSON-LD, meta description, OG tags | **Plugin `wp_head` hooks** (unchanged code) | Not blocks. Survives theme swaps because it is in the plugin. |
| Contact form | **`wpforms/form-selector` block**, `formId 129` | Shortcode block fallback. |
| Primary + footer navigation | **`core/navigation` block** | The old `primary`/`footer` menus do not migrate; rebuilt once in the Site Editor. |

## Migration disposition (Keep / Update / Defer)

| Current | Disposition |
|---|---|
| `inc/meeting.php`, `inc/seo.php` | **Keep** — move verbatim to the plugin. |
| FAQ via `WP_Query` in `front-page.php` | **Update** → `tmhasselt/faq` dynamic block. |
| `do_shortcode('[wpforms id=129]')` | **Update** → `wpforms/form-selector` block. |
| `wp_nav_menu()` × 2 | **Update** → `core/navigation`; menus rebuilt in the editor. |
| `.shell` wrappers + bespoke layout CSS | **Update** → theme.json `contentSize`/`wideSize` + Group blocks. |
| `style.css` `:root` tokens | **Update** → fills to theme.json palette; ink/rules/status stay CSS vars in `app.css`. |
| `.grain`, `.runsheet`, `details` accordion, `.wpforms-*` overrides | **Keep** → moved as-is into `app.css`, enqueued via `functions.php`. |
| `prefers-color-scheme` dark block | **Defer** — keep in `app.css`, revisit during Phase 4. |
| `title-tag` / `post-thumbnails` / `html5` supports, `show_admin_bar` false, excerpt filters | **Keep** in `functions.php`. |
| Text domain `tmhasselt`, `languages/` | **Keep**. |

## wp-admin steps (wp-env first, then repeated on live at cutover)

1. Activate `tmhasselt-core` **before** switching the theme (JSON-LD/SEO must not blink out).
2. Settings → Reading: "Your homepage displays → A static page", pick the front-page page and the posts page (`/blog/`). `front-page.html` renders regardless, but `is_front_page()` in `seo.php` depends on this.
3. Site Editor → Navigation: build the primary menu (Wat mag je verwachten / Spreekangst / Praktisch / Veelgestelde vragen / **Kom langs als gast** button) and the footer menu.
4. Confirm the WPForms block id is `wpforms/form-selector` (`wp block-type list` or the inserter); if not, switch `patterns/contact.php` to the shortcode fallback.
5. FAQ posts and form 129: no change.

## Edge cases

- **No upcoming meeting** — `tmh_next_meeting()` null: binding callback returns `"datum volgt"`; `tmhasselt/faq` unaffected. (The generator spans 24 months, so null is theoretical.)
- **FAQ category empty** — `render.php` prints the existing "Er staan nog geen vragen in de categorie FAQ." line.
- **Post with no featured image** — `core/post-featured-image` renders nothing, no gap.
- **Empty archive** — `core/query-no-results` block copy.
- **Dynamic blocks in the editor** — `tmhasselt/faq` shows a plain server-rendered preview (no interactivity in the canvas); acceptable, the club never edits it.
- **Bindings in the editor** — the callback runs in the editor via REST, so real dates show on the canvas.

## Verification (wp-env, then live per `live-verify`)

Restore or seed content first — wp-env is currently a stock install. Import the
Phase 1 `.wprime` package, or at minimum create the `faq` category + 3 FAQ posts
and one `blog` post.

Walk every template at desktop and 375px:

- Front page: 8 sections in order; hero date = next 1st/3rd Tuesday 20:00; strip present; single visible CTA (guest).
- `/faq/` and `/blog/`: category archives resolve (the shadowing fix holds).
- One post: `single.html` + CTA band.
- One page: `page.html`.
- 404.
- Contact: submit in wp-env (check WP Mail Logging / WPForms), and on live post-cutover a real submit must reach `hasselt.toastmasters@gmail.com`.
- `<html lang="nl-BE">`, Dutch copy only, no English strings leaking from core.
- JSON-LD passes the Rich Results Test; 6 upcoming events; Organization node intact.
- `npm run lint:php` clean (theme + plugin); no PHP 8.0+ syntax in the plugin.
- Lighthouse mobile ≥ 90.

## Work order (all in wp-env)

1. **Done 2026-09-07.** Scaffolded `plugins/tmhasselt-core/`, moved `meeting.php` + `seo.php` + `tmh_club_email`, added `inc/bindings.php` + `blocks/faq/`. Plugin active alongside the classic theme; SEO head tags + JSON-LD (7 nodes) render from the plugin, binding source + `tmhasselt/faq` block registered and verified, classic theme strip still shows the next date. `theme/inc/` deleted; `functions.php` warns in wp-admin if the plugin is inactive. Tooling: `.wp-env.json` mapping, `ftp.sh push-plugin`, `lint:php` glob, `CLAUDE.md` all updated.
2. ~~Add `inc/bindings.php` + `blocks/faq/`~~ folded into step 1.
3. **Done 2026-09-07.** `theme.json` v3 written (palette, type scale, spacing scale, layout 40rem/75rem, element + block styles).
4. **Done.** `parts/header.html` (strip with `strip_line` binding, inline Navigation, guest button), `parts/footer.html` (→ `tmhasselt/footer` pattern). Templates: `front-page`, `index`, `home`, `archive`, `single`, `page`, `404` (all `.html`).
5. **Done.** Patterns: `hero`, `promise`, `fear`, `evening`, `belonging`, `practical`, `faq`, `contact`, `cta-band`, `footer`, `front-page` (composition, Inserter: no). Bindings used: `strip_line`, `next_date`, `next_sub`, `cadence`, `practical_next`. WPForms via a `core/shortcode` block (`[wpforms id="129"]`) — robust, no dependency on the block being registered.
6. **Done.** Residual CSS in `theme/assets/css/app.css` (enqueued as `tmh-app` on front end + editor). Classic templates deleted: `header.php`, `footer.php`, `front-page.php`, `archive.php`, `single.php`, `page.php`, `404.php`, `index.php`. `style.css` is now a header + note only.
7. **Done in wp-env.** `show_on_front=page`, Home + Blog pages created and assigned. Navigation is inline in `header.html` (no wp-admin menu build needed). `pre_get_posts` filter in `functions.php` keeps the `faq` category out of the blog index. On live these Reading settings must be set again at cutover.
8. **Done.** Browser walk via headless Chrome + CDP at 1280px and 390px: home (all 8 sections), blog, single, page, 404, contact form (WPForms `wpforms/form-selector` block, `formId 129`, styled via `.wpforms-*` in app.css). No horizontal overflow at either width (`scrollWidth === clientWidth`). Fixes applied during the walk: `contentSize` 40rem → 75rem (bands were pinned to the prose measure), `huge` font max 5rem → 4.3rem + `word-break:normal` on the hero h1, force-stack columns < 782px (inline `flex-basis` from the width attr was defeating core stacking), `.tmh-photo` figure `width:100%`, dark scheme removed (deferred), `color-scheme: light`. Lighthouse not yet run.
9. Hand off to Phase 5 (cutover — the plan doc already lists "upload `tmhasselt-core`"). The `design/canvas/` `.dc.html` files are kept as a visual reference for the "turned up" scale.

## Tooling changes

- `.wp-env.json`: add `"wp-content/plugins/tmhasselt-core": "./plugins/tmhasselt-core"` to `mappings`.
- `scripts/ftp.sh`: add `push-plugin` (mirror of `push-theme` for `wp-content/plugins/tmhasselt-core`).
- `package.json`: extend `lint:php` glob to `plugins/`.
- `CLAUDE.md`: Stack table (theme → block theme), Layout (`plugins/`), Commands (`push-plugin`).
