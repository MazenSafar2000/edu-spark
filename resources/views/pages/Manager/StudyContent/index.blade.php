@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <!-- التبويبات -->
        <ul class="nav nav-tabs mb-3 nav-std" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="#" data-bs-toggle="tab" data-bs-target="#books" type="button"
                    role="tab">{{ trans('main_trans.books') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="#" data-bs-toggle="tab" data-bs-target="#homeworks" type="button"
                    role="tab">{{ trans('main_trans.homeworks') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="#" data-bs-toggle="tab" data-bs-target="#exams" type="button"
                    role="tab">{{ trans('main_trans.exams') }}</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="#" data-bs-toggle="tab" data-bs-target="#lessons" type="button"
                    role="tab">{{ trans('main_trans.recordedCLasses') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="#" data-bs-toggle="tab" data-bs-target="#subjects" type="button"
                    role="tab">{{ trans('main_trans.zoomClasses') }}</button>
            </li>
        </ul>

        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- books -->
                <div class="tab-pane fade show active" id="books" role="tabpanel">
                    <div class="header-table">
                        <a href="{{ route('books.create') }}">{{ trans('Teacher_trans.add_new_book') }}</a>
                        <input type="search" id="booksSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>
                    <div class="table-responsive manager-table-wrapper">
                        <table class="text-center manager-grade-table" id="bookTable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.book_name') }}</th>
                                    <th>{{ trans('Students_trans.Grade') }}</th>
                                    <th>{{ trans('Students_trans.classrooms') }}</th>
                                    <th>{{ trans('Students_trans.section') }}</th>
                                    <th>{{ trans('Students_trans.subject') }}</th>
                                    <th>{{ trans('main_trans.Teacher') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->grade->Name }}</td>
                                        <td>{{ $book->classroom->Name_Class }}</td>
                                        <td>{{ $book->section->Name_Section }}</td>
                                        <td>{{ $book->subject->name }}</td>
                                        <td>{{ $book->teacher->user->name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle dropdown-toggle-operations"
                                                    data-bs-toggle="dropdown">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-operations">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            target="_blank"
                                                            href="{{ asset('storage/attachments/library/teachers/' . $book->teacher->user->National_ID . '/' . $book->file_name) }}">
                                                            <i
                                                                class="fa-solid fa-download action-icon download-icon-action"></i>
                                                            {{ trans('Teacher_trans.download') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('books.edit', $book->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-book{{ $book->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
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
                        {{ $books->links('vendor.pagination.custom') }}

                        @foreach ($books as $book)
                            <!-- delet book modal -->
                            <div class="modal fade" id="deleteModal-book{{ $book->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="{{ trans('Grades_trans.Close') }}"></button>
                                        </div>
                                        <form id="deleteBookForm" action="{{ route('books.destroy', $book->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body text-center">
                                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                            </div>
                                        </form>
                                        <div class="modal-footer justify-content-center">
                                            <button type="submit" form="deleteBookForm"
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

                <!-- homeworks -->
                <div class="tab-pane fade" id="homeworks" role="tabpanel">
                    <div class="add-std">
                        <a href="{{ route('Homework.create') }}"
                            class="add-std-btn">{{ trans('Teacher_trans.add_new_homework') }}</a>
                    </div>

                    <div class="header-table">
                        <div class="select-std d-flex gap-2 flex-wrap">

                        </div>

                        <input type="search" id="homeworkSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>


                    <div class="table-responsive manager-table-wrapper">
                        <table class="table text-center manager-grade-table" id="homeworksTable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.homework_title') }}</th>
                                    <th>{{ trans('Teacher_trans.grade') }} </th>
                                    <th>{{ trans('Teacher_trans.classroom') }} </th>
                                    <th>{{ trans('Teacher_trans.section') }} </th>
                                    <th>{{ trans('Teacher_trans.subject') }} </th>
                                    <th>{{ trans('Teacher_trans.total_degree') }}</th>
                                    <th>{{ trans('Teacher_trans.allow_multiple_submissions') }}</th>
                                    <th>{{ trans('Teacher_trans.homework_due_date') }} </th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($homeworks as $homework)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="max-width: 200px">{{ $homework->title }}</td>
                                        <td>{{ $homework->grade->Name }}</td>
                                        <td>{{ $homework->classroom->Name_Class }}</td>
                                        <td>{{ $homework->section->Name_Section }}</td>
                                        <td>{{ $homework->subject->name }}</td>
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
                                                            href="{{ route('Homework.submissions', $homework->id) }}">
                                                            <i
                                                                class="fas fa-users students-icon action-icon std-icon-action"></i>
                                                            {{ trans('Teacher_trans.Display_Delivered_Students') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('Homework.edit', $homework->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
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
                                                <form id="deleteHomework"
                                                    action="{{ route('Homework.destroy', $homework->id) }}"
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

                                @empty
                                    <td class="alert-danger" colspan="8">{{ trans('main_trans.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $homeworks->links('vendor.pagination.custom') }}
                    </div>
                </div>

                <!-- exams -->
                <div class="tab-pane fade" id="exams" role="tabpanel">
                    <div class="add-std">
                        <a href="{{ route('Exams.create') }}"
                            class="add-std-btn">{{ trans('Teacher_trans.add_new_quizz') }}</a>
                    </div>

                    <div class="header-table">
                        <div class="select-std d-flex gap-2 flex-wrap">

                        </div>

                        <input type="search" id="examSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>


                    <div class="table-responsive manager-table-wrapper">
                        <table class="table text-center manager-grade-table">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.quizz_name') }}</th>
                                    <th>{{ trans('Teacher_trans.duration') }} </th>
                                    <th>{{ trans('Teacher_trans.start_at') }} </th>
                                    <th>{{ trans('Teacher_trans.end_at') }} </th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exams as $exam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $exam->name }}</td>

                                        <td>{{ $exam->duration }} minutes</td>
                                        <td>{{ $exam->start_at }}</td>
                                        <td>{{ $exam->end_at }}</td>
                                        <td>
                                            <a href="{{ route('Exam.results', $exam->id) }}"><i
                                                    class="fa-solid fa-eye action-icon eye-icon-action"
                                                    title="{{ trans('main_trans.view') }}"></i>
                                            </a>
                                        </td>
                                        </td>
                                    @empty
                                        <td class="alert-danger" colspan="8">{{ trans('main_trans.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $exams->links('vendor.pagination.custom') }}

                    </div>
                </div>

                <!-- recorded classes -->
                <div class="tab-pane fade" id="lessons" role="tabpanel">
                    <div class="add-std">
                        <a href="{{ route('RecordedClasses.create') }}"
                            class="add-std-btn">{{ trans('Teacher_trans.Add_new_recordedClass') }}</a>
                    </div>

                    <div class="header-table">
                        <div class="select-std d-flex gap-2 flex-wrap">

                        </div>

                        <input type="search" id="classesSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>

                    <div class="table-responsive manager-table-wrapper">
                        <table class="table text-center manager-grade-table" id="bookrecordedClassesTable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.Class_title') }}</th>
                                    <th>{{ trans('Teacher_trans.grade') }}</th>
                                    <th>{{ trans('Teacher_trans.classroom') }}</th>
                                    <th>{{ trans('Teacher_trans.section') }}</th>
                                    <th>{{ trans('Teacher_trans.subject') }}</th>
                                    <th>{{ trans('main_trans.Teacher') }}</th>
                                    <th>{{ trans('Teacher_trans.Class_link') }}</th>
                                    <th>{{ trans('Teacher_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recordedClasses as $class)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $class->title }}</td>
                                        <td>{{ $class->grade->Name }}</td>
                                        <td>{{ $class->classroom->Name_Class }}</td>
                                        <td>{{ $class->section->Name_Section }}</td>
                                        <td>{{ $class->subject->name }}</td>
                                        <td>{{ $class->teacher->user->name }}</td>
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
                                                            href="{{ route('RecordedClasses.edit', $class->id) }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
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
                                                    action="{{ route('RecordedClasses.destroy', $class->id) }}"
                                                    method="POST">
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
                                @empty
                                    <td class="alert-danger" colspan="8">{{ trans('main_trans.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $recordedClasses->links('vendor.pagination.custom') }}
                    </div>
                </div>

                <!-- zoom classes -->
                <div class="tab-pane fade" id="subjects" role="tabpanel">
                    <div class="header-table">
                        <div class="add-meet d-flex gap-2 flex-wrap">
                            <a
                                href="{{ route('zoomCLasses.create.indirect') }}">{{ trans('Teacher_trans.Add_manual_meeting') }}</a>

                            <a
                                href="{{ route('zoomCLasses.create') }}">{{ trans('Teacher_trans.Add_automatic_meeting') }}</a>
                        </div>

                        <div class="search-box-student text-end mb-3">
                            <input type="search" id="zoomSearch" class="form-control search-input-custom"
                                placeholder="{{ trans('Teacher_trans.search') }}">
                        </div>
                    </div>

                    <div class="table-responsive manager-table-wrapper">
                        <table class="table text-center manager-grade-table" id="zoomClassesTable">
                            <thead class="thead-manager">
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
                                        <td class="text-danger"><a href="{{ $zoomClass->join_url }}"
                                                target="_blank">{{ trans('main_trans.join_now') }}</a></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle dropdown-toggle-operations"
                                                    data-bs-toggle="dropdown">
                                                    {{ trans('Teacher_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-operations">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-meet{{ $zoomClass->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
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
                                        <form id="deleteZoomForm"
                                            action="{{ route('zoomCLasses.destroy', $zoomClass->id) }}" method="POST">
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
        </div>
    </div>

    {{-- search input code --}}
    <script>
        document.getElementById('booksSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('bookTable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });

        document.getElementById('classesSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('bookrecordedClassesTable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });

        document.getElementById('homeworkSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('homeworksTable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });

        document.getElementById('zoomSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('zoomClassesTable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
