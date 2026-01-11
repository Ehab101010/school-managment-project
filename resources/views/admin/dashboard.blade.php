<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
 
</head>
<body>
 
 
 
    @include('includes.admin-sidebar')
 

    <div class="content">
        <h1>مرحبًا بك في لوحة تحكم المدير</h1>
        <p>اختر إحدى الخيارات من القائمة اليسرى للبدء.</p>
    </div>
    <script src="{{ asset('js/admin.js') }}" defer></script>
 
 
</body>
</html>
