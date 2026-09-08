---
name: code-reviewer
description: |
  Review theme/plugin PHP, CSS, and templates in the current conversation.
  Use when: "review this", "code review", "check my code", "review changes",
  "is this correct", "look over this code".
allowed-tools: Read,Glob,Grep,Bash
---

<skill_directive>
Start from `git diff` (staged or working tree). Review across:

- **Security**: every echo escaped (`esc_html`, `esc_attr`, `esc_url`,
  `wp_kses_post`), nonces on any form the theme adds, no raw `$_GET`/`$_POST`.
- **WordPress correctness**: template hierarchy, `wp_head`/`wp_footer` present,
  `wp_enqueue_*` not inline tags, `tmh_` prefix, text domain `tmhasselt`,
  translation functions on user-facing strings, no PHP the host lacks.
- **Accessibility**: landmarks, heading order, alt text, focus styles,
  contrast per `design-system`, `prefers-reduced-motion`.
- **Conversion**: does the change make "come and watch" easier or harder.

Report Critical → Warning → Suggestion, each with location, issue, why, fix.
Skip pre-existing issues and pure style.
</skill_directive>
