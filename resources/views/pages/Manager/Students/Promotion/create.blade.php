@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header-form">{{ trans('main_trans.Students_Promotions') }}</h3>
        <div class="title-underline"></div>

        <div class="container my-4">
            <div class="card custom-form-card">
                @if (Session::has('error_promotions'))
                    <div class="alert alert-danger">
                        <ul>
                            <li><strong>{{ Session::get('error_promotions') }}</strong></li>
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <form class="subject-form" method="post" action="{{ route('Promotion.store') }}">
                        @csrf
                        <!-- Old School Stage -->
                        <div class="form-section mb-4">
                            <h6 class="section-heading text-danger mb-3"> {{ trans('main_trans.Old_school_stage') }}</h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="Grade_id" class="text-danger">{{ trans('Students_trans.Grade') }}*</label>
                                    <select class="form-select custom-select @error('Grade_id') is-invalid @enderror"
                                        name="Grade_id" id="Grade_id" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                        @foreach ($Grades as $Grade)
                                            <option value="{{ $Grade->id }}">{{ $Grade->Name }}</option>
                                        @endforeach
                                    </select>
                                    @error('Grade_id')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="Classroom_id"
                                        class="text-danger">{{ trans('Students_trans.classrooms') }}*</label>
                                    <select class="form-select custom-select @error('Classroom_id') is-invalid @enderror"
                                        name="Classroom_id" id="Classroom_id" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    </select>
                                    @error('Classroom_id')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="section_id"
                                        class="text-danger">{{ trans('Students_trans.section') }}*</label>
                                    <select class="form-select custom-select  @error('section_id') is-invalid @enderror"
                                        name="section_id" id="section_id" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    </select>
                                    @error('section_id')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="academic_year"
                                        class="text-danger">{{ trans('Students_trans.academic_year') }}*</label>
                                    <select class="form-select custom-select @error('academic_year') is-invalid @enderror"
                                        name="academic_year" id="academic_year" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                        @php $current_year = date('Y'); @endphp
                                        @for ($year = $current_year; $year <= $current_year + 1; $year++)
                                            @php $academicYear = $year . '/' . ($year + 1); @endphp
                                            <option value="{{ $academicYear }}"
                                                {{ old('academic_year') == $academicYear ? 'selected' : '' }}>
                                                {{ $academicYear }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('academic_year')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- New Academic Stage -->
                        <div class="form-section mb-4">
                            <h6 class="section-heading text-danger mb-3">{{ trans('main_trans.New_academic_stage') }}</h6>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="Grade_id_new"
                                        class="text-danger">{{ trans('Students_trans.Grade') }}*</label>
                                    <select class="form-select custom-select @error('Grade_id_new') is-invalid @enderror"
                                        name="Grade_id_new" id="Grade_id_new" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                        @foreach ($Grades as $Grade)
                                            <option value="{{ $Grade->id }}">{{ $Grade->Name }}</option>
                                        @endforeach
                                    </select>
                                    @error('Grade_id_new')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="Classroom_id_new"
                                        class="text-danger">{{ trans('Students_trans.classrooms') }}*</label>
                                    <select
                                        class="form-select custom-select @error('Classroom_id_new') is-invalid @enderror"
                                        name="Classroom_id_new" id="Classroom_id_new" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    </select>
                                    @error('Classroom_id_new')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="section_id_new"
                                        class="text-danger">{{ trans('Students_trans.section') }}*</label>
                                    <select class="form-select custom-select @error('section_id_new') is-invalid @enderror"
                                        name="section_id_new" id="section_id_new" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                    </select>
                                    @error('section_id_new')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="academic_year_new"
                                        class="text-danger">{{ trans('Students_trans.academic_year') }}*</label>
                                    <select
                                        class="form-select custom-select @error('academic_year_new') is-invalid @enderror"
                                        name="academic_year_new" id="academic_year_new" required>
                                        <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                        @php $current_year = date('Y'); @endphp
                                        @for ($year = $current_year; $year <= $current_year + 1; $year++)
                                            @php $academicYear = $year . '/' . ($year + 1); @endphp
                                            <option value="{{ $academicYear }}"
                                                {{ old('academic_year_new') == $academicYear ? 'selected' : '' }}>
                                                {{ $academicYear }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('academic_year_new')
                                        <div class="error-message" id="error-bookNameArabic">
                                            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn save-btn">{{ trans('Students_trans.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- filter classes & section --}}
    <script>
        $(function() {
            // ===== Old Academic Stage =====
            $('select[name="Grade_id"]').on('change', function() {
                let gradeId = $(this).val();
                let $classroom = $('select[name="Classroom_id"]');
                let $section = $('select[name="section_id"]');

                $classroom.empty().append(
                    '<option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>');
                $section.empty().append(
                    '<option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>');

                if (gradeId) {
                    $.get("{{ url('/ajax/classrooms') }}/" + gradeId, function(data) {
                        $.each(data, function(id, name) {
                            $classroom.append(`<option value="${id}">${name}</option>`);
                        });
                    }).fail(function(xhr) {
                        console.error('Error loading classrooms', xhr.responseText);
                    });
                }
            });

            $('select[name="Classroom_id"]').on('change', function() {
                let classId = $(this).val();
                let $section = $('select[name="section_id"]');

                $section.empty().append(
                    '<option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>');

                if (classId) {
                    $.get("{{ url('/ajax/sections') }}/" + classId, function(data) {
                        $.each(data, function(id, name) {
                            $section.append(`<option value="${id}">${name}</option>`);
                        });
                    }).fail(function(xhr) {
                        console.error('Error loading sections', xhr.responseText);
                    });
                }
            });

            // ===== New Academic Stage =====
            $('select[name="Grade_id_new"]').on('change', function() {
                let gradeId = $(this).val();
                let $classroom = $('select[name="Classroom_id_new"]');
                let $section = $('select[name="section_id_new"]');

                $classroom.empty().append(
                    '<option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>');
                $section.empty().append(
                    '<option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>');

                if (gradeId) {
                    $.get("{{ url('/ajax/classrooms') }}/" + gradeId, function(data) {
                        $.each(data, function(id, name) {
                            $classroom.append(`<option value="${id}">${name}</option>`);
                        });
                    }).fail(function(xhr) {
                        console.error('Error loading classrooms', xhr.responseText);
                    });
                }
            });

            $('select[name="Classroom_id_new"]').on('change', function() {
                let classId = $(this).val();
                let $section = $('select[name="section_id_new"]');

                $section.empty().append(
                    '<option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>');

                if (classId) {
                    $.get("{{ url('/ajax/sections') }}/" + classId, function(data) {
                        $.each(data, function(id, name) {
                            $section.append(`<option value="${id}">${name}</option>`);
                        });
                    }).fail(function(xhr) {
                        console.error('Error loading sections', xhr.responseText);
                    });
                }
            });
        });
    </script>
@endsection
