@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title">{{ trans('Teacher_trans.recorded_classes') }}</h3>

        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a
                            href="{{ route('recordedClasses.create') }}">{{ trans('Teacher_trans.Add_new_recordedClass') }}</a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">

                    </div>
                    <div class="table-responsive">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <table class="table text-center custom-user-table-teacher">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.grade') }}</th>
                                    <th>{{ trans('Teacher_trans.classroom') }}</th>
                                    <th>{{ trans('Teacher_trans.section') }}</th>
                                    <th>{{ trans('Teacher_trans.subject') }}</th>
                                    <th>{{ trans('Teacher_trans.Class_title') }}</th>
                                    <th>{{ trans('Teacher_trans.Class_link') }}</th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $class->grade->Name }}</td>
                                        <td>{{ $class->classroom->Name_Class }}</td>
                                        <td>{{ $class->section->Name_Section }}</td>
                                        <td>{{ $class->subject->name }}</td>
                                        <td>{{ $class->title }}</td>
                                        <td><a href="{{ $class->video_url }}"
                                                target="_blank">{{ trans('Teacher_trans.Watch_the_class') }}</a>
                                        </td>
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
                                                            href="{{ route('recordedClasses.edit', $class->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-lesson{{ $class->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- delete class modal   -->
                                    <div class="modal fade" id="deleteModal-lesson{{ $class->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('recordedClasses.destroy', $class->id) }}"
                                                method="POST">
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
