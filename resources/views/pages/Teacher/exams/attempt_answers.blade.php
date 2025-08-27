@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar">

        <div class="container card-answer-exam">
            <div class="container mt-4">
                <h3 class="mb-4">عرض إجابات الطالب: {{ $attempt->student->user->name }}</h3>

                <!-- Summary -->
                <div class="row mb-4 text-center">
                    <div class="col-md-4">
                        <div class="alert alert-success p-2">
                            <strong>الاجابات الصحيحة:</strong> {{ $attempt->answers->where('is_correct', 1)->count() }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-danger p-2">
                            <strong>الاجابات الخاطئة:</strong> {{ $attempt->answers->where('is_correct', 0)->count() }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info p-2">
                            <strong>الدرجة:</strong> {{ $attempt->score_obtained }} /
                            {{ $attempt->exam->total_marks ?? $attempt->exam->questions->sum('score') }}
                        </div>
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

                    <div class="card mb-4">
                        <div class="card-header fw-bold">
                            {{ $index + 1 }}. {!! $question->question !!}
                        </div>
                        <div class="card-body">
                            @foreach ($options as $opt)
                                @php
                                    $isSelected = $selectedAnswer === $opt;
                                    $isAnswerCorrect = $question->correct_answer === $opt;
                                @endphp
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" disabled
                                        @if ($isSelected) checked @endif>
                                    <label
                                        class="form-check-label fw-bold @if ($isSelected && !$isAnswerCorrect) text-danger @endif">
                                        {{ $opt }}
                                        @if ($isSelected && $isAnswerCorrect)
                                            <i class="fas fa-check text-success ms-2"></i>
                                        @elseif($isSelected && !$isAnswerCorrect)
                                            <i class="fas fa-times text-danger ms-2"></i>
                                        @endif
                                    </label>
                                </div>
                            @endforeach

                            <div class="mt-3 border-top pt-2 small text-muted">
                                <p>الاجابة الصحيحة: <span class="fw-bold">{{ $question->correct_answer }}</span></p>
                                <p>درجة السؤال: <span>{{ $question->score ?? 1 }} /
                                        {{ $isCorrect ? $question->score ?? 1 : 0 }}</span></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
