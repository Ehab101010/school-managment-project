{{-- ═══ admin sidebar — 2026 Dark Edition ═══ --}}

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
            <span class="ds-brand-tag">نظام الإدارة</span>
        </div>
    </div>

    {{-- User --}}
    <div class="ds-user-badge">
        <div class="ds-user-avatar">
            {{ mb_substr(auth()->user()->name ?? 'م', 0, 1) }}
        </div>
        <div class="ds-user-info">
            <span class="ds-user-name">{{ auth()->user()->name ?? 'المدير' }}</span>
            <span class="ds-user-role"><i class='bx bxs-shield-alt-2'></i> مدير النظام</span>
        </div>
    </div>

    <div class="ds-divider"></div>

    <nav class="ds-nav">

        {{-- الرئيسية --}}
        <a href="{{ route('admin.dashboard') }}"
           class="ds-nav-link {{ request()->routeIs('admin.dashboard') ? 'ds-active' : '' }}">
            <div class="ds-nav-icon"><i class='bx bx-home-smile'></i></div>
            <span>الرئيسية</span>
            <div class="ds-nav-glow"></div>
        </a>

        {{-- الطلاب --}}
        <div class="ds-group {{ request()->routeIs('admin.add-student','admin.edit-student','admin.view-student*') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bxs-graduation'></i></div>
                <span>الطلاب</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('admin.add-student') }}"       class="{{ request()->routeIs('admin.add-student')       ? 'ds-sub-active' : '' }}"><i class='bx bx-user-plus'></i> إضافة طالب</a>
                <a href="{{ route('admin.edit-student') }}"      class="{{ request()->routeIs('admin.edit-student')      ? 'ds-sub-active' : '' }}"><i class='bx bx-edit'></i> تعديل بيانات</a>
                <a href="{{ route('admin.view-student-info') }}" class="{{ request()->routeIs('admin.view-student-info') ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض الطلاب</a>
            </div>
        </div>

        {{-- المعلمون --}}
        <div class="ds-group {{ request()->routeIs('admin.add-teacher','admin.edit-teacher','admin.view-teacher-info','admin.add-assignment','admin.view-assignment','admin.teacher-attendance.*') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-chalkboard'></i></div>
                <span>المعلمون</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('admin.add-teacher') }}"               class="{{ request()->routeIs('admin.add-teacher')               ? 'ds-sub-active' : '' }}"><i class='bx bx-user-plus'></i> إضافة معلم</a>
                <a href="{{ route('admin.edit-teacher') }}"              class="{{ request()->routeIs('admin.edit-teacher')              ? 'ds-sub-active' : '' }}"><i class='bx bx-edit'></i> تعديل بيانات</a>
                <a href="{{ route('admin.view-teacher-info') }}"         class="{{ request()->routeIs('admin.view-teacher-info')         ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض المعلمين</a>
                <a href="{{ route('admin.add-assignment') }}"            class="{{ request()->routeIs('admin.add-assignment')            ? 'ds-sub-active' : '' }}"><i class='bx bxs-edit-alt'></i> تعيين معلم</a>
                <a href="{{ route('admin.view-assignment') }}"           class="{{ request()->routeIs('admin.view-assignment')           ? 'ds-sub-active' : '' }}"><i class='bx bx-link-alt'></i> عرض التعيينات</a>
                <a href="{{ route('admin.teacher-attendance.index') }}"  class="{{ request()->routeIs('admin.teacher-attendance.index')  ? 'ds-sub-active' : '' }}"><i class='bx bx-calendar-check'></i> تسجيل الحضور</a>
                <a href="{{ route('admin.teacher-attendance.report') }}" class="{{ request()->routeIs('admin.teacher-attendance.report') ? 'ds-sub-active' : '' }}"><i class='bx bx-bar-chart-alt-2'></i> تقرير الحضور</a>
            </div>
        </div>

        {{-- أولياء الأمور --}}
        <div class="ds-group {{ request()->routeIs('admin.add-parent','admin.edit-parent','admin.view-parent*') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-group'></i></div>
                <span>أولياء الأمور</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('admin.add-parent') }}"           class="{{ request()->routeIs('admin.add-parent')           ? 'ds-sub-active' : '' }}"><i class='bx bx-user-plus'></i> إضافة ولي أمر</a>
                <a href="{{ route('admin.edit-parent') }}"          class="{{ request()->routeIs('admin.edit-parent')          ? 'ds-sub-active' : '' }}"><i class='bx bx-edit'></i> تعديل بيانات</a>
                <a href="{{ route('admin.view-parent-info') }}"     class="{{ request()->routeIs('admin.view-parent-info')     ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض أولياء الأمور</a>
                <a href="{{ route('admin.view-parent-assignment') }}" class="{{ request()->routeIs('admin.view-parent-assignment') ? 'ds-sub-active' : '' }}"><i class='bx bxs-edit-alt'></i> تعيين ولي أمر</a>
            </div>
        </div>

        {{-- المواد والصفوف --}}
        <div class="ds-group {{ request()->routeIs('admin.add-subject','admin.view-subjects-info','admin.create-class','admin.view-class-info') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-book-open'></i></div>
                <span>المواد والصفوف</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('admin.add-subject') }}"        class="{{ request()->routeIs('admin.add-subject')        ? 'ds-sub-active' : '' }}"><i class='bx bx-plus'></i> إضافة مادة</a>
                <a href="{{ route('admin.view-subjects-info') }}" class="{{ request()->routeIs('admin.view-subjects-info') ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض المواد</a>
                <a href="{{ route('admin.create-class') }}"       class="{{ request()->routeIs('admin.create-class')       ? 'ds-sub-active' : '' }}"><i class='bx bx-plus'></i> إضافة صف</a>
                <a href="{{ route('admin.view-class-info') }}"    class="{{ request()->routeIs('admin.view-class-info')    ? 'ds-sub-active' : '' }}"><i class='bx bx-list-ul'></i> عرض الصفوف</a>
            </div>
        </div>
 
        {{-- الإعلانات والتقارير --}}
        <div class="ds-group {{ request()->routeIs('admin.announcements.*','admin.reports.*') ? 'ds-open' : '' }}">
            <button class="ds-group-trigger">
                <div class="ds-nav-icon"><i class='bx bx-bell'></i></div>
                <span>الإعلانات والتقارير</span>
                <i class='bx bx-chevron-left ds-chevron'></i>
            </button>
            <div class="ds-group-body">
                <a href="{{ route('admin.announcements.create') }}" class="{{ request()->routeIs('admin.announcements.create') ? 'ds-sub-active' : '' }}"><i class='bx bx-plus-circle'></i> إعلان جديد</a>
                <a href="{{ route('admin.announcements.index') }}"  class="{{ request()->routeIs('admin.announcements.index')  ? 'ds-sub-active' : '' }}"><i class='bx bxs-megaphone'></i> الإعلانات</a>
                <a href="{{ route('admin.reports.index') }}"        class="{{ request()->routeIs('admin.reports.index')        ? 'ds-sub-active' : '' }}"><i class='bx bx-file-blank'></i> التقارير</a>
                <a href="{{ route('admin.reports.create') }}"       class="{{ request()->routeIs('admin.reports.create')       ? 'ds-sub-active' : '' }}"><i class='bx bx-plus-circle'></i> إرسال تقرير</a>
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