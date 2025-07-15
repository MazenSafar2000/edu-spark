@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <!-- المحتوى الرئيسي -->
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container mt-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    <form class="subject-form" action="{{ route('library.update', $book->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title" id="title_id"
                                        class="form-control custom-input float-input"
                                        value="{{ old('title', $book->title) }}" />
                                    <label for="title_id"
                                        class="float-label">{{ trans('Teacher_trans.book_name') }}*</label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.Grade') }}*</label>
                                <select class="form-select custom-select" name="grade_id" id="grade-select">
                                    <option selected disabled>{{ trans('Sections_trans.Select_Grade') }}</option>
                                    @foreach ($Grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            {{ $book->Grade_id == $grade->id ? 'selected' : '' }}>
                                            {{ $grade->Name }}</option>
                                    @endforeach
                                </select>
                                @error('grade_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.classroom') }}*</label>
                                <select class="form-select custom-select" name="classroom_id" id="classroom-select">
                                    <option value="{{ $book->Classroom_id }}">
                                        {{ $book->classroom->Name_Class }}</option>
                                </select>
                                @error('classroom_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('main_trans.section') }}*</label>
                                <select class="form-select custom-select" name="section_id" id="section-select">
                                    <option value="{{ $book->section_id }}">
                                        {{ $book->section->Name_Section }}</option>
                                </select>
                                @error('section_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <div class="">
                                <div class="form-group">
                                    <label for="subject_id">{{ trans('Students_trans.subjects') }} : <span
                                            class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-2" name="subject_id" id="subject-select">
                                        <option value="{{ $book->subject_id }}">
                                            {{ $book->subject->name }}</option>
                                    </select>
                                    @error('subject_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="" class="text-danger">{{ trans('Parent_trans.Attachments') }} *</label>
                                <input type="file" accept="application/pdf" name="file_name"
                                    class="form-control custom-input" id="file_name">
                                @error('file_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
