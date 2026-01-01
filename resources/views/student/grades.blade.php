
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
    <h1>   الدرجات</h1>

    <table class="schedule-table">
    <thead>
          <tr>
            <th>المادة</th>
            <th>المذاكرة الأولى</th>
            <th>المذاكرة الثانية</th>
            <th>النشاط</th>
            <th>الامتحان النهائي</th>
            <th>المجموع</th>
          </tr>
        </thead>
        <tbody>
@foreach($grades as $grade)
<tr>
    <td>{{ $grade->subject->subject_name }}</td>
    <td>{{ $grade->first_exam }}</td>
    <td>{{ $grade->second_exam }}</td>
    <td>{{ $grade->activity }}</td>
    <td>{{ $grade->final_exam }}</td>
    <td>{{ $grade->first_exam + $grade->second_exam + $grade->activity + $grade->final_exam }}</td>
</tr>
@endforeach
</tbody>


</div>


    </div>

    <script src="{{ asset('js/student.js') }}"></script>

 

</body>
</html>



