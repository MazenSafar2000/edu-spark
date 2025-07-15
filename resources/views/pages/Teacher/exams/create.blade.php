@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.add_new_quizz') }}</h3>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="subject-form" action="{{ route('exams.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_ar" class="form-control custom-input float-input"
                                        id="" placeholder=" " />
                                    @error('Name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_ar') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_en" class="form-control custom-input float-input"
                                        id="" placeholder=" " />
                                    @error('Name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_en') }}</label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.grade') }}*</label>
                                <select class="form-select custom-select" name="Grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            {{ old('Grade_id') == $grade->id ? 'selected' : '' }}>
                                            {{ $grade->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Grade_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('Students_trans.classrooms') }}*</label>
                                <select class="form-select custom-select" name="Classroom_id" id="classroom-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_class') }}</option>
                                </select>
                                @error('Classroom_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div> --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.Grade') }}*</label>
                                <select class="form-select custom-select" name="grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('Sections_trans.Select_Grade') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->Name }}</option>
                                    @endforeach
                                </select>
                                @error('grade_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.classroom') }}*</label>
                                <select class="form-select custom-select" name="classroom_id" id="classroom-select">
                                    <option disabled>{{ trans('Teacher_trans.select_class') }}</option>
                                </select>
                                @error('classroom_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.section') }}*</label>
                                <select class="form-select custom-select" name="section_id" id="section-select">
                                    <option disabled selected>{{ trans('Teacher_trans.select_section') }}</option>
                                </select>
                                @error('section_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.subject') }}*</label>
                                <select name="subject_id" id="subject-select" class="form-select custom-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_subject') }}</option>
                                </select>
                                @error('subject_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="duration" class="form-control custom-input float-input" />
                                    <label for="duration"
                                        class="float-label">{{ trans('Teacher_trans.duration_minute') }}</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_at" class="text-danger">{{ trans('main_trans.start_at') }}*</label>
                                <input type="datetime-local" name="start_at" class="form-control custom-input"
                                    id="start_at" placeholder="{{ trans('main_trans.start_at') }}">
                                @error('start_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('main_trans.end_at') }}*</label>
                                <input type="datetime-local" name="end_at" class="form-control custom-input" id="end_at"
                                    placeholder="{{ trans('main_trans.end_at') }}">
                                @error('end_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Teacher_trans.save_data') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- محتوى الصفحة هنا -->
    </div>
@endsection
@section('js')
    <script>
        $('#grade-select').on('change', function() {
            let gradeId = $(this).val();
            $('#classroom-select').empty().append('<option selected disabled>Loading...</option>');
            $('#section-select').empty().append('<option selected disabled>Select Section</option>');
            $('#subject-select').empty().append('<option selected disabled>Select Subject</option>');

            $.get('/teacher/getClassroomsByGrade/' + gradeId, function(data) {
                $('#classroom-select').empty().append(
                    '<option selected disabled>Select Classroom</option>');
                data.forEach(function(classroom) {
                    $('#classroom-select').append(
                        `<option value="${classroom.id}">${classroom.name}</option>`);
                });
            });
        });

        $('#classroom-select').on('change', function() {
            let classroomId = $(this).val();
            $('#section-select').empty().append('<option selected disabled>Loading...</option>');
            $('#subject-select').empty().append('<option selected disabled>Select Subject</option>');

            $.get('/teacher/getSectionsByClassroom/' + classroomId, function(data) {
                $('#section-select').empty().append('<option selected disabled>Select Section</option>');
                data.forEach(function(section) {
                    $('#section-select').append(
                        `<option value="${section.id}">${section.name}</option>`);
                });
            });
        });

        $('#section-select').on('change', function() {
            let sectionId = $(this).val();
            $('#subject-select').empty().append('<option selected disabled>Loading...</option>');

            $.get('/teacher/getSubjectsBySection/' + sectionId, function(data) {
                $('#subject-select').empty().append('<option selected disabled>Select Subject</option>');
                data.forEach(function(subject) {
                    $('#subject-select').append(
                        `<option value="${subject.id}">${subject.name}</option>`);
                });
            });
        });
    </script>
@endsection
