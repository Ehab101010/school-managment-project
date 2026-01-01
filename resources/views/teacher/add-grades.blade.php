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
    <h1>إضافة درجات الطلاب</h1>

    {{-- FORM الرئيسي --}}
    <form method="GET" action="{{ route('teacher.add-grades') }}">

        {{-- اختيار الصف --}}
        <label>اختر الصف:</label>
        <select name="class_name" onchange="this.form.submit()">
            <option value="">اختر الصف</option>
            @foreach ($classes as $c)
                <option value="{{ $c->class_name }}"
                    {{ request('class_name') == $c->class_name ? 'selected' : '' }}>
                    {{ $c->class_name }}
                </option>
            @endforeach
        </select>

        {{-- اختيار الشعبة --}}
        <label>اختر الشعبة:</label>
        <select name="class_id" onchange="this.form.submit()">
            <option value="">اختر الشعبة</option>
            @foreach ($sections as $sec)
                <option value="{{ $sec->class_id }}"
                    {{ request('class_id') == $sec->class_id ? 'selected' : '' }}>
                    {{ $sec->section_name }} ({{ $sec->section_type }})
                </option>
            @endforeach
        </select>

        {{-- اختيار المادة --}}
        @if (!empty($subjects))
            <label>اختر المادة:</label>
            <select name="subject_id" onchange="this.form.submit()">
                <option value="">اختر المادة</option>
                @foreach ($subjects as $sub)
                    <option value="{{ $sub->subject_id }}"
                        {{ request('subject_id') == $sub->subject_id ? 'selected' : '' }}>
                        {{ $sub->subject_name }}
                    </option>
                @endforeach
            </select>
        @endif

    </form>

    {{-- جدول الطلاب وتعبئة الدرجات --}}
    @if (!empty($students))
<form method="POST" action="{{ route('teacher.store-grades') }}">
    @csrf

    <input type="hidden" name="class_id" value="{{ request('class_id') }}">
    <input type="hidden" name="section_type" value="{{ request('section_type') ?? '' }}">
    <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">

    <table>
        <thead>
            <tr>
                <th>اسم الطالب</th>
                <th>امتحان أول</th>
                <th>امتحان ثاني</th>
                <th>نشاط</th>
                <th>الامتحان النهائي</th>
                <th>المجموع</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $st)
            <tr>
                <td>{{ $st->full_name }}</td>

                <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][first]" min="0" max="15" required></td>
                <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][second]" min="0" max="15" required></td>
                <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][activity]" min="0" max="20" required></td>
                <td><input type="number" class="grade-input" name="grades[{{ $st->student_id }}][final]" min="0" max="50" required></td>

                <td><input type="number" class="total-field" name="grades[{{ $st->student_id }}][total]" readonly></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn-save">حفظ الدرجات</button>
</form>
@endif

</div>

<script>
     document.querySelectorAll('.grade-input').forEach(input => {
        input.addEventListener('input', function () {
            let row = this.closest('tr');

            let first  = Number(row.querySelector('input[name*="[first]"]').value) || 0;
            let second = Number(row.querySelector('input[name*="[second]"]').value) || 0;
            let act    = Number(row.querySelector('input[name*="[activity]"]').value) || 0;
            let finalE = Number(row.querySelector('input[name*="[final]"]').value) || 0;

            let total = first + second + act + finalE;

            row.querySelector('.total-field').value = total;
        });
    });
</script>
<script src="{{ asset('js/teacher.js') }}"></script>

</body>
</html>
