<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البيانات الشخصية للطالب</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.student-sidebar')

<div class="content content-profile">
     <h1>البيانات الشخصية</h1>

     <div class="profile-section">

        <div class="info-row">
            <i class='bx bx-user'></i>
            <span>الاسم الكامل: {{ $student->full_name }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-user-circle'></i>
            <span>اسم الأم: {{ $student->mother_name }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-calendar'></i>
            <span>تاريخ الميلاد: {{ $student->birth_date }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-user-pin'></i>
            <span>الجنس: {{ $student->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-flag'></i>
            <span>الجنسية: {{ $student->nationality }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-id-card'></i>
            <span>رقم الطالب: {{ $student->student_id }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-home'></i>
            <span>الصف: {{ $student->class->class_name }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-buildings'></i>
            <span>الشعبة: {{ $student->class->section_name }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-calendar-star'></i>
            <span>العام الدراسي: {{ $student->class->academic_year }}</span>
        </div>

    </div>

     <div class="profile-section contact" style="margin-top:40px">

        <div class="info-row">
            <i class='bx bx-phone'></i>
            <span>رقم الأب: {{ $student->father_phone_number }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-phone'></i>
            <span>رقم الأم: {{ $student->mother_phone_number }}</span>
        </div>

        <div class="info-row">
            <i class='bx bx-phone'></i>
            <span>رقم الطالب: {{ $student->student_phone_number }}</span>
        </div>

    </div>

</div>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
