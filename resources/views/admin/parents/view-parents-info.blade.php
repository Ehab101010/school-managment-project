<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض أولياء الأمور</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">أولياء الأمور</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bxs-group'></i> أولياء الأمور</h1>
                <p>جميع أولياء الأمور المسجلين في النظام</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bxs-group'></i></div>
        </div>
    </div>

    <div class="card">
        <div class="toolbar">
            <form action="{{ route('admin.view-parent-info') }}" method="GET">
                <div class="search-box">
                    <input type="text" name="query" placeholder="البحث بالاسم" value="{{ request('query') }}">
                    <button type="submit">بحث</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>الاسم الكامل</th><th>تاريخ الميلاد</th><th>الجنس</th>
                        <th>رقم الجوال</th><th>هاتف إضافي</th><th>هاتف المنزل</th>
                        <th>العنوان</th><th>الوظيفة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parents as $parent)
                    <tr>
                        <td><div class="tea-name-cell"><div class="tea-avatar">{{ mb_substr($parent->full_name,0,1) }}</div><span>{{ $parent->full_name }}</span></div></td>
                        <td>{{ $parent->birth_date }}</td>
                        <td>{{ $parent->gender ?? '—' }}</td>
                        <td>{{ $parent->phone_mobile }}</td>
                        <td>{{ $parent->additional_phone_number ?? '—' }}</td>
                        <td>{{ $parent->phone_home ?? '—' }}</td>
                        <td>{{ $parent->address ?? '—' }}</td>
                        <td>{{ $parent->job ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;color:var(--text-3);padding:2rem;">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($parents->hasPages())
        <div class="pagination-container">
            <ul class="pagination">
                <li class="{{ $parents->onFirstPage() ? 'disabled' : '' }}"><a href="{{ $parents->previousPageUrl() ?? '#' }}">السابق</a></li>
                @foreach($parents->getUrlRange(1, $parents->lastPage()) as $page => $url)
                    <li class="{{ $page == $parents->currentPage() ? 'active' : '' }}"><a href="{{ $url }}">{{ $page }}</a></li>
                @endforeach
                <li class="{{ $parents->hasMorePages() ? '' : 'disabled' }}"><a href="{{ $parents->nextPageUrl() ?? '#' }}">التالي</a></li>
            </ul>
        </div>
        @endif
    </div>

</div>

<script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>