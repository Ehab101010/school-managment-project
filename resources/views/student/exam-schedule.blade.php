{{-- resources/views/student/exam-schedule.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جدول الامتحانات — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1><i class='bx bx-calendar-event'></i> جدول الامتحانات</h1>
            <div class="breadcrumb">
                <span>الرئيسية</span>
                <i class='bx bx-chevron-left'></i>
                <span>الامتحانات</span>
            </div>
        </div>
    </div>

    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-calendar-check'></i> مواعيد الامتحانات</span>
            <span style="font-size:13px; color:var(--text-muted);">{{ count($exams) }} امتحان</span>
        </div>

        @if(count($exams))
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المادة</th>
                        <th>التاريخ</th>
                        <th>اليوم</th>
                        <th>وقت الامتحان</th>
                        <th>القاعة</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">{{ $loop->iteration }}</td>
                        <td style="font-weight:700; color:var(--primary);">{{ $exam->subject->subject_name }}</td>
                        <td>
                            <div class="exam-date-badge" data-exam-date="{{ $exam->exam_date }}">
                                <span class="day-name">{{ $exam->day_of_week }}</span>
                                <span class="date-num">{{ \Carbon\Carbon::parse($exam->exam_date)->format('d/m') }}</span>
                            </div>
                        </td>
                        <td style="font-weight:600; color:var(--accent);">{{ $exam->day_of_week }}</td>
                        <td>
                            <span class="exam-time-badge">
                                <i class='bx bx-time'></i> {{ $exam->exam_time }}
                            </span>
                        </td>
                        <td>
                            <span class="room-badge">
                                <i class='bx bx-door-open'></i> {{ $exam->room }}
                            </span>
                        </td>
                        <td style="color:var(--text-muted); font-size:13px;">{{ $exam->notes ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class='bx bx-calendar-x'></i>
            <p>لا توجد امتحانات مجدولة حالياً</p>
        </div>
        @endif
    </div>

</div>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
