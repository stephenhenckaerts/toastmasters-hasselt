---
name: design-system
description: |
  Toastmasters Hasselt visual system — brand palette (paint vs ink), type,
  spacing, motion, logo rules. Use for any UI work: templates, CSS, theme.json,
  block patterns, design review, colours, spacing, the design canvas.
---

## Audience

Adults in Limburg who are nervous about speaking in public and are deciding
whether to show up on a Tuesday evening. Warm, credible, low-threshold. The site
must answer "kan ik gewoon eens komen kijken?" within one screen.

## Paint vs ink

**Loyal Blue is the only colour allowed to occupy area.** Maroon is ink: glyphs,
rules, marks, never a fill, so the two darks never share an edge. The official
maroon `#772432` sits at 1.07:1 against Loyal Blue; the lifted `#A03C4B` keeps
the hue and adds 15 L*. Yellow only on dark grounds (1.24:1 on light fails WCAG
1.4.11). Neutrals derive from Loyal Blue's hue (241.7°), not Cool Gray's 189°.

| Token | Value | Role |
|---|---|---|
| `--blue` | `#004165` | Loyal Blue, official. Paint: hero, bands, buttons |
| `--blue-lift` | `#006094` | Blissful Blue, official. Hover, links on light |
| `--blue-deep` / `--blue-950` | `#00314E` / `#001626` | Depth inside blue areas |
| `--maroon` | `#A03C4B` | Ink only: headings accents, rules, icons |
| `--maroon-deep` | `#772432` | True Maroon, official. Small print only |
| `--yellow` | `#F2DF74` | Happy Yellow, official. Dark grounds only |
| `--ground` / `--surface` / `--surface-2` | `#F5F5F5` / `#FFFFFF` / `#E7E9E9` | Fair Gray page, white cards |
| `--ink` / `--ink-2` / `--ink-3` | `#1A1A1A` / `#5B656D` / `#788289` | Text, secondary, hints (non-text only) |
| `--line` / `--line-strong` | `#DADEDD` / `#CBD0D0` | Rules and borders |
| `--green` / `--amber` / `--red` | `#2F7D52` / `#8A6410` / `#A33327` | Status |

Dark scheme exists in `theme/style.css` (`prefers-color-scheme` + `data-theme`);
maroon lightens to `#D08A96` there.

## Type and rhythm

Source Serif 4 for display, Source Sans 3 for body. Fluid scale `--t-0` … `--t-4`
with max ≤ 2.5× min so 500% zoom stays legible. Measure 60ch. Body ≥ 1.13rem.

## Rules that survive any redesign

- Official Toastmasters International logo unaltered; custom club logos are a
  chartered-club violation. Both required TI footer strings stay.
- Contrast ≥ 4.5:1 for text, ≥ 3:1 for UI; "hint at" the brand is enough,
  strict brand compliance was relaxed by Stephen.
- Photos: real club evenings only, consent confirmed before any face goes up.
- Motion purposeful and short; respect `prefers-reduced-motion`.
- Single primary call to action per screen: come and watch a meeting.

## Sources of truth

`theme/style.css` `:root` block; `design/prototype.html` (August 2026 canvas);
Toastmasters brand manual for official values.
