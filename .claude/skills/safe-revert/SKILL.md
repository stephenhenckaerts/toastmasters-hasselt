---
name: safe-revert
description: |
  Revert or discard changes behind a patch safety net.
  Use when: "revert", "undo", "roll back", "start over", "discard changes".
---

<skill_directive>
1. **Save** first: `TS=$(date +%s); git diff --cached > "$SCRATCH/safe-revert-$TS.staged.patch"; git diff > "$SCRATCH/safe-revert-$TS.patch"`; copy untracked files the revert would touch.
2. **Show** what will be reverted and the scope.
3. **Confirm** scope with Stephen.
4. **Revert** — prefer `--soft`; `git checkout HEAD -- <file>` for single files.
5. **Verify** and give the recovery command (`git apply <patch>`).

Live-site reverts are not git: re-activate the previous theme in wp-admin, or
re-import the last Prime Mover package. Never delete a backup to "clean up".
</skill_directive>
