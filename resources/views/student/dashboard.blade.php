{{-- resources/views/student/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرئيسية — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    {{-- Welcome Banner --}}
    <div class="welcome-banner fade-in">
        <div class="welcome-banner-inner">
            <div class="welcome-text-block">
                <h2>أهلاً وسهلاً، {{ $student->full_name }} 👋</h2>
                <p>
                    مرحباً بك في منصتك التعليمية الذكية!<br>
                    نتمنى لك تجربة دراسية مليئة بالإنجاز والتقدّم.<br>
                    استخدم القائمة الجانبية للتنقّل بين خدمات المدرسة.
                </p>
                <div class="welcome-badges">
                    <div class="welcome-badge">
                        <i class='bx bx-buildings'></i>
                        <span>{{ $student->class->class_name ?? '' }} - {{ $student->class->section_name ?? '' }}</span>
                    </div>
                    <div class="welcome-badge">
                        <i class='bx bx-calendar'></i>
                        <span>{{ now()->translatedFormat('l، j F Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="welcome-image-block">
                <img src="{{ asset('Images/robot.png') }}" alt="mascot">
            </div>
        </div>
    </div>

   

    {{-- Quick Actions --}}
    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-grid-alt'></i> الوصول السريع</span>
        </div>
        <div class="quick-actions">
            <a href="{{ route('student.timetable') }}" class="quick-action-card qa-purple">
                <div class="quick-action-icon"><i class='bx bx-calendar-week'></i></div>
                <div class="quick-action-label">الجدول الدراسي</div>
                <div class="quick-action-sub">عرض حصصك الأسبوعية</div>
            </a>
            <a href="{{ route('student.exams') }}" class="quick-action-card qa-amber">
                <div class="quick-action-icon"><i class='bx bx-calendar-event'></i></div>
                <div class="quick-action-label">جدول الامتحانات</div>
                <div class="quick-action-sub">مواعيد الامتحانات القادمة</div>
            </a>
            <a href="{{ route('student.grades') }}" class="quick-action-card qa-cyan">
                <div class="quick-action-icon"><i class='bx bx-bar-chart-alt-2'></i></div>
                <div class="quick-action-label">الدرجات</div>
                <div class="quick-action-sub">نتائجك ومجاميعك</div>
            </a>
            <a href="{{ route('student.content') }}" class="quick-action-card qa-green">
                <div class="quick-action-icon"><i class='bx bx-folder-open'></i></div>
                <div class="quick-action-label">المحتوى التعليمي</div>
                <div class="quick-action-sub">ملفات ومواد دراسية</div>
            </a>
            <a href="{{ route('student.profile') }}" class="quick-action-card qa-purple">
                <div class="quick-action-icon"><i class='bx bx-user-circle'></i></div>
                <div class="quick-action-label">بياناتي الشخصية</div>
                <div class="quick-action-sub">معلوماتي وبيانات التواصل</div>
            </a>
        </div>
    </div>

</div>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
