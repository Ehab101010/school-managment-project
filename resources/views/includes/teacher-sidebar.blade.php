<div class="sidebar">
    <div class="logo">
        <i class='bx bxs-user'></i>
        <span>واجهة المعلم</span>
    </div>
 
    <ul class="menu">
        <li>
            <a href="{{ route('teacher.dashboard') }}" class="p-3 block">
                <i class='bx bx-home'></i>
                <span>الرئيسية</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-btn">
                <i class='bx bx-show'></i>
                <span>عرض البيانات</span>
                <i class='bx bx-chevron-down arrow'></i>
            </a>
            <ul class="submenu">
            <li><a href="{{ route('teacher.view-stu-info') }}">          <i class='bx bx-edit'></i>
            بيانات الطلاب</a></li>
            
            <li><a href="{{ route('teacher.timetable') }}">
                <i class='bx bx-check-square'></i> البرنامج الدراسي     </a></li>
            </ul>
        </li>
      
           
 
 
        <li>
            <a href="{{route('teacher.add-grades')}}">
                <i class='bx bx-file'></i>
                <span> إضافة الدرجات</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-btn">
                <i class='bx bx-check-square'></i>
                <span> المحتوى التعليمي</span>
                <i class='bx bx-chevron-down arrow'></i>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('teacher.create-content') }}"> إنشاء محتوى تعليمي </a></li>
                <li><a href="{{ route('teacher.view-content') }}"> عرض المحتوى </a></li>
                </ul>
        </li>
 
            <a href="{{ route('login') }}">
                <i class='bx bx-log-out-circle'></i>
                <span>تسجيل الخروج</span>
            </a>
        </li>
    </ul>
</div>
 