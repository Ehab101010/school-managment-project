<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض موظفي شؤون الطلاب</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">الموظفون</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-id-card'></i> موظفو شؤون الطلاب</h1>
                <p>جميع موظفي شؤون الطلاب المسجلين في النظام</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bx-id-card'></i></div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success fade-in"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="toolbar">
            <form action="{{ route('admin.view-staff') }}" method="GET">
                <div class="search-box">
                    <input type="text" name="search" placeholder="البحث باسم الموظف" value="{{ request('search') }}">
                    <button type="submit">بحث</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>الاسم الكامل</th><th>تاريخ الميلاد</th><th>الجنس</th>
                        <th>الجنسية</th><th>السكن</th><th>الهاتف</th>
                        <th>البريد</th><th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $member)
                    <tr>
                        <td><div class="tea-name-cell"><div class="tea-avatar">{{ mb_substr($member->full_name,0,1) }}</div><span>{{ $member->full_name }}</span></div></td>
                        <td>{{ $member->birth_date ?? '-' }}</td>
                        <td>{{ $member->gender }}</td>
                        <td>{{ $member->nationality ?? '-' }}</td>
                        <td>{{ $member->address ?? '-' }}</td>
                        <td>{{ $member->phone ?? '-' }}</td>
                        <td>{{ $member->email ?? '-' }}</td>
                        <td>{{ $member->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($staff->hasPages())
        <div class="pagination-container">
            <ul class="pagination">
                <li class="{{ $staff->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $staff->previousPageUrl() ?? '#' }}" class="page-link">السابق</a>
                </li>
                @foreach ($staff->getUrlRange(1, $staff->lastPage()) as $page => $url)
                    <li class="{{ $page == $staff->currentPage() ? 'active' : '' }}">
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="{{ $staff->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $staff->nextPageUrl() ?? '#' }}" class="page-link">التالي</a>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
