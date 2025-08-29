@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
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
                            <th>{{ trans('Teacher_trans.duration') }} </th>
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
                {{ $exams->links('vendor.pagination.custom') }}

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
