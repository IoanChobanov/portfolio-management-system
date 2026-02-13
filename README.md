# Portfolio Management System

A full-stack Content Management System (CMS) developed using **Laravel** and **Blade templates**. The application allows for managing personal projects, implementing specific architectural patterns and security measures.

## About The Project

This project focuses on backend structure and secure data management. The main features include:

- **Architecture:** Implemented the **Service Pattern** to separate business logic from controllers, ensuring a cleaner codebase.
- **Frontend Rendering:** Built the user interface using **Blade Templates** for server-side rendering, styled with **Tailwind CSS**.
- **Role-Based Access Control (RBAC):** Extended Laravel Breeze authentication to support user roles (Admin vs. Standard User).
- **Authorization:** Utilized **Laravel Policies** and Gates to control access to specific resources and actions.
- **Data Validation:** Implemented strict **Form Requests** to validate all incoming data and prevent security vulnerabilities.
- **File Management:** Integrated file storage functionality for uploading and managing project images.
- **Database:** Designed a relational database schema in **MySQL** using migrations and Eloquent ORM.

## Stack

- **Framework:** Laravel 11+
- **Database:** MySQL
- **Frontend:** Blade, Tailwind CSS
- **Auth:** Laravel Breeze

## How to run

If you want to run this locally or to check the code:

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
