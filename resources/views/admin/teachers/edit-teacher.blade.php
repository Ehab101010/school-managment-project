<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title>عرض وتعديل بيانات المعلمين</title>
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')

 <div class="content content-edit-teacher">
    <div class="page-header">
        <h1> تعديل بيانات المعلمين</h1>
        <p>قائمة بجميع المعلمين المسجلين مع خيارات التعديل والحذف وتعيين الصفوف.</p>
    </div>
    @if(session('success'))
    <div class=" alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class=" alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="card">
         <div class="toolbar">
        <form method="GET" action="{{ route('admin.edit-teacher') }}">
    <div class="search-box">
        <input type="text" name="search" placeholder="البحث باسم المعلم أو المادة" value="{{ request('search') }}">
        <button type="submit">بحث</button>
    </div>
</form>

 
        </div>

         <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم الكامل</th>
                        <th> اسم الام</th>
                        <th>تاريخ الميلاد</th>
                        <th> الجنس</th>
                        <th> الجنسية</th>
                         <th>السكن </th>
                        <th>رقم الهاتف </th>
                        <th>البريد الإلكتروني</th>
                        <th>الملاحظات </th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
@foreach($teachers as $teacher)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $teacher->full_name }}</td>
    <td>{{ $teacher->mother_name }}</td>
    <td>{{ $teacher->birth_date }}</td>
    <td>{{ $teacher->gender }}</td>
    <td>{{ $teacher->nationality }}</td>
     <td>{{ $teacher->address }}</td>
    <td>{{ $teacher->phone }}</td>
    <td>{{ $teacher->email }}</td>
    <td>{{ $teacher->notes }}</td>
    <td>
     <button class="btn-edit" onclick="openTeacherModal({{ $teacher->teacher_id }})">
    تعديل
</button>

     <form action="{{ route('admin.delete-teacher', $teacher->teacher_id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا المعلم؟')">
            حذف
        </button>
    </form>
</td>

</tr>
@endforeach
</tbody>

            </table>
            @if ($teachers->hasPages())
<div class="pagination-container">
    <ul class="pagination">
        <li class="{{ $teachers->onFirstPage() ? 'disabled' : '' }}">
            <a href="{{ $teachers->previousPageUrl() ?? '#' }}" class="page-link">السابق</a>
        </li>

        @foreach ($teachers->getUrlRange(1, $teachers->lastPage()) as $page => $url)
            <li class="{{ $page == $teachers->currentPage() ? 'active' : '' }}">
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
            </li>
        @endforeach

        <li class="{{ $teachers->hasMorePages() ? '' : 'disabled' }}">
            <a href="{{ $teachers->nextPageUrl() ?? '#' }}" class="page-link">التالي</a>
        </li>
    </ul>
</div>
@endif

        </div>
        
 
    </div>
</div>
<div id="teacherModal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>تعديل بيانات المعلم</h2>

        <form id="teacherForm" method="POST">
            @csrf

            <label>الاسم الكامل</label>
            <input type="text" name="full_name" id="t_full_name">

            <label>اسم الأم</label>
            <input type="text" name="mother_name" id="t_mother_name">

            <label>تاريخ الميلاد</label>
            <input type="date" name="birth_date" id="t_birth_date">

            <label>الجنس</label>
            <select name="gender" id="t_gender">
                <option value="male">ذكر</option>
                <option value="female">أنثى</option>
            </select>

            <label>الجنسية</label>
            <input type="text" name="nationality" id="t_nationality">

            <label>المواد المتقنة</label>
            <input type="text" name="subject" id="t_subject">

            <label>السكن</label>
            <input type="text" name="address" id="t_address">

            <label>رقم الهاتف</label>
            <input type="text" name="phone" id="t_phone">

            <label>البريد الإلكتروني</label>
            <input type="email" name="email" id="t_email">

            <label>ملاحظات</label>
            <textarea name="notes" id="t_notes"></textarea>

            <div class="modal-buttons">
                <button type="submit" class="btn-save">حفظ</button>
                <button type="button" class="btn-cancel" onclick="closeTeacherModal()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

 

 <script src="{{ asset('js/admin.js') }}"></script>


</body>
</html>
