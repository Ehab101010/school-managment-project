<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء محتوى تعليمي</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   
</head>
<body>

@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-primary fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-book-add'></i> نشر محتوى تعليمي</h1>
                <p>إضافة ملفات ومحتوى تعليمي جديد لطلابك</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bxs-book-add'></i></div>
        </div>
    </div>

    {{-- ─── Alerts ─── --}}
    @if ($errors->any())
    <div class="alert alert-danger fade-in">
        <i class='bx bx-error-circle' style="font-size:20px;"></i>
        <ul style="margin:0;padding-right:16px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success fade-in">
        <i class='bx bx-check-circle' style="font-size:20px;"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ─── Form Card ─── --}}
    <div class="form-card fade-in">
        <div class="form-card-header">
            <i class='bx bx-cloud-upload'></i>
            <h2>بيانات المحتوى الجديد</h2>
        </div>

        <div class="form-card-body">
            <form action="{{ route('teacher.storeContent') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="create-form">

                    {{-- ── المادة الدراسية ── --}}
                    <div class="form-group">
                        <label><i class='bx bx-book' style="color:var(--accent);"></i> المادة الدراسية</label>
                        <select name="subject_id" required>
                            <option value="">-- اختر المادة --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->subject_id }}"
                                    {{ old('subject_id') == $subject->subject_id ? 'selected' : '' }}>
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ── الصف الدراسي ── --}}
                    <div class="form-group">
                        <label><i class='bx bx-buildings' style="color:var(--accent);"></i> الصف الدراسي</label>
                        <select name="class_id" required>
                            <option value="">-- اختر الصف --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_id }}"
                                    {{ old('class_id') == $class->class_id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                    @isset($class->section_name)
                                        - {{ $class->section_name }}
                                        @isset($class->section_type)({{ $class->section_type }})@endisset
                                    @endisset
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ── عنوان المحتوى ── --}}
                    <div class="form-group full">
                        <label><i class='bx bx-heading' style="color:var(--accent);"></i> عنوان المحتوى</label>
                        <input type="text" name="title" required
                               value="{{ old('title') }}"
                               placeholder="مثال: شرح العمليات الحسابية الأساسية">
                    </div>

                    {{-- ── وصف المحتوى ── --}}
                    <div class="form-group full">
                        <label><i class='bx bx-text' style="color:var(--accent);"></i> وصف المحتوى</label>
                        <textarea name="description" required
                                  placeholder="اكتب وصفاً مختصراً للمحتوى...">{{ old('description') }}</textarea>
                    </div>

                    {{-- ── نوع المحتوى – بطاقات ── --}}
                    <div class="form-group full">
                        <label><i class='bx bx-category' style="color:var(--accent);"></i> نوع المحتوى</label>
                        <div class="type-cards" id="type-cards">

                            <label class="type-card {{ old('content_type') === 'link' ? 'selected' : '' }}">
                                <input type="radio" name="content_type" value="link"
                                    {{ old('content_type') === 'link' ? 'checked' : '' }} required>
                                <div class="tc-icon">🔗</div>
                                <div class="tc-label">رابط خارجي</div>
                            </label>

                            <label class="type-card {{ old('content_type') === 'pdf' ? 'selected' : '' }}">
                                <input type="radio" name="content_type" value="pdf"
                                    {{ old('content_type') === 'pdf' ? 'checked' : '' }}>
                                <div class="tc-icon">📄</div>
                                <div class="tc-label">ملف PDF</div>
                            </label>

                            <label class="type-card {{ old('content_type') === 'excel' ? 'selected' : '' }}">
                                <input type="radio" name="content_type" value="excel"
                                    {{ old('content_type') === 'excel' ? 'checked' : '' }}>
                                <div class="tc-icon">📊</div>
                                <div class="tc-label">ملف Excel</div>
                            </label>

                            <label class="type-card {{ old('content_type') === 'powerpoint' ? 'selected' : '' }}">
                                <input type="radio" name="content_type" value="powerpoint"
                                    {{ old('content_type') === 'powerpoint' ? 'checked' : '' }}>
                                <div class="tc-icon">📑</div>
                                <div class="tc-label">PowerPoint</div>
                            </label>

                        </div>
                    </div>

                    {{-- ── حقل الرابط الخارجي ── --}}
                    <div class="form-group full upload-panel" id="panel-link">
                        <label><i class='bx bx-link-external' style="color:var(--accent);"></i> رابط خارجي</label>
                        <input type="url" name="external_link"
                               value="{{ old('external_link') }}"
                               placeholder="https://www.youtube.com/watch?v=...">
                        <small style="color:#6b7280;margin-top:4px;display:block;">
                            يمكن أن يكون رابط يوتيوب أو أي موقع تعليمي آخر.
                        </small>
                    </div>

                    {{-- ── رفع PDF ── --}}
                    <div class="form-group full upload-panel" id="panel-pdf">
                        <label><i class='bx bx-upload' style="color:var(--accent);"></i> رفع ملف PDF</label>
                        <div class="upload-zone" id="zone-pdf">
                            <input type="file" name="pdf_file" accept=".pdf" id="file-pdf">
                            <i class='bx bxs-file-pdf uz-icon' style="color:#e53e3e;"></i>
                            <div class="uz-label">اسحب الملف هنا أو انقر للاختيار</div>
                            <div class="uz-hint">PDF فقط – الحد الأقصى 20 ميغابايت</div>
                            <div class="uz-filename" id="fname-pdf"></div>
                        </div>
                    </div>

                    {{-- ── رفع Excel ── --}}
                    <div class="form-group full upload-panel" id="panel-excel">
                        <label><i class='bx bx-upload' style="color:var(--accent);"></i> رفع ملف Excel</label>
                        <div class="upload-zone" id="zone-excel">
                            <input type="file" name="excel_file" accept=".xls,.xlsx" id="file-excel">
                            <i class='bx bxs-spreadsheet uz-icon' style="color:#21a366;"></i>
                            <div class="uz-label">اسحب الملف هنا أو انقر للاختيار</div>
                            <div class="uz-hint">XLS / XLSX فقط – الحد الأقصى 20 ميغابايت</div>
                            <div class="uz-filename" id="fname-excel"></div>
                        </div>
                    </div>

                    {{-- ── رفع PowerPoint ── --}}
                    <div class="form-group full upload-panel" id="panel-powerpoint">
                        <label><i class='bx bx-upload' style="color:var(--accent);"></i> رفع ملف PowerPoint</label>
                        <div class="upload-zone" id="zone-ppt">
                            <input type="file" name="powerpoint_file" accept=".ppt,.pptx" id="file-ppt">
                            <i class='bx bxs-slideshow uz-icon' style="color:#d24726;"></i>
                            <div class="uz-label">اسحب الملف هنا أو انقر للاختيار</div>
                            <div class="uz-hint">PPT / PPTX فقط – الحد الأقصى 50 ميغابايت</div>
                            <div class="uz-filename" id="fname-ppt"></div>
                        </div>
                    </div>

                </div>{{-- /create-form --}}

                {{-- ── أزرار ── --}}
                <div style="margin-top:24px; display:flex; gap:12px; flex-wrap:wrap;">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-cloud-upload'></i> نشر المحتوى
                    </button>
                    <a href="{{ route('teacher.view-content') }}" class="btn btn-cancel">
                        <i class='bx bx-x'></i> إلغاء
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>{{-- /content --}}

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>