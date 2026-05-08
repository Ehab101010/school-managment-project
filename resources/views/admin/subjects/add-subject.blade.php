{{-- resources/views/admin/subjects/add-subject.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مادة دراسية</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

{{-- Mobile sidebar overlay & toggle --}}
@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">إضافة مادة</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>
<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-book-add'></i> إضافة مادة دراسية</h1>
                <p>أضف مادة جديدة لتعيينها للمعلمين والصفوف</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-book'></i></div>
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

    <form method="POST" action="{{ route('admin.store-subject') }}">
        @csrf
        <div class="form-shell fade-in">

            <div>
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-book'></i></div>
                        <span class="section-title">بيانات المادة</span>
                    </div>
                    <div class="section-body">
                        <div class="sf">
                            <label>اسم المادة <span class="req">*</span></label>
                            <div class="sf-input-wrap"><i class='bx bx-book'></i><input type="text" name="subject_name" placeholder="مثال: الرياضيات" required value="{{ old('subject_name') }}"></div>
                        </div>
                        <div class="sf">
                            <label>وصف المادة</label>
                            <div class="sf-input-wrap"><textarea name="description" rows="5" placeholder="وصف مختصر عن المادة الدراسية...">{{ old('description') }}</textarea></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="side-panel">
                <div class="submit-card">
                    <div class="submit-card-header hdr-teal"><i class='bx bx-check-shield'></i> تأكيد الإضافة</div>
                    <div class="submit-card-body">
                        <div class="info-box teal"><i class='bx bx-info-circle'></i> بعد الإضافة يمكن تعيين المادة لمعلمين وصفوف محددة.</div>
                        <button type="submit" class="btn-add teal"><i class='bx bx-save'></i> حفظ المادة</button>
                        <button type="reset"  class="btn-reset"><i class='bx bx-x'></i> مسح البيانات</button>
                    </div>
                </div>
                <div class="section-card">
                    <div class="section-header"><div class="section-header-icon teal"><i class='bx bx-list-check'></i></div><span class="section-title">تذكير</span></div>
                    <div class="section-body" style="padding:1rem 1.3rem;gap:.6rem;grid-template-columns:1fr;">
                        @foreach(['اسم المادة مطلوب','الوصف يساعد المعلمين','يمكن تعديلها لاحقاً'] as $tip)
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