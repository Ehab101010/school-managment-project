
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الطالب</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.student-sidebar')

     <div class="content">
 
 <div class="schedule-container">
    <h1> جدول الامتحانات</h1>

    <table class="schedule-table">
<thead>
  <tr>
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
    <td>{{ $exam->subject->subject_name }}</td>
    <td>{{ $exam->exam_date }}</td>
    <td>{{ $exam->day_of_week }}</td>
    <td>{{ $exam->exam_time }}</td>
    <td>{{ $exam->room }}</td>
    <td>{{ $exam->notes ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>


</div>


    </div>

    <script src="{{ asset('js/student.js') }}"></script>

 

</body>
</html>



