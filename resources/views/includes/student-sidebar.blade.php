{{-- resources/views/includes/student-sidebar.blade.php --}}
<div class="sidebar">

    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <i class='bx bxs-graduation'></i>
        </div>
        <div class="sidebar-logo-text">
            <strong>المدرسة الذكية</strong>
            <small>بوابة الطالب</small>
        </div>
    </div>

    <div class="sidebar-profile">
        @php $sidebarStudent = \App\Models\Student::find(auth()->user()->profile_id); @endphp
        <div class="sidebar-profile-avatar">
            {{ mb_substr($sidebarStudent?->full_name ?? 'ط', 0, 1) }}
        </div>
        <div class="sidebar-profile-info">
            <div class="sidebar-profile-name">{{ $sidebarStudent?->full_name ?? 'الطالب' }}</div>
            <div class="sidebar-profile-class">#{{ $sidebarStudent?->student_id ?? auth()->user()->profile_id }}</div>
        </div>
    </div>

    <ul class="sidebar-menu">

        <li class="sidebar-nav-label">القائمة الرئيسية</li>

        <li>
            <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class='bx bxs-dashboard'></i><span>الرئيسية</span>
            </a>
        </li>
        <li>
            <a href="{{ route('student.profile') }}" class="{{ request()->routeIs('student.profile') ? 'active' : '' }}">
                <i class='bx bx-id-card'></i><span>البيانات الشخصية</span>
            </a>
        </li>

        <li class="sidebar-nav-label">الدراسة</li>

        <li class="menu-item {{ request()->routeIs('student.timetable','student.exams') ? 'open' : '' }}">
            <button class="menu-btn">
                <i class='bx bx-calendar'></i>
                <span>التقويم والجداول</span>
                <i class='bx bx-chevron-down arrow'></i>
            </button>
            <ul class="submenu">
                <li>
                    <a href="{{ route('student.timetable') }}" class="{{ request()->routeIs('student.timetable') ? 'active' : '' }}">
                        <i class='bx bx-table'></i> الجدول الدراسي
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.exams') }}" class="{{ request()->routeIs('student.exams') ? 'active' : '' }}">
                        <i class='bx bx-notepad'></i> جدول الامتحانات
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('student.grades') }}" class="{{ request()->routeIs('student.grades') ? 'active' : '' }}">
                <i class='bx bx-bar-chart-alt-2'></i><span>الدرجات</span>
            </a>
        </li>
        <li>
            <a href="{{ route('student.attendance') }}" class="{{ request()->routeIs('student.attendance') ? 'active' : '' }}">
                <i class='bx bx-calendar-check'></i><span>الحضور والغياب</span>
            </a>
        </li>
        <li>
            <a href="{{ route('student.content') }}" class="{{ request()->routeIs('student.content') ? 'active' : '' }}">
                <i class='bx bx-book-open'></i><span>المحتوى التعليمي</span>
            </a>
        </li>

        <li class="sidebar-nav-label">التواصل</li>

        {{-- الإعلانات والرسائل — badge من AppServiceProvider --}}
        <li class="menu-item {{ request()->routeIs('student.announcements','student.notifications') ? 'open' : '' }}">
            <button class="menu-btn">
                <i class='bx bx-bell'></i>
                <span>الإعلانات والرسائل</span>
                @if(($sidebarTotalUnread ?? 0) > 0)
                    <span class="notif-badge">{{ $sidebarTotalUnread > 99 ? '99+' : $sidebarTotalUnread }}</span>
                @endif
                <i class='bx bx-chevron-down arrow'></i>
            </button>
            <ul class="submenu">
                <li>
                    <a href="{{ route('student.announcements') }}" class="{{ request()->routeIs('student.announcements') ? 'active' : '' }}">
                        <i class='bx bxs-megaphone'></i> الإعلانات
                        @if(($sidebarAnnUnread ?? 0) > 0)
                            <span class="notif-badge">{{ $sidebarAnnUnread }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.notifications') }}" class="{{ request()->routeIs('student.notifications') ? 'active' : '' }}">
                        <i class='bx bx-envelope'></i> الرسائل
                        @if(($sidebarMsgUnread ?? 0) > 0)
                            <span class="notif-badge">{{ $sidebarMsgUnread }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('student-logout-form').submit();">
            <i class='bx bx-log-out-circle'></i><span>تسجيل الخروج</span>
        </a>
        <form id="student-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

</div>
