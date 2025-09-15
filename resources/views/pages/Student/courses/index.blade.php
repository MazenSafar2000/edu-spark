@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">


        <div class="container mt-5 subject-data">
            <div class="page-title-parent">
                <h2>{{ $teacher_section->subject->name }} - <span>{{ $teacher_section->teacher->user->name }}</span></h2>
                {{-- <a href="student-mark.html">العلامات</a> --}}
            </div>
            <div class="accordion" id="contentAccordion">
                @foreach ($materials as $material)
                    @if ($material['type'] == 'book')
                        {{-- book --}}
                        <div class="accordion-item">
                            <div class="unit-content d-flex justify-content-between">
                                <div class="unit-content-subject">
                                    <a href="{{ route('subject.viewBook', $material['data']->id) }}" class="unit-link">
                                        <i class="fas fa-book"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('subject.viewBook', $material['data']->id) }}"
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
                                    <a href="{{ route('subject.viewHomework', $material['data']->id) }}" class="unit-link">
                                        <i class="fa fa-tasks"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('subject.viewHomework', $material['data']->id) }}"
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
                                    <a href="{{ route('subject.viewExam', $material['data']->id) }}" class="unit-link">
                                        <i class="fa fa-pen-to-square"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('subject.viewExam', $material['data']->id) }}"
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
                                    <a href="{{ route('subject.viewRecoreded', $material['data']->id) }}"
                                        class="unit-link">
                                        <i class="fas fa-play-circle"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('subject.viewRecoreded', $material['data']->id) }}"
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
                                    <a href="{{ route('subject.viewZoomClass', $material['data']->id) }}"
                                        class="unit-link">
                                        <i class="fas fa-video"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date"><span>{{ $material['created_at'] }}</span></p>
                                </div>

                                <div class="unit-action">
                                    <a href="{{ route('subject.viewZoomClass', $material['data']->id) }}"
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
    <br><br><br><br>
    <br><br><br><br>
@endsection
