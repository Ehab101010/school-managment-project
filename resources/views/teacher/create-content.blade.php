<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء محتوى تعليمي</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.teacher-sidebar')

<div class="content create-content">


    <div class="page-header">
        <h1><i class='bx bx-book-add'></i> إنشاء محتوى تعليمي</h1>
     </div>
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
<div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px;">
{{ session('success') }}
    </div>
@endif
     <form action="{{ route('teacher.storeContent') }}" method="POST" enctype="multipart/form-data">
        @csrf
       
        <div class="form-group">
            <label>المادة الدراسية</label>
            <select name="subject_id" required>
                <option value="">اختر المادة</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                @endforeach
            </select>
        </div>

         <div class="form-group">
            <label>الصف الدراسي</label>
            <select name="class_id" required>
                <option value="">اختر الصف</option>
                @foreach($classes as $class)
                <option value="{{ $class->class_id }}">
    {{ $class->class_name }} - {{ $class->section_name }} ({{ $class->section_type }})
</option>
                @endforeach
            </select>
        </div>

         <div class="form-group">
            <label>عنوان المحتوى</label>
            <input type="text" name="title" required placeholder="مثال: درس العمليات الحسابية الأساسية">
        </div>
 <div class="form-group">
    <label>وصف المحتوى</label>
    <textarea name="description" required placeholder="اكتب وصفاً مختصراً للمحتوى"></textarea>
</div>

         <div class="form-group">
            <label>نوع المحتوى</label>
            <select name="content_type" id="content-type" required>
                <option value="">اختر النوع</option>
                <option value="video">فيديو</option>
                <option value="pdf">ملف PDF</option>
                <option value="excel">ملف Excel</option>
                <option value="assignment">واجب</option>
                <option value="link">رابط خارجي</option>
            </select>
        </div>

         <div class="form-group" id="pdf-input" style="display:none;">
            <label>رفع ملف PDF</label>
            <input type="file" name="pdf_file" accept=".pdf">
        </div>

         <div class="form-group" id="excel-input" style="display:none;">
            <label>رفع ملف Excel</label>
            <input type="file" name="excel_file" accept=".xls,.xlsx">
        </div>

         <div class="form-group" id="link-input" style="display:none;">
            <label>رابط خارجي</label>
            <input type="url" name="external_link" placeholder="https://example.com">
        </div>

        <button type="submit" class="btn-primary">إضافة المحتوى</button>
    </form>
</div>

<script>
     const typeSelect = document.getElementById("content-type");
    const pdfInput = document.getElementById("pdf-input");
    const excelInput = document.getElementById("excel-input");
    const linkInput = document.getElementById("link-input");

    typeSelect.addEventListener("change", function () {
        const type = this.value;

        pdfInput.style.display = "none";
        excelInput.style.display = "none";
        linkInput.style.display = "none";

        if (type === "pdf") pdfInput.style.display = "block";
        if (type === "excel") excelInput.style.display = "block";
     });
</script>
<script src="{{ asset('js/teacher.js') }}"></script>

</body>
</html>
