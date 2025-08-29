@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    {{-- <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title">Exam Details</h3>

        <div class="table-users-teacher mt-5">
            <!-- المحتوى -->
            <div class="table-content-teacher tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel">
                    <div class="header-table-teacher">
                        <a href="{{ route('exams.create') }}">add questions</a>
                        <input type="search" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>

                    <div class="table-responsive">
                        <ul class="list-group mb-3">
                            <li class="list-group-item"><strong>name:</strong> {{ $exam->name }}</li>
                            <li class="list-group-item"><strong>description:</strong> {{ $exam->description }}</li>
                            <li class="list-group-item"><strong>subject:</strong> {{ $exam->subject->name }}</li>
                            <li class="list-group-item"><strong>الفصل:</strong> {{ $exam->classroom->name }}</li>
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
    </div> --}}


    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-title2">{{ trans('main_trans.exam_details') }}</h3>
        <div class="title-underline"></div>

        <div class="student-data">

            <ul class="nav nav-tabs nav-exam-data" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab">{{ trans('main_trans.details') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions"
                        type="button" role="tab">{{ trans('main_trans.questions') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="resuls-tab" data-bs-toggle="tab" data-bs-target="#resuls" type="button"
                        role="tab">{{ trans('main_trans.results') }}</button>
                </li>


                <div class="dropdown">
                    <button class="dropdown-toggle dropdown-toggle-detalis" data-bs-toggle="dropdown">
                        {{ trans('main_trans.more') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-operations">

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('exams.edit', $exam->id) }}">
                                <i class="fas fa-edit action-icon edit-icon-action"></i> {{ trans('main_trans.edit') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal"
                                data-bs-target="#deleteModal-exam{{ $exam->id }}">
                                <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                {{ trans('main_trans.delete') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>

            <!-- delete exam modal -->
            <div class="modal fade" id="deleteModal-exam{{ $exam->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                    <div class="modal-content">
                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('main_trans.close') }}"></button>
                            </div>
                            <div class="modal-body text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                            </div>
                            <div class="modal-footer custom-modal-footer">
                                <button type="submit" class="btn btn-primary custom-save-btn" form="stageForm">
                                    {{ trans('main_trans.delete') }}</button>
                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                    data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-users mt-5">
                <!-- المحتوى -->
                <div class="table-content tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <div class="container">
                            <div class="exam-table table-responsive">
                                <table class="table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('main_trans.exam_name') }}</td>
                                            <td>{{ $exam->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('main_trans.instructions') }}</td>
                                            <td> {{ $exam->description }} </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.subject') }}</td>
                                            <td>{{ $exam->subject->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.duration') }}</td>
                                            <td>{{ $exam->duration }} minute/minutes</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.start_at') }}</td>
                                            <td>{{ $exam->start_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.end_at') }}</td>
                                            <td>{{ $exam->end_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.Final_grade') }}</td>
                                            <td>{{ $exam->maximum_grade }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('Teacher_trans.Total_question_scores') }}</td>
                                            <td>{{ $exam->total_marks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="questions" role="tabpanel">

                        <div class="custom-form-container container">
                            <form action="{{ route('exam.questions.updateSettings', $exam->id) }}" method="POST"
                                class="mb-4">
                                @csrf
                                @method('PUT')
                                <div class="row align-items-center g-3">


                                    <!-- العمود الأول: الدرجة النهائية -->
                                    <div class="col-md-8 col-12">
                                        <div class="form-group-float position-relative">
                                            <input type="number" name="maximum_grade" step="0.01"
                                                class="form-control custom-input-form float-input" placeholder=" "
                                                value="{{ $exam->maximum_grade }}" />
                                            <label class="float-label">{{ trans('Teacher_trans.Final_grade') }}</label>
                                        </div>
                                    </div>

                                    <!-- العمود الثاني: تبديل ترتيب الأسئلة -->
                                    <div class="col-md-2 col-12 d-flex align-items-center">
                                        <label class="custom-checkbox-label m-0">
                                            <input type="checkbox" class="custom-checkbox" name="shuffle_questions"
                                                id="shuffle_questions" {{ $exam->shuffle_questions ? 'checked' : '' }}>
                                            {{ trans('Teacher_trans.shuffle_questions') }}
                                        </label>
                                    </div>

                                    <!-- العمود الثالث: زر حفظ -->
                                    <div class="col-md-2 col-12">
                                        <button type="submit"
                                            class="custom-btn-save">{{ trans('main_trans.Save_modifications') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>




                        <div class="container custom-table-teacher">

                            <div class="table-responsive custom-table-wrapper">
                                <table class="table text-center custom-grade-table">
                                    <thead class="thead-custom">
                                        <tr>
                                            <th>#</th>
                                            <th> السؤال</th>
                                            <th> القسم</th>
                                            <th>النوع</th>
                                            <th>الدرجة</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exam->questions as $question)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $question->question }}</td>
                                                <td>{{ $question->QCategory->title }}</td>
                                                <td>{{ $question->pivot->score }}</td>
                                                <td>{{ $question->type }}</td>
                                                <td>
                                                    {{-- <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal-question">
                                                        <i class="fas fa-trash-alt action-icon delete-icon-action"
                                                            title="حذف السؤال"></i>
                                                    </a> --}}
                                                    <form method="POST"
                                                        action="{{ route('exam.remove-question', [$exam->id, $question->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="pagination-container d-flex justify-content-between">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>

                                    <div class="pagination-show">
                                        <p>عرض 1 إلى 10 من 10 إدخالات</p>
                                        <div class="title-underline-page"></div>

                                    </div>
                                </div>

                                <div class="dropdown">
                                    <button class="operations-btn-exam dropdown-toggle" data-bs-toggle="dropdown">
                                        إضافة سؤال
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-subjects">

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                href="teacher-forms/teacher-add-question.html">
                                                سؤال جديد
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal" data-bs-target="#addModal-questionRandom">
                                                سؤال عشوائي
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                                data-bs-toggle="modal" data-bs-target="#addModal-questionBank">
                                                بنك الأسئلة
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Modal حذف الطالب -->
                                <div class="modal fade" id="deleteModal-question" tabindex="-1"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="إغلاق"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                <p>هل أنت متأكد أنك تريد حذف هذا السؤال ؟</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-del">تأكيد الحذف</button>
                                                <button type="button" class="btn btn-cancel"
                                                    data-bs-dismiss="modal">إلغاء</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade custom-modal" id="addModal-questionRandom" tabindex="-1"
                                    aria-labelledby="addModal-questionRandom" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                        <div class="modal-content custom-modal-content">

                                            <!-- رأس المودال -->
                                            <div class="modal-header custom-modal-header">
                                                <h5 class="modal-title custom-modal-title" id="addModal-questionRandom">
                                                    إضافة سؤال عشوائي</h5>
                                            </div>

                                            <!-- جسم المودال -->
                                            <div class="modal-body custom-modal-body">
                                                <form id="stageForm" class="custom-form">


                                                    <div class="mb-3 custom-form-group">
                                                        <select class="form-select custom-select" id="grade">
                                                            <option selected disabled>اختر تصنيف الاسئلة ...</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3 custom-form-group">
                                                        <div class="form-group-float position-relative ">
                                                            <input type="text"
                                                                class="form-control custom-input float-input"
                                                                id="" placeholder=" " />
                                                            <label for="" class="float-label">عدد الاسئلة
                                                                العشوائية</label>
                                                        </div>
                                                    </div>


                                                </form>
                                            </div>

                                            <!-- تذييل المودال -->
                                            <div class="modal-footer custom-modal-footer">
                                                <button type="submit" class="btn btn-primary custom-save-btn"
                                                    form="stageForm">اضافة</button>
                                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                    data-bs-dismiss="modal">إلغاء</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade custom-modal" id="addModal-questionBank" tabindex="-1"
                                    aria-labelledby="addModal-questionBank" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered custom-modal-dialog modal-lg">
                                        <div class="modal-content custom-modal">
                                            <!-- رأس المودال -->
                                            <div class="modal-header custom-modal-header">
                                                <h5 class="modal-title custom-modal-title" id="addModal-questionBank">
                                                    إضافة من بنك الاسئلة</h5>
                                            </div>

                                            <div class="modal-body custom-modal-body">

                                                <div class="mb-3 custom-form">
                                                    <select class="form-select custom-select" id="grade">
                                                        <option selected disabled>اختر تصنيف الاسئلة ...</option>
                                                    </select>
                                                </div>

                                                <!-- الجدول -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" class="form-check-input"></th>
                                                                <th>السؤال</th>
                                                                <th>النوع</th>
                                                                <th>الدرجة</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="checkbox" class="form-check-input"></td>
                                                                <td>السؤال الأول</td>
                                                                <td>MCQ</td>
                                                                <td>15</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="form-check-input"></td>
                                                                <td>السؤال الثاني</td>
                                                                <td>MCQ</td>
                                                                <td>10</td>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="checkbox" class="form-check-input"></td>
                                                                <td>السؤال الثالث</td>
                                                                <td>MCQ</td>
                                                                <td>20</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <div class="modal-footer custom-modal-footer">
                                                <button type="submit" class="btn btn-primary custom-save-btn"
                                                    form="stageForm">اضافة</button>
                                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                    data-bs-dismiss="modal">إلغاء</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>


                    <div class="tab-pane fade" id="resuls" role="tabpanel">
                        <div class="charts-wrapper">
                            <div class="chart-box">
                                <canvas id="barChart"></canvas>
                            </div>

                            <div class="chart-box">
                                <canvas id="donutChart"></canvas>
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
                                        <tr>
                                            <td>1</td>
                                            <td>محمد محمد</td>
                                            <td>20</td>
                                            <td>12-3-2025 3:30pm</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle dropdown-toggle-operations"
                                                        data-bs-toggle="dropdown">
                                                        العمليات
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-operations">
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="teacher-exam-review.html">
                                                                <i class="fas fa-eye eye-icon-action"></i> عرض الإجابات
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-2"
                                                                href="#" data-bs-toggle="modal"
                                                                data-bs-target="#relodeModal-exam">
                                                                <i class="fas fa-rotate-right relode-icon-action"></i>
                                                                إعادة الاختبار
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div class="modal fade" id="relodeModal-exam" tabindex="-1" aria-labelledby="relodeModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="إغلاق"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <i class="fas fa-rotate-right fa-3x mb-3"></i>
                                        <p>هل أنت متأكد من أنك تريد اعادة الاختبار للطالب <span>أحمد محمد</span></p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-del">تأكيد</button>
                                        <button type="button" class="btn btn-cancel"
                                            data-bs-dismiss="modal">إلغاء</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>

    </div>
@endsection
