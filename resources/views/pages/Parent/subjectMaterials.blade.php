@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container mt-5">
            <div class="page-title-parent">
                <h2>{{ $teacher_section->subject->name }} - <span>{{ $teacher_section->teacher->user->name }}</span></h2>
                <a href="{{ route('parent.subject.scores', ['teacherSection' => $teacher_section, 'studentId' => $student->id]) }}">
                    {{ trans('main_trans.scores') }}
                </a>
            </div>
            <div class="accordion" id="contentAccordion">
                @foreach ($materials as $material)
                    @if ($material['type'] == 'book')
                        {{-- book --}}
                        <div class="accordion-item">
                            <div class="unit-content d-flex justify-content-between">
                                <div class="unit-content-subject">
                                    <a href="{{ route('book.details', ['bookId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="unit-link">
                                        <i class="fas fa-book"></i>
                                        {{ $material['title'] }} </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('book.details', ['bookId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>

                                </div>
                            </div>
                        </div>
                    @elseif($material['type'] == 'homework')
                        {{-- homework --}}
                        <div class="accordion-item">
                            <div class="unit-content d-flex justify-content-between">
                                <div class="unit-content-subject">
                                    <a href="{{ route('homework.details', ['homeworkId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="unit-link">
                                        <i class="fas fa-tasks"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('homework.details', ['homeworkId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>

                                </div>
                            </div>
                        </div>
                    @elseif($material['type'] == 'exam')
                        {{-- exam --}}
                        <div class="accordion-item">
                            <div class="unit-content d-flex justify-content-between">
                                <div class="unit-content-subject">
                                    <a href="{{ route('exam.details', ['examId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="unit-link">
                                        <i class="fas fa-pen-to-square"></i>
                                        {{ $material['title'] }} </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('exam.details', ['examId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>

                                </div>
                            </div>
                        </div>
                    @elseif($material['type'] == 'recorded')
                        {{-- recorded --}}
                        <div class="accordion-item">
                            <div class="unit-content d-flex justify-content-between">
                                <div class="unit-content-subject">
                                    <a href="{{ route('recordedClass.details', ['classId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="unit-link">
                                        <i class="fas fa-play-circle"></i>
                                        {{ $material['title'] }} </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('recordedClass.details', ['classId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>

                                </div>
                            </div>
                        </div>
                    @elseif($material['type'] == 'online')
                        {{-- zoom --}}
                        <div class="accordion-item">
                            <div class="unit-content d-flex justify-content-between">
                                <div class="unit-content-subject">
                                    <a href="{{ route('zoomClass.details', ['classId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="unit-link">
                                        <i class="fas fa-video"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('zoomClass.details', ['classId' => $material['data']->id, 'studentId' => $student->id]) }}"
                                        class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <br><br><br><br><br>
@endsection
