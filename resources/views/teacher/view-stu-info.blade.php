<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بيانات الطلاب</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .stu-search-card {
            background: var(--card-bg); border-radius: var(--radius);
            padding: 20px 26px; border: 1px solid var(--border);
            box-shadow: var(--shadow-sm); margin-bottom: 20px;
            display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
        }
        .stu-search-label {
            font-weight: 700; color: var(--primary); font-size: 14.5px;
            white-space: nowrap; display: flex; align-items: center; gap: 6px;
        }
        .stu-search-label i { color: var(--accent-light); font-size: 18px; }
        .stu-search-input {
            flex: 1; min-width: 220px; max-width: 420px;
            display: flex; align-items: center;
            background: var(--bg); border: 1.5px solid var(--border);
            border-radius: var(--radius-sm); overflow: hidden; transition: border-color .18s;
        }
        .stu-search-input:focus-within { border-color: var(--accent-light); }
        .stu-search-input input {
            flex: 1; border: none; background: transparent;
            padding: 9px 14px; font-size: 14px;
            font-family: "Cairo", sans-serif; color: var(--text); outline: none;
        }
        .stu-search-input button {
            padding: 9px 16px; background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none; color: white; cursor: pointer; font-size: 16px;
            display: flex; align-items: center; transition: opacity .18s;
        }
        .stu-search-input button:hover { opacity: .88; }
        .stu-clear-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 8px 14px; background: var(--bg);
            border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            font-size: 13px; color: var(--text-muted); text-decoration: none;
            font-family: "Cairo", sans-serif; transition: all .18s;
        }
        .stu-clear-btn:hover { border-color: var(--danger); color: var(--danger); }

        .stu-table-card {
            background: var(--card-bg); border-radius: var(--radius);
            border: 1px solid var(--border); box-shadow: var(--shadow-sm);
            overflow: hidden; margin-bottom: 24px;
        }
        .stu-table-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 24px; border-bottom: 1.5px solid var(--bg);
            flex-wrap: wrap; gap: 10px;
        }
        .stu-table-title {
            font-size: 16px; font-weight: 700; color: var(--primary);
            display: flex; align-items: center; gap: 8px;
        }
        .stu-table-title i { color: var(--accent-light); font-size: 20px; }
        .stu-count-badge {
            background: linear-gradient(135deg, rgba(79,70,229,.08), rgba(129,140,248,.12));
            color: var(--primary-light); border: 1px solid rgba(99,102,241,.2);
            border-radius: 50px; padding: 4px 14px; font-size: 12.5px; font-weight: 700;
        }

        .stu-table-wrap { overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; }
        .stu-table-wrap table { min-width: 1050px; }

        .stu-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: inline-flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 13px; flex-shrink: 0;
        }
        .stu-name-cell { display: flex; align-items: center; gap: 10px; white-space: nowrap; }

        .gender-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 50px; font-size: 12px; font-weight: 700;
        }
        .gender-m { background: rgba(79,70,229,.08); color: var(--primary-light); border: 1px solid rgba(79,70,229,.18); }
        .gender-f { background: rgba(236,72,153,.08); color: #db2777; border: 1px solid rgba(236,72,153,.18); }
        .phone-cell { direction: ltr; white-space: nowrap; font-size: 13px; }
        .stu-empty { padding: 60px 24px; text-align: center; color: var(--text-muted); }
        .stu-empty i { font-size: 48px; color: var(--border); display: block; margin-bottom: 12px; }
        .stu-empty p { font-size: 15px; font-weight: 600; }
    </style>
</head>
<body>

@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-primary fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bxs-graduation'></i> بيانات الطلاب</h1>
                <p>عرض ومتابعة بيانات طلابك الدراسية والشخصية</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bxs-group'></i></div>
        </div>
    </div>

    <form action="{{ route('teacher.view-stu-info') }}" method="GET">
        <div class="stu-search-card fade-in">
            <span class="stu-search-label"><i class='bx bx-search-alt'></i> البحث عن طالب</span>
            <div class="stu-search-input">
                <input type="text" name="query" placeholder="ابحث باسم الطالب..." value="{{ request('query') }}">
                <button type="submit"><i class='bx bx-search'></i></button>
            </div>
            @if(request('query'))
            <a href="{{ route('teacher.view-stu-info') }}" class="stu-clear-btn">
                <i class='bx bx-x'></i> مسح
            </a>
            @endif
        </div>
    </form>

    <div class="stu-table-card fade-in">
        <div class="stu-table-header">
            <span class="stu-table-title"><i class='bx bx-group'></i> قائمة الطلاب</span>
            @if($students->total() ?? false)
            <span class="stu-count-badge"><i class='bx bx-user'></i> {{ $students->total() }} طالب</span>
            @endif
        </div>

        @if($students->isEmpty())
        <div class="stu-empty">
            <i class='bx bx-search-alt'></i>
            <p>{{ request('query') ? 'لم يُعثر على طلاب بهذا الاسم' : 'لا توجد بيانات طلاب متاحة' }}</p>
        </div>
        @else
        <div class="stu-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الطالب</th>
                        <th>اسم الأم</th>
                        <th>تاريخ الميلاد</th>
                        <th>الجنس</th>
                        <th>الصف</th>
                        <th>الشعبة</th>
                        <th>الجنسية</th>
                        <th>هاتف الطالب</th>
                        <th>هاتف الأب</th>
                        <th>هاتف الأم</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                    <tr>
                        <td style="color:var(--text-muted);font-weight:600;font-size:13px;">
                            {{ ($students->currentPage() - 1) * $students->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="stu-name-cell">
                                <div class="stu-avatar">{{ mb_substr($student->full_name, 0, 1) }}</div>
                                <span style="font-weight:700;color:var(--primary);">{{ $student->full_name }}</span>
                            </div>
                        </td>
                        <td>{{ $student->mother_name }}</td>
                        <td class="phone-cell">{{ $student->birth_date }}</td>
                        <td>
                            @php $isMale = in_array($student->gender, ['male','ذكر']); @endphp
                            <span class="gender-badge {{ $isMale ? 'gender-m' : 'gender-f' }}">
                                {{ $isMale ? '👦 ذكر' : '👧 أنثى' }}
                            </span>
                        </td>
                        <td style="font-weight:600;">{{ $student->class->class_name ?? '—' }}</td>
                        <td>{{ $student->class->section_name ?? '—' }}</td>
                        <td style="font-size:13px;">{{ $student->nationality ?? '—' }}</td>
                        <td class="phone-cell">{{ $student->student_phone_number ?? '—' }}</td>
                        <td class="phone-cell">{{ $student->father_phone_number ?? '—' }}</td>
                        <td class="phone-cell">{{ $student->mother_phone_number ?? '—' }}</td>
                        <td style="max-width:150px;color:var(--text-muted);font-size:13px;text-align:right;">
                            {{ $student->notes ? Str::limit($student->notes, 35) : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
        <div class="pagination-container" style="padding:16px 24px;">
            <ul class="pagination">
                <li class="{{ $students->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $students->previousPageUrl() ?? '#' }}"><i class='bx bx-chevron-right'></i></a>
                </li>
                @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                <li class="{{ $page == $students->currentPage() ? 'active' : '' }}">
                    <a href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach
                <li class="{{ $students->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $students->nextPageUrl() ?? '#' }}"><i class='bx bx-chevron-left'></i></a>
                </li>
            </ul>
        </div>
        @endif
        @endif
    </div>

</div>

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>
