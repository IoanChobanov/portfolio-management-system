# Portfolio Management System

A robust, full-stack Content Management System (CMS) built with **Laravel** and **Tailwind CSS**.

## About The Project

I built this platform not just to manage my personal projects, but to practice advanced Laravel architecture in a real-world scenario. While it looks like a standard portfolio on the surface, the backend focuses heavily on **clean code principles** and **security**.

Instead of cluttering Controllers with business logic, I implemented the **Service Pattern**. This keeps the codebase maintainable and testable. I also extended the standard authentication system to include a custom **Role-Based Access Control (RBAC)**, allowing strictly defined permissions for Admins and regular Users.

## Technical Highlights

- **Architecture:** The application avoids "Fat Controllers" by offloading complex logic to dedicated Service classes.
- **Security First:** Beyond standard CSRF protection, I utilized strict **Form Requests** for validation and Laravel **Policies** to authorize actions at the model level.
- **Frontend:** Built with **Blade** templates and **Tailwind CSS** for a fast, server-side rendered UI that is fully responsive without the complexity of a SPA.
- **Data Management:** Features a complete file management system for uploading project assets, utilizing Laravel's Storage facade and Eloquent relationships.

## Stack

- **Framework:** Laravel 10+
- **Database:** MySQL
- **Styling:** Tailwind CSS
- **Auth:** Laravel Breeze (Customized)

## Getting Started

If you want to run this locally to check the code:

```bash
# 1. Clone the repo
git clone [https://github.com/IoanChobanov/portfolio-management-system.git](https://github.com/IoanChobanov/portfolio-management-system.git)

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Setup Environment
cp .env.example .env
php artisan key:generate

# 4. Database & Seed
# (Make sure you have a database created in MySQL)
php artisan migrate --seed

# 5. Serve
php artisan serve
```
