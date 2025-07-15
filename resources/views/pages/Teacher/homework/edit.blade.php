@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">

        <h3 class="teacher-header-form">{{ trans('Teacher_trans.Edit_homework') }}</h3>

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
                    <form class="subject-form" action="{{ route('homeworks.update', $homework->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="form-group-float position-relative ">
                                <input type="text" name="title" class="form-control custom-input float-input"
                                    id="title" value="{{ old('title', $homework->title) }}" />
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <label for="title"
                                    class="float-label">{{ trans('Teacher_trans.homework_title') }}*</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.homework_description') }}*</label>
                                <textarea name="description" id="" class="form-control custom-textarea fs-5 p-3" rows="3"
                                    placeholder="{{ trans('Teacher_trans.homework_description') }}*">{{ old('description', $homework->description) }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.grade') }}*</label>
                                <select name="grade_id" id="grade-select" class="form-select custom-select">
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}"
                                            {{ $grade->id == $homework->grade_id ? 'selected' : '' }}>
                                            {{ $grade->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.classroom') }}*</label>
                                <select name="classroom_id" id="classroom-select" class="form-select custom-select">
                                    <option value="{{ $homework->classroom_id }}">
                                        {{ $homework->classroom->Name_Class }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.section') }}*</label>
                                <select name="section_id" id="section-select" class="form-select custom-select">
                                    <option value="{{ $homework->section_id }}">
                                        {{ $homework->section->Name_Section }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="" class="text-danger">{{ trans('Teacher_trans.subject') }}*</label>
                                <select name="subject_id" id="subject-select" class="form-select custom-select">
                                    <option value="{{ $homework->subject_id }}">
                                        {{ $homework->subject->name }}
                                    </option>
                                </select>
                                @error('subject_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.total_degree') }}*</label>
                                <input type="number" name="total_degree" class="form-control custom-input" min="1"
                                    value="{{ old('total_degree', $homework->total_degree) }}">
                                @error('total_degree')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <label for="hobbies" class="text-danger">{{ trans('Teacher_trans.allowed_file_types') }}*
                            :</label><br>
                        <select name="allowed_file_types[]" class="form-control" multiple required>
                            @php
                                $selectedTypes = old('allowed_file_types', $homework->allowed_file_types ?? []);
                            @endphp
                            @foreach (['pdf', 'doc', 'docx', 'jpg', 'png', 'rar', 'zip'] as $type)
                                <option value="{{ $type }}"
                                    {{ in_array($type, $selectedTypes) ? 'selected' : '' }}>
                                    {{ strtoupper($type) }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">{{ trans('Teacher_trans.hold_ctrl') }}</small>
                        @error('allowed_file_types')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <br>

                        <label for="hobbies"
                            class="text-danger fw-bold fs-5 text-decoration-underline mt-4">{{ trans('Teacher_trans.allow_multiple_submissions') }}:</label><br>
                        <div class="checkbox-allow mt-3">
                            <div>
                                <input type="checkbox" id="allow_multiple_submissions"
                                    name="allow_multiple_submissions"class="ms-2"
                                    {{ old('allow_multiple_submissions', $homework->allow_multiple_submissions) ? 'checked' : '' }}>
                                <label for="" class="fs-5 ">{{ trans('Teacher_trans.yes_allow') }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.homework_due_date') }}*</label>
                                <input type="datetime-local" name="due_date" class="form-control custom-input"
                                    value="{{ old('due_date', \Carbon\Carbon::parse($homework->due_date)->format('Y-m-d\TH:i')) }}"
                                    placeholder="{{ trans('Teacher_trans.homework_due_date') }}">
                                @error('due_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for=""
                                    class="text-danger">{{ trans('Teacher_trans.homework_attachment') }}({{ trans('Teacher_trans.optional') }})</label>
                                <input type="file" name="attachment" class="form-control custom-input"
                                    accept=".pdf,.doc,.docx,.jpg,.png,.rar,.zip">
                                @if (isset($homework) && $homework->attachment_path)
                                    <div class="mt-2">
                                        <a href="{{ Storage::url('attachments/homeworks/teachers/'. Auth::user()->teacher->National_ID .'/'.$homework->attachment_path) }}" target="_blank">
                                            {{ trans('Teacher_trans.view_current_attachment') }}
                                        </a>
                                        <label class="ml-3">
                                            <input type="checkbox" name="remove_attachment">
                                            {{ trans('Teacher_trans.remove_attachment') }}
                                        </label>
                                    </div>
                                @endif
                                @error('attachment')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="text-end">
                            <button type="submit"
                                class="btn save-btn">{{ trans('Teacher_trans.Create_Homework') }}</button>
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
