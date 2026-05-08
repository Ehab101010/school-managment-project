<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درجات - {{ $child->full_name }}</title>
    <link rel="stylesheet" href="{{ asset('css/parent.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>

@include('includes.parent-sidebar')

<div class="content">
    <div class="dashboard-wrapper">

        {{-- ترويسة الطالب --}}
        <div class="student-header">
            <div class="student-avatar">
                <i class='bx bxs-user-circle'></i>
            </div>
            <div class="student-info">
                <h2>{{ $child->full_name }}</h2>
                <div class="student-badges">
                    <span class="student-badge">
                        <i class='bx bxs-buildings'></i>
                        {{ $child->class->class_name ?? 'غير محدد' }}
                    </span>
                    <span class="student-badge">
                        <i class='bx bxs-group'></i>
                        {{ $child->class->section_name ?? 'غير محدد' }}
                    </span>
                </div>
            </div>
            <a href="{{ route('parent.clear-child') }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                تغيير الابن
            </a>
        </div>

        @if($grades->count() > 0)

        {{-- بطاقات الملخص --}}
        <div class="summary-cards">
            <div class="summary-card">
                <div class="sc-icon blue"><i class='bx bx-book-open'></i></div>
                <div class="sc-value">{{ $grades->count() }}</div>
                <div class="sc-label">عدد المواد</div>
            </div>
 
            <div class="summary-card">
                <div class="sc-icon yellow"><i class='bx bxs-star'></i></div>
                <div class="sc-value">
                    {{ number_format($grades->sum(fn($g) => ($g->first_exam ?? 0) + ($g->second_exam ?? 0) + ($g->activity ?? 0) + ($g->final_exam ?? 0)) / $grades->count(), 1) }}
                </div>
                <div class="sc-label">متوسط المجموع</div>
                <div class="sc-max">من 100</div>
            </div>
            <div class="summary-card">
                <div class="sc-icon purple"><i class='bx bxs-trophy'></i></div>
                @php
                    $bestGrade = $grades->sortByDesc('final_exam')->first();
                @endphp
                <div class="sc-value">{{ $bestGrade->final_exam ?? '-' }}</div>
                <div class="sc-label">أعلى درجة نهائية</div>
                <div class="sc-max">{{ $bestGrade->subject->subject_name ?? '' }}</div>
            </div>
        </div>

        {{-- جدول الدرجات --}}
        <div class="grades-table-wrapper">
            <div class="grades-table-header">
                <h3>
                    <i class='bx bxs-bar-chart-alt-2'></i>
                    تفاصيل الدرجات
                </h3>
                <span class="grades-count">{{ $grades->count() }} مادة</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>المادة</th>
                        <th>اختبار أول<br><small style="font-weight:400;opacity:0.7">/15</small></th>
                        <th>اختبار ثاني<br><small style="font-weight:400;opacity:0.7">/15</small></th>
                        <th>نشاط<br><small style="font-weight:400;opacity:0.7">/20</small></th>
                        <th>نهائي<br><small style="font-weight:400;opacity:0.7">/50</small></th>
                        <th>المجموع<br><small style="font-weight:400;opacity:0.7">/100</small></th>
                        <th>التقدير</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $grade)
                    @php
                        $total = ($grade->first_exam ?? 0)
                               + ($grade->second_exam ?? 0)
                               + ($grade->activity ?? 0)
                               + ($grade->final_exam ?? 0);
                        $pct = $total; // المجموع من 100 مباشرة

                        if ($pct >= 90)      { $status = 'excellent'; $label = 'ممتاز'; }
                        elseif ($pct >= 75)  { $status = 'good';      $label = 'جيد جداً'; }
                        elseif ($pct >= 60)  { $status = 'average';   $label = 'جيد'; }
                        else                 { $status = 'weak';      $label = 'ضعيف'; }
                    @endphp
                    <tr>
                        {{-- المادة --}}
                        <td>
                            <div class="subject-name">
                                <div class="subject-icon">
                                    <i class='bx bxs-book'></i>
                                </div>
                                <span>{{ $grade->subject->subject_name ?? 'غير محدد' }}</span>
                            </div>
                        </td>

                        {{-- اختبار أول --}}
                        <td>
                            <div class="grade-cell">
                                <span class="grade-val">{{ $grade->first_exam ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- اختبار ثاني --}}
                        <td>
                            <div class="grade-cell">
                                <span class="grade-val">{{ $grade->second_exam ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- نشاط --}}
                        <td>
                            <div class="grade-cell">
                                <span class="grade-val">{{ $grade->activity ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- نهائي --}}
                        <td>
                            <div class="grade-cell">
                                <span class="grade-val">{{ $grade->final_exam ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- المجموع مع شريط --}}
                        <td>
                            <div class="grade-bar-wrap">
                         
                                    <span class="grade-pct {{ $status }}">{{ $total }}</span>
                             </div>
                        </td>

                        {{-- التقدير --}}
                        <td>
                            <span class="badge-grade {{ $status }}">{{ $label }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        {{-- لا توجد درجات --}}
        <div class="grades-table-wrapper">
            <div class="empty-state">
                <i class='bx bx-bar-chart-alt'></i>
                <p>لا توجد درجات مسجلة حتى الآن</p>
            </div>
        </div>
        @endif

    </div>
</div>

<script src="{{ asset('js/parent.js') }}"></script>
</body>
</html>