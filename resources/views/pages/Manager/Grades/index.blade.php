@extends('layouts.main.manager_dashboard')
@section('manager_content')

    <!-- المحتوى الرئيسي -->
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <!-- التبويبات -->
        <ul class="nav nav-tabs mb-3 nav-std" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#grades" type="button"
                    role="tab">{{ trans('main_trans.Grades') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#classrooms" type="button"
                    role="tab">{{ trans('main_trans.classes') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="parents-tab" data-bs-toggle="tab" data-bs-target="#sections" type="button"
                    role="tab">{{ trans('main_trans.sections') }}</button>
            </li>
        </ul>

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
            <!-- content -->
            <div class="table-content tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="grades" role="tabpanel">
                    <div class="header-table">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addStageModal">
                            {{ trans('main_trans.add_grade') }}
                        </a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Grades_trans.Name') }}</th>
                                    <th>{{ trans('Grades_trans.Notes') }}</th>
                                    <th>{{ trans('Grades_trans.Processes') }}</th>
                                </tr>
                            </thead>
                            @foreach ($Grades as $Grade)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $Grade->Name }}</td>
                                    <td>{{ $Grade->Notes }}</td>
                                    <td class="position-relative">
                                        <div class="dropdown">
                                            <button class="btn operations-btn dropdown-toggle" type="button"
                                                id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ trans('main_trans.operations') }}
                                            </button>
                                            <ul class="dropdown-menu operations-dropdown text-end"
                                                aria-labelledby="operationsDropdown">

                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                        href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editStageModal{{ $Grade->id }}">
                                                        <i class="fas fa-edit text-primary"></i>
                                                        {{ trans('main_trans.edit') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteGradeModal{{ $Grade->id }}">
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
                    </div>
                </div>

                @include('pages.Manager.classrooms.index')

                @include('pages.Manager.sections.index')
            </div>
        </div>

        @foreach ($Grades as $Grade)
            <!--  edit grade modal  -->
            <div class="modal fade custom-modal" id="editStageModal{{ $Grade->id }}" tabindex="-1"
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
                            <form id="editStageForm{{ $Grade->id }}" class="custom-form"
                                action="{{ route('Grades.update', $Grade->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                @include('forms._form-grade')

                            </form>
                        </div>

                        <!-- التذييل -->
                        <div class="modal-footer custom-modal-footer">
                            <button type="submit" class="btn btn-primary custom-save-btn"
                                form="editStageForm{{ $Grade->id }}">{{ trans('Grades_trans.submit') }}</button>
                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal حذف المرحلة -->
            <div class="modal fade" id="deleteGradeModal{{ $Grade->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('Grades.destroy', $Grade->id) }}" method="POST">
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
                                <button type="submit" class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                <button type="button" class="btn btn-cancel"
                                    data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- add new grade modal -->
        <div class="modal fade custom-modal" id="addStageModal" tabindex="-1" aria-labelledby="addStageModalLabel"
            aria-hidden="true">
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
                        <form id="stageForm" class="custom-form" action="{{ route('Grades.store') }}" method="POST">
                            @csrf

                            @include('forms._form-grade', ['Grade' => null])

                        </form>
                    </div>

                    <!-- تذييل المودال -->
                    <div class="modal-footer custom-modal-footer">
                        <button type="submit" class="btn btn-primary custom-save-btn"
                            form="stageForm">{{ trans('Grades_trans.submit') }}</button>
                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                            data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
