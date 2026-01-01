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

<div class="content class-content">
    <h1>إنشاء صف دراسي جديد</h1>
@if(session('success'))
    <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif
@error('class_name')
    <div      style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 10px;"  >{{ $message }}</div>
@enderror

@error('section_type')
<div      style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 10px;"  >{{ $message }}</div>
 
@enderror

    <form action="{{ route('admin.store-class') }}" method="POST" class="class-form">
    @csrf
    <div class="form-grid">
        <div class="form-group">
             <input type="text" name="class_name" placeholder="مثال: الصف الأول" required>
        </div>
       
        <div class="form-group">
             <input type="text" name="section_name" placeholder="مثال: الشعبة الأولى" required>
        </div>

        <div class="form-group">
    <label for="section_type">  </label>
    <select name="section_type" id="section_type" required>
        <option value="">اختر نوع القسم</option>
        <option value="علمي" {{ old('section_type') == 'علمي' ? 'selected' : '' }}>علمي</option>
        <option value="أدبي" {{ old('section_type') == 'أدبي' ? 'selected' : '' }}>أدبي</option>
     </select>

</div>

        <div class="form-group">
             <input type="number" name="expected_students" min="0" placeholder="عدد الطلاب">
        </div>


        <div class="form-group">
             <input type="text" name="academic_year" placeholder="مثال: 2025-2026">
        </div>

        <div class="form-group">
             <textarea name="notes" placeholder="ملاحظات إضافية"></textarea>
        </div>
        <div class="form-actions">
        <button type="submit" class="btn-primary">إنشاء الصف</button>
        <button type="reset" class="btn-secondary">إلغاء</button>

</div>
    </div>
    </form>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
