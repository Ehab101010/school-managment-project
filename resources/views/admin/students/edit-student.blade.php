<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات الطلاب</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

 <div class="content content-edit-student">
    <div class="page-header">
        <h1> تعديل بيانات الطلاب</h1>
        <p>قائمة بجميع الطلاب المسجلين مع خيارات التعديل والحذف.</p>
    </div>
@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif
 

@if(session('error'))
    <div class="alert-danger">
        {{ session('error') }}
    </div>
@endif
 
     <div class="card">
         <div class="toolbar">
        <form action="{{ route('admin.edit-student') }}" method="GET">
    <div class="search-box">
        <input type="text" name="query" placeholder="البحث باسم الطالب" value="{{ request('query') }}">
        <button type="submit">بحث</button>
    </div>
</form>


         <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                         <th>رقم الطالب</th>
                        <th>الاسم الكامل</th>
                        <th>اسم الأم </th>
                        <th>تاريخ الميلاد</th>
                        <th>الجنس</th>
                         <th>الجنسية </th>
                        <th>رقم الطالب</th>
                        <th>رقم الأب</th>
                        <th>رقم الأم</th>
                        <th> الملاحظات</th>
        
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->student_id }}</td>
            <td>{{ $student->full_name }}</td>
            <td>{{ $student->mother_name }}</td>
            <td>{{ $student->birth_date }}</td>
            <td>{{ $student->gender }}</td>
             <td>{{ $student->nationality }}</td>
            <td>{{ $student->student_phone_number }}</td>
            <td>{{ $student->father_phone_number }}</td>
            <td>{{ $student->mother_phone_number }}</td>
            <td>{{ $student->notes?$student->notes:'-'  }}</td>
            <td>
            <button class="btn-edit" onclick="openEditModal({{  $student->student_id }})">
    تعديل
</button>
    <form action="{{ route('admin.delete-student', $student->student_id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">
            حذف
        </button>
    </form>
</td>
        </tr>
 
        @endforeach
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

 
 <div id="editModal" class="modal" style="display:none;">
     <div class="modal-content">
        <h2>تعديل بيانات الطالب</h2>

        <form id="editForm" method="POST">
            @csrf

            <label>الاسم الكامل</label>
            <input type="text" name="full_name" id="full_name">

            <label>اسم الأم</label>
            <input type="text" name="mother_name" id="mother_name">

            <label>تاريخ الميلاد</label>
            <input type="date" name="birth_date" id="birth_date">

            <label>الجنس</label>
            <select name="gender" id="gender">
                <option value="male">ذكر</option>
                <option value="female">أنثى</option>
            </select>
     
   

 
            <label>الجنسية</label>
            <input type="text" name="nationality" id="nationality">

            <label>رقم الطالب</label>
            <input type="text" name="student_phone_number" id="student_phone_number">

            <label>رقم الأب</label>
            <input type="text" name="father_phone_number" id="father_phone_number">

            <label>رقم الأم</label>
            <input type="text" name="mother_phone_number" id="mother_phone_number">

            <label>ملاحظات</label>
            <textarea name="notes" id="notes"></textarea>

            <div class="modal-buttons">
                <button type="submit" class="btn-save">حفظ</button>
                <button type="button" class="btn-cancel" onclick="closeModal()">إلغاء</button>
            </div>
        </form>
 </div>
</div>
 


{{-- كود JavaScript لفتح وغلق القائمة الجانبية --}}
<script src="{{ asset('js/admin.js') }}"></script>


</body>
</html>
