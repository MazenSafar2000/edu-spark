@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">تعديل السؤال</h3>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="exam_id" value="{{ $question->quizze_id }}">

                        <div class="mb-3">
                            <label class="text-danger">{{ trans('Teacher_trans.question') }} *</label>
                            <textarea name="title" class="form-control @error('title') is-invalid @enderror" rows="3">{{ old('title', $question->title) }}</textarea>
                            @error('title')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="text-danger">{{ trans('Teacher_trans.answers') }} *</label>

                            <div id="answer-fields">
                                @php
                                    $answers = old('answers', json_decode($question->answers, true));
                                    $selected = old(
                                        'right_answer',
                                        array_search($question->right_answer, $answers) + 1,
                                    );
                                @endphp

                                @foreach ($answers as $index => $answer)
                                    <div class="input-group mb-2 answer-row">
                                        <div class="input-group-text">
                                            <input type="radio" name="right_answer" value="{{ $index + 1 }}"
                                                {{ $selected == $index + 1 ? 'checked' : '' }}>
                                        </div>
                                        <input type="text" name="answers[]"
                                            class="form-control @error('answers.' . $index) is-invalid @enderror"
                                            value="{{ old('answers.' . $index, $answer) }}"
                                            placeholder="الخيار رقم {{ $index + 1 }}">
                                        @if (count($answers) > 2)
                                            <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
                                        @endif
                                    </div>
                                    @error('answers.' . $index)
                                        <div class="text-danger mb-2">{{ $message }}</div>
                                    @enderror
                                @endforeach
                            </div>

                            <button type="button" id="add-answer" class="btn btn-primary btn-sm mt-2">+ خيار جديد</button>

                            @error('right_answer')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label>{{ trans('Teacher_trans.degree') }} *</label>
                            <select name="score" class="form-select @error('score') is-invalid @enderror">
                                <option disabled>{{ trans('Teacher_trans.select_degree') }}</option>
                                @foreach ([1, 5, 10, 15, 20] as $val)
                                    <option value="{{ $val }}" {{ $question->score == $val ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>
                            @error('score')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">{{ trans('Teacher_trans.save_data') }}</button>
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
            const maxAnswers = 4;
            const answerFields = document.getElementById('answer-fields');
            const addBtn = document.getElementById('add-answer');

            addBtn.addEventListener('click', function() {
                const currentAnswers = answerFields.querySelectorAll('.answer-row').length;

                if (currentAnswers >= maxAnswers) return;

                const index = currentAnswers;
                const div = document.createElement('div');
                div.classList.add('input-group', 'mb-2', 'answer-row');

                div.innerHTML = `
                <div class="input-group-text">
                    <input type="radio" name="right_answer" value="${index + 1}">
                </div>
                <input type="text" name="answers[]" class="form-control" placeholder="الخيار رقم ${index + 1}">
                <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
            `;

                answerFields.appendChild(div);
                refreshRadioValues();
            });

            answerFields.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-answer')) {
                    const rows = answerFields.querySelectorAll('.answer-row');
                    if (rows.length <= 2) return; // Minimum 2
                    e.target.closest('.answer-row').remove();
                    refreshRadioValues();
                }
            });

            function refreshRadioValues() {
                const rows = answerFields.querySelectorAll('.answer-row');
                rows.forEach((row, index) => {
                    row.querySelector('input[type="radio"]').value = index + 1;
                    row.querySelector('input[type="text"]').placeholder = `الخيار رقم ${index + 1}`;
                });
            }
        });
    </script>
@endsection
