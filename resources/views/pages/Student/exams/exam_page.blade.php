@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container my-5 exam-container">

            <div class="row g-0">

                <!-- الأسئلة -->
                <div class="col-md-9 p-4" id="question-section">
                    <div class="exam-header">
                        <p> {{ $exam->name }} - <span>{{ $exam->teacher->user->name }} </span></p>
                    </div>

                    <!-- exam.blade.php -->
                    <!-- exam.blade.php -->
                    <form method="POST" action="{{ route('student.exam.submitExam', $exam->id) }}">
                        @csrf
                        @foreach ($questions as $question)
                            <div class="question-box">
                                <h5>{{ $loop->iteration }}. {{ $question->title }}</h5>
                                @foreach (json_decode($question->answers, true) as $key => $value)
                                    <div class="form-check">
                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $key }}">
                                        <label>{{ $key }}. {{ $value }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <!-- زر التالي أو زر إنهاء المحاولة حسب الصفحة الحالية -->
                        <div class="form-group">
                            @if ($questions->hasMorePages())
                                <button type="submit" class="btn btn-primary">التالي</button>
                            @else
                                <button type="submit" class="btn btn-success">إنهاء المحاولة</button>
                            @endif
                        </div>
                    </form>



                    {{-- hidden form for auto submit answeres --}}
                    <form id="finishForm" method="POST" action="{{ route('student.exam.autoSaveAnswers', $exam->id) }}">
                        @csrf
                        {{-- The answers are already inside the main form (id="questionForm") --}}
                        {{-- We'll copy them using JS before submitting --}}
                    </form>

                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn prevBtn" id="prevBtn">{{ trans('Students_trans.Back') }}</button>
                        @if ($questions->hasMorePages())
                            <button form="questionForm" class="btn nextBtn"
                                id="nextBtn">{{ trans('Students_trans.Next') }}</button>
                        @else
                            <button type="button" class="btn nextBtn" onclick="submitAndGoToReview()">
                                {{ trans('Students_trans.Finish_Attempt') }}
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-md-3 p-3 text-center question-number-container">
                    <div class="d-flex flex-wrap gap-2  mb-4" id="questionNumbers">

                    </div>

                    <button type="button" class="btn btn-exam-finish" onclick="submitAndGoToReview()">
                        {{ trans('Students_trans.Finish_Attempt') }}
                    </button>
                    <div id="timer" class="text-danger fw-bold mt-3 timer-exam" data-time="10"><span
                            id="time"></span></div>
                </div>

            </div>
        </div>


        <!-- محتوى الصفحة هنا -->
    </div>

    {{-- <script>
        let totalTime = {{ $remainingTime }};
        let timerEl = document.getElementById('time');

        // حفظ الوقت المتبقي في SessionStorage
        function updateTimer() {
            if (totalTime < 0) {
                window.location.href = "{{ route('student.timeout', $exam->id) }}";
                return;
            }

            let minutes = Math.floor(totalTime / 60);
            let seconds = totalTime % 60;
            timerEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            sessionStorage.setItem('remainingTime', totalTime);
            totalTime--;

            setTimeout(updateTimer, 1000);
        }

        // استرجاع الوقت المتبقي إذا كان موجودًا في sessionStorage
        if (sessionStorage.getItem('remainingTime')) {
            totalTime = parseInt(sessionStorage.getItem('remainingTime'));
        }
        updateTimer();

    </script> --}}

    <script>
        // حفظ الإجابة تلقائيًا باستخدام JavaScript
        document.querySelectorAll('input[type=radio]').forEach((input) => {
            input.addEventListener('change', function() {
                const answer = {
                    question_id: this.name.replace('answers[', '').replace(']', ''),
                    answer: this.value
                };

                // إرسال البيانات إلى الخادم باستخدام AJAX
                fetch('{{ route('student.exam.autoSaveAnswers', $exam->id) }}', {
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
