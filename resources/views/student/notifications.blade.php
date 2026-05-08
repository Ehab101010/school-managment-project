{{-- resources/views/student/notifications.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإشعارات — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1>
                <i class='bx bx-bell'></i> الإشعارات
                @if($unreadCount > 0)
                <span class="unread-pill" style="font-size:13px; margin-right:8px;">{{ $unreadCount }} جديد</span>
                @endif
            </h1>
            <div class="breadcrumb">
                <span>الرئيسية</span>
                <i class='bx bx-chevron-left'></i>
                <span>الإشعارات</span>
            </div>
        </div>
    </div>

    @if($unreadCount > 0)
    <div class="alert fade-in" style="background:rgba(109,40,217,0.07); border-color:rgba(109,40,217,0.2); color:var(--accent);">
        <i class='bx bx-bell-ring'></i>
        لديك <strong>{{ $unreadCount }}</strong> إشعار جديد — تم تعليمه كمقروء تلقائياً
    </div>
    @endif

    {{-- Reports --}}
    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-envelope'></i> الرسائل والتقارير</span>
            <span class="count-badge"><i class='bx bx-envelope'></i> {{ $reports->total() }} رسالة</span>
        </div>

        @if($reports->count())
        <div class="notif-list">
            @foreach($reports as $report)
            @php
                $typeMap = [
                    'performance' => ['bx-bar-chart-alt-2','type-performance','أداء أكاديمي'],
                    'behavior'    => ['bx-brain',          'type-behavior',   'سلوك'],
                    'attendance'  => ['bx-calendar-check', 'type-attendance', 'حضور وغياب'],
                    'general'     => ['bx-file',           'type-general',    'عام'],
                ];
                $t           = $typeMap[$report->report_type] ?? ['bx-file','type-general','عام'];
                $isTeacher   = $report->sender_role === 'teacher';
                $senderLabel = $isTeacher ? ($report->teacher_name ?? 'معلم') : 'الإدارة';
            @endphp
            <div class="notif-item fade-in" onclick="openStuReport({{ json_encode(['title'=>$report->title,'content'=>$report->content,'type'=>$t[2],'type_class'=>$t[1],'sender'=>$senderLabel,'is_teacher'=>$isTeacher,'subject'=>$report->subject_name??null,'period'=>$report->period??null,'date'=>$report->created_at->format('d/m/Y')]) }})" style="cursor:pointer;">
                <div class="notif-icon-wrap {{ $t[1] }}">
                    <i class='bx {{ $t[0] }}'></i>
                </div>
                <div class="notif-body">
                    <div class="notif-header-row">
                        <span class="notif-title">{{ $report->title }}</span>
                        <div style="display:flex; gap:5px; flex-wrap:wrap;">
                            <span class="nbadge nbadge-normal">{{ $t[2] }}</span>
                            <span class="nbadge {{ $isTeacher ? 'b-teacher' : 'b-admin' }}">
                                {{ $isTeacher ? '👨‍🏫 ' : '🏫 ' }}{{ $senderLabel }}
                            </span>
                            @if($isTeacher && $report->subject_name)
                            <span class="nbadge b-high">
                                <i class='bx bx-book-open' style="font-size:11px;"></i> {{ $report->subject_name }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <p class="notif-text">{{ Str::limit($report->content, 100) }}</p>
           
                    <div class="notif-meta">
                        <span class="notif-time"><i class='bx bx-time'></i> {{ $report->created_at->diffForHumans() }}</span>
                      
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination-container">
            {{ $reports->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class='bx bx-envelope-open'></i>
            <p>لا توجد رسائل حالياً</p>
        </div>
        @endif
    </div>

    {{-- System Notifications --}}
    @if($notifications->count())
    <div class="card fade-in" style="margin-top:1.2rem;">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-inbox'></i> إشعارات النظام</span>
            <span class="count-badge"><i class='bx bx-bell'></i> {{ $notifications->total() }} إشعار</span>
        </div>
        <div class="notif-list">
            @foreach($notifications as $item)
            @php $notif = $item->notification; @endphp
            <div class="notif-item fade-in" onclick="openStuReport({{ json_encode(['title'=>$notif->title,'content'=>$notif->body,'type'=>'إشعار نظام','type_class'=>'normal','sender'=>$notif->sender_role==='admin'?'الإدارة':'معلم','is_teacher'=>$notif->sender_role!=='admin','subject'=>null,'period'=>null,'date'=>$notif->created_at->format('d/m/Y')]) }})" style="cursor:pointer;">
                <div class="notif-icon-wrap normal">
                    <i class='bx {{ $notif->sender_role === "admin" ? "bx-shield-alt-2" : "bx-user-voice" }}'></i>
                </div>
                <div class="notif-body">
                    <div class="notif-header-row">
                        <span class="notif-title">{{ $notif->title }}</span>
                        <span class="nbadge {{ $notif->sender_role === 'admin' ? 'b-admin' : 'b-teacher' }}">
                            {{ $notif->sender_role === 'admin' ? '🏫 الإدارة' : '👨‍🏫 معلم' }}
                        </span>
                    </div>
                    <p class="notif-text">{{ $notif->body }}</p>
                    <div class="notif-meta">
                        <span class="notif-time"><i class='bx bx-time'></i> {{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination-container">
            {{ $notifications->links() }}
        </div>
    </div>
    @endif

</div>

{{-- Modal التقرير/الإشعار --}}
<div class="modal-overlay" id="stuReportModal" onclick="if(event.target===this)closeStuReport()">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-head-title"><i class='bx bx-envelope'></i> تفاصيل الرسالة</span>
            <button class="modal-close" onclick="closeStuReport()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-ann-title" id="stuRepTitle"></div>
            <div class="modal-meta-row" id="stuRepMeta"></div>
            <div class="modal-content-box" id="stuRepBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" onclick="closeStuReport()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>
<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
