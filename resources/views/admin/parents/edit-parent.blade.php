<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات أولياء الأمور</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">تعديل ولي أمر</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-edit'></i> تعديل بيانات ولي الأمر</h1>
                <p>تحديث المعلومات الشخصية لولي الأمر</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bxs-group'></i></div>
        </div>
    </div>

    @if(session('success'))<div class="alert-success fade-in"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert-danger fade-in"><i class='bx bx-error-circle'></i> {{ session('error') }}</div>@endif

    <div class="card fade-in">
        <div class="toolbar">
            <form action="{{ route('admin.edit-parent') }}" method="GET">
                <div class="search-box">
                    <input type="text" name="query" placeholder="البحث باسم ولي الأمر" value="{{ request('query') }}">
                    <button type="submit"><i class='bx bx-search'></i> بحث</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>الاسم الكامل</th><th>تاريخ الميلاد</th><th>الجنس</th>
                        <th>رقم الجوال</th><th>هاتف إضافي</th><th>هاتف المنزل</th>
                        <th>العنوان</th><th>الوظيفة</th><th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parents as $parent)
                    <tr>
                        <td><div class="tea-name-cell"><div class="tea-avatar">{{ mb_substr($parent->full_name,0,1) }}</div><span class="tea-name">{{ $parent->full_name }}</span></div></td>
                        <td>{{ $parent->birth_date }}</td>
                        <td>{{ $parent->gender ?? '—' }}</td>
                        <td>{{ $parent->phone_mobile }}</td>
                        <td>{{ $parent->additional_phone_number ?? '—' }}</td>
                        <td>{{ $parent->phone_home ?? '—' }}</td>
                        <td>{{ $parent->address ?? '—' }}</td>
                        <td>{{ $parent->job ?? '—' }}</td>
                        <td>
                            <div class="table-actions">
                                <button class="btn-edit" data-id="{{ $parent->id }}"><i class='bx bx-edit'></i> تعديل</button>
                                <form action="{{ route('admin.delete-parent', $parent->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد؟')"><i class='bx bx-trash'></i> حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" style="text-align:center;color:var(--text-3);padding:2rem;">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($parents->hasPages())
        <div class="pagination-container">
            <ul class="pagination">
                <li class="{{ $parents->onFirstPage() ? 'disabled' : '' }}"><a href="{{ $parents->previousPageUrl() ?? '#' }}">السابق</a></li>
                @foreach($parents->getUrlRange(1, $parents->lastPage()) as $page => $url)
                    <li class="{{ $page == $parents->currentPage() ? 'active' : '' }}"><a href="{{ $url }}">{{ $page }}</a></li>
                @endforeach
                <li class="{{ $parents->hasMorePages() ? '' : 'disabled' }}"><a href="{{ $parents->nextPageUrl() ?? '#' }}">التالي</a></li>
            </ul>
        </div>
        @endif
    </div>
</div>

{{-- Modal التعديل --}}
<div id="editModal" class="modal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title"><i class='bx bx-edit'></i> تعديل بيانات ولي الأمر</div>
            <button class="modal-close" onclick="closeModal()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-form-grid">
                    <div class="sf">
                        <label>الاسم الكامل</label>
                        <div class="sf-input-wrap"><i class='bx bx-user'></i><input type="text" name="full_name" id="full_name"></div>
                    </div>
                    <div class="sf">
                        <label>تاريخ الميلاد</label>
                        <div class="sf-input-wrap"><input type="date" name="birth_date" id="birth_date"></div>
                    </div>
                    <div class="sf">
                        <label>الجنس</label>
                        <div class="sf-input-wrap"><i class='bx bx-male-female'></i>
                            <select name="gender" id="gender"><option value="ذكر">ذكر</option><option value="أنثى">أنثى</option></select>
                        </div>
                    </div>
                    <div class="sf">
                        <label>رقم الجوال</label>
                        <div class="sf-input-wrap"><i class='bx bx-phone'></i><input type="text" name="phone_mobile" id="phone_mobile"></div>
                    </div>
                    <div class="sf">
                        <label>هاتف إضافي</label>
                        <div class="sf-input-wrap"><i class='bx bx-phone-call'></i><input type="text" name="additional_phone_number" id="additional_phone_number"></div>
                    </div>
                    <div class="sf">
                        <label>هاتف المنزل</label>
                        <div class="sf-input-wrap"><i class='bx bx-phone-call'></i><input type="text" name="phone_home" id="phone_home"></div>
                    </div>
                    <div class="sf">
                        <label>العنوان</label>
                        <div class="sf-input-wrap"><i class='bx bx-map'></i><input type="text" name="address" id="address"></div>
                    </div>
                    <div class="sf">
                        <label>الوظيفة</label>
                        <div class="sf-input-wrap"><i class='bx bx-briefcase'></i><input type="text" name="job" id="job"></div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top:1rem;padding:0;">
                    <button type="button" class="btn-reset" onclick="closeModal()"><i class='bx bx-x'></i> إلغاء</button>
                    <button type="submit" class="btn-add teal"><i class='bx bx-save'></i> حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>
