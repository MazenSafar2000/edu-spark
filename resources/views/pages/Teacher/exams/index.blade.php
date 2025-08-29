@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    {{-- <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title">{{ trans('Teacher_trans.exams_list') }}</h3>

        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a href="{{ route('exams.create') }}">{{ trans('Teacher_trans.add_new_quizz') }}</a>
                        <input type="search" id="examSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">

                    </div>

                    <div class="table-responsive">
                        <table class="table text-center custom-user-table-teacher" id="datatable">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.quizz_name') }}</th>

                                    <th>{{ trans('Teacher_trans.durartion') }} </th>
                                    <th>{{ trans('Teacher_trans.start_at') }} </th>
                                    <th>{{ trans('Teacher_trans.end_at') }} </th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exams as $exam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $exam->name }}</td>

                                        <td>{{ $exam->duration }} minutes</td>
                                        <td>{{ $exam->start_at }}</td>
                                        <td>{{ $exam->end_at }}</td>
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('exams.show', $exam->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            show
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('exams.edit', $exam->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteExamModal-exam{{ $exam->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('delet') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('exams.show', $exam->id) }}">
                                                            <i
                                                                class="fas fa-question-circle action-icon question-icon-action"></i>
                                                            {{ trans('Teacher_trans.Show_questions') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('addQuestions', $exam->id) }}">
                                                            <i
                                                                class="fas fa-question-circle action-icon question-icon-action"></i>
                                                            add questions
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                            href="{{ route('teacher.exams.tested_students', $exam->id) }}">
                                                            <i
                                                                class="fas fa-users students-icon action-icon std-icon-action"></i>
                                                            {{ trans('Teacher_trans.Display_Tested_Students') }}
                                                        </a>
                                                    </li>


                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- delete exam modal   -->
                                    <div class="modal fade" id="deleteExamModal-exam{{ $exam->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST">
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
                            </tbody>
                        </table>
                        {{ $exams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('Teacher_trans.exams_list') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">
            <div class="header-table-teacher">
                <a href="{{ route('exams.create') }}">{{ trans('Teacher_trans.add_new_quizz') }}</a>
                <div class="search-box-student text-end mb-3">
                    <input type="search" id="examSearch" class="form-control search-input-custom"
                        placeholder="{{ trans('main_trans.search') }}">
                </div>
            </div>
            <div class="table-responsive custom-table-wrapper">
                <table class="text-center custom-grade-table" id="datatable">
                    <thead class="thead-custom">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('Teacher_trans.quizz_name') }}</th>
                            <th>{{ trans('Teacher_trans.durartion') }} </th>
                            <th>{{ trans('Teacher_trans.start_at') }} </th>
                            <th>{{ trans('Teacher_trans.end_at') }} </th>
                            <th>{{ trans('Teacher_trans.operations') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $exam)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $exam->name }}</td>

                                <td>{{ $exam->duration }} minutes</td>
                                <td>{{ $exam->start_at }}</td>
                                <td>{{ $exam->end_at }}</td>
                                <td>
                                    <a href="{{ route('exams.show', $exam->id) }}"><i
                                            class="fa-solid fa-eye action-icon eye-icon-action"
                                            title="{{ trans('main_trans.view') }}"></i>
                                    </a>
                                </td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $exams->links('vendor.pagination.custom')}}

                <!-- Modal حذف الواجب -->
                <div class="modal fade" id="deleteModal-exam" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="إغلاق"></button>
                            </div>
                            <div class="modal-body text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <p>هل أنت متأكد أنك تريد حذف هذا الاختبار ؟</p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-del">تأكيد الحذف</button>
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">إلغاء</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- search input code --}}
    <script>
        document.getElementById('examSearch').addEventListener('input', function() {
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
