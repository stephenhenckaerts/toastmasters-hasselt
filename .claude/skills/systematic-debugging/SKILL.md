---
name: systematic-debugging
description: |
  Root-cause debugging for WordPress/PHP/CSS issues on this site.
  Use when: "not working", "broken", "white screen", "fails", "error",
  "debug", "investigate", "fix", "looks wrong", a plugin or template misbehaves.
---

<skill_directive>
REPRODUCE → ISOLATE → ROOT CAUSE → FIX. No code before all four.

1. **Reproduce** locally in wp-env with the same content. Exact URL, expected vs actual.
2. **Isolate** the layer: PHP fatal (`wp-content/debug.log`, `npm run wp -- eval`),
   template selection (which file rendered — Template Hierarchy), plugin
   conflict (deactivate in halves), CSS (DevTools computed styles), data
   (does the post/page/menu/category exist and is it published).
3. **Root cause**: ask "why" until the answer is a line of code or a setting.
4. **Fix** minimally, re-verify in the browser, then check the sibling templates.

Three failed fixes in a row means the model of the problem is wrong. Stop and re-isolate.
</skill_directive>

## Common root causes here

| Symptom | Likely cause |
|---|---|
| Category archive shows an empty page | A page with the same slug shadows the archive (happened with `faq`/`blog`) |
| White screen | PHP fatal; read `debug.log`; a syntax the host's PHP lacks |
| Menu missing | Location registered but no menu assigned in Appearance → Menus |
| Form mail missing | WPForms notification "Send To" or SPF; check WP Mail Logging |
| Wrong meeting date | `inc/meeting.php` DST or "1st/3rd Tuesday" logic |
| Theme upload via wp-admin does nothing | Known host quirk since Aug 2026; use FTP |
