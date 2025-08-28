# CodeIgniter EMS

A modernized Employee Management System built with CodeIgniter 3.

## Prerequisites
- PHP 7.4+ (or compatible with your local stack)
- MySQL/MariaDB
- Web server (Laragon/XAMPP) configured to serve `ci/`

## Quick Start
1. Create database and import `ems.sql`.
2. Update database credentials in `ci/application/config/database.php`.
3. Ensure base URL in `ci/application/config/config.php` matches your host (e.g., `http://localhost/CodeIgniter-EMS/ci/`).
4. Visit the app:
   - Home: `http://localhost/CodeIgniter-EMS/ci/`
   - Dashboard: `http://localhost/CodeIgniter-EMS/ci/Dash`
   - Employees: `http://localhost/CodeIgniter-EMS/ci/Employees`
   - Jobs: `http://localhost/CodeIgniter-EMS/ci/Jobs`
   - Departments: `http://localhost/CodeIgniter-EMS/ci/Department`
   - Performance Dashboard (static): `http://localhost/CodeIgniter-EMS/ci/performance_dashboard.php`

## UI/UX Notes
- Shared layout (sidebar + topnav) across all dash pages.
- Styles centralized in `ci/assets/css/dashboard.css` and `ci/assets/css/theme.css`.
- Shared behavior in `ci/assets/js/dashboard.js` (theme toggle, clock, mobile sidebar).

## Data Models
- Employees (`employees`), Jobs (`jobs`), Departments (`department`).

## Development Tips
- Logs: `ci/application/logs/` and performance logs under `ci/application/logs/performance/`.
- API docs: `http://localhost/CodeIgniter-EMS/ci/index.php/api_docs`.

## Housekeeping
- Legacy Performance controller and view removed in favor of `performance_dashboard.php`.
- Jobs/Departments indexes now show lists by default; sidebar points to base routes.

## Troubleshooting
- If CSS/JS don’t load, verify `base_url` and that assets paths resolve under `ci/assets/...`.
- If DB errors occur, re-check credentials and ensure `ems.sql` imported successfully.