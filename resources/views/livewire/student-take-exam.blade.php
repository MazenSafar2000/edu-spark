@extends('layouts.main.student_dashboard')
@section('student-content')
    <!-- ----------------------------------------------------------------------------------------------- -->
    <div id="mainContent" class="transition-all with-sidebar">
        <div class="container exam-preview-container">
            <div x-data="examApp()" x-init="init()" class="container py-3">

                {{-- Top bar: timer + connectivity --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge bg-secondary">الصفحة: {{ $pageIndex + 1 }} / {{ $totalPages }}</span>
                    </div>

                    <div>
                        <span class="badge" :class="online ? 'bg-success' : 'bg-danger'">
                            <span x-text="online ? 'متصل' : 'غير متصل'"></span>
                        </span>
                        <span class="ms-2 fw-bold text-danger">
                            الوقت المتبقي:
                            <span x-text="format(timeLeft)"></span>
                        </span>
                    </div>
                </div>

                {{-- Questions on this page --}}
                @foreach ($currentQuestions as $q)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-3">سؤال: {{ $q->question }}</h5>

                            @php
                                $opts = is_array($q->options) ? $q->options : json_decode($q->options, true) ?? [];
                                $name = 'q-' . $q->id;
                                $currentVal = $answers[$q->id] ?? '';
                            @endphp

                            @if ($q->type === 'MCQ')
                                @foreach ($opts as $idx => $opt)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            id="opt-{{ $q->id }}-{{ $idx }}" name="{{ $name }}"
                                            value="{{ $opt }}" @checked($currentVal === $opt)
                                            @change="handleAnswer({{ $q->id }}, '{{ addslashes($opt) }}')">
                                        <label class="form-check-label" for="opt-{{ $q->id }}-{{ $idx }}">
                                            {{ $opt }}
                                        </label>
                                    </div>
                                @endforeach
                            @elseif ($q->type === 'TrueFalse')
                                @php $trueFalse = $opts ?: ['True','False']; @endphp
                                @foreach ($trueFalse as $idx => $opt)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            id="opt-{{ $q->id }}-{{ $idx }}" name="{{ $name }}"
                                            value="{{ $opt }}" @checked($currentVal === $opt)
                                            @change="handleAnswer({{ $q->id }}, '{{ addslashes($opt) }}')">
                                        <label class="form-check-label" for="opt-{{ $q->id }}-{{ $idx }}">
                                            {{ $opt }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                {{-- Future types (essay, etc.) --}}
                                <textarea class="form-control" rows="4" @input="handleAnswer({{ $q->id }}, $event.target.value)">{{ $currentVal }}</textarea>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Page navigation --}}
                <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-secondary" @click="goPrev"
                        :disabled="{{ $pageIndex }} <= 0">السابق</button>

                    <div class="d-flex gap-1 flex-wrap">
                        @for ($i = 0; $i < $totalPages; $i++)
                            <button class="btn btn-sm {{ $i === $pageIndex ? 'btn-primary' : 'btn-outline-primary' }}"
                                @click="goTo({{ $i }})">{{ $i + 1 }}</button>
                        @endfor
                    </div>

                    <button class="btn btn-outline-secondary" @click="goNext"
                        :disabled="{{ $pageIndex }} >= {{ $totalPages - 1 }}">التالي</button>
                </div>

                {{-- Submit --}}
                <div class="text-end mt-3">
                    <button class="btn btn-success" @click="submitNow">تسليم الامتحان</button>
                </div>

                {{-- Alpine app --}}
                <script>
                    function examApp() {
                        return {
                            attemptId: @js($attemptId),
                            examId: @js($examId),
                            timeLeft: @js($timeLeft),
                            pageIndex: @js($pageIndex),
                            online: navigator.onLine,
                            allQuestions: @js($allQuestions), // Preload all questions grouped by page
                            currentQuestions: @js($currentQuestions),
                            answers: @js($answers),

                            init() {
                                const local = this.getLocalState();
                                if (local) {
                                    this.timeLeft = Math.min(this.timeLeft, local.timeLeft ?? this.timeLeft);
                                    this.pageIndex = local.pageIndex ?? this.pageIndex;
                                    this.answers = local.answers ?? this.answers;
                                    this.currentQuestions = this.allQuestions[this.pageIndex] ?? [];
                                }

                                window.addEventListener('online', () => {
                                    this.online = true;
                                    this.flushLocalToServer();
                                });
                                window.addEventListener('offline', () => {
                                    this.online = false;
                                });

                                this.startUITimer();
                            },

                            // startUITimer() {
                            //     const iv = setInterval(() => {
                            //         if (this.timeLeft > 0) {
                            //             this.timeLeft--;
                            //             this.saveLocalState();
                            //             if (this.online) this.safeEmit('tick');
                            //         } else {
                            //             clearInterval(iv);
                            //             this.safeEmit('submitExam');
                            //         }
                            //     }, 1000);
                            // },

                            handleAnswer(qid, value) {
                                this.answers[qid] = value;
                                this.saveLocalState();
                                if (this.online) this.safeEmit('saveAnswer', qid, value);
                            },

                            goPrev() {
                                this.goTo(this.pageIndex - 1);
                            },

                            goNext() {
                                this.goTo(this.pageIndex + 1);
                            },

                            goTo(i) {
                                if (i < 0 || i >= this.allQuestions.length) return;

                                // Instant frontend switch
                                this.pageIndex = i;
                                this.currentQuestions = this.allQuestions[i] ?? [];

                                // Save local state
                                this.saveLocalState();

                                // Sync backend asynchronously (no blocking)
                                if (this.online) {
                                    setTimeout(() => this.safeEmit('goToPage', i), 0);
                                }
                            },

                            submitNow() {
                                this.flushLocalToServer(() => {
                                    this.safeEmit('submitExam');
                                });
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
                                    pageIndex: this.pageIndex,
                                    answers: this.answers
                                });
                            },
                            flushLocalToServer(cb) {
                                const local = this.getLocalState();
                                if (!local) {
                                    if (cb) cb();
                                    return;
                                }
                                if (this.online) {
                                    this.safeEmit('restoreClientState', local);
                                    if (cb) setTimeout(cb, 250);
                                }
                            },
                            format(s) {
                                s = Math.max(0, parseInt(s || 0));
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
@endsection
