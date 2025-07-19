@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher2">
                        <h3 class="teacher-title2">تقييم الواجب</h3>
                        <input type="search" class="form-control search-input" placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table-teacher">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Students_trans.student_name') }}</th>
                                    <th>{{ trans('Students_trans.classrooms') }}</th>
                                    <th>{{ trans('Students_trans.section') }}</th>
                                    <th>{{ trans('Teacher_trans.submitted_file') }}</th>
                                    <th>{{ trans('Teacher_trans.submission_timing') }}</th>
                                    <th>{{ trans('Teacher_trans.degree') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    @php
                                        $submission = $student->submissions->firstWhere('homework_id', $homework->id);
                                        $submittedAt = optional($submission)->submitted_at;
                                        $deadline = \Carbon\Carbon::parse($homework->due_date);
                                    @endphp
                                    <tr @if ($submission && $submission->degree !== null) class="table-success" @endif>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->classroom->Name_Class }}</td>
                                        <td>{{ $student->section->Name_Section }}</td>
                                        <td>
                                            @if ($submission && $submission->file_path)
                                                <a href="{{ asset("storage/attachments/homework_submissions/students/{$student->National_ID}/". $submission->file_path) }}" target="_blank">
                                                    {{ trans('Students_trans.Download_file') }}
                                                </a>
                                            @else
                                                <span
                                                    class="text-danger">{{ trans('Teacher_trans.no_submissions') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($submission && $submission->file_path && $submittedAt)
                                                @if ($submittedAt->gt($deadline))
                                                    <span class="text-danger">{{ __('Late by') }}
                                                        {{ $submittedAt->diff($deadline)->format('%d days %h hours %i minutes') }}
                                                    </span>
                                                @else
                                                    <span class="text-success">{{ __('Early by') }}
                                                        {{ $deadline->diff($submittedAt)->format('%d days %h hours %i minutes') }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-muted">{{ trans('Teacher_trans.no_submissions') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#gradeModal-{{ $student->id }}">
                                                {{ trans('Teacher_trans.grade_homework') }}
                                            </button>


                                        </td>
                                    </tr>

                                    <!-- grade homework modal -->
                                    <div class="modal fade" id="gradeModal-{{ $student->id }}" tabindex="-1"
                                        aria-labelledby="gradeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">

                                            <form
                                                action="{{ route('homework.grade', [$homework->id, $student->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="gradeModalLabel-{{ $student->id }}">
                                                            {{ trans('Teacher_trans.grade_homework') }} -
                                                            {{ $student->user->name }}
                                                        </h5>
                                                        <button type="button" class="close text-white"
                                                            data-bs-dismiss="modal" aria-bs-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>{{ trans('Teacher_trans.degree') }}</label>
                                                            <input type="number" name="degree" class="form-control"
                                                                value="{{ $submission?->degree ?? '' }}"
                                                                max="{{ $homework->total_degree }}" min="0"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{ trans('Teacher_trans.Feedback') }}</label>
                                                            <textarea name="feedback" rows="4" class="form-control">{{ $submission?->feedback ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ trans('Teacher_trans.Close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-success">{{ trans('Teacher_trans.Save_changes') }}</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ trans('Teacher_trans.no_students') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
