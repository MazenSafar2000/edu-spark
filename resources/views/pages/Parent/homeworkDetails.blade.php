@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-highlight fw-bold">{{ trans('Students_trans.preview_homework') }}</span>
                </h4>
            </div>

            <div class="container page-wrap py-4">
                <!-- شريط المواعيد -->
                <div class="header-box mb-3">
                    <div class="header-dates">
                        <div><strong>{{ $homework->title }}</strong></div>
                        <hr>
                        <div>
                            <strong>{{ trans('Students_trans.Opens') }}:
                            </strong>{{ $homework->created_at->translatedFormat('l d F Y، h:i A') }}
                        </div>
                        <div>
                            <strong>{{ trans('Students_trans.Close') }}:
                            </strong>{{ $homework->due_date->translatedFormat('l d F Y، h:i A') }}
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="tiny">
                            <p style="white-space: pre-line;">
                                {{ $homework->description }}
                                @if ($homework->attachment_path)
                                    <a class=""
                                        href="{{ asset('storage/attachments/homeworks/teachers/' . $homework->teacher->National_ID . '/' . $homework->attachment_path) }}"
                                        target="_blank">
                                        {{ trans('Teacher_trans.attachment_path') }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- البطاقة -->
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
                                        <td class="text-danger">
                                            @if ($submission && $submission->degree !== null && $submission->show_grade)
                                                <span class="text-success">
                                                    {{ $submission->degree }}
                                                </span>
                                                <br>
                                                <small>
                                                    {{ trans('Students_trans.teacher_feedback') }}:
                                                    {{ $submission->teacher_feedback ?? '-' }}
                                                </small>
                                            @elseif ($submission && $submission->degree !== null && !$submission->show_grade)
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
                                                    href="{{ asset('storage/attachments/homework_submissions/students/' . $submission->student->National_ID . '/' . $submission->file_path) }}"
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


        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
