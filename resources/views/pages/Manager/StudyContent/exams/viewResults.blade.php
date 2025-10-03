@extends('layouts.main.manager_dashboard')
@section('manager_content')
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
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="resuls-tab" data-bs-toggle="tab" data-bs-target="#resuls" type="button"
                        role="tab">{{ trans('main_trans.results') }}</button>
                </li>


                <div class="dropdown">
                    <button class="dropdown-toggle dropdown-toggle-detalis" data-bs-toggle="dropdown">
                        {{ trans('main_trans.more') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-operations">

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('Exams.edit', $sectionExam->id) }}">
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
                            <form action="{{ route('Exams.questions.updateSettings', $exam->id) }}" method="POST"
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
                                                <td>{{ $question->type }}</td>
                                                <td>
                                                    <span class="editable-score" data-exam="{{ $exam->id }}"
                                                        data-question="{{ $question->id }}">
                                                        {{ $question->pivot->score }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('Exam.remove-question', [$exam->id, $question->id]) }}">
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

                                <!-- random questions modal -->
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
                                                    action="{{ route('Exam.questions.storeRandom', $exam->id) }}">
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
                                                action="{{ route('Exam.questions.storeFromBank', $exam->id) }}">
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

                    <!-- results -->
                    <div class="tab-pane fade" id="resuls" role="tabpanel">
                        <div class="charts-wrapper">
                            <div class="chart-box">
                                <canvas id="barChart"></canvas>
                            </div>

                            <div class="chart-box">
                                <canvas id="donutChart"></canvas>
                            </div>
                        </div>


                        <div class="container custom-table-teacher">

                            <div class="search-box-student  mb-3 d-flex justify-content-between">
                                <input type="search" id="studentSearch" class="form-control search-input-custom"
                                    placeholder="{{ trans('Teacher_trans.search') }}">

                                <div class="btn-export-zero d-flex align-items-center">
                                    <form action="{{ route('Exam.toggleShowGrade', $sectionExam->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex checkbox-show-result">
                                            <label class="custom-checkbox-label2">
                                                <input type="checkbox" class="custom-checkbox" name="show_answers"
                                                    value="1" onchange="this.form.submit()"
                                                    {{ $sectionExam->show_answers ? 'checked' : '' }}>
                                                {{ trans('main_trans.View_students_grades') }}
                                            </label>
                                        </div>
                                    </form>

                                    <a href="{{ route('manager.exam.export', $exam->id) }}" class="btn-export"><i
                                            class="fas fa-file-excel"></i> {{ trans('Teacher_trans.export') }}</a>

                                    <form action="{{ route('Exam.assignZeros', $exam->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf

                                        <button type="submit" class="btn-zero"><i class="fas fa-user-times"></i>
                                            {{ trans('Teacher_trans.set_zero') }}</button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive custom-table-wrapper">
                                <table class="text-center custom-grade-table" id="datatable">
                                    <thead class="thead-custom">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('Teacher_trans.student_name') }}</th>
                                            <th>{{ trans('Teacher_trans.score') }}</th>
                                            <th>{{ trans('main_trans.Delivery_date') }}</th>
                                            <th>{{ trans('Teacher_trans.operations') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                            @php
                                                $attempt = $attempts[$student->id] ?? null;
                                                $degree = $degrees[$student->id] ?? null;
                                                $grade =
                                                    $degrees[$student->id]->score ??
                                                    ($attempts[$student->id]->grade_obtained ?? null);
                                                $currentGrade = $degree->score ?? '';
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $student->user->name }}</td>
                                                <td>
                                                    @if ($grade !== null)
                                                        {{ number_format($grade, 2) }} / {{ $exam->maximum_grade }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($attempt && $attempt->ended_at)
                                                        {{ $attempt->ended_at->format('d-m-Y h:ia') }}
                                                    @else
                                                        {{ trans('main_trans.not_examed') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="dropdown-toggle dropdown-toggle-operations"
                                                            data-bs-toggle="dropdown">
                                                            {{ trans('Teacher_trans.operations') }}
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-operations">
                                                            @if ($attempt)
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                                        href="{{ route('manager.exam.studentAttempts', [$exam->id, $student->id]) }}">
                                                                        <i
                                                                            class="fas fa-eye eye-icon-action"></i>{{ trans('Teacher_trans.show_attempts') }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center gap-2"
                                                                    href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#addGradeModal{{ $student->id }}">
                                                                    <i
                                                                        class="fas fa-edit action-icon edit-icon-action"></i>
                                                                    {{ trans('Teacher_trans.editScore') }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal: Edit grade -->
                                            <div class="modal fade custom-modal" id="addGradeModal{{ $student->id }}"
                                                tabindex="-1" aria-labelledby="addGradeModal" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                                    <div class="modal-content custom-modal-content">

                                                        <!-- رأس المودال -->
                                                        <div class="modal-header custom-modal-header">
                                                            <h5 class="modal-title custom-modal-title" id="addGradeModal">
                                                                {{ trans('Teacher_trans.update_score') }}<span>
                                                                    {{ $student->user->name }}</span></h5>
                                                        </div>

                                                        <!-- جسم المودال -->
                                                        <div class="modal-body custom-modal-body">
                                                            <form id="scoreForm" class="custom-form" method="POST"
                                                                action="{{ route('manager.manual.degree.store') }}">
                                                                @csrf
                                                                <input type="hidden" name="student_id"
                                                                    value="{{ $student->id }}">
                                                                <input type="hidden" name="exam_id"
                                                                    value="{{ $exam->id }}">

                                                                <div class="mb-3 custom-form-group">
                                                                    <div class="form-group-float position-relative ">
                                                                        <input type="number" step="0.01"
                                                                            name="score"
                                                                            class="form-control custom-input float-input"
                                                                            placeholder=" "
                                                                            value="{{ $currentGrade }}" />
                                                                        <label for=""
                                                                            class="float-label">score</label>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3 custom-form-group">
                                                                    <textarea class="form-control custom-textarea" name="feedback" id="stageNotes" rows="3"
                                                                        placeholder="{{ trans('Teacher_trans.Feedback') }}">{{ $degree?->feedback ?? '' }}</textarea>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <!-- تذييل المودال -->
                                                        <div class="modal-footer custom-modal-footer">
                                                            <button type="submit" class="btn btn-primary custom-save-btn"
                                                                form="scoreForm">{{ trans('Teacher_trans.save') }}</button>
                                                            <button type="button"
                                                                class="btn btn-secondary custom-cancel-btn"
                                                                data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
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
                        <form action="{{ route('Exams.destroy', $exam->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('main_trans.close') }}"></button>
                            </div>
                            <div class="modal-body text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <p>{{ trans('main_trans.Delete_Warning') }}</p>
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

                fetch(`/Exam/questions_by_category/${categoryId}`)
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

    <!-- charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Donut Chart
            var ctxDonut = document.getElementById("donutChart").getContext("2d");
            new Chart(ctxDonut, {
                type: "doughnut",
                data: {
                    labels: ["{{ trans('Teacher_trans.tested') }}",
                        "{{ trans('Teacher_trans.did_not_perform') }}",
                        "{{ trans('Teacher_trans.succeeded') }}",
                        "{{ trans('Teacher_trans.failed') }}"
                    ],
                    datasets: [{
                        data: [
                            {{ $stats['attempted'] }},
                            {{ $stats['not_attempted'] }},
                            {{ $stats['success'] }},
                            {{ $stats['fail'] }}
                        ],
                        backgroundColor: ["#36A2EB", "#FFCE56", "#4CAF50", "#F44336"]
                    }]
                }
            });

            // Bar Chart
            var ctxBar = document.getElementById("barChart").getContext("2d");
            new Chart(ctxBar, {
                type: "bar",
                data: {
                    labels: {!! json_encode(array_keys($distribution)) !!},
                    datasets: [{
                        label: "{{ trans('Teacher_trans.number_students') }}",
                        data: {!! json_encode(array_values($distribution)) !!},
                        backgroundColor: "#52a447"
                    }]
                }
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

    <script>
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("editable-score")) {
                let span = e.target;
                let currentScore = span.textContent.trim();
                let examId = span.dataset.exam;
                let questionId = span.dataset.question;

                // إنشاء input
                let input = document.createElement("input");
                input.type = "number";
                input.value = currentScore;
                input.classList.add("form-control", "form-control-sm");
                input.style.width = "80px";

                span.replaceWith(input);
                input.focus();

                input.addEventListener("blur", function() {
                    let newScore = this.value;

                    fetch(`/manager/exam/${examId}/question/${questionId}/update-score`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                score: newScore
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                let newSpan = document.createElement("span");
                                newSpan.textContent = data.score;
                                newSpan.classList.add("editable-score");
                                newSpan.dataset.exam = examId;
                                newSpan.dataset.question = questionId;

                                this.replaceWith(newSpan);
                            }
                        });
                });

                // كمان تخلي Enter يعمل حفظ
                input.addEventListener("keydown", function(e) {
                    if (e.key === "Enter") {
                        this.blur(); // نفس تأثير الخروج
                    }
                });
            }
        });
    </script>
@endsection
