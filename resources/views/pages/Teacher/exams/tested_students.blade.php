@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="tab-pane fade show active" id="resuls" role="tabpanel">
            <div class="charts-wrapper">
                <!-- Donut Chart -->
                <div class="chart-box">
                    <canvas id="donutChart"></canvas>
                </div>

                <!-- Results Distribution Chart -->
                <div class="chart-box">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="container custom-table-teacher">
                <div class="search-box-student text-end mb-3">
                    <input type="search" class="form-control search-input-custom" placeholder="ابحث ...">
                </div>

                <div class="table-responsive custom-table-wrapper">
                    <table class="table text-center custom-grade-table">
                        <thead class="thead-custom">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>الدرجة</th>
                                <th>موعد التسليم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                @php
                                    $attempt = $attempts[$student->id] ?? null;
                                    $degree = $degrees[$student->id] ?? null;
                                    $grade = $attempt->grade_obtained ?? ($degree->score ?? null);
                                    $ended = $attempt->ended_at ?? ($degree->date ?? null);
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $grade ?? '-' }}</td>
                                    <td>
                                        @if ($attempt && $attempt->ended_at)
                                            {{ $attempt->ended_at->format('d-m-Y h:ia') }}
                                        @else
                                            لم يؤدِ الامتحان
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle dropdown-toggle-operations"
                                                data-bs-toggle="dropdown">
                                                العمليات
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-operations">
                                                @if ($attempt)
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('teacher.exams.studentAttempts', [$exam->id, $student->id]) }}">
                                                            <i class="fas fa-eye eye-icon-action"></i> show attempts
                                                        </a>
                                                    </li>
                                                    {{-- <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#relodeModal-exam-{{ $student->id }}">
                                                            <i class="fas fa-rotate-right relode-icon-action"></i> إعادة
                                                            الاختبار
                                                        </a>
                                                    </li> --}}
                                                @endif
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editGradeModal-{{ $student->id }}">
                                                        <i class="fas fa-edit"></i> تعديل الدرجة
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal: Reset exam -->
                                @if ($attempt)
                                    <div class="modal fade" id="relodeModal-exam-{{ $student->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="fas fa-rotate-right fa-3x mb-3"></i>
                                                    <p>هل تريد إعادة الاختبار للطالب <span>{{ $student->name }}</span>؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form method="POST" action="">
                                                        @csrf
                                                        <button type="submit" class="btn btn-del">تأكيد</button>
                                                    </form>
                                                    <button type="button" class="btn btn-cancel"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Modal: Edit grade -->
                                <div class="modal fade" id="editGradeModal-{{ $student->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تعديل درجة الطالب: {{ $student->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('manual.degree.store') }}">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <input type="hidden" name="exam_id" value="{{ $exam->id }}">

                                                <div class="modal-body">
                                                    <input type="number" step="0.01" name="score" class="form-control"
                                                        value="{{ $attempt->grade_obtained ?? '' }}"
                                                        placeholder="أدخل الدرجة الجديدة">
                                                </div>
                                                <div class="modal-body">
                                                    <label>{{ trans('Teacher_trans.Feedback') }}</label>
                                                    <textarea name="feedback" class="form-control" rows="4">{{ $degree?->feedback ?? '' }}</textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-del">حفظ</button>
                                                    <button type="button" class="btn btn-cancel"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Donut Chart
            var ctxDonut = document.getElementById("donutChart").getContext("2d");
            new Chart(ctxDonut, {
                type: "doughnut",
                data: {
                    labels: ["أدوا الامتحان", "لم يؤدوا", "نجحوا", "راسبوا"],
                    datasets: [{
                        data: [
                            {{ $stats['attempted'] }},
                            {{ $stats['not_attempted'] }},
                            {{ $stats['success'] }},
                            {{ $stats['fail'] }}
                        ],
                        backgroundColor: ["#36A2EB", "#FFCE56", "#4CAF50", "#F44336"]
                    }]
                }
            });

            // Bar Chart
            var ctxBar = document.getElementById("barChart").getContext("2d");
            new Chart(ctxBar, {
                type: "bar",
                data: {
                    labels: {!! json_encode(array_keys($distribution)) !!},
                    datasets: [{
                        label: "عدد الطلاب",
                        data: {!! json_encode(array_values($distribution)) !!},
                        backgroundColor: "#36A2EB"
                    }]
                }
            });
        });
    </script>
@endsection
