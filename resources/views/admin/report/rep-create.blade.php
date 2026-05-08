{{-- resources/views/admin/report/rep-create.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">إنشاء تقرير</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-envelope'></i> إرسال رسالة جديدة</h1>
                <p>أرسل رسالة أو تقريراً إلى معلم أو ولي أمر</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bx-envelope'></i></div>
        </div>
    </div>

    @if($errors->any())
    <div class="alert-danger fade-in">
        <i class='bx bx-error-circle'></i>
        <ul style="margin:0;padding-right:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.reports.store') }}" method="POST">
        @csrf
        <div class="form-shell fade-in">

            {{-- ══ المحتوى ══ --}}
            <div>
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-edit-alt'></i></div>
                        <span class="section-title">محتوى الرسالة</span>
                    </div>
                    <div class="section-body cols-1">

                        <div class="sf">
                            <label>عنوان الرسالة <span class="req">*</span></label>
                            <div class="sf-input-wrap">
                                <i class='bx bx-heading'></i>
                                <input type="text" name="title"
                                    placeholder="مثال: متابعة أداء الطالب – الفصل الأول"
                                    required value="{{ old('title') }}">
                            </div>
                        </div>

                        <div class="sf">
                            <label>نوع الرسالة <span class="req">*</span></label>
                            <div class="sf-input-wrap">
                                <i class='bx bx-tag'></i>
                                <select name="report_type" required>
                                    <option value="performance" {{ old('report_type','performance')=='performance'?'selected':'' }}>📊 أداء أكاديمي</option>
                                    <option value="behavior"    {{ old('report_type')=='behavior'   ?'selected':'' }}>🧠 سلوك</option>
                                    <option value="attendance"  {{ old('report_type')=='attendance' ?'selected':'' }}>📅 حضور وغياب</option>
                                    <option value="general"     {{ old('report_type')=='general'    ?'selected':'' }}>✉️ عام</option>
                                </select>
                            </div>
                        </div>

                        <div class="sf">
                            <label>نص الرسالة <span class="req">*</span></label>
                            <div class="sf-input-wrap">
                                <textarea name="content" rows="9"
                                    placeholder="اكتب نص الرسالة هنا..."
                                    required>{{ old('content') }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ══ المستلم ══ --}}
            <div class="side-panel">
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-user-check'></i></div>
                        <span class="section-title">المرسل إليه</span>
                    </div>
                    <div class="section-body cols-1">

                        <div class="sf">
                            <label>إرسال إلى <span class="req">*</span></label>
                            <div class="sf-input-wrap">
                                <i class='bx bx-user'></i>
                                <select name="recipient_type" id="recipientType" required>
                                    <option value="">— اختر نوع المستلم —</option>
                                    <option value="teacher" {{ old('recipient_type')=='teacher'?'selected':'' }}>👨‍🏫 معلم</option>
                                    <option value="parent"  {{ old('recipient_type')=='parent' ?'selected':'' }}>👪 ولي أمر</option>
                                </select>
                            </div>
                        </div>

                        {{-- ── معلم ── --}}
                        <div id="teacherGroup" class="recipient-hidden">
                            <div class="sf">
                                <label>اختر المعلم</label>
                                <div class="sf-input-wrap">
                                    <i class='bx bx-chalkboard'></i>
                                    <select name="recipient_id" id="teacherSel" disabled>
                                        <option value="">— اختر المعلم —</option>
                                        @foreach($teachers as $t)
                                            @if($t->user_id)
                                            <option value="{{ $t->user_id }}" {{ old('recipient_id')==$t->user_id?'selected':'' }}>
                                                {{ $t->full_name }}
                                            </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- ── ولي أمر ── --}}
                        <div id="parentGroup" class="recipient-hidden">
                            <div class="sf">
                                <label><i class='bx bx-buildings' style="color:var(--teal-bright);"></i> اختر الصف والشعبة</label>
                                <div class="sf-input-wrap">
                                    <i class='bx bx-buildings'></i>
                                    <select id="classSel" disabled>
                                        <option value="">— اختر الصف —</option>
                                        @foreach($classes as $cls)
                                        <option value="{{ $cls->class_id }}">
                                            {{ $cls->class_name }} — {{ $cls->section_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div id="parentSelWrap" style="display:none; margin-top:.75rem;">
                                <div class="sf">
                                    <label><i class='bx bx-group' style="color:var(--teal-bright);"></i> اختر ولي الأمر</label>
                                    <div class="sf-input-wrap">
                                        <i class='bx bx-group'></i>
                                        <select name="recipient_id" id="parentSel" disabled>
                                            <option value="">— اختر ولي الأمر —</option>
                                        </select>
                                    </div>
                                    <div id="noParentsMsg" style="display:none; font-size:.78rem; color:var(--accent-red); margin-top:.4rem;">
                                        <i class='bx bx-info-circle'></i> لا يوجد أولياء أمور مرتبطون بهذا الصف
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-box teal">
                            <i class='bx bx-info-circle'></i>
                            ستظهر الرسالة في لوحة المستلم وسيتم تحديث حالتها عند القراءة.
                        </div>

                    </div>
                </div>

                <div class="submit-card">
                    <div class="submit-card-header hdr-teal"><i class='bx bx-paper-plane'></i> إرسال الرسالة</div>
                    <div class="submit-card-body">
                        <button type="submit" class="btn-add teal">
                            <i class='bx bx-paper-plane'></i> إرسال الرسالة الآن
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
window.classParentsData = @json($classParentsJson);
</script>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
