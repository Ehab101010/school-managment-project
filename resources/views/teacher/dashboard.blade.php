<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المعلم</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.teacher-sidebar')

<div class="content">

   {{-- Welcome Banner --}}
<div class="welcome-banner fade-in">
    <div class="wb-inner">
        <div class="wb-text">
            {{-- هنا التعديل: نستخدم اسم المعلم الكامل من جدول المدرسين --}}
            <h2>المعلم : {{ $teacher->full_name ?? 'المعلم' }}</h2>
            <p>مرحباً بك في لوحة تحكم المعلم — إدارة محتواك التعليمي ودرجات طلابك بكل سهولة</p>
            
            <div class="welcome-meta">
                <div class="welcome-meta-item">
                    <i class='bx bx-calendar'></i>
                    <span>{{ now()->translatedFormat('l، j F Y') }}</span>
                </div>
                <div class="welcome-meta-item">
                    <i class='bx bx-time'></i>
                    <span>الفصل الدراسي الأول</span>
                </div>
            </div>
        </div>
        <div class="wb-icon-wrap">
            <i class='bx bxs-user-badge'></i>
        </div>
    </div>
</div>

   

    {{-- Quick Actions --}}
    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-grid-alt'></i> الإجراءات السريعة</span>
        </div>
        <div class="quick-actions">
            <a href="{{ route('teacher.add-grades') }}" class="quick-action-card qa-blue">
                <div class="quick-action-icon"><i class='bx bx-edit-alt'></i></div>
                <div class="quick-action-label">إضافة درجات</div>
                <div class="quick-action-sub">تسجيل درجات الطلاب</div>
            </a>
            <a href="{{ route('teacher.create-content') }}" class="quick-action-card qa-teal">
                <div class="quick-action-icon"><i class='bx bx-plus-circle'></i></div>
                <div class="quick-action-label">إضافة محتوى</div>
                <div class="quick-action-sub">رفع مواد تعليمية</div>
            </a>
            <a href="{{ route('teacher.view-content') }}" class="quick-action-card qa-orange">
                <div class="quick-action-icon"><i class='bx bx-folder-open'></i></div>
                <div class="quick-action-label">المحتوى التعليمي</div>
                <div class="quick-action-sub">عرض وإدارة المحتوى</div>
            </a>
            <a href="{{ route('teacher.timetable') }}" class="quick-action-card qa-green">
                <div class="quick-action-icon"><i class='bx bx-time-five'></i></div>
                <div class="quick-action-label">الجدول الدراسي</div>
                <div class="quick-action-sub">عرض حصصك الأسبوعية</div>
            </a>
        </div>
    </div>

</div>

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>