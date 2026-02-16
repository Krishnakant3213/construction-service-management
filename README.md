# 🏗️ Construction Service & Quotation Management System

A Laravel 12 web application for construction and manufacturing businesses to manage the complete workflow — from customer inquiry to project completion.

## 📋 Overview

This system digitizes manual processes such as WhatsApp inquiries, Excel quotations, and paper-based tracking into a structured, automated, and scalable platform.

### Key Features
- **Lead Management** — Capture and track client inquiries with status pipeline
- **Site Visit Booking** — Schedule, assign, and record site inspections
- **Quotation Builder** — Generate professional quotations with Indian GST calculations (CGST/SGST/IGST)
- **Project Tracking** — Convert approved quotations into projects with task breakdown
- **Payment Tracking** — Record and monitor payments against projects
- **Dashboard & Analytics** — KPIs, revenue trends, and lead conversion metrics
- **Role-Based Access** — Super Admin, Admin, Sales Executive, Site Engineer, Accountant

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade + Blade Components |
| CSS | Tailwind CSS 4 |
| Database | MySQL 8 (SQLite for tests) |
| Auth | Laravel Breeze (Blade) |
| Roles & Permissions | Spatie Laravel-Permission v7 |
| File Uploads | Spatie Media Library v11 |
| PDF Generation | barryvdh/laravel-dompdf v3 |

---

## 🗄️ Database Schema

18 tables covering the full business workflow:

| Table | Purpose |
|---|---|
| `users` | System users with roles (extended with phone, avatar, soft deletes) |
| `lead_sources` | Lookup: WhatsApp, Website, Referral, JustDial, etc. |
| `leads` | Client inquiries with status pipeline & priority |
| `site_visits` | Scheduled site inspections with measurements & photos |
| `services` | Master catalog of construction services & rates |
| `quotations` | Professional quotations with GST tax calculations |
| `quotation_items` | Line items within quotations |
| `projects` | Active projects converted from approved quotations |
| `project_tasks` | Work breakdown items within projects |
| `payments` | Payment records against projects |
| `activity_logs` | Polymorphic audit trail |
| `settings` | Application-wide configuration (company, tax, etc.) |
| `media` | Spatie Media Library (file uploads) |
| `notifications` | Laravel database notifications |
| Spatie tables | `roles`, `permissions`, `model_has_roles`, etc. |

### Auto-Numbering
- Leads: `LD-00001`
- Site Visits: `SV-00001`
- Quotations: `QT-20260216-00001` (with date string)
- Projects: `PJ-00001`
- Payments: `PAY-00001`

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8

### Installation

```bash
# Clone the repository
git clone https://github.com/Krishnakant3213/construction-service-management.git
cd construction-service-management

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Update .env with your database credentials
# DB_DATABASE=construction_service
# DB_USERNAME=root
# DB_PASSWORD=your_password

# Run migrations and seed data
php artisan migrate --seed

# Build frontend assets
npm run build

# Start the server
php artisan serve
```

### Default Login Credentials

| Role | Email | Password |
|---|---|---|
| Super Admin | `admin@construction.test` | `password` |
| Sales Executive | `sales@construction.test` | `password` |
| Site Engineer | `engineer@construction.test` | `password` |
| Accountant | `accountant@construction.test` | `password` |

---

## 📊 Seeded Data

- **5 Roles** with 32 granular permissions
- **4 Sample Users** with assigned roles
- **10 Lead Sources** (WhatsApp, Website, Referral, etc.)
- **15 Construction Services** with realistic rates & HSN codes
- **14 Application Settings** (company info, tax defaults, quotation terms)

---

## ✅ Completed

- [x] Laravel 12 project setup with Blade + Breeze
- [x] Package installation (Spatie Permission, Media Library, DomPDF)
- [x] Database schema design (18 tables)
- [x] All Eloquent models with `$guarded`, `SoftDeletes`, relationships, scopes
- [x] Auto-number generation on Lead, SiteVisit, Quotation, Project, Payment
- [x] GST tax calculation engine in Quotation model
- [x] Roles & permissions seeder (5 roles, 32 permissions)
- [x] Sample data seeders (users, services, lead sources, settings)
- [x] Super-admin Gate bypass

## 🔲 Next Steps

### Phase 1: Backend — Controllers & Routes
- [ ] `DashboardController` — KPI cards, charts, recent activity
- [ ] `LeadController` — Full CRUD + status transitions + follow-up tracking
- [ ] `SiteVisitController` — CRUD + complete/cancel actions
- [ ] `QuotationController` — CRUD + send/approve/reject/revise + PDF generation
- [ ] `ProjectController` — CRUD + quotation-to-project conversion + progress tracking
- [ ] `ProjectTaskController` — Nested CRUD under projects
- [ ] `PaymentController` — Nested CRUD under projects
- [ ] `ServiceController` — CRUD (admin settings area)
- [ ] `SettingController` — Company info, tax configuration
- [ ] `UserController` — User management + role assignment
- [ ] `ReportController` — Revenue reports, lead conversion analytics

### Phase 2: Frontend — Blade Views & Components
- [ ] Admin layout with sidebar navigation
- [ ] Dashboard with KPI cards and charts
- [ ] Lead management views (list, create, edit, show)
- [ ] Site visit views with calendar integration
- [ ] Quotation builder with dynamic line items & live tax preview
- [ ] Project tracking views with task management
- [ ] Payment recording with receipt upload
- [ ] Reports & analytics pages
- [ ] Reusable Blade components (status badges, data tables, modals)

### Phase 3: Business Logic & Integrations
- [ ] Quotation PDF generation (DomPDF)
- [ ] Email notifications (new lead, quotation sent, payment received)
- [ ] Activity logging across all modules
- [ ] File uploads via Spatie Media Library
- [ ] Quotation revision workflow
- [ ] Lead-to-project full lifecycle

### Phase 4: Testing & Polish
- [ ] Feature tests (SQLite) for all CRUD operations
- [ ] Quotation tax calculation tests
- [ ] Project conversion flow tests
- [ ] UI polish and responsive design
- [ ] Performance optimization

---

## 📁 Project Structure

```
app/
├── Models/
│   ├── User.php              # HasRoles, relationships to all modules
│   ├── Lead.php              # Auto-number, status pipeline, HasMedia
│   ├── LeadSource.php        # Lookup table
│   ├── SiteVisit.php         # Scheduling, measurements, HasMedia
│   ├── Service.php           # Master service catalog
│   ├── Quotation.php         # GST calculations, revisions, HasMedia
│   ├── QuotationItem.php     # Auto-calculated amounts & GST
│   ├── Project.php           # Progress tracking, HasMedia
│   ├── ProjectTask.php       # Auto-updates project progress
│   ├── Payment.php           # Auto-numbering
│   ├── ActivityLog.php       # Polymorphic audit trail
│   └── Setting.php           # Key-value config helpers
database/
├── migrations/               # 18 migration files
└── seeders/
    ├── DatabaseSeeder.php
    ├── RoleAndPermissionSeeder.php
    ├── AdminUserSeeder.php
    ├── LeadSourceSeeder.php
    ├── ServiceSeeder.php
    └── SettingSeeder.php
```

---

## 📄 License

This project is proprietary software.
