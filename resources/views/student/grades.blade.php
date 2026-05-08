{{-- resources/views/student/grades.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدرجات — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1><i class='bx bx-bar-chart-alt-2'></i> الدرجات</h1>
            <div class="breadcrumb">
                <span>الرئيسية</span>
                <i class='bx bx-chevron-left'></i>
                <span>الدرجات</span>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    @if(count($grades))
    @php
        $avg     = $grades->avg(fn($g) => $g->first_exam + $g->second_exam + $g->activity + $g->final_exam);
        $highest = $grades->max(fn($g) => $g->first_exam + $g->second_exam + $g->activity + $g->final_exam);
    @endphp
    <div class="stats-grid fade-in" style="grid-template-columns: repeat(3, 1fr); max-width: 580px;">
        <div class="stat-card purple">
            <div class="stat-icon"><i class='bx bx-book'></i></div>
            <div>
                <div class="stat-value">{{ count($grades) }}</div>
                <div class="stat-label">عدد المواد</div>
            </div>
        </div>
        <div class="stat-card cyan">
            <div class="stat-icon"><i class='bx bx-trending-up'></i></div>
            <div>
                <div class="stat-value">{{ number_format($avg, 1) }}</div>
                <div class="stat-label">المعدل العام</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon"><i class='bx bx-trophy'></i></div>
            <div>
                <div class="stat-value">{{ $highest }}</div>
                <div class="stat-label">أعلى درجة</div>
            </div>
        </div>
    </div>
    @endif

    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-list-ul'></i> تفاصيل الدرجات</span>
        </div>

        @if(count($grades))
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المادة</th>
                        <th>المذاكرة الأولى <small style="opacity:.7;">/15</small></th>
                        <th>المذاكرة الثانية <small style="opacity:.7;">/15</small></th>
                        <th>النشاط <small style="opacity:.7;">/20</small></th>
                        <th>الامتحان النهائي <small style="opacity:.7;">/50</small></th>
                        <th>المجموع <small style="opacity:.7;">/100</small></th>
                        <th>التقدير</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $grade)
                    @php
                        $total = $grade->first_exam + $grade->second_exam + $grade->activity + $grade->final_exam;
                        if      ($total >= 90) $letter = ['ممتاز',   'pass'];
                        elseif  ($total >= 80) $letter = ['جيد جداً','pass'];
                        elseif  ($total >= 70) $letter = ['جيد',     'good'];
                        elseif  ($total >= 60) $letter = ['مقبول',   'good'];
                        else                   $letter = ['راسب',    'fail'];
                    @endphp
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">{{ $loop->iteration }}</td>
                        <td style="font-weight:700; text-align:right; color:var(--primary);">{{ $grade->subject->subject_name }}</td>
                        <td>
                            <span style="font-weight:600;">{{ $grade->first_exam }}</span>
        
                        </td>
                        <td>
                            <span style="font-weight:600;">{{ $grade->second_exam }}</span>
                        
                        </td>
                        <td>
                            <span style="font-weight:600;">{{ $grade->activity }}</span>
               
                        </td>
                        <td>
                            <span style="font-weight:600;">{{ $grade->final_exam }}</span>
               
                        </td>
                        <td>
                            <span class="grade-total {{ $letter[1] }}" style=" background-color:transparent">{{ $total }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $letter[1] === 'pass' ? 'badge-excel' : ($letter[1] === 'good' ? 'badge-assignment' : 'badge-pdf') }}">
                                {{ $letter[0] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class='bx bx-bar-chart'></i>
            <p>لم يتم إدخال درجات بعد</p>
        </div>
        @endif
    </div>

</div>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
