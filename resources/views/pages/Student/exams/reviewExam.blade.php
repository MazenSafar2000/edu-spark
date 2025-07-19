@extends('layouts.main.student_dashboard')
@section('student-content')
    {{-- <div class="container">
        <h3>مراجعة إجاباتك</h3>

        @foreach ($questions as $question)
            <div class="mb-4">
                <h5>{{ $loop->iteration }}. {{ $question->title }}</h5>
                @php $studentAnswer = $answers[$question->id] ?? null; @endphp
                @if ($studentAnswer)
                    <p><strong>إجابتك:</strong> {{ $studentAnswer }} -
                        {{ $question->answers[$studentAnswer] ?? 'غير معروف' }}</p>
                @else
                    <p class="text-danger"><strong>لم يتم الإجابة على هذا السؤال</strong></p>
                @endif
            </div>
        @endforeach

        <form method="POST" action="{{ route('student.exam.submit', $exam->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">تسليم الامتحان</button>
        </form>
    </div> --}}



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
                        <table class="table table-bordered text-center custom-answer">
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
                                        @php $studentAnswer = $answers[$question->id] ?? false; @endphp
                                        @if ($studentAnswer)
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
                        </table>
                    </div>


                    <div class="end-of-exam d-flex">
                        <a href="student-exam.html" class="back-to-exam-btn">العودة للاختبار</a>
                        <form method="POST" action="{{ route('student.exam.submit', $exam->id) }}">
                            @csrf
                            <button type="submit"
                                class="end-of-exam-btn">{{ trans('Students_trans.Finish_Attempt') }}</button>
                        </form>
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


        <!-- محتوى الصفحة هنا -->
    </div>

    <script>
        let totalTime = {{ $time_limit }} - {{ $elapsed }};
        let timerEl = document.getElementById('time');

        function updateTimer() {
            let minutes = Math.floor(totalTime / 60);
            let seconds = totalTime % 60;
            timerEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            totalTime--;

            if (totalTime < 0) {
                window.location.href = "{{ route('student.exam.force', $exam->id) }}";
            } else {
                setTimeout(updateTimer, 1000);
            }
        }

        updateTimer();
    </script>
@endsection
