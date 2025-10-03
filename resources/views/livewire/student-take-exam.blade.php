<div wire:poll.10s="checkDeadline">
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;"
        x-data="examTimer(@js($timeLeft))" x-init="start()">
        <div class="container exam-container">
            <div class="row g-0">
                <!-- الأسئلة -->
                <div class="col-md-9 p-4">
                    <div class="exam-header mb-3">
                        <p>{{ $exam->name ?? 'الاختبار' }} - <span>{{ $exam->teacher->user->name }}</span></p>
                    </div>

                    @foreach ($currentQuestions as $index => $q)
                        <div id="question-{{ $q->id }}" class="question-box mb-4">
                            <h5 class="fw-bold">
                                {{ $loop->iteration + $pageIndex * $questionsPerPage }}) {!! $q->question !!}
                            </h5>

                            @php
                                $opts = is_array($q->options) ? $q->options : json_decode($q->options, true) ?? [];
                                $name = 'q-' . $q->id;
                                $currentVal = $answers[$q->id] ?? '';
                            @endphp

                            @if ($q->type === 'MCQ' || $q->type === 'TrueFalse')
                                @foreach ($opts as $idx => $opt)
                                    <div class="form-check custom-answer mb-2">
                                        <input class="form-check-input" type="radio"
                                            id="opt-{{ $q->id }}-{{ $idx }}" name="{{ $name }}"
                                            value="{{ $opt }}" @checked($currentVal === $opt)
                                            wire:change="saveAnswer({{ $q->id }}, $event.target.value)">
                                        <label class="form-check-label"
                                            for="opt-{{ $q->id }}-{{ $idx }}">
                                            {{ $opt }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <textarea class="form-control mt-2" rows="4"
                                    wire:input.debounce.500ms="saveAnswer({{ $q->id }}, $event.target.value)">{{ $currentVal }}</textarea>
                            @endif
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn prevBtn" wire:click="goToPage({{ max($pageIndex - 1, 0) }})"
                            @if ($pageIndex <= 0) disabled @endif>{{ trans('main_trans.previous') }}</button>
                        <button class="btn nextBtn" wire:click="goToPage({{ min($pageIndex + 1, $totalPages - 1) }})"
                            @if ($pageIndex >= $totalPages - 1) disabled @endif>{{ trans('main_trans.next') }}</button>
                    </div>
                </div>

                <!-- الشريط الجانبي -->
                <div class="col-md-3 p-3 text-center question-number-container">
                    <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="avatar" class="mb-2 rounded-circle"
                        width="120">
                    <h6>{{ auth()->user()->name }}</h6>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach ($questions as $index => $q)
                            @php
                                $answered = isset($answers[$q->id]) && $answers[$q->id] !== '';
                                $currentPage = floor($index / $questionsPerPage);
                            @endphp
                            <button
                                class="btn btn-sm question-number-btn {{ $answered ? 'active' : '' }}"
                                wire:click="goToPage({{ floor($index / $questionsPerPage) }}, {{ $q->id }})">
                                {{ $index + 1 }}

                            </button>
                        @endforeach
                    </div>

                    <button class="btn btn-exam-finish w-100" @click="$wire.submitExam()">{{ trans('main_trans.finish_attempt') }}</button>

                    <div class="text-danger fw-bold mt-3" x-text="formatted"></div>

                    <div x-data="connectionStatus()" x-init="init()">
                        <span class="badge" :class="online ? 'bg-success' : 'bg-danger'"
                            x-text="online ? 'متصل' : 'غير متصل'">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script العد التنازلي -->
<script>
    function examTimer(initialTime) {
        return {
            timeLeft: initialTime,
            interval: null,
            formatted: '',

            start() {
                if (this.interval) return;
                this.updateFormatted();

                this.interval = setInterval(() => {
                    if (this.timeLeft > 0) {
                        this.timeLeft--;
                        this.updateFormatted();
                    } else {
                        clearInterval(this.interval);
                        this.interval = null;
                        if (window.Livewire) Livewire.emit('submitExam');
                    }
                }, 1000);
            },

            updateFormatted() {
                const m = Math.floor(this.timeLeft / 60);
                const s = this.timeLeft % 60;
                this.formatted = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
            }
        }
    }
</script>

<!-- Script حالة الاتصال -->
<script>
    function connectionStatus() {
        return {
            online: navigator.onLine,

            init() {
                window.addEventListener('online', () => this.online = true);
                window.addEventListener('offline', () => this.online = false);
            }
        }
    }
</script>

<!-- Script التمرير للسؤال -->
<script>
    document.addEventListener('livewire:load', () => {
        window.Livewire.on('scrollToQuestion', questionId => {
            const el = document.getElementById(`question-${questionId}`);
            if (el) el.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        });
    });
</script>
