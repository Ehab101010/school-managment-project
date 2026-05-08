{{-- resources/views/teacher/announcements/_card.blade.php --}}
@php
    $role = $ann->sender_role;
    if ($role === 'admin') {
        $senderRole = ['admin', 'b-admin', 'المدير'];
    } elseif ($role === 'student_affairs') {
        $senderRole = ['sa', 'b-sa', $ann->sender_label ?? 'شؤون الطلاب'];
    } else {
        $senderRole = ['teacher', 'b-teacher', 'المعلم'];
    }

    $targets = [
        'all'          => 'الجميع',
        'all_parents'  => 'أولياء الأمور',
        'all_students' => 'الطلاب',
        'all_teachers' => 'المعلمون',
        'class'        => 'صف: ' . ($ann->targetClass?->class_name ?? ''),
    ];
    $target = $targets[$ann->target_type] ?? $ann->target_type;
@endphp

<div class="ann-card" onclick="openTeacherAnn({{ json_encode(['title'=>$ann->title,'body'=>$ann->body,'sender'=>$senderRole[2],'sender_class'=>$senderRole[1],'target'=>$target,'subject'=>$ann->subject_name??null,'date'=>$ann->created_at->format('d/m/Y'),'is_mine'=>$showDelete]) }})" style="cursor:pointer;">
    <div class="ann-icon {{ $senderRole[0] }}"><i class='bx bx-megaphone'></i></div>
    <div class="ann-body">
        <div class="ann-top">
            <div class="ann-card-title">{{ $ann->title }}</div>
            <div class="ann-time"><i class='bx bx-time-five'></i> {{ $ann->created_at->diffForHumans() }}</div>
        </div>
        <div class="ann-preview">{{ $ann->body }}</div>
        <div class="ann-meta">
            <span class="badge-sm {{ $senderRole[1] }}"><i class='bx bx-user'></i> {{ $senderRole[2] }}</span>
            <span class="badge-sm b-target"><i class='bx bx-group'></i> {{ $target }}</span>
        </div>
    </div>

    @if($showDelete)
    <form method="POST" action="{{ route('teacher.announcements.destroy', $ann->id) }}"
          onsubmit="return confirm('حذف هذا الإعلان؟')" style="flex-shrink:0;">
        @csrf @method('DELETE')
        <button type="submit" style="background:rgba(231,76,60,0.08); border:1.5px solid rgba(231,76,60,0.22);
                color:var(--danger); border-radius:var(--radius-xs); width:34px; height:34px;
                display:flex; align-items:center; justify-content:center;
                cursor:pointer; font-size:1.1rem; transition:var(--transition);">
            <i class='bx bx-trash'></i>
        </button>
    </form>
    @endif
</div>