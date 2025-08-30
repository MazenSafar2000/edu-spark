@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.Add_new_recordedClass') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    <form class="subject-form" action="{{ route('recordedClasses.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title"
                                        class="form-control custom-input float-input @error('title') custom-input-error @enderror"
                                        id="" placeholder=" " value="{{ old('title') }}" />
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
                                        id="" placeholder="">{{ old('description') }}</textarea>
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
                                        <option value="{{ $grade->id }}">{{ $grade->Name }}</option>
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
                                    <option selected disabled>{{ trans('Teacher_trans.select_class') }}</option>
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
                            <div class="col-md-12">
                                <label for="" class="text-danger">{{ trans('Students_trans.subjects') }}*</label>
                                <select class="form-select custom-select @error('subject_id') custom-select-error @enderror"
                                    name="subject_id" id="subject-select">
                                    <option selected disabled>{{ trans('Teacher_trans.select_subject') }}</option>
                                </select>
                            </div>
                            @error('subject_id')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="url" name="video_url" class="form-control custom-input float-input @error('video_url') custom-input-error @enderror"
                                    placeholder=" " value="{{ old('video_url')}}" />
                                    <label for="video_url" class="float-label">{{ trans('Teacher_trans.Class_link') }}</label>
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

    {{-- save old value when validate --}}
    <script>
        $(document).ready(function() {
            let oldGrade = "{{ old('grade_id') }}";
            let oldClassroom = "{{ old('classroom_id') }}";
            let oldSection = "{{ old('section_id') }}";
            let oldSubject = "{{ old('subject_id') }}";

            if (oldGrade) {
                $('#grade-select').val(oldGrade).trigger('change');

                // بعد ما تنزل الكلاسات
                $.get('/teacher/getClassroomsByGrade/' + oldGrade, function(data) {
                    $('#classroom-select').empty().append('<option disabled>{{ trans('main_trans.select_class') }}</option>');
                    data.forEach(function(classroom) {
                        let selected = classroom.id == oldClassroom ? 'selected' : '';
                        $('#classroom-select').append(
                            `<option value="${classroom.id}" ${selected}>${classroom.name}</option>`
                        );
                    });

                    if (oldClassroom) {
                        // بعد ما تنزل الأقسام
                        $.get('/teacher/getSectionsByClassroom/' + oldClassroom, function(data) {
                            $('#section-select').empty().append(
                                '<option disabled>{{ trans('main_trans.select_section') }}</option>');
                            data.forEach(function(section) {
                                let selected = section.id == oldSection ? 'selected' : '';
                                $('#section-select').append(
                                    `<option value="${section.id}" ${selected}>${section.name}</option>`
                                );
                            });

                            if (oldSection) {
                                // بعد ما تنزل المواد
                                $.get('/teacher/getSubjectsBySection/' + oldSection, function(
                                    data) {
                                    $('#subject-select').empty().append(
                                        '<option disabled>{{ trans('main_trans.select_subject') }}</option>');
                                    data.forEach(function(subject) {
                                        let selected = subject.id == oldSubject ?
                                            'selected' : '';
                                        $('#subject-select').append(
                                            `<option value="${subject.id}" ${selected}>${subject.name}</option>`
                                        );
                                    });
                                });
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
