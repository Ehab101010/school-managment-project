 
document.addEventListener("DOMContentLoaded", () => {

    /* ══════════════════════════════════════════
       SIDEBAR — Submenu Toggle
    ══════════════════════════════════════════ */
    document.querySelectorAll(".menu-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            const parent = btn.closest(".menu-item");
            // Close other open items
            document.querySelectorAll(".menu-item.open").forEach((item) => {
                if (item !== parent) item.classList.remove("open");
            });
            parent.classList.toggle("open");
        });
    });
 
    /* ══════════════════════════════════════════
       ACTIVE NAV LINK — Auto-detect from URL
    ══════════════════════════════════════════ */
    const currentPath = window.location.pathname;
    document.querySelectorAll(".sidebar-menu a").forEach((link) => {
        const href = link.getAttribute("href");
        if (href && href !== "#" && currentPath.startsWith(href)) {
            link.classList.add("active");
            // Open parent submenu if inside one
            const parentItem = link.closest(".menu-item");
            if (parentItem) parentItem.classList.add("open");
        }
    });
    
    
    
    
    
       /* ══════════════════════════════════════════
    Open / Close Message Modal
       ══════════════════════════════════════════ */
    
    window.closeStuReport = function() {
    const modal = document.getElementById('stuReportModal');
    if (modal) {
        modal.classList.remove('active'); // أو modal.style.display = 'none'; حسب الـ CSS لديك
    }
};

window.openStuReport = function(data) {
    const modal = document.getElementById('stuReportModal');
    if (!modal) return;

    // 1. تعبئة العنوان
    document.getElementById('stuRepTitle').textContent = data.title;

    // 2. بناء "الميتا" (البيانات الفرعية) بشكل ديناميكي
    let metaHTML = `
        <span class="nbadge ${data.type_class}">${data.type}</span>
        <span class="nbadge ${data.is_teacher ? 'b-teacher' : 'b-admin'}">
            ${data.is_teacher ? '👨‍🏫' : '🏫'} ${data.sender}
        </span>
    `;

    if (data.subject) {
        metaHTML += `
            <span class="nbadge b-high">
                <i class='bx bx-book-open'></i> ${data.subject}
            </span>`;
    }

    metaHTML += `<span class="notif-time"><i class='bx bx-calendar'></i> ${data.date}</span>`;

    document.getElementById('stuRepMeta').innerHTML = metaHTML;

    // 3. تعبئة نص الرسالة/المحتوى
    // استخدم textContent للأمان، أو innerHTML إذا كنت ترسل تنسيق HTML من السيرفر
    document.getElementById('stuRepBody').textContent = data.content;

    // 4. إظهار المودال
    modal.classList.add('active');
};


    /* ══════════════════════════════════════════
    Open / Close Ann Modal
    ══════════════════════════════════════════ */
// دالة فتح مودال الإعلانات
window.openAnnModal = function(data) {
    const modal = document.getElementById('stuAnnModal');
    if (!modal) return;

    // 1. تعبئة العنوان
    document.getElementById('stuAnnTitle').textContent = data.title;

    // 2. بناء الميتا (بيانات المرسل، المادة، الهدف، التاريخ)
    let metaHTML = `
        <span class="badge-sm ${data.sender_class}">
            <i class='bx bx-user'></i> ${data.sender}
        </span>
    `;

    if (data.is_teacher && data.subject) {
        metaHTML += `
            <span class="badge-sm b-high">
                <i class='bx bx-book-open'></i> ${data.subject}
            </span>`;
    }

    metaHTML += `
        <span class="badge-sm b-target"><i class='bx bx-group'></i> ${data.target}</span>
        <span class="notif-time"><i class='bx bx-calendar'></i> ${data.date}</span>
    `;

    document.getElementById('stuAnnMeta').innerHTML = metaHTML;

    // 3. تعبئة نص الإعلان
    document.getElementById('stuAnnBody').textContent = data.body;

    // 4. إظهار المودال
    modal.classList.add('active');
};

