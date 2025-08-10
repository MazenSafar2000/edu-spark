@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container my-5 subject-content-container">

            <!-- عنوان المادة والمعلم -->
            <div class="d-flex justify-content-between align-items-center mb-4 classroom-header">
                {{-- <div class="classroom-title me-3">
                    <h5 class="fw-bold classroom-name">{{ $section->My_classs->Name_Class }}<span class="section-name">
                            -{{ $section->Name_Section }}- </span></h5>
                    <h3 class="subject-name ">{{ $teacher_section->subject->name }}</h3>
                </div> --}}

                <div class="dropdown">
                    <button class="btn operations-btn-subject dropdown-toggle" type="button" id="operationsDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ trans('main_trans.add') }}
                    </button>
                    <ul class="dropdown-menu operations-dropdown-subject text-end" aria-labelledby="operationsDropdown">

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewBook', $teacher_section->id) }}">
                                </i> {{ trans('Students_trans.Book') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewExam', $teacher_section->id) }}">
                                {{ trans('Students_trans.exam') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewHomework', $teacher_section->id) }}">
                                {{ trans('Students_trans.Homework') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewRecordedClass', $teacher_section->id) }}">
                                {{ trans('Teacher_trans.recorded_classe') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="teacher-forms/teacher-add-meet-auto.html">
                                {{ trans('Teacher_trans.Onlineclass') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-content-subject">
                @foreach ($materials as $material)
                    @if ($material['type'] == 'book')
                        <div class="card shadow-sm mb-3 content">
                            <div
                                class="card-body d-flex justify-content-between align-items-center flex-wrap content-card-body">
                                <div class="assignment-info">
                                    <p class="mb-3 fw-bold content-title">{{ $material['title'] }}</p>
                                    <h6 class="text-muted content-date">{{ $material['created_at'] }}</h6>
                                </div>

                                <div class="dropdown">
                                    <button class="btn operations-btn dropdown-toggle" type="button"
                                        id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ trans('main_trans.operations') }}
                                    </button>
                                    <ul class="dropdown-menu operations-dropdown text-end"
                                        aria-labelledby="operationsDropdown">

                                        <li>
                                            <a target="_blank"
                                                class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="{{ asset('storage/attachments/library/teachers/' . Auth::user()->teacher->National_ID . '/' . $material['data']->file_name) }}">
                                                <i class="fa-solid fa-download action-icon download-icon-action"></i>
                                                {{ trans('Teacher_trans.download') }}
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="{{ route('library.edit', $material['data']->id) }}">
                                                <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                {{ trans('main_trans.edit') }}
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-book{{ $material['data']->id }}">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                {{ trans('main_trans.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- delet book modal -->
                        <div class="modal fade" id="deleteModal-book{{ $material['data']->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->

                                <form action="{{ route('library.destroy', $material['data']->id) }}" method="POST">
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
                    @elseif($material['type'] == 'homework')
                        <div class="card shadow-sm mb-3 content">
                            <div
                                class="card-body d-flex justify-content-between align-items-center flex-wrap content-card-body">
                                <div class="assignment-info">
                                    <p class="mb-3 fw-bold content-title">{{ $material['title'] }}</p>
                                    <h6 class="text-muted content-date">{{ $material['created_at'] }}</h6>
                                </div>
                                <div class="dropdown">
                                    <button class="btn operations-btn dropdown-toggle" type="button"
                                        id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ trans('main_trans.operations') }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end operations-dropdown text-end"
                                        aria-labelledby="operationsDropdown">


                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="teacher-hw-submissions.html">
                                                <i class="fas fa-users students-icon action-icon std-icon-action"></i>
                                                الطلاب
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="{{ route('homeworks.edit', $material['data']->id) }}">
                                                <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                {{ trans('main_trans.edit') }}
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-hw{{ $material['data']->id }}">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                {{ trans('main_trans.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--  delete homework modal  -->
                        <div class="modal fade" id="deleteModal-hw{{ $material['data']->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('homeworks.destroy', $material['data']->id) }}" method="POST">
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
                    @elseif($material['type'] == 'exam')
                        <div class="card shadow-sm mb-3 content">
                            <div
                                class="card-body d-flex justify-content-between align-items-center flex-wrap content-card-body">
                                <div class="assignment-info">
                                    <p class="mb-3 fw-bold content-title">{{ $material['title'] }}</p>
                                    <h6 class="text-muted content-date">{{ $material['created_at'] }}</h6>
                                </div>
                                <div class="dropdown">
                                    <button class="btn operations-btn dropdown-toggle" type="button"
                                        id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ trans('main_trans.operations') }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end operations-dropdown text-end"
                                        aria-labelledby="operationsDropdown">

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="{{ route('exams.edit', $material['data']->id) }}">
                                                <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                {{ trans('main_trans.edit') }}
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteExamModal-exam{{ $material['data']->id }}">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                {{ trans('delet') }}
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="{{ route('exams.show', $material['data']->id) }}">
                                                <i class="fas fa-question-circle action-icon question-icon-action"></i>
                                                {{ trans('Teacher_trans.Show_questions') }}
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="">
                                                <i class="fas fa-users students-icon action-icon std-icon-action"></i>
                                                {{ trans('Teacher_trans.Display_Tested_Students') }}
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- delete exam modal   -->
                        <div class="modal fade" id="deleteExamModal-exam{{ $material['data']->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('exams.destroy', $material['data']->id) }}" method="POST">
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
                    @elseif($material['type'] == 'recorded')
                        <div class="card shadow-sm mb-3 content">
                            <div
                                class="card-body d-flex justify-content-between align-items-center flex-wrap content-card-body">
                                <div class="assignment-info">
                                    <p class="mb-3 fw-bold content-title">{{ $material['title'] }}</p>
                                    <h6 class="text-muted content-date">{{ $material['created_at'] }}</h6>
                                </div>
                                <div class="dropdown">
                                    <button class="btn operations-btn dropdown-toggle" type="button"
                                        id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ trans('main_trans.operations') }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end operations-dropdown text-end"
                                        aria-labelledby="operationsDropdown">


                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="{{ route('recordedClasses.edit', $material['data']->id) }}">
                                                <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                {{ trans('main_trans.edit') }}
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-lesson{{ $material['data']->id }}">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                {{ trans('main_trans.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- delete class modal   -->
                        <div class="modal fade" id="deleteModal-lesson{{ $material['data']->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('recordedClasses.destroy', $material['data']->id) }}" method="POST">
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
                    @elseif($material['type'] == 'online')
                        <div class="card shadow-sm mb-3 content">
                            <div
                                class="card-body d-flex justify-content-between align-items-center flex-wrap content-card-body">
                                <div class="assignment-info">
                                    <p class="mb-3 fw-bold content-title">{{ $material['title'] }}</p>
                                    <h6 class="text-muted content-date">{{ $material['created_at'] }}</h6>
                                </div>
                                <div class="dropdown">
                                    <button class="btn operations-btn dropdown-toggle" type="button"
                                        id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        العمليات
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end operations-dropdown text-end"
                                        aria-labelledby="operationsDropdown">


                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                href="teacher-forms/teacher-edit-meet-auto.html">
                                                <i class="fas fa-edit action-icon edit-icon-action"></i> تعديل
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal-meet">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i> حذف
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if ($materials->isEmpty())
                    <div class="alert alert-info text-center mt-4">
                        {{ trans('main_trans.no_materials') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <br><br><br><br>
@endsection
