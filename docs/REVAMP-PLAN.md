# KG Studios revamp: brainstorm, sitemap and roadmap

Status: proposal. Nothing here is built yet. Items marked **(my call)** are decisions I made on your behalf; change any of them.

## 1. The idea

KG Studios sells presentations that win rooms. The site should behave like one.

**Concept: "The site is a deck."**
- Every section is a slide. A slide counter (`03 / 12`) sits in the corner, arrow keys and scroll both advance, and transitions are 3D slide moves, not generic fades.
- The signature story is **chaos to clarity**: cluttered slides drift in 3D, then snap into one sharp, aligned layout as you scroll. It is the "KG Studios Effect" turned from a slider into the whole experience.
- Gold (`#d8a53e`) stays as the brand accent. Add light "paper" sections between dark ones, because real decks are mostly light and the contrast makes the dark scenes feel richer **(my call)**.

**Primary goal (my call):** get a qualified brief. Main button everywhere: "Get a quote". Secondary: "Book a 20-minute call". Everything else supports trust or findability.

**Anti-goals:** a site that is slow on a client's laptop or phone; motion that hides the message; 3D with no meaning; a look that any agency could have.

## 2. Sitemap

```
/ Home
├── /services/                          Services hub
│   ├── /services/presentation-design/  hub
│   │   ├── pitch-and-investor-decks
│   │   ├── sales-and-marketing-decks
│   │   ├── event-and-conference-keynotes
│   │   ├── proposal-and-consulting-decks   (SteerCo, leadership updates)
│   │   ├── annual-and-esg-reports
│   │   ├── presentation-templates          (Copilot-compatible)
│   │   ├── outsourced-presentation-design  (retainer / managed service)
│   │   ├── presentation-training
│   │   └── dam-and-web-add-ins
│   ├── /services/brand-identity/
│   │   └── logo-and-visual-identity, brand-guidelines, employer-branding,
│   │       marketing-collaterals, packaging-design
│   └── /services/digital-design/
│       └── website-ux-ui, landing-pages-and-microsites,
│           social-media, campaign-creatives-and-interactives
├── /who-we-serve/
│   ├── startups-and-founders
│   ├── corporate-and-enterprise-teams
│   ├── consulting-firms
│   └── white-label-partners            (agencies and consultancies that resell decks)
├── /work/                              Case studies (filter by service, industry)
│   └── /work/{case-study}/             Template: challenge, approach, before/after, motion, result, quote
├── /process/                           How we work: brief, story, design, motion, delivery, NDA and security
├── /pricing/                           Engagement models + quote calculator (or "from" ranges)
├── /about/
│   ├── /about/team/  (+ /about/team/{person}/ optional)
│   └── /about/careers/
├── /insights/                          Blog
│   ├── /insights/{post}/
│   └── /insights/category/{topic}/
├── /resources/                         Guides and free templates (email-gated lead magnets)
├── /faq/
├── /contact/                           Contact, book a call, request a quote (with file upload)
│   └── /contact/thank-you/             noindex, fires the conversion event
├── /locations/                         Only for places you really serve
│   └── gurgaon, delhi-ncr, mumbai, bengaluru, dubai, abu-dhabi, riyadh
├── /lp/{campaign}/                     Paid-ad landing pages, noindex
└── Utility
    ├── /privacy-policy/  /terms/  /cookie-policy/  /confidentiality-and-nda/
    ├── /accessibility/   /sitemap/ (HTML)   /search/   404
```

**Header menu:** Services, Work, Who we serve, Process, Insights, About, then the "Get a quote" button.
**Footer:** services list, company, resources, legal, contact, social, newsletter.

### XML sitemap and indexing
- Keep one SEO plugin (Yoast or Rank Math) to produce `/sitemap_index.xml`. The old site already uses Yoast-style files. The theme should not duplicate it.
- Submit it in Search Console (the property is already verified).
- Set `noindex` on: thank-you, search, `/lp/*`, tag archives, and author archives. The old site exposes an author sitemap, which leaks usernames and adds thin pages. Turn author archives off.
- Add an HTML `/sitemap/` page and breadcrumbs with `BreadcrumbList` schema.
- Add 301 redirects for every old URL that changes. The old site had `/` and `/hello-world/`; delete "Hello World".

## 3. Pages, one by one (what each should do)

