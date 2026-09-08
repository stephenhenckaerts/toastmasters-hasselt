---
name: planning
description: |
  Turns a chosen direction into a file-level plan grounded in current WordPress
  docs and this theme's existing patterns. Use when: "plan this", "how should
  we implement", "implementation plan", before any multi-file theme change.
---

Ground plans in current docs, not recall: WordPress developer handbook
(Context7 `/kasparsd/wp-docs-md` or `/websites/wordpress`), the wp-env README on
GitHub, plugin pages on wordpress.org. Check `theme/` for the existing shape
(template names, `tmh_` helpers, `inc/meeting.php`, `inc/seo.php`) before
inventing a new one.

The plan lists files to create or modify, the wp-admin steps that go with them
(menus, settings, activation), edge cases (empty archive, no upcoming meeting,
missing thumbnail), and how it is verified in the browser. Where the theme's
current pattern differs from today's WordPress practice, decide Keep / Update /
Defer explicitly. Keep it proportional: a CSS tweak needs a paragraph.
