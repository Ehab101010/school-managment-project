<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم ولي الأمر</title>
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>

@include('includes.parent-sidebar')

<div class="content">
    <div class="welcome-screen">

        <div class="welcome-header">
            <div class="logo-badge">
                <i class='bx bxs-school'></i>
                نظام المدرسة الذكية
            </div>
            <h1>
                أهلاً وسهلاً،
                <span class="name-highlight">{{ auth()->user()->name }}</span>
                👋
            </h1>
            <p>اختر أحد أبنائك للاطلاع على لوحة تحكمه</p>
        </div>

        <div class="children-grid">
            @foreach($children as $child)
            <form method="POST" action="{{ route('parent.select-child') }}" class="child-form">
                @csrf
                <input type="hidden" name="child_id" value="{{ $child->student_id }}">
                <button type="submit" class="child-card-btn">
                    <div class="card-content">
                        <div class="avatar-ring">
                            <i class='bx bxs-graduation'></i>
                        </div>
                        <div class="child-name">{{ $child->full_name }}</div>
                        <div class="child-meta">
                            <span class="meta-tag">
                                <i class='bx bxs-buildings'></i>
                                {{ $child->class->class_name ?? 'غير محدد' }}
                            </span>
                            <span class="meta-tag">
                                <i class='bx bxs-group'></i>
                                {{ $child->class->section_name ?? 'غير محدد' }}
                            </span>
                        </div>
                        <div class="select-hint">
                            <i class='bx bx-log-in-circle'></i>
                            اضغط للدخول
                        </div>
                    </div>
                </button>
            </form>
            @endforeach
        </div>

    </div>
</div>

<script src="{{ asset('js/parent.js') }}"></script>
</body>
</html>