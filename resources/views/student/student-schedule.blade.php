{{-- resources/views/student/student-schedule.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الجدول الدراسي — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1><i class='bx bx-calendar-week'></i> الجدول الدراسي</h1>
            <div class="breadcrumb">
                <span>الرئيسية</span>
                <i class='bx bx-chevron-left'></i>
                <span>الجدول الدراسي</span>
            </div>
        </div>
    </div>

    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-time'></i> الجدول الأسبوعي</span>
        </div>

        <div class="table-wrapper">
            <table class="schedule-table">
                <thead>
                    <tr>
                        @foreach($days as $day)
                            <th>{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($periods as $period)
                    <tr>
                        @foreach($days as $day)
                        <td>
                            @if(isset($mapped[$day][$period]))
                            @php $slot = $mapped[$day][$period]; @endphp
                            <div class="schedule-cell">
                                <span class="subj-name">{{ $slot->subject->subject_name }}</span>
                                <span class="subj-time">
                                    <i class='bx bx-time-five'></i>
                                    {{ $slot->time_from }} - {{ $slot->time_to }}
                                </span>
                                <span class="subj-teacher">
                                    <i class='bx bx-user'></i>
                                    {{ $slot->teacher->full_name }}
                                </span>
                                <span class="subj-room">
                                    <i class='bx bx-door-open'></i> {{ $slot->room }}
                                </span>
                            </div>
                            @else
                            <span class="empty-cell">—</span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
