# EWU Lost & Found Portal

CSE302 Database Management Systems lab project — a localized PHP/MySQL web app for reporting and managing lost/found campus items, matching the schema and features described in the lab report.

## Tech Stack
- Frontend: HTML5
- Backend: PHP (server-side logic, sessions)
- Database: MySQL (via phpMyAdmin)
- Server: Apache (XAMPP)

## Setup Instructions

1. **Install XAMPP** (or any Apache + MySQL + PHP stack).
2. **Copy the project folder** into your XAMPP `htdocs` directory, e.g.:
   ```
   C:\xampp\htdocs\ewu_lost_found\
   ```
3. **Start Apache and MySQL** from the XAMPP Control Panel.
4. **Create the database**:
   - Open phpMyAdmin (`http://localhost/phpmyadmin`).
   - Click "Import" and select `database.sql`, OR paste its contents into the SQL tab and run it.
   - This creates the `ewu_lost_found` database with `users` and `items` tables, plus sample data.
5. **Check `config.php`** — update `DB_USER` / `DB_PASS` if your MySQL setup differs from the XAMPP default (`root` / empty password).
6. **Visit the app**: `http://localhost/ewu_lost_found/`

## Test Accounts
All seeded accounts use the password: **1234**

| EWU ID           | Role    | Name                  |
|------------------|---------|-----------------------|
| 2024-1-60-141    | Student | Faiyaz Hossen         |
| 2024-1-60-250    | Student | Shariful Islam Akibe  |
| 2024-1-60-333    | Student | Fardin Shahriar       |
| admin-01         | Admin   | Jalal Uddin           |

## File Structure
```
ewu_lost_found/
├── database.sql        # Schema + sample data
├── config.php           # DB connection + session start
├── auth.php              # Login guard / admin guard
├── index.php              # Login page
├── dashboard.php           # Role-based item listing (Read)
├── report_item.php          # Report new item form (Create)
├── update_status.php         # Admin: mark item as Found (Update)
├── delete_item.php            # Delete item, RBAC enforced (Delete)
├── logout.php                  # Destroy session
└── style.css                    # Shared styling
```

## Role-Based Access Control
- **Student**: view all items, create new reports, delete only their own reports.
- **Admin**: view all items, update any item's status (Lost → Found), delete any listing.

## Security Notes
This is a teaching lab project, so passwords are stored as plain text (`VARCHAR(50)`) to match the schema in the report. All SQL queries use prepared statements to prevent SQL injection. For a production system, use `password_hash()` / `password_verify()` instead of plain-text comparison.
