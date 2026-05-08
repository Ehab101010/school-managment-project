{{-- resources/views/teacher/report/rep-create.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Notifications.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-messages fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-envelope'></i> رسالة جديدة</h1>
                <p>إرسال تقرير أو تقييم لولي الأمر أو الإدارة</p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.notifications.inbox') }}" class="hero-btn hero-btn-ghost">
                    <i class='bx bx-arrow-back'></i> رجوع
                </a>
                <div class="hero-icon-wrap"><i class='bx bxs-envelope'></i></div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger fade-in"><i class='bx bx-error-circle'></i> {{ session('error') }}</div>
    @endif
    @if(session('success'))
    <div class="alert alert-success fade-in"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
    @endif

    <div class="notif-compose-wrap fade-in">
        <form action="{{ route('teacher.report.store') }}" method="POST">
            @csrf

            {{-- ─── تفاصيل الرسالة ─── --}}
            <div class="notif-compose-form">
                <div class="form-card">
                    <div class="form-card-header" style="background:linear-gradient(135deg,#1a1040,#2563a8);">
                        <i class='bx bx-edit'></i>
                        <h2>تفاصيل الرسالة</h2>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label>عنوان الرسالة <span class="req">*</span></label>
                            <input type="text" name="title"
                                   placeholder="مثال: تقرير أداء الطالب - الفصل الأول"
                                   required value="{{ old('title') }}">
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div class="form-group">
                                <label>نوع الرسالة</label>
                                <select name="report_type" required>
                                    <option value="performance" {{ old('report_type','performance')=='performance'?'selected':'' }}>📊 أداء أكاديمي</option>
                                    <option value="behavior"    {{ old('report_type')=='behavior'   ?'selected':'' }}>🧠 سلوك</option>
                                    <option value="attendance"  {{ old('report_type')=='attendance' ?'selected':'' }}>📅 حضور وغياب</option>
                                    <option value="general"     {{ old('report_type')=='general'    ?'selected':'' }}>📋 عام</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>الفترة الزمنية</label>
                                <input type="text" name="period"
                                       placeholder="مثال: الفصل الأول 2025"
                                       value="{{ old('period') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>محتوى الرسالة <span class="req">*</span></label>
                            <textarea name="content" rows="9" required
                                      placeholder="اكتب تفاصيل رسالتك هنا..."
                                      style="min-height:220px;">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── المستلم ─── --}}
            <div class="notif-compose-recipients">
                <div class="form-card">
                    <div class="form-card-header" style="background:linear-gradient(135deg,#1a1040,#7c3aed);">
                        <i class='bx bx-user-check'></i>
                        <h2>المستلم</h2>
                    </div>
                    <div class="form-card-body">

                        {{-- نوع الإرسال --}}
                        <div class="step-label"><span class="step-badge">1</span> نوع المستلم</div>
                        <div class="target-toggle">
                            <div class="toggle-btn active" id="btn-student" onclick="switchTarget('student')">
                                <i class='bx bx-user-graduate'></i> طالب محدد
                            </div>
                            <div class="toggle-btn" id="btn-parent" onclick="switchTarget('parent')">
                                <i class='bx bx-group'></i> ولي أمر مباشرة
                            </div>
                        </div>
                        <input type="hidden" name="target_type" id="targetType" value="student">

                        {{-- ── طالب محدد ── --}}
                        <div class="sub-panel active" id="panel-student">
                            <div class="step-label"><span class="step-badge">2</span> اختر الصف والشعبة</div>
                            <div class="filter-row">
                                <div class="form-group">
                                    <label>اسم الصف</label>
                                    <select id="classNameSel" onchange="onClassName()">
                                        <option value="">-- اختر الصف --</option>
                                        @foreach($classNames as $name)
                                            <option value="{{ $name }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>الشعبة</label>
                                    <select id="sectionSel" onchange="onSection()" disabled>
                                        <option value="">-- اختر الشعبة --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="step-label"><span class="step-badge">3</span> اختر الطالب</div>
                            <div class="form-group">
                                <select name="student_id" id="studentSel"
                                        onchange="showParentPreview()" disabled>
                                    <option value="">-- اختر الشعبة أولاً --</option>
                                </select>
                            </div>

                            <div id="parentPreview" style="display:none;">
                                <div class="info-box success">
                                    <i class='bx bx-send'></i>
                                    ستصل الرسالة للطالب وولي أمره: <strong id="parentNameText"></strong>
                                </div>
                            </div>
                            <div id="noParentWarn" style="display:none;">
                                <div class="info-box danger">
                                    <i class='bx bx-error-circle'></i>
                                    لا يوجد ولي أمر مرتبط بهذا الطالب
                                </div>
                            </div>
                        </div>

                        {{-- ── ولي أمر مباشرة ── --}}
                        <div class="sub-panel" id="panel-parent">
                            <div class="step-label"><span class="step-badge">2</span> اختر ولي الأمر</div>
                            <div class="form-group">
                                <select name="parent_id" id="parentSel" disabled>
                                    <option value="">-- اختر ولي الأمر --</option>
                                    @foreach($studentsData->where('has_parent', true)->unique('parent_name') as $s)
                                    {{-- سنعبأ هذا من JS --}}
                                    @endforeach
                                </select>
                            </div>
                            <div style="background:rgba(124,58,237,0.06); border:1px solid rgba(124,58,237,0.15);
                                        border-radius:var(--radius-sm); padding:.85rem 1rem;
                                        font-size:.82rem; color:var(--text-muted); display:flex; gap:.5rem; margin-top:.5rem;">
                                <i class='bx bx-info-circle' style="color:var(--accent); font-size:1rem; flex-shrink:0;"></i>
                                الرسالة ستصل لولي الأمر مباشرة في حسابه.
                            </div>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-primary"
                        style="width:100%; margin-top:16px; height:50px; font-size:16px;">
                    <i class='bx bx-paper-plane'></i> إرسال الرسالة
                </button>
            </div>

        </form>
    </div>
