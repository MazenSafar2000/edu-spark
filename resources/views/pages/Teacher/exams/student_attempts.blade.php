@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container mt-4">
            <h3>محاولات الطالب: {{ $student->name }}</h3>
            <p>الاختبار: <strong>{{ $exam->name }}</strong></p>

            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>تاريخ البداية</th>
                        <th>تاريخ الانتهاء</th>
                        <th>الحالة</th>
                        <th>الدرجة المحققة</th>
                        {{-- <th>time taking</th> --}}
                        <th>operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attempts as $index => $attempt)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $attempt->started_at ?? $attempt->created_at }}</td>
                            <td>{{ $attempt->ended_at ?? '-' }}</td>
                            <td>
                                @if ($attempt->status === 'completed')
                                    <span class="badge bg-success">مكتمل</span>
                                @else
                                    <span class="badge bg-warning">{{ $attempt->status }}</span>
                                @endif
                            </td>
                            <td>{{ round($attempt->grade_obtained, 2) }} / {{ $exam->maximum_grade ?? 100 }}</td>
                            {{-- <td>
                                @if ($attempt->ended_at && $attempt->started_at)
                                    {{ $attempt->started_at->DiffInRealMinutes($attempt->ended_at) }}
                                @else
                                    -
                                @endif
                            </td> --}}
                            <td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle dropdown-toggle-operations" data-bs-toggle="dropdown">
                                        العمليات
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-operations">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                href="{{ route('teacher.exams.attemptAnswers', [$exam->id, $student->id, $attempt->id]) }}">
                                                <i class="fas fa-edit"></i> show answers
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-attempt{{ $attempt->id }}">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                {{ trans('main_trans.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>


                        <!-- delet book modal -->
                        <div class="modal fade" id="deleteModal-attempt{{ $attempt->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->

                                <form action="{{ route('examAttempts.destroy', $attempt->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                            <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="submit"
                                                class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                            <button type="button" class="btn btn-cancel"
                                                data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
