# ShapeShifter Modules

A consolidated WordPress module library featuring a full suite of content blocks and block editor enhancements.

**Author:** [The Elixir Haus](https://www.theelxirhaus.com)  
**Plugin Website:** [shapeshifter-modules.com](https://www.shapeshifter-modules.com)  
**Requires WordPress:** 6.4+  
**Requires PHP:** 8.1+  
**Requires:** Advanced Custom Fields Pro

---

## Overview

ShapeShifter Modules gives you a library of pre-built, highly configurable content blocks registered as Gutenberg blocks. Each module is built around the DarkPhysiCSS utility framework, giving you responsive layout control without leaving the WordPress admin. Modules are managed as a dedicated custom post type and can be embedded anywhere via shortcode.

---

## Modules

### Free

| Module | Description |
|--------|-------------|
| **M1** | Headline & Columned Content — headline, copy, forms, buttons, background images/video, parallax |
| **M4** | Quote |
| **M5** | Accordion |

### Pro (license required)

| Module | Description |
|--------|-------------|
| **M2** | Slideshow or Grid — manual slides, post/page feeds, masonry |
| **M3** | Alternating Columns |
| **M6** | Sticky Column |
| **M7** | Menu List |
| **M8** | Horizontal Rule |
| **M9** | Code Block |
| **M10** | Custom Module Block |

---

## Key Features

- **ACF block registration** — all modules are registered as native Gutenberg blocks via `acf_register_block_type`
- **Reusable Modules CPT** — build modules once, reuse them across any post, page, or template
- **Shortcode embedding** — `[ss-module id="123"]` or `[ss-module id="my-module-slug"]`
- **DarkPhysiCSS integration** — utility CSS framework with responsive grid, spacing, and typography controls configurable from the WordPress admin
- **Video backgrounds** — Vimeo and YouTube background video support on M1 and M2
- **Parallax & image effects** — parallax scrolling, fixed attachment, and image tint overlays
- **Lightbox system** — built-in lightbox for modals and inline content
- **FAQ schema output** — automatic `application/ld+json` FAQ schema generation from M5 accordion content
- **Block editor enhancements** — admin styles, draggable block pane, inline CSS re-pathing for the editor
- **CSS/JS minification** — inline assets are minified at runtime (toggled via `SS_MINIFY`)

---

## Requirements

- WordPress 6.4 or higher
- PHP 8.1 or higher
- [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) — required for block registration, options pages, and field groups

---

## Installation

1. Upload the `shapeshifter-modules` folder to `/wp-content/plugins/`
2. Activate the plugin through **Plugins > Installed Plugins**
3. Ensure ACF Pro is active — ShapeShifter features will not load without it
4. For Pro modules, enter your license key under **Settings > ShapeShifter Modules**

---

## License Activation (Pro)

Pro modules are gated behind a license key validated against the ShapeShifter licensing server. To activate:

1. Get a Pro License at [shapeshifter-modules.com](https://www.shapeshifter-modules.com)
2. Go to **Settings > ShapeShifter Modules**
3. Enter your license key in the License Key field and save
4. The plugin validates the key automatically; on success, Pro blocks become available in the block inserter

The license status is cached indefinitely once validated. It re-checks only when the key is changed.

---

## Support

For support, documentation, and updates visit [shapeshifter-modules.com/](https://www.shapeshifter-modules.com/),
and checkout our Reddit Community [https://www.reddit.com/r/shapeshiftermodules/](r/shapeshiftermodules).
