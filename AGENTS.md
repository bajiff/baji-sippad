# SIPPAD — Agent Instructions

SIPPAD (Sistem Informasi Pelatihan dan Pendaftaran Desa) is a Laravel-based training and registration management system for villages. This document helps AI agents understand the codebase structure, conventions, and development workflow.

## Quick Reference

- **Framework**: Laravel 13.8 (PHP 8.3)
- **Database**: PostgreSQL 16.14 (primary) + SQLite (dev)
- **Frontend**: Blade templates + Alpine.js + Vite
- **Key Features**: Training management, user registration, attendance tracking, certificate generation, reporting, notifications
- **Status**: ~99% complete ([PROGRESS.md](docs/PROGRESS.md) — Fase 6 at 95%)

## Project Structure

```
app/
  Http/Controllers/
    Admin/         # Admin-only controllers (CRUD for trainings, registrations, etc.)
    User/          # User-facing controllers (dashboard, profile, history)
    Auth/          # Authentication (login, register)
  Models/          # Eloquent models (User, Pelatihan, Pendaftaran, Kehadiran, Sertifikat, etc.)
  Services/        # Business logic (LaporanService, PendaftaranService, SertifikatService)
  Notifications/   # Notification classes (PendaftaranStatusNotification)
  Providers/       # Service providers

database/
  migrations/      # 10+ migrations defining core schema
  seeders/         # Database seeders (AdminSeeder, KategoriSeeder, etc.)

resources/
  views/
    layouts/       # app.blade.php, admin.blade.php, user.blade.php, guest.blade.php
    components/    # Reusable Blade components (navbar, sidebar, card, button, etc.)
    pdf/           # PDF templates (sertifikat.blade.php — single-page A4 landscape)
    admin/         # Admin pages (dashboard, CRUD pages)
    user/          # User pages (dashboard, profile, training history, registration)
    landing.blade.php  # Public landing page

routes/
  web.php          # All web routes (guest, auth, admin, user groups)

tests/
  Feature/         # Feature tests
  Unit/            # Unit tests
```

## Architecture & Conventions

### Role-Based Access Control
- **Admin**: Full access to CRUD operations, verification, reporting. Protected by `AdminMiddleware`.
- **User**: Access to training browsing, self-registration, profile, history, certificates. Protected by `UserMiddleware`.
- **Guest**: Landing page, login, register.

### Service Layer Pattern
Business logic is encapsulated in service classes under `app/Services/`:
- `PendaftaranService`: Registration workflows (create, verify, reject, cancel)
- `SertifikatService`: Certificate generation and bulk operations
- `LaporanService`: Report generation and export (CSV)

When implementing features, add business logic to services, not controllers.

