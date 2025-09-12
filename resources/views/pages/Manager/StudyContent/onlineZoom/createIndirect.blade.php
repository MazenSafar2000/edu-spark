@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.Add_manual_meeting') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    @include('components.error-field')
                    <form class="subject-form" action="{{ route('zoomCLasses.store.indirect') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="topic"
                                        class="form-control custom-input float-input @error('topic') custom-input-error @enderror"
                                        placeholder=" " />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.Class_title') }}</label>
                                </div>
                                @error('topic')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.Grade') }}*</label>
                                <select class="form-select custom-select @error('Grade_id') custom-select-error @enderror"
                                    name="Grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_grade') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->Name }}</option>
                                    @endforeach
                                </select>
                                @error('Grade_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.classrooms') }}*</label>
                                <select
                                    class="form-select custom-select @error('Classroom_id') custom-select-error @enderror"
                                    name="Classroom_id" id="classroom-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_class') }}</option>
                                </select>
                                @error('Classroom_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Students_trans.section') }}*</label>
                                <select class="form-select custom-select @error('section_id') custom-select-error @enderror"
                                    name="section_id" id="section-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_section') }}</option>
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
                                <label for="" class="text-danger">{{ trans('Teacher_trans.subject') }}*</label>
                                <select class="form-select custom-select @error('subject_id') custom-select-error @enderror"
                                    name="subject_id" id="subject-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_subject') }}</option>
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
                                    <option selected disabled>{{ trans('main_trans.select_teacher_name') }}</option>
                                </select>
                                @error('teacher_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.Class_time') }}*</label>
                                <input type="datetime-local" name="start_time"
                                    class="form-control custom-input @error('start_time') custom-input-error @enderror"
                                    value="{{ old('start_time') }}">
                                @error('start_time')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group-float position-relative">
                                    <input type="password" name="password"
                                        class="form-control custom-input float-input @error('password') custom-input-error @enderror"
                                        placeholder=" " />
                                    <label for="" class="float-label">{{ trans('Teacher_trans.Password') }}</label>
                                </div>
                                @error('password')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="form-group-float position-relative">
                                    <input type="number" name="duration"
                                        class="form-control custom-input float-input @error('duration') custom-input-error @enderror"
                                        placeholder=" " value="{{ old('duration') }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.duration') }}</label>
                                </div>
                                @error('duration')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="form-group-float position-relative">
                                    <input type="text" name="meeting_id"
                                        class="form-control custom-input float-input @error('meeting_id') custom-input-error @enderror"
                                        placeholder=" " value="{{ old('meeting_id') }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.Meeting_number') }}</label>
                                </div>
                                @error('meeting_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative">
                                    <input type="url" name="start_url"
                                        class="form-control custom-input float-input @error('start_url') custom-input-error @enderror"
                                        placeholder=" " value="{{ old('start_url') }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.start_url_host') }}</label>
                                </div>
                                @error('start_url')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-float position-relative">
                                    <input type="url" name="join_url"
                                        class="form-control custom-input float-input @error('join_url') custom-input-error @enderror"
                                        placeholder=" " value="{{ old('join_url') }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.Login_link_for_students') }}</label>
                                </div>
                                @error('join_url')
                                    <div class="error-message">
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
