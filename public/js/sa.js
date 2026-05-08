document.addEventListener("DOMContentLoaded", function () {

    // ==============================
    // Theme Management (Dark/Light Mode)
    // ==============================
    const themeToggle = document.getElementById("themeToggle");
    const THEME_KEY   = "sa_theme";
    function applyTheme(theme) {
        if (theme === "light") { document.body.classList.add("light-mode"); }
        else { document.body.classList.remove("light-mode"); }
    }
    applyTheme(localStorage.getItem(THEME_KEY) || "dark");
    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            const isLight = document.body.classList.toggle("light-mode");
            localStorage.setItem(THEME_KEY, isLight ? "light" : "dark");
            themeToggle.style.animation = "none";
            themeToggle.offsetHeight;
            themeToggle.style.animation = "spinPop 0.4s ease";
        });
    }

    // ==============================
    // Sidebar Control (Open/Close)
    // ==============================
    const sidebar   = document.querySelector(".sidebar");
    const toggle    = document.querySelector(".menu-toggle");
    const overlay   = document.querySelector(".sidebar-overlay");
    function openSidebar()  { sidebar?.classList.add("open");    overlay?.classList.add("active");    document.body.style.overflow = "hidden"; }
    function closeSidebar() { sidebar?.classList.remove("open"); overlay?.classList.remove("active"); document.body.style.overflow = ""; }
    toggle?.addEventListener("click", () => { sidebar?.classList.contains("open") ? closeSidebar() : openSidebar(); });
    overlay?.addEventListener("click", closeSidebar);

    // ==============================
    // Sidebar Accordion Menu
    // ==============================
    document.querySelectorAll(".menu-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const parent = btn.parentElement;
            document.querySelectorAll(".menu-item.open").forEach(item => { if (item !== parent) item.classList.remove("open"); });
            parent.classList.toggle("open");
        });
    });
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".menu-item")) {
            document.querySelectorAll(".menu-item.open").forEach(item => item.classList.remove("open"));
        }
    });

    // ==============================
    // Content Type Toggle (File/Link)
    // ==============================
    const contentType = document.getElementById("content-type");
    if (contentType) {
        contentType.addEventListener("change", function () {
            const fileInput = document.getElementById("file-input");
            const linkInput = document.getElementById("link-input");
            if (fileInput) fileInput.style.display = "none";
            if (linkInput) linkInput.style.display = "none";
            if (this.value === "pdf_excel" && fileInput) fileInput.style.display = "block";
            if ((this.value === "video" || this.value === "link") && linkInput) linkInput.style.display = "block";
        });
    }

    // ==============================
    // Modal Outside Click Handler
    // ==============================
    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("click", function (e) { if (e.target === this) this.style.display = "none"; });
    });

    // ==============================
    // Announcement Target Selector
    // ==============================
    const checkedTarget = document.querySelector('input[name="target_type"]:checked');
    if (checkedTarget) toggleClassSelector(checkedTarget);

    // ==============================
    // Attendance Status Change Listener
    // ==============================
    const statusRadios = document.querySelectorAll(".status-radio");
    if (statusRadios.length > 0) {
        statusRadios.forEach(r => r.addEventListener("change", updateCounts));
        updateCounts();
    }
});

// ==============================
// Edit Student (Fetch & Modal)
// ==============================
function openEditModal(studentId, fetchUrl, updateUrl) {
    const url = fetchUrl || `/student-affairs/students/get/${studentId}`;
    fetch(url, { credentials: 'same-origin' })
        .then(res => { if (!res.ok) throw new Error(res.status); return res.json(); })
        .then(student => {
            setValue("full_name",             student.full_name);
            setValue("mother_name",           student.mother_name);
            setValue("birth_date",            student.birth_date);
            setValue("gender",                student.gender);
            setValue("nationality",           student.nationality);
            setValue("student_phone_number", student.student_phone_number);
            setValue("father_phone_number",  student.father_phone_number);
            setValue("mother_phone_number",  student.mother_phone_number);
            setValue("notes",                student.notes);
            const form = document.getElementById("editForm");
            if (form) form.action = updateUrl || `/student-affairs/students/update/${studentId}`;
            openModal("editModal");
        })
        .catch(err => { console.error("Student fetch error:", err); alert("فشل في جلب بيانات الطالب"); });
}

// ==============================
// Edit Teacher (Fetch & Modal)
// ==============================
function openTeacherModal(teacherId, fetchUrl, updateUrl) {
    const url = fetchUrl || `/student-affairs/teachers/get/${teacherId}`;
    fetch(url, { credentials: 'same-origin' })
        .then(res => { if (!res.ok) throw new Error(res.status); return res.json(); })
        .then(teacher => {
            setValue("t_full_name",   teacher.full_name);
            setValue("t_mother_name", teacher.mother_name);
            setValue("t_birth_date",  teacher.birth_date);
            setValue("t_gender",      teacher.gender);
            setValue("t_nationality", teacher.nationality);
            setValue("t_address",     teacher.address);
            setValue("t_phone",       teacher.phone);
            setValue("t_email",       teacher.email);
            setValue("t_notes",       teacher.notes);
            const form = document.getElementById("teacherForm");
            if (form) form.action = updateUrl || `/student-affairs/teachers/update/${teacherId}`;
            openModal("teacherModal");
        })
        .catch(err => { console.error("Teacher fetch error:", err); alert("فشل في جلب بيانات المعلم"); });
}

