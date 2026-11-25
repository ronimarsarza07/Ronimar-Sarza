# Candidate Information System

A beginner-friendly CRUD system for candidate records. It is built with PHP, MySQL, HTML, and CSS and is intended to run locally using XAMPP.

## Features
- Create, view, search, edit, and archive candidate records
- Required-field and length validation
- Prepared SQL statements and HTML output escaping
- CSRF token for form submissions
- Archive behavior (soft delete) with confirmation prompt
- Database schema included in `database/schema.sql`

## Requirements
- XAMPP with Apache, PHP, and MySQL enabled
- PHP extensions `pdo_mysql` and `mbstring`

## Run with XAMPP
1. Copy this folder into `C:\xampp\htdocs\Finals-Refactored`.
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Select **Import**, choose `database/schema.sql`, and click **Import**.
5. Open `http://localhost/Finals-Refactored/`.

Default local database settings are host `127.0.0.1`, database `finals_crud_db`, user `root`, and blank password. Set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` environment variables if your local MySQL credentials differ. Do not commit real passwords.

## Project structure
- `index.php` handles the request and renders the page.
- `app/CandidateService.php` validates business rules.
- `app/CandidateRepository.php` owns candidate SQL operations.
- `app/Database.php` creates the PDO database connection.
- `app/Html.php` escapes text before showing it in the browser.
- `database/schema.sql` creates the database and table.
- `assets/styles.css` contains the interface styling.

## OOP and design notes for code defense
- `Database` has one job: open a safe PDO connection.
- `CandidateRepository` separates storage queries from page markup.
- `CandidateService` checks input before saving changes.
- `Html` keeps HTML escaping reusable.
- Private database connection property and typed methods keep repository details encapsulated.
- Prepared statements bind values safely; values are never inserted into SQL by string concatenation.
- Archiving fills in `deleted_at`, so a record is hidden from the active list without being permanently erased.

## Scope
This is a focused candidate information system designed to demonstrate the CRUD requirements. It does not include voter accounts, ballot casting, or election result tallying from the original Finals project.

## GitHub
You can upload the source files to a public repository for submission. GitHub Pages cannot execute PHP; use XAMPP for a local demo or a PHP/MySQL hosting service for an online demo. Never upload real passwords or private student data.
