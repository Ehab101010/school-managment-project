<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المعلمين</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')

<div class="content content-view-teachers"> 
    <div class="page-header">
        <h1>عرض بيانات المعلمين</h1>
    </div>
     <div class="card">
         <div class="toolbar">
        <form action="{{ route('admin.view-teacher-info') }}" method="GET">
    <div class="search-box">
        <input type="text" name="search" placeholder="البحث باسم الطالب" value="{{ request('search') }}">
        <button type="submit">بحث</button>
    </div>
</form>
 

    </div>

    <div class="table-teacher-info">
        <table>
            <thead>
                <tr>
                    <th>الاسم الكامل</th> 
                    <th>اسم الام</th> 
                    <th>تاريخ الميلاد</th>
                    <th>الجنس</th>
                    <th>الجنسية</th>
                     <th>السكن</th>
                    <th>رقم الهاتف</th>
                    <th>البريد الإلكتروني</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
            <tbody>
@foreach($teachers as $teacher)
<tr>
    <td>{{ $teacher->full_name }}</td>
    <td>{{ $teacher->mother_name }}</td>
    <td>{{ $teacher->birth_date }}</td>
    <td>{{ $teacher->gender }}</td>
    <td>{{ $teacher->nationality }}</td>
     <td>{{ $teacher->address }}</td>
    <td>{{ $teacher->phone }}</td>
    <td>{{ $teacher->email }}</td>
    <td>{{ $teacher->notes ?$teacher->notes  : '-'}}</td>
 
</tr>
@endforeach
</tbody>


        </table>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
