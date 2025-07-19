@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">


        <div class="container mt-5">
            <div class="page-title-parent">
                <h2> {{ $teacher_section->subject->name }} - <span>{{ $teacher_section->teacher->user->name }}</span></h2>
                <a href="student-mark.html">العلامات</a>
            </div>

            <div class="accordion" id="contentAccordion">

                @foreach ($materials as $material)
                    <div class="accordion-item">
                        <div class="unit-content d-flex justify-content-between">
                            @if ($material['type'] == 'book')
                                <div class="unit-content-subject">
                                    <a href="{{ route('subject.viewBook', $material['data']->id)}}" class="unit-link">
                                        <i class="fas fa-link"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date">{{ $material['created_at'] }}</p>
                                </div>
                                <div class="unit-action">
                                    <a href="{{ route('subject.viewBook', $material['data']->id)}}" class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>
                                </div>
                            @elseif($material['type'] == 'homework')
                                <div class="unit-content-subject">
                                    <a href="{{ route('subject.viewHomework', $material['data']->id)}}" class="unit-link">
                                        <i class="fas fa-link"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date">{{ $material['created_at'] }}</p>
                                </div>
                                <div class="unit-action">
                                    <a href="{{ route('subject.viewHomework', $material['data']->id)}}" class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>
                                </div>
                            @elseif($material['type'] == 'exam')
                                <div class="unit-content-subject">
                                    <a href="{{ route('subject.viewExam', $material['data']->id)}}" class="unit-link">
                                        <i class="fas fa-link"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date">{{ $material['created_at'] }}</p>
                                </div>
                                <div class="unit-action">
                                    <a href="{{ route('subject.viewExam',$material['data']->id)}}" class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>
                                </div>
                            @elseif($material['type'] == 'recorded')
                                <div class="unit-content-subject">
                                    <a href="{{ route('subject.viewRecoreded', $material['data']->id)}}" class="unit-link">
                                        <i class="fas fa-link"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date">{{ $material['created_at'] }}</p>
                                </div>
                                <div class="unit-action">
                                    <a href="{{ route('subject.viewRecoreded', $material['data']->id)}}" class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>
                                </div>
                            @elseif($material['type'] == 'online')
                                <div class="unit-content-subject">
                                    <a href="" class="unit-link">
                                        <i class="fas fa-link"></i>
                                        {{ $material['title'] }}
                                    </a>
                                    <p class="add-date">{{ $material['created_at'] }}</p>
                                </div>
                                <div class="unit-action">
                                    <a href="student-book-preview.html" class="btn action-eye-btn">
                                        <i class="fas fa-eye ms-1"></i> {{ trans('Students_trans.view') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