| Page | Job | Key blocks |
|---|---|---|
| Home | Win trust in 10 seconds, route to a brief | 3D hero, audience switcher (founder / corporate / consulting), chaos-to-clarity scroll story, services, named client logos, 2 case study teasers, stats, team, testimonials, quote CTA |
| Services hub | Explain what you do, route to the right sub-page | 3 pillars, each with its own mini 3D scene |
| Service pages | Rank for the search term and convert | Who it is for, outcome, process, 2 examples, FAQ, price range, CTA |
| Work + case study | Prove it | Filters, big visuals, before/after, results, client quote, next case |
| Who we serve | Match the visitor's own situation | Pain points, relevant services and work, one testimonial |
| Process | Remove fear | 5 steps with timelines, tools, turnaround, NDA and security |
| Pricing | Qualify leads and cut tyre-kickers | Engagement models (per deck, retainer, template system), quote calculator |
| About / Team | Show the consulting DNA | Story, BCG / KPMG / ZS background, values, people, careers |
| Insights / Resources | Search traffic and lead capture | Guides, teardowns, gated templates |
| FAQ | Answer objections and win rich results | `FAQPage` schema |
| Contact | Convert | Multi-step brief, file upload, calendar, WhatsApp, email, address |

## 4. Motion and 3D catalogue

Cost = build effort and runtime weight. Wow = visitor impact.

| # | Idea | Where | Tech | Cost | Wow |
|---|---|---|---|---|---|
| 1 | **3D slide stack hero**: your real slide images as floating planes, parallax with the cursor | Home hero | Three.js, lazy-loaded | M | High |
| 2 | **Chaos to clarity**: scattered slides snap into a clean grid as you scroll (pinned, scrubbed) | Home | GSAP ScrollTrigger + the 3D scene | M | Very high |
| 3 | **Logo preloader**: the KG logo draws itself, then the page opens (under 1.2 s, skippable) | Site entry | SVG path animation | S | Medium |
| 4 | Slide-style page transitions | All pages | View Transitions API with fallback | S | Medium |
| 5 | Smooth scroll, text-split reveals, scroll-speed marquee | Everywhere | Lenis + GSAP | S | Medium |
| 6 | Custom cursor with labels ("Drag", "View", "Play") | Desktop | CSS + JS | S | Medium |
| 7 | Service cards with a tiny 3D object each: rising chart (decks), rotating logo cube (brand), floating browser frame (digital) | Services | Three.js or CSS 3D | M | High |
| 8 | Case study scroller with image ripple on hover | Work | OGL (small WebGL) | M | High |
| 9 | 3D flip before/after | Work, case studies | CSS 3D | S | Medium |
| 10 | Template library coverflow | Resources | CSS 3D | S | Medium |
| 11 | **"Fix this slide" mini-game**: drag messy blocks onto a grid, then see the real result | Home or Work | JS drag and drop | M | Very high, shareable |
| 12 | Gold dust particles | Hero, CTA | Canvas 2D | S | Low |
| 13 | Showreel video (60 s) with motion-led deck work | Home, About | Compressed video, poster first | M | High |

**Guardrails (non-negotiable):**
- 3D loads only after first paint and only on capable devices (not on `saveData`, low CPU core count, or `prefers-reduced-motion`). Everyone else gets a polished still image.
- Targets: LCP under 2.5 s, CLS under 0.1, INP under 200 ms, 3D chunk under about 150 KB gzipped, 60 fps on a mid-range laptop.
- A visible "reduce motion" toggle. Content is never hidden behind an animation.
- All libraries are self-hosted in `assets/vendor`, not loaded from CDNs, for speed and privacy.

## 5. Things you may have missed

**Trust and proof**
1. Case studies with real results. Many decks are under NDA, so use anonymised cases or ask clients for written approval.
2. Named client logos. Today the logos are unlabelled files (`chill`, `ei`, `gen`, `ic`, `indi-closet`, `midlife-baithak`, `ot`, `vis`, `vo`). Add the names, plus any awards, press, or certifications.
3. A 60-second showreel.

**Conversion**
4. Thank-you page and GA4 events: `form_submit`, `quote_calculator_used`, `whatsapp_click`, `book_call_click`.
5. WhatsApp click-to-chat. It is the main channel for India and the Middle East.
6. Calendar booking (Calendly, Cal.com, or Zoho Bookings).
7. Auto-reply email to the lead, plus an instant alert (email, Slack, or WhatsApp) to your team.
8. CRM hookup (HubSpot, Zoho, or Notion) so leads do not live only in WordPress. Today they sit under **Leads** in the admin.
9. Bot protection on forms: Cloudflare Turnstile or reCAPTCHA.

