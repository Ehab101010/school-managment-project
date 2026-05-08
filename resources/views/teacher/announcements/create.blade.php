{{-- resources/views/teacher/announcements/create.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعلان جديد</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-announcements fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-megaphone'></i> إعلان جديد</h1>
                <p>إنشاء وإرسال إعلان لطلابك</p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.announcements.index') }}" class="hero-btn hero-btn-ghost">
                    <i class='bx bx-arrow-back'></i> رجوع
                </a>
                <div class="hero-icon-wrap"><i class='bx bxs-megaphone'></i></div>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger fade-in">
        <i class='bx bx-error-circle'></i>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('teacher.announcements.store') }}">
        @csrf
        <div class="compose-grid">

            {{-- المحتوى --}}
            <div class="form-card fade-in">
                <div class="form-card-header" style="background:linear-gradient(135deg,#1a1040,#2563a8);">
                    <i class='bx bx-edit'></i>
                    <h2>محتوى الإعلان</h2>
                </div>
                <div class="form-card-body">
                    <div class="field">
                        <label>عنوان الإعلان *</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="مثال: اجتماع أولياء الأمور" required>
                    </div>
                    <div class="field">
                        <label>نص الإعلان *</label>
                        <textarea name="body" required
                                  placeholder="اكتب تفاصيل الإعلان هنا...">{{ old('body') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- الصف المستهدف --}}
            <div class="form-card fade-in fade-in-delay-1">
                <div class="form-card-header" style="background:linear-gradient(135deg,#1a1040,#7c3aed);">
                    <i class='bx bx-buildings'></i>
                    <h2>الصف المستهدف</h2>
                </div>
                <div class="form-card-body">

                    <div class="field">
                        <label>اختر الصف *</label>
                        <select name="target_id" required>
                            <option value="">-- اختر الصف --</option>
                            @foreach($classes as $cls)
                            <option value="{{ $cls->class_id }}"
                                {{ old('target_id') == $cls->class_id ? 'selected' : '' }}>
                                {{ $cls->class_name }} - {{ $cls->section_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="background:rgba(124,58,237,0.06); border:1px solid rgba(124,58,237,0.15);
                                border-radius:var(--radius-sm); padding:.85rem 1rem;
                                font-size:.82rem; color:var(--text-muted); display:flex; gap:.5rem; align-items:flex-start;">
                        <i class='bx bx-info-circle' style="color:var(--accent); font-size:1rem; flex-shrink:0; margin-top:.05rem;"></i>
                        سيصل الإعلان لجميع طلاب الصف المحدد وأولياء أمورهم.
                    </div>

                    <button type="submit" class="btn-pub" style="margin-top:1.2rem;">
                        <i class='bx bx-send'></i> نشر الإعلان
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>