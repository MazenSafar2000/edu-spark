@extends('layouts.main.manager_dashboard')
@section('manager_content')
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
            @include('components.error-field')
            <div class="table-content tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="teachers" role="tabpanel">
                    <div class="header-table">
                        <a href="{{ route('Teachers.create') }}">{{ trans('main_trans.add_teacher') }}</a>
                        <input type="search" id="TeacherSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">

                    </div>
                    <div class="table-responsive manager-table-wrapper">
                        <table class="text-center manager-grade-table" id="datatable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.Name_Teacher') }}</th>
                                    <th>{{ trans('main_trans.National_ID') }}</th>
                                    <th>{{ trans('Teacher_trans.Gender') }}</th>
                                    <th>{{ trans('Teacher_trans.Joining_Date') }}</th>
                                    <th>{{ trans('Teacher_trans.specialization') }}</th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Teachers as $Teacher)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $Teacher->user->name }}</td>
                                        <td>{{ $Teacher->user->National_ID }}</td>
                                        <td>{{ $Teacher->genders->Name }}</td>
                                        <td>{{ $Teacher->Joining_Date }}</td>
                                        <td>{{ $Teacher->specializations->Name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle operations-btn" data-bs-toggle="dropdown">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-btn-item">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('Teachers.show', $Teacher->id) }}">
                                                            <i
                                                                class="fas fa-eye action-icon edit-icon-action"></i>{{ trans('main_trans.View_data') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('Teachers.edit', $Teacher->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-teacher{{ $Teacher->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal-teacher{{ $Teacher->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="{{ trans('main_trans.close') }}"></button>
                                                </div>

                                                <form action="{{ route('Teachers.destroy', $Teacher->id) }}" method="post"
                                                    id="deleteTeacher{{ $Teacher->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('main_trans.Delete_Student_Warning') }}</p>
                                                        <p>{{ $Teacher->user->name }}</p>
                                                    </div>
                                                    <div class="modal-footer custom-modal-footer-manager">
                                                        <button type="submit" form="deleteTeacher{{ $Teacher->id }}"
                                                            class="btn btn-primary custom-save-btn"
                                                            form="stageForm">{{ trans('main_trans.submit') }}</button>
                                                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                            data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $Teachers->links('vendor.pagination.custom') }}
                    </div>
                </div>

                <!-- specializations -->
                <div class="tab-pane fade" id="specialization" role="tabpanel">
                    <div class="header-table">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addModal-specialization">
                            {{ trans('main_trans.add_grade') }}
                        </a>

                        <input type="text" id="SpecializationsSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">

                    </div>
                    <div class="table-responsive manager-table-wrapper">
                        <table class="text-center manager-grade-table" id="datatable_specialize">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('main_trans.specialization') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Specializations as $Specialization)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $Specialization->Name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle operations-btn" data-bs-toggle="dropdown">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-btn-item">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editModal-specialization{{ $Specialization->id }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-specialization{{ $Specialization->id }}">
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
                        {{ $Specializations->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- add new Specialization modal -->
        <div class="modal fade custom-modal" id="addModal-specialization" tabindex="-1"
            aria-labelledby="addModal-specialization" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                <div class="modal-content custom-modal-content">

                    <!-- رأس المودال -->
                    <div class="modal-header custom-modal-header">
                        <h5 class="modal-title custom-modal-title" id="addStageModalLabel">
                            {{ trans('main_trans.add_specialization') }}</h5>
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
                    <div class="modal-footer custom-modal-footer-manager">
                        <button type="submit" class="btn btn-primary custom-save-btn"
                            form="SpecializationForm">{{ trans('main_trans.submit') }}</button>
                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                            data-bs-dismiss="modal">{{ trans('main_trans.close') }}</button>
                    </div>

                </div>
            </div>
        </div>

        @foreach ($Specializations as $Specialization)
            <!-- delete Specialization modal   -->
            <div class="modal fade" id="deleteModal-specialization{{ $Specialization->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="{{ trans('main_trans.close') }}"></button>
                        </div>

                        <form id="deleteSpecForm{{ $Specialization->id }}"
                            action="{{ route('Specializations.destroy', $Specialization->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="modal-body text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <p>{{ trans('main_trans.Delete_Warning') }} - {{ $Specialization->Name }}</p>
                            </div>
                        </form>

                        <div class="modal-footer custom-modal-footer-manager">
                            <button type="submit" class="btn btn-primary custom-save-btn"
                                form="deleteSpecForm{{ $Specialization->id }}">{{ trans('main_trans.submit') }}</button>
                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--  edit Specialization modal  -->
            <div class="modal fade custom-modal" id="editModal-specialization{{ $Specialization->id }}" tabindex="-1"
                aria-labelledby="editModal-specialization" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                    <div class="modal-content custom-modal-content">

                        <!-- رأس المودال -->
                        <div class="modal-header custom-modal-header">
                            <h5 class="modal-title custom-modal-title" id="editModal-specialization">
                                {{ trans('main_trans.edit_specialization') }}</h5>
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

                        <!-- تذييل المودال -->
                        <div class="modal-footer custom-modal-footer-manager">
                            <button type="submit" class="btn btn-primary custom-save-btn"
                                form="editStageForm{{ $Specialization->id }}">{{ trans('main_trans.submit') }}</button>
                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- search input code --}}
    <script>
        document.getElementById('TeacherSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('datatable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });

        document.getElementById('SpecializationsSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('datatable_specialize');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
