📌 Component: App.jsx
🔹 Purpose
Top-level app wrapper that mounts the router.

🔹 Data Required
{}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
No dynamic data; purely structural. No SEO usage here.

📌 Component: AppRouter.jsx
🔹 Purpose
Defines route structure and nested page mapping.

🔹 Data Required
{}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Routing is static; no API required unless routes become CMS-driven.

📌 Component: MainLayout.jsx
🔹 Purpose
Shared layout container for header, footer, and routed content.

🔹 Data Required
{}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
No data or SEO; structural only.

📌 Component: Header.jsx
🔹 Purpose
Primary navigation with dropdown services, about links, and CTA.

🔹 Data Required
{
"brandName": "string",
"navLinks": [
{
"label": "string",
"path": "string"
}
],
"aboutMenu": [
{
"label": "string",
"path": "string"
}
],
"serviceGroups": [
{
"key": "string",
"items": [
{
"label": "string",
"slug": "string"
}
]
}
],
"cta": {
"label": "string",
"path": "string"
}
}

🔹 API Contract
METHOD: GET /api/v1/navigation/header

Response Example
{
"success": true,
"data": {
"brandName": "CreativeNconcepts",
"navLinks": [
{ "label": "Home", "path": "/" },
{ "label": "Journey", "path": "/modular-journey" },
{ "label": "Projects", "path": "/projects" },
{ "label": "Testimonials", "path": "/testimonials" },
{ "label": "Contact", "path": "/contact" }
],
"aboutMenu": [
{ "label": "Who We Are", "path": "/about/who-we-are" },
{ "label": "Our Team", "path": "/about/our-team" },
{ "label": "Our Office", "path": "/about/our-office" }
],
"serviceGroups": [
{ "key": "Kitchen", "items": [{ "label": "Modular Kitchen", "slug": "kitchen" }] }
],
"cta": { "label": "Book Consultation", "path": "/contact" }
}
}

🔹 Admin Actions Needed
Edit
Reorder
Toggle status

🔹 Notes
Public data. Dropdown group ordering matters. No SEO usage.

📌 Component: Footer.jsx
🔹 Purpose
Footer brand description, contact info, social links, quick links, and service links.

🔹 Data Required
{
"brandName": "string",
"description": "string",
"contact": {
"address": "string",
"phone": "string",
"email": "string",
"hours": "string"
},
"socialLinks": [
{ "label": "string", "url": "string" }
],
"quickLinks": [
{ "label": "string", "path": "string" }
],
"serviceLinks": [
{ "label": "string", "path": "string" }
],
"legalLinks": [
{ "label": "string", "url": "string" }
],
"copyright": "string"
}

🔹 API Contract
METHOD: GET /api/v1/navigation/footer

Response Example
{
"success": true,
"data": {
"brandName": "CreativeNconcepts",
"description": "CreativeNconcepts brings bespoke interior expertise...",
"contact": {
"address": "Shed No. 9...",
"phone": "+91 98765 43210",
"email": "hello@creativenconcepts.com",
"hours": "Mon - Sat: 09.00 to 18.00 · Sunday Closed"
},
"socialLinks": [{ "label": "Instagram", "url": "https://..." }],
"quickLinks": [{ "label": "Home", "path": "/" }],
"serviceLinks": [{ "label": "Modular Kitchen", "path": "/services/kitchen" }],
"legalLinks": [{ "label": "Privacy Policy", "url": "/privacy" }],
"copyright": "© 2024 CreativeNconcepts. All rights reserved."
}
}

🔹 Admin Actions Needed
Edit
Reorder
Toggle status

🔹 Notes
Public data. Social and legal links should be editable.

📌 Component: Home.jsx
🔹 Purpose
Homepage assembly of hero, ethos section, previews, and CTA.

🔹 Data Required
{
"ethos": {
"eyebrow": "string",
"title": "string",
"description": "string",
"ctaLabel": "string",
"ctaPath": "string",
"imageLeft": "string",
"imageRight": "string",
"stats": [
{ "value": "string", "label": "string" }
]
}
}

