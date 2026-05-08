<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>  تسجيل الحضور والغياب</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">  
 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
 
<body>
@include('includes.teacher-sidebar')

<div class="content">
<div class="att-page">

    <div class="page-hero hero-primary fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-calendar-check'></i> تسجيل الحضور والغياب</h1>
                <p>اختر الفصل والمادة والتاريخ لتسجيل حضور الطلاب</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bxs-calendar-check'></i></div>
        </div>
    </div>

    {{-- Success --}}
    @if(session('success'))
    <div class="att-alert att-alert-success">
        <i class='bx bx-check-circle'></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Quick select form --}}
    <div class="att-card">
        <div class="att-card-header">
            <i class='bx bx-filter-alt'></i>
            <span>اختيار الحصة</span>
        </div>
        <div class="att-card-body">
            <form action="{{ route('teacher.attendance.create') }}" method="GET">
                <div class="att-form-grid">
                    <div class="att-field">
                        <label>الفصل الدراسي</label>
                        <select name="class_id" id="class_sel" required>
                            <option value="">-- اختر الفصل --</option>
                            @foreach($assignments as $classId => $items)
                                <option value="{{ $classId }}">
                                    {{ $items->first()->classRoom->class_name ?? '' }}
                                    — {{ $items->first()->classRoom->section_name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="att-field">
                        <label>المادة الدراسية</label>
                        <select name="subject_id" id="subject_sel" required>
                            <option value="">-- اختر المادة --</option>
                            @foreach($assignments as $classId => $items)
                                @foreach($items as $a)
                                    <option value="{{ $a->subject_id }}"
                                            data-class="{{ $classId }}"
                                            style="display:none">
                                        {{ $a->subject->subject_name ?? '' }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="att-field">
                        <label>التاريخ</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <button type="submit" class="att-btn-primary">
                        <i class='bx bx-right-arrow-alt'></i>
                        متابعة
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Cards overview --}}
    <div class="assignments-grid">
        @foreach($assignments as $classId => $items)
            @foreach($items as $a)
            <a href="{{ route('teacher.attendance.create', [
                'class_id'   => $classId,
                'subject_id' => $a->subject_id,
                'date'       => date('Y-m-d'),
            ]) }}" class="assignment-card">
                <div class="ac-class">
                    {{ $a->classRoom->class_name ?? '' }} — {{ $a->classRoom->section_name ?? '' }}
                </div>
                <div class="ac-subject">{{ $a->subject->subject_name ?? '' }}</div>
                <div class="ac-section">{{ $a->classRoom->section_type ?? '' }}</div>
                <i class='bx bx-chevron-left ac-arrow'></i>
            </a>
            @endforeach
        @endforeach
    </div>

</div>


<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>