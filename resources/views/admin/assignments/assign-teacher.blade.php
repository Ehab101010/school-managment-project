<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعيين معلم إلى صف دراسي</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">ربط معلم</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>
<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bxs-edit-alt'></i> تعيين معلم إلى صف دراسي</h1>
                <p>ربط المعلم بالصف الدراسي والمادة</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-chalkboard'></i></div>
        </div>
    </div>
    <div class="assign-area">

        @if(session('success'))
            <div class="alert-success"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-danger"><i class='bx bx-error-circle'></i> {{ session('error') }}</div>
        @endif

        <form class="assign-form-wrap" method="POST" action="{{ route('admin.store-assignment') }}">
            @csrf

            <div class="sf" style="margin-bottom:1rem;">
                <label>المعلم</label>
                <div class="sf-input-wrap">
                    <i class='bx bx-user-badge'></i>
                    <select id="teacher" name="teacher_id" required>
                        <option value="">اختر المعلم</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->teacher_id }}">{{ $teacher->full_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sf" style="margin-bottom:1rem;">
                <label>الصف الدراسي</label>
                <div class="sf-input-wrap">
                    <i class='bx bx-buildings'></i>
                    <select id="class" name="class_id" required>
                        <option value="">اختر الصف</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->full_class_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sf" style="margin-bottom:1rem;">
                <label>المادة الدراسية</label>
                <div class="sf-input-wrap">
                    <i class='bx bx-book-open'></i>
                    <select id="subject" name="subject_id" required>
                        <option value="">اختر المادة</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="page-hero-actions" style="margin-top:1.5rem;">
                <button type="submit" class="hero-btn"><i class='bx bx-check'></i> تعيين المعلم</button>
                <button type="reset" class="hero-btn hero-btn-ghost"><i class='bx bx-x'></i> إلغاء</button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>