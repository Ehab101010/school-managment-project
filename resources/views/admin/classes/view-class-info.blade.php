<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء صف دراسي</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
@include('includes.admin-sidebar')

<div class="content class-content" style="">
  
    <h1>الصفوف الدراسية الحالية</h1>
    
    <table>
        <thead>
            <tr>
                <th>اسم الصف</th>
                <th>القسم</th>
                 <th>عدد الطلاب</th>
                <th>العام الدراسي</th>
                <th>القسم </th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $class)
            <tr>
                <td>{{ $class->class_name }}</td>
                <td>{{ $class->section_name ?? '-' }}</td>
                 <td>{{ $class->expected_students }}</td>
                <td>{{ $class->academic_year }}</td>
                <td>{{ $class->section_type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
