@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('main_trans.exam_details') }}</h3>
        <div class="title-underline"></div>

        <div class="student-data">

            <!-- tabs -->
            <ul class="nav nav-tabs nav-exam-data" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab">{{ trans('main_trans.details') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions"
                        type="button" role="tab">{{ trans('main_trans.questions') }}</button>
                </li>

                <div class="dropdown">
                    <button class="dropdown-toggle dropdown-toggle-detalis" data-bs-toggle="dropdown">
                        {{ trans('main_trans.more') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-operations">

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('exams.edit', $exam->id) }}">
                                <i class="fas fa-edit action-icon edit-icon-action"></i> {{ trans('main_trans.edit') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal"
                                data-bs-target="#deleteModal-exam{{ $exam->id }}">
                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                {{ trans('main_trans.delete') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>

            <!-- content -->
            <div class="table-users mt-5">
                <div class="table-content tab-content" id="myTabContent">
                    <!-- exam details -->
                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <div class="container">
                            <div class="exam-table table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('main_trans.exam_name') }}</td>
                                            <td>{{ $exam->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('main_trans.instructions') }}</td>
                                            <td> {{ $exam->description }} </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.subject') }}</td>
                                            <td>{{ $exam->subject->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.duration') }}</td>
                                            <td>{{ $exam->duration }} minute/minutes</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.start_at') }}</td>
                                            <td>{{ $exam->start_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.end_at') }}</td>
                                            <td>{{ $exam->end_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.Final_grade') }}</td>
                                            <td>{{ $exam->maximum_grade }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.Total_question_scores') }}</td>
                                            <td>{{ $exam->total_marks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- questions -->
                    <div class="tab-pane fade" id="questions" role="tabpanel">

                        <div class="custom-form-container container">
                            <form action="{{ route('exam.questions.updateSettings', $exam->id) }}" method="POST"
                                class="mb-4">
                                @csrf
                                @method('PUT')
                                <div class="row align-items-center g-3">


                                    <!-- العمود الأول: الدرجة النهائية -->
                                    <div class="col-md-8 col-12">
                                        <div class="form-group-float position-relative">
                                            <input type="number" name="maximum_grade" step="0.01"
                                                class="form-control custom-input-form float-input" placeholder=" "
                                                value="{{ $exam->maximum_grade }}" />
                                            <label class="float-label">{{ trans('Teacher_trans.Final_grade') }}</label>
                                        </div>
                                    </div>

                                    <!-- العمود الثاني: تبديل ترتيب الأسئلة -->
                                    <div class="col-md-2 col-12 d-flex align-items-center">
                                        <label class="custom-checkbox-label m-0">
                                            <input type="checkbox" class="custom-checkbox" name="shuffle_questions"
                                                id="shuffle_questions" {{ $exam->shuffle_questions ? 'checked' : '' }}>
                                            {{ trans('Teacher_trans.shuffle_questions') }}
                                        </label>
                                    </div>

                                    <!-- العمود الثالث: زر حفظ -->
                                    <div class="col-md-2 col-12">
                                        <button type="submit"
                                            class="custom-btn-save">{{ trans('main_trans.Save_modifications') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="container custom-table-teacher">

                            <div class="table-responsive custom-table-wrapper">
                                <table class="table text-center custom-grade-table">
                                    <thead class="thead-custom">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('Teacher_trans.question') }}</th>
                                            <th>{{ trans('Teacher_trans.category') }}</th>
                                            <th>{{ trans('Teacher_trans.type') }}</th>
                                            <th>{{ trans('Teacher_trans.score') }}</th>
                                            <th>{{ trans('Teacher_trans.operations') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exam->questions as $question)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $question->question }}</td>
                                                <td>{{ $question->QCategory->title }}</td>
                                                <td>{{ $question->pivot->score }}</td>
                                                <td>{{ $question->type }}</td>
                                                <td>
                                                    {{-- <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal-question">
                                                        <i class="fas fa-trash-alt action-icon delete-icon-action"
                                                            title="حذف السؤال"></i>
                                                    </a> --}}
                                                    <form method="POST"
                                                        action="{{ route('exam.remove-question', [$exam->id, $question->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">{{ trans('Teacher_trans.delete') }}</button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="dropdown">
                                    <button class="operations-btn-exam dropdown-toggle" data-bs-toggle="dropdown">
                                        {{ trans('Teacher_trans.add_new_question') }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-subjects">

                                        {{-- <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                href="teacher-forms/teacher-add-question.html">
                                                {{ trans('Teacher_trans.add_new_question') }}
                                            </a>
                                        </li> --}}
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal" data-bs-target="#addModal-questionBank">
                                                {{ trans('Teacher_trans.from_q_b') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal" data-bs-target="#addModal-questionRandom">
                                                {{ trans('Teacher_trans.random_q') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="modal fade custom-modal" id="addModal-questionRandom" tabindex="-1"
                                    aria-labelledby="addModal-questionRandom" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                        <div class="modal-content custom-modal-content">

                                            <!-- رأس المودال -->
                                            <div class="modal-header custom-modal-header">
                                                <h5 class="modal-title custom-modal-title" id="addModal-questionRandom">
                                                    {{ trans('Teacher_trans.random_Q') }}</h5>
                                            </div>

                                            <!-- جسم المودال -->
                                            <div class="modal-body custom-modal-body">
                                                <form id="randomQForm" class="custom-form" method="POST"
                                                    action="{{ route('exam.questions.storeRandom', $exam->id) }}">
                                                    @csrf
                                                    <div class="mb-3 custom-form-group">
                                                        <select class="form-select custom-select" name="category_id">
                                                            <option selected disabled>
                                                                {{ trans('Teacher_trans.select_category') }}</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3 custom-form-group">
                                                        <div class="form-group-float position-relative ">
                                                            <input type="number" name="random_count" min="1"
                                                                class="form-control custom-input float-input"
                                                                placeholder=" " />
                                                            <label for=""
                                                                class="float-label">{{ trans('Teacher_trans.random_Q_number') }}*</label>
                                                        </div>
                                                    </div>


                                                </form>
                                            </div>

                                            <!-- تذييل المودال -->
                                            <div class="modal-footer custom-modal-footer">
                                                <button type="submit" form="randomQForm"
                                                    class="btn btn-primary custom-save-btn">{{ trans('main_trans.add') }}</button>
                                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade custom-modal" id="addModal-questionBank" tabindex="-1"
                                    aria-labelledby="addModal-questionBank" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered custom-modal-dialog modal-lg">
                                        <div class="modal-content custom-modal">
                                            <!-- رأس المودال -->
                                            <div class="modal-header custom-modal-header">
                                                <h5 class="modal-title custom-modal-title" id="addModal-questionBank">
                                                    {{ trans('Teacher_trans.from_QB') }}</h5>
                                            </div>

                                            <form id="addFromBankForm" method="POST"
                                                action="{{ route('exam.questions.storeFromBank', $exam->id) }}">
                                                @csrf
                                                <div class="modal-body custom-modal-body">
                                                    <div class="mb-3 custom-form">
                                                        <select class="form-select custom-select" id="bankCategorySelect">
                                                            <option selected disabled>
                                                                {{ trans('Teacher_trans.select_category') }}</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <input type="checkbox" id="selectAll"> Select All --}}

                                                    <!-- الجدول -->
                                                    <div class="table-responsive" id="questionsTableWrapper">
                                                        <table class="table table-bordered custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox"
                                                                            id="selectAll"class="form-check-input">
                                                                    </th>
                                                                    <th>{{ trans('Teacher_trans.question') }}</th>
                                                                    <th>{{ trans('Teacher_trans.type') }}</th>
                                                                    <th>{{ trans('Teacher_trans.score') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="questionsTableBody">
                                                                <!-- AJAX Autoload -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="modal-footer custom-modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary custom-save-btn">{{ trans('Teacher_trans.save') }}</button>
                                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                        data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- delete exam modal -->
            <div class="modal fade" id="deleteModal-exam{{ $exam->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                    <div class="modal-content">
                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('main_trans.close') }}"></button>
                            </div>
                            <div class="modal-body text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                            </div>
                            <div class="modal-footer custom-modal-footer">
                                <button type="submit" class="btn btn-primary custom-save-btn">
                                    {{ trans('main_trans.delete') }}</button>
                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <!-- JavaScript to handle category change and fetch questions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('bankCategorySelect');
            const questionsTableWrapper = document.getElementById('questionsTableWrapper');
            const questionsTableBody = document.getElementById('questionsTableBody');

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                if (!categoryId) return;

                fetch(`/exam/questions-by-category/${categoryId}`)
                    .then(res => res.json())
                    .then(data => {
                        const questions = data.questions;
                        questionsTableBody.innerHTML = '';

                        if (!Array.isArray(questions) || questions.length === 0) {
                            questionsTableWrapper.style.display = 'none';
                            return;
                        }

                        questions.forEach(question => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                            <td><input type="checkbox" class="itemCheckbox" name="question_ids[]" value="${question.id}"></td>
                            <td>${question.question}</td>
                            <td>${question.type}</td>
                            <td>${question.score}</td>
                        `;
                            questionsTableBody.appendChild(tr);
                        });

                        questionsTableWrapper.style.display = 'block';
                    })
                    .catch(error => {
                        console.error("حدث خطأ أثناء تحميل الأسئلة:", error);
                        questionsTableWrapper.style.display = 'none';
                    });
            });
        });
    </script>

    <!-- select all -->
    <script>
        $(document).ready(function() {
            $('#selectAll').click(function() {
                $('.itemCheckbox').prop('checked', this.checked);
            });
        });
    </script>

    <!-- search input code -->
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
