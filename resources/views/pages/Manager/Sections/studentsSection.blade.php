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
                        <a href="{{ route('Students.create') }}">{{ trans('main_trans.add_student') }}</a>
                        <input type="search" id="studentSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center custom-user-table" id="datatable">
                            <thead class="thead-user">
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
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>{{ $student->gender->Name }}</td>
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
                                                            href="{{ route('Students.show', $student->id) }}">
                                                            <i class="fa-solid fa-eye text-success"></i>
                                                            {{ trans('main_trans.Student_information') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Students.edit', $student->id) }}">
                                                            <i class="fas fa-edit text-primary"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $student->id }}">
                                                            <i class="fas fa-trash-alt text-danger"></i>
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
                                                            aria-label="إغلاق"></button>
                                                    </div>

                                                    <form action="{{ route('Students.destroy', $student->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-body text-center">
                                                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                            <p>هل أنت متأكد أنك تريد حذف هذا الطالب؟</p>
                                                            <p>{{ $student->user->name }}</p>
                                                        </div>

                                                        <div class="modal-footer justify-content-center">
                                                            <button type="submit" class="btn btn-del">تأكيد
                                                                الحذف</button>
                                                            <button type="button" class="btn btn-cancel"
                                                                data-bs-dismiss="modal">إلغاء</button>
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
