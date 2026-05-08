/**
 * shared-modal.js — Shared functions between all project interfaces.
 * Loaded after the specific JS for each user role.
 */

/* ==============================
   Global Constants & Labels
   ============================== */
const REPORT_TYPE_LABELS = {
    performance : '📊 أداء أكاديمي',
    behavior    : '🧠 سلوك',
    attendance  : '📅 حضور',
    general     : '📋 عام',
};

/* ==============================
   Core Modal Engine (Open/Close)
   ============================== */

/**
 * @param {string} modalId   - The overlay ID
 * @param {string} titleId   - The title element ID
 * @param {string} metaId    - The meta badges element ID
 * @param {string} bodyId    - The body text element ID
 * @param {string} title     - Title text
 * @param {string} body      - Content text
 * @param {string} metaHtml  - Prepared HTML for badges
 */
function _openModal(modalId, titleId, metaId, bodyId, title, body, metaHtml) {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;

    document.getElementById(titleId).textContent = title;
    document.getElementById(bodyId).textContent  = body;
    document.getElementById(metaId).innerHTML    = metaHtml;

    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function _closeModal(modalId) {
    const overlay = document.getElementById(modalId);
    if (!overlay) return;
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}

/* ==============================
   Badge Generator Helpers
   ============================== */
function _badge(icon, text, style) {
    const iconHtml = icon ? `<i class='bx ${icon}'></i> ` : '';
    return `<span style="${style}">${iconHtml}${text}</span>`;
}

const BADGE = {
    muted  : (icon, text) => _badge(icon, text, 'background:var(--bg,#f0f4f8);color:var(--text-muted,#627b92);border:1px solid var(--border,#dde3ed)'),
    blue   : (icon, text) => _badge(icon, text, 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe'),
    green  : (icon, text) => _badge(icon, text, 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0'),
    yellow : (icon, text) => _badge(icon, text, 'background:#fef9c3;color:#92400e;border:1px solid #fde68a'),
    purple : (icon, text) => _badge(icon, text, 'background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe'),
    red    : (icon, text) => _badge(icon, text, 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca'),
    class  : (cls, icon, text) => `<span class="${cls}"><i class='bx ${icon}'></i> ${text}</span>`,
};

/* ==============================
   Parent Interface (Announcements & Messages)
   ============================== */
function openAnn(data) {
    const senderClass = data.sender === 'الإدارة' ? 't-admin' : 't-teacher';
    let meta = `<span class="tag ${senderClass}"><i class='bx bx-user'></i> ${data.sender}</span>`;
    if (data.is_teacher && data.subject)
        meta += `<span class="tag" style="background:#fef3c7;color:#92400e"><i class='bx bx-book-open'></i> ${data.subject}</span>`;
    meta += `<span class="tag t-target"><i class='bx bx-group'></i> ${data.target}</span>`;
    meta += BADGE.muted('bx-calendar', data.date);
    _openModal('annModal', 'mTitle', 'mMeta', 'mBody', data.title, data.body, meta);
}

function closeAnn() { _closeModal('annModal'); }
function closeOutside(e) { if (e.target === document.getElementById('annModal')) closeAnn(); }

function openModal(msg) {
    const isTeacher   = msg.sender_role === 'teacher';
    const sender      = isTeacher ? (msg.sender_name || 'معلم') : 'الإدارة';
    const senderClass = isTeacher ? 'badge-teacher' : 'badge-admin';
    const date        = new Date(msg.created_at).toLocaleDateString('ar-SA', { year:'numeric', month:'long', day:'numeric' });
    const rtype       = REPORT_TYPE_LABELS[msg.report_type] || '📋 عام';

    let meta = `<span class="badge ${senderClass}"><i class='bx bx-user'></i> ${sender}</span>`;
    if (isTeacher && msg.subject_name)
        meta += `<span class="badge" style="background:#fef3c7;color:#92400e"><i class='bx bx-book-open'></i> ${msg.subject_name}</span>`;
    meta += BADGE.muted('bx-calendar', date);
    meta += `<span class="badge rtype-general">${rtype}</span>`;
    if (msg.student) meta += `<span class="badge badge-student"><i class='bx bxs-graduation'></i> ${msg.student}</span>`;
    if (msg.period)  meta += BADGE.muted('bx-calendar', msg.period);

    _openModal('msgModal', 'modalTitle', 'modalMeta', 'modalBody', msg.title, msg.body, meta);
}

function closeModal()         { _closeModal('msgModal'); }
function closeModalOutside(e) { if (e.target === document.getElementById('msgModal')) closeModal(); }

/* ==============================
   Student Interface (Announcements & Reports)
   ============================== */
function openAnnModal(data) {
    const senderClass = data.sender_class || 'b-admin';
    let meta = `<span class="badge-sm ${senderClass}"><i class='bx bx-user'></i> ${data.sender}</span>`;
    if (data.is_teacher && data.subject)
        meta += `<span class="badge-sm b-high"><i class='bx bx-book-open'></i> ${data.subject}</span>`;
    meta += `<span class="badge-sm b-target"><i class='bx bx-group'></i> ${data.target}</span>`;
    meta += `<span class="badge-sm" style="background:var(--bg);color:var(--text-muted);border:1px solid var(--border)"><i class='bx bx-calendar'></i> ${data.date}</span>`;
    _openModal('stuAnnModal', 'stuAnnTitle', 'stuAnnMeta', 'stuAnnBody', data.title, data.body, meta);
}

function closeStuAnn() { _closeModal('stuAnnModal'); }

function openStuReport(data) {
    const senderClass = data.is_teacher ? 'b-teacher' : 'b-admin';
    const typeLabel   = REPORT_TYPE_LABELS[data.type] || data.type;
    let meta = `<span class="nbadge ${senderClass}">${data.is_teacher ? '👨‍🏫 ' : '🏫 '}${data.sender}</span>`;
    meta += `<span class="nbadge nbadge-normal">${typeLabel}</span>`;
    if (data.subject) meta += `<span class="nbadge b-high"><i class='bx bx-book-open' style='font-size:11px'></i> ${data.subject}</span>`;
    if (data.period)  meta += `<span class="nbadge" style="background:var(--bg);color:var(--text-muted);border:1px solid var(--border)"><i class='bx bx-calendar'></i> ${data.period}</span>`;
    meta += `<span class="nbadge" style="background:var(--bg);color:var(--text-muted);border:1px solid var(--border)"><i class='bx bx-calendar'></i> ${data.date}</span>`;
    _openModal('stuReportModal', 'stuRepTitle', 'stuRepMeta', 'stuRepBody', data.title, data.content, meta);
}

function closeStuReport() { _closeModal('stuReportModal'); }

/* ==============================
   Teacher Interface (Announcements & Inbox)
   ============================== */
function openTeacherAnn(data) {
    let meta = `<span class="badge-sm ${data.sender_class}"><i class='bx bx-user'></i> ${data.sender}</span>`;
    if (data.subject) meta += `<span class="badge-sm b-high"><i class='bx bx-book-open'></i> ${data.subject}</span>`;
    meta += `<span class="badge-sm b-target"><i class='bx bx-group'></i> ${data.target}</span>`;
    meta += `<span class="badge-sm" style="background:var(--bg);color:var(--text-muted);border:1px solid var(--border)"><i class='bx bx-calendar'></i> ${data.date}</span>`;
    _openModal('teacherAnnModal', 'tAnnTitle', 'tAnnMeta', 'tAnnBody', data.title, data.body, meta);
}

function closeTeacherAnn() { _closeModal('teacherAnnModal'); }

function openTeacherMsg(data) {
    const typeLabel = REPORT_TYPE_LABELS[data.type] || '📋 عام';
    let meta = `<span class="badge-sm b-admin"><i class='bx bx-shield-alt-2'></i> ${data.sender}</span>`;
    meta += BADGE.green(null, typeLabel);
    if (data.student) meta += `<span class="badge-sm b-sa"><i class='bx bx-user-graduate'></i> ${data.student}</span>`;
    if (data.period)  meta += BADGE.muted('bx-calendar', data.period);
    meta += BADGE.muted('bx-calendar', data.date);
    meta += data.is_read
        ? BADGE.green('bx-check-double', 'مقروءة')
        : BADGE.yellow('bx-envelope', 'غير مقروءة');
    _openModal('teacherMsgModal', 'tMsgTitle', 'tMsgMeta', 'tMsgBody', data.title, data.content, meta);
}

function closeTeacherMsg() { _closeModal('teacherMsgModal'); }

/* ==============================
   Admin & Student Affairs (Announcements & Sent Reports)
   ============================= */
function openAdminAnn(data) {
    let meta = BADGE.blue('bx-user', `${data.sender} (${data.role})`);
    meta += BADGE.green('bx-group', data.target);
    meta += BADGE.muted('bx-calendar', data.date);
    _openModal('adminAnnModal', 'aAnnTitle', 'aAnnMeta', 'aAnnBody', data.title, data.body, meta);
}

function closeAdminAnn() { _closeModal('adminAnnModal'); }

function openAdminReport(data) {
    const typeLabel      = REPORT_TYPE_LABELS[data.type] || '📋 عام';
    const recipientBadge = data.recipient_role === 'teacher'
        ? BADGE.blue('bx-send', `إلى: 👨‍🏫 ${data.recipient}`)
        : BADGE.yellow('bx-send', `إلى: 👪 ${data.recipient}`);
    let meta  = BADGE.green(null, typeLabel);
    meta     += recipientBadge;
    if (data.student) meta += BADGE.purple('bx-user-graduate', data.student);
    meta += BADGE.muted('bx-calendar', data.date);
    _openModal('adminRepModal', 'aRepTitle', 'aRepMeta', 'aRepBody', data.title, data.content, meta);
}

function closeAdminReport() { _closeModal('adminRepModal'); }

/* ==============================
   Keyboard Accessibility (ESC to Close)
   ============================== */
document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    [
        'annModal', 'msgModal',
        'stuAnnModal', 'stuReportModal',
        'teacherAnnModal', 'teacherMsgModal',
        'adminAnnModal', 'adminRepModal',
    ].forEach(id => {
        const el = document.getElementById(id);
        if (el?.classList.contains('open')) _closeModal(id);
    });
});