</div>

<script>
const CLASSES      = @json($classes);
const STUDENTS     = @json($studentsData);
let currentTarget  = 'student';

// جمع أولياء الأمور الفريدين
const parentsMap = {};
STUDENTS.filter(s => s.has_parent && s.parent_name).forEach(s => {
    if (!parentsMap[s.parent_name]) parentsMap[s.parent_name] = s;
});

function switchTarget(type) {
    currentTarget = type;
    document.getElementById('targetType').value = type;

    document.getElementById('btn-student').classList.toggle('active', type === 'student');
    document.getElementById('btn-parent').classList.toggle('active',  type === 'parent');
    document.getElementById('panel-student').classList.toggle('active', type === 'student');
    document.getElementById('panel-parent').classList.toggle('active',  type === 'parent');

    // تفعيل/تعطيل الحقول
    document.getElementById('parentSel').disabled  = type !== 'parent';
    document.getElementById('studentSel').disabled = true;

    if (type === 'parent') fillParentSel();
}

function fillParentSel() {
    const sel = document.getElementById('parentSel');
    sel.innerHTML = '<option value="">-- اختر ولي الأمر --</option>';
    Object.values(parentsMap).forEach(s => {
        sel.innerHTML += `<option value="${s.student_id}">${s.parent_name}</option>`;
    });
    sel.disabled = false;
}

function onClassName() {
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

    if (secSel.options.length === 2) { secSel.selectedIndex = 1; onSection(); }
}

function onSection() {
    const classId = document.getElementById('sectionSel').value;
    fillStudents(classId);
}

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

function showParentPreview() {
    const sel       = document.getElementById('studentSel');
    const opt       = sel.options[sel.selectedIndex];
    const hasParent = opt?.dataset?.hasParent === '1';
    const name      = opt?.dataset?.parentName ?? '';
    document.getElementById('parentPreview').style.display = (sel.value && hasParent)  ? 'block' : 'none';
    document.getElementById('noParentWarn').style.display  = (sel.value && !hasParent) ? 'block' : 'none';
    if (hasParent) document.getElementById('parentNameText').textContent = name;
}

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
</script>

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>