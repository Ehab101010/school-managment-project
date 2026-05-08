{{-- resources/views/admin/parents/add-parent.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة ولي أمر جديد</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

{{-- Mobile sidebar overlay & toggle --}}
@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">إضافة ولي أمر</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>
<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-user-plus'></i> إضافة ولي أمر جديد</h1>
                <p>أدخل بيانات ولي الأمر وسيتم إنشاء حسابه تلقائياً</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-group'></i></div>
        </div>
    </div>

    @if(session('username') && session('password'))
    <div class="creds-card fade-in">
        <h3><i class='bx bx-check-circle'></i> تم إنشاء حساب ولي الأمر بنجاح</h3>
        <div class="cred-row"><strong>اسم المستخدم:</strong><span class="cred-val">{{ session('username') }}</span></div>
        <div class="cred-row"><strong>كلمة المرور:</strong><span class="cred-val">{{ session('password') }}</span></div>
    </div>
    @endif

    @if($errors->any())
    <div class="alert-danger fade-in">
        <i class='bx bx-error-circle'></i>
        <ul style="margin:0;padding-right:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.store-parent') }}">
        @csrf
        <div class="form-shell fade-in">

            <div>
                {{-- البيانات الشخصية --}}
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-user'></i></div>
                        <span class="section-title">البيانات الشخصية</span>
                    </div>
                    <div class="section-body">
                        <div class="sf">
                            <label>الاسم الكامل <span class="req">*</span></label>
                            <div class="sf-input-wrap"><i class='bx bx-user'></i><input type="text" name="full_name" placeholder="أدخل الاسم الكامل" value="{{ old('full_name') }}" required></div>
                        </div>
                        <div class="sf">
                            <label>تاريخ الميلاد</label>
                            <div class="sf-input-wrap"><input type="date" name="birth_date" value="{{ old('birth_date') }}"></div>
                        </div>
                        <div class="sf">
                            <label>الجنس</label>
                            <div class="sf-input-wrap"><i class='bx bx-male-female'></i>
                                <select name="gender">
                                    <option value="">— اختر —</option>
                                    <option value="ذكر"  {{ old('gender')=='ذكر'  ?'selected':'' }}>ذكر</option>
                                    <option value="أنثى" {{ old('gender')=='أنثى' ?'selected':'' }}>أنثى</option>
                                </select>
                            </div>
                        </div>
                        <div class="sf">
                            <label>الوظيفة</label>
                            <div class="sf-input-wrap"><i class='bx bx-briefcase'></i><input type="text" name="job" placeholder="مثال: مهندس" value="{{ old('job') }}"></div>
                        </div>
                        <div class="sf">
                            <label>العنوان</label>
                            <div class="sf-input-wrap"><i class='bx bx-map'></i><input type="text" name="address" placeholder="مثال: دمشق - المزة" value="{{ old('address') }}"></div>
                        </div>
                    </div>
                </div>

                {{-- أرقام التواصل --}}
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-phone'></i></div>
                        <span class="section-title">أرقام التواصل</span>
                    </div>
                    <div class="section-body cols-3">
                        <div class="sf">
                            <label>رقم الجوال</label>
                            <div class="sf-input-wrap"><i class='bx bx-phone'></i><input type="tel" name="phone_mobile" placeholder="05xxxxxxxx" value="{{ old('phone_mobile') }}"></div>
                        </div>
                        <div class="sf">
                            <label>هاتف المنزل</label>
                            <div class="sf-input-wrap"><i class='bx bx-phone-call'></i><input type="tel" name="phone_home" placeholder="011xxxxxxx" value="{{ old('phone_home') }}"></div>
                        </div>
                        <div class="sf">
                            <label>رقم إضافي</label>
                            <div class="sf-input-wrap"><i class='bx bx-phone-call'></i><input type="tel" name="additional_phone_number" placeholder="05xxxxxxxx" value="{{ old('additional_phone_number') }}"></div>
                        </div>
                    </div>
                </div>

                {{-- ملاحظات --}}
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-header-icon teal"><i class='bx bx-note'></i></div>
                        <span class="section-title">ملاحظات إضافية</span>
                    </div>
                    <div class="section-body cols-1">
                        <div class="sf">
                            <div class="sf-input-wrap"><textarea name="notes" rows="3" placeholder="أي ملاحظات خاصة بولي الأمر...">{{ old('notes') }}</textarea></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="side-panel">
                <div class="submit-card">
                    <div class="submit-card-header hdr-teal"><i class='bx bx-check-shield'></i> تأكيد الإضافة</div>
                    <div class="submit-card-body">
                        <div class="info-box teal"><i class='bx bx-info-circle'></i> سيتم إنشاء حساب دخول لولي الأمر يمكنه من متابعة أبنائه.</div>
                        <button type="submit" class="btn-add teal"><i class='bx bx-plus'></i> إضافة ولي الأمر</button>
                        <button type="reset"  class="btn-reset"><i class='bx bx-x'></i> مسح البيانات</button>
                    </div>
                </div>
                <div class="section-card">
                    <div class="section-header"><div class="section-header-icon teal"><i class='bx bx-list-check'></i></div><span class="section-title">تذكير</span></div>
                    <div class="section-body cols-1" style="padding:1rem 1.3rem;gap:.6rem;">
                        @foreach(['الاسم الكامل مطلوب','رقم جوال للتواصل','يمكن ربطه بالطلاب لاحقاً'] as $tip)
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