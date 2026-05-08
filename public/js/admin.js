

document.addEventListener("DOMContentLoaded", function () {

    // ==============================
    // DS Sidebar — responsive burger
    // ==============================
    const dsSidebar   = document.getElementById('dsSidebar');
    const dsHamburger = document.getElementById('dsHamburger');
    const dsOverlay   = document.getElementById('dsOverlay');

    function dsOpenSidebar() {
        dsSidebar?.classList.add('ds-sidebar-open');
        dsOverlay?.classList.add('ds-ov-show');
        dsHamburger?.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function dsCloseSidebar() {
        dsSidebar?.classList.remove('ds-sidebar-open');
        dsOverlay?.classList.remove('ds-ov-show');
        dsHamburger?.classList.remove('is-open');
        document.body.style.overflow = '';
    }
    function dsToggleSidebar() {
        dsSidebar?.classList.contains('ds-sidebar-open') ? dsCloseSidebar() : dsOpenSidebar();
    }

    dsHamburger?.addEventListener('click', dsToggleSidebar);
    dsOverlay?.addEventListener('click', dsCloseSidebar);

    // Close sidebar when clicking any nav link on mobile
    dsSidebar?.querySelectorAll('.ds-nav-link, .ds-group-body a, .ds-logout').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) dsCloseSidebar();
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') dsCloseSidebar();
    });

    // Accordion groups
    document.querySelectorAll('.ds-group-trigger').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const group  = btn.closest('.ds-group');
            const isOpen = group.classList.contains('ds-open');
            document.querySelectorAll('.ds-group.ds-open').forEach(el => {
                if (el !== group) el.classList.remove('ds-open');
            });
            group.classList.toggle('ds-open', !isOpen);
        });
    });

    // Close accordion when clicking outside (mobile)
    document.addEventListener('click', e => {
        if (!e.target.closest('.ds-sidebar') && window.innerWidth <= 768) {
            document.querySelectorAll('.ds-group.ds-open').forEach(el => el.classList.remove('ds-open'));
        }
    });

    // ==============================
    // Mobile sidebar toggle (legacy .sidebar pages)
    // ==============================
    const sidebar  = document.querySelector(".sidebar");
    const toggle   = document.querySelector(".menu-toggle");
    const overlay  = document.querySelector(".sidebar-overlay");

    function openSidebar() {
        sidebar?.classList.add("open");
        overlay?.classList.add("active");
        toggle?.classList.add("is-open");
        document.body.style.overflow = "hidden";
    }
    function closeSidebar() {
        sidebar?.classList.remove("open");
        overlay?.classList.remove("active");
        toggle?.classList.remove("is-open");
        document.body.style.overflow = "";
    }
    toggle?.addEventListener("click", () => {
        sidebar?.classList.contains("open") ? closeSidebar() : openSidebar();
    });
    overlay?.addEventListener("click", closeSidebar);

    // Close when clicking a nav link (mobile)
    sidebar?.querySelectorAll("a[href]").forEach(link => {
        link.addEventListener("click", () => {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });

    // ==============================
    // Sidebar accordion — sidebar-group
    // ==============================
    document.querySelectorAll(".sidebar-group-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const group = btn.closest(".sidebar-group");
            const isOpen = group.classList.contains("open");

            document.querySelectorAll(".sidebar-group.open").forEach(el => {
                if (el !== group) el.classList.remove("open");
            });

            group.classList.toggle("open", !isOpen);
        });
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".sidebar")) {
            if (window.innerWidth <= 900) {
                document.querySelectorAll(".sidebar-group.open").forEach(el => el.classList.remove("open"));
            }
        }
    });

    // ==============================
// Edit Guardian (data-id on the button)
// ==============================
    document.querySelectorAll(".btn-edit[data-id]").forEach(btn => {
        btn.addEventListener("click", function () {
            openParentModal(this.dataset.id);
        });
    });

    // ==============================
