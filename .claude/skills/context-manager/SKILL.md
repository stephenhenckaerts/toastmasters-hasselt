---
name: context-manager
description: |
  Records durable cross-session context into Claude auto-memory.
  Use when: "save context", "end of session", "pick up later", "where were we",
  "resume work", "continue tomorrow".
---

<skill_directive>
Continuity lives in `~/.claude/projects/<this-path>/memory/`, one topic per file
with frontmatter and a pointer line in `MEMORY.md`. Save what the repo does not
already record: open decisions, blockers (access, admin asks), live-site state,
absolute dates. On resume, summarise where work stopped and verify any named
file or setting still exists before acting. No session files in the repo.
</skill_directive>
