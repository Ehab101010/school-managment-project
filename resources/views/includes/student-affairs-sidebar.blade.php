{{-- ═══ student-affairs sidebar ═══ --}}
<div class="ds-overlay" id="dsOverlay"></div>
<button class="ds-hamburger" id="dsHamburger">
    <span></span><span></span><span></span>
</button>

<aside class="ds-sidebar" id="dsSidebar">

    {{-- Brand --}}
    <div class="ds-brand">
        <div class="ds-brand-mark">
            <i class='bx bxs-school'></i>
            <div class="ds-brand-pulse"></div>
        </div>
        <div class="ds-brand-text">
            <span class="ds-brand-name">المدرسة</span>
            <span class="ds-brand-tag">شؤون الطلاب</span>
        </div>
    </div>

    <div class="ds-divider"></div>

    <nav class="ds-nav">

        {{-- الرئيسية --}}
        <a href="{{ route('sa.dashboard') }}"
           class="ds-nav-link {{ request()->routeIs('sa.dashboard') ? 'ds-active' : '' }}">
            <div class="ds-nav-icon"><i class='bx bx-home-smile'></i></div>
            <span>الرئيسية</span>
            <div class="ds-nav-glow"></div>
        </a>

        {{-- الطلاب --}}
        <div class="ds-group {{ request()->routeIs('sa.add-student','sa.edit-student','sa.view-student*') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bxs-graduation'></i></div>
                <span>الطلاب</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('sa.add-student') }}"       class="{{ request()->routeIs('sa.add-student')       ? 'ds-sub-active' : '' }}"><i class='bx bx-user-plus'></i> إضافة طالب</a>
                <a href="{{ route('sa.edit-student') }}"      class="{{ request()->routeIs('sa.edit-student')      ? 'ds-sub-active' : '' }}"><i class='bx bx-edit'></i> تعديل بيانات</a>
                <a href="{{ route('sa.view-student-info') }}" class="{{ request()->routeIs('sa.view-student-info') ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض الطلاب</a>
            </div>
        </div>

        {{-- المعلمون --}}
        <div class="ds-group {{ request()->routeIs('sa.add-teacher','sa.edit-teacher','sa.view-teacher-info','sa.add-assignment','sa.view-assignment','sa.teacher-attendance.*') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-chalkboard'></i></div>
                <span>المعلمون</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('sa.add-teacher') }}"              class="{{ request()->routeIs('sa.add-teacher')              ? 'ds-sub-active' : '' }}"><i class='bx bx-user-plus'></i> إضافة معلم</a>
                <a href="{{ route('sa.edit-teacher') }}"             class="{{ request()->routeIs('sa.edit-teacher')             ? 'ds-sub-active' : '' }}"><i class='bx bx-edit'></i> تعديل بيانات</a>
                <a href="{{ route('sa.view-teacher-info') }}"        class="{{ request()->routeIs('sa.view-teacher-info')        ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض المعلمين</a>
                <a href="{{ route('sa.add-assignment') }}"           class="{{ request()->routeIs('sa.add-assignment')           ? 'ds-sub-active' : '' }}"><i class='bx bxs-edit-alt'></i> تعيين معلم</a>
                <a href="{{ route('sa.view-assignment') }}"          class="{{ request()->routeIs('sa.view-assignment')          ? 'ds-sub-active' : '' }}"><i class='bx bx-link-alt'></i> عرض التعيينات</a>
                <a href="{{ route('sa.teacher-attendance.index') }}" class="{{ request()->routeIs('sa.teacher-attendance.index') ? 'ds-sub-active' : '' }}"><i class='bx bx-calendar-check'></i> تسجيل الحضور</a>
            </div>
        </div>

        {{-- أولياء الأمور --}}
        <div class="ds-group {{ request()->routeIs('sa.add-parent','sa.edit-parent','sa.view-parent*','sa.view-parent-assignment') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-group'></i></div>
                <span>أولياء الأمور</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('sa.add-parent') }}"             class="{{ request()->routeIs('sa.add-parent')             ? 'ds-sub-active' : '' }}"><i class='bx bx-user-plus'></i> إضافة ولي أمر</a>
                <a href="{{ route('sa.edit-parent') }}"            class="{{ request()->routeIs('sa.edit-parent')            ? 'ds-sub-active' : '' }}"><i class='bx bx-edit'></i> تعديل بيانات</a>
                <a href="{{ route('sa.view-parent-info') }}"       class="{{ request()->routeIs('sa.view-parent-info')       ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض أولياء الأمور</a>
                <a href="{{ route('sa.view-parent-assignment') }}" class="{{ request()->routeIs('sa.view-parent-assignment') ? 'ds-sub-active' : '' }}"><i class='bx bxs-edit-alt'></i> تعيين ولي أمر</a>
            </div>
        </div>

        {{-- المواد والصفوف --}}
        <div class="ds-group {{ request()->routeIs('sa.add-subject','sa.view-subjects-info','sa.create-class','sa.view-class-info') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-book-open'></i></div>
                <span>المواد والصفوف</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('sa.add-subject') }}"        class="{{ request()->routeIs('sa.add-subject')        ? 'ds-sub-active' : '' }}"><i class='bx bx-plus'></i> إضافة مادة</a>
                <a href="{{ route('sa.view-subjects-info') }}" class="{{ request()->routeIs('sa.view-subjects-info') ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض المواد</a>
                <a href="{{ route('sa.create-class') }}"       class="{{ request()->routeIs('sa.create-class')       ? 'ds-sub-active' : '' }}"><i class='bx bx-plus'></i> إضافة صف</a>
                <a href="{{ route('sa.view-class-info') }}"    class="{{ request()->routeIs('sa.view-class-info')    ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض الصفوف</a>
            </div>
        </div>

        {{-- الإعلانات --}}
        <div class="ds-group {{ request()->routeIs('sa.announcements.*') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-bell'></i></div>
                <span>الإعلانات</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('sa.announcements.create') }}" class="{{ request()->routeIs('sa.announcements.create') ? 'ds-sub-active' : '' }}"><i class='bx bx-plus-circle'></i> إعلان جديد</a>
                <a href="{{ route('sa.announcements.index') }}"  class="{{ request()->routeIs('sa.announcements.index')  ? 'ds-sub-active' : '' }}"><i class='bx bxs-megaphone'></i> الإعلانات</a>
            </div>
        </div>

    </nav>

    {{-- Logout --}}
    <div class="ds-sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" id="ds-logout-form">@csrf</form>
        <a href="#" class="ds-logout"
           onclick="event.preventDefault(); document.getElementById('ds-logout-form').submit();">
            <i class='bx bx-log-out'></i>
            <span>تسجيل الخروج</span>
        </a>
    </div>

</aside>