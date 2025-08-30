@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">


        <h3 class="teacher-title2">{{ trans('Teacher_trans.homework_results') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">

            <div class="search-box-student  mb-3 d-flex justify-content-between">
                <input type="search" id="submissionSearch" class="form-control search-input-custom" placeholder="{{ trans('Teacher_trans.search') }}">

                <div class="btn-export-zero d-flex align-items-center">
                    <a href="{{ route('teacher.homework.export', $homework->id) }}" class="btn-export">{{ trans('Teacher_trans.export') }}</a>
                </div>
            </div>


            <div class="table-responsive custom-table-wrapper">
                <table class="text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Students_trans.student_name') }}</th>
                            <th>{{ trans('Students_trans.classrooms') }}</th>
                            <th>{{ trans('Students_trans.section') }}</th>
                            <th>{{ trans('Teacher_trans.submitted_file') }}</th>
                            <th>{{ trans('Teacher_trans.submission_timing') }}</th>
                            <th>{{ trans('Teacher_trans.degree') }}</th>
                            <th>{{ trans('Teacher_trans.operations') }}</th>
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
                                        <a href="{{ asset("storage/attachments/homework_submissions/students/{$student->National_ID}/" . $submission->file_path) }}"
                                            target="_blank">
                                            {{ trans('Students_trans.Download_file') }}
                                        </a>
                                    @else
                                        <span class="text-danger">{{ trans('Teacher_trans.no_submissions') }}</span>
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
                                <td>{{ $submission?->degree ?? '' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2 std-submission-hw">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addGradeModal{{ $student->id }}">
                                            {{ trans('Teacher_trans.grade_homework') }} </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- مودال تقييم الواجب -->
                            <div class="modal fade custom-modal" id="addGradeModal{{ $student->id }}" tabindex="-1"
                                aria-labelledby="addGradeModal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                    <div class="modal-content custom-modal-content">

                                        <!-- رأس المودال -->
                                        <div class="modal-header custom-modal-header">
                                            <h5 class="modal-title custom-modal-title" id="addGradeModal">
                                                {{ trans('Teacher_trans.grade_homework') }}
                                                <span>{{ $student->user->name }}</span>
                                            </h5>
                                        </div>

                                        <!-- جسم المودال -->
                                        <div class="modal-body custom-modal-body">
                                            <form id="gradeHmForm" class="custom-form"
                                                action="{{ route('homework.grade', [$homework->id, $student->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="mb-3 custom-form-group">
                                                    <div class="form-group-float position-relative ">
                                                        <input type="number" name="degree"
                                                            class="form-control custom-input float-input"
                                                            value="{{ $submission?->degree ?? '' }}"
                                                            max="{{ $homework->total_degree }}" min="0"
                                                            placeholder=" " />
                                                        <label for=""
                                                            class="float-label">{{ trans('Teacher_trans.degree') }}</label>
                                                    </div>
                                                </div>

                                                <div class="mb-3 custom-form-group">
                                                    <textarea class="form-control custom-textarea" name="feedback" rows="4"
                                                        placeholder="{{ trans('Teacher_trans.Feedback') }}">{{ $submission?->feedback ?? '' }}</textarea>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- تذييل المودال -->
                                        <div class="modal-footer custom-modal-footer">
                                            <button type="submit" class="btn btn-primary custom-save-btn"
                                                form="gradeHmForm">تقييم</button>
                                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                data-bs-dismiss="modal">إلغاء</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6">{{ trans('Teacher_trans.no_students') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $students->links('vendor.pagination.custom') }}

            </div>
        </div>

    </div>
    {{-- search input code --}}
    <script>
        document.getElementById('submissionSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('datatable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