// content-type (Content Type — File/Link)
// ==============================
    const contentType = document.getElementById("content-type");
    if (contentType) {
        contentType.addEventListener("change", function () {
            const fileInput = document.getElementById("file-input");
            const linkInput = document.getElementById("link-input");
            if (fileInput) fileInput.style.display = "none";
            if (linkInput) linkInput.style.display = "none";
            if (this.value === "pdf_excel" && fileInput)                        fileInput.style.display = "block";
            if ((this.value === "video" || this.value === "link") && linkInput) linkInput.style.display = "block";
        });
    }

// ==============================
// Close the modal by clicking outside it.
// ==============================
    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("click", function (e) {
            if (e.target === this) this.style.display = "none";
        });
    });

    // ==============================
// Ads — Show/Hide Row Selection on Load
// ==============================
    const checkedTarget = document.querySelector('input[name="target_type"]:checked');
    if (checkedTarget) toggleClassSelector(checkedTarget);

    // ==============================
// Notifications — Toggle Recipient Type (targetType)
// ==============================
    const targetType   = document.getElementById("targetType");
    const classGroup   = document.getElementById("classGroup");
    const studentGroup = document.getElementById("studentGroup");

    if (targetType && classGroup && studentGroup) {
        targetType.addEventListener("change", function () {
            classGroup.style.display   = "none";
            studentGroup.style.display = "none";
            if (this.value === "class_students")                                       classGroup.style.display   = "block";
            if (this.value === "specific_student" || this.value === "specific_parent") studentGroup.style.display = "block";
        });
    }

    // ==============================
// Filter items by chapter
// ==============================
    const classSel   = document.getElementById("class_sel");
    const subjectSel = document.getElementById("subject_sel");

    if (classSel && subjectSel) {
        classSel.addEventListener("change", function () {
            const val = this.value;
            subjectSel.querySelectorAll("option").forEach(opt => {
                if (!opt.value) return;
                opt.style.display = (opt.dataset.class === val) ? "" : "none";
            });
            subjectSel.value = "";
        });
    }

    // ==============================
// Teacher Attendance — Update counters on load
 // ==============================
    const statusRadios = document.querySelectorAll(".status-radio");
    if (statusRadios.length > 0 && typeof updateCounts === "function") {
        statusRadios.forEach(r => r.addEventListener("change", updateCounts));
        updateCounts();
    }

    // ==============================
// Reports — Switch Recipient Type (recipientType)
// ==============================
    const recipientType = document.getElementById("recipientType");
    if (recipientType) {
        const teacherGroup  = document.getElementById("teacherGroup");
        const parentGroup   = document.getElementById("parentGroup");
        const teacherSel    = document.getElementById("teacherSel");
        const classSel2     = document.getElementById("classSel");
        const parentSelWrap = document.getElementById("parentSelWrap");
        const parentSel     = document.getElementById("parentSel");
        const noParentsMsg  = document.getElementById("noParentsMsg");

        function applyRecipient(val) {
            if (!teacherGroup || !parentGroup) return;
            [teacherGroup, parentGroup].forEach(g => g.className = "recipient-hidden");
            if (teacherSel) teacherSel.disabled = true;
            if (classSel2)  classSel2.disabled  = true;
            if (parentSel)  parentSel.disabled  = true;
            if (parentSelWrap) parentSelWrap.style.display = "none";
            if (noParentsMsg)  noParentsMsg.style.display  = "none";

            if (val === "teacher" && teacherGroup) {
                teacherGroup.className = "slide-in";
                if (teacherSel) teacherSel.disabled = false;
            } else if (val === "parent" && parentGroup) {
                parentGroup.className = "slide-in";
                if (classSel2) classSel2.disabled = false;
            }
        }

        if (classSel2) {
            classSel2.addEventListener("change", function () {
                if (!parentSel) return;
                parentSel.innerHTML        = '<option value="">— اختر ولي الأمر —</option>';
                parentSel.disabled         = true;
                if (parentSelWrap) parentSelWrap.style.display = "none";
                if (noParentsMsg)  noParentsMsg.style.display  = "none";
                if (!this.value) return;

                const data    = window.classParentsData || {};
                const parents = data[this.value] ?? [];
                if (parentSelWrap) parentSelWrap.style.display = "block";

                if (parents.length === 0) {
                    if (noParentsMsg) noParentsMsg.style.display = "block";
                    return;
                }
                parents.forEach(p => {
                    const opt = document.createElement("option");
                    opt.value       = p.user_id;
                    opt.textContent = p.full_name;
                    parentSel.appendChild(opt);
                });
                parentSel.disabled = false;
            });
        }

        recipientType.addEventListener("change", e => applyRecipient(e.target.value));
        applyRecipient(recipientType.value);
    }

});




