<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')

     <div class="content assign-content">
 
     <div class="page-header">
        <h1>عرض التعيينات </h1>
 
   
     <div class="card">
         <div class="toolbar">
         <form action="{{ route('admin.view-assignment') }}" method="GET">
     <div class="search-box">
         <input type="text" name="search" placeholder="البحث باسم الطالب" value="{{ request('search') }}">
         <button type="submit">بحث</button>
     </div>
     </div>

 

    @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    <table class="assign-table">
        <thead>
            <tr>
                <th>اسم المعلم</th>
                <th>المادة</th>
                <th>الصف</th>
                <th>الفصل الدراسي</th>
             </tr>
        </thead>
        <tbody>
        @foreach($assignments as $assignment)
<tr>
    <td>{{ $assignment->teacher->full_name }}</td>
    <td>{{ $assignment->subject->subject_name }}</td>
    <td>{{ $assignment->class->class_name }}</td>
    <td>{{ $assignment->class->section_name ?? 'غير محدد' }}</td>
 
</tr>
@endforeach

            </tbody>
    </table>
</div>

   

    <script src="{{ asset('js/admin.js') }}"></script>


</body>
</html>





