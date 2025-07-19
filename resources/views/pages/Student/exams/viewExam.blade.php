@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">معاينة </span>
                    <span class="preview-title-highlight fw-bold">الاختبار</span>
                </h4>
            </div>

            <div class="preview-wrapper p-4">
                <div class="preview-card">
                    <h5 class="exam-title">{{ $exam->name }}</h5>

                    <ul class="list-unstyled exam-description">
                        {{-- <li><strong> اسم الاختبار :</strong> اختبار لغة عربية </li> --}}
                        <li><strong>{{ trans('Students_trans.subject') }} :</strong>{{ $exam->subject->name ?? '-' }}</li>
                        <li><strong>{{ trans('Students_trans.duration') }} :</strong>{{ $exam->duration }} دقيقة</li>
                        <li><strong>{{ trans('Students_trans.start_at') }}
                                :</strong>{{ \Carbon\Carbon::parse($exam->start_at)->format('Y-m-d g:i A') }}</li>
                        <li><strong>{{ trans('Students_trans.end_at') }}
                                :</strong>{{ \Carbon\Carbon::parse($exam->end_at)->format('Y-m-d g:i A') }}</li>
                        <li>
                            <strong>{{ trans('Students_trans.Status') }}:</strong>
                            {{-- <span class="exam-status">متاح الان للتقديم، ينتهي بعد 23 ساعة و52 دقيقة</span> --}}
                            @php
                                $now = now();
                                $start = \Carbon\Carbon::parse($exam->start_at);
                                $end = \Carbon\Carbon::parse($exam->end_at);
                            @endphp

                            @if ($now->lt($start))
                                <span class="text-warning">@php
                                    $diffStart = $now->diff($start);
                                @endphp
                                    يبدأ بعد
                                    {{ $diffStart->h > 0 ? $diffStart->h . ' ساعة و ' : '' }}{{ $diffStart->i }}
                                    دقيقة
                                </span>
                            @elseif($now->between($start, $end))
                                <span class="text-success">@php
                                    $diffEnd = $now->diff($end);
                                @endphp
                                    متاح الآن (ينتهي بعد
                                    {{ $diffEnd->h > 0 ? $diffEnd->h . ' ساعة و ' : '' }}{{ $diffEnd->i }}
                                    دقيقة)
                                </span>
                            @else
                                <span class="text-danger">انتهى</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            @php
                                $now = now();
                                $can_start = $now >= $exam->start_at && $now <= $exam->end_at;
                            @endphp

                            @if ($studentDegree)
                                <strong>{{ trans('Students_trans.degree') }} : </strong>
                                {{ $studentDegree->score }}

                                @if (!empty($studentDegree->feedback))
                                    <div class="mt-2">
                                        <strong>{{ trans('Teacher_trans.Feedback') }}:</strong>
                                        <div class="alert alert-info mt-1 mb-0">
                                            {{ $studentDegree->feedback }}
                                        </div>
                                    </div>
                                @endif
                            @else
                                @if ($now->between($exam->start_at, $exam->end_at))
                                    {{-- <a href="{{ route('student_exams.show', $exam->id) }}"
                                        class="btn btn-outline-success w-100" role="button" aria-pressed="true"
                                        onclick="alertAbuse()">
                                        <i class="fas fa-person-booth"></i>
                                    </a> --}}
                                    <a href="{{ route('student.exam.start', $exam->id) }}" class="btn exam-start-btn">
                                        <i class="fas fa-eye ms-1"></i> محاولة أداء الاختبار
                                    </a>
                                @else
                                    {{-- <button class="btn btn-secondary btn-sm" disabled>
                                        {{ trans('Students_trans.not_available') }}
                                    </button> --}}
                                @endif
                            @endif

                        </li>
                    </ul>

                    {{-- <div class="exam-buttons d-flex gap-3">
                        <a href="student-exam.html" class="btn exam-start-btn">
                            <i class="fas fa-eye ms-1"></i> محاولة أداء الاختبار
                        </a>

                    </div> --}}
                </div>
            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
    <br><br><br><br>
@endsection
