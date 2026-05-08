{{-- resources/views/admin/attendance/index.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حضور المعلمين</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="sec-teachers">

{{-- Mobile sidebar overlay & toggle --}}

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">الحضور</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
<div class="att-page">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bxs-user-check'></i> تسجيل حضور المعلمين</h1>
                <p>سجّل الحضور اليومي </p>
            </div>
</div>
    </div>

    @if(session('success'))
    <div class="att-alert att-alert-success">
        <i class='bx bx-check-circle'></i> {{ session('success') }}
    </div>
    @endif

    {{-- Toolbar --}}
    <div class="att-toolbar">
        <form method="GET" style="display:flex;align-items:center;gap:.7rem;">
            <div class="date-picker-wrap">
                <label><i class='bx bx-calendar'></i> التاريخ:</label>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()">
            </div>
        </form>

    </div>
 

    {{-- Form --}}
    <form action="{{ route('admin.teacher-attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="att-card">
            <div class="att-card-header">
                <div class="att-card-header-title">
                    <i class='bx bxs-user-check'></i>
                    كشف حضور المعلمين — {{ \Carbon\Carbon::parse($date)->translatedFormat('l، d F Y') }}
                </div>
  
            </div>

            <div class="att-table-wrap">
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المعلم</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $i => $teacher)
                        <tr>
                            <td style="color:var(--text-muted);font-size:.8rem;">{{ $i+1 }}</td>
                            <td>
                                <div class="tea-name-cell">
                                    <div class="tea-avatar">{{ mb_substr($teacher->full_name, 0, 1) }}</div>
                                    <div>
                                        <div class="tea-name">{{ $teacher->full_name }}</div>
                                        <div class="tea-dept">#{{ $teacher->teacher_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php $cur = $existing[(string)$teacher->teacher_id] ?? 'present'; @endphp
                                <div class="status-group">
                                    <input type="radio" name="attendance[{{ $teacher->teacher_id }}]"
                                           id="tp_{{ $teacher->teacher_id }}" value="present"
                                           {{ $cur === 'present' ? 'checked' : '' }} class="status-radio">
                                    <label for="tp_{{ $teacher->teacher_id }}" class="sl-present">
                                        <i class='bx bx-check'></i> حاضر
                                    </label>

                                    <input type="radio" name="attendance[{{ $teacher->teacher_id }}]"
                                           id="ta_{{ $teacher->teacher_id }}" value="absent"
                                           {{ $cur === 'absent' ? 'checked' : '' }} class="status-radio">
                                    <label for="ta_{{ $teacher->teacher_id }}" class="sl-absent">
                                        <i class='bx bx-x'></i> غائب
                                    </label>

                                    <input type="radio" name="attendance[{{ $teacher->teacher_id }}]"
                                           id="tl_{{ $teacher->teacher_id }}" value="late"
                                           {{ $cur === 'late' ? 'checked' : '' }} class="status-radio">
                                    <label for="tl_{{ $teacher->teacher_id }}" class="sl-late">
                                        <i class='bx bx-time'></i> متأخر
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="att-submit-bar">
 
                <button type="submit" class="att-btn-submit">
                    <i class='bx bx-save'></i> حفظ الحضور
                </button>
            </div>
        </div>
    </form>

</div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>