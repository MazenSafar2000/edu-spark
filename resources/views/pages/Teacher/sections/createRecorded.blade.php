@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.Add_new_recordedClass') }}</h3>

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
                    <form class="subject-form" action="{{ route('recordedClasses.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="section_id" value="{{ $teacher_section->section_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $teacher_section->section->My_classs->id }}">
                        <input type="hidden" name="grade_id"
                            value="{{ $teacher_section->section->My_classs->Grades->id }}">
                        <input type="hidden" name="subject_id" value="{{ $teacher_section->subject_id }}">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title" class="form-control custom-input float-input" />
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.Class_title') }}</label>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="description"
                                        class="form-control custom-input float-input" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.class_description_optional') }}</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="url" name="video_url" class="form-control custom-input float-input"
                                        placeholder=" " />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.Class_link') }}</label>
                                </div>
                                <p>{{ trans('Teacher_trans.Class_link') }} <small>
                                        {{ trans('Teacher_trans.video_types') }}</small></p>
                            </div>

                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Grades_trans.submit') }}</button>
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
