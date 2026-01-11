<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة معلم جديد</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')
<div class="content content-add-teacher">
    <h1>إضافة معلم جديد</h1>
    @if(session('username') && session('password'))
    <div style="background:#e0f7fa; padding:15px; border:2px solid #00acc1; margin-bottom:20px; border-radius:5px;">
        <h3 style="color:#00695c; margin-top:0;">تم إنشاء حساب المعلم بنجاح</h3>
        <p><strong>اسم المستخدم:</strong> <span style="font-family:monospace; background:#fff; padding:2px 5px;">{{ session('username') }}</span></p>
        <p><strong>كلمة المرور:</strong> <span style="font-family:monospace; background:#fff; padding:2px 5px;">{{ session('password') }}</span></p>
      
    </div>
    @endif

        <form class="teacher-form" method="POST" action="{{ route('admin.store-teacher') }}">
        @csrf
    <div class="form-grid">
         <div class="form-group">
                    <div class="input-with-icon">
                        <i class='bx bx-user'></i>
                        <input type="text" name="full_name" placeholder=" الاسم الكامل">
                    </div>
         </div>
        <div class="form-group">
        <div class="input-with-icon">
                        <i class='bx bx-female'></i>
                        <input type="text" name="mother_name" placeholder="اسم الأم">
                    </div>        </div>
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
                        <i class='bx bx-flag'></i>
                        <input type="text" name="nationality" placeholder="الجنسية">
                    </div>        
               </div>

        <div class="form-group">
       <div class="input-with-icon">
        <i class='bx bx-home'></i>
             <input type="text" name="address" placeholder="مكان السكن">
        </div>
        </div>

        <div class="form-group">
        <div class="input-with-icon">
                        <i class='bx bx-phone'></i>
                        <input type="tel" name="phone" placeholder="رقم الهاتف">
                        </div>
        </div>
      
        <div class="form-group">
        <div class="input-with-icon">
        <i class='bx bx-envelope'></i>
             <input type="email" name="email" placeholder="البريد الإلكتروني">
        </div>
</div>
        <div class="form-group full-width"> 
        <div class="input-with-icon">
        <i class='bx bx-note'></i>
             <textarea name="notes" rows="4" placeholder="ملاحظات"></textarea>
        </div>
</div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">إضافة المعلم</button>
        <button type="reset" class="btn-secondary">إلغاء</button>
    </div>
</form>
 


    </div>

    <script src="{{ asset('js/admin.js') }}"></script>


</body>
</html>
