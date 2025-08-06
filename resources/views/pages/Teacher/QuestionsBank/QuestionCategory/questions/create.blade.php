@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
<div id="mainContent" class="transition-all with-sidebar">

    <h3 class="teacher-header-form">إضافة سؤال جديد</h3>

    <div class="container mt-4">
        <div class="card custom-form-card-teacher">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('questions.store') }}" method="POST">
                    @csrf

                    {{-- Select Category --}}
                    <div class="mb-3">
                        <label class="text-danger">اختر الفئة *</label>
                        <select name="QCategory_id" class="form-select @error('QCategory_id') is-invalid @enderror">
                            <option value="">-- اختر الفئة --</option>
                            {{-- @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('QCategory_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach --}}
                        </select>
                        @error('QCategory_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Question Text --}}
                    <div class="mb-3">
                        <label class="text-danger">نص السؤال *</label>
                        <textarea name="question" class="form-control @error('question') is-invalid @enderror" rows="3">{{ old('question') }}</textarea>
                        @error('question')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Question Type --}}
                    <div class="mb-3">
                        <label class="text-danger">نوع السؤال *</label><br>
                        <label><input type="radio" name="type" value="MCQ" {{ old('type') == 'MCQ' ? 'checked' : '' }}> اختيار من متعدد</label>
                        <label class="ms-3"><input type="radio" name="type" value="TrueFalse" {{ old('type') == 'TrueFalse' ? 'checked' : '' }}> صح أو خطأ</label>
                        @error('type')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- MCQ Options --}}
                    <div id="mcq-options" style="display: none;">
                        <label class="text-danger">الخيارات *</label>
                        <div id="answer-fields">
                            @php
                                $answers = old('options', ['', '']);
                                $selected = old('correct_answer');
                            @endphp

                            @foreach ($answers as $index => $answer)
                                <div class="input-group mb-2 answer-row">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_answer" value="{{ $answer }}" {{ $selected == $answer ? 'checked' : '' }}>
                                    </div>
                                    <input type="text" name="options[]" class="form-control" value="{{ $answer }}" placeholder="الخيار رقم {{ $index + 1 }}">
                                    @if ($loop->count > 2)
                                        <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-answer" class="btn btn-primary btn-sm mt-2">+ خيار جديد</button>
                    </div>

                    {{-- True/False Options --}}
                    <div id="true-false-options" style="display: none;">
                        <label class="text-danger">اختر الإجابة الصحيحة *</label><br>
                        <label><input type="radio" name="correct_answer" value="true" {{ old('correct_answer') == 'true' ? 'checked' : '' }}> صح</label>
                        <label class="ms-3"><input type="radio" name="correct_answer" value="false" {{ old('correct_answer') == 'false' ? 'checked' : '' }}> خطأ</label>
                    </div>

                    {{-- Score --}}
                    <div class="mb-3 mt-3">
                        <label class="text-danger">الدرجة *</label>
                        <select name="score" class="form-select @error('score') is-invalid @enderror">
                            <option disabled selected>اختر الدرجة</option>
                            @foreach ([1, 5, 10, 15, 20] as $val)
                                <option value="{{ $val }}" {{ old('score') == $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                        @error('score')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const answerFields = document.getElementById('answer-fields');
        const addBtn = document.getElementById('add-answer');
        const maxAnswers = 4;

        // Show/Hide question type fields
        function toggleQuestionType(type) {
            document.getElementById('mcq-options').style.display = type === 'MCQ' ? 'block' : 'none';
            document.getElementById('true-false-options').style.display = type === 'TrueFalse' ? 'block' : 'none';
        }

        document.querySelectorAll('input[name="type"]').forEach(radio => {
            radio.addEventListener('change', function () {
                toggleQuestionType(this.value);
            });

            if (radio.checked) {
                toggleQuestionType(radio.value);
            }
        });

        // Add option
        addBtn.addEventListener('click', function () {
            const currentAnswers = answerFields.querySelectorAll('.answer-row').length;
            if (currentAnswers >= maxAnswers) return;

            const index = currentAnswers;
            const div = document.createElement('div');
            div.classList.add('input-group', 'mb-2', 'answer-row');
            div.innerHTML = `
                <div class="input-group-text">
                    <input type="radio" name="correct_answer" value="">
                </div>
                <input type="text" name="options[]" class="form-control" placeholder="الخيار رقم ${index + 1}">
                <button type="button" class="btn btn-danger remove-answer ms-2">−</button>
            `;
            answerFields.appendChild(div);
        });

        // Remove option
        answerFields.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-answer')) {
                const rows = answerFields.querySelectorAll('.answer-row');
                if (rows.length <= 2) return;
                e.target.closest('.answer-row').remove();
            }
        });

        // Keep radio values synced with text input
        answerFields.addEventListener('input', function (e) {
            if (e.target.name === 'options[]') {
                const row = e.target.closest('.answer-row');
                const radio = row.querySelector('input[type="radio"]');
                radio.value = e.target.value;
            }
        });
    });
</script>
@endsection
