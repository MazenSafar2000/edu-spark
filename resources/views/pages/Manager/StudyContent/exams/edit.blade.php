@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.edit_quizz') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    <form class="subject-form" action="{{ route('Exams.update', $sectionExam->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_ar"
                                        class="form-control custom-input float-input @error('Name_ar') custom-input-error @enderror"
                                        placeholder=" " value="{{ old('Name_ar', $exam->getTranslation('name', 'ar')) }}" />
                                    <label for="Name_ar"
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_ar') }}</label>
                                </div>
                                @error('Name_ar')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="Name_en"
                                        class="form-control custom-input float-input @error('Name_en') custom-input-error @enderror"
                                        i placeholder=" "
                                        value="{{ old('Name_en', $exam->getTranslation('name', 'en')) }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.quizz_name_en') }}</label>
                                </div>
                                @error('Name_en')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="form-group-float position-relative ">
                                <textarea name="description"
                                    class="form-control custom-textarea float-input @error('description') custom-textarea-error @enderror">{{ old('description', $exam->description) }}</textarea>
                                <label for="description"
                                    class="float-label">{{ trans('Teacher_trans.instructions') }}</label>
                            </div>
                            @error('description')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_at" class="text-danger">{{ trans('main_trans.start_at') }}*</label>
                                <input type="datetime-local" name="start_at"
                                    class="form-control custom-input @error('start_at') custom-input-error @enderror"
                                    id="start_at" placeholder="{{ trans('main_trans.start_at') }}"
                                    value="{{ old('start_at', $exam->start_at) }}">
                                @error('start_at')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('main_trans.end_at') }}*</label>
                                <input type="datetime-local" name="end_at"
                                    class="form-control custom-input @error('end_at') custom-input-error @enderror"
                                    id="end_at" placeholder="{{ trans('main_trans.end_at') }}"
                                    value="{{ old('end_at', $exam->end_at) }}">
                                @error('start_at')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="duration"
                                        class="form-control custom-input float-input @error('duration') custom-input-error @enderror"
                                        id="" placeholder="" value="{{ old('duration', $exam->duration) }}" />
                                    <label for="duration"
                                        class="float-label">{{ trans('Teacher_trans.duration_minute') }}*</label>
                                </div>
                                @error('duration')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="attempts"
                                        class="form-control custom-input float-input @error('attempts') custom-input-error @enderror"
                                        id="" placeholder="" value="{{ old('attempts', $exam->attempts) }}" />
                                    <label for="attempts"
                                        class="float-label">{{ trans('Teacher_trans.attempts') }}*</label>
                                </div>
                                @error('attempts')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="question_per_page"
                                        class="form-control custom-input float-input @error('question_per_page') custom-input-error @enderror"
                                        id="" placeholder=""
                                        value="{{ old('question_per_page', $exam->question_per_page) }}" />
                                    <label for="question_per_page"
                                        class="float-label">{{ trans('Teacher_trans.question_per_page') }}*</label>
                                </div>
                                @error('question_per_page')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="maximum_grade"
                                        class="form-control custom-input float-input @error('maximum_grade') custom-input-error @enderror"
                                        id="" placeholder=""
                                        value="{{ old('maximum_grade', $exam->maximum_grade) }}" />
                                    <label for="maximum_grade"
                                        class="float-label">{{ trans('Teacher_trans.maximum_grade') }}*</label>
                                </div>
                                @error('maximum_grade')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.Grade') }}*</label>
                                <select class="form-select custom-select @error('grade_id') custom-select-error @enderror"
                                    name="grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('main_trans.select_grade') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            {{ old('grade_id', $sectionExam->section->My_classs->Grades->id) == $grade->id ? 'selected' : '' }}>
                                            {{ $grade->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('grade_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.classroom') }}*</label>
                                <select
                                    class="form-select custom-select  @error('classroom_id') custom-select-error @enderror"
                                    name="classroom_id" id="classroom-select">
                                    <option value="{{ $sectionExam->section->My_classs->id }}">
                                        {{ $sectionExam->section->My_classs->Name_Class }}
                                    </option>
                                </select>
                                @error('classroom_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.section') }}*</label>
                                <select
                                    class="form-select custom-select  @error('section_id') custom-select-error @enderror"
                                    name="section_id" id="section-select">
                                    <option value="{{ $sectionExam->section_id }}">
                                        {{ $sectionExam->section->Name_Section }}
                                    </option>
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
                                <select
                                    class="form-select custom-select @error('subject_id') custom-select-error @enderror"
                                    name="subject_id" id="subject-select">
                                    <option value="{{ $exam->subject_id }}">
                                        {{ $exam->subject->name }}
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
                                <select
                                    class="form-select custom-select @error('teacher_id') custom-select-error @enderror"
                                    name="teacher_id" id="teachert-select">
                                    <option value="{{ $exam->teacher_id }}">
                                        {{ $exam->teacher->user->name }}
                                    </option>
                                </select>
                                @error('teacher_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Teacher_trans.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
