@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="teacher-title">{{ trans('Teacher_trans.question_list') }}: {{ $exam->name }}</h3>

        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a href="{{ route('questions.show', $exam->id) }}">{{ trans('Teacher_trans.add_new_question') }}</a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('Teacher_trans.search') }}">
                    </div>

                    <div class="table-responsive">
                        <table class="table text-center custom-user-table-teacher">
                            <thead class="thead-user">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ trans('Teacher_trans.question') }}</th>
                                    <th scope="col">{{ trans('Teacher_trans.answers') }}</th>
                                    <th scope="col">{{ trans('Teacher_trans.right_answer') }}</th>
                                    <th scope="col">{{ trans('Teacher_trans.degree') }}</th>
                                    {{-- <th scope="col">{{ trans('Teacher_trans.quizz_name') }}</th> --}}
                                    <th scope="col">{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $question->title }}</td>
                                        <td>{{ $question->answers }}</td>
                                        <td>{{ $question->right_answer }}</td>
                                        <td>{{ $question->score }}</td>
                                        {{-- <td>{{ $question->quizze->name }}</td> --}}
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">


                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('questions.edit', $question->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-question{{ $question->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal حذف الطالب -->
                                    <div class="modal fade" id="deleteModal-question{{ $question->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
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

            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
