# LifeFlow — Blood Bank & Donation Management System
## DBMS Project Setup Guide

---

## Project Structure

```
blood_bank/
│
├── index.html              ← Main website (single-page app)
│
├── css/
│   └── style.css           ← All styles
│
├── js/
│   └── main.js             ← All JavaScript (API calls, UI logic)
│
├── api/
│   ├── db_connect.php      ← MySQL connection + helpers
│   ├── donors.php          ← Donor register & search API
│   ├── requests.php        ← Blood request API
│   ├── inventory.php       ← Inventory API
│   └── admin_login.php     ← Admin auth API
│
└── sql/
    └── blood_bank.sql      ← Full database schema + sample data
```

---

## Requirements

| Tool | Version |
|------|---------|
| XAMPP / WAMP / LAMP | Any recent version |
| PHP | 7.4 or higher |
| MySQL | 5.7 or higher |
| Browser | Chrome / Firefox / Edge |

---

## Setup Steps

### Step 1 — Install XAMPP
Download from: https://www.apachefriends.org
Install and start **Apache** and **MySQL** from the XAMPP Control Panel.

### Step 2 — Copy Project Files
Copy the entire `blood_bank` folder to:
```
C:\xampp\htdocs\blood_bank\        (Windows)
/opt/lampp/htdocs/blood_bank/      (Linux/Mac)
```

### Step 3 — Create the Database
1. Open your browser and go to: http://localhost/phpmyadmin
2. Click **"New"** in the left panel
3. Type database name: `blood_bank_db` → click **Create**
4. Click the database → click **Import** tab
5. Click **Choose File** → select `sql/blood_bank.sql`
6. Click **Go** at the bottom

That's it! All tables + sample data will be created automatically.

### Step 4 — Configure DB Password (if needed)
Open `api/db_connect.php` and update:
```php
define('DB_USER', 'root');    // your MySQL username
define('DB_PASS', '');        // your MySQL password (blank by default in XAMPP)
```

### Step 5 — Run the Website
Open your browser and visit:
```
http://localhost/blood_bank/
```

---

## Default Admin Login
- Username: `admin`
- Password: `admin123`

> Change this in production! The password is stored as a bcrypt hash in the `admins` table.

---

## Pages Overview

| Page | URL / Nav | Description |
|------|-----------|-------------|
| Home | Default | Landing page with stats and features |
| Donor Registration | Donate | Register new blood donors (saves to DB) |
| Find Blood | Find Blood | Search donors + submit blood requests |
| Blood Inventory | Inventory | Real-time stock from DB |
| Admin Dashboard | Admin Panel | Manage donors, requests, inventory |
| About & Contact | About | Team info and contact form |

---

## Database Tables

| Table | Purpose |
|-------|---------|
| `admins` | Admin user accounts |
| `donors` | Registered blood donors |
| `blood_requests` | Patient blood requests |
| `blood_inventory` | Current stock per blood group |
| `donations` | Log of all donations |

---

## API Endpoints

| Method | URL | Action |
|--------|-----|--------|
| GET | `api/donors.php` | Get all donors (supports ?blood_group=&city=&availability=) |
| POST | `api/donors.php` | Register new donor |
| GET | `api/requests.php` | Get blood requests |
| POST | `api/requests.php` | Submit new blood request |
| PUT | `api/requests.php` | Update request status (admin) |
| GET | `api/inventory.php` | Get full inventory |
| PUT | `api/inventory.php` | Update units for a blood group |
| POST | `api/inventory.php` | Log a donation + update inventory |
| POST | `api/admin_login.php` | Admin login |

---

## How It Works (Without PHP)
The website works as a static site too — it just shows sample data.
To enable real database connection, you need XAMPP running.

---

## Troubleshooting

**"Connection refused" / blank page**
→ Make sure Apache and MySQL are running in XAMPP Control Panel

**"Access denied for user root"**
→ Open phpMyAdmin → User accounts → set password for root or update `db_connect.php`

**Page not loading properly**
→ Make sure the folder is inside `htdocs` and you are accessing via `localhost` not `file://`
