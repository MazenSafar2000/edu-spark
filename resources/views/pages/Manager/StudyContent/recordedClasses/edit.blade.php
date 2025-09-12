@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.Update_recordedClass') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    <form class="subject-form" action="{{ route('RecordedClasses.update', $class->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title"
                                        class="form-control custom-input float-input @error('title') custom-input-error @enderror"
                                        id="" placeholder=" " value="{{ old('title', $class->title) }}" />
                                    <label for="title"
                                        class="float-label">{{ trans('Teacher_trans.Class_title') }}*</label>
                                </div>
                                @error('title')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <textarea name="description"
                                        class="form-control custom-textarea float-input @error('description') custom-textarea-error @enderror"
                                        id="" placeholder="">{{ old('description', $class->description) }}</textarea>
                                    <label for="description"
                                        class="float-label">{{ trans('Teacher_trans.class_description_optional') }}</label>
                                </div>
                                @error('description')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.Grade') }}*</label>
                                <select class="form-select custom-select @error('grade_id') custom-select-error @enderror"
                                    name="grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_grade') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            {{ $grade->id == $class->grade_id ? 'selected' : '' }}>
                                            {{ $grade->Name }}</option>
                                    @endforeach
                                </select>
                                @error('grade_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.classrooms') }}*</label>
                                <select
                                    class="form-select custom-select @error('classroom_id') custom-select-error @enderror"
                                    name="classroom_id" id="classroom-select">
                                    <option value="{{ $class->classroom_id }}">
                                        {{ $class->classroom->Name_Class }}</option>
                                </select>
                                @error('classroom_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.section') }}*</label>
                                <select class="form-select custom-select @error('section_id') custom-select-error @enderror"
                                    name="section_id" id="section-select">
                                    <option value="{{ $class->section_id }}">
                                        {{ $class->section->Name_Section }}</option>
                                </select>
                                @error('section_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('Students_trans.subjects') }}*</label>
                                <select class="form-select custom-select @error('subject_id') custom-select-error @enderror"
                                    name="subject_id" id="subject-select">
                                    <option value="{{ $class->subject_id }}">
                                        {{ $class->subject->name }}
                                    </option>
                                </select>
                                @error('subject_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('main_trans.Teachers') }}*</label>
                                <select class="form-select custom-select @error('teacher_id') custom-select-error @enderror"
                                    name="teacher_id" id="teachert-select">
                                    <option value="{{ $class->teacher_id }}">
                                        {{ $class->teacher->user->name }}
                                    </option>
                                </select>
                                @error('teacher_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="url" name="video_url"
                                        class="form-control custom-input float-input @error('video_url') custom-input-error @enderror"
                                        placeholder=" " value="{{ old('video_url', $class->video_url) }}" />
                                    <label for="video_url"
                                        class="float-label">{{ trans('Teacher_trans.Class_link') }}</label>
                                </div>
                                <p>{{ trans('Teacher_trans.video_types') }}</p>
                                @error('video_url')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
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
        // When grade is selected
        $('#grade-select').on('change', function() {
            let gradeId = $(this).val();
            $('#classroom-select').empty().append('<option selected disabled>Loading...</option>');
            $('#section-select').empty().append(
                '<option selected disabled>{{ trans('main_trans.select_section') }}</option>');
            $('#subject-select').empty().append(
                '<option selected disabled>{{ trans('main_trans.select_subject') }}</option>');
            $('#teachert-select').empty().append(
                '<option selected disabled>{{ trans('main_trans.select_teacher_name') }}</option>');

            $.get('/ajax/classrooms/' + gradeId, function(data) {
                $('#classroom-select').empty().append(
                    '<option selected disabled>Select Classroom</option>');
                data.forEach(function(classroom) {
                    $('#classroom-select').append(
                        `<option value="${classroom.id}">${classroom.name}</option>`);
                });
            });
        });

        // When classroom is selected
        $('#classroom-select').on('change', function() {
            let classroomId = $(this).val();
            $('#section-select').empty().append('<option selected disabled>Loading...</option>');
            $('#subject-select').empty().append(
                '<option selected disabled>{{ trans('main_trans.select_subject') }}</option>');
            $('#teachert-select').empty().append(
                '<option selected disabled>{{ trans('main_trans.select_teacher_name') }}</option>');

            $.get('/ajax/sections/' + classroomId, function(data) {
                $('#section-select').empty().append(
                    '<option selected disabled>{{ trans('main_trans.select_section') }}</option>');
                data.forEach(function(section) {
                    $('#section-select').append(
                        `<option value="${section.id}">${section.name}</option>`);
                });
            });
        });

        // When section is selected
        $('#section-select').on('change', function() {
            let sectionId = $(this).val();
            $('#subject-select').empty().append('<option selected disabled>Loading...</option>');
            $('#teachert-select').empty().append(
                '<option selected disabled>{{ trans('main_trans.select_teacher_name') }}</option>');

            $.get('/ajax/subjects/' + sectionId, function(data) {
                $('#subject-select').empty().append(
                    '<option selected disabled>{{ trans('main_trans.select_subject') }}</option>');
                data.forEach(function(subject) {
                    $('#subject-select').append(
                        `<option value="${subject.id}">${subject.name}</option>`);
                });
            });
        });

        // When subject is selected
        $('#subject-select').on('change', function() {
            let subjectId = $(this).val();
            let sectionId = $('#section-select').val();
            $('#teachert-select').empty().append('<option selected disabled>Loading...</option>');

            $.get('/ajax/teachers/' + sectionId + '/' + subjectId, function(data) {
                $('#teachert-select').empty().append(
                    '<option selected disabled>{{ trans('main_trans.select_teacher_name') }}</option>');
                data.forEach(function(teacher) {
                    $('#teachert-select').append(
                        `<option value="${teacher.id}">${teacher.name}</option>`);
                });
            });
        });
    </script>
@endsection
