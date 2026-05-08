<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل الحضور والغياب</title>
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>
@include('includes.parent-sidebar')

<div class="content">
<div class="attendance-page">

    {{-- ترويسة الطالب --}}
    <div class="student-header">
        <div class="student-avatar"><i class='bx bxs-user'></i></div>
        <div class="student-info">
            <h2>{{ $student->full_name }}</h2>
            <div class="student-badges">
                <span class="student-badge">
                    <i class='bx bx-buildings'></i>
                    {{ $student->class->class_name ?? '---' }}
                    @if($student->class->section_name ?? false)
                        - {{ $student->class->section_name }}
                    @endif
                </span>
            </div>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="btn-back">
            <i class='bx bx-arrow-back'></i> رجوع
        </a>
    </div>

    {{-- جدول المواد --}}
    <div class="table-card">
        <div class="table-card-header">
            <div class="ttl"><i class='bx bx-book-open'></i> الحضور حسب المادة</div>
        </div>

        @if($subjectStats->isEmpty())
        <div class="empty-state">
            <i class='bx bx-calendar-x'></i>
            <p>لا توجد سجلات حتى الآن</p>
        </div>
        @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>المادة</th>
                        <th>حاضر</th>
                        <th>غائب</th>
                        <th>متأخر</th>
                        <th>غياب فعلي <p style="font-size:10px; margin:0;">(كل 3 تأخيرات = غياب 1)</p></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjectStats as $s)
                    <tr>
                        <td style="font-weight:600;">{{ $s['subject_name'] }}</td>
                        <td>
                            @if($s['present'] > 0)
                                <span class="badge badge-present">{{ $s['present'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($s['absent'] > 0)
                                <span class="badge badge-absent">{{ $s['absent'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($s['late'] > 0)
                                <span class="badge badge-late">{{ $s['late'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @php $effective = $s['absent'] + $s['late_as_absent']; @endphp
                            @if($effective > 0)
                                <span class="badge badge-absent">{{ $effective }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top:2px solid var(--border);">
                        <td style="font-weight:700;">المجموع الكلي</td>
                        <td><span class="badge badge-present">{{ $totalPresent }}</span></td>
                        <td><span class="badge badge-absent">{{ $totalAbsent }}</span></td>
                        <td><span class="badge badge-late">{{ $totalLate }}</span></td>
                        <td><span class="badge badge-absent">{{ $totalAbsent + $totalLateAsAbsent }}</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>
 
        @endif
    </div>

</div>
</div>

<script src="{{ asset('js/parent.js') }}"></script>
</body>
</html>