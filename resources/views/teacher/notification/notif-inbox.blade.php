{{-- resources/views/teacher/notification/notif-inbox.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرسائل</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Notifications.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-messages fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-envelope'></i> الرسائل الواردة</h1>
                <p>تقارير وإشعارات مرسلة من الإدارة بخصوص طلابك</p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.report.create') }}" class="hero-btn">
                    <i class='bx bx-edit'></i> رسالة جديدة
                </a>
                <a href="{{ route('teacher.notifications.sent') }}" class="hero-btn hero-btn-ghost">
                    <i class='bx bx-paper-plane'></i> المرسلة
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success fade-in">
        <i class='bx bx-check-circle'></i> {{ session('success') }}
    </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="stats-grid fade-in" style="grid-template-columns: repeat(2, 1fr); max-width:400px;">
        <div class="stat-card teal">
            <div class="stat-icon"><i class='bx bx-envelope'></i></div>
            <div>
                <div class="stat-value">{{ $reports->total() }}</div>
                <div class="stat-label">إجمالي الرسائل</div>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon"><i class='bx bx-envelope-open'></i></div>
            <div>
                <div class="stat-value">{{ $unreadReports }}</div>
                <div class="stat-label">رسائل جديدة</div>
            </div>
        </div>
    </div>

    {{-- ── قائمة الرسائل الواردة ── --}}
    <div class="card fade-in" style="margin-top:24px;">
        <div class="card-header">
            <span class="card-title">
                <i class='bx bx-inbox'></i> صندوق الوارد
            </span>
            <span style="font-size:13px; color:var(--text-muted);">{{ $reports->total() }} رسالة</span>
        </div>

        @if($reports->count())
            @foreach($reports as $report)
            @php
                $icons = [
                    'performance' => 'bx-bar-chart-alt-2',
                    'behavior'    => 'bx-brain',
                    'attendance'  => 'bx-calendar-check',
                    'general'     => 'bx-envelope',
                ];
                $icon = $icons[$report->report_type] ?? 'bx-envelope';
            @endphp
            <div class="report-item fade-in"
                 onclick="openTeacherMsg({{ json_encode(['title'=>$report->title,'content'=>$report->content,'type'=>$report->report_type,'sender'=>'الإدارة','student'=>$report->student?$report->student->full_name:null,'period'=>$report->period??null,'date'=>$report->created_at->format('d/m/Y'),'is_read'=>(bool)$report->is_read]) }})"
                 style="{{ !$report->is_read ? 'border-right: 3px solid var(--accent);' : '' }} cursor:pointer;">
                <div class="report-type-icon rt-{{ $report->report_type }}">
                    <i class='bx {{ $icon }}'></i>
                </div>
                <div class="report-content">
                    <div class="report-title">
                        @if(!$report->is_read)
                            <span class="unread-dot"></span>
                        @endif
                        {{ $report->title }}
                    </div>
                    <p class="report-excerpt">{{ Str::limit($report->content, 130) }}</p>
                    <div class="report-meta">
                        <span><i class='bx bx-user'></i> من: الإدارة</span>
                        @if($report->student)
                            <span>
                                <i class='bx bx-user-graduate'></i>
                                الطالب: <strong>{{ $report->student->full_name }}</strong>
                            </span>
                        @endif
                        <span class="notif-time">
                            <i class='bx bx-time'></i> {{ $report->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- ── Pagination ── --}}
            @if($reports->hasPages())
            <div class="pagination-container" style="padding-top:16px;">
                <ul class="pagination">

                    {{-- السابق --}}
                    <li class="{{ $reports->onFirstPage() ? 'disabled' : '' }}">
                        @if($reports->onFirstPage())
                            <span><i class='bx bx-chevron-right'></i></span>
                        @else
                            <a href="{{ $reports->previousPageUrl() }}"><i class='bx bx-chevron-right'></i></a>
                        @endif
                    </li>

                    {{-- الأرقام --}}
                    @foreach($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                        <li class="{{ $page == $reports->currentPage() ? 'active' : '' }}">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- التالي --}}
                    <li class="{{ $reports->hasMorePages() ? '' : 'disabled' }}">
                        @if($reports->hasMorePages())
                            <a href="{{ $reports->nextPageUrl() }}"><i class='bx bx-chevron-left'></i></a>
                        @else
                            <span><i class='bx bx-chevron-left'></i></span>
                        @endif
                    </li>

                </ul>
            </div>
            @endif

        @else
            <div class="empty-state">
                <i class='bx bx-envelope-open'></i>
                <p>صندوق الوارد فارغ</p>
            </div>
        @endif
    </div>

</div>

{{-- Modal الرسالة --}}
<div class="modal-overlay" id="teacherMsgModal" onclick="if(event.target===this)closeTeacherMsg()">
    <div class="modal shared-modal">
        <div class="modal-head">
            <span class="modal-head-title"><i class='bx bx-envelope'></i> تفاصيل الرسالة</span>
            <button class="modal-close" onclick="closeTeacherMsg()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-ann-title" id="tMsgTitle"></div>
            <div class="modal-meta-row" id="tMsgMeta"></div>
            <div class="modal-content-box" id="tMsgBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" onclick="closeTeacherMsg()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/teacher.js') }}"></script>
<script src="{{ asset('js/shared-modal.js') }}"></script>
</body>
</html>