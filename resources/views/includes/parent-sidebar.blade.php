<div class="sidebar">
    <div class="logo">
        <i class='bx bxs-school'></i>
        <span>لوحة ولي الأمر</span>
    </div>

    <ul class="menu">

        <li>
            <a href="{{ route('parent.dashboard') }}" class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                <i class='bx bx-home'></i><span>الرئيسية</span>
            </a>
        </li>

        <li>
            <a href="{{ route('parent.children') }}" class="{{ request()->routeIs('parent.children') ? 'active' : '' }}">
                <i class='bx bx-group'></i><span>أبنائي</span>
            </a>
        </li>

        <li>
            <a href="{{ route('parent.grades') }}" class="{{ request()->routeIs('parent.grades') ? 'active' : '' }}">
                <i class='bx bx-bar-chart'></i><span>العلامات</span>
            </a>
        </li>

        <li>
            <a href="{{ route('parent.attendance') }}" class="{{ request()->routeIs('parent.attendance') ? 'active' : '' }}">
                <i class='bx bx-calendar'></i><span>الحضور</span>
            </a>
        </li>

        <li>
            <a href="{{ route('parent.content') }}" class="{{ request()->routeIs('parent.content') ? 'active' : '' }}">
                <i class='bx bx-book-open'></i><span>المحتوى التعليمي</span>
            </a>
        </li>

        {{-- الإعلانات والرسائل — badge من AppServiceProvider --}}
        <li class="menu-item {{ request()->routeIs('parent.announcements', 'parent.messages') ? 'open' : '' }}">
            <a href="#" class="menu-btn">
                <i class='bx bx-bell'></i>
                <span>الإعلانات والرسائل</span>
                @if(($sidebarTotalUnread ?? 0) > 0)
                    <span class="notif-badge">{{ $sidebarTotalUnread > 99 ? '99+' : $sidebarTotalUnread }}</span>
                @endif
                <i class='bx bx-chevron-down arrow'></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="{{ route('parent.announcements') }}" class="{{ request()->routeIs('parent.announcements') ? 'active' : '' }}">
                        <i class='bx bxs-megaphone'></i> الإعلانات
                        @if(($sidebarAnnUnread ?? 0) > 0)
                            <span class="notif-badge">{{ $sidebarAnnUnread > 99 ? '99+' : $sidebarAnnUnread }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('parent.messages') }}" class="{{ request()->routeIs('parent.messages') ? 'active' : '' }}">
                        <i class='bx bx-message'></i> الرسائل
                        @if(($sidebarReportUnread ?? 0) > 0)
                            <span class="notif-badge">{{ $sidebarReportUnread > 99 ? '99+' : $sidebarReportUnread }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <div class="logout-link">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('parent-logout-form').submit();">
            <i class='bx bx-log-out'></i> تسجيل الخروج
        </a>
        <form id="parent-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</div>
