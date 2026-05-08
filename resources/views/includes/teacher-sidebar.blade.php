<div class="sidebar">
    {{-- Logo --}}
    <div class="sidebar-header">
        <div class="logo">🎓</div>
        <span class="logo-text">المنصة التعليمية</span>
    </div>

    {{-- Profile avatar --}}
    <div class="sidebar-profile">
        <div class="profile-avatar">👤</div>
        <div class="profile-info">       

            <span class="profile-name"> {{ $teacher->full_name ?? 'المعلم' }}</span>
            <span class="profile-role">لوحة التحكم</span>
        </div>
    </div>

    <ul class="menu-container">
        {{-- الرئيسية --}}
        <li class="menu-item">
            <a href="{{ route('teacher.dashboard') }}" class="menu-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class='bx bxs-home-circle'></i>
                <span>الرئيسية</span>
            </a>
        </li>

        {{-- عرض البيانات --}}
        <li class="menu-item has-submenu {{ request()->routeIs('teacher.view-stu-info', 'teacher.timetable') ? 'open' : '' }}">
            <div class="menu-link submenu-btn {{ request()->routeIs('teacher.view-stu-info', 'teacher.timetable') ? 'active' : '' }}">
                <i class='bx bx-data'></i>
                <span>عرض البيانات</span>
                <i class='bx bx-chevron-left arrow-icon'></i>
            </div>
            <ul class="submenu">
                <li><a href="{{ route('teacher.view-stu-info') }}" class="{{ request()->routeIs('teacher.view-stu-info') ? 'active' : '' }}">بيانات الطلاب</a></li>
                <li><a href="{{ route('teacher.timetable') }}" class="{{ request()->routeIs('teacher.timetable') ? 'active' : '' }}">البرنامج الدراسي</a></li>
            </ul>
        </li>

        {{-- الحضور والغياب --}}
        <li class="menu-item has-submenu {{ request()->routeIs('teacher.attendance.*') ? 'open' : '' }}">
            <div class="menu-link submenu-btn {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}">
                <i class='bx bx-calendar-check'></i>
                <span>الحضور والغياب</span>
                <i class='bx bx-chevron-left arrow-icon'></i>
            </div>
            <ul class="submenu">
                <li><a href="{{ route('teacher.attendance.create') }}" class="{{ request()->routeIs('teacher.attendance.create') ? 'active' : '' }}">تسجيل حضور جديد</a></li>
                <li><a href="{{ route('teacher.attendance.report') }}" class="{{ request()->routeIs('teacher.attendance.report') ? 'active' : '' }}">سجل الحضور والغياب</a></li>
            </ul>
        </li>

        {{-- الأكاديميا (الدرجات والمحتوى) --}}
        <li class="menu-item has-submenu {{ request()->routeIs('teacher.add-grades', 'teacher.create-content', 'teacher.view-content') ? 'open' : '' }}">
            <div class="menu-link submenu-btn {{ request()->routeIs('teacher.add-grades', 'teacher.create-content', 'teacher.view-content') ? 'active' : '' }}">
                <i class='bx bx-book-content'></i>
                <span>الأكاديميا</span>
                <i class='bx bx-chevron-left arrow-icon'></i>
            </div>
            <ul class="submenu">
                <li><a href="{{ route('teacher.add-grades') }}" class="{{ request()->routeIs('teacher.add-grades') ? 'active' : '' }}">إضافة درجات</a></li>
                <li><a href="{{ route('teacher.create-content') }}" class="{{ request()->routeIs('teacher.create-content') ? 'active' : '' }}">رفع محتوى</a></li>
                <li><a href="{{ route('teacher.view-content') }}" class="{{ request()->routeIs('teacher.view-content') ? 'active' : '' }}">عرض المحتوى المرفوع</a></li>
            </ul>
        </li>

        {{-- المراسلات والتقارير --}}
        <li class="menu-item has-submenu {{ request()->routeIs('teacher.notifications.*', 'teacher.report.create') ? 'open' : '' }}">
            <div class="menu-link submenu-btn {{ request()->routeIs('teacher.notifications.*', 'teacher.report.create') ? 'active' : '' }}">
                <i class='bx bx-bell'></i>
                <span>المراسلات</span>
                <i class='bx bx-chevron-left arrow-icon'></i>
            </div>
            <ul class="submenu">
                <li><a href="{{ route('teacher.notifications.inbox') }}" class="{{ request()->routeIs('teacher.notifications.inbox') ? 'active' : '' }}">البريد الوارد</a></li>
                <li><a href="{{ route('teacher.notifications.sent') }}" class="{{ request()->routeIs('teacher.notifications.sent') ? 'active' : '' }}">المرسلة</a></li>
                <li><a href="{{ route('teacher.report.create') }}" class="{{ request()->routeIs('teacher.report.create') ? 'active' : '' }}">إنشاء تقرير/رسالة</a></li>
            </ul>
        </li>

        {{-- الإعلانات --}}
        <li class="menu-item has-submenu {{ request()->routeIs('teacher.announcements.*') ? 'open' : '' }}">
            <div class="menu-link submenu-btn {{ request()->routeIs('teacher.announcements.*') ? 'active' : '' }}">
                <i class='bx bx-megaphone'></i>
                <span>الإعلانات</span>
                <i class='bx bx-chevron-left arrow-icon'></i>
            </div>
            <ul class="submenu">
                <li><a href="{{ route('teacher.announcements.index') }}" class="{{ request()->routeIs('teacher.announcements.index') ? 'active' : '' }}">كل الإعلانات</a></li>
                <li><a href="{{ route('teacher.announcements.create') }}" class="{{ request()->routeIs('teacher.announcements.create') ? 'active' : '' }}">إضافة إعلان</a></li>
            </ul>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="logout-btn" 
           onclick="event.preventDefault(); document.getElementById('teacher-logout-form').submit();">
            <i class='bx bx-log-out-circle'></i>
            <span>خروج</span>
        </a>
        <form id="teacher-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>