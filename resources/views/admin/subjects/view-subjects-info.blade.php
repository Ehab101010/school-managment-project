<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المواد الدراسية</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')

    <div class="content content-view-subjects">
        <h1>  المواد الدراسية</h1>

   
        <div class="card">
          <div class="toolbar">
         <form action="{{ route('admin.view-subjects-info') }}" method="GET">
     <div class="search-box">
         <input type="text" name="search" placeholder="البحث باسم الطالب" value="{{ request('search') }}">
         <button type="submit">بحث</button>
     </div>

    
        </div>
         <table>
            <thead>
                <tr>
                     <th>اسم المادة</th>
                    <th>الوصف</th>
                    <th>القسم</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($subjects as $subject)
            <tr>
                 <td>{{ $subject->subject_name }}</td>
                <td>{{ $subject->description }}</td>
                <td>{{ $subject->subject_type }}</td>
           
            </tr>
        @endforeach
    </tbody>
        </table>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>
