<div class="sidebar">
    <div class="logo">
        <i class='bx bxs-school'></i>
        <span>المدرسة الذكية</span>
    </div>

    <ul class="menu">

        <li>
            <a href="{{ route('student.dashboard') }}" class="p-3 block">
                <i class='bx bx-home'></i>
                <span>الرئيسية</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.profile') }}">
                <i class='bx bx-file'></i>
                <span>البيانات الشخصية</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="#" class="menu-btn">
                <i class='bx bx-user-plus'></i>
                <span>التقويم</span>
                <i class='bx bx-chevron-down arrow'></i>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('student.timetable') }}">الجدول الدراسي</a></li>
                <li><a href="{{ route('student.exams') }}">جدول الامتحانات</a></li>
            </ul>
        </li>

        <li>
            <a href="{{ route('student.grades') }}">
                <i class='bx bx-file'></i>
                <span>الدرجات</span>
            </a>
        </li>

        <li>
            <a href="{{ route('student.content') }}">
                <i class='bx bx-file'></i>
                <span>المحتوى التعليمي</span>
            </a>
        </li>

        <div class="logout-link">
            <a href="{{ route('login') }}">
                <i class='bx bx-log-out-circle'></i>
                <span>تسجيل الخروج</span>
            </a>
        </div>

    </ul>
</div>
