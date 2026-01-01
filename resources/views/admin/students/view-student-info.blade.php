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

     <div class="content content-view-stu"> 
        <div class="page-header">
        <h1>عرض بيانات الطلاب</h1>
     </div>

     <div class="card">
          <div class="toolbar">
         <form action="{{ route('admin.view-student') }}" method="GET">
     <div class="search-box">
         <input type="text" name="query" placeholder="البحث باسم الطالب" value="{{ request('query') }}">
         <button type="submit">بحث</button>
     </div>

 

         <div class="table-student-info">
    <table>
        <thead>
            <tr>
                <th>الاسم الكامل</th>
                <th>اسم الأم</th>
                <th>تاريخ الميلاد</th>
                <th>الجنس</th>
                <th>الصف</th>
                <th>الشعبة</th>
                <th>القسم</th>
                <th>الجنسية</th>
                <th>رقم هاتف الطالب</th>
                <th>رقم هاتف الأب</th>
                <th>رقم هاتف الأم</th>
                <th>ملاحظات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->mother_name }}</td>
                    <td>{{ $student->birth_date }}</td>
                    <td>
                    {{ $student->gender }}
 
</td>

                    <td>{{ $student->class ? $student->class->class_name : '-' }}</td>
            <td>
                @if($student->class)
                   
                    @if($student->class->section_name)
                        {{ $student->class->section_name }}
                    @endif
                @else
                    -
                @endif
            </td>
                    <td>{{ $student->section_type }}</td>
                    <td>{{ $student->nationality }}</td>
                    <td>{{ $student->student_phone_number }}</td>
                    <td>{{ $student->father_phone_number }}</td>
                    <td>{{ $student->mother_phone_number }}</td>
                     <td>{{ $student->notes ?$student->notes : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;">لا توجد بيانات طلاب متاحة</td>
                </tr>
            @endforelse
        </tbody>
    </table>
   
    @if ($students->hasPages())
<div class="pagination-container">
    <ul class="pagination">
         <li class="{{ $students->onFirstPage() ? 'disabled' : '' }}">
            <a href="{{ $students->previousPageUrl() ?? '#' }}" class="page-link">السابق</a>
        </li>

         @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
            <li class="{{ $page == $students->currentPage() ? 'active' : '' }}">
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
            </li>
        @endforeach

         <li class="{{ $students->hasMorePages() ? '' : 'disabled' }}">
            <a href="{{ $students->nextPageUrl() ?? '#' }}" class="page-link">التالي</a>
        </li>
    </ul>
</div>
@endif
</div>
 
</div>


</div>

        
  

    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>


</body>
</html>
