{{-- resources/views/student/profile.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البيانات الشخصية — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1><i class='bx bx-user-circle'></i> البيانات الشخصية</h1>
            <div class="breadcrumb">
                <span>الرئيسية</span>
                <i class='bx bx-chevron-left'></i>
                <span>الملف الشخصي</span>
            </div>
        </div>
    </div>

    {{-- Profile Hero --}}
    <div class="profile-hero fade-in">
        <div class="profile-avatar-large">
            {{ mb_substr($student->full_name, 0, 1) }}
        </div>
        <div class="profile-hero-info">
            <h2>{{ $student->full_name }}</h2>
            <div class="profile-meta">
                <div class="profile-meta-item">
                    <i class='bx bx-buildings'></i>
                    <span>{{ $student->class->class_name ?? '' }} - {{ $student->class->section_name ?? '' }}</span>
                </div>
                <div class="profile-meta-item">
                    <i class='bx bx-calendar-star'></i>
                    <span>{{ $student->class->academic_year ?? '' }}</span>
                </div>
                <div class="profile-meta-item">
                    <i class='bx bx-flag'></i>
                    <span>{{ $student->nationality ?? '' }}</span>
                </div>
            </div>
        </div>
        <div class="profile-id-badge">
            <span class="id-label">رقم الطالب</span>
            <span class="id-value">#{{ $student->student_id }}</span>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="profile-grid">

        {{-- Personal Info --}}
        <div class="profile-info-card fade-in fade-in-delay-1">
            <div class="profile-info-title">
                <i class='bx bx-user'></i>
                المعلومات الشخصية
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-user'></i></div>
                <div>
                    <span class="info-label">الاسم الكامل</span>
                    <span class="info-value">{{ $student->full_name }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-user-circle'></i></div>
                <div>
                    <span class="info-label">اسم الأم</span>
                    <span class="info-value">{{ $student->mother_name }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-calendar'></i></div>
                <div>
                    <span class="info-label">تاريخ الميلاد</span>
                    <span class="info-value" style="direction:ltr; display:inline-block;">{{ $student->birth_date }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-user-pin'></i></div>
                <div>
                    <span class="info-label">الجنس</span>
                    <span class="info-value">{{ $student->gender == 'male' ? '👦 ذكر' : '👧 أنثى' }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-flag'></i></div>
                <div>
                    <span class="info-label">الجنسية</span>
                    <span class="info-value">{{ $student->nationality }}</span>
                </div>
            </div>
        </div>

        {{-- Academic Info --}}
        <div class="profile-info-card fade-in fade-in-delay-2">
            <div class="profile-info-title">
                <i class='bx bx-graduation'></i>
                المعلومات الدراسية
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-id-card'></i></div>
                <div>
                    <span class="info-label">رقم الطالب</span>
                    <span class="info-value">{{ $student->student_id }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-home'></i></div>
                <div>
                    <span class="info-label">الصف الدراسي</span>
                    <span class="info-value">{{ $student->class->class_name ?? '—' }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-buildings'></i></div>
                <div>
                    <span class="info-label">الشعبة</span>
                    <span class="info-value">{{ $student->class->section_name ?? '—' }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class='bx bx-calendar-star'></i></div>
                <div>
                    <span class="info-label">العام الدراسي</span>
                    <span class="info-value">{{ $student->class->academic_year ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="profile-info-card fade-in fade-in-delay-3" style="grid-column: 1 / -1;">
            <div class="profile-info-title">
                <i class='bx bx-phone'></i>
                معلومات التواصل
            </div>
            <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:0;">
                <div class="info-row" style="border-bottom:none; border-left: 1px solid var(--bg);">
                    <div class="info-icon"><i class='bx bx-phone'></i></div>
                    <div>
                        <span class="info-label">رقم الطالب</span>
                        <span class="info-value" style="direction:ltr; display:inline-block;">{{ $student->student_phone_number ?? '—' }}</span>
                    </div>
                </div>
                <div class="info-row" style="border-bottom:none; border-left: 1px solid var(--bg); padding-right:20px;">
                    <div class="info-icon"><i class='bx bx-phone-call'></i></div>
                    <div>
                        <span class="info-label">رقم الأب</span>
                        <span class="info-value" style="direction:ltr; display:inline-block;">{{ $student->father_phone_number ?? '—' }}</span>
                    </div>
                </div>
                <div class="info-row" style="border-bottom:none; padding-right:20px;">
                    <div class="info-icon"><i class='bx bx-phone-incoming'></i></div>
                    <div>
                        <span class="info-label">رقم الأم</span>
                        <span class="info-value" style="direction:ltr; display:inline-block;">{{ $student->mother_phone_number ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
