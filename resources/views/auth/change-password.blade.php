<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تغيير كلمة المرور | المنصة الدراسية</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/Login_Style.css">
</head>
<body>

<div class="ambient">
    <div class="ambient-orb orb-a" style="background:radial-gradient(circle, rgba(78,205,196,0.18), transparent)"></div>
    <div class="ambient-orb orb-b"></div>
    <div class="ambient-orb orb-c" style="background:radial-gradient(circle, rgba(78,205,196,0.10), transparent)"></div>
    <div class="grid-overlay"></div>
</div>

<div class="auth-center">

    <div class="logo-area">
        <div class="logo-ring cyan-ring">
            <div class="logo-icon"><i class='bx bxs-shield-alt-2'></i></div>
        </div>
        <div class="logo-text">
            <span class="logo-welcome"> كلمة المرور</span>
            <span class="logo-sub">تحديث كلمة المرور بأمان</span>
        </div>
    </div>

    <div class="card cyan-card">

        @if(session('success'))
        <div class="alert alert-success">
            <i class='bx bx-check-circle'></i>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <i class='bx bx-error-circle'></i>
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <div class="field">
                <label class="cyan-label">
                    <i class='bx bx-user'></i>
                    اسم المستخدم
                </label>
                <input type="text" name="username" placeholder="أدخل اسم المستخدم" required>
            </div>

            <div class="field">
                <label class="cyan-label">
                    <i class='bx bx-lock'></i>
                    كلمة المرور الحالية
                </label>
                <div class="input-wrap">
                    <input type="password" name="old_password" id="old_pass" placeholder="••••••••" required>
                    <button type="button" class="eye-btn" onclick="togglePass('old_pass', this)">
                        <i class='bx bx-hide'></i>
                    </button>
                </div>
            </div>

            <div class="field">
                <label class="cyan-label">
                    <i class='bx bx-lock-alt'></i>
                    كلمة المرور الجديدة
                </label>
                <div class="input-wrap">
                    <input type="password" name="new_password" id="new_pass" placeholder="••••••••" required>
                    <button type="button" class="eye-btn" onclick="togglePass('new_pass', this)">
                        <i class='bx bx-hide'></i>
                    </button>
                </div>
            </div>

            <div class="field">
                <label class="cyan-label">
                    <i class='bx bx-lock-open'></i>
                    تأكيد كلمة المرور الجديدة
                </label>
                <div class="input-wrap">
                    <input type="password" name="new_password_confirmation" id="confirm_pass" placeholder="••••••••" required>
                    <button type="button" class="eye-btn" onclick="togglePass('confirm_pass', this)">
                        <i class='bx bx-hide'></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login btn-cyan">
                <span>حفظ كلمة المرور</span>
                <i class='bx bx-check-shield'></i>
            </button>

        </form>

        <div class="card-footer">
            <a href="{{ route('login') }}">
                <i class='bx bx-arrow-back'></i>
                العودة لتسجيل الدخول
            </a>
        </div>

    </div>

    <p class="copyright">جميع الحقوق محفوظة &copy; {{ date('Y') }} — المنصة الدراسية الذكية</p>

</div>

<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bx bx-show';
    } else {
        input.type = 'password';
        icon.className = 'bx bx-hide';
    }
}
</script>
</body>
</html>
