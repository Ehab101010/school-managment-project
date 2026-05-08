{{-- resources/views/admin/report/rep-index.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرسائل المرسلة</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">التقارير</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-envelope'></i> الرسائل المرسلة</h1>
                <p>جميع الرسائل والتقارير المرسلة</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-envelope'></i></div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success fade-in"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
    @endif

    <div class="card fade-in">
        <div class="toolbar">
            <span class="card-toolbar-title"><i class='bx bx-envelope'></i> جميع الرسائل المرسلة</span>
            <span class="badge badge-teal">{{ $sent->total() }} رسالة</span>
        </div>

        @if($sent->count())
        @php
            $icons = [
                'performance' => 'bx-bar-chart-alt-2',
                'behavior'    => 'bx-brain',
                'attendance'  => 'bx-calendar-check',
                'general'     => 'bx-envelope',
            ];
            $typeLabels = [
                'performance' => 'أداء أكاديمي',
                'behavior'    => 'سلوك',
                'attendance'  => 'حضور وغياب',
                'general'     => 'عام',
            ];
        @endphp

        <div class="announce-list">
            @foreach($sent as $report)
            @php
                $recipientName = '---';
                if ($report->recipient) {
                    if ($report->recipient_role === 'teacher') {
                        $recipientName = \App\Models\Teacher::where('teacher_id', $report->recipient->profile_id)->value('full_name') ?? $report->recipient->name ?? '---';
                    } elseif ($report->recipient_role === 'parent') {
                        $recipientName = \App\Models\StudentParent::where('id', $report->recipient->profile_id)->value('full_name') ?? $report->recipient->name ?? '---';
                    }
                }
                $rType      = $report->report_type ?? 'general';
                $iconClass  = $icons[$rType] ?? 'bx-envelope';
                $typeLabel  = $typeLabels[$rType] ?? $rType;
                $isTeacher  = $report->recipient_role === 'teacher';
                $dateStr    = $report->created_at->format('d/m/Y');
                $timeStr    = $report->created_at->format('H:i');
            @endphp

            <div class="announce-item" onclick="openAdminReport({{ json_encode(['title'=>$report->title,'content'=>$report->content,'type'=>$typeLabel,'recipient'=>$recipientName,'recipient_role'=>$report->recipient_role,'student'=>$report->student?$report->student->full_name:null,'date'=>$dateStr.' '.$timeStr]) }})">

                <div class="ann-icon-wrap">
                    <i class='bx {{ $iconClass }}'></i>
                </div>

                <div class="ann-body">
                    <div class="announce-title">{{ $report->title }}</div>
                    <p class="announce-body">{{ Str::limit($report->content, 130) }}</p>

                    <div class="ann-chips">
                        {{-- نوع الرسالة --}}
                        <span class="ann-chip ann-chip-teal">
                            <i class='bx {{ $iconClass }}'></i>
                            {{ $typeLabel }}
                        </span>
                        {{-- المستلم --}}
                        <span class="ann-chip {{ $isTeacher ? 'ann-chip-blue' : 'ann-chip-yellow' }}">
                            <span class="ann-chip-avatar">{{ mb_substr($recipientName,0,1) }}</span>
                            {{ $recipientName }}
                            <em>{{ $isTeacher ? 'معلم' : 'ولي أمر' }}</em>
                        </span>
                        {{-- الطالب إن وجد --}}
                        @if($report->student)
                        <span class="ann-chip ann-chip-green">
                            <i class='bx bx-user-graduate'></i>
                            {{ $report->student->full_name }}
                        </span>
                        @endif
                        {{-- التاريخ --}}
                        <span class="ann-chip ann-chip-dim">
                            <i class='bx bx-calendar'></i>
                            {{ $dateStr }}
                            <em>{{ $timeStr }}</em>
                        </span>
                    </div>
                </div>

                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onclick="event.stopPropagation()">
                    @csrf @method('DELETE')
                    <button class="btn-delete ann-del-btn" onclick="return confirm('حذف هذه الرسالة؟')" title="حذف">
                        <i class='bx bx-trash'></i>
                    </button>
                </form>

            </div>
            @if(!$loop->last)<div class="ann-divider"></div>@endif
            @endforeach
        </div>

        <div class="pagination-container">{{ $sent->links() }}</div>

        @else
        <div class="empty-state">
            <i class='bx bx-envelope-open'></i>
            <p>لم تقم بإرسال أي رسائل بعد</p>
        </div>
        @endif
    </div>

</div>

{{-- Modal --}}
<div class="modal" id="adminRepModal" onclick="if(event.target===this)closeAdminReport()">
    <div class="modal-box" style="max-width:520px;">
        <div class="modal-header">
            <span class="modal-title"><i class='bx bx-envelope'></i> تفاصيل الرسالة</span>
            <button class="modal-close" onclick="closeAdminReport()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-item-title" id="aRepTitle"></div>
            <div class="modal-item-meta" id="aRepMeta"></div>
            <hr style="border:none;border-top:1px solid var(--glass-border);margin:.75rem 0;">
            <div class="modal-item-body" id="aRepBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-reset" onclick="closeAdminReport()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
