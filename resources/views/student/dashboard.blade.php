<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الطالب</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
@include('includes.student-sidebar')
<div class="content welcome-page">

 
    <div class="student-header">
        <div class="left">
            <h2>مرحباً، {{ $student->full_name }} 👋</h2>
            <p>{{ $student->class->class_name }} - {{ $student->class->section_name }}</p>
        </div>

        <div class="right">
            <div class="avatar">
                <img src="{{ asset('Images/Profile.png') }}" alt="student avatar">
            </div>

        
        </div>
    </div>

     <div class="welcome-box">

        <div class="welcome-text">
             <p>
                أهلاً بك في منصتك التعليمية الذكية!  
                نتمنى لك تجربة دراسية مليئة بالإنجاز والتقدّم.  
                استخدم القائمة الجانبية للتنقّل بين جدولك الدراسي، الدرجات،  
                المحتوى التعليمي، وبقية خدمات المدرسة.
            </p>
        </div>

        <div class="welcome-image">
            <img src="{{ asset('Images/robot.png') }}" alt="Robot waving">
        </div>

    </div>

</div>


    <script src="{{ asset('js/student.js') }}"></script>

 

</body>
</html>
