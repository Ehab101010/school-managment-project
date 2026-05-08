<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الجدول الدراسي</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-primary fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-calendar-week'></i> الجدول الدراسي</h1>
                <p>برنامجك التدريسي الأسبوعي وجدول الحصص</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bxs-calendar'></i></div>
        </div>
    </div>

    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-time'></i> جدول الحصص الأسبوعي</span>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>اليوم</th>
                        <th>الحصة</th>
                        <th>الوقت</th>
                        <th>الصف</th>
                        <th>المادة</th>
                        <th>الفصل / الغرفة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($timetable as $row)
                    <tr>
                        <td>
                            <span class="day-badge">
                                <i class='bx bx-calendar-alt' style="margin-left:4px; font-size:13px;"></i>
                                {{ $row->day }}
                            </span>
                        </td>
                        <td>
                            <span class="period-badge">الحصة {{ $row->period }}</span>
                        </td>
                        <td style="direction:ltr; font-weight:600; color:var(--primary);">
                            {{ $row->time_from }} — {{ $row->time_to }}
                        </td>
                        <td style="font-weight:600;">{{ $row->class->class_name ?? '—' }}</td>
                        <td style="font-weight:700; color:var(--primary-light);">{{ $row->subject->subject_name ?? '—' }}</td>
                        <td>
                            <span style="background:rgba(0,194,179,0.08); color:var(--accent); padding:4px 12px; border-radius:20px; font-size:13px; font-weight:600;">
                                <i class='bx bx-door-open' style="font-size:13px;"></i>
                                {{ $row->room }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px; color:var(--text-muted); text-align:center;">
                            <i class='bx bx-calendar-x' style="font-size:40px; display:block; margin-bottom:8px; color:var(--border);"></i>
                            لا يوجد جدول دراسي متاح
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>