@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container my-5 exam-container">
            <div class="row g-0">
                <div class="col-md-9 p-4" id="question-section">
                    <div class="row">
                        <div class="col exam-header">
                            <p> {{ $exam->name }} - <span>{{ $exam->teacher->user->name }} </span></p>
                        </div>
                        <div id="timer" class="col text-danger fw-bold mt-3 timer-exam" data-time="10"><span
                                id="time"></span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        {{-- <table class="table table-bordered text-center custom-answer">
                            <thead>
                                <tr>
                                    <th>question number</th>
                                    <th>{{ trans('Teacher_trans.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                    <tr class="custom-row-answer">
                                        <td>{{ $loop->iteration }}</td>
                                        @php
                                            $studentAnswer = $answers[$question->id] ?? null;
                                        @endphp

                                        @if (array_key_exists($question->id, $answers))
                                            <td><span class="answer-present">{{ trans('students_trans.answered') }}</span>
                                            </td>
                                        @else
                                            <td><span
                                                    class="answer-missing">{{ trans('students_trans.not_answered') }}</span>
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                        <form method="POST" action="{{ route('student.exam.submit', $exam->id) }}">
                            @csrf
                            @foreach ($exam->questions as $question)
                                <div class="question-box">
                                    <h5>{{ $question->title }}</h5>
                                    <p>إجابتك: {{ $answers[$question->id] ?? 'لم تتم الإجابة' }}</p>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">التسليم</button>
                        </form>
                    </div>


                    <div class="end-of-exam d-flex">
                        <a href="student-exam.html" class="back-to-exam-btn">العودة للاختبار</a>
                        {{-- <form method="POST" action="{{ route('student.exam.submit', $exam->id) }}">
                            @csrf
                            <button type="submit"
                                class="end-of-exam-btn">{{ trans('Students_trans.Finish_Attempt') }}</button>
                        </form> --}}
                        <!-- review.blade.php -->


                    </div>

                </div>

                <!-- ترقيم الأسئلة + زر إنهاء -->
                <div class="col-md-3 p-3 text-center question-number-container">
                    <div class="d-flex flex-wrap gap-2  mb-4" id="questionNumbers">

                    </div>
                    <div id="timer" class="text-danger fw-bold mt-3 timer-exam" data-time="10"><span
                            id="time"></span></div>
                </div>

            </div>
        </div>

    </div>

    <script>
        // حفظ الإجابة تلقائيًا باستخدام JavaScript
        document.querySelectorAll('input[type=radio]').forEach((input) => {
            input.addEventListener('change', function() {
                const answer = {
                    question_id: this.name.replace('answers[', '').replace(']', ''),
                    answer: this.value,
                    exam_id: {{ $exam->id }} // إرسال exam_id مع كل إجابة
                };

                // إرسال البيانات باستخدام AJAX
                fetch('{{ route('student.exam.timeout', $exam->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(answer)
                });
            });
        });
    </script>
@endsection
