@extends('layouts.main.manager_dashboard')
@section('manager_content')
    {{-- <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">جدول المعلمين</h3>

        <ul class="nav nav-tabs mb-3 nav-std" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#teachers"
                    type="button" role="tab">المعلمين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#specialization"
                    type="button" role="tab">التخصصات</button>
            </li>

        </ul>


        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table">
                        <a href="{{ route('Teachers.create') }}" class="btn">{{ trans('main_trans.add_teacher') }}</a>
                        <input type="search" class="form-control" placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.Name_Teacher') }}</th>
                                    <th>{{ trans('Teacher_trans.Gender') }}</th>
                                    <th>{{ trans('Teacher_trans.Joining_Date') }}</th>
                                    <th>{{ trans('Teacher_trans.specialization') }}</th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Teachers as $Teacher)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $Teacher->user->name }}</td>
                                        <td>{{ $Teacher->genders->Name }}</td>
                                        <td>{{ $Teacher->Joining_Date }}</td>
                                        <td>{{ $Teacher->specializations->Name }}</td>
                                        <td>
                                            <a href="{{ route('Teachers.show', $Teacher->id) }}"><i
                                                    class="fa-solid fa-eye action-icon eye-icon-action"
                                                    title="{{ trans('main_trans.show_details') }}"></i></a>
                                            <a href="{{ route('Teachers.edit', $Teacher->id) }}"><i
                                                    class="fas fa-edit action-icon edit-icon-action"
                                                    title="{{ trans('main_trans.edit') }}"></i></a>
                                            <a data-bs-toggle="modal" data-bs-target="#deleteTeacher{{ $Teacher->id }}"><i
                                                    class="fas fa-trash-alt action-icon delete-icon-action"
                                                    title="{{ trans('main_trans.delete') }}"></i></a>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteTeacher{{ $Teacher->id }}" tabindex="-1"
                                                aria-labelledby="deleteTeacherLabel{{ $Teacher->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('Teachers.destroy', $Teacher->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title"
                                                                    id="deleteTeacherLabel{{ $Teacher->id }}">
                                                                    {{ trans('main_trans.Delete_teacher_data') }}
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ trans('main_trans.Warning_Delete') }}</p>
                                                                <strong>{{ $Teacher->user->name }}</strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">{{ trans('main_trans.close') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">{{ trans('main_trans.delete') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div> --}}

    <!-- المحتوى الرئيسي -->
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <!-- التبويبات -->
        <ul class="nav nav-tabs mb-3 nav-std" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#teachers"
                    type="button" role="tab">{{ trans('main_trans.Teachers') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#specialization"
                    type="button" role="tab">{{ trans('main_trans.specialization') }}</button>
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
            <div class="table-content tab-content" id="myTabContent">
                <!-- teachers -->
                <div class="tab-pane fade show active" id="teachers" role="tabpanel">
                    <div class="header-table">
                        <a href="{{ route('Teachers.create') }}">
                            {{ trans('main_trans.add_teacher') }}
                        </a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.Name_Teacher') }}</th>
                                    <th>{{ trans('Teacher_trans.National_ID') }}</th>
                                    <th>{{ trans('Teacher_trans.Gender') }}</th>
                                    <th>{{ trans('Teacher_trans.Joining_Date') }}</th>
                                    <th>{{ trans('Teacher_trans.specialization') }}</th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Teachers as $Teacher)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $Teacher->user->name }}</td>
                                        <td>{{ $Teacher->National_ID }}</td>
                                        <td>{{ $Teacher->genders->Name }}</td>
                                        <td>{{ $Teacher->Joining_Date }}</td>
                                        <td>{{ $Teacher->specializations->Name }}</td>
                                        {{-- <td>
                                            <a href="{{ route('Teachers.show', $Teacher->id) }}"><i
                                                    class="fa-solid fa-eye action-icon eye-icon-action"
                                                    title="{{ trans('main_trans.show_details') }}"></i></a>
                                            <a href="{{ route('Teachers.edit', $Teacher->id) }}"><i
                                                    class="fas fa-edit action-icon edit-icon-action"
                                                    title="{{ trans('main_trans.edit') }}"></i></a>
                                            <a data-bs-toggle="modal" data-bs-target="#deleteTeacher{{ $Teacher->id }}"><i
                                                    class="fas fa-trash-alt action-icon delete-icon-action"
                                                    title="{{ trans('main_trans.delete') }}"></i></a>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteTeacher{{ $Teacher->id }}" tabindex="-1"
                                                aria-labelledby="deleteTeacherLabel{{ $Teacher->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('Teachers.destroy', $Teacher->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title"
                                                                    id="deleteTeacherLabel{{ $Teacher->id }}">
                                                                    {{ trans('main_trans.Delete_teacher_data') }}
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ trans('main_trans.Warning_Delete') }}</p>
                                                                <strong>{{ $Teacher->user->name }}</strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">{{ trans('main_trans.close') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">{{ trans('main_trans.delete') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> --}}
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Teachers.show', $Teacher->id) }}">
                                                            <i class="fa-solid fa-eye text-success"></i>
                                                            {{ trans('main_trans.View_data') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Teachers.edit', $Teacher->id) }}">
                                                            <i class="fas fa-edit text-primary"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('TeachersClasses', $Teacher->id) }}">
                                                            <i class="fa-solid fa-eye text-success"></i>
                                                            {{ trans('main_trans.classes_teach') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteTeacher{{ $Teacher->id }}">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteTeacher{{ $Teacher->id }}" tabindex="-1"
                                        aria-labelledby="deleteTeacherLabel{{ $Teacher->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('Teachers.destroy', $Teacher->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteTeacherLabel{{ $Teacher->id }}">
                                                            {{ trans('main_trans.Delete_teacher_data') }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ trans('main_trans.Warning_Delete') }}</p>
                                                        <strong>{{ $Teacher->user->name }}</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ trans('main_trans.close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ trans('main_trans.delete') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- specializations -->
                <div class="tab-pane fade" id="specialization" role="tabpanel">
                    <div class="header-table">
                        <a data-bs-toggle="modal" data-bs-target="#addSpecializationModal">
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
                                    <th>{{ trans('main_trans.specialization') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Specializations as $Specialization)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $Specialization->Name }}</td>
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editSpecializationModal{{ $Specialization->id }}">
                                                            <i class="fas fa-edit text-primary"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteSpecializationModal{{ $Specialization->id }}">
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
            </div>
        </div>


        <!-- add new Specialization modal -->
        <div class="modal fade custom-modal" id="addSpecializationModal" tabindex="-1"
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
                        <form id="SpecializationForm" class="custom-form" action="{{ route('Specializations.store') }}"
                            method="POST">
                            @csrf

                            @include('forms._form-specialization', ['Specialization' => null])

                        </form>
                    </div>

                    <!-- تذييل المودال -->
                    <div class="modal-footer custom-modal-footer">
                        <button type="submit" class="btn btn-primary custom-save-btn"
                            form="SpecializationForm">{{ trans('Grades_trans.submit') }}</button>
                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                            data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                    </div>

                </div>
            </div>
        </div>


        @foreach ($Specializations as $Specialization)
            <!--  edit Specialization modal  -->
            <div class="modal fade custom-modal" id="editSpecializationModal{{ $Specialization->id }}" tabindex="-1"
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
                            <form id="editStageForm{{ $Specialization->id }}" class="custom-form"
                                action="{{ route('Specializations.update', $Specialization->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                @include('forms._form-specialization')

                            </form>
                        </div>

                        <!-- التذييل -->
                        <div class="modal-footer custom-modal-footer">
                            <button type="submit" class="btn btn-primary custom-save-btn"
                                form="editStageForm{{ $Specialization->id }}">{{ trans('Grades_trans.submit') }}</button>
                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- delete Specialization modal   -->
            <div class="modal fade" id="deleteSpecializationModal{{ $Specialization->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('Specializations.destroy', $Specialization->id) }}" method="POST">
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

    </div>
@endsection
