@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">{{ trans('Students_trans.exam_details') }}</span>
                </h4>
            </div>

            <div class="container page-wrap py-4">
                @include('components.error-field')
                <!-- Exam Title -->
                <div class="exam-title-preview">
                    <i class="fa fa-pen-to-square"></i>
                    {{ $exam->name }}
                </div>

                <!-- Exam Dates & Info -->
                <div class="header-box mb-3">
                    <div class="header-dates">
                        <div><strong>{{ trans('Students_trans.Opens') }}:
                            </strong>{{ \Carbon\Carbon::parse($exam->start_at)->translatedFormat('l d F Y، h:i A') }}</div>
                        <div><strong>{{ trans('Students_trans.Close') }}:
                            </strong>{{ \Carbon\Carbon::parse($exam->end_at)->translatedFormat('l d F Y، h:i A') }}</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="tiny">
                            {{ $exam->description }}
                        </div>
                    </div>
                </div>

                <!-- Attempts Section -->
                <div class="attempts-section mb-3">
                    <div class="attempts-header">
                        <p class="attempts-count">{{ trans('main_trans.number_attempt') }}: {{ $exam->attempts }}</p>
                        <p class="attempts-count">{{ trans('Students_trans.duration') }}: {{ $exam->duration }}
                            minut/minutes</p>
                        <p class="attempts-count">{{ trans('main_trans.Success_score') }}: {{ $exam->maximum_grade / 2 }}
                            {{ trans('main_trans.Out_of') }} {{ $exam->maximum_grade }}</p>
                    </div>

                    <h5 class="attempts-title">{{ trans('main_trans.your_attempts') }}</h5>

                    <div class="row g-3 attempts-list">
                        @foreach ($examAttempts as $index => $attempt)
                            <div class="col-12 col-md-6 col-lg-4 attempt-item">
                                <div class="attempt-card shadow-sm">
                                    <div class="attempt-card-header">{{ trans('Students_trans.attempt') }}
                                        {{ $index + 1 }}</div>
                                    <div class="attempt-card-body p-0">
                                        <table class="table mb-0 attempt-table">
                                            <tbody>
                                                <tr>
                                                    <th>{{ trans('Students_trans.Status') }}</th>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $attempt->status)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('Students_trans.started') }}</th>
                                                    <td>{{ $attempt->started_at ? \Carbon\Carbon::parse($attempt->started_at)->translatedFormat('l d F Y h:i A') : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('Students_trans.ended') }}</th>
                                                    <td>{{ $attempt->ended_at ? \Carbon\Carbon::parse($attempt->ended_at)->translatedFormat('l d F Y h:i A') : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('Students_trans.duration') }}</th>
                                                    <td>
                                                        @if ($attempt->started_at && $attempt->ended_at)
                                                            @php
                                                                $duration =
                                                                    strtotime($attempt->ended_at) -
                                                                    strtotime($attempt->started_at);
                                                                $minutes = gmdate('i', $duration);
                                                                $seconds = gmdate('s', $duration);
                                                            @endphp

                                                            {{ $minutes }} {{ trans('Students_trans.minutes') }}
                                                            {{ $seconds }} {{ trans('Students_trans.seconds') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>{{ trans('Students_trans.Review') }}</th>
                                                    <td>{{ $exam->sectionExams->first()->show_answers ? $attempt->grade_obtained : trans('Students_trans.not_allowed') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="attempt-footer p-2">
                                        @if ($exam->sectionExams->first()->show_answers)
                                            <a href="{{ route('parent.exam.review', $attempt->id) }}"
                                                class="btn-attempt">{{ trans('Students_trans.questions_review') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
