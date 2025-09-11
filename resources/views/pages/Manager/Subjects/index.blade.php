@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">{{ trans('main_trans.subjects') }}</h3>
        <div class="title-underline-manager"></div>


        <div class="table-users mt-5">
            <div class="tab-pane fade show active" role="tabpanel">
                <div class="header-table">
                    <a data-bs-toggle="modal" data-bs-target="#addSubjectModal"
                        class="btn">{{ trans('main_trans.add_subject') }}</a>
                    <input type="text" class="form-control search-input" id="SubjectSearch"
                        placeholder="{{ trans('main_trans.search') }}">

                </div>
                <div class="table-responsive manager-table-wrapper">
                    <table class="text-center manager-grade-table" id="datatable">
                        <thead class="thead-manager">
                            <tr>
                                <th>#</th>
                                <th>{{ trans('main_trans.subject_name') }}</th>
                                <th>{{ trans('main_trans.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Subjects as $Subject)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $Subject->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle operations-btn" data-bs-toggle="dropdown">
                                                {{ trans('main_trans.operations') }}
                                            </button>
                                            <ul class="dropdown-menu operations-btn-item">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                        data-bs-toggle="modal" href="#"
                                                        data-bs-target="#editSubjectModal{{ $Subject->id }}">
                                                        <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                        {{ trans('main_trans.edit') }}
                                                    </a>
                                                </li>

                                                <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $Subject->id }}">
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
                    {{ $Subjects->links('vendor.pagination.custom') }}

                    <!-- add new subject modal -->
                    <div class="modal fade custom-modal" id="addSubjectModal" tabindex="-1"
                        aria-labelledby="addStageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                            <div class="modal-content custom-modal-content">

                                <!-- رأس المودال -->
                                <div class="modal-header custom-modal-header">
                                    <h5 class="modal-title custom-modal-title" id="addStageModalLabel">
                                        {{ trans('main_trans.add_subject') }}
                                    </h5>
                                </div>

                                <!-- جسم المودال -->
                                <div class="modal-body custom-modal-body">
                                    <form id="AddSubjectsForm" class="custom-form" action="{{ route('Subjects.store') }}"
                                        method="POST" enctype="multipart/form-data">
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
                        <!--  edit subject modal  -->
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
                                            action="{{ route('Subjects.update', $Subject->id) }}" method="post"
                                            enctype="multipart/form-data">
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

                        <!-- delete subject modal -->
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

    {{-- search input code --}}
    <script>
        document.getElementById('SubjectSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('datatable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
