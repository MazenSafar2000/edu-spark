@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">Students table "{{ $section->My_classs->Grades->Name }} -
            {{ $section->My_classs->Name_Class }} - {{ $section->Name_Section }} "</h3>
        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    <div class="header-table">
                        <a class="btn" data-bs-toggle="modal"
                            data-bs-target="#addteacherModal">{{ trans('main_trans.add_teacher') }}</a>
                        <input type="search" id="studentSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table" id="datatable">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.Name_Teacher') }}</th>
                                    <th>{{ trans('Students_trans.subject') }}</th>
                                    <th>{{ trans('Students_trans.Processes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sectionTeachers as $teacher)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $teacher->teacher->user->name }}</td>
                                        <td>{{ $teacher->subject->name  }}</td>
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
                                                            href="{{ route('Students.edit', $teacher->id) }}">
                                                            <i class="fas fa-edit text-primary"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $teacher->id }}">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

        <!-- add teacherSection modal -->
        <div class="modal fade custom-modal" id="addteacherModal" tabindex="-1" aria-labelledby="addStageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                <div class="modal-content custom-modal-content">

                    <!-- رأس المودال -->
                    <div class="modal-header custom-modal-header">
                        <h5 class="modal-title custom-modal-title" id="addStageModalLabel">
                            {{ trans('main_trans.add_teacher') }}
                        </h5>
                    </div>

                    <!-- جسم المودال -->
                    <div class="modal-body custom-modal-body">
                        <form action="{{ route('TeacherSections.store') }}" method="POST">
                            @csrf

                            @include('forms._form-teacherSection')

                            <div class="modal-footer custom-modal-footer">
                                <button type="submit"
                                    class="btn btn-primary custom-save-btn">{{ trans('Grades_trans.submit') }}</button>
                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                    data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- search input code --}}
    <script>
        document.getElementById('studentSearch').addEventListener('input', function() {
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
