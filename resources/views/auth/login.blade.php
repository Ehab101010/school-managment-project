 
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | المنصة الدراسية الذكية</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/Login_Style.css') }}">
</head>
<body>
  
    <div class="Container">
        <div class="Home-Pic"><h1> Online School Education </h1></div>

        <div class="Login-Page">
            <img src="{{ asset('images/LOGO.png') }}" alt="Home Picture" width="400">

            <div class="login-box">
                <h1>تسجيل الدخول</h1>

                 @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="list-style:none; padding:0; margin:0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                @csrf
                    <div class="input_box">
                        <i class='bx bx-user'></i>
                        <input type="text" name="username"  required>
                        <label>اسم المستخدم</label>
                    </div>

                    <div class="input_box">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" required>
                        <label>كلمة المرور</label>
                    </div>

                    <button type="submit" class="btn">تسجيل الدخول</button>

                    <div class="extra-links" style="margin-top:10px;">
                    <a href="{{ route('password.change') }}">تغيير كلمة المرور</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
