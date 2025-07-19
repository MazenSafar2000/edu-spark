<div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
    <!-- قسم الأسئلة -->
    <div class="col-md-9 p-4" id="question-section">
        <div class="exam-header">
            <p>اختبار {{ $exam->subject->name }} - <span>{{ $exam->teacher->name }}</span></p>
        </div>

        <!-- عرض الأسئلة -->
        @foreach ($questions as $index => $question)
            <div id="question-{{ $index + 1 }}" class="question-box">
                <h5 class="fw-bold">{{ $question->title }}</h5>

                @foreach (json_decode($question->answers) as $answer)
                    <div class="form-check custom-answer">
                        <input class="form-check-input" type="radio" wire:model="answers.{{ $question->id }}"
                            value="{{ $answer }}">
                        <label class="form-check-label">{{ $answer }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <!-- أزرار التحكم -->
        <div class="d-flex justify-content-between mt-4">
            <button wire:click="prevQuestion" class="btn prevBtn">السابق</button>
            <button wire:click="nextQuestion" class="btn nextBtn">التالي</button>
            <button wire:click="submitExam" class="btn btn-exam-finish">إنهاء الاختبار</button>
        </div>
    </div>

    <!-- قسم مراجعة الأسئلة -->
    <div class="col-md-3 p-3 text-center question-number-container">
        <img src="../images/pic-1.jpg" alt="">
        <h6>{{ Auth::user()->name }}</h6>
        <div class="d-flex flex-wrap gap-2 mb-4" id="questionNumbers">
            @foreach ($questions as $index => $question)
                <button class="btn {{ isset($answers[$question->id]) ? 'btn-success' : 'btn-secondary' }}"
                    wire:click="goToQuestion({{ $question->id }})">
                    {{ $index + 1 }}
                </button>
            @endforeach
        </div>

        <div id="timer" class="text-danger fw-bold mt-3 timer-exam">{{ $remaining_time }} دقيقة</div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('start-timer', event => {
            let timeLeft = event.detail.time;
            let timerInterval = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    @this.submitExam();
                }
                document.getElementById('timer').innerText =
                    `${Math.floor(timeLeft / 60)} دقيقة ${timeLeft % 60} ثانية`;
                timeLeft--;
            }, 1000);
        });
    </script>
@endpush
