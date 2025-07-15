@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title">{{ trans('Teacher_trans.homeworks_list') }}</h3>

        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a href="{{ route('homeworks.create') }}">{{ trans('Teacher_trans.add_new_homework') }}</a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">

                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table-teacher">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.grade') }} </th>
                                    <th>{{ trans('Teacher_trans.classroom') }} </th>
                                    <th>{{ trans('Teacher_trans.section') }} </th>
                                    <th>{{ trans('Teacher_trans.subject') }} </th>
                                    <th>{{ trans('Teacher_trans.homework_title') }}</th>
                                    <th>{{ trans('Teacher_trans.homework_description') }}</th>
                                    <th>{{ trans('Teacher_trans.total_degree') }}</th>
                                    <th>{{ trans('Teacher_trans.allow_multiple_submissions') }}</th>
                                    <th>{{ trans('Teacher_trans.homework_due_date') }} </th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($homeworks as $homework)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $homework->grade->Name }}</td>
                                        <td>{{ $homework->classroom->Name_Class }}</td>
                                        <td>{{ $homework->section->Name_Section }}</td>
                                        <td>{{ $homework->subject->name }}</td>
                                        <td style="max-width: 200px">{{ $homework->title }}</td>
                                        <td style="max-width: 200px">{{ $homework->description }}</td>
                                        <td>{{ $homework->total_degree }}</td>
                                        <td>{{ $homework->allow_multiple_submissions ? 'Yes' : 'No' }}</td>
                                        <td>{{ $homework->due_date }}</td>
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
                                                            href="teacher-hw-submissions.html">
                                                            <i
                                                                class="fas fa-users students-icon action-icon std-icon-action"></i>
                                                            الطلاب
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('homeworks.edit', $homework->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-hw{{ $homework->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!--  delete homework modal  -->
                                    <div class="modal fade" id="deleteModal-hw{{ $homework->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('homeworks.destroy', $homework->id) }}" method="POST">
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
