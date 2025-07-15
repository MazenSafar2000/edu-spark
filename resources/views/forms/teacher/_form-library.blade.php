<div class="row mb-3">
    <div class="col-md-12">
        <div class="form-group-float position-relative ">
            <input type="text" name="title" id="title_id" class="form-control custom-input float-input"
                value="{{ old('title', $isEdit ? $book->title : '') }}" />
            <label for="title_id" class="float-label">{{ trans('Teacher_trans.book_name') }}*</label>
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
                    {{ old('grade_id', $isEdit ? $book->Grade_id : '') == $grade->id ? 'selected' : '' }}>
                    {{ $grade->Name }}
                </option>
            @endforeach
        </select>
        @error('grade_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="" class="text-danger">{{ trans('main_trans.classroom') }}*</label>
        <select class="form-select custom-select" name="classroom_id" id="classroom-select">
            <option disabled>{{ trans('Teacher_trans.select_class') }}</option>
            @if (old('classroom_id') || isset($book))
                <option value="{{ old('classroom_id', $book->classroom_id ?? '') }}">
                    {{ old('classroom_name', $book->classroom->Name_Class ?? '') }}
                </option>
            @endif
        </select>
        @error('classroom_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="" class="text-danger">{{ trans('main_trans.section') }}*</label>
        <select class="form-select custom-select" name="section_id" id="section-select">
            <option disabled selected>{{ trans('Teacher_trans.select_section') }}</option>
        </select>
        @error('section_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="">
    <div class="">
        <div class="form-group">
            <label for="subject_id">{{ trans('Students_trans.subjects') }} : <span class="text-danger">*</span></label>
            <select class="custom-select mr-sm-2" name="subject_id" id="subject-select">
                <option disabled selected>{{ trans('Teacher_trans.select_subject') }}</option>
                {{-- @foreach ($Subjects as $subject)
                    <option value="{{ $subject->id }}"
                        {{ old('subject_id', $library->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach --}}
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
        <input type="file" accept="application/pdf" name="file_name" class="form-control custom-input"
            id="file_name">
        @error('file_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
