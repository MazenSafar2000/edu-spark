@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar">

        <h3 class="teacher-header-form">{{ trans('main_trans.add_question') }}</h3>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    @include('components.error-field')

                    <form class="subject-form" action="{{ route('questions.store') }}" method="POST">
                        @csrf

                        {{-- Select Category --}}
                        <div class="mb-3">
                            <label class="text-danger">{{ trans('Teacher_trans.select_category') }} *</label>
                            <select name="QCategory_id"
                                class="form-select custom-select @error('QCategory_id') custom-select-error @enderror">
                                <option value="">{{ trans('Teacher_trans.select_category') }}</option>
                                @foreach ($Qcategories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('QCategory_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('QCategory_id')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Question Text --}}
                        <div class="mb-3">
                            <label class="text-danger">{{ trans('main_trans.question_title') }}*</label>
                            <textarea name="question" class="form-control @error('question') is-invalid @enderror" rows="3">{{ old('question') }}</textarea>
                            @error('question')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Question Type --}}
                        <div class="border p-3">
                            <div class="mb-3">
                                <label class="text-danger">{{ trans('main_trans.question_type') }} *</label><br>
                                <label><input type="radio" name="type" value="MCQ"
                                        {{ old('type') == 'MCQ' ? 'checked' : '' }}>{{ trans('main_trans.MCQ') }}</label>
                                <label class="ms-3"><input type="radio" name="type" value="TrueFalse"
                                        {{ old('type') == 'TrueFalse' ? 'checked' : '' }}>{{ trans('main_trans.true_false') }}</label>
                                @error('type')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- MCQ Options --}}
                            <div id="mcq-options" style="display: none;">
                                <label class="text-danger">{{ trans('main_trans.options') }} *</label>
                                <div id="answer-fields">
                                    @php
                                        $answers = old('options', ['', '']);
                                        $selected = old('correct_answer');
                                    @endphp

                                    @foreach ($answers as $index => $answer)
                                        <div class="input-group mb-2 answer-row">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct_answer" value="{{ $answer }}"
                                                    {{ $selected == $answer ? 'checked' : '' }}>
                                            </div>
                                            <input type="text" name="options[]" class="form-control"
                                                value="{{ $answer }}"
                                                placeholder="{{ trans('main_trans.option') }} {{ $index + 1 }}">
                                            @if ($loop->count > 2)
                                                <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-answer"
                                    class="btn btn-primary btn-sm mt-2">{{ trans('main_trans.new_option') }} +</button>
                            </div>

                            {{-- True/False Options --}}
                            <div id="true-false-options" style="display: none;">
                                <label class="text-danger">{{ trans('main_trans.options') }} *</label><br>
                                <label><input type="radio" name="correct_answer" value="true"
                                        {{ old('correct_answer') == 'true' ? 'checked' : '' }}>{{ trans('main_trans.true') }}</label>
                                <label class="ms-3"><input type="radio" name="correct_answer" value="false"
                                        {{ old('correct_answer') == 'false' ? 'checked' : '' }}>{{ trans('main_trans.false') }}</label>
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
                            <select name="score" class="form-select @error('score') is-invalid @enderror">
                                <option disabled selected>{{ trans('main_trans.select_score') }}</option>
                                @foreach ([1, 5, 10, 15, 20] as $val)
                                    <option value="{{ $val }}" {{ old('score') == $val ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>
                            @error('score')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">{{ trans('main_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const answerFields = document.getElementById('answer-fields');
            const addBtn = document.getElementById('add-answer');
            const maxAnswers = 4;

            // Show/Hide question type fields
            function toggleQuestionType(type) {
                document.getElementById('mcq-options').style.display = type === 'MCQ' ? 'block' : 'none';
                document.getElementById('true-false-options').style.display = type === 'TrueFalse' ? 'block' :
                    'none';
            }

            document.querySelectorAll('input[name="type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    toggleQuestionType(this.value);
                });

                if (radio.checked) {
                    toggleQuestionType(radio.value);
                }
            });

            // Add option
            addBtn.addEventListener('click', function() {
                const currentAnswers = answerFields.querySelectorAll('.answer-row').length;
                if (currentAnswers >= maxAnswers) return;

                const index = currentAnswers;
                const div = document.createElement('div');
                div.classList.add('input-group', 'mb-2', 'answer-row');
                div.innerHTML = `
                <div class="input-group-text">
                    <input type="radio" name="correct_answer" value="">
                </div>
                <input type="text" name="options[]" class="form-control" placeholder="{{ trans('main_trans.option') }} ${index + 1}">
                <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
            `;
                answerFields.appendChild(div);
            });

            // Remove option
            answerFields.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-answer')) {
                    const rows = answerFields.querySelectorAll('.answer-row');
                    if (rows.length <= 2) return;
                    e.target.closest('.answer-row').remove();
                }
            });

            // Keep radio values synced with text input
            answerFields.addEventListener('input', function(e) {
                if (e.target.name === 'options[]') {
                    const row = e.target.closest('.answer-row');
                    const radio = row.querySelector('input[type="radio"]');
                    radio.value = e.target.value;
                }
            });
        });
    </script>
@endsection
