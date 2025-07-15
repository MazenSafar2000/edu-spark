@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="teacher-title">جدول الكتب</h3>

        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a href="{{ route('library.create') }}">{{ trans('Teacher_trans.add_new_book') }} </a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>

                    <div class="table-responsive">
                        <table class="table text-center custom-user-table-teacher">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.book_name') }}</th>
                                    <th>{{ trans('Students_trans.Grade') }}</th>
                                    <th>{{ trans('Students_trans.classrooms') }}</th>
                                    <th>{{ trans('Students_trans.section') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->grade->Name }}</td>
                                        <td>{{ $book->classroom->Name_Class }}</td>
                                        <td>{{ $book->section->Name_Section }}</td>
                                        <td class="position-relative">
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
                                                            href="{{ asset('storage/attachments/library/teachers/' . Auth::user()->teacher->National_ID . '/' . $book->file_name) }}">
                                                            <i
                                                                class="fa-solid fa-download action-icon download-icon-action"></i>
                                                            {{ trans('Teacher_trans.download') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('library.edit', $book->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-book{{ $book->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach ($data as $book)
                            <!-- delet book modal -->
                            <div class="modal fade" id="deleteModal-book{{ $book->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->

                                    <form action="{{ route('library.destroy', $book->id) }}" method="POST">
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



                    </div>
                </div>

            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
