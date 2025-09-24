@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">{{ $section->My_classs->Grades->Name }} -
            {{ $section->My_classs->Name_Class }} - {{ $section->Name_Section }} "</h3>
        <div class="title-underline-manager"></div>

        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table">
                        <a href="#" data-bs-toggle="modal"
                            data-bs-target="#addTeacherSectionModal">{{ trans('main_trans.add_teacher') }}</a>
                        <input type="search" id="studentSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive manager-table-wrapper">
                        @include('components.error-field')
                        <table class="text-center manager-grade-table" id="datatable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.Name_Teacher') }}</th>
                                    <th>{{ trans('Students_trans.subject') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sectionTeachers as $teacher)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $teacher->teacher->user->name }}</td>
                                        <td>{{ $teacher->subject->name }}</td>
                                        <td>
                                            <i class="fas fa-trash-alt action-icon delete-icon-action"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $teacher->id }}">
                                            </i>
                                        </td>
                                    </tr>

                                    <!-- Modal حذف المعلم -->
                                    <div class="modal fade" id="deleteModal{{ $teacher->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                                </div>
                                                <form id="{{ $teacher->id }}"
                                                    action="{{ route('TeacherSections.destroy', $teacher->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                                    </div>
                                                </form>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="submit" form="{{ $teacher->id }}"
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

                        <!-- مودال اضافة معلم للشعبة -->
                        <div class="modal fade custom-modal" id="addTeacherSectionModal" tabindex="-1"
                            aria-labelledby="addTeacherSectionModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                <div class="modal-content custom-modal-content">

                                    <!-- رأس المودال -->
                                    <div class="modal-header custom-modal-header">
                                        <h5 class="modal-title custom-modal-title" id="addTeacherSectionModalLabel">
                                            {{ trans('main_trans.add_teacher') }}</h5>
                                    </div>

                                    <!-- جسم المودال -->
                                    <div class="modal-body custom-modal-body">
                                        <form id="sectionTeachersModal" action="{{ route('TeacherSections.store') }}"
                                            method="POST" class="custom-form">
                                            @csrf

                                            @include('forms._form-teacherSection')

                                        </form>
                                        <!-- تذييل المودال -->
                                        <div class="modal-footer custom-modal-footer-manager">
                                            <button type="submit" form="sectionTeachersModal"
                                                class="btn btn-primary custom-save-btn"
                                                form="stageForm">{{ trans('main_trans.submit') }}</button>
                                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
