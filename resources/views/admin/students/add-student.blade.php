<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة طالب جديد</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')

    <div class="content content-add-student">
        
        <h1>إضافة طالب جديد</h1>
        @if(session('username') && session('password'))
<div style="background:#e0f7fa; padding:15px; border:2px solid #00acc1; margin-bottom:20px; border-radius:5px;">
    <h3 style="color:#00695c; margin-top:0;">تم إنشاء حساب الطالب بنجاح</h3>
    <p><strong>اسم المستخدم:</strong> <span style="font-family:monospace; background:#fff; padding:2px 5px;">{{ session('username') }}</span></p>
    <p><strong>كلمة المرور:</strong> <span style="font-family:monospace; background:#fff; padding:2px 5px;">{{ session('password') }}</span></p>
  
</div>
@endif
 
<form class="student-form" method="POST" action="{{ route('admin.store-student') }}">
            @csrf
            <div class="form-grid">

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-user'></i>
                        <input type="text" name="full_name" placeholder="اكتب الاسم الكامل">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-female'></i>
                        <input type="text" name="mother_name" placeholder="اسم الأم">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                         <input type="date" name="birth_date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-male-female'></i>
                        <select name="gender">
                            <option value="">اختر</option>
                            <option value="ذكر">ذكر</option>
                            <option value="أنثى">أنثى</option>
                        </select>
                    </div>
                </div>

               

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-book'></i>
                        <select name="class_id" id="class_id" required>
                            <option value="">اختر القسم للتصفية</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_id }}" data-section-type="{{ $class->section_type }}">
                                    {{ $class->class_name }} - {{ $class->section_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-flag'></i>
                        <input type="text" name="nationality" placeholder="الجنسية">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-phone'></i>
                        <input type="tel" name="student_phone_number" placeholder="رقم الهاتف الخاص بالطالب">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-phone-call'></i>
                        <input type="tel" name="father_phone_number" placeholder="رقم الهاتف الخاص بالأب">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-phone-call'></i>
                        <input type="tel" name="mother_phone_number" placeholder="رقم الهاتف الخاص بالأم">
                    </div>
                </div>

                <div class="form-group full-width">
                    <div class="input-with-icon">
                        <i class='bx bx-note'></i>
                        <textarea name="notes" style="border:2px solid #517b7e" rows="4" placeholder="تفاصيل إضافية"></textarea>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">إضافة الطالب</button>
                <button type="reset" class="btn-secondary">إلغاء</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>