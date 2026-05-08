{{-- resources/views/teacher/announcements/index.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعلانات</title>
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')

<div class="content">
<div class="ann-page">

    <div class="page-hero hero-announcements fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-megaphone'></i> الإعلانات</h1>
                <p>إعلانات من الإدارة وإعلاناتك المرسلة للطلاب</p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.announcements.create') }}" class="hero-btn">
                    <i class='bx bx-plus'></i> إعلان جديد
                </a>
                <div class="hero-icon-wrap"><i class='bx bxs-megaphone'></i></div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success fade-in">
        <i class='bx bx-check-circle'></i> {{ session('success') }}
    </div>
    @endif

    {{-- Tabs --}}
    <div class="tab-row">
        <button type="button" class="tab-btn active" onclick="showTab('received', this)">
            <i class='bx bx-download'></i> من الإدارة
            <span style="background:rgba(255,255,255,.25); border-radius:50px; padding:.1rem .5rem; font-size:.73rem;">{{ $received->count() }}</span>
        </button>
        <button type="button" class="tab-btn" onclick="showTab('sent', this)">
            <i class='bx bx-upload'></i> إعلاناتي
            <span style="background:var(--bg); color:var(--text-muted); border-radius:50px; padding:.1rem .5rem; font-size:.73rem;">{{ $sent->count() }}</span>
        </button>
    </div>

    {{-- من الإدارة --}}
    <div id="received">
        @if($received->isEmpty())
        <div class="empty-state"><i class='bx bx-inbox'></i><p>لا توجد إعلانات من الإدارة</p></div>
        @else
        <div class="ann-grid">
            @foreach($received as $ann)
            @include('teacher.announcements._card', ['ann' => $ann, 'showDelete' => false])
            @endforeach
        </div>
        @endif
    </div>

    {{-- إعلاناتي --}}
    <div id="sent" style="display:none;">
        @if($sent->isEmpty())
        <div class="empty-state"><i class='bx bx-megaphone'></i><p>لم ترسل أي إعلانات بعد</p></div>
        @else
        <div class="ann-grid">
            @foreach($sent as $ann)
            @include('teacher.announcements._card', ['ann' => $ann, 'showDelete' => true])
            @endforeach
        </div>
        @endif
    </div>

</div>
</div>

{{-- Modal الإعلان --}}
<div class="modal-overlay" id="teacherAnnModal" onclick="if(event.target===this)closeTeacherAnn()">
    <div class="modal shared-modal">
        <div class="modal-head">
            <span class="modal-head-title"><i class='bx bx-megaphone'></i> تفاصيل الإعلان</span>
            <button class="modal-close" onclick="closeTeacherAnn()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-ann-title" id="tAnnTitle"></div>
            <div class="modal-meta-row" id="tAnnMeta"></div>
            <div class="modal-content-box" id="tAnnBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" onclick="closeTeacherAnn()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/teacher.js') }}"></script>
<script src="{{ asset('js/shared-modal.js') }}"></script>
</body>
</html>