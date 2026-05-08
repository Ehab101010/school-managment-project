{{-- resources/views/admin/attendance/report.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير حضور المعلمين</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="sec-teachers">

{{-- Mobile sidebar overlay & toggle --}}

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">تقرير الحضور</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">
<div class="att-page">

    {{-- Hero --}}
    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-bar-chart-alt-2'></i> تقرير حضور المعلمين الشهري</h1>
                <p>ملخص الحضور والغياب والتأخير </p>
            </div>
</div>
    </div>

    {{-- Month filter --}}
    <form method="GET" class="month-form">
        <label><i class='bx bx-calendar'></i> الشهر:</label>
        <input type="month" name="month" value="{{ $month }}">
        <button type="submit"><i class='bx bx-search'></i> عرض</button>
    </form>

 

    {{-- Table --}}
    <div class="att-card">
        <div class="att-card-header">
            <div class="att-card-header-title">
                <i class='bx bxs-report'></i>
                تقرير شهر: {{ \Carbon\Carbon::parse($month.'-01')->translatedFormat('F Y') }}
                — ({{ $teachers->count() }} معلم)
            </div>
        </div>
        <div class="att-table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المعلم</th>
                        <th>أيام الحضور</th>
                        <th>غيابات مباشرة</th>
                        <th>تأخيرات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $i => $teacher)
                    @php $s = $summary[$teacher->teacher_id]; @endphp
                    <tr>
                        <td style="color:var(--text-muted);font-size:.8rem;">{{ $i+1 }}</td>
                        <td>
                            <div class="tea-name-cell">
                                <div class="tea-avatar">{{ mb_substr($teacher->full_name, 0, 1) }}</div>
                                {{ $teacher->full_name }}
                            </div>
                        </td>
                        <td>
                            <span class="stat-pill sp-green">
                                <i class='bx bx-check-circle'></i>
                                {{ $s['present'] ?? 0 }} يوم
                            </span>
                        </td>
                        <td>
                            <span class="stat-pill sp-red">
                                <i class='bx bx-x-circle'></i>
                                {{ $s['absences'] }}
                            </span>
                        </td>
                        <td>
                            <span class="stat-pill sp-yellow">
                                <i class='bx bx-time'></i>
                                {{ $s['lates'] }} تأخير

                            </span>
                        </td>
                   
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>