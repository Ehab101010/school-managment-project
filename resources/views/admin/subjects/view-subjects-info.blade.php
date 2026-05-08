<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المواد الدراسية</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">المواد الدراسية</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-book-open'></i> المواد الدراسية</h1>
                <p>جميع المواد المسجلة في النظام</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bx-book-open'></i></div>
        </div>
    </div>
    <div class="card">
        <div class="toolbar">
            <form action="{{ route('admin.view-subjects-info') }}" method="GET">
                <div class="search-box">
                    <input type="text" name="search" placeholder="البحث باسم المادة" value="{{ request('search') }}">
                    <button type="submit">بحث</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>اسم المادة</th><th>الوصف</th><th>القسم</th></tr></thead>
                <tbody>
                    @foreach($subjects as $subject)
                    <tr>
                        <td><strong style="color:var(--text-1);">{{ $subject->subject_name }}</strong></td>
                        <td>{{ $subject->description }}</td>
                        <td><span class="badge badge-teal">{{ $subject->subject_type }}</span></td>
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