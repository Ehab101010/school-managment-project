<div class="sidebar">
    <div class="logo">
        <i class='bx bxs-school'></i>
        <span>المدرسة الذكية</span>
    </div>

    <ul class="menu">
         <li>
            <a href="{{ route('admin.dashboard') }}" class="p-3 block">
                <i class='bx bx-home'></i>
                <span>الرئيسية</span>
            </a>
        </li>

         <li class="menu-item">
            <a href="#" class="menu-btn">
                <i class='bx bx-user-plus'></i>
                <span>الإضافة</span>
                <i class='bx bx-chevron-down arrow'></i>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('admin.add-student') }}">إضافة طالب</a></li>
                <li><a href="{{ route('admin.add-teacher') }}">إضافة معلم</a></li>
                <li><a href="{{ route('admin.add-subject') }}">إضافة مادة</a></li>
                <li><a href="{{ route('admin.create-class') }}">إضافة صف دراسي</a></li>
            </ul>
        </li>

         <li class="menu-item">
            <a href="#" class="menu-btn">
                <i class='bx bx-edit'></i>
                <span>تعديل البيانات</span>
                <i class='bx bx-chevron-down arrow'></i>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('admin.edit-student') }}">تعديل بيانات طالب</a></li>
                <li><a href="{{ route('admin.edit-teacher') }}">تعديل بيانات معلم</a></li>
            </ul>
        </li>

         <li class="menu-item">
            <a href="#" class="menu-btn">
                <i class='bx bx-show'></i>
                <span>عرض البيانات</span>
                <i class='bx bx-chevron-down arrow'></i>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('admin.view-student-info') }}">عرض الطلاب</a></li>
                <li><a href="{{ route('admin.view-teacher-info') }}">عرض المعلمين</a></li>
                <li><a href="{{ route('admin.view-subjects-info') }}">عرض المواد</a></li>
                <li><a href="{{ route('admin.view-class-info') }}">عرض الصفوف</a></li>
                <li><a href="{{ route('admin.view-assignment') }}">عرض التعيينات</a></li>
            </ul>
        </li>

         <li>
        <a href="{{ route('admin.add-assignment') }}">
        <i class='bx bxs-edit-alt'></i>
                <span>تعيين معلم</span>
            </a>
        </li>

    
        <div class="logout-link"  >
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class='bx bx-log-out'></i>
                تسجيل الخروج
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </ul>
</div>
