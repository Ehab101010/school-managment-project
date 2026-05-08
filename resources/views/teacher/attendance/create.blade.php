<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>   تسجيل الحضور والغياب</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">  
 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
 
<body>
@include('includes.teacher-sidebar')

<div class="content">
<div class="att-page">

    {{-- Top bar --}}
    <div class="att-topbar">
        <a href="{{ route('teacher.attendance.index') }}" class="att-back-btn">
            <i class='bx bx-arrow-back'></i> رجوع
        </a>
        <div class="att-meta">
            <span class="att-badge att-badge-purple">
                <i class='bx bx-book-open'></i>
                {{ $assignment->subject->subject_name ?? '' }}
            </span>
            <span class="att-badge att-badge-blue">
                <i class='bx bx-group'></i>
                {{ $assignment->classRoom->class_name ?? '' }} — {{ $assignment->classRoom->section_name ?? '' }}
            </span>
            <span class="att-badge att-badge-date">
                <i class='bx bx-calendar'></i>
                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
            </span>
        </div>
    </div>
 
    {{-- Stats --}}
    <div class="att-stats">
        <div class="att-stat">
            <div class="att-stat-icon si-total"><i class='bx bx-group'></i></div>
            <div>
                <div class="att-stat-num" id="cnt-total">{{ $students->count() }}</div>
                <div class="att-stat-label">إجمالي الطلاب</div>
            </div>
        </div>
        <div class="att-stat">
            <div class="att-stat-icon si-pres"><i class='bx bx-check-circle'></i></div>
            <div>
                <div class="att-stat-num" id="cnt-present">0</div>
                <div class="att-stat-label">حاضر</div>
            </div>
        </div>
        <div class="att-stat">
            <div class="att-stat-icon si-abs"><i class='bx bx-x-circle'></i></div>
            <div>
                <div class="att-stat-num" id="cnt-absent">0</div>
                <div class="att-stat-label">غائب</div>
            </div>
        </div>
        <div class="att-stat">
            <div class="att-stat-icon si-late"><i class='bx bx-time'></i></div>
            <div>
                <div class="att-stat-num" id="cnt-late">0</div>
                <div class="att-stat-label">متأخر</div>
            </div>
        </div>
    </div>

    {{-- Main form --}}
    <form action="{{ route('teacher.attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="class_id"   value="{{ $classId }}">
        <input type="hidden" name="subject_id"  value="{{ $subjectId }}">
        <input type="hidden" name="date"        value="{{ $date }}">

        <div class="att-card">
            <div class="att-card-header">
                <div class="att-card-header-title">
                    <i class='bx bx-list-check'></i>
                    كشف الحضور ({{ $students->count() }} طالب)
                </div>
 
            </div>

            <div class="att-table-wrap">
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>الحالة</th>
                            <th>ملاحظة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $i => $student)
                        <tr>
                            <td style="color:var(--att-muted);font-size:.8rem;">{{ $i+1 }}</td>
                            <td>
                                <div class="stu-name-cell">
                                    <div class="stu-avatar">{{ mb_substr($student->full_name, 0, 1) }}</div>
                                    <div>
                                        <div class="stu-name">{{ $student->full_name }}</div>
                                        <div class="stu-num">#{{ $student->student_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="status-group" data-student="{{ $student->student_id }}">
                                    @php $cur = $existing[$student->student_id] ?? 'present'; @endphp

                                    <input type="radio" name="attendance[{{ $student->student_id }}]"
                                           id="p_{{ $student->student_id }}" value="present"
                                           {{ $cur === 'present' ? 'checked' : '' }} class="status-radio">
                                    <label for="p_{{ $student->student_id }}" class="sl-present">
                                        <i class='bx bx-check'></i> حاضر
                                    </label>

                                    <input type="radio" name="attendance[{{ $student->student_id }}]"
                                           id="a_{{ $student->student_id }}" value="absent"
                                           {{ $cur === 'absent' ? 'checked' : '' }} class="status-radio">
                                    <label for="a_{{ $student->student_id }}" class="sl-absent">
                                        <i class='bx bx-x'></i> غائب
                                    </label>

                                    <input type="radio" name="attendance[{{ $student->student_id }}]"
                                           id="l_{{ $student->student_id }}" value="late"
                                           {{ $cur === 'late' ? 'checked' : '' }} class="status-radio">
                                    <label for="l_{{ $student->student_id }}" class="sl-late">
                                        <i class='bx bx-time'></i> متأخر
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="notes[{{ $student->student_id }}]"
                                       class="note-input" placeholder="ملاحظة اختيارية..."
                                       value="{{ old('notes.'.$student->student_id) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="att-submit-bar">
                <div class="submit-info">
                    إجمالي: <span>{{ $students->count() }}</span> طالب —
                    حاضر: <span id="info-p">0</span> |
                    غائب: <span id="info-a">0</span> |
                    متأخر: <span id="info-l">0</span>
                </div>
                <button type="submit" class="att-btn-submit">
                    <i class='bx bx-save'></i>
                    حفظ الحضور
                </button>
            </div>
        </div>
    </form>

</div>


<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>