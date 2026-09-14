# BengkelKu — Motorcycle & Automobile Workshop Management System

A web-based management information system designed to streamline the operational workflow of a motorcycle and automobile repair workshop (*bengkel*). This system covers customer registration, vehicle management, mechanic assignment, service transaction recording, and report generation.

---

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [System Architecture](#system-architecture)
- [Features](#features)
- [Database Schema](#database-schema)
- [Project Structure](#project-structure)
- [Installation & Setup](#installation--setup)
- [Known Limitations](#known-limitations)

---

## Overview

BengkelKu is a CRUD-based workshop management system built using PHP and MySQL. It provides a centralized dashboard for workshop operators to manage all aspects of the repair process — from customer intake to service completion and revenue reporting — without relying on manual paper-based records.

The system was developed as an academic or portfolio project to demonstrate proficiency in server-side web development using the PHP procedural paradigm, relational database design, and Bootstrap-based UI development.

---

## Tech Stack

| Layer        | Technology                            |
|--------------|---------------------------------------|
| Backend      | PHP 8 (Procedural)                    |
| Database     | MySQL via `mysqli` extension           |
| Frontend     | HTML5, Bootstrap 5.3, Bootstrap Icons |
| Custom Style | Vanilla CSS (`assets/css/style.css`)  |
| Local Server | Laragon (Apache + MySQL)              |

---

## System Architecture

The application follows a **Page-Controller** pattern — each PHP file handles both business logic and view rendering. Shared concerns are extracted into reusable includes:

```
index.php / module/action.php
    ├── config/database.php   → Database connection singleton
    ├── includes/header.php   → HTML head, navbar, sidebar
    └── includes/footer.php   → Closing tags, Bootstrap JS
```

Navigation depth is determined dynamically (`$depth` variable in `header.php`), allowing the same header partial to resolve asset paths correctly from both root-level and subdirectory pages.

---

## Features

### Dashboard
- Summary statistics cards: total customers, vehicles, mechanics, and service records
- Service status breakdown (In-Progress vs. Completed)
- Total revenue aggregated from completed services
- Quick-access shortcuts to the most common actions
- Live table of the 5 most recent service transactions

### Customer Management (`/pelanggan`)
- Add, view, edit, and delete customer records
- Fields: Full Name, Phone Number, Address
- Cascade deletion — removing a customer removes all associated vehicles and service records

### Vehicle Management (`/kendaraan`)
- Register vehicles linked to an existing customer
- Supports both motorcycles (`Motor`) and automobiles (`Mobil`)
- Fields: Owner, Vehicle Type, Brand, Model, License Plate, Year of Manufacture

### Mechanic Management (`/mekanik`)
- Manage mechanic profiles and their specialization
- Specialization options: Motorcycle only, Automobile only, or Both
- Fields: Name, Phone Number, Specialization

### Service Transactions (`/servis`)
- Record full service intake details per vehicle
- Assign a responsible mechanic per job
- Track service status: **In Progress (Proses)** or **Completed (Selesai)**
- Fields: Vehicle, Mechanic, Entry Date, Completion Date (optional), Customer Complaint, Work Performed, Service Cost

### Service Report (`/laporan`)
- Filterable report by service status and date range
- Displays aggregated revenue totals for completed services
- Built-in print-to-paper functionality via `window.print()` with print-specific CSS hiding UI chrome

---

## Database Schema

The database (`db_bengkel`) consists of four normalized tables with proper foreign key constraints:

```
pelanggan (Customer)
 ├── id (PK)
 ├── nama, telepon, alamat
 └── created_at

kendaraan (Vehicle)
 ├── id (PK)
 ├── id_pelanggan (FK → pelanggan.id, CASCADE DELETE)
 ├── jenis ENUM('Motor','Mobil')
 ├── merk, model, plat_nomor, tahun

mekanik (Mechanic)
 ├── id (PK)
 ├── nama, telepon
 ├── spesialisasi ENUM('Motor','Mobil','Keduanya')
 └── created_at

servis (Service Transaction)
 ├── id (PK)
 ├── id_kendaraan (FK → kendaraan.id, CASCADE DELETE)
 ├── id_mekanik   (FK → mekanik.id,   CASCADE DELETE)
 ├── tanggal_masuk, tanggal_selesai
 ├── keluhan, pekerjaan
 ├── biaya DECIMAL(12,0)
 ├── status ENUM('Proses','Selesai')
 └── created_at
```

Referential integrity is enforced via `ON DELETE CASCADE` on both foreign keys in the `servis` and `kendaraan` tables.

---

## Project Structure

```
Bengkel/
├── assets/
│   ├── css/
│   │   └── style.css           # Custom stylesheet
│   └── js/                     # (reserved for scripts)
├── config/
│   └── database.php            # MySQLi connection setup
├── includes/
│   ├── header.php              # Global navbar + sidebar partial
│   └── footer.php              # Global footer partial
├── pelanggan/
│   ├── index.php               # Customer list
│   ├── tambah.php              # Add customer
│   ├── edit.php                # Edit customer
│   └── hapus.php               # Delete customer
├── kendaraan/
│   ├── index.php               # Vehicle list
│   ├── tambah.php              # Add vehicle
│   ├── edit.php                # Edit vehicle
│   └── hapus.php               # Delete vehicle
├── mekanik/
│   ├── index.php               # Mechanic list
│   ├── tambah.php              # Add mechanic
│   ├── edit.php                # Edit mechanic
│   └── hapus.php               # Delete mechanic
├── servis/
│   ├── index.php               # Service transaction list
│   ├── tambah.php              # Add service record
│   ├── edit.php                # Edit service record
│   └── hapus.php               # Delete service record
├── laporan/
│   └── index.php               # Filterable service report + print
├── database.sql                # Full DDL + sample seed data
├── koneksi.php                 # Legacy connection file (superseded by config/)
└── index.php                   # Application dashboard (entry point)
```

---

## Installation & Setup

### Prerequisites
- [Laragon](https://laragon.org/) (or XAMPP / WAMP) with PHP 8+ and MySQL

### Steps

1. **Clone or copy** the project folder into your web server root:
   ```
   C:\laragon\www\Bengkel\
   ```

2. **Import the database** via phpMyAdmin or the MySQL CLI:
   ```sql
   SOURCE C:/laragon/www/Bengkel/database.sql;
   ```
   This will create the `db_bengkel` database, all tables, and sample seed data.

3. **Verify database credentials** in `config/database.php`:
   ```php
   $host     = "localhost";
   $user     = "root";
   $password = "";          // Update if your MySQL root has a password
   $database = "db_bengkel";
   ```

4. **Start Laragon** and navigate to:
   ```
   http://localhost/Bengkel/
   ```

---

## Known Limitations

The following areas represent acknowledged technical gaps in the current version of this project. They are areas for future improvement and were deliberately deferred to keep scope manageable for the development timeline.

| # | Limitation | Description |
|---|---|---|
| 1 | **No Authentication** | The application has no login/logout system. All pages are publicly accessible to anyone on the same network. Any production deployment would require user authentication and role-based access control (RBAC). |
| 2 | **SQL Injection Vulnerability** | User inputs are interpolated directly into SQL query strings without the use of prepared statements (`mysqli_prepare`). This exposes the application to SQL injection attacks if deployed in a public-facing environment. |
| 3 | **No Input Sanitization on Write** | While `htmlspecialchars()` is applied on output, POST inputs are not sanitized or validated server-side beyond basic empty-field checks before being written to the database. |
| 4 | **No Pagination** | All data tables load every record from the database in a single query. On large datasets this will degrade performance. Pagination or lazy-loading has not been implemented. |
| 5 | **No Search / Filter on Master Data** | The customer, vehicle, and mechanic list pages display all records without search or column filtering capability. |
| 6 | **Procedural Code Style** | The application is written in procedural PHP without a framework, OOP, or MVC separation. Business logic, SQL queries, and HTML markup are mixed within the same files, which reduces maintainability at scale. |
| 7 | **No Export Feature** | The report page supports browser print only. There is no functionality to export data as PDF or Excel (`.xlsx`). |
| 8 | **Hardcoded Database Credentials** | Database credentials are stored in plaintext inside `config/database.php` and are not managed via environment variables or a `.env` file. |
| 9 | **No Audit Trail** | There is no logging of who changed what and when. The system records `created_at` timestamps but does not track updates or deletions. |
| 10 | **Single-User, Single-Role** | The system is designed for a single operator. There is no concept of multiple users, permission levels, or concurrent session management. |

---

## Author

Developed as a personal portfolio project to demonstrate foundational full-stack web development skills using PHP, MySQL, and Bootstrap.

---

*Last updated: September 2026*
