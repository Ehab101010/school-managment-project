<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/teacher.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.teacher-sidebar')
    <div class="content content-container">
        <h1>  المحتوى التعليمي</h1>
 
        <table class="content-table">
            <thead>
                <tr>
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
@foreach ($content as $item)
    <tr>
 
        <td>{{ $item->subject->subject_name ?? '---' }}</td>
        <td>
    {{ $item->class->class_name ?? '---' }}
    -
    {{ $item->class->section_name ?? '' }}
    ({{ $item->class->section_type ?? '' }})
</td>

        <td>{{ $item->title }}</td>
        <td>{{ $item->content_type }}</td>
        <td>{{ $item->description }}</td>

        <td>
            @if ($item->file_path)
            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="link">
      فتح الملف
</a>
            @elseif ($item->external_link)
                <a href="{{ $item->external_link }}" target="_blank" class="link">فتح الرابط</a>
            @else
                ---
            @endif
        </td>

        <td>
            <button class="btn edit">تعديل</button>

            <form action="{{ route('teacher.content.delete', $item->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn delete" onclick="return confirm('هل تريد الحذف؟')">حذف</button>
            </form>
        </td>
    </tr>
@endforeach
</tbody>

        </table>
    </div>
    
 <div class="modal-overlay" id="editModal">
    <div class="modal">
        <h2>✏️ تعديل المحتوى</h2>

        <form class="edit-content-form">
            <div class="form-group">
                <label>المادة الدراسية</label>
                <select>
                    <option>الرياضيات</option>
                    <option>العلوم</option>
                    <option>اللغة العربية</option>
                    <option>اللغة الإنجليزية</option>
                </select>
            </div>

            <div class="form-group">
                <label>الصف الدراسي</label>
                <select>
                    <option>الصف الأول</option>
                    <option>الصف الثاني</option>
                    <option>الصف الثالث</option>
                </select>
            </div>

            <div class="form-group">
                <label>عنوان المحتوى</label>
                <input type="text" placeholder="أدخل عنوان المحتوى">
            </div>

            <div class="form-group">
                <label>نوع المحتوى</label>
                <select>
                    <option>درس</option>
                    <option>فيديو</option>
                    <option>ملف</option>
                    <option>رابط خارجي</option>
                    <option>واجب</option>
                </select>
            </div>

            <div class="form-group">
                <label>الوصف</label>
                <textarea placeholder="اكتب وصفًا مختصرًا للمحتوى..."></textarea>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn save">💾 حفظ التغييرات</button>
                <button type="button" class="btn cancel" id="closeModal">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/teacher.js') }}"></script>
    </body>
</html>
