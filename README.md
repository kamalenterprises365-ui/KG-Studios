# KG Studios WordPress theme

Custom theme for [kgstudios.io](https://kgstudios.io/). No page builder or plugins required.

## Install
Repo root is the theme folder. Zip it (or connect it via your GitHub integration) into `wp-content/themes/kg-studios`, then activate.

On activation the theme creates Home, Services, Our Work, About and Contact pages (if missing), sets Home as the static front page (if no static page is set), and builds a primary menu.

## Structure
- `front-page.php`, `page-services.php`, `page-work.php`, `page-about.php`, `page-contact.php`: page templates, picked by page slug.
- `template-parts/`: reusable sections (hero, logos, services, why-us, before/after, team, testimonials, CTA).
- `inc/content.php`: all site copy and image names.
- `inc/contact-form.php`: multi-step lead form, emails the address set in the Customizer.
- `assets/css/main.css`, `assets/js/main.js`: styles and animations (no libraries).

## Settings
Appearance → Customize → *KG Studios contact & social*: email, phone, address, Facebook / Instagram / LinkedIn URLs.

## Notes
- Form mail uses `wp_mail()`. Install an SMTP plugin for reliable delivery.
- Animations respect `prefers-reduced-motion`.
