@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">Students table "{{ $section->My_classs->Grades->Name }} -
            {{ $section->My_classs->Name_Class }} - {{ $section->Name_Section }} "</h3>
        <div class="title-underline-manager"></div>


        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">

                    <div class="header-table">
                        <input type="search" id="studentSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>


                    <div class="table-responsive manager-table-wrapper">
                        <table class="text-center manager-grade-table" id="datatable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Students_trans.name') }}</th>
                                    <th>{{ trans('Students_trans.email') }}</th>
                                    <th>{{ trans('Students_trans.gender') }}</th>
                                    <th>{{ trans('Students_trans.Processes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>{{ $student->gender->Name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle operations-btn" data-bs-toggle="dropdown">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-btn-item">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Students.show', $student->id) }}">
                                                            <i class="fas fa-eye action-icon eye-icon-action"></i>
                                                            {{ trans('main_trans.Student_information') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Students.edit', $student->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $student->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>


                                        <!-- Modal حذف الطالب -->
                                        <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <!-- يجعل المودال بالنص -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                                    </div>

                                                    <form id="deleteStudentForm{{ $student->id }}" action="{{ route('Students.destroy', $student->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-body text-center">
                                                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                            <p>{{ trans('Grades_trans.Delete_Warning') }} - {{ $student->user->name }}</p>
                                                        </div>

                                                    </form>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="submit" form="deleteStudentForm{{ $student->id }}"
                                                            class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                                        <button type="button" class="btn btn-cancel"
                                                            data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $students->links('vendor.pagination.custom')}}
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
