---
name: live-verify
description: |
  Drive the local wp-env site or the live club site in a real browser to confirm
  a UI or behaviour claim — screenshots, console, network, mobile width.
  Use when: "check it in the browser", "take a look at localhost:8888",
  "verify the fix", "why does this look wrong", "test it yourself", or whenever
  a UI claim is about to be reported as done.
---

<skill_directive>
A UI claim is unverified until it has been seen in a browser. Reading PHP,
curling a URL, or reasoning from a diff does not count.

1. **Local first.** `npm start` if nothing listens on 8888
   (`lsof -nP -iTCP:8888 -sTCP:LISTEN`); wp-env is single-owner and safe to
   restart. Log in at `/wp-login.php` with admin / password.
2. **Live is read-only from the browser** unless the task says otherwise.
   Production URL https://www.toastmastershasselt.be. wp-admin login is
   Stephen's; ask for it rather than guessing.
3. **Walk every template, not the happy path:** front page, `/faq/`, `/blog/`,
   one post, one static page, 404, the contact form (submit on local only),
   the primary and footer menus, the next-meeting date.
4. **Widths:** 390px mobile, 768px, 1280px. Scan for horizontal overflow:
   `[...document.querySelectorAll('*')].filter(n => n.scrollWidth > n.clientWidth + 1)`.
5. **Report evidence, not conclusions:** screenshot, console messages, DOM probe.
   Save screenshots under `screenshots/` (gitignored), never at the repo root.
6. Playwright MCP is the default tool. Never write a standalone script.
</skill_directive>

## Pitfalls

- Reported a fix from the code without opening the browser → open the browser.
- Checked only the front page → the 404 and archive templates break separately.
- Verified on a retina Mac only → check the 390px viewport for the hero.
