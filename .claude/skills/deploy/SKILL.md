---
name: deploy
description: |
  Push the theme to the live Combell host over FTP and activate it. Manual only.
  Use when: "/deploy", "push the theme", "deploy to live", "upload the theme".
disable-model-invocation: true
---

<skill_directive>
Order matters; each step is reversible until activation.

1. Confirm a fresh content backup exists today (Prime Mover package or
   Tools → Export in wp-admin). No backup, no deploy.
2. `npm run lint:php` clean. Theme verified locally (`live-verify`).
3. `npm run ftp -- ls wp-content/themes` — confirm reads work and note what is there.
4. `npm run ftp -- push-theme` — uploads `theme/` to
   `wp-content/themes/toastmasters-hasselt/`. Nothing changes visibly yet.
   A `550 Operation not permitted` means the FTP user still lacks write rights;
   stop and ask the admin to tick "Write permissions" in the Combell panel.
5. Activate in wp-admin → Appearance → Themes in the browser. Rollback is
   activating the previous theme on the same screen.
6. Walk the live site with `live-verify` (all templates, mobile width, form).
7. Report what changed, with screenshots. Rotate the FTP password afterwards
   if plain FTP was used (the server refuses TLS).
</skill_directive>
