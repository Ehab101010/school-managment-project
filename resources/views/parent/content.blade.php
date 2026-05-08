{{-- resources/views/parent/content.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المحتوى التعليمي</title>
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.parent-sidebar')

<div class="content">
<div class="content-page">

    {{-- ترويسة --}}
    <div class="student-header" style="margin-bottom:1.5rem;">
        <div class="student-avatar">
            <i class='bx bx-book-open'></i>
        </div>
        <div class="student-info">
            <h2>المحتوى التعليمي</h2>
            <div class="student-badges">
                <span class="student-badge">
                    <i class='bx bx-user-circle'></i>
                    {{ $child->full_name ?? $child->first_name . ' ' . $child->last_name }}
                </span>
                <span class="student-badge">
                    <i class='bx bx-chalkboard'></i>
                    {{ $child->class->class_name ?? '---' }}
                </span>
            </div>
        </div>
        <a href="{{ route('parent.children') }}" class="btn-back">
            <i class='bx bx-arrow-back'></i> رجوع
        </a>
    </div>

    {{-- ══ كروت المواد ══ --}}
    <div id="subjectsView">
        @php
            $grouped   = $content->groupBy('subject_id');
            $typeIcons = ['video'=>'bx-play-circle','pdf'=>'bxs-file-pdf','excel'=>'bx-table','assignment'=>'bx-task','link'=>'bx-link-external'];
            $subjectIcons = ['رياضيات'=>'bx-math','علوم'=>'bx-test-tube','لغة عربية'=>'bx-font','لغة إنجليزية'=>'bx-globe','تاريخ'=>'bx-landmark','جغرافيا'=>'bx-map','تربية إسلامية'=>'bx-book-heart','حاسوب'=>'bx-desktop','فيزياء'=>'bx-atom','كيمياء'=>'bxs-flask'];
        @endphp

        @if($grouped->isEmpty())
        <div class="empty-state">
            <i class='bx bx-folder-open'></i>
            <p>لا يوجد محتوى تعليمي متاح حالياً</p>
        </div>
        @else
        <div class="subjects-grid">
            @foreach($grouped as $subjectId => $items)
            @php
                $subject     = $items->first()->subject;
                $subjectName = $subject->subject_name ?? 'مادة';
                $teacher     = $subject->teacher->full_name ?? null;
                $types       = $items->groupBy('content_type');
                $iconKey     = collect($subjectIcons)->keys()->first(fn($k) => str_contains($subjectName, $k));
                $icon        = $iconKey ? $subjectIcons[$iconKey] : 'bx-book-open';
            @endphp
            <a href="#" class="subject-card"
               onclick="showSubject({{ $subjectId }}, '{{ addslashes($subjectName) }}', event)">

                <div class="subject-icon">
                    <i class='bx {{ $icon }}'></i>
                </div>

                <div class="subject-name">{{ $subjectName }}</div>

                @if($teacher)
                <div class="subject-teacher">
                    <i class='bx bx-user'></i> {{ $teacher }}
                </div>
                @endif

                <div class="subject-types">
                    @foreach($types as $type => $typeItems)
                    <span class="type-chip tc-{{ $type }}">
                        <i class='bx {{ $typeIcons[$type] ?? "bx-file" }}'></i>
                        {{ $typeItems->count() }}
                    </span>
                    @endforeach
                </div>

                <div class="subject-footer">
                    <span class="subject-count">
                        <i class='bx bx-collection'></i>
                        {{ $items->count() }} ملف
                    </span>
                    <span class="subject-arrow">
                        <i class='bx bx-left-arrow-alt'></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ══ محتوى المادة ══ --}}
    <div id="contentPanel" class="content-panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class='bx bx-collection'></i>
                <span id="panelTitle"></span>
            </div>
            <button class="btn-back-panel" onclick="showSubjects()">
                <i class='bx bx-arrow-back'></i> رجوع للمواد
            </button>
        </div>
        <div class="items-grid" id="itemsGrid"></div>
    </div>

</div>
</div>

@php
    $contentJson = $content->map(fn($item) => [
        'id'            => $item->id,
        'subject_id'    => $item->subject_id,
        'title'         => $item->title,
        'description'   => $item->description,
        'content_type'  => $item->content_type,
        'file_url'      => $item->file_path ? asset('storage/'.$item->file_path) : null,
        'external_link' => $item->external_link,
        'created_at'    => $item->created_at?->format('Y/m/d'),
    ]);
@endphp
<script>
const allContent = @json($contentJson);
</script>
<script src="{{ asset('js/parent.js') }}"></script>
</body>
</html>