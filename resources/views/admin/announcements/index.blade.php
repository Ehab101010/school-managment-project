{{-- resources/views/admin/announcements/index.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعلانات</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.admin-sidebar')

<div class="mobile-topbar">
    <div style="width:44px"></div>
    <span class="mobile-topbar-title">الإعلانات</span>
    <span class="mobile-topbar-badge"><i class='bx bxs-crown'></i> مدير</span>
</div>

<div class="content">

    <div class="page-hero hero-teal fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-bell'></i> الإعلانات</h1>
                <p>إدارة ونشر الإعلانات للطلاب وأولياء الأمور والمعلمين</p>
            </div>
            <div class="hero-icon-wrap"><i class='bx bx-bell'></i></div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success fade-in"><i class='bx bx-check-circle'></i> {{ session('success') }}</div>
    @endif

    <div class="card fade-in">
        <div class="toolbar">
            <span class="card-toolbar-title"><i class='bx bx-bell'></i> جميع الإعلانات</span>
            <span class="badge badge-teal">{{ $announcements->total() }} إعلان</span>
        </div>

        @if($announcements->isEmpty())
        <div class="empty-state">
            <i class='bx bx-bell-off'></i>
            <p>لا توجد إعلانات حتى الآن</p>
        </div>

        @else
        @php
            $targetLabels = [
                'all'          => ['label'=>'الجميع',        'icon'=>'bx-globe'],
                'all_parents'  => ['label'=>'أولياء الأمور', 'icon'=>'bx-group'],
                'all_students' => ['label'=>'الطلاب',        'icon'=>'bx-user-graduate'],
                'all_teachers' => ['label'=>'المعلمون',      'icon'=>'bx-chalkboard'],
                'class'        => ['label'=>'صف محدد',       'icon'=>'bx-book-open'],
            ];
        @endphp

        <div class="announce-list">
            @foreach($announcements as $ann)
            @php
                $tKey   = $ann->target_type ?? 'all';
                $tInfo  = $targetLabels[$tKey] ?? ['label'=>$tKey,'icon'=>'bx-group'];
                $tLabel = $tKey === 'class'
                    ? 'صف: '.($ann->targetClass?->class_name??'').'-'.($ann->targetClass?->section_name??'')
                    : $tInfo['label'];
                $senderName = $ann->senderUser?->name ?? '---';
                $senderRole = $ann->sender_role === 'admin' ? 'مدير' : 'معلم';
                $dateStr    = $ann->created_at->format('d/m/Y');
                $timeStr    = $ann->created_at->format('H:i');
            @endphp

            <div class="announce-item" onclick="openAdminAnn({{ json_encode(['title'=>$ann->title,'body'=>$ann->body,'target'=>$tLabel,'sender'=>$senderName,'role'=>$senderRole,'date'=>$dateStr.' '.$timeStr]) }})">

                {{-- أيقونة الإعلان --}}
                <div class="ann-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="22" height="22">
                        <path d="M3 8.5C3 7.4 3.9 6.5 5 6.5H15C16.1 6.5 17 7.4 17 8.5V13.5C17 14.6 16.1 15.5 15 15.5H13L17 19.5V15.5C18.1 15.5 19 14.6 19 13.5V5.5C19 4.4 18.1 3.5 17 3.5H5C3.9 3.5 3 4.4 3 5.5V8.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 10H13M7 13H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="ann-body">
                    <div class="announce-title">{{ $ann->title }}</div>
                    <p class="announce-body">{{ Str::limit($ann->body, 130) }}</p>

                    <div class="ann-chips">
                        {{-- الجهة --}}
                        <span class="ann-chip ann-chip-teal">
                            <i class='bx {{ $tInfo['icon'] }}'></i>
                            {{ $tLabel }}
                        </span>
                        {{-- المرسل --}}
                        <span class="ann-chip ann-chip-blue">
                            <span class="ann-chip-avatar"> </span>
                         
                            <em>{{ $senderRole }}</em>
                        </span>
                        {{-- التاريخ --}}
                        <span class="ann-chip ann-chip-dim">
                            <i class='bx bx-calendar'></i>
                            {{ $dateStr }}
                            <em>{{ $timeStr }}</em>
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.announcements.destroy', $ann->id) }}"
                      onsubmit="return confirm('حذف هذا الإعلان؟')" onclick="event.stopPropagation()">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete ann-del-btn" title="حذف">
                        <i class='bx bx-trash'></i>
                    </button>
                </form>

            </div>
            @if(!$loop->last)<div class="ann-divider"></div>@endif
            @endforeach
        </div>

        @if($announcements->hasPages())
        <div class="pagination-container">{{ $announcements->links() }}</div>
        @endif
        @endif
    </div>

</div>

{{-- Modal --}}
<div class="modal" id="adminAnnModal" onclick="if(event.target===this)closeAdminAnn()">
    <div class="modal-box" style="max-width:520px;">
        <div class="modal-header">
            <span class="modal-title"><i class='bx bx-bell'></i> تفاصيل الإعلان</span>
            <button class="modal-close" onclick="closeAdminAnn()"><i class='bx bx-x'></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-item-title" id="aAnnTitle"></div>
            <div class="modal-item-meta" id="aAnnMeta"></div>
            <hr style="border:none;border-top:1px solid var(--glass-border);margin:.75rem 0;">
            <div class="modal-item-body" id="aAnnBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-reset" onclick="closeAdminAnn()"><i class='bx bx-x'></i> إغلاق</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
