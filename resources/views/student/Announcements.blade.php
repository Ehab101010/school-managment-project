{{-- resources/views/student/announcements.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعلانات — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-header">
        <h1><i class='bx bx-megaphone'></i> الإعلانات</h1>
        @if($unreadCount > 0)
            <span class="unread-pill"><i class='bx bx-bell-ring'></i> {{ $unreadCount }} إعلان جديد</span>
        @endif
    </div>

    {{-- Filters --}}
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterAnns('all', this)">
            <i class='bx bx-list-ul'></i> الكل ({{ $announcements->count() }})
        </button>
        <button class="filter-tab" onclick="filterAnns('admin', this)">
            <i class='bx bx-shield-alt-2'></i> من المدير
        </button>
        <button class="filter-tab" onclick="filterAnns('student_affairs', this)">
            <i class='bx bx-group'></i> من شؤون الطلاب
        </button>
        <button class="filter-tab" onclick="filterAnns('teacher', this)">
            <i class='bx bx-chalkboard'></i> من المعلم
        </button>
    </div>

    @if($announcements->isEmpty())
        <div class="empty-state">
            <i class='bx bx-inbox'></i>
            <p>لا توجد إعلانات حتى الآن</p>
        </div>
    @else
        <div class="ann-grid" id="annGrid">
            @foreach($announcements as $ann)
            @php
                $isAdmin     = $ann->sender_role === 'admin';
                $isSA        = $ann->sender_role === 'student_affairs';
                $isTeacher   = $ann->sender_role === 'teacher';
                $senderLabel = $ann->sender_label ?? ($isAdmin ? 'المدير' : ($isSA ? 'شؤون الطلاب' : ($ann->teacher_name ?? 'المعلم')));
                $subjectName = $ann->subject_name ?? null;
                $senderClass = $isAdmin ? 'b-admin' : ($isSA ? 'b-sa' : 'b-teacher');
                $iconClass   = $isAdmin ? 'admin' : ($isSA ? 'admin' : 'teacher');
                $targets = [
                    'all'              => 'الجميع',
                    'all_students'     => 'الطلاب',
                    'class'            => 'صف: ' . ($ann->targetClass?->class_name ?? ''),
                    'specific_student' => 'موجه إليك',
                ];
                $target = $targets[$ann->target_type] ?? $ann->target_type;
            @endphp
            <div class="ann-card {{ !$ann->is_read ? 'unread' : '' }}"
                 data-role="{{ $ann->sender_role }}"
                 onclick="openAnnModal({{ json_encode(['title'=>$ann->title,'body'=>$ann->body,'sender'=>$senderLabel,'subject'=>$subjectName,'date'=>$ann->created_at->format('d/m/Y'),'target'=>$target,'sender_class'=>$senderClass,'is_teacher'=>$isTeacher]) }})"
                 style="cursor:pointer;">

                <div class="ann-icon {{ $iconClass }}">
                    <i class='bx bx-megaphone'></i>
                </div>

                <div class="ann-body">
                    <div class="ann-top">
                        <div class="ann-card-title">{{ $ann->title }}</div>
                        <div class="ann-time">
                            <i class='bx bx-time-five'></i>
                            {{ $ann->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="ann-preview">{{ Str::limit($ann->body, 120) }}</div>
                    <div class="ann-meta">
                        <span class="badge-sm {{ $senderClass }}">
                            <i class='bx bx-user'></i> {{ $senderLabel }}
                        </span>
                        @if($isTeacher && $subjectName)
                        <span class="badge-sm b-high">
                            <i class='bx bx-book-open'></i> {{ $subjectName }}
                        </span>
                        @endif
                        <span class="badge-sm b-target">
                            <i class='bx bx-group'></i> {{ $target }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

{{-- Modal الإعلان --}}
<div class="modal-overlay" id="stuAnnModal" onclick="if(event.target===this)closeStuAnn()">
    <div class="modal">
        <div class="modal-head">
            <span class="modal-head-title"><i class='bx bx-megaphone'></i> تفاصيل الإعلان</span>
            <button class="modal-close" onclick="closeStuAnn()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-ann-title" id="stuAnnTitle"></div>
            <div class="modal-meta-row" id="stuAnnMeta"></div>
            <div class="modal-content-box" id="stuAnnBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" onclick="closeStuAnn()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>
<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