// ==============================
// Helper: fetch JSON 
// ==============================
function adminFetch(url) {
    return fetch(url, {
        credentials: "same-origin",
        headers: { "Accept": "application/json", "X-Requested-With": "XMLHttpRequest" }
    }).then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    });
}

// ==============================
// Edit Student
// ==============================
function openEditModal(studentId, fetchUrl, updateUrl) {
    const url = fetchUrl || `/admin/students/get/${studentId}`;
    adminFetch(url)
        .then(student => {
            setValue("full_name",            student.full_name);
            setValue("mother_name",          student.mother_name);
            setValue("birth_date",           student.birth_date);
            setValue("gender",               student.gender);
            setValue("nationality",          student.nationality);
            setValue("student_phone_number", student.student_phone_number);
            setValue("father_phone_number",  student.father_phone_number);
            setValue("mother_phone_number",  student.mother_phone_number);
            setValue("notes",                student.notes);

            const form = document.getElementById("editForm");
            if (form) form.action = updateUrl || `/admin/students/update/${studentId}`;
            openModal("editModal");
        })
        .catch(err => { console.error("Student fetch error:", err); alert("فشل في جلب بيانات الطالب"); });
}


// ==============================
// Edit Teacher
// ==============================
function openTeacherModal(teacherId, fetchUrl, updateUrl) {
    const url = fetchUrl || `/admin/teachers/get/${teacherId}`;
    adminFetch(url)
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
            if (form) form.action = updateUrl || `/admin/teachers/update/${teacherId}`;
            openModal("teacherModal");
        })
        .catch(err => { console.error("Teacher fetch error:", err); alert("فشل في جلب بيانات المعلم"); });
}

function closeTeacherModal() {
    const modal = document.getElementById("teacherModal");
    if (modal) modal.style.display = "none";
}


// ==============================
// Edit Guardian
// ==============================
function openParentModal(parentId, fetchUrl, updateUrl) {
    const url = fetchUrl || `/admin/parents/${parentId}`;
    adminFetch(url)
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
            if (form) form.action = updateUrl || `/admin/parents/${parentId}`;
            openModal("editModal");
        })
        .catch(err => { console.error("Parent fetch error:", err); alert("فشل في جلب بيانات ولي الأمر"); });
}


// ==============================
// Assign Guardian to Student
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
        adminFetch(`/admin/assignments/get-students?class_id=${classId}`)
            .then(students => {
                studentEl.innerHTML = '<option value="">اختر الطالب</option>';
                students.forEach(s => {
                    studentEl.innerHTML += `<option value="${s.student_id}">${s.full_name}</option>`;
                });
            });
    });
}
 

// ==============================
// Shared utility functions
// ==============================
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = "flex";
}

function closeModal() {
    const modal = document.getElementById("editModal");
    if (modal) modal.style.display = "none";
}

function setValue(id, value) {
    const el = document.getElementById(id);
    if (el) el.value = value ?? "";
}


// ==============================
// Tabs
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
// Show/Hide Row Selection (Ads)
// // ==============================
function toggleClassSelector(el) {
    const selector = document.getElementById("class-selector");
    if (!selector) return;
    if (el.value === "class") {
        selector.style.display = "block";
        selector.classList.add("visible");
    } else {
        selector.style.display = "none";
        selector.classList.remove("visible");
    }
}

function toggleTheme() {
    // Dark only — no-op kept for backward compat
}


// ==============================
// Teachers' Attendance
// ==============================

function setAll(status) {
    document.querySelectorAll(`.status-radio[value="${status}"]`).forEach(r => r.checked = true);
    updateCounts();
}

