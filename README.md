# KG Studios WordPress theme

Custom theme for [kgstudios.io](https://kgstudios.io/). No page builder or plugins required.

## Install
Repo root is the theme folder. Zip it (or connect it via your GitHub integration) into `wp-content/themes/kg-studios`, then activate.

On activation the theme creates Home, Services, Our Work, About and Contact pages (if missing) and builds a primary menu. The home page is always `front-page.php`.

## Structure
- `front-page.php`, `page-services.php`, `page-work.php`, `page-about.php`, `page-contact.php`: page templates, picked by page slug.
- `template-parts/`: reusable sections (hero, logos, services, why-us, before/after, team, testimonials, CTA).
- `inc/content.php`: all site copy and image names.
- `inc/contact-form.php`: multi-step lead form, emails the address set in the Customizer.
- `assets/css/main.css`, `assets/js/main.js`: styles and animations (no libraries).

## Settings
Appearance → Customize → *KG Studios contact & social*: email, phone, address, Facebook / Instagram / LinkedIn URLs.

## Notes
- Every enquiry is saved under **Leads** in the admin and emailed with `wp_mail()`. Install an SMTP plugin for reliable delivery.
- Test the form handler on staging: `wp eval-file wp-content/themes/KG-Studios/tests/contact-form.php`.
- Animations respect `prefers-reduced-motion`.
