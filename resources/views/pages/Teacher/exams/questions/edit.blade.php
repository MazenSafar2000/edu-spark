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

                        {{-- Select Category --}}
                        <div class="mb-3">
                            <label class="text-danger">الفئة *</label>
                            <select name="QCategory_id" class="form-select">
                                <option value="">اختر الفئة</option>
                                @foreach ($Qcategories as $QC)
                                    <option value="{{ $QC->id }}"
                                        {{ $question->QCategory_id == $QC->id ? 'selected' : '' }}>
                                        {{ $QC->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Question Text --}}
                        <div class="mb-3">
                            <label class="text-danger">نص السؤال *</label>
                            <textarea name="question" class="form-control" rows="3">{{ old('question', $question->question) }}</textarea>
                        </div>

                        {{-- Question Type --}}
                        <div class="mb-3">
                            <label class="text-danger">نوع السؤال *</label><br>
                            <label><input type="radio" name="type" value="MCQ"
                                    {{ $question->type === 'MCQ' ? 'checked' : '' }}> اختيار من متعدد</label>
                            <label class="ms-3"><input type="radio" name="type" value="TrueFalse"
                                    {{ $question->type === 'TrueFalse' ? 'checked' : '' }}> صح أو خطأ</label>
                        </div>

                        {{-- MCQ Options --}}
                        <div id="mcq-options" style="{{ $question->type === 'MCQ' ? '' : 'display: none;' }}">
                            <label class="text-danger">الخيارات *</label>
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
                                            value="{{ $answer }}" placeholder="الخيار رقم {{ $index + 1 }}">
                                        @if (count($answers) > 2)
                                            <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-answer" class="btn btn-primary btn-sm mt-2">+ خيار جديد</button>
                        </div>

                        {{-- True/False Options --}}
                        <div id="true-false-options" style="{{ $question->type === 'TrueFalse' ? '' : 'display: none;' }}">
                            <label class="text-danger">اختر الإجابة الصحيحة *</label><br>
                            <label><input type="radio" name="correct_answer" value="true"
                                    {{ $question->correct_answer === 'true' ? 'checked' : '' }}> صح</label>
                            <label class="ms-3"><input type="radio" name="correct_answer" value="false"
                                    {{ $question->correct_answer === 'false' ? 'checked' : '' }}> خطأ</label>
                        </div>

                        {{-- Score --}}
                        <div class="mb-3 mt-3">
                            <label class="text-danger">الدرجة *</label>
                            <select name="score" class="form-select">
                                @foreach ([1, 5, 10, 15, 20] as $val)
                                    <option value="{{ $val }}" {{ $question->score == $val ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">تحديث</button>
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
                <input type="text" name="options[]" class="form-control" placeholder="خيار جديد">
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
@endsection
