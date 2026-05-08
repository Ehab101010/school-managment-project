<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>إضافة الدرجات</title>
</head>
<body>

@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1><i class='bx bx-edit-alt'></i> إضافة درجات الطلاب</h1>
            <div class="breadcrumb">
                <span>لوحة التحكم</span>
                <i class='bx bx-chevron-left'></i>
                <span>إضافة الدرجات</span>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="form-card fade-in">
        <div class="form-card-header">
            <i class='bx bx-filter-alt'></i>
            <h2>تصفية البيانات</h2>
        </div>
        <div class="form-card-body">
            <form method="GET" action="{{ route('teacher.add-grades') }}">
                <div class="filter-form" style="background:transparent; border:none; padding:0; margin-bottom:0;">

                    <div class="form-group">
                        <label><i class='bx bx-buildings' style="color:var(--accent);"></i> اختر الصف</label>
                        <select name="class_name" onchange="this.form.submit()">
                            <option value="">-- اختر الصف --</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->class_name }}"
                                    {{ request('class_name') == $c->class_name ? 'selected' : '' }}>
                                    {{ $c->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class='bx bx-group' style="color:var(--accent);"></i> اختر الشعبة</label>
                        <select name="class_id" onchange="this.form.submit()">
                            <option value="">-- اختر الشعبة --</option>
                            @foreach ($sections as $sec)
                                <option value="{{ $sec->class_id }}"
                                    {{ request('class_id') == $sec->class_id ? 'selected' : '' }}>
                                    {{ $sec->section_name }} ({{ $sec->section_type }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if (!empty($subjects))
                    <div class="form-group">
                        <label><i class='bx bx-book' style="color:var(--accent);"></i> اختر المادة</label>
                        <select name="subject_id" onchange="this.form.submit()">
                            <option value="">-- اختر المادة --</option>
                            @foreach ($subjects as $sub)
                                <option value="{{ $sub->subject_id }}"
                                    {{ request('subject_id') == $sub->subject_id ? 'selected' : '' }}>
                                    {{ $sub->subject_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                </div>
            </form>
        </div>
    </div>

    {{-- Grades Table --}}
    @if (!empty($students))
    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-list-ul'></i> قائمة الطلاب — تسجيل الدرجات</span>
            <span style="font-size:13px; color:var(--text-muted);">{{ count($students) }} طالب</span>
        </div>

        <form method="POST" action="{{ route('teacher.store-grades') }}">
            @csrf
            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
            <input type="hidden" name="section_type" value="{{ request('section_type') ?? '' }}">
            <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">

            <div class="table-wrapper">
                <table class="grades-input-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>امتحان أول <small style="opacity:.7;">/15</small></th>
                            <th>امتحان ثاني <small style="opacity:.7;">/15</small></th>
                            <th>نشاط <small style="opacity:.7;">/20</small></th>
                            <th>الامتحان النهائي <small style="opacity:.7;">/50</small></th>
                            <th>المجموع <small style="opacity:.7;">/100</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $st)
                        <tr>
                            <td style="color:var(--text-muted); font-weight:600;">{{ $index + 1 }}</td>
                            <td style="font-weight:600; text-align:right;">{{ $st->full_name }}</td>
                            <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][first]" min="0" max="15" required placeholder="0"></td>
                            <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][second]" min="0" max="15" required placeholder="0"></td>
                            <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][activity]" min="0" max="20" required placeholder="0"></td>
                            <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][final]" min="0" max="50" required placeholder="0"></td>
                            <td><input type="number" class="total-field" name="grades[{{ $st->student_id }}][total]" readonly placeholder="0"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:20px; display:flex; justify-content:flex-end;">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save'></i> حفظ الدرجات
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="card fade-in" style="text-align:center; padding:48px; color:var(--text-muted);">
        <i class='bx bx-info-circle' style="font-size:48px; color:var(--border); display:block; margin-bottom:12px;"></i>
        <p style="font-size:16px;">يرجى اختيار الصف والشعبة والمادة لعرض قائمة الطلاب</p>
    </div>
    @endif

</div>
<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>