🔹 API Contract
METHOD: GET /api/v1/pages/home

Response Example
{
"success": true,
"data": {
"ethos": {
"eyebrow": "Our Ethos",
"title": "We build narratives through structure and light.",
"description": "At CreativeNconcepts...",
"ctaLabel": "The Creative Story",
"ctaPath": "/about/who-we-are",
"imageLeft": "https://...",
"imageRight": "https://...",
"stats": [
{ "value": "12+", "label": "Design Awards" },
{ "value": "500+", "label": "Happy Clients" }
]
}
}
}

🔹 Admin Actions Needed
Edit

🔹 Notes
Public data; no SEO in component.

📌 Component: Hero.jsx
🔹 Purpose
Homepage hero slider with rotating slides and CTAs.

🔹 Data Required
{
"slides": [
{
"image": "string",
"eyebrow": "string",
"title": "string",
"subtitle": "string"
}
],
"ctaPrimary": { "label": "string", "path": "string" },
"ctaSecondary": { "label": "string", "path": "string" },
"autoRotateMs": "number"
}

🔹 API Contract
METHOD: GET /api/v1/hero-slides

Response Example
{
"success": true,
"data": {
"slides": [
{
"image": "https://...",
"eyebrow": "Bespoke Architectural Excellence",
"title": "CreativeNconcepts",
"subtitle": "Designing Spaces. Creating Experiences."
}
],
"ctaPrimary": { "label": "Book Free Consultation", "path": "/contact" },
"ctaSecondary": { "label": "View Portfolio", "path": "/projects" },
"autoRotateMs": 6500
}
}

🔹 Admin Actions Needed
Create
Edit
Delete
Reorder
Toggle status

🔹 Notes
Public data. Slides are a list. No SEO usage.

📌 Component: ServicesPreview.jsx
🔹 Purpose
Home section previewing featured services.

🔹 Data Required
{
"section": {
"eyebrow": "string",
"title": "string",
"description": "string"
},
"featuredServiceIds": ["string"],
"services": [
{
"id": "string",
"title": "string",
"category": "string",
"shortDescription": "string",
"bannerImage": "string"
}
]
}

🔹 API Contract
METHOD: GET /api/v1/services/featured

Response Example
{
"success": true,
"data": {
"section": {
"eyebrow": "What We Offer",
"title": "Architectural Design Solutions",
"description": "Precision-led..."
},
"featuredServiceIds": ["kitchen", "living-room"],
"services": [
{
"id": "kitchen",
"title": "Modern Modular Kitchen",
"category": "Residential",
"shortDescription": "Functional, elegant and intelligent cooking spaces.",
"bannerImage": "https://..."
}
]
}
}

🔹 Admin Actions Needed
Edit
Reorder
Toggle status

🔹 Notes
Public data. Ordering controls which services show.

📌 Component: Deliverables.jsx
🔹 Purpose
Home section highlighting service commitments and benefits.

🔹 Data Required
{
"leadTitle": "string",
"leadLogo": "string",
"leadPoints": [
{ "title": "string" }
],
"cta": {
"label": "string",
"path": "string"
},
"cards": [
{
"title": "string",
"copy": "string",
"tone": "string",
"icon": "string"
}
]
}

🔹 API Contract
METHOD: GET /api/v1/home/deliverables

Response Example
{
"success": true,
"data": {
"leadTitle": "Our Service Commitments",
"leadLogo": "⌂",
"leadPoints": [{ "title": "Well Considered Design" }],
"cta": { "label": "Make An Appointment", "path": "/contact" },
"cards": [
{ "title": "Experienced Team", "copy": "Seasoned leads...", "tone": "primary", "icon": "👷‍♂️" }
]
}
}

🔹 Admin Actions Needed
Edit
Reorder
Toggle status

🔹 Notes
Public data. Icons are emoji strings.

📌 Component: Brands.jsx
🔹 Purpose
Home section listing partner/brand logos.

🔹 Data Required
{
"brands": [
{ "name": "string", "logoUrl": "string" }
]
}

🔹 API Contract
METHOD: GET /api/v1/brands

