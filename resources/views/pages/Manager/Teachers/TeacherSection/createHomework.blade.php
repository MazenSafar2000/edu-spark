@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.add_new_homework') }}</h3>
        <div class="title-underline"></div>

        <div class="container mt-4">
            <div class="card custom-form-card-teacher">
                <div class="card-body">
                    @include('components.error-field')
                    <form class="subject-form"action="{{ route('homeworks.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="section_id" value="{{ $teacher_section->section_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $teacher_section->section->My_classs->id }}">
                        <input type="hidden" name="grade_id"
                            value="{{ $teacher_section->section->My_classs->Grades->id }}">
                        <input type="hidden" name="subject_id" value="{{ $teacher_section->subject_id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group-float position-relative ">
                                    <input type="text" name="title"
                                        class="form-control custom-input float-input @error('title') custom-input-error @enderror"
                                        id="title" placeholder=" " value="{{ old('title') }}" />
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
                                        id="" placeholder=" " value="{{ old('total_degree') }}" />
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
                                    placeholder="{{ trans('Teacher_trans.homework_description') }}">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <div class="error-message" id="error-bookNameArabic">
                                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">



                        </div>



                        <label for="hobbies"
                            class="text-danger">{{ trans('Teacher_trans.allowed_file_types') }}*</label><br>

                        <div class="checkbox-file mt-4">
                            <div>
                                <input type="checkbox" id="filetype_pdf" name="allowed_file_types[]" value="pdf"
                                    class="ms-2">
                                <label for="filetype_pdf">PDF</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_doc" name="allowed_file_types[]" value="doc"
                                    class="ms-2">
                                <label for="filetype_doc">Word (DOC)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_docx" name="allowed_file_types[]" value="docx"
                                    class="ms-2">
                                <label for="filetype_docx">Word (DOCX)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_jpg" name="allowed_file_types[]" value="jpg"
                                    class="ms-2">
                                <label for="filetype_jpg">Image (JPG)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_png" name="allowed_file_types[]" value="png"
                                    class="ms-2">
                                <label for="filetype_png">Image (PNG)</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_rar" name="allowed_file_types[]" value="rar"
                                    class="ms-2">
                                <label for="filetype_rar">RAR File</label>
                            </div>

                            <div>
                                <input type="checkbox" id="filetype_zip" name="allowed_file_types[]" value="zip"
                                    class="ms-2">
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
                                    value="" class="ms-2">
                                <label for="" class="fs-5 ">{{ trans('Teacher_trans.yes_allow') }}</label>
                            </div>
                        </div>
                        <br>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.homework_attachment') }}({{ trans('Teacher_trans.optional') }})</label>
                                <input type="file" name="attachment" class="form-control custom-input"
                                    accept=".pdf,.doc,.docx,.jpg,.png,.rar,.zip" placeholder="علامة الواجب">
                                @if (isset($homework) && $homework->attachment_path)
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($homework->attachment_path) }}" target="_blank">
                                            {{ trans('Teacher_trans.view_current_attachment') }}
                                        </a>
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
                            <div class="col-md-6">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.homework_due_date') }}*</label>
                                <input type="datetime-local" name="due_date"
                                    class="form-control custom-input @error('due_date') custom-input-error @enderror"
                                    value="{{ old('due_date') }}">
                                @error('due_date')
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
