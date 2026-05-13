# 🎓 Students Fees Management System

---

## 📋 Overview

This is a **Students Fees Management System** that I built and submitted as my **Final Examination project** for the Web Design and Development course at the **Adventist University of Central Africa (AUCA)**, Faculty of Information Technology.

The system demonstrates practical skills in full-stack web development using HTML, CSS, PHP, and MySQL — covering all core concepts taught throughout the semester including database connectivity, session management, and CRUD operations.

---

## 🏫 Exam Information

| Detail | Info |
|---|---|
| **Institution** | Adventist University of Central Africa (AUCA) |
| **Faculty** | Faculty of Information Technology |
| **Course** | Web Design and Development |
| **Assessment Type** | Final Examination |
| **Academic Year** | 2025 / 2026 |
| **Location** | Kigali, Rwanda |

---

## 🗂️ Project Structure

```
FEES_MANAGEMENT/
│
├── login.php          → Login page (entry point)
├── login.html         → HTML structure reference only
├── login.css          → Styles for the login form
│
├── fees.php           → Main fees management dashboard (working file)
├── fees.html          → HTML structure reference only
├── fees.css           → Styles for the fees dashboard
│
├── index.php          → Session check & redirect to fees.php
│
├── db.php             → Database connection for FinalExam2026 (login)
├── db2.php            → Database connection for DBGroupA2026 (fees data)
│
└── setup.sql          → SQL script to create databases and tables
```

---

## ⚙️ Technologies Used

- **Frontend:** HTML5, CSS3
- **Backend:** PHP (Server-side scripting)
- **Database:** MySQL (via MySQLi extension)
- **Server:** Apache (XAMPP / WAMP)
- **Session Management:** PHP Sessions

---

## 🗄️ Database Design

### Database 1 — `FinalExam2026`
Used for user authentication.

| Table | Purpose |
|---|---|
| `Logger2026` | Stores login credentials |

### Database 2 — `DBGroupA2026`
Used for storing fees records.

| Table | Purpose |
|---|---|
| `Fees2026` | Stores all student fee records |

### `Fees2026` Table Fields

| Field | Type | Description |
|---|---|---|
| `id` | INT (AUTO) | Primary Key |
| `student_name` | VARCHAR | Full name of student |
| `student_id` | VARCHAR | Unique student identifier |
| `academic_year` | VARCHAR | e.g. 2025/2026 |
| `no_of_courses` | INT | Number of registered courses |
| `total_credits` | INT | Total credit hours |
| `amount_per_credit` | DECIMAL | Cost per credit hour |
| `registration_fees` | DECIMAL | Fixed registration fee |
| `final_project` | DECIMAL | Final project fee |
| `graduation_fees` | DECIMAL | Graduation fee |
| `total_fees` | DECIMAL | Calculated total |

---

## 🔐 Login Credentials

| Username | Password |
|---|---|
| `admin` | `1234` |
| `student` | `pass123` |

---

## 🚀 How to Run

### Prerequisites
- XAMPP or WAMP installed
- Apache and MySQL services running

### Steps

**1.** Copy the project folder into your server's web root:
```
C:/xampp/htdocs/FEES_MANAGEMENT/
```

**2.** Start **Apache** and **MySQL** from the XAMPP Control Panel.

**3.** Open your browser and go to:
```
http://localhost/FEES_MANAGEMENT/login.php
```

**4.** Log in using the credentials above.

> ⚠️ **Important:** Never open files directly from the file system (e.g. `C:/xampp/.../login.html`). PHP only works when accessed through `http://localhost`.

---

## 🧩 System Features

| Feature | Description |
|---|---|
| 🔐 **Login System** | Secure session-based authentication |
| 💾 **Save Data** | Insert new student fee records into the database |
| 📋 **Retrieve Data** | Fetch and display all records from the database |
| 👁️ **Display** | Show only the latest 4 records |
| ✏️ **Update Fees** | Update total fees for a specific student by ID |
| 🗑️ **Delete** | Remove a specific student record or all records |
| 🧮 **Calculate** | Automatically compute total fees from input fields |
| 🖨️ **Print** | Print the current page |
| ❌ **Cancel** | Clear all input fields |
| 🚪 **Exit / Logout** | Destroy session and redirect to login |

---

## 📐 Fee Calculation Formula

```
Total Fees = (Total Credits × Amount per Credit)
           + Registration Fees
           + Final Project Fee
           + Graduation Fees
```

---

## 📌 Notes

- `fees.html` and `login.html` are **reference files only** — always use the `.php` versions.
- Databases and tables are **auto-created on first run** — no need to manually run `setup.sql`.
- Passwords are stored as plain text for exam simplicity. In production, use `password_hash()`.

---

*Built and submitted as a Final Exam project — AUCA, Faculty of Information Technology, 2026.*