Response Example
{
"success": true,
"data": {
"brands": [
{ "name": "greenply", "logoUrl": "https://..." }
]
}
}

🔹 Admin Actions Needed
Create
Edit
Delete
Reorder
Toggle status

🔹 Notes
Public data. Currently sourced from local assets.

📌 Component: JourneyPreview.jsx
🔹 Purpose
Home section previewing first three journey steps and CTA.

🔹 Data Required
{
"section": {
"eyebrow": "string",
"title": "string",
"description": "string"
},
"heroImage": "string",
"heroTitle": "string",
"heroSubtitle": "string",
"stepsPreview": [
{
"id": "number",
"title": "string",
"description": "string"
}
],
"cta": {
"label": "string",
"path": "string"
}
}

🔹 API Contract
METHOD: GET /api/v1/journey/preview

Response Example
{
"success": true,
"data": {
"section": {
"eyebrow": "Process Engineering",
"title": "The Modular Journey",
"description": "We believe that the process..."
},
"heroImage": "https://...",
"heroTitle": "Crafted with precision.",
"heroSubtitle": "Every modular component...",
"stepsPreview": [
{ "id": 1, "title": "The Initial Conversation", "description": "We begin by understanding..." }
],
"cta": { "label": "Explore The Process", "path": "/modular-journey" }
}
}

🔹 Admin Actions Needed
Edit
Reorder
Toggle status

🔹 Notes
Public data. Uses first 3 steps; ensure ordering.

📌 Component: FeaturedProjects.jsx
🔹 Purpose
Home section showcasing three featured project cards.

🔹 Data Required
{
"section": {
"eyebrow": "string",
"title": "string"
},
"projects": [
{
"id": "string",
"title": "string",
"category": "string",
"location": "string",
"year": "string",
"description": "string",
"image": "string"
}
]
}

🔹 API Contract
METHOD: GET /api/v1/projects/featured

Response Example
{
"success": true,
"data": {
"section": {
"eyebrow": "Our Project",
"title": "Crafting Spaces, Creating Memories"
},
"projects": [
{
"id": "local-1",
"title": "Residential Project",
"category": "Residential",
"location": "Residential",
"year": "2024",
"description": "Residential Project completed with attention to detail.",
"image": "https://..."
}
]
}
}

🔹 Admin Actions Needed
Edit
Reorder
Toggle status

🔹 Notes
Public data. Selection logic should be handled by API (unique categories).

📌 Component: ContactCTA.jsx
🔹 Purpose
Global CTA section linking to contact and projects.

🔹 Data Required
{
"eyebrow": "string",
"title": "string",
"ctaPrimary": { "label": "string", "path": "string" },
"ctaSecondary": { "label": "string", "path": "string" }
}

🔹 API Contract
METHOD: GET /api/v1/cta/contact

Response Example
{
"success": true,
"data": {
"eyebrow": "Ready for the transformation?",
"title": "Design Without Compromise",
"ctaPrimary": { "label": "Book Free Consultation", "path": "/contact" },
"ctaSecondary": { "label": "Explore Portfolio", "path": "/projects" }
}
}

🔹 Admin Actions Needed
Edit

🔹 Notes
Public data. No SEO usage.

📌 Component: AboutSubPage.jsx
🔹 Purpose
Dynamic about page renderer based on route param section.

🔹 Data Required
{
"section": "string",
"pageHeader": {
"title": "string",
"image": "string",
"imagePosition": "string",
"overlay": "boolean"
},
"whoWeAre": {
"introTitle": "string",
"introLead": "string",
"introBody": "string",
"introImage": "string",
"stats": [
{ "value": "number", "suffix": "string", "label": "string" }
],
"dials": [
{ "value": "number", "label": "string" }
],
"beforeAfter": {
"beforeSrc": "string",
"afterSrc": "string"
},
"reasons": [
{ "title": "string", "copy": "string", "icon": "string" }
],
"whyCenterImage": "string"
},
"team": [
{ "name": "string", "role": "string", "img": "string" }
],
"office": {
"imgSrc": "string",
"title": "string",
"eyebrow": "string",
"address": "string",
"mapsQuery": "string"
}
}

