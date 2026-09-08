---
name: commit
description: |
  Commit workflow for this solo repo. Use when: "commit this", "commit and
  push", "ready to commit", "let's commit".
---

<skill_directive>
1. `git status` and `git diff --staged`: no secrets, no screenshots, nothing
   from `private/` or `backups/` (gitignored, but check).
2. `npm run lint:php` if PHP changed.
3. Conventional message: `feat(theme): …`, `fix(faq): …`, `docs: …`,
   `chore(wp-env): …`. One topic per commit; propose a split otherwise.
4. Push only when asked. No changesets, no MRs; `main` is fine.
5. If the session produced a durable lesson, save it to auto-memory first.
</skill_directive>
