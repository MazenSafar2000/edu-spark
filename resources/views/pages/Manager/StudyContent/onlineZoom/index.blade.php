@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('Teacher_trans.Online_classes') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">
            <div class="header-table-teacher">
                <div class="add-meet d-flex gap-2 flex-wrap">
                    <a href="{{ route('ZoomClasses.create.indirect') }}">{{ trans('Teacher_trans.Add_manual_meeting') }}</a>

                    <a href="{{ route('ZoomClasses.create') }}">{{ trans('Teacher_trans.Add_automatic_meeting') }}</a>
                </div>

                <div class="search-box-student text-end mb-3">
                    <input type="search" id="zoomSearch" class="form-control search-input-custom"
                        placeholder="{{ trans('Teacher_trans.search') }}">
                </div>
            </div>


            <div class="table-responsive custom-table-wrapper">
                <table class="text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Teacher_trans.Class_title') }}</th>
                            <th>{{ trans('Teacher_trans.grade') }}</th>
                            <th>{{ trans('Teacher_trans.classroom') }}</th>
                            <th>{{ trans('Teacher_trans.section') }}</th>
                            <th>{{ trans('Teacher_trans.Start_date') }}</th>
                            <th>{{ trans('Teacher_trans.Class_time') }}</th>
                            <th>{{ trans('Teacher_trans.Class_link') }}</th>
                            <th>{{ trans('Teacher_trans.operations') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($zoomClasses as $zoomClass)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $zoomClass->topic }}</td>
                                <td>{{ $zoomClass->grade->Name }}</td>
                                <td>{{ $zoomClass->classroom->Name_Class }}</td>
                                <td>{{ $zoomClass->section->Name_Section }}</td>
                                <td>{{ $zoomClass->start_at }}</td>
                                <td>{{ $zoomClass->duration }}</td>
                                <td class="text-danger"><a href="{{ $zoomClass->join_url }}" target="_blank">{{ trans('main_trans.join_now') }}</a></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle dropdown-toggle-operations"
                                            data-bs-toggle="dropdown">
                                            {{ trans('Teacher_trans.operations') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-operations">
                                            {{-- <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                    href="teacher-forms/teacher-edit-meet.html">
                                                    <i class="fas fa-edit action-icon edit-icon-action"></i> {{ trans('main_trans.edit') }}
                                                </a>
                                            </li> --}}

                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-meet{{ $zoomClass->id }}">
                                                    <i class="fas fa-trash-alt action-icon delete-icon-action"></i> {{ trans('main_trans.delete') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            @empty
                                <td class="alert-danger" colspan="8">{{ trans('main_trans.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $zoomClasses->links('vendor.pagination.custom') }}

                @foreach ($zoomClasses as $zoomClass)
                    <!-- delete zoom class modal-->
                    <div class="modal fade" id="deleteModal-meet{{ $zoomClass->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                </div>
                                <form id="deleteZoomForm" action="{{ route('ZoomClasses.destroy', $zoomClass->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                        <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                    </div>
                                </form>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" form="deleteZoomForm"
                                        class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                    <button type="button" class="btn btn-cancel"
                                        data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
@section('js')
    {{-- search input code --}}
    <script>
        document.getElementById('zoomSearch').addEventListener('input', function() {
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
