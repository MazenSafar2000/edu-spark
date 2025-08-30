@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('Teacher_trans.homeworks_list') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">

            <div class="header-table-teacher">
                <a href="{{ route('homeworks.create') }}">{{ trans('Teacher_trans.add_new_homework') }}</a>


                <div class="search-box-student text-end mb-3">
                    <input type="search" id="homeworkSearch" class="form-control search-input-custom"
                        placeholder="{{ trans('main_trans.search') }}">
                </div>
            </div>
            <div class="table-responsive custom-table-wrapper">
                <table class="text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
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
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle dropdown-toggle-operations"
                                            data-bs-toggle="dropdown">
                                            {{ trans('main_trans.operations') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-operations">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                    href="{{ route('submissions', $homework->id) }}">
                                                    <i class="fas fa-users students-icon action-icon std-icon-action"></i>
                                                    {{ trans('Teacher_trans.Display_Delivered_Students') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                    href="{{ route('homeworks.edit', $homework->id) }}">
                                                    <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                    {{ trans('main_trans.edit') }}
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-hw{{ $homework->id }}">
                                                    <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                    {{ trans('main_trans.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal حذف الواجب -->
                            <div class="modal fade" id="deleteModal-hw{{ $homework->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                        </div>
                                        <form id="deleteHomework" action="{{ route('homeworks.destroy', $homework->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div class="modal-body text-center">
                                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                            </div>
                                        </form>
                                        <div class="modal-footer justify-content-center">
                                            <button type="submit" form="deleteHomework"
                                                class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                            <button type="button" class="btn btn-cancel"
                                                data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $homeworks->links('vendor.pagination.custom') }}




            </div>
        </div>

    </div>
    {{-- search input code --}}
    <script>
        document.getElementById('homeworkSearch').addEventListener('input', function() {
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
