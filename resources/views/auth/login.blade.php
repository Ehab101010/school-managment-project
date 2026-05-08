<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | المنصة الدراسية</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/Login_Style.css">
</head>
<body>

<div class="ambient">
    <div class="ambient-orb orb-a"></div>
    <div class="ambient-orb orb-b"></div>
    <div class="ambient-orb orb-c"></div>
    <div class="grid-overlay"></div>
</div>

<div class="auth-center">

    <div class="logo-area">
        <div class="logo-ring">
            <div class="logo-icon"><i class='bx bxs-graduation'></i></div>
        </div>
        <div class="logo-text">
            <span class="logo-welcome">أهلاً بك</span>
            <span class="logo-sub">المنصة الدراسية الإلكترونية</span>
        </div>
    </div>

    <div class="card">

        @if(session('lockout'))
        <div class="alert alert-locked">
            <div class="locked-icon"><i class='bx bxs-lock-alt'></i></div>
            <div>
                <strong>الحساب مقفل مؤقتاً</strong>
                <p>تجاوزت الحد المسموح من المحاولات. يرجى الانتظار <span id="lockTimer">{{ session('lockout_remaining', 300) }}</span> ثانية.</p>
            </div>
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

        @if(session('success'))
        <div class="alert alert-success">
            <i class='bx bx-check-circle'></i>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('attempts') && session('attempts') > 0 && !session('lockout'))
        <div class="attempts-bar">
            <div class="attempts-label">
                <i class='bx bx-shield-alt-2'></i>
                المحاولات المتبقية: <strong>{{ 3 - session('attempts') }}</strong> من 3
            </div>
            <div class="attempts-track">
                @for($i = 0; $i < 3; $i++)
                    <div class="attempt-dot {{ $i < session('attempts') ? 'used' : '' }}"></div>
                @endfor
            </div>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" {{ session('lockout') ? 'style=pointer-events:none;opacity:.5' : '' }}>
            @csrf

            <div class="field">
                <label>
                    <i class='bx bx-user'></i>
                    اسم المستخدم
                </label>
                <input
                    type="text"
                    name="username"
                    placeholder="أدخل اسم المستخدم"
                    value="{{ old('username') }}"
                    required
                    autocomplete="username"
                    {{ session('lockout') ? 'disabled' : '' }}>
            </div>

            <div class="field">
                <label>
                    <i class='bx bx-lock-alt'></i>
                    كلمة المرور
                </label>
                <div class="input-wrap">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                        {{ session('lockout') ? 'disabled' : '' }}>
                    <button type="button" class="eye-btn" onclick="togglePass('password', this)">
                        <i class='bx bx-hide'></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login" {{ session('lockout') ? 'disabled' : '' }}>
                <span>تسجيل الدخول</span>
                <i class='bx bx-log-in-circle'></i>
            </button>

        </form>

        <div class="card-footer">
            <a href="{{ route('password.change') }}">
                <i class='bx bx-key'></i>
                تغيير كلمة المرور
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

const timerEl = document.getElementById('lockTimer');
if (timerEl) {
    let seconds = parseInt(timerEl.textContent);
    const iv = setInterval(() => {
        seconds--;
        timerEl.textContent = seconds;
        if (seconds <= 0) { clearInterval(iv); window.location.reload(); }
    }, 1000);
}
</script>
</body>
</html>
