@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container my-5 subject-content-container">

            <!-- عنوان المادة والمعلم -->
            <div class="d-flex justify-content-between align-items-center mb-4 classroom-header">
                <div class="classroom-title me-3">
                    <h5 class="fw-bold classroom-name">{{ $teacher_section->section->My_classs->Name_Class }}
                        <span class="section-name">-{{ $teacher_section->section->Name_Section }}-</span>
                    </h5>
                    <h3 class="subject-name">{{ $teacher_section->subject->name }}</h3>
                </div>

                <div class="dropdown">
                    <button class="btn operations-btn-subject dropdown-toggle" data-bs-toggle="dropdown">
                        {{ trans('main_trans.add') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-subjects">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewBook', $teacher_section->id) }}">
                                <i class="fa fa-book"></i> {{ trans('Students_trans.Book') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewExam', $teacher_section->id) }}">
                                <i class="fa fa-pen-to-square"></i> {{ trans('Students_trans.exam') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewHomework', $teacher_section->id) }}">
                                <i class="fa fa-tasks"></i> {{ trans('Students_trans.Homework') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('createNewRecordedClass', $teacher_section->id) }}">
                                <i class="fa fa-play-circle"></i> {{ trans('Teacher_trans.recorded_classe') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="teacher-forms/teacher-add-meet-auto.html">
                                <i class="fa fa-video"></i> {{ trans('Teacher_trans.Onlineclass') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-content-subject">
                @foreach ($materials as $material)
                    <div class="card shadow-sm mb-3 content">
                        <div
                            class="card-body d-flex justify-content-between align-items-center flex-wrap content-card-body">
                            <div class="assignment-info">
                                <p class="content-title">
                                    @if ($material['type'] == 'book')
                                        <i class="fa fa-book"></i>
                                    @elseif($material['type'] == 'exam')
                                        <i class="fa fa-pen-to-square"></i>
                                    @elseif($material['type'] == 'homework')
                                        <i class="fa fa-tasks"></i>
                                    @elseif($material['type'] == 'recorded')
                                        <i class="fa fa-play-circle"></i>
                                    @elseif($material['type'] == 'online')
                                        <i class="fa fa-video"></i>
                                    @endif
                                    {{ $material['title'] }}
                                </p>
                                <p class="content-date"><span>{{ $material['created_at'] }}</span>
                                </p>
                            </div>

                            <div class="dropdown">
                                <button class="dropdown-toggle dropdown-toggle-operations" data-bs-toggle="dropdown">
                                    {{ trans('main_trans.operations') }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-operations">

                                    {{-- Actions based on type --}}
                                    @if ($material['type'] == 'book')
                                        <li>
                                            <a target="_blank" class="dropdown-item d-flex align-items-center gap-2"
                                                href="{{ asset('storage/attachments/library/teachers/' . Auth::user()->National_ID . '/' . $material['data']->file_name) }}">
                                                <i class="fa-solid fa-download action-icon download-icon-action"></i>
                                                {{ trans('Teacher_trans.download') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
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
                                    @elseif($material['type'] == 'homework')
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                href="{{ route('submissions', $material['data']->id) }}">
                                                <i class="fas fa-users students-icon action-icon std-icon-action"></i>
                                                {{ trans('Teacher_trans.Display_Delivered_Students') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
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
                                    @elseif($material['type'] == 'exam')
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                href="{{ route('exam.results', $material['section_exam_id']) }}">
                                                <i class="fas fa-question-circle action-icon question-icon-action"></i>
                                                {{ trans('Teacher_trans.ExamDetails') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                href="{{ route('exams.edit', $material['exam_id']) }}">
                                                <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                {{ trans('main_trans.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal-exam{{ $material['section_exam_id'] }}">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                {{ trans('main_trans.remove') }}
                                            </a>
                                        </li>
                                    @elseif($material['type'] == 'recorded')
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
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
                                    @elseif($material['type'] == 'online')
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                href="teacher-forms/teacher-edit-meet.html">
                                                <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                {{ trans('main_trans.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal-meet{{ $material['data']->id }}">
                                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                {{ trans('main_trans.delete') }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($materials->isEmpty())
                    <div class="alert alert-info text-center mt-4">
                        {{ trans('main_trans.no_materials') }}
                    </div>
                @endif
            </div>
        </div>
        @foreach ($materials as $material)
            @if ($material['type'] == 'book')
                <!-- delete book modal -->
                <div class="modal fade" id="deleteModal-book{{ $material['data']->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('Grades_trans.Close') }}"></button>
                            </div>
                            <form id="deleteBookForm{{ $material['data']->id }}"
                                action="{{ route('library.destroy', $material['data']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                </div>
                            </form>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" form="deleteBookForm{{ $material['data']->id }}"
                                    class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                <button type="button" class="btn btn-cancel"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($material['type'] == 'homework')
                <!-- delete homework modal -->
                <div class="modal fade" id="deleteModal-hw{{ $material['data']->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('Grades_trans.Close') }}"></button>
                            </div>
                            <form id="deleteHomework{{ $material['data']->id }}"
                                action="{{ route('homeworks.destroy', $material['data']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                </div>
                            </form>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" form="deleteHomework{{ $material['data']->id }}"
                                    class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                <button type="button" class="btn btn-cancel"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($material['type'] == 'exam')
                <!-- delete exam modal -->
                <div class="modal fade" id="deleteModal-exam{{ $material['section_exam_id'] }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('main_trans.close') }}"></button>
                            </div>
                            <form id="deleteExamForm{{ $material['section_exam_id'] }}"
                                action="{{ route('sectionsExams.destroy', $material['section_exam_id']) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                </div>
                            </form>
                            <div class="modal-footer custom-modal-footer">
                                <button type="submit" form="deleteExamForm{{ $material['data']->id }}"
                                    class="btn btn-primary custom-save-btn">
                                    {{ trans('main_trans.delete') }}</button>
                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($material['type'] == 'recorded')
                <!-- delete recorded class modal -->
                <div class="modal fade" id="deleteModal-lesson{{ $material['data']->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('Grades_trans.Close') }}"></button>
                            </div>
                            <form id="deleteClassForm{{ $material['data']->id }}"
                                action="{{ route('recordedClasses.destroy', $material['data']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                </div>
                            </form>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" form="deleteClassForm{{ $material['data']->id }}"
                                    class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                <button type="button" class="btn btn-cancel"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($material['type'] == 'online')
                <!-- delete zoom class modal-->
                <div class="modal fade" id="deleteModal-meet{{ $material['data']->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('Grades_trans.Close') }}"></button>
                            </div>
                            <form id="deleteZoomForm{{ $material['data']->id }}" action="{{ route('ZoomClasses.destroy', $material['data']->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                </div>
                            </form>
                            <div class="modal-footer justify-content-center">
                                <button type="submit" form="deleteZoomForm{{ $material['data']->id }}"
                                    class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                <button type="button" class="btn btn-cancel"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <br><br><br><br>
@endsection
