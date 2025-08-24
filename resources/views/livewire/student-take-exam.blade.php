@extends('layouts.main.student_dashboard')

@section('student-content')
    {{-- Avoid FOUC with Alpine --}}

    <div id="mainContent" class="transition-all with-sidebar">
        <div class="container exam-preview-container">
            <div x-data="examApp()" x-init="init()" class="container py-3">

                {{-- Top bar: timer + connectivity --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge bg-secondary">
                            الصفحة: <span x-text="$wire.pageIndex + 1"></span> / {{ $totalPages }}
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge" :class="online ? 'bg-success' : 'bg-danger'">
                            <span x-text="online ? 'متصل' : 'غير متصل'"></span>
                        </span>
                        <span class="fw-bold text-danger">
                            الوقت المتبقي: <span x-text="format(timeLeft)"></span>
                        </span>
                    </div>
                </div>

                {{-- Questions on this page --}}
                <div>
                    @foreach ($currentQuestions as $q)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="mb-3">سؤال: {{ $q->question }}</h5> {{-- if question contains HTML, switch to {!! $q->question !!} --}}

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
                                                {{-- FIX: stop using addslashes; pass the actual value via $event to Livewire --}}
                                                wire:change="updateAnswer({{ $q->id }}, $event.target.value)"
                                                {{-- NEW: keep Alpine's local cache updated even when offline --}}
                                                x-on:change="answers[{{ $q->id }}] = $event.target.value; saveLocalState()">
                                            <label class="form-check-label"
                                                for="opt-{{ $q->id }}-{{ $idx }}">
                                                {{ $opt }}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif ($q->type === 'TrueFalse')
                                    @php $trueFalse = $opts ?: ['True','False']; @endphp
                                    @foreach ($trueFalse as $idx => $opt)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio"
                                                id="opt-{{ $q->id }}-{{ $idx }}"
                                                name="{{ $name }}" value="{{ $opt }}"
                                                @checked($currentVal === $opt)
                                                wire:change="updateAnswer({{ $q->id }}, $event.target.value)"
                                                x-on:change="answers[{{ $q->id }}] = $event.target.value; saveLocalState()">
                                            <label class="form-check-label"
                                                for="opt-{{ $q->id }}-{{ $idx }}">
                                                {{ $opt }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Essay / text --}}
                                    <textarea class="form-control" rows="4" {{-- Livewire autosave --}}
                                        wire:input.debounce.500ms="updateAnswer({{ $q->id }}, $event.target.value)" {{-- Keep Alpine local state in sync even when offline --}}
                                        x-on:input.debounce.500ms="answers[{{ $q->id }}] = $event.target.value; saveLocalState()">{{ $currentVal }}</textarea>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Page navigation --}}
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-outline-secondary" wire:click="previousPage"
                        @if ($pageIndex <= 0) disabled @endif>السابق</button>

                    <div class="d-flex gap-1 flex-wrap">
                        @for ($i = 0; $i < $totalPages; $i++)
                            <button class="btn btn-sm {{ $i === $pageIndex ? 'btn-primary' : 'btn-outline-primary' }}"
                                wire:click="goToPage({{ $i }})">
                                {{ $i + 1 }}
                            </button>
                        @endfor
                    </div>

                    <button class="btn btn-outline-secondary" wire:click="nextPage"
                        @if ($pageIndex >= $totalPages - 1) disabled @endif>التالي</button>
                </div>


                {{-- Submit --}}
                <div class="text-end mt-3">
                    <button class="btn btn-success" :disabled="submitting"
                        x-on:click="
                            submitting = true;
                            saveLocalState();
                            if (online) { safeEmit('submitExam'); }
                            else {
                                // Keep state locally; server will hard-stop at deadline.
                                // Optionally show a toast here.
                                submitting = false;
                            }
                        ">تسليم
                        الامتحان</button>
                </div>

                {{-- Alpine app (wire:ignore) --}}
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
                                        // Never extend client beyond server value
                                        if (typeof local.timeLeft === 'number') {
                                            this.timeLeft = Math.min(this.timeLeft, local.timeLeft);
                                        }
                                        if (local.answers && typeof local.answers === 'object') {
                                            // Keep local answers for offline continuity
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

                                    // 4) Start ticking (client UI); server enforces deadline
                                    this.startUITimer();

                                    // 5) If we have anything unsent and we are online, push once now
                                    if (this.online) this.flushLocalToServer();
                                },

                                startUITimer() {
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
                                            // Else: state is saved locally; server deadline will stop the attempt.
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
                                    // Send a compact payload: server will clamp time and upsert answers
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
    </div>
@endsection
