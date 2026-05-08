# EDU School Management System

A web-based School Management System developed using the Laravel framework.
This project is designed as an academic application to manage school operations
including classes, subjects, teachers, students, timetables, exams, grades, and parent communication.

---

## Project Features

- User authentication and role-based access (Admin, Teacher, Student, Parent)
- Class and subject management
- Teacher and student management
- Class-subject assignments and teacher assignments
- Timetables and exam schedules
- Grade management
- Learning content management
- Attendance tracking (students & teachers)
- Messaging and announcements system
- Parent portal (view child's grades, attendance, schedule, and content)
- Monthly reports
- Clean MVC architecture using Laravel

---

## User Roles

| Role    | Description                                                                |
| ------- | -------------------------------------------------------------------------- |
| Admin   | Full system control: manage users, classes, subjects, assignments, reports |
| Teacher | Manage content, grades, attendance, and communicate with students/parents  |
| Student | View schedule, grades, content, attendance, and receive messages           |
| Parent  | View child's academic info, grades, attendance, and receive announcements  |

---

## Technologies Used

- Laravel Framework
- PHP
- MySQL
- Blade Templates
- HTML, CSS, JavaScript
- XAMPP / Apache
- Git & GitHub

---

## Installation & Setup

Follow the steps below to run the project locally:

### 1️⃣ Clone the repository

```bash
git clone https://github.com/Ehab101010/school-managment-project.git
cd school-managment-project
```

### 2️⃣ Install dependencies

```bash
composer install
npm install
npm run build
```

### 3️⃣ Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 🗄️ Database Initialization: SQL Import

Import the SQL file located at:

```
database/sql/school_db
```

### ▶️ Running the Application

```bash
php artisan serve
```

---

## 🔐 Default Test Users

| Role    | Username   | Password   |
| ------- | ---------- | ---------- |
| Admin   | admin      | admin123   |
| Teacher | ahmad.ali  | teacher123 |
| Student | student_17 | student123 |
| Parent  | parent_4   | parent123  |

---

## ⚠️ Project Report

The project report is available at:

```
Report/Project Report
```
