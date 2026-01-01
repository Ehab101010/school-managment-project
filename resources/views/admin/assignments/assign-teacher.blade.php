<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
@include('includes.admin-sidebar')

     <div class="content">


     <div class="assign-content">
    <h1>تعيين معلم إلى صف دراسي</h1>
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <form class="assign-form" method="POST" action="{{ route('admin.store-assignment') }}">
    @csrf

    <div class="form-group">
        <label for="teacher">     </label>
        <select id="teacher" name="teacher_id" required>
            <option value="">--👨‍🏫 اختر المعلم --</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->teacher_id }}">
                    {{ $teacher->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="class">   </label>
        <select id="class" name="class_id" required>
            <option value="">--🏫 اختر الصف --</option>
            @foreach ($classes as $class)
            <option value="{{ $class->class_id }}">
    {{ $class->full_class_name }}
</option>

            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="subject">       </label>
        <select id="subject" name="subject_id" required>
            <option value="">--📘 اختر المادة --</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->subject_id }}">
                    {{ $subject->subject_name }}
                </option>
            @endforeach
        </select>
    </div>
 

    <div class="assign-buttons">
        <button type="submit" class="btn-assign">تعيين المعلم  </button>
        <button type="reset" class="btn-cancel">إلغاء  </button>
    </div>
</form>
 
 
 
 
</div>

    </div>

    <script src="{{ asset('js/admin.js') }}"></script>


</body>
</html>





