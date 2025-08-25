<div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
    <div class="container exam-container" x-data="examApp()" x-init="init()">

        <div class="row g-0">
            <!-- الأسئلة -->
            <div class="col-md-9 p-4" id="question-section">

                <div class="exam-header mb-3">
                    <p>{{ $exam->name ?? 'الاختبار' }} - <span>{{ $exam->teacher->user->name }}</span></p>
                </div>

                <!-- Loop questions -->
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
                                        wire:change="updateAnswer({{ $q->id }}, $event.target.value)"
                                        x-on:change="answers[{{ $q->id }}] = $event.target.value; saveLocalState()">
                                    <label class="form-check-label" for="opt-{{ $q->id }}-{{ $idx }}">
                                        {{ $opt }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <textarea class="form-control mt-2" rows="4"
                                wire:input.debounce.500ms="updateAnswer({{ $q->id }}, $event.target.value)"
                                x-on:input.debounce.500ms="answers[{{ $q->id }}] = $event.target.value; saveLocalState()">{{ $currentVal }}</textarea>
                        @endif
                    </div>
                @endforeach

                <!-- أزرار السابق / التالي -->
                <div class="d-flex justify-content-between mt-4">
                    <button class="btn prevBtn" wire:click="previousPage"
                        @if ($pageIndex <= 0) disabled @endif>
                        السابق
                    </button>

                    <button class="btn nextBtn" wire:click="nextPage" @if ($pageIndex >= $totalPages - 1) disabled @endif>
                        التالي
                    </button>
                </div>
            </div>

            <!-- ترقيم الأسئلة + زر إنهاء -->
            <div class="col-md-3 p-3 text-center question-number-container">
                <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="صورة الطالب" class="mb-2 rounded-circle"
                    width="120">
                <h6>{{ auth()->user()->name }}</h6>

                <div class="d-flex flex-wrap gap-2 mb-4 mt-3" id="questionNumbers">
                    @for ($i = 0; $i < $totalPages; $i++)
                        <button class="btn btn-sm {{ $i === $pageIndex ? 'btn-primary' : 'btn-outline-primary' }}"
                            wire:click="goToPage({{ $i }})">
                            {{ $i + 1 }}
                        </button>
                    @endfor
                </div>

                <!-- Submit button -->
                <button class="btn btn-exam-finish w-100" :disabled="submitting"
                    x-on:click="
                            submitting = true;
                            saveLocalState();
                            if (online) { safeEmit('submitExam'); }
                            else { submitting = false; }
                        ">
                    إنهاء الاختبار
                </button>

                <!-- Timer -->
                <div id="timer" class="text-danger fw-bold mt-3 timer-exam" x-text="format(timeLeft)"></div>
                <div class="text-danger">Time left from server: {{ $timeLeft }}</div>


                <!-- Connectivity -->
                <div class="mt-2">
                    <span class="badge" :class="online ? 'bg-success' : 'bg-danger'">
                        <span x-text="online ? 'متصل' : 'غير متصل'"></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Alpine app -->
        <div wire:ignore>
            <script>
                function examApp() {
                    return {
                        attemptId: @js($attemptId),
                        examId: @js($examId),
                        timeLeft: @js($timeLeft), // UI countdown
                        online: navigator.onLine,
                        answers: @js($answers),
                        submitting: false,

                        init() {
                            // 1) Try restore local state
                            const local = this.getLocalState();
                            if (local) {
                                if (typeof local.timeLeft === 'number') {
                                    this.timeLeft = Math.min(this.timeLeft, local.timeLeft);
                                }
                                if (local.answers && typeof local.answers === 'object') {
                                    this.answers = Object.assign({}, this.answers, local.answers);
                                }
                            }

                            // 2) Connectivity listeners
                            window.addEventListener('online', () => {
                                this.online = true;
                                this.flushLocalToServer();
                            });
                            window.addEventListener('offline', () => {
                                this.online = false;
                            });

                            // 3) Persist on tab close / hide
                            window.addEventListener('beforeunload', () => this.saveLocalState());
                            document.addEventListener('visibilitychange', () => {
                                if (document.visibilityState === 'hidden') this.saveLocalState();
                                if (document.visibilityState === 'visible' && this.online) {
                                    this.flushLocalToServer();
                                }
                            });

                            // 4) Start ticking
                            this.startUITimer();

                            // 5) If we have anything unsent and we are online, push once now
                            if (this.online) this.flushLocalToServer();
                        },

                        startUITimer() {
                            // Immediately show correct time
                            this.saveLocalState(); // persist initial state if needed

                            // Tick UI every second; server reconciles via periodic check
                            const iv = setInterval(() => {
                                if (this.timeLeft > 0) {
                                    this.timeLeft--;
                                    this.saveLocalState();

                                    // Emit a lightweight tick to allow server-side sync/guard
                                    if (this.online) this.safeEmit('tick');
                                } else {
                                    clearInterval(iv);
                                    // Ask server to finalize if reachable
                                    if (this.online) this.safeEmit('submitExam');
                                }
                            }, 1000);
                        },


                        key() {
                            return `attempt_${this.attemptId}_state`;
                        },
                        getLocalState() {
                            try {
                                return JSON.parse(localStorage.getItem(this.key()) || 'null');
                            } catch {
                                return null;
                            }
                        },
                        setLocalState(obj) {
                            localStorage.setItem(this.key(), JSON.stringify(obj));
                        },
                        saveLocalState() {
                            this.setLocalState({
                                timeLeft: this.timeLeft,
                                answers: this.answers
                            });
                        },

                        flushLocalToServer(cb) {
                            const local = this.getLocalState();
                            if (!local) {
                                if (cb) cb();
                                return;
                            }
                            this.safeEmit('restoreClientState', {
                                timeLeft: typeof local.timeLeft === 'number' ? local.timeLeft : this.timeLeft,
                                answers: local.answers || {}
                            });
                            if (cb) setTimeout(cb, 250);
                        },

                        format(s) {
                            s = Math.max(0, parseInt(s || 0, 10));
                            const m = Math.floor(s / 60);
                            const r = s % 60;
                            return `${String(m).padStart(2,'0')}:${String(r).padStart(2,'0')}`;
                        },

                        safeEmit(event, ...args) {
                            if (window.Livewire) {
                                window.Livewire.emit(event, ...args);
                            } else {
                                document.addEventListener('livewire:load', () => {
                                    window.Livewire.emit(event, ...args);
                                }, {
                                    once: true
                                });
                            }
                        }
                    }
                }
            </script>
        </div>
    </div>
</div>