function updateCounts() {
    const rows    = document.querySelectorAll("tr[data-student]");
    const total   = rows.length || document.querySelectorAll(".status-group").length;
    const present = document.querySelectorAll(".status-radio[value='present']:checked").length;
    const absent  = document.querySelectorAll(".status-radio[value='absent']:checked").length;
    const late    = document.querySelectorAll(".status-radio[value='late']:checked").length;
    const elTotal   = document.getElementById("countTotal");
    const elPresent = document.getElementById("countPresent");
    const elAbsent  = document.getElementById("countAbsent");
    const elLate    = document.getElementById("countLate");
    if (elTotal)   elTotal.textContent   = total;
    if (elPresent) elPresent.textContent = present;
    if (elAbsent)  elAbsent.textContent  = absent;
    if (elLate)    elLate.textContent    = late;
    const submitInfo = document.querySelector(".submit-info span");
    if (submitInfo) submitInfo.textContent = present;
}


 
/* ══════════════════════════════════════════
   Announcement Modal (Admin)
══════════════════════════════════════════ */
function openAdminAnn(data) {
    const modal = document.getElementById('adminAnnModal');
    if (!modal) return;

    const titleEl = document.getElementById('aAnnTitle');
    const metaEl  = document.getElementById('aAnnMeta');
    const bodyEl  = document.getElementById('aAnnBody');

    if (titleEl) titleEl.textContent = data.title || '';

    if (metaEl) {
        const initial = (data.sender || '-').charAt(0);
        metaEl.innerHTML = `<div class="modal-chips">
            <span class="ann-chip ann-chip-blue">
                <span class="ann-chip-avatar">${initial}</span>
                ${data.sender || '---'}
                <em>${data.role || ''}</em>
            </span>
            <span class="ann-chip ann-chip-teal">
                <i class='bx bx-globe'></i>
                ${data.target || ''}
            </span>
            <span class="ann-chip ann-chip-dim">
                <i class='bx bx-calendar'></i>
                ${data.date || ''}
            </span>
        </div>`;
    }

    if (bodyEl) bodyEl.textContent = data.body || '';

    modal.style.display = 'flex';
}

function closeAdminAnn() {
    const modal = document.getElementById('adminAnnModal');
    if (modal) modal.style.display = 'none';
}

/* ══════════════════════════════════════════
   Report Modal (Admin)
══════════════════════════════════════════ */
function openAdminReport(data) {
    const modal = document.getElementById('adminRepModal');
    if (!modal) return;

    const titleEl = document.getElementById('aRepTitle');
    const metaEl  = document.getElementById('aRepMeta');
    const bodyEl  = document.getElementById('aRepBody');

    if (titleEl) titleEl.textContent = data.title || '';

    if (metaEl) {
        const initial    = (data.recipient || '-').charAt(0);
        const isTeacher  = data.recipient_role === 'teacher';
        const chipColor  = isTeacher ? 'ann-chip-blue' : 'ann-chip-yellow';
        const roleLabel  = isTeacher ? 'معلم' : 'ولي أمر';
        const studentChip = data.student
            ? `<span class="ann-chip ann-chip-green"><i class='bx bx-user-graduate'></i>${data.student}</span>`
            : '';
        metaEl.innerHTML = `<div class="modal-chips">
            <span class="ann-chip ann-chip-teal">
                <i class='bx bx-tag'></i>
                ${data.type || ''}
            </span>
            <span class="ann-chip ${chipColor}">
                <span class="ann-chip-avatar">${initial}</span>
                ${data.recipient || '---'}
                <em>${roleLabel}</em>
            </span>
            ${studentChip}
            <span class="ann-chip ann-chip-dim">
                <i class='bx bx-calendar'></i>
                ${data.date || ''}
            </span>
        </div>`;
    }

    if (bodyEl) bodyEl.textContent = data.content || '';

    modal.style.display = 'flex';
}

function closeAdminReport() {
    const modal = document.getElementById('adminRepModal');
    if (modal) modal.style.display = 'none';
}
