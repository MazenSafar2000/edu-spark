@extends('layouts.main.student_dashboard')
@section('student-content')
    {{-- <div class="container">
        <h3>{{ $exam->name }}</h3>
        <div id="timer" class="alert alert-info">الوقت المتبقي: <span id="time"></span></div>

        <form method="POST" action="{{ route('student.exam.save', $exam->id) }}">
            @csrf
            @foreach ($questions as $question)
                <div class="mb-4">
                    <h5>{{ $loop->iteration }}. {{ $question->title }}</h5>
                    @foreach (json_decode($question->answers, true) as $key => $value)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                value="{{ $key }}"
                                {{ isset(json_decode($session->answers, true)[$question->id]) && json_decode($session->answers, true)[$question->id] === $key ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $key }}. {{ $value }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">التالي</button>
        </form>
    </div> --}}


    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container my-5 exam-container">

            <div class="row g-0">

                <!-- الأسئلة -->
                <div class="col-md-9 p-4" id="question-section">
                    <div class="exam-header">
                        <p>اختبار لغة عربية - <span>ميادة مغاري</span></p>
                    </div>

                    <form id="questionForm" method="POST" action="{{ route('student.exam.save', $exam->id) }}">
                        @csrf
                        @foreach ($questions as $question)
                            <div id="question-1" class="question-box">
                                <h5 class="fw-bold ">{{ $loop->iteration }}. {{ $question->title }}</h5>
                                @foreach (json_decode($question->answers, true) as $key => $value)
                                    <div class="form-check custom-answer">
                                        <input class="" type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $key }}"
                                            {{ isset(json_decode($session->answers, true)[$question->id]) && json_decode($session->answers, true)[$question->id] === $key ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $key }}.
                                            {{ $value }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        {{-- <button type="submit" class="btn prevBtn" id="prevBtn">next</button> --}}

                    </form>





                    <!-- أزرار السابق / التالي -->
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn prevBtn" id="prevBtn">{{ trans('Students_trans.Back') }}</button>
                        <button form="questionForm" class="btn nextBtn" id="nextBtn">{{ trans('Students_trans.Next') }}</button>
                    </div>
                </div>

                <div class="col-md-3 p-3 text-center question-number-container">
                    <div class="d-flex flex-wrap gap-2  mb-4" id="questionNumbers">

                    </div>

                    <a href="{{ route('student.exam.review', $exam->id) }}" class="btn btn-exam-finish">{{ trans('Students_trans.Finish_Attempt') }}</a>
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
