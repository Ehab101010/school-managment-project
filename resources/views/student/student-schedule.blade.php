
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
    <h1>الجدول الدراسي</h1>

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
                        <strong>{{ $mapped[$day][$period]->subject->subject_name }}</strong><br>
                        <span>{{ $mapped[$day][$period]->time_from }} - {{ $mapped[$day][$period]->time_to }}</span><br>
                        <span>{{ $mapped[$day][$period]->teacher->full_name }}</span><br>
                        <span>قاعة: {{ $mapped[$day][$period]->room }}</span>
                    @else
                        -
                    @endif
                </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>


</div>



    </div>

    <script src="{{ asset('js/student.js') }}"></script>

 

</body>
</html>



