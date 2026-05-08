{{-- resources/views/parent/messages.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإشعارات</title>
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>
@include('includes.parent-sidebar')

<div class="content">
<div class="messages-page">

    {{-- ترويسة --}}
    <div class="student-header" style="margin-bottom:1.8rem;">
        <div class="student-avatar"><i class='bx bxs-bell'></i></div>
        <div class="student-info">
            <h2>الإشعارات</h2>
            <div class="student-badges">
                <span class="student-badge"><i class='bx bx-bell'></i> {{ $total }} إشعار</span>
            </div>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="btn-back">
            <i class='bx bx-arrow-back'></i> رجوع
        </a>
    </div>

    {{-- إحصائيات --}}
    <div class="msg-stats">
        <div class="msg-stat">
            <div class="msg-stat-icon blue"><i class='bx bx-building'></i></div>
            <div><div class="msg-stat-val">{{ $fromAdmin }}</div><div class="msg-stat-label">من الإدارة</div></div>
        </div>
        <div class="msg-stat">
            <div class="msg-stat-icon purple"><i class='bx bxs-graduation'></i></div>
            <div><div class="msg-stat-val">{{ $fromTeacher }}</div><div class="msg-stat-label">من المعلمين</div></div>
        </div>
    </div>
 

    {{-- القائمة --}}
    @if($messages->isEmpty())
    <div class="empty-state">
        <i class='bx bx-bell'></i>
        <p>لا توجد إشعارات حتى الآن</p>
    </div>
    @else
    <div class="messages-list">
        @foreach($messages as $msg)
        @php
            $isTeacher   = $msg['sender_role'] === 'teacher';
            $senderLabel = $isTeacher ? ($msg['sender_name'] ?? 'معلم') : 'الإدارة';
            $senderClass = $isTeacher ? 'badge-teacher' : 'badge-admin';
            $rtypeMap = [
                'performance' => ['rtype-performance','📊 أداء أكاديمي'],
                'behavior'    => ['rtype-behavior',   '🧠 سلوك'],
                'attendance'  => ['rtype-attendance', '📅 حضور'],
                'general'     => ['rtype-general',    '📋 عام'],
            ];
            $rtype       = $rtypeMap[$msg['report_type'] ?? ''] ?? ['rtype-general','📋 عام'];
            $date        = \Carbon\Carbon::parse($msg['created_at'])->diffForHumans();
            $subjectName = $msg['subject_name'] ?? null;
        @endphp
        <div class="msg-card"
             onclick="openModal(JSON.parse(this.dataset.msg))"
             data-msg="{{ json_encode($msg, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"
             style="cursor:pointer;">
            <div class="msg-icon">
                <i class='bx bx-bell'></i>
            </div>
            <div class="msg-body">
                <div class="msg-top">
                    <div class="msg-title">{{ $msg['title'] }}</div>
                    <div class="msg-time"><i class='bx bx-time-five'></i> {{ $date }}</div>
                </div>
                <div class="msg-preview">{{ $msg['body'] }}</div>
                <div class="msg-meta">
                    <span class="badge {{ $senderClass }}"><i class='bx bx-user'></i> {{ $senderLabel }}</span>
                    @if($isTeacher && $subjectName)
                    <span class="badge" style="background:#fef3c7;color:#92400e;"><i class='bx bx-book-open'></i> {{ $subjectName }}</span>
                    @endif
                    <span class="badge {{ $rtype[0] }}">{{ $rtype[1] }}</span>
                    @if($msg['student'])
                        <span class="badge badge-student"><i class='bx bxs-graduation'></i> {{ $msg['student'] }}</span>
                    @endif
               
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
</div>

{{-- Modal --}}
<div class="modal-overlay" id="msgModal" onclick="closeModalOutside(event)">
    <div class="modal shared-modal">
        <div class="modal-head">
            <span class="modal-head-title"><i class='bx bx-bell'></i> تفاصيل الإشعار</span>
            <button class="modal-close" onclick="closeModal()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-title" id="modalTitle"></div>
            <div class="modal-meta-row" id="modalMeta"></div>
            <div class="modal-content-box" id="modalBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" onclick="closeModal()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>
<script src="{{ asset('js/parent.js') }}"></script>
<script src="{{ asset('js/shared-modal.js') }}"></script>
</body>
</html>