🔹 API Contract
METHOD: GET /api/v1/about?section=:section

Response Example
{
"success": true,
"data": {
"section": "who-we-are",
"pageHeader": {
"title": "Who We Are",
"image": "https://...",
"imagePosition": "center center",
"overlay": true
},
"whoWeAre": {
"introTitle": "Pioneers of Premium Interiors.",
"introLead": "Founded in 2010...",
"introBody": "Our team consists of...",
"introImage": "https://...",
"stats": [
{ "value": 250, "suffix": "+", "label": "Projects Completed" }
],
"dials": [
{ "value": 87, "label": "Clients Satisfaction" }
],
"beforeAfter": {
"beforeSrc": "https://...",
"afterSrc": "https://..."
},
"reasons": [
{ "title": "5 Years Warranty", "copy": "Extended protection...", "icon": "🛡️" }
],
"whyCenterImage": "https://..."
}
}
}

🔹 Admin Actions Needed
Edit
Reorder
Toggle status

🔹 Notes
Public data. Conditional rendering based on section. No SEO fields present.

📌 Component: CountUp.jsx
🔹 Purpose
Animated number counter used in About stats.

🔹 Data Required
{
"end": "number",
"suffix": "string",
"duration": "number"
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; values come from About data.

📌 Component: AnimatedDial.jsx
🔹 Purpose
Animated circular percentage dial used in About.

🔹 Data Required
{
"value": "number",
"label": "string"
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; values come from About data.

📌 Component: BeforeAfterSlider.jsx
🔹 Purpose
Interactive before/after image slider.

🔹 Data Required
{
"beforeSrc": "string",
"afterSrc": "string"
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; images provided by About data.

📌 Component: OfficeSection.jsx
🔹 Purpose
Office location hero with address and map link.

🔹 Data Required
{
"imgSrc": "string",
"title": "string",
"eyebrow": "string",
"address": "string",
"mapsQuery": "string"
}

🔹 API Contract
METHOD: GET /api/v1/office

Response Example
{
"success": true,
"data": {
"imgSrc": "https://...",
"title": "Bengaluru",
"eyebrow": "Our Office",
"address": "Shed No. 9...",
"mapsQuery": "https://maps.app.goo.gl/..."
}
}

🔹 Admin Actions Needed
Edit

🔹 Notes
Public data.

📌 Component: Contact.jsx
🔹 Purpose
Contact page with hero, inquiry form, and contact info blocks.

🔹 Data Required
{
"pageHeader": {
"title": "string",
"image": "string",
"imagePosition": "string",
"overlay": "boolean"
},
"heroImage": "string",
"headline": "string",
"subcopy": "string",
"serviceOptions": ["string"],
"infoItems": [
{ "key": "string", "label": "string", "value": "string" }
]
}

🔹 API Contract
METHOD: GET /api/v1/pages/contact

Response Example
{
"success": true,
"data": {
"pageHeader": {
"title": "Contact Us",
"image": "https://...",
"imagePosition": "center center",
"overlay": true
},
"heroImage": "https://...",
"headline": "Designing Your Future Starts Here.",
"subcopy": "Our principal architects...",
"serviceOptions": [
"Residential Interior",
"Commercial Space",
"Modular Kitchen",
"Architecture Service"
],
"infoItems": [
{ "key": "location", "label": "Our Studio", "value": "Shed No. 9..." }
]
}
}

🔹 Admin Actions Needed
Edit
Toggle status

🔹 Notes
Public data. No SEO fields.

🧾 FORMS ANALYSIS (Contact Form)
Fields: name, email, service, message
Validation: name required; email required + regex; service required; message required min 10 chars
API endpoint: POST /api/v1/leads
Success: show inline success alert; Error: show field-level messages + general failure message
Admin visibility: leads list with status (new/contacted/closed)

📌 Component: Projects.jsx
🔹 Purpose
Project portfolio with category filters, load more, and lightbox.

🔹 Data Required
{
"pageHeader": {
"title": "string",
"image": "string",
"imagePosition": "string",
"overlay": "boolean"
},
"categories": ["string"],
"projects": [
{
"id": "string",
"title": "string",
"category": "string",
"subCategory": "string",
"location": "string",
"image": "string",
"year": "string",
"description": "string"
}
],
"pageSize": "number"
}

🔹 API Contract
METHOD: GET /api/v1/projects?category=:category&limit=:limit&offset=:offset

Response Example
{
"success": true,
"data": {
"categories": ["All", "Residential", "Commercial"],
"projects": [
{
"id": "local-1",
"title": "Residential Project",
"category": "Residential",
"subCategory": "Museum",
"location": "Residential",
"image": "https://...",
"year": "2024",
"description": "Residential Project completed with attention to detail."
}
],
"pageSize": 12,
"total": 96
}
}

🔹 Admin Actions Needed
Create
Edit
Delete
Reorder
Toggle status

🔹 Notes
Public data. Pagination/load-more is required. Sorting by category order.

📌 Component: ProjectCard.jsx
🔹 Purpose
Project thumbnail card with image and category badge.

🔹 Data Required
{
"project": {
"id": "string",
"title": "string",
"category": "string",
"subCategory": "string",
"image": "string"
}
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; data comes from Projects API.

📌 Component: Lightbox.jsx
🔹 Purpose
Modal image viewer for project gallery.

🔹 Data Required
{
"items": [
{
"image": "string",
"title": "string",
"category": "string"
}
],
"currentIndex": "number",
"isOpen": "boolean"
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; data comes from Projects API.

📌 Component: ServiceDetail.jsx
🔹 Purpose
Service detail page with banner, description, specs, and gallery.

🔹 Data Required
{
"service": {
"id": "string",
"title": "string",
"category": "string",
"shortDescription": "string",
"description": "string",
"bannerImage": "string",
"gallery": ["string"],
"specs": [
{ "title": "string", "detail": "string" }
],
"metrics": [
{ "value": "string", "label": "string" }
],
"whatToExpect": ["string"]
},
"ctaPrimary": { "label": "string", "path": "string" },
"ctaSecondary": { "label": "string", "path": "string" }
}

🔹 API Contract
METHOD: GET /api/v1/services/:id

Response Example
{
"success": true,
"data": {
"service": {
"id": "kitchen",
"title": "Modern Modular Kitchen",
"category": "Residential",
"shortDescription": "Functional, elegant...",
"description": "Our kitchens are designed...",
"bannerImage": "https://...",
"gallery": ["https://..."],
"specs": [
{ "title": "Precision Joinery", "detail": "Millimetric accuracy..." }
],
"metrics": [
{ "value": "100%", "label": "Custom Built" },
{ "value": "05yr", "label": "Service Plan" }
],
"whatToExpect": [
"Tailored layouts and material recommendations for your space."
]
},
"ctaPrimary": { "label": "Book Consultation", "path": "/contact" },
"ctaSecondary": { "label": "View Similar Projects", "path": "/projects" }
}
}

🔹 Admin Actions Needed
Create
Edit
Delete
Reorder
Toggle status

🔹 Notes
Public data. Gallery ordering important. Conditional redirect if service not found.

📌 Component: ModularJourney.jsx
🔹 Purpose
Full journey page listing all steps and CTA.

🔹 Data Required
{
"hero": {
"eyebrow": "string",
"title": "string",
"subtitle": "string",
"scrollHint": "string"
},
"steps": [
{
"id": "number",
"title": "string",
"description": "string",
"image": "string"
}
],
"cta": {
"label": "string",
"path": "string",
"title": "string"
}
}

🔹 API Contract
METHOD: GET /api/v1/journey

Response Example
{
"success": true,
"data": {
"hero": {
"eyebrow": "The Creative Choreography",
"title": "The Modular Journey",
"subtitle": "From the initial abstract thought...",
"scrollHint": "Scroll to begin ↓"
},
"steps": [
{ "id": 1, "title": "The Initial Conversation", "description": "We begin...", "image": "https://..." }
],
"cta": { "title": "The result is always Exceptional.", "label": "Start Your Journey", "path": "/contact" }
}
}

🔹 Admin Actions Needed
Create
Edit
Delete
Reorder
Toggle status

🔹 Notes
Public data. Step ordering is key. No SEO fields.

📌 Component: JourneyStep.jsx
🔹 Purpose
Single journey step block with alternating layout.

🔹 Data Required
{
"step": {
"id": "number",
"title": "string",
"description": "string",
"image": "string"
}
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; data comes from Journey API.

📌 Component: Testimonials.jsx
🔹 Purpose
Testimonials page displaying customer reviews.

🔹 Data Required
{
"pageHeader": {
"title": "string",
"image": "string",
"imagePosition": "string",
"overlay": "boolean"
},
"testimonials": [
{
"id": "string",
"name": "string",
"role": "string",
"content": "string",
"avatar": "string",
"rating": "number"
}
]
}

🔹 API Contract
METHOD: GET /api/v1/testimonials

Response Example
{
"success": true,
"data": {
"testimonials": [
{
"id": "t1",
"name": "Ananya Sharma",
"role": "Homeowner",
"content": "CreativeNconcepts transformed...",
"avatar": "https://...",
"rating": 5
}
]
}
}

🔹 Admin Actions Needed
Create
Edit
Delete
Reorder
Toggle status

🔹 Notes
Public data. Rating is currently static “★★★★★”.

📌 Component: PageHeader.jsx
🔹 Purpose
Reusable page header hero with background image.

🔹 Data Required
{
"title": "string",
"subtitle": "string",
"description": "string",
"image": "string",
"imagePosition": "string",
"overlay": "boolean",
"showSubtitle": "boolean",
"showDescription": "boolean"
}

🔹 API Contract
METHOD: GET /api/v1/page-headers/:slug

Response Example
{
"success": true,
"data": {
"title": "Contact Us",
"subtitle": null,
"description": null,
"image": "https://...",
"imagePosition": "center center",
"overlay": true,
"showSubtitle": false,
"showDescription": false
}
}

🔹 Admin Actions Needed
Edit

🔹 Notes
Public data. No SEO meta fields.

📌 Component: SectionTitle.jsx
🔹 Purpose
Reusable section title block with eyebrow and description.

🔹 Data Required
{
"eyebrow": "string",
"title": "string",
"description": "string",
"align": "string"
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; data comes from parent sections.

📌 Component: Button.jsx
🔹 Purpose
Reusable styled button wrapper.

🔹 Data Required
{
"variant": "string",
"label": "string"
}

🔹 API Contract
METHOD: GET /api/v1/none

Response Example
{
"success": true,
"data": null
}

🔹 Admin Actions Needed
None

🔹 Notes
Pure UI; data comes from parent sections.

✅ Required APIs List
GET /api/v1/navigation/header
GET /api/v1/navigation/footer
GET /api/v1/pages/home
GET /api/v1/hero-slides
GET /api/v1/services/featured
GET /api/v1/home/deliverables
GET /api/v1/brands
GET /api/v1/journey/preview
GET /api/v1/projects/featured
GET /api/v1/cta/contact
GET /api/v1/about?section=:section
GET /api/v1/office
GET /api/v1/pages/contact
POST /api/v1/leads
GET /api/v1/projects
GET /api/v1/services/:id
GET /api/v1/journey
GET /api/v1/testimonials
GET /api/v1/page-headers/:slug

✅ Required Admin Modules
Navigation (Header/Footer)
Homepage Content
Hero Slides
Services
Deliverables
Brands
Journey Steps
Projects
Testimonials
About Sections
Office Locations
Contact Page Content
Leads (Contact Submissions)
Page Headers

✅ Database Entities Needed
navigation_items
footer_content
home_sections
hero_slides
services
service_galleries
service_specs
projects
journey_steps
brands
testimonials
about_sections
team_members
office_locations
page_headers
cta_blocks
leads

If you want me to narrow the scope to only route-level pages (and skip low-level UI components), tell me and I’ll trim the list.