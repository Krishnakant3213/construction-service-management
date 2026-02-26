# 🏗️ Full Project Phases breakdown

This document details the complete roadmap we discussed and agreed upon today for converting the **Construction Service Management** project into a modern Single Page Application (SPA) using **Laravel 12 (Backend) + Inertia.js + Vue 3 (Frontend)**.

---

## ✅ Phase -1: Foundation (Already Finished)

_The work that was completed prior to our session today._

- Laravel 12 default installation.
- 18 Database Migrations covering Leads, Quotations, Projects, Payments, etc.
- 12 Eloquent Models with relationships, scopes, soft deletes, and auto-numbering.
- GST calculation engine (built into the `Quotation` model).
- 6 Database Seeders including Spatie Roles & Permissions (32 distinct permissions).

---

## 🟡 Phase 0: Vue + Inertia Infrastructure (In Progress)

_The technological bridge converting the app from Blade to a Vue SPA._

- Install and configure `inertia-laravel` (Backend) and `@inertiajs/vue3` (Frontend).
- Configure Vite alongside the Vue plugin.
- Create the core `app.blade.php` root shell and `app.js` bootstrap script.
- Set up Ziggy to pass Laravel named routes natively to Vue.
- **Converting Authentication:**
    - Modify Laravel Breeze's default `Auth` controllers to return `Inertia::render()`.
    - Rebuild the login, registration, and password reset flows as Vue Single File Components (SFCs).

---

## 🔲 Phase 1: Backend Core (Controllers & Requests)

_Building the API/Responses for the admin panel._

- **DashboardController**: Return KPI metrics, charts (revenue over time, lead status distribution), and recent activity logs to the frontend.
- **LeadController**: Full CRUD operations + `updateStatus` method to handle pipeline movement (New -> Contacted -> Won/Lost).
- **SiteVisitController**: Nested under Leads; handles scheduling, completing, and canceling site measurements.
- **QuotationController**: CRUD + custom actions to `send`, `approve`, `reject`, `revise` (cloning), and `convertToProject`.
- **ProjectController & ProjectTaskController**: Project tracking, task management, and updating completion percentage.
- **PaymentController**: Nested under Projects; handles recording incoming revenue.
- **Admin/Settings Controllers**: `SettingController`, `ServiceController`, `UserController` (managing users and Spatie roles).
- _All controllers will use strict Laravel FormRequests for validation._

---

## 🔲 Phase 2: Frontend Views (Vue 3 UI)

_Building the visual interface using Tailwind CSS 4 and Vue 3 Composition API._

- **Global Architecture**:
    - A persistent `AppLayout.vue` comprising a fixed sidebar (navigation) and topbar (search, notifications, breadcrumbs).
    - Reusable components: `StatCard`, `StatusBadge`, `DataTable`, `Modal`.
- **Key Modules**:
    - **Dashboard**: 4 top KPI cards + Chart.js integrations.
    - **Leads view**: Complex data table with status pill filters.
    - **Quotation Builder (The hardest view)**: A dynamic, highly interactive form allowing the user to add/remove service line items and see a **live-updating GST and subtotal preview** via Vue reactivity.
    - **Project View**: Comprehensive view showing a progress bar, task completion checklists, and payment ledgers.
    - **Settings View**: Vertical tabbed layout for Company details, global Tax rates, etc.

---

## 🔲 Phase 3: Business Logic & Integrations

_The complex application features operating behind the scenes._

- **PDF Generation**: Implementing `barryvdh/laravel-dompdf` to generate professional, nicely styled A4 quotation PDFs based on the Blade template `resources/views/quotations/pdf.blade.php`.
- **Email Notifications**: Triggering Laravel Mailable/Notification classes (e.g., `QuotationSentNotification`, `PaymentReceivedNotification`) to alert staff and clients.
- **Activity Logging**: Implementing a Polymorphic activity log to track "Who did what, and when" across leads, quotations, and projects.
- **File Uploads**: Using `Spatie Media Library` to attach site visit photos, project documents, and offline payment receipts globally.

---

## 🔲 Phase 4: Testing & Polish

_Ensuring the application is completely robust before production use._

- **Feature Tests**: Ensuring all critical CRUD pipelines function correctly using SQLite in-memory databases.
- **Financial Tests**: Writing explicit unit tests against the `calculateTotals()` method in the Quotation model to ensure that Discounts, CGST, SGST, and IGST math is perfectly accurate.
- **Conversion Flow Tests**: Ensuring that taking an approved Quotation and converting it into an active Project accurately migrates line items to project scope/budget.
- **Polish**: Refining UI empty states, mobile-responsive layouts, and loading indicators.
