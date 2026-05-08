document.addEventListener("DOMContentLoaded", () => {
    // ============================================================
    // SIDEBAR NAVIGATION (Accordion Menu) - النسخة المطورة
    // ============================================================
    const submenuButtons = document.querySelectorAll(".submenu-btn");

    submenuButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const parent = btn.parentElement;
            
            // إغلاق أي قائمة أخرى مفتوحة (اختياري - إذا أردت فتح قائمة واحدة فقط في كل مرة)
            document.querySelectorAll(".menu-item.has-submenu.open").forEach((item) => {
                if (item !== parent) item.classList.remove("open");
            });

            // تبديل القائمة الحالية
            parent.classList.toggle("open");
        });
    });

    // تأكد من بقاء القائمة مفتوحة إذا كان الرابط النشط بداخلها
    const activeSubmenu = document.querySelector(".submenu .active");
    if (activeSubmenu) {
        activeSubmenu.closest(".has-submenu").classList.add("open");
    }
});
 
// ... باقي الكود الخاص بالدرجات والفلترة (اتركه كما هو) ...
// ============================================================
// TAB MANAGEMENT (Inbox/Sent Toggle)
// ============================================================
function showTab(tabId, btn) {
    document.getElementById('received').style.display = 'none';
    document.getElementById('sent').style.display     = 'none';

    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

    document.getElementById(tabId).style.display = 'block';
    btn.classList.add('active');
}

// ============================================================
// MODAL SYSTEM (Edit Student/Record)
// ============================================================
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editModal");
    const closeModalBtn = document.getElementById("closeModal");
    const editButtons = document.querySelectorAll(".btn.edit");

    if (modal && closeModalBtn) {
        editButtons.forEach((btn) => {
            btn.addEventListener("click", () => {
                modal.style.display = "flex";
            });
        });

        closeModalBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        window.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    }
});

// ============================================================
// DYNAMIC GRADES CALCULATION (Real-time Total)
// ============================================================
function calculateTotal(input) {
    const row = input.closest("tr");
    const inputs = row.querySelectorAll(".grade-input");
    let total = 0;

    inputs.forEach((i) => {
        const value = parseFloat(i.value) || 0;
        total += value;
    });

    row.querySelector(".total-cell").textContent = total;
}

