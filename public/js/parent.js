 
document.addEventListener('DOMContentLoaded', function () {

     const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.sidebar .menu li a');

    menuLinks.forEach(link => {
        if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });

});
document.addEventListener('DOMContentLoaded', function () {

    /* ══════════════════════════════════════════
       التعامل مع القوائم الفرعية (فتح وإغلاق)
    ══════════════════════════════════════════ */
    const menuBtn = document.querySelector('.menu-btn');
    
    if (menuBtn) {
        menuBtn.addEventListener('click', function (e) {
            e.preventDefault(); // لمنع الانتقال لأي رابط
            const parentItem = this.closest('.menu-item');
            
            // تبديل كلاس open للفتح والإغلاق
            parentItem.classList.toggle('open');
        });
    }

    /* ══════════════════════════════════════════
       تحديد الرابط النشط تلقائياً
    ══════════════════════════════════════════ */
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.sidebar .menu li a');

    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '#' && currentPath.includes(href)) {
            link.classList.add('active');
            
            // إذا كان الرابط النشط داخل قائمة فرعية، نفتح القائمة الأب تلقائياً
            const parentMenu = link.closest('.menu-item');
            if (parentMenu) {
                parentMenu.classList.add('open');
            }
        }
    });

});


// دالة لعرض محتويات مادة معينة
function showSubject(subjectId, subjectName, event) {
    if (event) event.preventDefault();

    const subjectsView = document.getElementById('subjectsView');
    const contentPanel = document.getElementById('contentPanel');
    const panelTitle = document.getElementById('panelTitle');
    const itemsGrid = document.getElementById('itemsGrid');

    // تغيير العنوان
    panelTitle.textContent = subjectName;

    // تصفية المحتوى بناءً على المادة المختارة
    const filteredItems = allContent.filter(item => item.subject_id == subjectId);

    // بناء كروت الملفات داخل المادة
    let html = '';
    const typeIcons = {
        'video': 'bx-play-circle',
        'pdf': 'bxs-file-pdf',
        'excel': 'bx-table',
        'assignment': 'bx-task',
        'link': 'bx-link-external'
    };

    filteredItems.forEach(item => {
        const icon = typeIcons[item.content_type] || 'bx-file';
        const link = item.file_url || item.external_link || '#';
        
        html += `
            <div class="item-card">
                <div class="item-type-icon ${item.content_type}">
                    <i class='bx ${icon}'></i>
                </div>
                <div class="item-details">
                    <div class="item-title">${item.title}</div>
                    <div class="item-desc">${item.description || 'لا يوجد وصف'}</div>
                    <div class="item-date">${item.created_at}</div>
                </div>
                <a href="${link}" target="_blank" class="btn-download">
                    <i class='bx bx-show-alt'></i> عرض
                </a>
            </div>
        `;
    });

    itemsGrid.innerHTML = html;

    // إخفاء شبكة المواد وإظهار لوحة المحتوى
    subjectsView.style.display = 'none';
    contentPanel.classList.add('active');
}

// دالة للرجوع لقائمة المواد
function showSubjects() {
    const subjectsView = document.getElementById('subjectsView');
    const contentPanel = document.getElementById('contentPanel');

    contentPanel.classList.remove('active');
    setTimeout(() => {
        subjectsView.style.display = 'block';
    }, 300);
}