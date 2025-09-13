@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('main_trans.edit_question') }}</h3>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    @include('components.error-field')

                    <form class="subject-form" action="{{ route('Questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Select Category --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-danger">{{ trans('main_trans.select_teacher_name') }}*</label>
                                <select name="teacher_id" id="teacherSelect"
                                    class="form-select custom-select @error('teacher_id') custom-select-error @enderror">
                                    <option value="">{{ trans('main_trans.select_teacher_name') }}</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ $question->teacher_id == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="text-danger">{{ trans('Teacher_trans.select_category') }} *</label>
                                <select name="QCategory_id" id="categorySelect"
                                    class="form-select custom-select @error('QCategory_id') custom-select-error @enderror"
                                    data-current="{{ old('QCategory_id', $question->QCategory_id) }}"
                                    {{ $question->teacher_id ? '' : 'disabled' }}>
                                    <option value="">{{ trans('Teacher_trans.select_category') }}</option>
                                    {{-- optional: keep current as a placeholder before JS fills --}}
                                    @if ($question->QCategory)
                                        <option value="{{ $question->QCategory_id }}" selected>
                                            {{ $question->QCategory->title }}
                                        </option>
                                    @endif
                                </select>
                                @error('QCategory_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Question Text --}}
                        <div class="mb-3">
                            <label class="text-danger">{{ trans('main_trans.question_title') }} *</label>
                            <textarea name="question" class="form-control" rows="3">{{ old('question', $question->question) }}</textarea>
                        </div>

                        {{-- Question Type --}}
                        <div class="border p-3">
                            <div class="mb-3">
                                <label class="text-danger">{{ trans('main_trans.question_type') }} *</label><br>
                                <label><input type="radio" name="type" value="MCQ"
                                        {{ $question->type === 'MCQ' ? 'checked' : '' }}>{{ trans('main_trans.MCQ') }}</label>
                                <label class="ms-3"><input type="radio" name="type" value="TrueFalse"
                                        {{ $question->type === 'TrueFalse' ? 'checked' : '' }}>{{ trans('main_trans.true_false') }}</label>
                            </div>

                            {{-- MCQ Options --}}
                            <div id="mcq-options" style="{{ $question->type === 'MCQ' ? '' : 'display: none;' }}">
                                <label class="text-danger">{{ trans('main_trans.options') }} *</label>
                                <div id="answer-fields">
                                    @php
                                        $answers = old('options', json_decode($question->options, true));
                                        $correct = old('correct_answer', $question->correct_answer);
                                    @endphp
                                    @foreach ($answers as $index => $answer)
                                        <div class="input-group mb-2 answer-row">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct_answer" value="{{ $answer }}"
                                                    {{ $correct == $answer ? 'checked' : '' }}>
                                            </div>
                                            <input type="text" name="options[]" class="form-control"
                                                value="{{ $answer }}"
                                                placeholder="{{ trans('main_trans.option') }} {{ $index + 1 }}">
                                            @if (count($answers) > 2)
                                                <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-answer"
                                    class="btn btn-primary btn-sm mt-2">{{ trans('main_trans.new_option') }} +</button>
                            </div>

                            {{-- True/False Options --}}
                            <div id="true-false-options"
                                style="{{ $question->type === 'TrueFalse' ? '' : 'display: none;' }}">
                                <label class="text-danger">{{ trans('main_trans.options') }} *</label><br>
                                <label><input type="radio" name="correct_answer" value="true"
                                        {{ $question->correct_answer === 'true' ? 'checked' : '' }}>{{ trans('main_trans.true') }}</label>
                                <label class="ms-3"><input type="radio" name="correct_answer" value="false"
                                        {{ $question->correct_answer === 'false' ? 'checked' : '' }}>{{ trans('main_trans.false') }}</label>
                            </div>
                        </div>
                        @error('type')
                            <div class="error-message" id="error-bookNameArabic">
                                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                            </div>
                        @enderror

                        {{-- Score --}}
                        <div class="mb-3 mt-3">
                            <label class="text-danger">{{ trans('main_trans.score') }} *</label>
                            <select name="score" class="form-select">
                                @foreach ([1, 5, 10, 15, 20] as $val)
                                    <option value="{{ $val }}" {{ $question->score == $val ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('score')
                            <div class="error-message" id="error-bookNameArabic">
                                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                            </div>
                        @enderror

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">{{ trans('main_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const answerFields = document.getElementById('answer-fields');
            const addBtn = document.getElementById('add-answer');
            const maxAnswers = 4;

            function toggleType(type) {
                document.getElementById('mcq-options').style.display = type === 'MCQ' ? 'block' : 'none';
                document.getElementById('true-false-options').style.display = type === 'TrueFalse' ? 'block' :
                    'none';
            }

            document.querySelectorAll('input[name="type"]').forEach(radio => {
                radio.addEventListener('change', () => toggleType(radio.value));
            });

            addBtn.addEventListener('click', function() {
                const currentAnswers = answerFields.querySelectorAll('.answer-row').length;
                if (currentAnswers >= maxAnswers) return;

                const div = document.createElement('div');
                div.classList.add('input-group', 'mb-2', 'answer-row');
                div.innerHTML = `
                <div class="input-group-text">
                    <input type="radio" name="correct_answer" value="">
                </div>
                <input type="text" name="options[]" class="form-control" placeholder="{{ trans('main_trans.new_option') }}">
                <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
            `;
                answerFields.appendChild(div);
            });

            answerFields.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-answer')) {
                    const rows = answerFields.querySelectorAll('.answer-row');
                    if (rows.length <= 2) return;
                    e.target.closest('.answer-row').remove();
                }
            });

            answerFields.addEventListener('input', function(e) {
                if (e.target.name === 'options[]') {
                    const radio = e.target.closest('.answer-row').querySelector('input[type="radio"]');
                    radio.value = e.target.value;
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const teacherSelect = document.getElementById('teacherSelect');
            const categorySelect = document.getElementById('categorySelect');
            if (!teacherSelect || !categorySelect) return;

            const currentCategoryId = categorySelect.dataset.current || '';

            function resetCategories() {
                categorySelect.innerHTML =
                    '<option value="">{{ trans('Teacher_trans.select_category') }}</option>';
                categorySelect.disabled = true;
            }

            function loadCategories(teacherId) {
                resetCategories();
                if (!teacherId) return;

                fetch(`/teachers/${teacherId}/categories`)
                    .then(res => res.json())
                    .then(categories => {
                        if (!Array.isArray(categories)) return;

                        categories.forEach(cat => {
                            const opt = document.createElement('option');
                            opt.value = cat.id;
                            opt.textContent = cat.title;
                            categorySelect.appendChild(opt);
                        });

                        // Re-select: old() value if present, else the question's current
                        if (currentCategoryId) {
                            categorySelect.value = currentCategoryId;
                        }

                        categorySelect.disabled = categories.length === 0;
                    })
                    .catch(err => console.error(err));
            }

            teacherSelect.addEventListener('change', function() {
                loadCategories(this.value);
            });

            // On edit page: auto-load for the existing teacher
            if (teacherSelect.value) {
                loadCategories(teacherSelect.value);
            } else {
                resetCategories();
            }
        });
    </script>
@endsection
