<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعلان جديد</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">إنشاء إعلان</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-megaphone'></i> إعلان جديد</h1>
                <p>أنشئ إعلاناً وحدد الجهة المستهدفة</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bx-bell'></i></div>
        </div>
    </div>

    @if($errors->any())
    <div class="alert-danger fade-in">
        <i class='bx bx-error-circle'></i>
        <ul style="margin:0;padding-right:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.announcements.store') }}">
        @csrf
        <div class="form-shell fade-in">

            {{-- ── المحتوى ── --}}
            <div>
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-edit'></i></div>
                        <span class="section-title">محتوى الإعلان</span>
                    </div>
                    <div class="section-body cols-1">
                        <div class="sf">
                            <label>عنوان الإعلان <span class="req">*</span></label>
                            <div class="sf-input-wrap">
                                <i class='bx bx-heading'></i>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="مثال: إجازة رسمية غداً" required>
                            </div>
                        </div>
                        <div class="sf">
                            <label>نص الإعلان <span class="req">*</span></label>
                            <div class="sf-input-wrap">
                                <textarea name="body" rows="6" required placeholder="اكتب تفاصيل الإعلان هنا...">{{ old('body') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── الإعدادات ── --}}
            <div class="side-panel">
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-target-lock'></i></div>
                        <span class="section-title">الجهة المستهدفة</span>
                    </div>
                    <div class="section-body cols-1" style="padding:1.2rem 1.3rem;gap:.6rem;">
                        @foreach([
                            'all'          => ['bx-globe',       'الجميع'],
                            'all_parents'  => ['bx-group',       'أولياء الأمور'],
                            'all_students' => ['bxs-graduation', 'الطلاب'],
                            'all_teachers' => ['bx-chalkboard',  'المعلمون'],
                            'class'        => ['bx-buildings',   'صف محدد'],
                        ] as $val => $data)
                        <label style="display:flex;align-items:center;gap:.6rem;padding:.6rem .8rem;border-radius:8px;border:1px solid var(--glass-border);cursor:pointer;transition:all .15s;background:var(--glass);">
                            <input type="radio" name="target_type" value="{{ $val }}"
                                   {{ old('target_type','all') === $val ? 'checked' : '' }}
                                   onchange="toggleClassSelector(this)"
                                   style="accent-color:var(--teal-bright);">
                            <i class='bx {{ $data[0] }}' style="color:var(--teal-bright);font-size:1rem;"></i>
                            <span style="font-size:.85rem;font-weight:600;color:var(--text-1);">{{ $data[1] }}</span>
                        </label>
                        @endforeach

                        <div id="class-selector" class="sf" style="display:none;margin-top:.5rem;">
                            <label>اختر الصف</label>
                            <div class="sf-input-wrap">
                                <i class='bx bx-buildings'></i>
                                <select name="target_id">
                                    <option value="">— اختر الصف —</option>
                                    @foreach($classes as $cls)
                                    <option value="{{ $cls->class_id }}" {{ old('target_id') == $cls->class_id ? 'selected' : '' }}>
                                        {{ $cls->class_name }} - {{ $cls->section_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="submit-card">
                    <div class="submit-card-header hdr-teal"><i class='bx bx-send'></i> نشر الإعلان</div>
                    <div class="submit-card-body">
                        <div class="info-box teal"><i class='bx bx-info-circle'></i> سيظهر الإعلان للجهة المستهدفة فور النشر.</div>
                        <button type="submit" class="btn-add teal"><i class='bx bx-send'></i> نشر الإعلان</button>
                    </div>
                </div>
            </div>

        </div>
    </form>

</div>

<script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>