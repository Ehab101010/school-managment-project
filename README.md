# EDU School Management System

A web-based School Management System developed using the Laravel framework.
This project is designed as an academic application to manage school operations
including classes, subjects, teachers, students, timetables, exams, and grades.

---

## Project Features

- User authentication and role-based access (Admin, Teacher, Student)
- Class and subject management
- Teacher and student management
- Class-subject assignments
- Timetables and exam schedules
- Grade management
- Learning content management
- Clean MVC architecture using Laravel

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

## 🗄 Database Initialization : SQL Import

Import the SQL file located at:
database/sql/school_db

## ▶️ Running the Application

```bash
php artisan serve
```

## 🔐 Default Test Users

Admin

username: admin

Password: admin123

Teacher

username: ahmad.ali

Password: 123

Student

username: student_19

Password: 123456

## ⚠️ The project report is available in :

Report/Project Report