function closeTeacherModal() {
    const modal = document.getElementById("teacherModal");
    if (modal) modal.style.display = "none";
}

// ==============================
// Edit Parent (Fetch & Modal)
// ==============================
function openParentModal(parentId, fetchUrl, updateUrl) {
    const url = fetchUrl || `/student-affairs/parents/${parentId}`;
    fetch(url, { credentials: 'same-origin' })
        .then(res => { if (!res.ok) throw new Error(res.status); return res.json(); })
        .then(parent => {
            setValue("full_name",               parent.full_name);
            setValue("birth_date",              parent.birth_date);
            setValue("gender",                  parent.gender);
            setValue("phone_mobile",            parent.phone_mobile);
            setValue("additional_phone_number", parent.additional_phone_number);
            setValue("phone_home",              parent.phone_home);
            setValue("address",                 parent.address);
            setValue("job",                     parent.job);
            const form = document.getElementById("editForm");
            if (form) form.action = updateUrl || `/student-affairs/parents/${parentId}`;
            openModal("editModal");
        })
        .catch(err => { console.error("Parent fetch error:", err); alert("فشل في جلب بيانات ولي الأمر"); });
}

// ==============================
// Assign Parent to Student (Filtering)
// ==============================
function initAssignParent(sections) {
    const classEl   = document.getElementById("class_name");
    const sectionEl = document.getElementById("section_name");
    const studentEl = document.getElementById("student_select");
    if (!classEl || !sectionEl || !studentEl) return;
    classEl.addEventListener("change", function () {
        const className = this.value;
        sectionEl.innerHTML = '<option value="">اختر الشعبة</option>';
        sections.forEach(section => {
            if (section.class_name === className) {
                sectionEl.innerHTML += `<option value="${section.class_id}">${section.section_name}</option>`;
            }
        });
        studentEl.innerHTML = '<option value="">اختر الطالب</option>';
    });
    sectionEl.addEventListener("change", function () {
        const classId = this.value;
        if (!classId) return;
        fetch(`/student-affairs/assignments/get-students?class_id=${classId}`, { credentials: 'same-origin' })
            .then(res => res.json())
            .then(students => {
                studentEl.innerHTML = '<option value="">اختر الطالب</option>';
                students.forEach(s => {
                    studentEl.innerHTML += `<option value="${s.student_id}">${s.full_name}</option>`;
                });
            });
    });
}

// ==============================
// Global UI Helpers (Modal & Value)
// ==============================
function openModal(id) { const modal = document.getElementById(id); if (modal) modal.style.display = "flex"; }
function closeModal()  { const modal = document.getElementById("editModal"); if (modal) modal.style.display = "none"; }
function setValue(id, value) { const el = document.getElementById(id); if (el) el.value = value ?? ""; }

// ==============================
// Tab Management (Inbox/Sent)
// ==============================
function showTab(id, el) {
    event.preventDefault();
    ["received", "sent"].forEach(t => {
        const tabEl = document.getElementById(t);
        if (tabEl) tabEl.style.display = (t === id) ? "block" : "none";
    });
    document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
    el.classList.add("active");
}

// ==============================
// Class Selector Toggle
// ==============================
function toggleClassSelector(el) {
    const selector = document.getElementById("class-selector");
    if (selector) selector.style.display = (el.value === "class") ? "block" : "none";
}

// ==============================
// Attendance Counter Management
// ==============================
function updateCounts() {
    let p = 0, a = 0, l = 0;
    document.querySelectorAll(".status-radio:checked").forEach(r => {
        if      (r.value === "present") p++;
        else if (r.value === "absent")  a++;
        else if (r.value === "late")    l++;
    });
    const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
    set("cnt-present", p); set("cnt-absent", a); set("cnt-late", l);
    set("info-p",      p); set("info-a",     a); set("info-l",   l);
}

// ==============================
// Bulk Attendance Setter
// ==============================
function setAll(status) {
    document.querySelectorAll(`.status-radio[value="${status}"]`).forEach(r => r.checked = true);
    updateCounts();
}


// DS Sidebar Accordion
document.querySelectorAll('.ds-group-trigger').forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();
        const group  = btn.closest('.ds-group');
        const isOpen = group.classList.contains('ds-open');
        // أغلق الكل
        document.querySelectorAll('.ds-group.ds-open').forEach(el => {
            if (el !== group) el.classList.remove('ds-open');
        });
        // افتح/أغلق الحالي
        group.classList.toggle('ds-open', !isOpen);
    });
});