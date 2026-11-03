# KG Studios WordPress theme (v2)

Custom theme for [kgstudios.io](https://kgstudios.io/). No page builder, no plugins required, no JS libraries.

**Design: colour chapters.** Every section is a full-bleed field in one flat brand colour (gold, ink, paper, teal), like slides in a deck. League Spartan + Figtree, square corners, no rules, gradients or resting shadows. Field classes: `f-gold`, `f-ink`, `f-paper`, `f-teal`; components read the roles those set (`--bg --fg --soft --tile --accent --on`), so neighbouring sections should always use different fields.

## Install
Repo root is the theme folder. Install it (zip, or WP Pusher) as `wp-content/themes/KG-Studios`, then activate. Test on staging first.

On activation (and once per theme version) the theme creates the page tree and two menus if they are missing. It never overwrites existing pages or menus:
Services (Presentation Design with 9 sub-pages, Brand Identity, Digital Design), Who We Serve (3 pages), Our Work, Process, Pricing, FAQ, About, Insights, Contact (+ Thank you), Sitemap.

## Structure
- `front-page.php`: home. Other hand-built pages: `page-work|about|process|pricing|faq|contact|insights|thank-you|sitemap.php`.
- `inc/pages-data.php`: copy and tree for every data-driven page (services, audiences). `page.php` renders them through `template-parts/landing.php`. Edit copy here.
- `inc/content.php`: home-page copy (team, testimonials, clients, why-us).
- `inc/post-types.php`: **Case studies** post type (client, service, result, before/after images). They appear on the Work page.
- `inc/contact-form.php`: multi-step lead form. Saves each enquiry under **Leads**, emails it, then redirects to the Thank you page.
- `inc/seo.php`: JSON-LD (Organization, Service, FAQ, Breadcrumb), description and social tags when no SEO plugin is active, `noindex` on the thank-you page, author archives redirected.
- `assets/css/main.css` (base) and `assets/css/motion.css` (3D, scroll scene, game, paper sections); `assets/js/main.js` (reveals, sliders, form) and `assets/js/motion.js` (3D hero, scene, cursor, game, calculator, consent).

## Settings (Appearance → Customize)
- *KG Studios contact & social*: email, phone, WhatsApp (shows a chat button), booking link (shows a "Book a call" button), address, social URLs.
- *KG Studios quote calculator*: per-slide rates. Leave blank to hide the calculator on Pricing.

## SEO
- `inc/seo.php`: per-page titles (about 60 characters) and descriptions (about 155) in `kg_seo_table()`, applied even when Yoast is active; JSON-LD for the agency (with service catalogue and founder), each service, FAQs and breadcrumbs; robots rules (thank-you page and the default "Hello world" post are noindexed and kept out of sitemaps; author archives redirect home); `llms.txt` for AI search at `/llms.txt`.
- Images are served as WebP when a `.webp` twin exists next to the original (about 45% smaller).
- After deploying: Search Console → Sitemaps → submit `sitemap_index.xml`, then request indexing for the home page.

## Notes
- Analytics: GA4 and Search Console tags are in `inc/setup.php` with Consent Mode v2 and a cookie banner. Do not also run Site Kit's tag.
- Footer legal links (Privacy, Terms, Cookie policy, Confidentiality, Accessibility) appear when pages with those slugs exist.
- Motion respects `prefers-reduced-motion`, and there is a "Reduce motion" switch in the footer.
- Mail uses `wp_mail()`. Install an SMTP plugin for reliable delivery.
- Checks (staging, WP-CLI): `wp eval-file wp-content/themes/KG-Studios/tests/contact-form.php` and `.../tests/pages-data.php`.
- Roadmap and sitemap rationale: `docs/REVAMP-PLAN.md`.
