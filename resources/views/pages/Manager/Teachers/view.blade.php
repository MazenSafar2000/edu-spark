@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="manager-header">{{ trans('main_trans.teacher_information') }}</h3>
        <div class="title-underline-manager2"></div>

        <div class="student-data">

            <ul class="nav nav-tabs mb-3 nav-std-data" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab">{{ trans('main_trans.teacher_information') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#classroomTeacher"
                        type="button" role="tab">{{ trans('main_trans.his_sections') }}</button>
                </li>
            </ul>


            <div class="table-users mt-5">
                <!-- المحتوى -->
                <div class="table-content tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <div class="container">
                            <div class="student-table table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('main_trans.name') }}</td>
                                            <td>{{ $teacher->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('main_trans.National_ID') }}</td>
                                            <td>{{ $teacher->National_ID }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('main_trans.specialization') }}</td>
                                            <td>{{ $teacher->specializations->Name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.Joining_Date') }}</td>
                                            <td>{{ $teacher->Joining_Date }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('main_trans.Address') }}</td>
                                            <td>{{ $teacher->Address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="classroomTeacher" role="tabpanel">
                        <div class="header-table">
                            <input type="search" id="sectionSearch" class="form-control search-input"
                                placeholder="{{ trans('main_trans.search') }}">
                        </div>
                        <div class="table-responsive manager-table-wrapper">
                            <table class="table text-center manager-grade-table" id="datatable">
                                <thead class="thead-manager">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('main_trans.Grade') }}</th>
                                        <th>{{ trans('main_trans.classroom') }}</th>
                                        <th>{{ trans('main_trans.section') }}</th>
                                        <th>{{ trans('main_trans.subject_name') }}</th>
                                        <th>{{ trans('main_trans.number_students') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $section)
                                        <tr onclick="window.location.href='{{ route('teacher.section.data', ['teacherId' => $teacher->id, 'sectionId' => $section->id]) }}'"
                                            style="cursor: pointer;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $section->section->My_classs->Grades->Name }}</td>
                                            <td>{{ $section->section->My_classs->Name_Class }}</td>
                                            <td>{{ $section->section->My_classs->Name_Class }}</td>
                                            <td>{{ $section->subject->name }}</td>
                                            <td>{{ $section->section->students->count() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <!-- Modal حذف الصف -->
                            <div class="modal fade" id="deleteModal-classroom" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                            <p>هل أنت متأكد أنك تريد حذف هذا الصف ؟</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-del">تأكيد الحذف</button>
                                            <button type="button" class="btn btn-cancel"
                                                data-bs-dismiss="modal">إلغاء</button>
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

    <script>
        document.getElementById('sectionSearch').addEventListener('input', function() {
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
