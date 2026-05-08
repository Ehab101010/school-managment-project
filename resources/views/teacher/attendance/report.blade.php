{{-- resources/views/teacher/attendance/report.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير الحضور</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')

<div class="content">
<div class="att-page">

@if(!isset($classId))
{{-- ═══════════════════════════════════════
     الشاشة الأولى — كروت الفصول والمواد
════════════════════════════════════════ --}}

    <div class="page-hero hero-primary fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-bar-chart-alt-2'></i> تقارير الحضور</h1>
                <p>اختر الفصل والمادة لعرض تقرير الحضور الشهري</p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.attendance.index') }}" class="hero-btn hero-btn-ghost">
                    <i class='bx bx-arrow-back'></i> تسجيل حضور
                </a>
                <div class="hero-icon-wrap"><i class='bx bxs-report'></i></div>
            </div>
        </div>
    </div>

    {{-- كروت الفصول --}}
    <div class="assignments-grid">
        @forelse($assignments as $classId => $items)
            @foreach($items as $a)
            <a href="{{ route('teacher.attendance.report', [
                'class_id'   => $classId,
                'subject_id' => $a->subject_id,
            ]) }}" class="assignment-card">

                {{-- أيقونة المادة --}}
                <div class="ac-icon"><i class='bx bx-bar-chart-alt-2'></i></div>

                <div class="ac-class">
                    {{ $a->classRoom->class_name ?? '' }}
                    @if($a->classRoom->section_name ?? '')
                        — {{ $a->classRoom->section_name }}
                    @endif
                </div>
                <div class="ac-subject">{{ $a->subject->subject_name ?? '' }}</div>
                <div class="ac-section">{{ $a->classRoom->section_type ?? '' }}</div>

                <div class="ac-footer">
                    <span class="ac-report-badge">
                        <i class='bx bx-file-blank'></i> عرض التقرير
                    </span>
                    <i class='bx bx-chevron-left ac-arrow'></i>
                </div>
            </a>
            @endforeach
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:3rem; color:var(--text-muted);">
                <i class='bx bx-folder-open' style="font-size:3rem; display:block; margin-bottom:1rem;"></i>
                لا توجد فصول مسندة إليك
            </div>
        @endforelse
    </div>

@else
{{-- ═══════════════════════════════════════
     الشاشة الثانية — التقرير الفعلي
════════════════════════════════════════ --}}

    <div class="page-hero hero-primary fade-in" style="margin-bottom:1.5rem;">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-bar-chart-alt-2'></i> تقرير الحضور الشهري</h1>
                <p>
                    {{ $assignment->classRoom->class_name ?? '' }}
                    @if($assignment->classRoom->section_name ?? '') — {{ $assignment->classRoom->section_name }} @endif
                    @if($assignment->subject->subject_name ?? '') &nbsp;|&nbsp; {{ $assignment->subject->subject_name }} @endif
                </p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.attendance.report') }}" class="hero-btn hero-btn-ghost">
                    <i class='bx bx-arrow-back'></i> الفصول
                </a>
                <div class="hero-icon-wrap"><i class='bx bxs-report'></i></div>
            </div>
        </div>
    </div>

    {{-- فلتر الشهر --}}
    <form method="GET" action="{{ route('teacher.attendance.report') }}" class="month-form">
        <input type="hidden" name="class_id"   value="{{ $classId }}">
        <input type="hidden" name="subject_id" value="{{ $subjectId }}">
        <label><i class='bx bx-calendar'></i> الشهر:</label>
        <input type="month" name="month" value="{{ $month }}">
        <button type="submit"><i class='bx bx-search'></i> عرض</button>
    </form>

 

    {{-- رسالة نجاح --}}
    @if(session('success'))
        <div class="alert-success">
            <i class='bx bx-check-circle'></i> {{ session('success') }}
        </div>
    @endif

    {{-- الجدول --}}
    <div class="att-card">
        <div class="att-card-header">
            <div class="att-card-header-title">
                <i class='bx bxs-report'></i>
                تقرير شهر: {{ \Carbon\Carbon::parse($month.'-01')->translatedFormat('F Y') }}
                — ({{ $students->count() }} طالب)
            </div>
        </div>

        <div class="att-table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الطالب</th>
                        <th>أيام الحضور</th>
                        <th>غيابات مباشرة</th>
                        <th>تأخيرات</th>
 
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $i => $student)
                    @php $s = $summary[$student->student_id]; @endphp
                    <tr>
                        <td style="color:var(--att-muted);font-size:.8rem;">{{ $i + 1 }}</td>
                        <td>
                            <div class="tea-name-cell">
                                <div class="tea-avatar">{{ mb_substr($student->full_name, 0, 1) }}</div>
                                {{ $student->full_name }}
                            </div>
                        </td>
                        <td>
                            <span class="stat-pill sp-green">
                                <i class='bx bx-check-circle'></i> {{ $s['present'] }} يوم
                            </span>
                        </td>
                        <td>
                            <span class="stat-pill sp-red">
                                <i class='bx bx-x-circle'></i> {{ $s['absent'] }}
                            </span>
                        </td>
                        <td>
                            <span class="stat-pill sp-yellow">
                                <i class='bx bx-time'></i> {{ $s['late'] }} تأخير
                            </span>
                        </td>
  
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--att-muted)">
                            <i class='bx bx-folder-open' style="font-size:2rem"></i>
                            <p>لا توجد سجلات حضور لهذا الشهر</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

 

@endif

</div>
</div>

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>