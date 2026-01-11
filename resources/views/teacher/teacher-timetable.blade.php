<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')

<div class="content">
    <div class="page-header">
        <h1>البرنامج التدريسي</h1>
    </div>

 
    <div class="timetable-card">
        <table>
            <thead>
                <tr>
                    <th>اليوم</th>
                    <th>الحصة</th>
                    <th>الوقت</th>
                    <th>الصف</th>
                    <th>المادة</th>
                    <th>الفصل/الغرفة</th>
                 </tr>
            </thead>
            <tbody>
            @forelse ($timetable as $row)
    <tr>
        <td>{{ $row->day }}</td>
        <td>{{ $row->period }}</td>
        <td>{{ $row->time_from }} - {{ $row->time_to }}</td>
        <td>{{ $row->class->class_name ?? '-' }}</td>
        <td>{{ $row->subject->subject_name ?? '-' }}</td>
        <td>{{ $row->room }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6">لا يوجد بيانات</td>
    </tr>
@endforelse

</tbody>


        </table>
    </div>
</div>
<script src="{{ asset('js/teacher.js') }}"></script>

</body>
</html>