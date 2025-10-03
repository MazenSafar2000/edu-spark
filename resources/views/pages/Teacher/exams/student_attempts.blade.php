@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('Teacher_trans.student_attempts') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">

            <div class="header-attempts-teacher">
                <h3 class="std-attempts-name">{{ trans('Teacher_trans.student_name') }} :
                    <span>{{ $student->user->name }}</span>
                </h3>
                <h3 class="std-attempts-name mb-3">{{ trans('Teacher_trans.exams') }} : <span>{{ $exam->name }}</span></h3>

            </div>
            <div class="table-responsive custom-table-wrapper">
                <table class="text-center custom-grade-table">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Teacher_trans.started') }}</th>
                            <th>{{ trans('Teacher_trans.ended') }}</th>
                            <th>{{ trans('Teacher_trans.status') }}</th>
                            <th>{{ trans('Teacher_trans.score') }}</th>
                            <th>{{ trans('Teacher_trans.operations') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attempts as $index => $attempt)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $attempt->started_at ?? $attempt->created_at }}</td>
                                <td>{{ $attempt->ended_at ?? '-' }}</td>
                                <td>
                                    @if ($attempt->status === 'completed')
                                        <span class="badge bg-success">{{ trans('Teacher_trans.completed') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $attempt->status }}</span>
                                    @endif
                                </td>
                                <td>{{ round($attempt->grade_obtained, 2) }} / {{ $exam->maximum_grade ?? 100 }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle dropdown-toggle-operations"
                                            data-bs-toggle="dropdown">
                                            {{ trans('Teacher_trans.operations') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-operations">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                    href="{{ route('teacher.exams.attemptAnswers', [$exam->id, $student->id, $attempt->id]) }}">
                                                    <i
                                                        class="fas fa-eye action-icon eye-icon-action"></i>{{ trans('Teacher_trans.show_answers') }}
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-lesson{{ $attempt->id }}">
                                                    <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                    {{ trans('Teacher_trans.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            @empty
                                <td class="alert-danger" colspan="5">{{ trans('main_trans.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @foreach ($attempts as $index => $attempt)
                    <!-- delete attempt modal -->
                    <div class="modal fade" id="deleteModal-lesson{{ $attempt->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="{{ trans('main_trans.close') }}"></button>
                                </div>
                                <form action="{{ route('examAttempts.destroy', $attempt->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                        <p>{{ trans('main_trans.Delete_Warning') }}</p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit"
                                            class="btn btn-del">{{ trans('main_trans.submit') }}</button>
                                        <button type="button" class="btn btn-cancel"
                                            data-bs-dismiss="modal">{{ trans('main_trans.close') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
@endsection