// دالة إغلاق مودال الإعلانات
window.closeStuAnn = function() {
    const modal = document.getElementById('stuAnnModal');
    if (modal) {
        modal.classList.remove('active');
    }
};
    /* ══════════════════════════════════════════
       EXAM COUNTDOWN BADGES
    ══════════════════════════════════════════ */
    document.querySelectorAll("[data-exam-date]").forEach((el) => {
        const examDate = new Date(el.dataset.examDate);
        const today    = new Date();
        today.setHours(0, 0, 0, 0);
        const diffDays = Math.ceil((examDate - today) / 86400000);

        if (diffDays === 0) {
            el.insertAdjacentHTML("beforeend", `<span class="countdown-pill today">اليوم!</span>`);
        } else if (diffDays > 0 && diffDays <= 7) {
            el.insertAdjacentHTML("beforeend", `<span class="countdown-pill soon">بعد ${diffDays} أيام</span>`);
        }
    });

    /* ══════════════════════════════════════════
       ATTENDANCE CIRCLE ANIMATION
    ══════════════════════════════════════════ */
    const circleFill = document.querySelector(".circle-fill");
    if (circleFill) {
        const pct = parseFloat(circleFill.dataset.pct || 0);
        setTimeout(() => {
            circleFill.style.strokeDasharray = `${pct * 3.267} 327`;
        }, 300);
    }

    /* ══════════════════════════════════════════
       FADE-IN OBSERVER
    ══════════════════════════════════════════ */
    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = "running";
                fadeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.07 });

    document.querySelectorAll(".fade-in").forEach((el) => {
        el.style.animationPlayState = "paused";
        fadeObserver.observe(el);
    });

    /* ══════════════════════════════════════════
       ANNOUNCEMENT FILTER
    ══════════════════════════════════════════ */
    // Exposed globally for onclick usage in blade templates
    window.filterAnns = (type, btn) => {
        document.querySelectorAll(".filter-tab").forEach((t) => t.classList.remove("active"));
        btn.classList.add("active");
        document.querySelectorAll("#annGrid .ann-card").forEach((card) => {
            const show = type === "all" || card.dataset.role === type;
            card.style.display = show ? "flex" : "none";
        });
    };

    /* ══════════════════════════════════════════
       CONTENT PAGE — Subject / Panel Toggle
    ══════════════════════════════════════════ */
    const allContentEl = document.getElementById("allContentData");
    if (allContentEl) {
        window.allContent = JSON.parse(allContentEl.textContent || "[]");
    }

    const typeIcons = {
        video: "bx-play-circle",
        pdf: "bxs-file-pdf",
        excel: "bx-table",
        assignment: "bx-task",
        link: "bx-link-external",
    };

    const typeLabels = {
        video: "فيديو",
        pdf: "PDF",
        excel: "Excel",
        assignment: "واجب",
        link: "رابط",
    };

    window.showSubject = (subjectId, subjectName, e) => {
        e.preventDefault();
        if (!window.allContent) return;

        const items = window.allContent.filter((i) => i.subject_id == subjectId);
        const grid  = document.getElementById("itemsGrid");
        if (!grid) return;

        grid.innerHTML = items.map((item, idx) => {
            const icon    = typeIcons[item.content_type]  || "bx-file";
            const label   = typeLabels[item.content_type] || item.content_type;
            const url     = item.file_url || item.external_link;
            const btnIcon = item.file_url ? "bx-download" : "bx-link-external";
            const btnText = item.file_url ? "تحميل" : "فتح الرابط";
            const desc    = item.description ? `<p class="item-desc">${item.description}</p>` : "";

            return `
            <div class="content-item-card" style="animation-delay:${idx * 0.05}s">
                <div class="item-icon ${item.content_type}">
                    <i class="bx ${icon}"></i>
                </div>
                <div class="item-body">
                    <div class="item-title">${item.title}</div>
                    ${desc}
                    <div style="display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--text-muted);margin-bottom:8px;">
                        <i class="bx bx-calendar" style="color:var(--accent-2);font-size:13px;"></i>
                        ${item.created_at || "—"}
                    </div>
                    ${url
                        ? `<a href="${url}" target="_blank" class="item-link"><i class="bx ${btnIcon}"></i> ${btnText}</a>`
                        : `<span style="color:var(--text-muted);font-size:12px;">لا يوجد ملف</span>`
                    }
                </div>
            </div>`;
        }).join("");

        document.getElementById("panelTitle").textContent = subjectName;
        const subjectsView = document.getElementById("subjectsView");
        const contentPanel = document.getElementById("contentPanel");
        if (subjectsView) subjectsView.style.display = "none";
        if (contentPanel) contentPanel.classList.add("active");
        window.scrollTo({ top: 0, behavior: "smooth" });
    };

    window.showSubjects = () => {
        const subjectsView = document.getElementById("subjectsView");
        const contentPanel = document.getElementById("contentPanel");
        if (contentPanel) contentPanel.classList.remove("active");
        if (subjectsView) subjectsView.style.display = "block";
        window.scrollTo({ top: 0, behavior: "smooth" });
    };

});


// ============================================================
// ATTENDANCE PAGE  
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.subj-row-fill').forEach(el => {
        const w = el.style.width;
        el.style.width = '0';
        setTimeout(() => { el.style.width = w; }, 280);
    });
});
  


