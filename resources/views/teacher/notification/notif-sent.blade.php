{{-- resources/views/teacher/notification/notif-sent.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرسائل المرسلة</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Notifications.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-messages fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-paper-plane'></i> الرسائل المرسلة</h1>
                <p>تقارير وتقييمات أرسلتها للإدارة وأولياء الأمور</p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.report.create') }}" class="hero-btn">
                    <i class='bx bx-edit'></i> رسالة جديدة
                </a>
                <a href="{{ route('teacher.notifications.inbox') }}" class="hero-btn hero-btn-ghost">
                    <i class='bx bx-inbox'></i> الوارد
                </a>
                <div class="hero-icon-wrap"><i class='bx bxs-paper-plane'></i></div>
            </div>
        </div>
    </div>

    {{-- ── قائمة الرسائل المرسلة ── --}}
    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title">
                <i class='bx bx-paper-plane'></i> الرسائل المرسلة لأولياء الأمور
            </span>
            <span style="font-size:13px; color:var(--text-muted);">{{ $sentReports->total() }} رسالة</span>
        </div>

        @if($sentReports->count())
            @foreach($sentReports as $report)
            @php
                $icons = [
                    'performance' => 'bx-bar-chart-alt-2',
                    'behavior'    => 'bx-brain',
                    'attendance'  => 'bx-calendar-check',
                    'general'     => 'bx-envelope',
                ];
                $icon = $icons[$report->report_type] ?? 'bx-envelope';
            @endphp
            <div class="report-item fade-in">
                <div class="report-type-icon rt-{{ $report->report_type }}">
                    <i class='bx {{ $icon }}'></i>
                </div>
                <div class="report-content">
                    <div class="report-title">{{ $report->title }}</div>
                    <p class="report-excerpt">{{ Str::limit($report->content, 100) }}</p>
                    <div class="report-meta">
                        @if($report->recipient_role === 'parent')
                            <span><i class='bx bx-user'></i> إلى: ولي الأمر</span>
                        @elseif($report->recipient_role === 'student')
                            <span><i class='bx bx-user-graduate'></i> إلى: الطالب</span>
                        @endif

                        @if($report->student)
                            <span>
                                <i class='bx bx-user-graduate'></i>
                                {{ $report->student->full_name }}
                            </span>
                        @endif

                        <span class="notif-time">
                            <i class='bx bx-time'></i> {{ $report->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                {{-- زر الحذف --}}
                <form method="POST" action="{{ route('teacher.report.destroy', $report->id) }}"
                      onsubmit="return confirm('حذف هذه الرسالة؟')" style="flex-shrink:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon-del" title="حذف">
                        <i class='bx bx-trash'></i>
                    </button>
                </form>
            </div>
            @endforeach

            {{-- ── Pagination ── --}}
            @if($sentReports->hasPages())
            <div class="pagination-container" style="padding-top:16px;">
                <ul class="pagination">

                    {{-- السابق --}}
                    <li class="{{ $sentReports->onFirstPage() ? 'disabled' : '' }}">
                        @if($sentReports->onFirstPage())
                            <span><i class='bx bx-chevron-right'></i></span>
                        @else
                            <a href="{{ $sentReports->previousPageUrl() }}"><i class='bx bx-chevron-right'></i></a>
                        @endif
                    </li>

                    {{-- الأرقام --}}
                    @foreach($sentReports->getUrlRange(1, $sentReports->lastPage()) as $page => $url)
                        <li class="{{ $page == $sentReports->currentPage() ? 'active' : '' }}">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- التالي --}}
                    <li class="{{ $sentReports->hasMorePages() ? '' : 'disabled' }}">
                        @if($sentReports->hasMorePages())
                            <a href="{{ $sentReports->nextPageUrl() }}"><i class='bx bx-chevron-left'></i></a>
                        @else
                            <span><i class='bx bx-chevron-left'></i></span>
                        @endif
                    </li>

                </ul>
            </div>
            @endif

        @else
            <div class="empty-state">
                <i class='bx bx-paper-plane'></i>
                <p>لم ترسل أي رسائل بعد</p>
            </div>
        @endif
    </div>

</div>

<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>