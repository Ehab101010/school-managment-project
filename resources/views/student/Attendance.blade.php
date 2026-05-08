<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل الحضور</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1><i class='bx bx-calendar-check'></i> الحضور والغياب</h1>
        </div>
    </div>

    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-book-open'></i> الحضور حسب المادة</span>
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
                                <span class="status-pill pill-green">{{ $s['present'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($s['absent'] > 0)
                                <span class="status-pill pill-red">{{ $s['absent'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @if($s['late'] > 0)
                                <span class="status-pill pill-yellow">{{ $s['late'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @php $effective = $s['absent'] + $s['late_as_absent']; @endphp
                            @if($effective > 0)
                                <span class="status-pill pill-red">{{ $effective }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top:2px solid var(--border);">
                        <td style="font-weight:700; color:var(--text);">المجموع الكلي</td>
                        <td><span class="status-pill pill-green">{{ $totalPresent }}</span></td>
                        <td><span class="status-pill pill-red">{{ $totalAbsent }}</span></td>
                        <td><span class="status-pill pill-yellow">{{ $totalLate }}</span></td>
                        <td><span class="status-pill pill-red">{{ $totalAbsent + $totalLateAsAbsent }}</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style="padding:10px 18px; font-size:12px; color:var(--text-muted); border-top:1px solid var(--border);">
            * كل 3 تأخيرات تُحتسب غياباً واحداً
        </div>
        @endif
    </div>

</div>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>