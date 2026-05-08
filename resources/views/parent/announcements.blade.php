{{-- resources/views/parent/announcements.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعلانات</title>
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>
@include('includes.parent-sidebar')

<div class="content">
<div class="ann-page">

    <div class="student-header" style="margin-bottom:1.8rem;">
        <div class="student-avatar"><i class='bx bxs-megaphone'></i></div>
        <div class="student-info">
            <h2>الإعلانات</h2>
            <div class="student-badges">
                <span class="student-badge"><i class='bx bx-envelope'></i> {{ $announcements->count() }} إعلان</span>
                @if($unreadCount > 0)
                <span class="student-badge"><i class='bx bx-bell'></i> {{ $unreadCount }} جديد</span>
                @endif
            </div>
        </div>
        <a href="{{ route('parent.dashboard') }}" class="btn-back">
            <i class='bx bx-arrow-back'></i> رجوع
        </a>
    </div>

    {{-- إحصائيات --}}
    @php
        $fromAdmin   = $announcements->where('sender_role','admin')->count();
        $fromSA      = $announcements->where('sender_role','student_affairs')->count();
        $fromTeacher = $announcements->where('sender_role','teacher')->count();
    @endphp
    <div class="ann-stats">
        <div class="ann-stat">
            <div class="ann-stat-icon si-blue"><i class='bx bxs-megaphone'></i></div>
            <div><div class="ann-stat-val">{{ $announcements->count() }}</div><div class="ann-stat-label">إجمالي</div></div>
        </div>
        <div class="ann-stat">
            <div class="ann-stat-icon si-blue"><i class='bx bx-building'></i></div>
            <div><div class="ann-stat-val">{{ $fromAdmin }}</div><div class="ann-stat-label">من الإدارة</div></div>
        </div>
        <div class="ann-stat">
            <div class="ann-stat-icon si-green"><i class='bx bx-group'></i></div>
            <div><div class="ann-stat-val">{{ $fromSA }}</div><div class="ann-stat-label">من شؤون الطلاب</div></div>
        </div>
        <div class="ann-stat">
            <div class="ann-stat-icon si-purple"><i class='bx bxs-graduation'></i></div>
            <div><div class="ann-stat-val">{{ $fromTeacher }}</div><div class="ann-stat-label">من المعلمين</div></div>
        </div>
    </div>

 
    {{-- القائمة --}}
    @if($announcements->isEmpty())
    <div class="empty-state">
        <i class='bx bx-megaphone'></i>
        <p>لا توجد إعلانات حتى الآن</p>
    </div>
    @else
    <div class="ann-list" id="annList">
        @foreach($announcements as $ann)
        @php
            $senderRole  = $ann->sender_role;
            $isSA        = $senderRole === 'student_affairs';
            $isTeacher   = $senderRole === 'teacher';
            $senderLabel = $ann->sender_label ?? ($senderRole === 'admin' ? 'الإدارة' : ($isSA ? 'شؤون الطلاب' : ($ann->teacher_name ?? 'المعلم')));
            $senderClass = ($senderRole === 'admin') ? 't-admin' : ($isSA ? 't-sa' : 't-teacher');
            $iconClass   = ($senderRole === 'admin') ? 'admin' : ($isSA ? 'sa' : 'teacher');
            $targets = [
                'all'             => 'الجميع',
                'all_parents'     => 'أولياء الأمور',
                'all_students'    => 'الطلاب',
                'class'           => 'صف: ' . ($ann->targetClass?->class_name ?? ''),
                'specific_student'=> 'طالب محدد',
            ];
            $target      = $targets[$ann->target_type] ?? $ann->target_type;
            $subjectName = $ann->subject_name ?? null;
        @endphp
        <div class="ann-card {{ !$ann->is_read ? 'unread' : '' }}"
             data-sender="{{ $senderRole }}"
             onclick="openAnn({{ json_encode(['title'=>$ann->title,'body'=>$ann->body,'sender'=>$senderLabel,'subject'=>$ann->subject_name,'date'=>$ann->created_at->format('d/m/Y'),'target'=>$target,'is_teacher'=>$ann->sender_role==='teacher']) }})">

            <div class="ann-icon {{ $iconClass }}">
                <i class='bx bxs-bell'></i>
            </div>

            <div class="ann-body">
                <div class="ann-top">
                    <div class="ann-title">{{ $ann->title }}</div>
                    <div class="ann-time"><i class='bx bx-time-five'></i> {{ $ann->created_at->diffForHumans() }}</div>
                </div>
                <div class="ann-preview">{{ $ann->body }}</div>
                <div class="ann-meta">
                    <span class="tag {{ $senderClass }}"><i class='bx bx-user'></i> {{ $senderLabel }}</span>
                    @if($isTeacher && $subjectName)
                    <span class="tag" style="background:#fef3c7;color:#92400e;"><i class='bx bx-book-open'></i> {{ $subjectName }}</span>
                    @endif
                    <span class="tag t-target"><i class='bx bx-group'></i> {{ $target }}</span>
                    @if(!$ann->is_read)
                    <span class="tag t-unread"><i class='bx bx-bell'></i> جديد</span>
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
<div class="modal-overlay" id="annModal" onclick="closeOutside(event)">
    <div class="modal shared-modal">
        <div class="modal-head">
            <span class="modal-head-title"><i class='bx bx-megaphone'></i> تفاصيل الإعلان</span>
            <button class="modal-close" onclick="closeAnn()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-ann-title" id="mTitle"></div>
            <div class="modal-meta-row" id="mMeta"></div>
            <div class="modal-content-box" id="mBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-m" onclick="closeAnn()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>
<script src="{{ asset('js/parent.js') }}"></script>
<script src="{{ asset('js/shared-modal.js') }}"></script>
</body>
</html>