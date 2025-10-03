@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">{{ trans('Students_trans.preview_ZoomClass') }}</span>
                </h4>
            </div>

            <div class="preview-wrapper p-4">
                <div class="preview-card">

                    <h5 class="exam-title">{{ $class->topic }}</h5>

                    <ul class="list-unstyled exam-description">
                        <li><strong>{{ trans('Students_trans.subject') }} :</strong> {{ $class->subject->name }}</li>
                        <li><strong>{{ trans('main_trans.Name_Teacher') }} :</strong>{{ $class->teacher->user->name }}
                        </li>
                        <li><strong>{{ trans('main_trans.start_at') }} :</strong> {{ $class->start_at }}
                        </li>
                        <li><strong>{{ trans('Students_trans.duration') }} :</strong> {{ $class->duration }}
                        </li>
                        <li><strong>{{ trans('Teacher_trans.Class_link') }} :</strong> <a href="{{ $class->start_url }}">{{ trans('main_trans.join_now') }}</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
