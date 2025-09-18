@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('Teacher_trans.add_new_quizz') }}</h3>
        <div class="title-underline"></div>

        <div class="container custom-table-teacher">
            <div class="header-table-teacher">
                <a href="#" id="submitSelected">{{ trans('Teacher_trans.add_selected') }}</a>
                <div class="search-box-student text-end mb-3">
                    <input type="search" id="examSearch" class="form-control search-input-custom"
                        placeholder="{{ trans('main_trans.search') }}">
                </div>
            </div>
            <div class="table-responsive custom-table-wrapper">
                <div class="card-body">
                    @include('components.error-field')

                    <form id="addSectionExamForm" method="POST" action="{{ route('sectionsExams.store') }}">
                        @csrf

                        <input type="hidden" value="{{ $teacher_section->section_id }}" name="section_id">
                        <input type="hidden" value="{{ $teacher_section->id }}" name="teacher_section_id">
                        <input type="hidden" name="subject_id" value="{{ $teacher_section->subject_id }}">


                        <table class="text-center custom-grade-table" id="datatable">
                            <thead class="thead-custom">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Teacher_trans.quizz_name') }}</th>
                                    <th>{{ trans('Teacher_trans.subject') }} </th>
                                    <th>{{ trans('Teacher_trans.start_at') }} </th>
                                    <th>{{ trans('Teacher_trans.duration') }} </th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="exam_ids[]" value="{{ $exam->id }}">
                                        </td>
                                        <td>{{ $exam->name }}</td>
                                        <td>{{ $exam->subject->name }}</td>
                                        <td>{{ $exam->start_at }}</td>
                                        <td>{{ $exam->duration }} minutes</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ trans('main_trans.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // Submit the form when the "Add Selected" link is clicked
        document.getElementById('submitSelected').addEventListener('click', function(e) {
            e.preventDefault(); // prevent the default link behavior
            document.getElementById('addSectionExamForm').submit(); // find the form and submit it
        });
    </script>
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
