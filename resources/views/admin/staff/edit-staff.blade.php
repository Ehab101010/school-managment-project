<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات موظفي شؤون الطلاب</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">تعديل موظف</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-edit'></i> تعديل بيانات الموظف</h1>
                <p>تحديث المعلومات الشخصية لموظفي شؤون الطلاب</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bx-id-card'></i></div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success fade-in"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-danger fade-in"><i class='bx bx-error-circle'></i> {{ session('error') }}</div>
    @endif

    <div class="card fade-in">
        <div class="toolbar">
            <form method="GET" action="{{ route('admin.edit-staff') }}">
                <div class="search-box">
                    <input type="text" name="search" placeholder="البحث باسم الموظف" value="{{ request('search') }}">
                    <button type="submit"><i class='bx bx-search'></i> بحث</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th><th>الاسم الكامل</th><th>تاريخ الميلاد</th>
                        <th>الجنس</th><th>الجنسية</th><th>السكن</th>
                        <th>الهاتف</th><th>البريد</th><th>ملاحظات</th><th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><div class="tea-name-cell"><div class="tea-avatar">{{ mb_substr($member->full_name,0,1) }}</div><span class="tea-name">{{ $member->full_name }}</span></div></td>
                        <td>{{ $member->birth_date ?? '-' }}</td>
                        <td>{{ $member->gender }}</td>
                        <td>{{ $member->nationality ?? '-' }}</td>
                        <td>{{ $member->address ?? '-' }}</td>
                        <td>{{ $member->phone ?? '-' }}</td>
                        <td>{{ $member->email ?? '-' }}</td>
                        <td>{{ $member->notes ?? '-' }}</td>
                        <td>
                            <div class="table-actions">
                                <button class="btn-edit" onclick="openStaffModal({{ $member->id }})">
                                    <i class='bx bx-edit'></i> تعديل
                                </button>
                                <form action="{{ route('admin.delete-staff', $member->id) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">
                                        <i class='bx bx-trash'></i> حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" style="text-align:center;color:var(--text-3);padding:2rem;">لا توجد بيانات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($staff->hasPages())
        <div class="pagination-container">
            <ul class="pagination">
                <li class="{{ $staff->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $staff->previousPageUrl() ?? '#' }}">السابق</a>
                </li>
                @foreach ($staff->getUrlRange(1, $staff->lastPage()) as $page => $url)
                    <li class="{{ $page == $staff->currentPage() ? 'active' : '' }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="{{ $staff->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $staff->nextPageUrl() ?? '#' }}">التالي</a>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>

{{-- Modal التعديل --}}
<div id="staffModal" class="modal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title"><i class='bx bx-edit'></i> تعديل بيانات الموظف</div>
            <button class="modal-close" onclick="closeStaffModal()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <form id="staffForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-form-grid">
                    <div class="sf">
                        <label>الاسم الكامل</label>
                        <div class="sf-input-wrap"><i class='bx bx-user'></i><input type="text" name="full_name" id="s_full_name"></div>
                    </div>
                    <div class="sf">
                        <label>تاريخ الميلاد</label>
                        <div class="sf-input-wrap"><input type="date" name="birth_date" id="s_birth_date"></div>
                    </div>
                    <div class="sf">
                        <label>الجنس</label>
                        <div class="sf-input-wrap"><i class='bx bx-male-female'></i>
                            <select name="gender" id="s_gender">
                                <option value="ذكر">ذكر</option><option value="أنثى">أنثى</option>
                            </select>
                        </div>
                    </div>
                    <div class="sf">
                        <label>الجنسية</label>
                        <div class="sf-input-wrap"><i class='bx bx-flag'></i><input type="text" name="nationality" id="s_nationality"></div>
                    </div>
                    <div class="sf">
                        <label>السكن</label>
                        <div class="sf-input-wrap"><i class='bx bx-map'></i><input type="text" name="address" id="s_address"></div>
                    </div>
                    <div class="sf">
                        <label>الهاتف</label>
                        <div class="sf-input-wrap"><i class='bx bx-phone'></i><input type="text" name="phone" id="s_phone"></div>
                    </div>
                    <div class="sf">
                        <label>البريد الإلكتروني</label>
                        <div class="sf-input-wrap"><i class='bx bx-envelope'></i><input type="email" name="email" id="s_email"></div>
                    </div>
                    <div class="sf" style="grid-column:1/-1;">
                        <label>ملاحظات</label>
                        <div class="sf-input-wrap"><textarea name="notes" id="s_notes" rows="3"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top:1rem;padding:0;">
                    <button type="button" class="btn-reset" onclick="closeStaffModal()"><i class='bx bx-x'></i> إلغاء</button>
                    <button type="submit" class="btn-add teal"><i class='bx bx-save'></i> حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