**Growth ideas for KG Studios specifically**
10. **White-label partner page.** Consulting firms and agencies already outsource deck work. This is a B2B2B channel.
11. **Template shop.** Sell Copilot-compatible PowerPoint templates. It is new revenue and strong SEO.
12. Free tools that attract searches and leads: quote calculator, "Score my deck" audit, pitch deck checklist.
13. Location pages for Gurgaon, Delhi NCR, Dubai and so on. Only for places you genuinely serve, or Google may treat them as doorway pages.

**Search and technical**
14. Schema: `Organization`, `ProfessionalService`, `Service`, `FAQPage`, `Review`, `BreadcrumbList`. Open Graph images per page.
15. Image pipeline: WebP/AVIF, responsive sizes, lazy loading, CDN. The current PNGs and JPEGs are fine for launch but not for case-study-heavy pages.
16. Staging site, backups, and a rollback plan. WP Pusher deploys on every push, so protect `main` and deploy from a `staging` branch first.
17. Editing without code: custom post types (Case Study, Team, Testimonial, Service) with editable fields, so you do not need a developer for every change. This matters because you are leaving Elementor.

**Compliance and access**
18. Cookie consent with Google Consent Mode v2. GA4 plus form data brings India's DPDP Act, and the UAE and Saudi data-protection laws, into play. Add Privacy, Terms and Cookie pages.
19. WCAG 2.2 AA: keyboard navigation, contrast, focus states, alt text, motion toggle.
20. **Arabic / RTL** version for the Middle East. Large effort. Build the theme RTL-ready now (logical CSS properties) and decide on launch later.
21. Social profiles: add the real LinkedIn, Instagram and Facebook URLs. Consider Behance, Dribbble and YouTube for the showreel. Right now the footer hides them because none are set.
22. Microsoft Clarity (free heatmaps and recordings) to see where visitors get stuck.

## 6. Design system direction (my call)

- **Type:** pair a high-contrast display serif for big headlines (for example Instrument Serif or Fraunces) with Inter for body. It reads as "consulting meets design" and avoids the common sans-only agency look. Montserrat stays only if you want continuity with the current brand.
- **Colour:** near-black `#0a0c10`, paper `#f6f3ec`, gold `#d8a53e`, teal `#00a39b` as a rare accent.
- **Layout:** large type, generous space, a 12-column grid, slide-number HUD, hairline rules like a consulting deck.
- **Motion language:** ease-out, 600-900 ms, one signature move (slide snap), no bounce.

## 7. Technical direction

- Keep the custom theme (no page builder). Add custom post types for Case Study, Team and Testimonial; use native blocks for the blog.
- Libraries: GSAP + ScrollTrigger, Lenis, Three.js (or OGL for light WebGL), all self-hosted. A small build step (Vite) produces `assets/dist/`, which is committed so WP Pusher can deploy without a server build.
- Keep `kg_process_lead()` and the **Leads** post type; add file upload (size and type limits) and the CRM webhook.
- RTL-ready CSS from day one.

## 8. Roadmap (rough effort, not a promise)

| Phase | Scope | Effort |
|---|---|---|
| 0. Foundations | Content inventory, URL map and 301s, design tokens, custom post types, consent + GA4 events, staging | about 1 week |
| 1. Core rebuild | Home v2, Services hub + 3 pillars + presentation sub-pages, Work + 3 case studies, Who we serve, Process, About/Team, FAQ, Contact + quote form, legal pages, schema, performance pass | 2-3 weeks |
| 2. Wow layer | 3D hero, chaos-to-clarity scroll story, cursor, page transitions, preloader, quote calculator, mini-game | 2 weeks |
| 3. Growth | Insights and resources with lead magnets, location pages, white-label page, pricing, template shop, Arabic/RTL | 3+ weeks |

Ship phase 1 first, then add phase 2 on top. The site is already usable at the end of phase 1.

## 9. What I need from you

1. Two or three case studies, with permission, or a decision to anonymise them.
2. Client names behind each logo.
3. Real social URLs, a WhatsApp number, and a booking link.
4. Do you serve the Middle East in Arabic, and is an Arabic site wanted?
5. Public pricing, "from" ranges, or quote-only?
6. Which locations you genuinely serve, for location pages.
7. Do you want to sell templates, and take partner (white-label) work?
8. Any competitor or reference sites you like or dislike.
