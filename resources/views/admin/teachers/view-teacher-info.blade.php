<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض بيانات المعلمين</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">المعلمون</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bxs-user-badge'></i> المعلمون</h1>
                <p>جميع المعلمين المسجلين في النظام</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bxs-user-badge'></i></div>
        </div>
    </div>

    <div class="card">
        <div class="toolbar">
            <form action="{{ route('admin.view-teacher-info') }}" method="GET">
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
                        <th>الاسم الكامل</th><th>اسم الأم</th><th>تاريخ الميلاد</th>
                        <th>الجنس</th><th>الجنسية</th><th>السكن</th>
                        <th>الهاتف</th><th>البريد</th><th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                    <tr>
                        <td><div class="tea-name-cell"><div class="tea-avatar">{{ mb_substr($teacher->full_name,0,1) }}</div><span>{{ $teacher->full_name }}</span></div></td>
                        <td>{{ $teacher->mother_name }}</td>
                        <td>{{ $teacher->birth_date }}</td>
                        <td>{{ $teacher->gender }}</td>
                        <td>{{ $teacher->nationality }}</td>
                        <td>{{ $teacher->address }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->notes ?? '—' }}</td>
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
