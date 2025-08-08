@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="table-users-teacher mt-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5>إدارة الأسئلة - {{ $exam->title }}</h5>
                <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-light btn-sm">← العودة لتفاصيل الامتحان</a>
            </div>

            <div class="card-body">
                <form action="{{ route('exam.questions.updateSettings', $exam->id) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PUT')

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="shuffle_questions" id="shuffle_questions"
                            {{ $exam->shuffle_questions ? 'checked' : '' }}>
                        <label class="form-check-label" for="shuffle_questions">
                            تبديل ترتيب الأسئلة (Shuffle Questions)
                        </label>
                    </div>

                    <div class="mb-2">
                        <label>الدرجة النهائية (Maximum Grade)</label>
                        <input type="number" name="maximum_grade" step="0.01" class="form-control"
                            value="{{ $exam->maximum_grade }}">
                    </div>

                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </form>


                <div class="mb-3">
                    <strong>مجموع درجات الأسئلة:</strong> {{ $totalMarks }}
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>question</th>
                            <th>category</th>
                            <th>type</th>
                            <th>score</th>
                            <th>operations</th>
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
                                    <form method="POST"
                                        action="{{ route('exam.remove-question', [$exam->id, $question->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">لا توجد أسئلة مضافة بعد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="addQuestionDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        إضافة سؤال
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="addQuestionDropdown">
                        <li><a class="dropdown-item" href="{{ route('questions.create') }}" target="_blank">سؤال جديد</a>
                        </li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#addFromBankModal">من بنك الأسئلة</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#addRandomModal">سؤال عشوائي</a></li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- Modal: Add from Question Bank -->
        <div class="modal fade" id="addFromBankModal" tabindex="-1" aria-labelledby="addFromBankModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة من بنك الأسئلة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addFromBankForm" method="POST"
                            action="{{ route('exam.questions.storeFromBank', $exam->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">اختر تصنيف الأسئلة:</label>
                                <select name="category_id" id="bankCategorySelect" class="form-select">
                                    <option disabled selected>اختر تصنيفاً</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="questionsTableWrapper" style="display: none">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>اختيار</th>
                                            <th>السؤال</th>
                                            <th>النوع</th>
                                            <th>الدرجة</th>
                                        </tr>
                                    </thead>
                                    <tbody id="questionsTableBody">
                                        <!-- AJAX Autoload -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">إضافة الأسئلة المحددة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Add Random Questions -->
        <div class="modal fade" id="addRandomModal" tabindex="-1" aria-labelledby="addRandomModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة سؤال عشوائي</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('exam.questions.storeRandom', $exam->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">اختر تصنيف الأسئلة:</label>
                                <select name="category_id" class="form-select" required>
                                    <option disabled selected>اختر تصنيفاً</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">عدد الأسئلة العشوائية:</label>
                                <input type="number" name="random_count" min="1" class="form-control" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">إضافة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- <form action="" method="POST">
        @csrf

        <div class="mb-3">
            <label for="category">اختر فئة الأسئلة:</label>
            <select name="category_id" id="category-select" class="form-select">
                <option value="">اختر فئة</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <div id="questions-list">
            <!-- سيتم تحميل الأسئلة بناءً على الفئة المختارة (AJAX أو تحميل مسبق) -->
            @foreach ($questions as $question)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question_ids[]" value="{{ $question->id }}"
                        {{ in_array($question->id, $selectedQuestions) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $question->question }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success mt-3">حفظ الأسئلة</button>
    </form> --}}
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
                        const questions = data.questions; // ✅ استخراج المصفوفة من الكائن
                        questionsTableBody.innerHTML = '';

                        if (!Array.isArray(questions) || questions.length === 0) {
                            questionsTableWrapper.style.display = 'none';
                            return;
                        }

                        questions.forEach(question => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                            <td><input type="checkbox" name="question_ids[]" value="${question.id}"></td>
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
@endsection
