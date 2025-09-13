@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">{{ trans('Students_trans.preview_homework') }}</span>
                </h4>
            </div>

            <div class="container page-wrap py-4">
                <div class="header-box mb-3">
                    <div class="header-dates">
                        <div>{{ $homework->title }}</div>
                        <hr>
                        <div><strong>{{ trans('Students_trans.Opens') }}:
                            </strong>{{ $homework->created_at->translatedFormat('l d F Y، h:i A') }}</div>
                        <div><strong>{{ trans('Students_trans.Close') }}:
                            </strong>{{ $homework->due_date->translatedFormat('l d F Y، h:i A') }}</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="tiny">
                            <p style="white-space: pre-line;">

                                {{ $homework->description }}

                                @if ($homework->attachment_path)
                                    <a class=""
                                        href="{{ asset('storage/attachments/homeworks/teachers/' . $homework->teacher->user->National_ID . '/' . $homework->attachment_path) }}"
                                        target="_blank">
                                        {{ trans('Teacher_trans.attachment_path') }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="action-btn d-flex gap-2">
                    @php
                        $now = now();
                        $duePassed = $now->gt($homework->due_date);
                    @endphp

                    @php
                        $now = now();
                        $deadline = \Carbon\Carbon::parse($homework->due_date);

                        $hasSubmission = $submission ? true : false;
                        $allowMultiple = $homework->allow_multiple_submissions;
                        $beforeDeadline = $now->lte($deadline);
                    @endphp



                    @if ($hasSubmission)
                        {{-- Case 1: Student already submitted --}}
                        @if ($allowMultiple && $beforeDeadline)
                            {{-- 1A: Multiple allowed, still before deadline → can resubmit --}}
                            <a href="{{ route('student.submissions.create', $homework->id) }}" class="btn action-btn-edit">
                                {{ trans('Students_trans.Resubmit') }}
                            </a>
                        @elseif($allowMultiple && !$beforeDeadline)
                            {{-- 1B: Multiple allowed, after deadline → cannot resubmit --}}
                            <button class="action-btn-edit" disabled>
                                {{ trans('Students_trans.Resubmit') }}
                            </button>
                        @else
                            {{-- 1C: Multiple NOT allowed → cannot resubmit --}}
                            <button class="action-btn-edit" disabled>
                                {{ trans('Students_trans.Submitted') }}
                            </button>
                        @endif
                    @else
                        {{-- Case 2: Student has NOT submitted yet --}}
                        @if ($allowMultiple && $beforeDeadline)
                            {{-- 2A: Not submitted, multiple allowed, before deadline → can submit normally --}}
                            <a href="{{ route('student.submissions.create', $homework->id) }}" class="btn action-btn-edit">
                                {{ trans('Students_trans.Submit') }}
                            </a>
                        @elseif($allowMultiple && !$beforeDeadline)
                            {{-- 2B: Not submitted, multiple allowed, after deadline → submit late --}}
                            <a href="{{ route('student.submissions.create', $homework->id) }}" class="btn btn-danger">
                                {{ trans('Students_trans.Submit_late') }}
                            </a>
                        @elseif(!$allowMultiple && $beforeDeadline)
                            {{-- 2C: Not submitted, multiple NOT allowed, before deadline → normal submit --}}
                            <a href="{{ route('student.submissions.create', $homework->id) }}" class="btn action-btn-edit">
                                {{ trans('Students_trans.Submit') }}
                            </a>
                        @elseif(!$allowMultiple && !$beforeDeadline)
                            {{-- 2D: Not submitted, multiple NOT allowed, after deadline → submit late --}}
                            <a href="{{ route('student.submissions.create', $homework->id) }}" class="btn btn-danger">
                                {{ trans('Students_trans.Submit_late') }}
                            </a>
                        @endif
                    @endif
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table status-table">
                                <tbody>
                                    <tr>
                                        <th>{{ trans('Students_trans.delivery_status') }}</th>
                                        <td>
                                            @if ($submission)
                                                <span
                                                    class="status-badge text-success">{{ trans('Students_trans.Submitted') }}</span>
                                            @else
                                                <span
                                                    class="status-badge text-danger">{{ trans('Students_trans.Not_Submitted') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('Students_trans.evaluation_status') }}</th>
                                        <td>
                                            @if ($submission && $submission->degree !== null && $homework->show_grade)
                                                <span class="text-success">
                                                    {{ $submission->degree }} / {{ $homework->total_degree }}
                                                </span>
                                                <br>
                                                <small class="text-success">
                                                    {{ trans('Students_trans.teacher_feedback') }}:
                                                    {{ $submission->feedback ?? '-' }}
                                                </small>
                                            @elseif ($submission && $submission->degree !== null && !$homework->show_grade)
                                                <span class="text-dark">{{ trans('Students_trans.graded') }}</span>
                                            @else
                                                <span class="text-dark">{{ trans('Students_trans.Not_Graded_Yet') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('Students_trans.time_remaining') }}</th>
                                        <td class="text-success">
                                            @php
                                                $now = now();
                                                $deadline = $homework->due_date;
                                            @endphp

                                            @if ($submission && $submission->submitted_at)
                                                {{-- Student submitted --}}
                                                @if ($submission->submitted_at->lt($deadline))
                                                    {{-- Submitted before deadline --}}
                                                    @php
                                                        $diff = $deadline->diff($submission->submitted_at);
                                                    @endphp
                                                    <span class="text-success">
                                                        {{ trans('Students_trans.turned') }}
                                                        {{ $diff->d }} {{ trans('Students_trans.days') }}
                                                        {{ $diff->h }} {{ trans('Students_trans.hours') }}
                                                        {{ $diff->i }} {{ trans('Students_trans.minutes') }}
                                                        {{ trans('Students_trans.early') }}
                                                    </span>
                                                @else
                                                    {{-- Submitted after deadline --}}
                                                    @php
                                                        $diff = $submission->submitted_at->diff($deadline);
                                                    @endphp
                                                    <span class="text-danger">
                                                        {{ trans('Students_trans.turned') }}
                                                        {{ $diff->d }} {{ trans('Students_trans.days') }}
                                                        {{ $diff->h }} {{ trans('Students_trans.hours') }}
                                                        {{ $diff->i }} {{ trans('Students_trans.minutes') }}
                                                        {{ trans('Students_trans.late') }}
                                                    </span>
                                                @endif
                                            @else
                                                {{-- Student did NOT submit --}}
                                                @if ($now->lt($deadline))
                                                    {{-- Before deadline --}}
                                                    @php
                                                        $diff = $deadline->diff($now);
                                                    @endphp
                                                    <span class="text-success">
                                                        {{ trans('Students_trans.remaining') }}
                                                        {{ $diff->d }} {{ trans('Students_trans.days') }}
                                                        {{ $diff->h }} {{ trans('Students_trans.hours') }}
                                                        {{ $diff->i }} {{ trans('Students_trans.minutes') }}
                                                    </span>
                                                @else
                                                    {{-- After deadline --}}
                                                    @php
                                                        $diff = $now->diff($deadline);
                                                    @endphp
                                                    <span class="text-danger">
                                                        {{ trans('Students_trans.ended_since') }}
                                                        {{ $diff->d }} {{ trans('Students_trans.days') }}
                                                        {{ $diff->h }} {{ trans('Students_trans.hours') }}
                                                        {{ $diff->i }} {{ trans('Students_trans.minutes') }}
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>{{ trans('Students_trans.Submitted_File') }}</th>
                                        <td class="align-items-center gap-2">
                                            @if ($submission && $submission->file_path)
                                                <span
                                                    class="muted">{{ $submission->submitted_at->translatedFormat('h:i A، d F Y') }}</span>

                                                <a class="file-pill"
                                                    href="{{ asset('storage/attachments/homework_submissions/students/' . $submission->student->user->National_ID . '/' . $submission->file_path) }}"
                                                    target="_blank">
                                                    {{ trans('Teacher_trans.download') }}
                                                </a>
                                            @else
                                                {{ trans('Students_trans.no_files') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('Students_trans.your_notes') }}</th>
                                        <td>{{ $submission->notes ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
