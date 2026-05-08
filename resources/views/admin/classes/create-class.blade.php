{{-- resources/views/admin/classes/create-class.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء صف دراسي</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

{{-- Mobile sidebar overlay & toggle --}}
@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">إضافة صف</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>
<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-buildings'></i> إنشاء صف دراسي جديد</h1>
                <p>أضف صفاً دراسياً جديداً وحدد نوع الشعبة</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-book-open'></i></div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success fade-in"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert-danger fade-in">
        <i class='bx bx-error-circle'></i>
        <ul style="margin:0;padding-right:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('admin.store-class') }}" method="POST">
        @csrf
        <div class="form-shell fade-in">

            <div>
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-buildings'></i></div>
                        <span class="section-title">بيانات الصف</span>
                    </div>
                    <div class="section-body">
                        <div class="sf">
                            <label>اسم الصف <span class="req">*</span></label>
                            <div class="sf-input-wrap"><i class='bx bx-buildings'></i><input type="text" name="class_name" placeholder="مثال: الصف الأول" required value="{{ old('class_name') }}"></div>
                        </div>
                        <div class="sf">
                            <label>اسم الشعبة <span class="req">*</span></label>
                            <div class="sf-input-wrap"><i class='bx bx-group'></i><input type="text" name="section_name" placeholder="مثال: الشعبة الأولى" required value="{{ old('section_name') }}"></div>
                        </div>
                        <div class="sf">
                            <label>نوع القسم <span class="req">*</span></label>
                            <div class="sf-input-wrap"><i class='bx bx-category'></i>
                                <select name="section_type" required>
                                    <option value="">— اختر النوع —</option>
                                    <option value="علمي" {{ old('section_type')=='علمي' ?'selected':'' }}>علمي</option>
                                    <option value="أدبي" {{ old('section_type')=='أدبي' ?'selected':'' }}>أدبي</option>
                                </select>
                            </div>
                        </div>
                        <div class="sf">
                            <label>العدد المتوقع للطلاب</label>
                            <div class="sf-input-wrap"><i class='bx bx-user-plus'></i><input type="number" name="expected_students" min="0" placeholder="مثال: 30" value="{{ old('expected_students') }}"></div>
                        </div>
                        <div class="sf">
                            <label>السنة الدراسية</label>
                            <div class="sf-input-wrap"><i class='bx bx-calendar'></i><input type="text" name="academic_year" placeholder="مثال: 2025-2026" value="{{ old('academic_year') }}"></div>
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-note'></i></div>
                        <span class="section-title">ملاحظات إضافية</span>
                    </div>
                    <div class="section-body cols-1">
                        <div class="sf">
                            <div class="sf-input-wrap"><textarea name="notes" rows="3" placeholder="أي ملاحظات خاصة بهذا الصف...">{{ old('notes') }}</textarea></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="side-panel">
                <div class="submit-card">
                    <div class="submit-card-header hdr-teal"><i class='bx bx-check-shield'></i> تأكيد الإنشاء</div>
                    <div class="submit-card-body">
                        <div class="info-box teal"><i class='bx bx-info-circle'></i> بعد الإنشاء يمكنك تعيين معلمين وإضافة طلاب لهذا الصف.</div>
                        <button type="submit" class="btn-add teal"><i class='bx bx-plus'></i> إنشاء الصف</button>
                        <button type="reset"  class="btn-reset"><i class='bx bx-x'></i> مسح البيانات</button>
                    </div>
                </div>
                <div class="section-card">
                    <div class="section-header"><div class="section-header-icon teal"><i class='bx bx-list-check'></i></div><span class="section-title">تذكير</span></div>
                    <div class="section-body cols-1" style="padding:1rem 1.3rem;gap:.6rem;">
                        @foreach(['اسم الصف والشعبة مطلوبان','حدد نوع القسم بدقة','السنة الدراسية تساعد في التنظيم'] as $tip)
                        <div style="display:flex;align-items:center;gap:.5rem;font-size:.8rem;color:var(--text-muted);">
                            <i class='bx bx-check-circle' style="color:var(--teal-bright);font-size:.95rem;flex-shrink:0;"></i> {{ $tip }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>