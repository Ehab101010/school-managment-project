<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

@include('includes.student-sidebar')

<div class="content content-container">
    <h1> المحتوى التعليمي</h1>
<div class="content-table">
    <table >
        <thead>
            <tr>
                <th>#</th>
                <th>المادة الدراسية</th>
                <th>الصف الدراسي</th>
                <th>العنوان</th>
                <th>النوع</th>
                <th>الوصف</th>
                <th>الملف / الرابط</th>
            </tr>
        </thead>

        <tbody>
        @foreach($content as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->subject->subject_name ?? '---' }}</td>

                 <td>{{ $student->class->class_name }}</td>

                <td>{{ $item->title }}</td>

                 <td>{{ $item->content_type }}</td>

                <td>{{ $item->description }}</td>

                 <td>
                    @if($item->file_path)
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank">
                            فتح الملف
                        </a>
                    @elseif($item->external_link)
                        <a href="{{ $item->external_link }}" target="_blank">
                            رابط خارجي
                        </a>
                    @else
                        ---
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    </div>
</div>

<script src="{{ asset('js/student.js') }}"></script>

</body>
</html>
