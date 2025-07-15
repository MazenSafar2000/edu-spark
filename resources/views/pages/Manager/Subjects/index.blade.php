@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">{{ trans('main_trans.subjects') }}</h3>


        <div class="table-users mt-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table">
                        <a data-bs-toggle="modal" data-bs-target="#addSubjectModal" class="btn">
                            {{ trans('main_trans.add_subject') }}
                        </a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">

                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('main_trans.subject_name') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Subjects as $Subject)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $Subject->name }}</td>
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">

                                                    <li>
                                                        <a class="btn dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editSubjectModal{{ $Subject->id }}">
                                                            <i class="fas fa-edit text-primary"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="btn dropdown-item d-flex align-items-center gap-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteSubjectModal{{ $Subject->id }}">
                                                            <i class="fas fa-trash-alt text-danger"></i>
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


                        <!-- add new grade modal -->
                        <div class="modal fade custom-modal" id="addSubjectModal" tabindex="-1"
                            aria-labelledby="addStageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                <div class="modal-content custom-modal-content">

                                    <!-- رأس المودال -->
                                    <div class="modal-header custom-modal-header">
                                        <h5 class="modal-title custom-modal-title" id="addStageModalLabel">
                                            {{ trans('Grades_trans.add_Grade') }}
                                        </h5>
                                    </div>

                                    <!-- جسم المودال -->
                                    <div class="modal-body custom-modal-body">
                                        <form id="AddSubjectsForm" class="custom-form"
                                            action="{{ route('Subjects.store') }}" method="POST">
                                            @csrf

                                            @include('forms._form-subjects', [
                                                'Subject' => null,
                                            ])

                                        </form>
                                    </div>

                                    <!-- تذييل المودال -->
                                    <div class="modal-footer custom-modal-footer">
                                        <button type="submit" class="btn btn-primary custom-save-btn"
                                            form="AddSubjectsForm">{{ trans('Grades_trans.submit') }}</button>
                                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                                            data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                    </div>

                                </div>
                            </div>
                        </div>


                        @foreach ($Subjects as $Subject)
                            <!--  edit grade modal  -->
                            <div class="modal fade custom-modal" id="editSubjectModal{{ $Subject->id }}" tabindex="-1"
                                aria-labelledby="editStageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                    <div class="modal-content custom-modal-content">

                                        <!-- رأس المودال -->
                                        <div class="modal-header custom-modal-header">
                                            <h5 class="modal-title custom-modal-title" id="editStageModalLabel">
                                                {{ trans('Grades_trans.edit_Grade') }}</h5>
                                        </div>

                                        <!-- جسم المودال -->
                                        <div class="modal-body custom-modal-body">
                                            <form id="editSubjectForm{{ $Subject->id }}" class="custom-form"
                                                action="{{ route('Subjects.update', $Subject->id) }}" method="post">
                                                @csrf
                                                @method('PUT')

                                                @include('forms._form-subjects')

                                            </form>
                                        </div>

                                        <!-- التذييل -->
                                        <div class="modal-footer custom-modal-footer">
                                            <button type="submit" class="btn btn-primary custom-save-btn"
                                                form="editSubjectForm{{ $Subject->id }}">{{ trans('Grades_trans.submit') }}</button>
                                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal حذف المرحلة -->
                            <div class="modal fade" id="deleteSubjectModal{{ $Subject->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('Subjects.destroy', $Subject->id) }}" method="POST">
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

    </div>
@endsection
