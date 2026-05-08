{{-- resources/views/student/view-content-stu.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المحتوى التعليمي — بوابة الطالب</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>
<body>

@include('includes.student-sidebar')

<div class="content">

    <div class="page-topbar fade-in">
        <div class="page-title-group">
            <h1><i class='bx bx-book-open'></i> المحتوى التعليمي</h1>
            <div class="breadcrumb">
                <span>الرئيسية</span>
                <i class='bx bx-chevron-left'></i>
                <span>المحتوى التعليمي</span>
            </div>
        </div>
    </div>

    {{-- Subjects View --}}
    <div id="subjectsView">
        @php
            $grouped   = collect($content)->groupBy('subject_id');
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

                <div class="subject-icon"><i class='bx {{ $icon }}'></i></div>
                <div class="subject-name">{{ $subjectName }}</div>

                @if($teacher)
                <div class="subject-teacher"><i class='bx bx-user'></i> {{ $teacher }}</div>
                @endif

                <div class="subject-types">
                    @foreach($types as $type => $typeItems)
                    <span class="type-chip tc-{{ $type }}">
                        <i class='bx {{ $typeIcons[$type] ?? "bx-file" }}'></i> {{ $typeItems->count() }}
                    </span>
                    @endforeach
                </div>

                <div class="subject-footer">
                    <span class="subject-count"><i class='bx bx-collection'></i> {{ $items->count() }} ملف</span>
                    <span class="subject-arrow"><i class='bx bx-left-arrow-alt'></i></span>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Content Panel --}}
    <div id="contentPanel" class="content-panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class='bx bx-collection'></i>
                <span id="panelTitle">المادة</span>
            </div>
            <button class="btn-back-panel" onclick="showSubjects()">
                <i class='bx bx-arrow-back'></i> رجوع للمواد
            </button>
        </div>
        <div class="items-grid" id="itemsGrid"></div>
    </div>

</div>

{{-- Pass JSON data to JS cleanly --}}
@php
    $contentJson = collect($content)->map(fn($item) => [
        'id'            => $item->id,
        'subject_id'    => $item->subject_id,
        'title'         => $item->title,
        'description'   => $item->description,
        'content_type'  => $item->content_type,
'file_url' => $item->file_path ? route('student.content.file', $item->id) : null,
        'external_link' => $item->external_link,
        'created_at'    => $item->created_at?->format('Y/m/d'),
    ]);
@endphp

{{-- Hidden element carries JSON, student.js reads it --}}
<script id="allContentData" type="application/json">@json($contentJson)</script>

<script src="{{ asset('js/student.js') }}"></script>
</body>
</html>
