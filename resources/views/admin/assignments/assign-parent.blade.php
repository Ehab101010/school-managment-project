<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعيين ولي أمر للطالب</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">ربط ولي أمر</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>
<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bxs-edit-alt'></i> تعيين ولي أمر للطالب</h1>
                <p>ربط ولي الأمر بالطالب في النظام</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-group'></i></div>
        </div>
    </div>
    <div class="assign-area">

        @if(session('success'))
            <div class="alert-success"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-danger"><i class='bx bx-error-circle'></i> {{ session('error') }}</div>
        @endif

        <div class="assign-form-wrap" style="max-width:600px;">
            <form method="POST" action="{{ route('admin.store-parent-assignment') }}">
                @csrf

                <div class="sf" style="margin-bottom:1rem;">
                    <label>ولي الأمر</label>
                    <div class="sf-input-wrap">
                        <i class='bx bx-user-check'></i>
                        <select name="parent_id" required>
                            <option value="">اختر ولي الأمر</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="sf" style="margin-bottom:1rem;">
                    <label>الصف</label>
                    <div class="sf-input-wrap">
                        <i class='bx bx-buildings'></i>
                        <select id="class_name">
                            <option value="">اختر الصف</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_name }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="sf" style="margin-bottom:1rem;">
                    <label>الشعبة</label>
                    <div class="sf-input-wrap">
                        <i class='bx bx-group'></i>
                        <select id="section_name">
                            <option value="">اختر الشعبة</option>
                        </select>
                    </div>
                </div>

                <div class="sf" style="margin-bottom:1rem;">
                    <label>الطالب</label>
                    <div class="sf-input-wrap">
                        <i class='bx bxs-graduation'></i>
                        <select name="student_id" id="student_select" required>
                            <option value="">اختر الطالب</option>
                        </select>
                    </div>
                </div>

                <div class="page-hero-actions" style="margin-top:1.5rem;">
                    <button type="submit" class="hero-btn"><i class='bx bx-link'></i> تعيين</button>
                    <button type="reset" class="hero-btn hero-btn-ghost"><i class='bx bx-x'></i> إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
<script>
initAssignParent(@json($sections));
</script>

</body>
</html>