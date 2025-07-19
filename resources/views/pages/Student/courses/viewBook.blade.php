@extends('layouts.main.student_dashboard')
@section('student-content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <div class="container exam-preview-container">
            <div class="exam-preview-title text-center">
                <h4>
                    <span class="preview-title-text fw-bold">معاينة </span>
                    <span class="preview-title-highlight fw-bold">الكتاب</span>
                </h4>
            </div>

            <div class="preview-wrapper p-4">
                <div class="preview-card">
                    <h5 class="exam-title">{{ $book->title }}</h5>

                    <ul class="list-unstyled exam-description">
                        <li><strong>{{ trans('Teacher_trans.subject') }} :</strong> {{ $book->subject->name }} </li>
                        <li><strong> {{ trans('main_trans.Date_added') }} :</strong> {{ $book->created_at }}</li>

                    </ul>

                    <div class="exam-buttons d-flex  gap-3">
                        <a href="{{ asset('storage/attachments/library/teachers/' . $book->teacher->National_ID  . '/' . $book->file_name) }}"
                            target="_blank" class="btn exam-start-btn">
                            <i class="fas fa-download ms-1"></i> {{ trans('Students_trans.Download') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
