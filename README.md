# SkyDatum Aerial Survey — Laravel 13 + Filament 3 Website, ERP & AI

Production-ready SME platform for a Austin / Central Texas **surveying drone service** firm: public marketing site, Filament admin ERP, knowledge base, and AI assistants for chat, content, automation ideas, and troubleshooting.

## Features
- 🏠 Premium public site (hero, services, about, dashboard preview, contact)
- 🚁 Service detail pages for topo mapping, orthomosaics, corridor ROW, volumetrics & inspections
- 📰 Blog / knowledge content with seeded posts
- 📬 Contact form that stores leads in the database
- 💬 Floating WhatsApp button + public AI chatbot widget
- 🗂️ Filament ERP at `/admin` (customers, missions/flights, inventory, invoices, payments, appointments)
- 👥 Roles: Admin, Manager, Staff
- 📊 Reports dashboard with stats + charts
- ⚙️ Settings page for company phone, WhatsApp, tax rate, and more
- 🤖 Admin AI Studio (blog/descriptions, automation suggestions, troubleshooting)
- 📚 Knowledge base: common issues, guides, admin manual, troubleshooting
- 🌱 Realistic demo seeders for a full walkthrough

## Tech Stack
- Laravel 13
- Filament 3
- Livewire + Alpine.js
- Tailwind-friendly public CSS (custom SkyDatum theme)
- MySQL or SQLite
- Spatie Laravel Permission
- OpenAI API with Gemini fallback keys (demo FAQ mode when keys are empty)

## Installation
```bash
git clone https://github.com/imranbru99/surveying-drone-service.git
cd surveying-drone-service
composer install
copy .env.example .env   # Windows
php artisan key:generate
# Ensure database/database.sqlite exists for SQLite demo
php artisan migrate --seed
php artisan serve
```

Admin ERP: `http://localhost:8000/admin` — `admin@example.com` / `password`

Optional AI keys in `.env`: `OPENAI_API_KEY` or `GEMINI_API_KEY`.

## Screenshots / Visual Dashboard
![SkyDatum hero](https://images.unsplash.com/photo-1473968512647-3e447244af8f?auto=format&fit=crop&w=1400&q=80)
![SkyDatum field](https://images.unsplash.com/photo-1508610048659-a06b669e3321?auto=format&fit=crop&w=1400&q=80)
![SkyDatum detail](https://images.unsplash.com/photo-1527979809429-b4bb5c0c0f1c?auto=format&fit=crop&w=1400&q=80)
![SkyDatum ops](https://images.unsplash.com/photo-1579829366248-204fe8413f31?auto=format&fit=crop&w=1400&q=80)

## Live Demo
Placeholder — deploy to your preferred host (Forge, Vapor, shared PHP) and update this section with the public URL.

## SEO-optimized repo description
```
SkyDatum Aerial Survey — Laravel 13 + Filament 3 website, ERP & AI for an Colorado Front Range surveying drone service (topo, orthomosaics, volumetrics, chatbot).
```

---

## 🤝 Let's Connect & Collaborate
I am open to Senior Remote Full-Stack Roles, AI Platform Architecture Contracts, and Enterprise Technical Advisory.
Timezone: UTC+6 (Dhaka / Rangpur, Bangladesh) — Flexible overlap with US, UK, and European business hours.
Delivery Mode: Async-ready, Slack, Discord, Jira, GitHub, and production-first accountability.

| Channel | Address / Handle | Quick Action |
|---------|------------------|--------------|
| 🌐 Primary Portfolio | imrandev.bd | Visit Site ↗ |
| 📦 Packagist Packages | packagist.org/packages/imrandevbd/ | View Packages ↗ |
| 💼 LinkedIn Profile | linkedin.com/in/imranbru99 | Connect ↗ |
| 🐙 GitHub Profile | github.com/imranbru99 | Follow ↗ |
| 💬 WhatsApp Direct | +880 1576-918420 | Chat Now ↗ |
| 📧 Direct Email | me@imrandev.bd | Send Email ↗ |
| 🐦 X (Twitter) | @imrandev_bd | Follow ↗ |
| 📺 YouTube Tech | @ImranDevBD | Subscribe ↗ |