### Database Models
Core models with relationships:
- **User**: role (admin|user), is_superadmin flag
- **Pelatihan**: Training class with status (draft|publish|selesai), category, quota
- **Pendaftaran**: User registration to training, status (menunggu|terverifikasi|ditolak|dibatalkan)
- **Kehadiran**: Attendance records (hadir|tidak_hadir|belum_presensi)
- **Sertifikat**: Generated certificates with status (terbit|dibatalkan)
- **Dokumentasi**: Training documentation/photos
- **KategoriPelatihan**: Training categories
- **Notification**: Database notifications (Laravel's default)

### Frontend Patterns
- **Blade Components**: Use reusable components in `resources/views/components/` for buttons, cards, modals, etc.
- **Alpine.js**: Lightweight interactivity (checkboxes, toggles, modals). Examples: bulk action checkboxes, dark/light theme toggle.
- **Responsive Design**: Tailwind CSS utility classes (if configured) or custom CSS from `resources/css/app.css`.
- **PDF Generation**: DomPDF for certificates. Layout in `resources/views/pdf/sertifikat.blade.php` uses absolute positioning (top/bottom/left/right) to ensure single-page A4 landscape output without page breaks.

### Notification System
- Database notifications stored in `notifications` table.
- `PendaftaranStatusNotification`: Triggered when registration status changes.
- Integrated into admin/user dashboards via bell icon and notification dropdown.

## Development Workflow

### Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

### Local Development
```bash
composer run dev
```
This starts concurrently:
- `php artisan serve` — Laravel server (localhost:8000)
- `php artisan queue:listen` — Job queue worker
- `php artisan pail` — Log viewer
- `npm run dev` — Vite dev server

### Running Tests
```bash
php artisan test
```

## Testing Notes
- Test directory: `tests/Feature/` and `tests/Unit/`
- Use `Laravel\Sanctum` for API testing (if applicable)
- Database is reset between feature tests (see `TestCase.php`)

## Key Files & Patterns

### Routes
- **Landing page** (`/`): Shows categories, latest trainings, stats; redirects auth'd users to dashboards.
- **Auth routes**: `/login`, `/register`, `/logout` (guest middleware).
- **Admin routes** (`/admin/*`): CRUD and verification operations.
- **User routes** (`/user/*`): Dashboard, training list, profile, registration history.

### Migrations
All migrations are in `database/migrations/`. Key migrations:
- Core Laravel tables (users, cache, jobs)
- Training & registration schema (kategori_pelatihan, pelatihan, pendaftaran, kehadiran, sertifikat, dokumentasi)
- Notifications table
- Super admin flag added to users table

### Configuration
- **Database**: Set in `.env` (SQLALCHEMY_URL for PostgreSQL or SQLite)
- **Mail**: Configure in `config/mail.php` if implementing email notifications
- **Session & Cache**: Default to file-based in dev; redis in production

## Common Tasks

### Adding a New Training Feature
1. Create migration in `database/migrations/`
2. Create/update model in `app/Models/`
3. Create controller(s) in `app/Http/Controllers/Admin/` or `User/`
4. Add service method in `app/Services/` if business logic is involved
5. Create route(s) in `routes/web.php`
6. Create views in `resources/views/admin/` or `user/`

### Certificate Generation
- Service: `app/Services/SertifikatService.php`
- PDF template: `resources/views/pdf/sertifikat.blade.php` (single-page A4 landscape)
- Bulk generation: Admin page with checkbox selection + "Generate Sertifikat" button
- Download: Individual certificate link in training history (user) or admin certificate table

### Bulk Operations
Pattern: Checkboxes (Alpine.js) → Form submission → Service method → Database update
Example: Bulk certificate generation, bulk status updates.

### Database Notifications
- Create notification class in `app/Notifications/`
- Trigger with `notify()` on user model
- Display in views with `$user->unreadNotifications` or similar

## Common Pitfalls

1. **PDF Page Breaks**: Use absolute positioning (top/bottom/left/right) in certificate layout, not margins or padding-heavy designs.
2. **Role Authorization**: Always check `$user->role` or `$user->is_superadmin` in controllers or use `authorize()` gate.
3. **Bulk Actions**: Remember to handle "select all" checkbox state and validate selections server-side.
4. **Queue Jobs**: If implementing async operations, ensure `queue:listen` is running in dev.
5. **Notifications**: Database notifications are stored; implement front-end polling or WebSocket for real-time updates.

## Related Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Project Progress](docs/PROGRESS.md)
- [Project Planning](docs/SIPPAD-Implementation-Planning.md) (if detailed specs are needed)

## Tips for AI Agents

- **Before adding features**: Check [PROGRESS.md](docs/PROGRESS.md) to understand what's completed.
- **Blade Components**: Reuse components; keep views DRY.
- **Service Pattern**: Add business logic to services for testability and reusability.
- **Alpine.js**: Use for lightweight interactivity; consider Livewire for complex state management if needed later.
- **Testing**: Write tests for services and critical controller logic.
- **Code Style**: Run `composer install` then `./vendor/bin/pint` to auto-format PHP code (Laravel Pint).