// ============================================================
// ACADEMIC DATA FETCHING (Classes, Sections, Subjects)
// ============================================================
if (document.getElementById("classSelect")) {
    document.getElementById("classSelect").addEventListener("change", function () {
        let classId = this.value;
        fetch(`/teacher/get-sections/${classId}`)
            .then((res) => res.json())
            .then((data) => {
                let sectionSelect = document.getElementById("sectionSelect");
                sectionSelect.innerHTML = '<option value="">اختر الشعبة</option>';
                data.forEach((section) => {
                    sectionSelect.innerHTML += `<option value="${section.section_id}">${section.section_type}</option>`;
                });
            });
    });

    document.getElementById("sectionSelect").addEventListener("change", function () {
        let classId = document.getElementById("classSelect").value;
        let sectionId = this.value;
        fetch(`/teacher/get-subjects/${classId}/${sectionId}`)
            .then((res) => res.json())
            .then((data) => {
                let subjectSelect = document.getElementById("subjectSelect");
                subjectSelect.innerHTML = '<option value="">اختر المادة</option>';
                if (data.status === "empty") {
                    subjectSelect.innerHTML = '<option value="">لا يوجد مواد</option>';
                    return;
                }
                data.forEach((sub) => {
                    subjectSelect.innerHTML += `<option value="${sub.subject_id}">${sub.subject_name}</option>`;
                });
            });
    });

    document.getElementById("loadStudents").addEventListener("click", function () {
        let classId = document.getElementById("classSelect").value;
        let sectionId = document.getElementById("sectionSelect").value;
        let subjectId = document.getElementById("subjectSelect").value;

        fetch(`/teacher/get-students/${classId}/${sectionId}/${subjectId}`)
            .then((res) => res.json())
            .then((data) => {
                let tbody = document.querySelector(".grades-input-table tbody");
                tbody.innerHTML = "";
                if (data.status === "empty") {
                    tbody.innerHTML = '<tr><td colspan="7">لا يوجد طلاب</td></tr>';
                    return;
                }
                let i = 1;
                data.forEach((stu) => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${i++}</td>
                            <td>${stu.student_name}</td>
                            <td><input type="number" min="0" max="20" class="grade-input" oninput="calculateTotal(this)"></td>
                            <td><input type="number" min="0" max="20" class="grade-input" oninput="calculateTotal(this)"></td>
                            <td><input type="number" min="0" max="10" class="grade-input" oninput="calculateTotal(this)"></td>
                            <td><input type="number" min="0" max="50" class="grade-input" oninput="calculateTotal(this)"></td>
                            <td class="total-cell">0</td>
                        </tr>`;
                });
            });
    });
}

// ============================================================
// CREATE CONTENT (Material Type & File Upload Zones)
// ============================================================
(function () {
    const cards   = document.querySelectorAll('.type-card');
    const panels  = document.querySelectorAll('.upload-panel');

    function showPanel(value) {
        panels.forEach(p => p.classList.remove('active'));
        if (value) {
            const target = document.getElementById('panel-' + value);
            if (target) target.classList.add('active');
        }
    }

    cards.forEach(card => {
        card.addEventListener('click', () => {
            cards.forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            const radio = card.querySelector('input[type="radio"]');
            radio.checked = true;
            showPanel(radio.value);
        });
    });

    const checkedRadio = document.querySelector('input[name="content_type"]:checked');
    if (checkedRadio) showPanel(checkedRadio.value);

    function setupUploadZone(zoneId, inputId, fnameId) {
        const zone  = document.getElementById(zoneId);
        const input = document.getElementById(inputId);
        const fname = document.getElementById(fnameId);
        if (!zone || !input) return;

        input.addEventListener('change', () => {
            if (input.files.length) {
                fname.textContent    = '✓ ' + input.files[0].name;
                fname.style.display  = 'block';
            }
        });
        zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', ()  => zone.classList.remove('drag-over'));
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('drag-over');
            if (e.dataTransfer.files.length) {
                input.files          = e.dataTransfer.files;
                fname.textContent    = '✓ ' + e.dataTransfer.files[0].name;
                fname.style.display  = 'block';
            }
        });
    }

    setupUploadZone('zone-pdf',   'file-pdf',   'fname-pdf');
    setupUploadZone('zone-excel', 'file-excel', 'fname-excel');
    setupUploadZone('zone-ppt',   'file-ppt',   'fname-ppt');
})();

// ============================================================
// ADD GRADES (Blade Template Total Calculation)
// ============================================================
document.querySelectorAll('.grade-input').forEach(input => {
    input.addEventListener('input', function () {
        const row    = this.closest('tr');
        const first  = Number(row.querySelector('input[name*="[first]"]').value)    || 0;
        const second = Number(row.querySelector('input[name*="[second]"]').value)   || 0;
        const act    = Number(row.querySelector('input[name*="[activity]"]').value) || 0;
        const finalE = Number(row.querySelector('input[name*="[final]"]').value)    || 0;
        row.querySelector('.total-field').value = first + second + act + finalE;
    });
});
// ============================================================
// ATTENDANCE FILTERING (Class -> Subject)
// ============================================================
document.addEventListener("DOMContentLoaded", () => {
    const classSel = document.getElementById('class_sel');
    const subjectSel = document.getElementById('subject_sel');
    
    if (classSel && subjectSel) {
        const allSubjectOptions = subjectSel.querySelectorAll('option');

        classSel.addEventListener('change', function() {
            const selectedClassId = this.value;

             subjectSel.value = "";

             allSubjectOptions.forEach(option => {
                const optionClassId = option.getAttribute('data-class');

                 if (!optionClassId) {
                    option.style.display = "block";
                    return;
                }

                 if (optionClassId === selectedClassId) {
                    option.style.display = "block";
                } else {
                    option.style.display = "none";
                }
            });
        });
    }
});
// ============================================================
// REPORT CREATION (Filtering Students/Parents)
// ============================================================
(function () {
    if (typeof window.REPORT_DATA === 'undefined') return;

    const CLASSES  = window.REPORT_DATA.classes;
    const STUDENTS = window.REPORT_DATA.students;
    let currentTarget = 'student';

    const parentsMap = {};
    STUDENTS.filter(s => s.has_parent && s.parent_name).forEach(s => {
        if (!parentsMap[s.parent_name]) parentsMap[s.parent_name] = s;
    });

    window.switchTarget = function (type) {
        currentTarget = type;
        document.getElementById('targetType').value = type;
        document.getElementById('btn-student').classList.toggle('active', type === 'student');
        document.getElementById('btn-parent').classList.toggle('active',  type === 'parent');
        document.getElementById('panel-student').classList.toggle('active', type === 'student');
        document.getElementById('panel-parent').classList.toggle('active',  type === 'parent');
        document.getElementById('parentSel').disabled  = type !== 'parent';
        document.getElementById('studentSel').disabled = true;
        if (type === 'parent') fillParentSel();
    };

    function fillParentSel() {
        const sel = document.getElementById('parentSel');
        sel.innerHTML = '<option value="">-- اختر ولي الأمر --</option>';
        Object.values(parentsMap).forEach(s => {
            sel.innerHTML += `<option value="${s.student_id}">${s.parent_name}</option>`;
        });
        sel.disabled = false;
    }

    window.onClassName = function () {
        const name   = document.getElementById('classNameSel').value;
        const secSel = document.getElementById('sectionSel');
        secSel.innerHTML = '<option value="">-- اختر الشعبة --</option>';
        secSel.disabled  = !name;
        resetStudentSel();
        if (!name) return;
        CLASSES.filter(c => c.class_name === name).forEach(c => {
            const o = document.createElement('option');
            o.value       = c.class_id;
            o.textContent = c.section_name + (c.section_type ? ` (${c.section_type})` : '');
            secSel.appendChild(o);
        });
        if (secSel.options.length === 2) { secSel.selectedIndex = 1; window.onSection(); }
    };

    window.onSection = function () {
        fillStudents(document.getElementById('sectionSel').value);
    };

    function fillStudents(classId) {
        const sel = document.getElementById('studentSel');
        sel.innerHTML = '<option value="">-- اختر الطالب --</option>';
        sel.disabled  = !classId;
        resetParentPreview();
        if (!classId) return;
        STUDENTS.filter(s => s.class_id == classId).forEach(s => {
            const o = document.createElement('option');
            o.value              = s.student_id;
            o.textContent        = s.full_name;
            o.dataset.hasParent  = s.has_parent ? '1' : '0';
            o.dataset.parentName = s.parent_name ?? '';
            sel.appendChild(o);
        });
    }

    window.showParentPreview = function () {
        const sel       = document.getElementById('studentSel');
        const opt       = sel.options[sel.selectedIndex];
        const hasParent = opt?.dataset?.hasParent === '1';
        const name      = opt?.dataset?.parentName ?? '';
        document.getElementById('parentPreview').style.display = (sel.value && hasParent)  ? 'block' : 'none';
        document.getElementById('noParentWarn').style.display  = (sel.value && !hasParent) ? 'block' : 'none';
        if (hasParent) document.getElementById('parentNameText').textContent = name;
    };

    function resetStudentSel() {
        const sel = document.getElementById('studentSel');
        sel.innerHTML = '<option value="">-- اختر الشعبة أولاً --</option>';
        sel.disabled  = true;
        resetParentPreview();
    }

    function resetParentPreview() {
        document.getElementById('parentPreview').style.display = 'none';
        document.getElementById('noParentWarn').style.display  = 'none';
    }
})();
 