PROJECT RULES - GAMIFIKASI LMS

This is a WordPress Plugin project with custom frontend architecture.

CORE ARCHITECTURE:

- WordPress is only used as backend CMS
- All frontend pages use custom router system
- No WordPress Pages for application routes
- No shortcode for application pages

ROUTING SYSTEM:

- All pages are handled via includes/router/router.php
- Example routes:
  /login
  /landing
  /dashboard
  /leaderboard
  /quiz
  /profile

FILE STRUCTURE RULES:

- All pages must be inside templates/
- Layout system must use templates/layout/fullwidth.php
- CSS must be inside assets/css/style.css
- JS must be inside assets/js/script.js

DEVELOPMENT RULES:

- Never modify WordPress theme files
- Never use Elementor or page builders
- Never create duplicate CSS files
- Never create duplicate JS files
- Never override router unless required

WORKFLOW RULE:

- Every feature must go through Git (branch → commit → PR → merge)
- No direct push to main

UI RULE:

- Must use prefix "gml-" for all frontend classes
- Must follow existing design system
