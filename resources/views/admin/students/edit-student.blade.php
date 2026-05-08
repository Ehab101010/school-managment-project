<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات الطلاب</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">تعديل طالب</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-edit'></i> تعديل بيانات الطالب</h1>
                <p>تحديث المعلومات الشخصية للطالب</p>
            </div>
<div class="hero-icon-wrap"><i class='bx bxs-graduation'></i></div>
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
            <form action="{{ route('admin.edit-student') }}" method="GET">
                <div class="search-box">
                    <input type="text" name="query" placeholder="البحث باسم الطالب" value="{{ request('query') }}">
                    <button type="submit"><i class='bx bx-search'></i> بحث</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>رقم الطالب</th>
                        <th>الاسم الكامل</th>
                        <th>اسم الأم</th>
                        <th>تاريخ الميلاد</th>
                        <th>الجنس</th>
                        <th>الجنسية</th>
                        <th>رقم الطالب</th>
                        <th>رقم الأب</th>
                        <th>رقم الأم</th>
                        <th>الملاحظات</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td><div class="tea-name-cell"><div class="tea-avatar">{{ mb_substr($student->full_name,0,1) }}</div><span class="tea-name">{{ $student->full_name }}</span></div></td>
                        <td>{{ $student->mother_name }}</td>
                        <td>{{ $student->birth_date }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->nationality }}</td>
                        <td>{{ $student->student_phone_number }}</td>
                        <td>{{ $student->father_phone_number }}</td>
                        <td>{{ $student->mother_phone_number }}</td>
                        <td>{{ $student->notes ?? '-' }}</td>
                        <td>
                            <div class="table-actions">
                                <button class="btn-edit" onclick="openEditModal({{ $student->student_id }})">
                                    <i class='bx bx-edit'></i> تعديل
                                </button>
                                <form action="{{ route('admin.delete-student', $student->student_id) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">
                                        <i class='bx bx-trash'></i> حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($students->hasPages())
        <div class="pagination-container">
            <ul class="pagination">
                <li class="{{ $students->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $students->previousPageUrl() ?? '#' }}">السابق</a>
                </li>
                @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                    <li class="{{ $page == $students->currentPage() ? 'active' : '' }}">
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="{{ $students->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $students->nextPageUrl() ?? '#' }}">التالي</a>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>

{{-- Modal التعديل --}}
<div id="editModal" class="modal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title"><i class='bx bx-edit'></i> تعديل بيانات الطالب</div>
            <button class="modal-close" onclick="closeModal()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-form-grid">
                    <div class="sf">
                        <label>الاسم الكامل</label>
                        <div class="sf-input-wrap"><i class='bx bx-user'></i><input type="text" name="full_name" id="full_name"></div>
                    </div>
                    <div class="sf">
                        <label>اسم الأم</label>
                        <div class="sf-input-wrap"><i class='bx bx-user'></i><input type="text" name="mother_name" id="mother_name"></div>
                    </div>
                    <div class="sf">
                        <label>تاريخ الميلاد</label>
                        <div class="sf-input-wrap"><input type="date" name="birth_date" id="birth_date"></div>
                    </div>
                    <div class="sf">
                        <label>الجنس</label>
                        <div class="sf-input-wrap"><i class='bx bx-male-female'></i>
                            <select name="gender" id="gender">
                                <option value="ذكر">ذكر</option>
                                <option value="أنثى">أنثى</option>
                            </select>
                        </div>
                    </div>
                    <div class="sf">
                        <label>الجنسية</label>
                        <div class="sf-input-wrap"><i class='bx bx-flag'></i><input type="text" name="nationality" id="nationality"></div>
                    </div>
                    <div class="sf">
                        <label>رقم الطالب</label>
                        <div class="sf-input-wrap"><i class='bx bx-phone'></i><input type="text" name="student_phone_number" id="student_phone_number"></div>
                    </div>
                    <div class="sf">
                        <label>رقم الأب</label>
                        <div class="sf-input-wrap"><i class='bx bx-phone'></i><input type="text" name="father_phone_number" id="father_phone_number"></div>
                    </div>
                    <div class="sf">
                        <label>رقم الأم</label>
                        <div class="sf-input-wrap"><i class='bx bx-phone'></i><input type="text" name="mother_phone_number" id="mother_phone_number"></div>
                    </div>
                    <div class="sf" style="grid-column:1/-1;">
                        <label>ملاحظات</label>
                        <div class="sf-input-wrap"><textarea name="notes" id="notes" rows="3"></textarea></div>
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

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
