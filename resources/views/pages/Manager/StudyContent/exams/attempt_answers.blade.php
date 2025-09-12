@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container my-5">
            <div
                class="result-summary-container alert alert-light d-flex justify-content-around align-items-center mb-4 text-center">
                <div class="result-item correct-answer">
                    <i class="fa-solid fa-check correct-icon"></i> <strong class="label"> الصحيحة:</strong>
                    <span class="value">{{ $attempt->answers->where('is_correct', 1)->count() }}</span>
                </div>
                <div class="result-item wrong-answer">
                    <i class="fas fa-times wrong-icon"></i><strong class="label"> الخاطئة:</strong>
                    <span class="value">{{ $attempt->answers->where('is_correct', 0)->count() }}</span>
                </div>
                <div class="result-item total-score">
                    <i class="fas fa-chart-bar chart-icon"></i><strong class="label"> العلامة:</strong>
                    <span class="value">{{ $attempt->grade_obtained }}</span>
                </div>
            </div>

            @foreach ($questions as $index => $question)
                @php
                    $studentAnswer = $attempt->answers->firstWhere('question_id', $question->id);
                    $selectedAnswer = $studentAnswer->answer ?? null;
                    $isCorrect = $studentAnswer?->is_correct;
                    $options = is_array($question->options)
                        ? $question->options
                        : json_decode($question->options, true) ?? [];
                @endphp
                <!-- بطاقة سؤال -->
                <div class="card question-card mb-4">
                    <div class="card-header question-title fw-bold">
                        {{ $index + 1 }}. {!! $question->question !!}
                    </div>

                    <div class="card-body question-body">
                        @foreach ($options as $opt)
                            @php
                                $isSelected = $selectedAnswer === $opt;
                                $isAnswerCorrect = $question->correct_answer === $opt;
                            @endphp
                            <!-- خيار خاطئ مختار من الطالب -->
                            <div
                                class="form-check form-check-reverse form-check-ltr mb-2 answer-option @if ($isSelected && !$isAnswerCorrect) answer-wrong selected-by-student @endif">
                                <input class="form-check-input" type="radio" disabled
                                    @if ($isSelected) checked @endif>
                                <label class="fw-bold me-3">
                                    {{ $opt }}
                                    @if (($isSelected && $isAnswerCorrect) || $isAnswerCorrect)
                                        <i class="fa-solid fa-check correct-icon"></i>
                                    @elseif($isSelected && !$isAnswerCorrect)
                                        <i class="fas fa-times wrong-icon"></i>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                        <!-- معلومات إضافية -->
                        <div class="question-footer mt-3 p-2 border-top small text-muted">
                            <p class="exam-correct-answer">الاجابة الصحيحة : <span>{{ $question->correct_answer }}</span>
                            </p>
                            <p class="exam-grade">الدرجة :
                                <span>{{ $question->score ?? 1 }}/{{ $isCorrect ? $question->score ?? 1 : 0 }}</span></p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <br><br><br><br>
@endsection
