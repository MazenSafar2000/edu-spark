@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.Edit_homework') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    <form class="subject-form" action="{{ route('Homework.update', $homework->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title"
                                        class="form-control custom-input float-input @error('title') custom-input-error @enderror"
                                        id="title" placeholder=" " value="{{ old('title', $homework->title) }}" />
                                    <label for=""
                                        class="float-label">{{ trans('Teacher_trans.homework_title') }}*</label>
                                </div>
                                @error('title')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="number" name="total_degree" min="1"
                                        class="form-control custom-input float-input @error('total_degree') custom-input-error @enderror"
                                        id="" placeholder=" "
                                        value="{{ old('total_degree', $homework->total_degree) }}" />
                                    <label for="total_degree"
                                        class="float-label">{{ trans('Teacher_trans.total_degree') }}*</label>
                                </div>
                                @error('total_degree')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.homework_description') }}
                                    <small>(optional)</small></label>
                                <textarea name="description"
                                    class="form-control custom-textarea fs-5 p-3 @error('description') custom-textarea-error @enderror" rows="3"
                                    placeholder="{{ trans('Teacher_trans.homework_description') }}">{{ old('description', $homework->description) }}</textarea>
                            </div>
                            @error('description')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.grade') }}*</label>
                                <select class="form-select custom-select @error('title') custom-select-error @enderror"
                                    name="grade_id" id="grade-select">
                                    <option disabled>{{ trans('Teacher_trans.select_grade') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            {{ $grade->id == $homework->grade_id ? 'selected' : '' }}>
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
                                <label for="" class="text-danger">{{ trans('Teacher_trans.classroom') }}*</label>
                                <select
                                    class="form-select custom-select @error('classroom_id') custom-select-error @enderror"
                                    name="classroom_id" id="classroom-select">
                                    <option value="{{ $homework->classroom_id }}">
                                        {{ $homework->classroom->Name_Class }}</option>
                                </select>
                                @error('classroom_id')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.section') }}*</label>
                                <select class="form-select custom-select @error('section_id') custom-select-error @enderror"
                                    name="section_id" id="section-select">
                                    <option value="{{ $homework->section_id }}">
                                        {{ $homework->section->Name_Section }}</option>
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
                                    <option value="{{ $homework->subject_id }}">
                                        {{ $homework->subject->name }}
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
                                    <option value="{{ $homework->teacher_id }}">
                                        {{ $homework->teacher->user->name }}
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
                            <div class="col-md-6">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.homework_due_date') }}*</label>
                                <input type="datetime-local" name="due_date"
                                    class="form-control custom-input @error('due_date') custom-input-error @enderror"
                                    value="{{ old('due_date', \Carbon\Carbon::parse($homework->due_date)->format('Y-m-d\TH:i')) }}">
                                @error('due_date')
                                    <div class="error-message" id="error-bookNameArabic">
                                        <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>



                        <label for="hobbies"
                            class="text-danger">{{ trans('Teacher_trans.allowed_file_types') }}*</label><br>

                        <?php
                        $selectedFileTypes = ['pdf', 'docx', 'zip']; // Example data
                        ?>

                        <div class="checkbox-file mt-4">
                            <div>
                                <input type="checkbox" id="filetype_pdf" name="allowed_file_types[]" value="pdf"
                                    class="ms-2" <?php if (in_array('pdf', $selectedFileTypes)) {
                                        echo 'checked';
                                    } ?>>
                                <label for="filetype_pdf">PDF</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_doc" name="allowed_file_types[]" value="doc"
                                    class="ms-2" <?php if (in_array('doc', $selectedFileTypes)) {
                                        echo 'checked';
                                    } ?>>
                                <label for="filetype_doc">Word (DOC)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_docx" name="allowed_file_types[]" value="docx"
                                    class="ms-2" <?php if (in_array('docx', $selectedFileTypes)) {
                                        echo 'checked';
                                    } ?>>
                                <label for="filetype_docx">Word (DOCX)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_jpg" name="allowed_file_types[]" value="jpg"
                                    class="ms-2" <?php if (in_array('jpg', $selectedFileTypes)) {
                                        echo 'checked';
                                    } ?>>
                                <label for="filetype_jpg">Image (JPG)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_png" name="allowed_file_types[]" value="png"
                                    class="ms-2" <?php if (in_array('png', $selectedFileTypes)) {
                                        echo 'checked';
                                    } ?>>
                                <label for="filetype_png">Image (PNG)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_rar" name="allowed_file_types[]" value="rar"
                                    class="ms-2" <?php if (in_array('rar', $selectedFileTypes)) {
                                        echo 'checked';
                                    } ?>>
                                <label for="filetype_rar">RAR File</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_zip" name="allowed_file_types[]" value="zip"
                                    class="ms-2" <?php if (in_array('zip', $selectedFileTypes)) {
                                        echo 'checked';
                                    } ?>>
                                <label for="filetype_zip">ZIP File</label>
                            </div>
                        </div>
                        @error('allowed_file_types')
                            <div class="error-message" id="error-bookNameArabic">
                                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                            </div>
                        @enderror

                        <label for="hobbies"
                            class="text-danger fw-bold fs-5 text-decoration-underline mt-4">{{ trans('Teacher_trans.allow_multiple_submissions') }}:</label><br>

                        <div class="checkbox-allow mt-3">
                            <div>
                                <input type="checkbox" id="allow_multiple_submissions" name="allow_multiple_submissions"
                                    class="ms-2"
                                    {{ old('allow_multiple_submissions', $homework->allow_multiple_submissions) ? 'checked' : '' }}>
                                <label for="" class="fs-5 ">{{ trans('Teacher_trans.yes_allow') }}</label>
                            </div>
                        </div>
                        <br>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.homework_attachment') }}({{ trans('Teacher_trans.optional') }})</label>
                                <input type="file" name="attachment" class="form-control custom-input"
                                    accept=".pdf,.doc,.docx,.jpg,.png,.rar,.zip">
                                @if (isset($homework) && $homework->attachment_path)
                                    <div class="mt-2 h5">
                                        <a href="{{ Storage::url('attachments/homeworks/teachers/' . Auth::user()->National_ID . '/' . $homework->attachment_path) }}"
                                            target="_blank">
                                            {{ trans('Teacher_trans.view_current_attachment') }}
                                        </a><br>
                                        <label class="ml-3">
                                            <input type="checkbox" name="remove_attachment">
                                            {{ trans('Teacher_trans.remove_attachment') }}
                                        </label>
                                    </div>
                                @endif
                                @error('attachment')
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
