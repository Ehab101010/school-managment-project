<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم - {{ $child->full_name }}</title>
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>

@include('includes.parent-sidebar')

<div class="content">
    <div class="dashboard-wrapper">

        {{-- ترويسة الطالب --}}
        <div class="student-header">

            {{-- يسار: أيقونة الطالب --}}
            <div class="student-avatar">
                <i class='bx bxs-user-circle'></i>
            </div>

            {{-- وسط: معلومات الطالب --}}
            <div class="student-info">
                <h2>{{ $child->full_name }}</h2>
                <div class="student-badges">
                    <span class="student-badge">
                        <i class='bx bxs-buildings'></i>
                        {{ $child->class->class_name ?? 'غير محدد' }}
                    </span>
                    <span class="student-badge">
                        <i class='bx bxs-group'></i>
                        {{ $child->class->section_name ?? 'غير محدد' }}
                    </span>
                </div>
            </div>

            {{-- يمين: زر العودة --}}
            <a href="{{ route('parent.clear-child') }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                تغيير الابن
            </a>

        </div>

        {{-- الروابط السريعة --}}
        <div class="section-title">الخدمات المتاحة</div>

        <div class="quick-links">
            <a href="{{ route('parent.grades') }}" class="quick-link-card">
                <div class="ql-icon blue"><i class='bx bxs-bar-chart-alt-2'></i></div>
                <span>الدرجات</span>
            </a>
            <a href="{{ route('parent.attendance') }}" class="quick-link-card">
                <div class="ql-icon green"><i class='bx bxs-calendar-check'></i></div>
                <span>الحضور والغياب</span>
            </a>
 
            <a href="{{ route('parent.announcements') }}" class="quick-link-card">
                <div class="ql-icon red"><i class='bx bxs-bell'></i></div>
                <span>الإعلانات</span>
            </a>
            <a href="{{ route('parent.messages') }}" class="quick-link-card">
                <div class="ql-icon purple"><i class='bx bxs-message-dots'></i></div>
                <span>الرسائل</span>
            </a>
        </div>

    </div>
</div>

<script src="{{ asset('js/parent.js') }}"></script>
</body>
</html>