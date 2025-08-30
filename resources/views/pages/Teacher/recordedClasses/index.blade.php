@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('Teacher_trans.recorded_classes') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">
            <div class="header-table-teacher">
                <a href="{{ route('recordedClasses.create') }}">{{ trans('Teacher_trans.Add_new_recordedClass') }}</a>
                <div class="search-box-student text-end mb-3">
                    <input type="search" id="classesSearch" class="form-control search-input-custom"
                        placeholder="{{ trans('main_trans.search') }}">
                </div>
            </div>
            <div class="table-responsive custom-table-wrapper">
                @include('components.error-field')
                <table class="text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Teacher_trans.grade') }}</th>
                            <th>{{ trans('Teacher_trans.classroom') }}</th>
                            <th>{{ trans('Teacher_trans.section') }}</th>
                            <th>{{ trans('Teacher_trans.subject') }}</th>
                            <th>{{ trans('Teacher_trans.Class_title') }}</th>
                            <th>{{ trans('Teacher_trans.Class_link') }}</th>
                            <th>{{ trans('Teacher_trans.operations') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $class->grade->Name }}</td>
                                <td>{{ $class->classroom->Name_Class }}</td>
                                <td>{{ $class->section->Name_Section }}</td>
                                <td>{{ $class->subject->name }}</td>
                                <td>{{ $class->title }}</td>
                                <td><a href="{{ $class->video_url }}"
                                        target="_blank">{{ trans('Teacher_trans.Watch_the_class') }}</a>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle dropdown-toggle-operations"
                                            data-bs-toggle="dropdown">
                                            {{ trans('main_trans.operations') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-operations">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                    href="{{ route('recordedClasses.edit', $class->id) }}">
                                                    <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                    {{ trans('main_trans.edit') }}
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-lesson{{ $class->id }}">
                                                    <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                    {{ trans('main_trans.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal حذف الدرس -->
                            <div class="modal fade" id="deleteModal-lesson{{ $class->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                        </div>
                                        <form id="deleteClassForm"
                                            action="{{ route('recordedClasses.destroy', $class->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body text-center">
                                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="submit" form="deleteClassForm"
                                                    class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                                <button type="button" class="btn btn-cancel"
                                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $classes->links('vendor.pagination.custom') }}
            </div>
        </div>

    </div>


    {{-- search input code --}}
    <script>
        document.getElementById('classesSearch').addEventListener('input', function() {
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
