# planetOzh WordPress Theme

A clean, colorful personal blog theme with dark/light mode, responsive layout, and category color badges.

## Features

- **Dark / Light mode** — toggle button in header, persists via `localStorage`, respects `prefers-color-scheme`
- **Responsive** — 2-column layout (content + sidebar) collapsing to single column below 860px
- **Hero section** — full-width on front page, customizable via Customizer
- **Category color badges** — 6 rotating colors assigned automatically by category ID
- **Featured first post** — first post on the list gets a card treatment
- **Estimated reading time** — calculated from word count
- **Customizer options** — hero text/badges, about block, footer copyright
- **Widget areas** — Main Sidebar + Footer Area
- **Menus** — Primary (header) + Footer

## Installation

1. Upload the `planetozh` folder to `/wp-content/themes/`
2. Activate in **Appearance → Themes**
3. Go to **Appearance → Menus** to set up navigation
4. Go to **Appearance → Widgets** to add sidebar widgets
5. Go to **Appearance → Customize** to configure the Hero and About sections

## Customizer Panels

| Panel | Settings |
|---|---|
| Hero Section | Kicker text, title (HTML OK), description, badges |
| Sidebar About Block | Display name, short bio |
| Footer | Copyright text |

## Category Colors

Colors cycle through 6 presets based on category ID:

| Color | Hex |
|---|---|
| Violet | `#8b5cf6` |
| Sky blue | `#0ea5e9` |
| Amber | `#f59e0b` |
| Green | `#10b981` |
| Pink | `#ec4899` |
| Orange | `#f97316` |

## File Structure

```
planetozh/
├── style.css               # Theme header + all CSS
├── functions.php           # Theme setup, enqueue, widgets, helpers
├── index.php               # Post list (home/archive)
├── single.php              # Single post
├── page.php                # Static page
├── sidebar.php             # Sidebar
├── header.php              # Header
├── footer.php              # Footer
├── comments.php            # Comments
├── search.php              # Search results
├── 404.php                 # Not found
├── template-parts/
│   └── hero.php            # Hero section partial
├── inc/
│   ├── fallback-menu.php   # Fallback nav menu
│   └── placeholder.php
└── assets/
    └── js/
        └── theme-toggle.js # Dark/light mode JS
```

## Screenshot

Add a `screenshot.png` (1200×900px) to the theme root for the WP admin preview.

## License

GNU General Public License v2 or later — https://www.gnu.org/licenses/gpl-2.0.html

