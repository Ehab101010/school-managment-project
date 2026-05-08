<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفوف الدراسية</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">الصفوف الدراسية</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-buildings'></i> الصفوف الدراسية</h1>
                <p>جميع الصفوف المسجلة في النظام</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bx-buildings'></i></div>
        </div>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>اسم الصف</th><th>الشعبة</th><th>عدد الطلاب المتوقع</th><th>العام الدراسي</th><th>النوع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                    <tr>
                        <td><strong style="color:var(--text-1);">{{ $class->class_name }}</strong></td>
                        <td>{{ $class->section_name ?? '—' }}</td>
                        <td>{{ $class->expected_students }}</td>
                        <td>{{ $class->academic_year }}</td>
                        <td>
                            @if($class->section_type === 'علمي')
                                <span class="badge badge-blue">{{ $class->section_type }}</span>
                            @else
                                <span class="badge badge-purple">{{ $class->section_type }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>