@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">معاينة </span>
                    <span class="preview-title-highlight fw-bold">الواجب</span>
                </h4>
            </div>

            <div class="preview-wrapper p-4">
                <div class="preview-card">
                    <h5 class="exam-title">{{ $homework->title }}</h5>

                    <ul class="list-unstyled exam-description">
                        <li><strong>{{ trans('Students_trans.homework_description') }}
                                :</strong>{{ $homework->description }}</li>
                        <li><strong>{{ trans('Students_trans.subject') }} :</strong>{{ $homework->subject->name }}</li>
                        <li><strong>{{ trans('Students_trans.total_degree') }} :</strong>{{ $homework->total_degree }}</li>
                        <li><strong>{{ trans('Students_trans.Delivery_Deadline') }} :</strong>{{ $homework->due_date }}</li>
                        @if ($homework->attachment_path)
                            <li><strong>{{ trans('Students_trans.Submitted_File') }}:</strong>
                                <a href="{{ asset('storage/attachments/homeworks/teachers/' . $homework->teacher->National_ID . '/' . $homework->attachment_path) }}"
                                    target="_blank" class="btn btn-sm btn-info">
                                    {{ trans('Students_trans.View File') }}
                                </a>
                            </li>
                        @endif

                        @if ($submission)
                            <div class="alert alert-success">{{ trans('Students_trans.you_submit') }}</div>
                            <p><strong>{{ trans('Students_trans.Status') }}:</strong>
                                @if ($submission->is_late)
                                    <span class="badge badge-warning">{{ trans('Students_trans.Late_Submission') }}</span>
                                @else
                                    <span class="badge text-success  badge-success">{{ trans('Students_trans.on_time') }}</span>
                                @endif
                            </p>
                            <p><strong>{{ trans('Students_trans.Submission_Date') }}:</strong>
                                {{ $submission->submitted_at }}</p>
                            @if ($homework->allow_multiple_submissions)
                                <a href="{{ route('student.submissions.create', $homework->id) }}"
                                    class="btn btn-warning btn-sm">{{ __('Students_trans.Resubmit') }}</a>
                            @endif
                            @if ($submission && ($submission->degree !== null || $submission->feedback))
                                <div class="mt-4">
                                    <div class="card border-success shadow-sm">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0">{{ __('Students_trans.Grading_Feedback') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($submission->degree !== null)
                                                <p class="mb-2">
                                                    <strong>{{ __('Students_trans.degree') }}:</strong>
                                                    <span class="badge badge-pill badge-primary px-3 py-2 text-success"
                                                        style="font-size: 16px;">
                                                        {{ $submission->degree }} /
                                                        {{ $homework->total_degree }}
                                                    </span>
                                                </p>
                                            @endif

                                            @if ($submission->feedback)
                                                <p class="mt-3 mb-0">
                                                    <strong>{{ __('Students_trans.Feedback') }}:
                                                    </strong><span> {{ $submission->feedback }}</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="exam-buttons d-flex  gap-3">
                                <a href="{{ route('student.submissions.create', $homework->id) }}" class="btn exam-start-btn">
                                    <i class="fas fa-eye ms-1"></i> تسليم الواجب
                                </a>
                            </div>
                        @endif

                        {{-- <li>
                            <strong>الحالة:</strong>
                            <span class="exam-status">متاح الان للتسليم ينتهي بعد 23 ساعة و52 دقيقة</span>
                        </li> --}}

                    </ul>


                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
@endsection
