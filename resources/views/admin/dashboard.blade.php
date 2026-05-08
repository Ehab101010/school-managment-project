<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard2026.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="dash-body">

<div class="ambient-bg">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

@include('includes.admin-sidebar')

<main class="ds-main">

    {{-- Topbar --}}
    <header class="ds-topbar">
        <div class="ds-breadcrumb">
            <i class='bx bx-home-smile'></i>
            <span class="ds-breadcrumb-current">لوحة التحكم</span>
        </div>
        <div class="ds-topbar-right">
            <div class="ds-topbar-date">
                <i class='bx bx-calendar-event'></i>
                <span>{{ now()->translatedFormat('l، j F Y') }}</span>
            </div>
            <div class="ds-topbar-badge">
                <i class='bx bxs-crown'></i>
                <span>مدير</span>
            </div>
        </div>
    </header>
 

    {{-- Stats --}}
    <div class="ds-stats">
        <div class="ds-stat ds-s1 ds-fade-in ds-d1">
            <div class="ds-stat-top">
                <div class="ds-stat-icon"><i class='bx bxs-graduation'></i></div>
                <div class="ds-stat-trend"><i class='bx bx-trending-up'></i></div>
            </div>
            <div class="ds-stat-num">{{ \App\Models\Student::count() }}</div>
            <div class="ds-stat-label">إجمالي الطلاب</div>
      
        </div>
        <div class="ds-stat ds-s2 ds-fade-in ds-d2">
            <div class="ds-stat-top">
                <div class="ds-stat-icon"><i class='bx bxs-user-badge'></i></div>
                <div class="ds-stat-trend"><i class='bx bx-trending-up'></i></div>
            </div>
            <div class="ds-stat-num">{{ \App\Models\Teacher::count() }}</div>
            <div class="ds-stat-label">المعلمون</div>
      
        </div>
        <div class="ds-stat ds-s3 ds-fade-in ds-d3">
            <div class="ds-stat-top">
                <div class="ds-stat-icon"><i class='bx bxs-group'></i></div>
                <div class="ds-stat-trend"><i class='bx bx-trending-up'></i></div>
            </div>
            <div class="ds-stat-num">{{ \App\Models\StudentParent::count() }}</div>
            <div class="ds-stat-label">أولياء الأمور</div>
      
        </div>
        <div class="ds-stat ds-s4 ds-fade-in ds-d4">
            <div class="ds-stat-top">
                <div class="ds-stat-icon"><i class='bx bxs-building-house'></i></div>
                <div class="ds-stat-trend"><i class='bx bx-trending-up'></i></div>
            </div>
            <div class="ds-stat-num">{{ \App\Models\ClassModel::count() }}</div>
            <div class="ds-stat-label">الصفوف الدراسية</div>
      
        </div>
    </div>

</main>

<script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>