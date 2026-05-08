<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض التعيينات</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">التعيينات</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>
<div class="content assign-content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-list-ul'></i> عرض التعيينات</h1>
                <p>قائمة بجميع تعيينات المعلمين على الصفوف والمواد</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-chalkboard'></i></div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert-danger"><i class='bx bx-error-circle'></i> {{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert-success"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="toolbar">
            <form action="{{ route('admin.view-assignment') }}" method="GET">
                <div class="search-box">
                    <input type="text" name="search" placeholder="البحث باسم المعلم" value="{{ request('search') }}">
                    <button type="submit">بحث</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>اسم المعلم</th>
                        <th>المادة</th>
                        <th>الصف</th>
                        <th>الشعبة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->teacher->full_name }}</td>
                        <td>{{ $assignment->subject->subject_name }}</td>
                        <td>{{ $assignment->class->class_name }}</td>
                        <td>{{ $assignment->class->section_name ?? 'غير محدد' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>