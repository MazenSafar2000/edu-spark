@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title">Exam Details</h3>

        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a href="{{ route('exams.create') }}">add questions</a>
                        {{-- <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}"> --}}
                    </div>

                    <div class="table-responsive">
                        <ul class="list-group mb-3">
                            <li class="list-group-item"><strong>name:</strong> {{ $exam->name }}</li>
                            <li class="list-group-item"><strong>description:</strong> {{ $exam->description }}</li>
                            <li class="list-group-item"><strong>subject:</strong> {{ $exam->subject->name }}</li>
                            {{-- <li class="list-group-item"><strong>الفصل:</strong> {{ $exam->classroom->name }}</li> --}}
                            <li class="list-group-item"><strong>الوقت:</strong> {{ $exam->duration }} دقيقة</li>
                            <li class="list-group-item"><strong>تاريخ البداية:</strong> {{ $exam->start_at }}</li>
                            <li class="list-group-item"><strong>تاريخ الانتهاء:</strong> {{ $exam->end_at }}</li>
                            <li class="list-group-item"><strong>الدرجة النهائية:</strong> {{ $exam->maximum_grade }}</li>
                            <li class="list-group-item"><strong>مجموع درجات الأسئلة:</strong> {{ $exam->total_marks }}</li>
                        </ul>

                        <div class="text-end">
                            <a href="{{ route('examQuestions.index', $exam->id) }}" class="btn btn-success">
                                إدارة أسئلة الامتحان
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
