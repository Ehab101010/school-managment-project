<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض بيانات الطلاب</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">الطلاب</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bxs-graduation'></i> الطلاب</h1>
                <p>جميع الطلاب المسجلين في النظام</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bxs-graduation'></i></div>
        </div>
    </div>

    <div class="card">
        <div class="toolbar">
            <form action="{{ route('admin.view-student-info') }}" method="GET">
                <div class="search-box">
                    <input type="text" name="query" placeholder="البحث باسم الطالب" value="{{ request('query') }}">
                    <button type="submit">بحث</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>الاسم الكامل</th><th>اسم الأم</th><th>تاريخ الميلاد</th>
                        <th>الجنس</th><th>الصف</th><th>الشعبة</th><th>القسم</th>
                        <th>الجنسية</th><th>رقم الطالب</th><th>رقم الأب</th>
                        <th>رقم الأم</th><th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td><div class="tea-name-cell"><div class="tea-avatar">{{ mb_substr($student->full_name,0,1) }}</div><span>{{ $student->full_name }}</span></div></td>
                        <td>{{ $student->mother_name }}</td>
                        <td>{{ $student->birth_date }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->class ? $student->class->class_name : '—' }}</td>
                        <td>{{ $student->class ? ($student->class->section_name ?? '—') : '—' }}</td>
                        <td>{{ $student->section_type }}</td>
                        <td>{{ $student->nationality }}</td>
                        <td>{{ $student->student_phone_number }}</td>
                        <td>{{ $student->father_phone_number }}</td>
                        <td>{{ $student->mother_phone_number }}</td>
                        <td>{{ $student->notes ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="12" style="text-align:center; color:var(--text-3); padding:2rem;">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
        <div class="pagination-container">
            <ul class="pagination">
                <li class="{{ $students->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $students->previousPageUrl() ?? '#' }}" class="page-link">السابق</a>
                </li>
                @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                    <li class="{{ $page == $students->currentPage() ? 'active' : '' }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="{{ $students->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $students->nextPageUrl() ?? '#' }}">التالي</a>
                </li>
            </ul>
        </div>
        @endif
    </div>

</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
