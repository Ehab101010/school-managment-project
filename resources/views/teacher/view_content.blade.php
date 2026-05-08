<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>المحتوى التعليمي</title>
</head>
<body>

@include('includes.teacher-sidebar')

<div class="content">

    <div class="page-hero hero-primary fade-in">
        <div class="page-hero-inner">
            <div>
                <h1><i class='bx bx-folder-open'></i> المحتوى التعليمي</h1>
                <p>إدارة المواد والملفات التعليمية المشاركة مع طلابك</p>
            </div>
            <div class="page-hero-actions">
                <a href="{{ route('teacher.create-content') }}" class="hero-btn">
                    <i class='bx bx-plus'></i> إضافة محتوى جديد
                </a>
                <div class="hero-icon-wrap"><i class='bx bxs-collection'></i></div>
            </div>
        </div>
    </div>

    <div class="card fade-in">
        <div class="card-header">
            <span class="card-title"><i class='bx bx-collection'></i> قائمة المحتوى</span>
            <span style="font-size:13px; color:var(--text-muted);">{{ count($content) }} عنصر</span>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المادة الدراسية</th>
                        <th>الصف الدراسي</th>
                        <th>العنوان</th>
                        <th>النوع</th>
                        <th>الوصف</th>
                        <th>الملف / الرابط</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($content as $index => $item)
                    <tr>
                        <td style="color:var(--text-muted); font-weight:600;">{{ $index + 1 }}</td>
                        <td style="font-weight:600;">{{ $item->subject->subject_name ?? '---' }}</td>
                        <td>
                            {{ $item->class->class_name ?? '---' }}
                            @if($item->class->section_name ?? false)
                                - {{ $item->class->section_name }}
                            @endif
                            @if($item->class->section_type ?? false)
                                <small style="color:var(--text-muted);">({{ $item->class->section_type }})</small>
                            @endif
                        </td>
                        <td style="font-weight:600; text-align:right; max-width:200px;">{{ $item->title }}</td>
                        <td>
                            @php
                                $badgeMap = [
                                    'video' => ['badge-video','🎬 فيديو'],
                                    'pdf'   => ['badge-pdf','📄 PDF'],
                                    'excel' => ['badge-excel','📊 Excel'],
                                    'assignment' => ['badge-assignment','📝 واجب'],
                                            'powerpoint' => ['badge-powerpoint', '📑 PowerPoint'],
                                    'link'  => ['badge-link','🔗 رابط'],
                                ];
                                $badge = $badgeMap[$item->content_type] ?? ['','---'];
                            @endphp
                            <span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                        </td>
                        <td style="max-width:200px; color:var(--text-muted); font-size:13px;">
                            {{ Str::limit($item->description, 60) }}
                        </td>
                        <td>
                            @if ($item->file_path)
<a href="{{ route('teacher.content.file', $item->id) }}" target="_blank" class="link">
                                    <i class='bx bx-download'></i> فتح الملف
                                </a>
                            @elseif ($item->external_link)
                                <a href="{{ $item->external_link }}" target="_blank" class="link">
                                    <i class='bx bx-link-external'></i> فتح الرابط
                                </a>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn edit" data-id="{{ $item->id }}"
                                    data-subject="{{ $item->subject_id }}"
                                    data-class="{{ $item->class_id }}"
                                    data-title="{{ $item->title }}"
                                    data-type="{{ $item->content_type }}"
                                    data-desc="{{ $item->description }}">
                                    <i class='bx bx-edit'></i> تعديل
                                </button>
                                <form action="{{ route('teacher.content.delete', $item->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn delete" onclick="return confirm('هل تريد حذف هذا المحتوى؟')">
                                        <i class='bx bx-trash'></i> حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding:48px; color:var(--text-muted);">
                            <i class='bx bx-folder-open' style="font-size:40px; display:block; margin-bottom:8px; color:var(--border);"></i>
                            لا يوجد محتوى تعليمي بعد
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
{{-- ── Edit Modal مصحح ── --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title"><i class='bx bx-edit'></i> تعديل المحتوى</span>
            <button type="button" class="modal-close" id="closeModal"><i class='bx bx-x'></i></button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>المادة الدراسية</label>
                <select name="subject_id" id="editSubject">
                    @foreach($content->pluck('subject')->unique('subject_id')->filter() as $sub)
                        <option value="{{ $sub->subject_id }}">{{ $sub->subject_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>عنوان المحتوى</label>
                <input type="text" name="title" id="editTitle" placeholder="أدخل عنوان المحتوى">
            </div>

            <div class="form-group">
                <label>نوع المحتوى</label>
                <select name="content_type" id="editType">
                    <option value="pdf">📄 PDF</option>
                    <option value="excel">📊 Excel</option>
                    <option value="powerpoint">📑 PowerPoint</option>
                    <option value="link">🔗 رابط خارجي</option>
                    <option value="video">🎬 فيديو</option>
                    <option value="assignment">📝 واجب</option>
                </select>
            </div>

            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" id="editDesc" placeholder="اكتب وصفاً..."></textarea>
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn btn-accent">
                    <i class='bx bx-save'></i> حفظ التغييرات
                </button>
                <button type="button" class="btn btn-cancel" id="closeModalBtn">
                    <i class='bx bx-x'></i> إلغاء
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/teacher.js') }}"></script>
</body>
</html>
 