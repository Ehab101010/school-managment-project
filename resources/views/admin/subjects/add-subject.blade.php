<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مادة دراسية</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')
<div class="content content-add-subject">

    <h1> إضافة مادة دراسية جديدة</h1>
         @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
        @endif
      
        <form method="POST" class="subject-form" action="{{ route('admin.store-subject') }}">
            @csrf
            <div class="form-grid">
        <div class="form-group">
             <input type="text" name="subject_name" placeholder="أدخل اسم المادة" required>
        </div>

        <div class="form-group">
             <textarea name="description" rows="4" placeholder="أدخل وصف المادة"></textarea>
        </div>

        <div class="form-actions">
        <button type="submit" class="btn-primary">حفظ المادة</button>
        <button type="reset" class="btn-secondary">إلغاء</button>
    </div>
    </div>
    </form>
</div>
     <script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>
