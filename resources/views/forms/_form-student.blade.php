<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="text" name="name_ar"
                class="form-control custom-input float-input @error('name_ar') is-invalid @enderror" id="studentNameAr"
                placeholder=" "
                @if ($Student->user) value="{{ old('name_ar', $Student->user->getTranslation('name', 'ar')) }}" @endif />
            @error('name_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="studentNameAr" class="float-label">{{ trans('main_trans.name_ar') }}</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="text" name="name_en"
                class="form-control custom-input float-input @error('name_en') is-invalid @enderror" id="studentNameEn"
                placeholder=" "
                @if ($Student->user) value="{{ old('name_en', $Student->user->getTranslation('name', 'en')) }}" @endif />
            @error('name_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="studentNameEn" class="float-label">{{ trans('main_trans.name_en') }}</label>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" name="National_ID"
            class="form-control custom-input @error('National_ID') is-invalid @enderror" id="National_ID"
            placeholder="{{ trans('Teacher_trans.National_ID') }}"
            value="{{ old('National_ID', $Teacher->National_ID ?? '') }}">
        @error('National_ID')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="password" name="password"
                class="form-control custom-input float-input @error('password') is-invalid @enderror" id="studentPass"
                placeholder=" " />
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="studentPass" class="float-label">{{ trans('Students_trans.password') }}</label>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="date"
                class="form-control custom-input float-input @error('Date_Birth') is-invalid @enderror" id="Date_Birth"
                name="Date_Birth" placeholder="" value="{{ old('Date_Birth', $Student->Date_Birth) }}"
                data-date-format="yyyy-mm-dd">
            <label for="Date_Birth" class="float-label">{{ trans('main_trans.Date_of_Birth') }}</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <select class="form-select custom-select float-input @error('gender_id') is-invalid @enderror"
                id="grade" name="gender_id">
                <option selected disabled>{{ trans('Parent_trans.Choose') }}</option>
                @foreach ($Genders as $Gender)
                    <option value="{{ $Gender->id }}"
                        {{ old('gender_id', $Student->gender_id ?? '') == $Gender->id ? 'selected' : '' }}>
                        {{ $Gender->Name }}</option>
                @endforeach
            </select>
            <label for="gender_id" class="float-label">{{ trans('Teacher_trans.Gender') }}</label>
        </div>
        @error('gender_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <select class="form-select custom-select" id="parent_id" name="parent_id">
            <option selected disabled>{{ trans('Students_trans.parent') }}</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}"
                    {{ old('parent_id', $Student->parent_id) == $parent->id ? 'selected' : '' }}>
                    {{ $parent->user->name }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <select class="form-select custom-select @error('academic_year') is-invalid @enderror" name="academic_year"
            id="academic_year">
            <option selected disabled>{{ trans('Students_trans.academic_year') }}</option>
            @php $current_year = date('Y'); @endphp
            @for ($year = $current_year; $year <= $current_year + 1; $year++)
                @php
                    $academicYear = $year . '/' . ($year + 1);
                @endphp
                <option value="{{ $academicYear }}"
                    {{ old('academic_year', $Student->academic_year) == $academicYear ? 'selected' : '' }}>
                    {{ $academicYear }}
                </option>
            @endfor
        </select>
        @error('academic_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="form-group-float position-relative ">
        <input type="email" name="email"
            class="form-control custom-input float-input @error('email') is-invalid @enderror" id="studentID"
            placeholder=" " value="{{ old('email', $Student->user->email ?? '') }}" />
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <label for="studentID" class="float-label">{{ trans('Students_trans.email') }}</label>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <select class="form-select custom-select @error('Grade_id') is-invalid @enderror" id="Grade_id"
            name="Grade_id">
            <option selected disabled>{{ trans('Students_trans.Grade') }}</option>
            @foreach ($my_classes as $c)
                <option value="{{ $c->id }}"
                    {{ old('Grade_id', $Student->Grade_id) == $c->id ? 'selected' : '' }}>{{ $c->Name }}</option>
            @endforeach
        </select>
        @error('Grade_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <select class="form-select custom-select @error('Classroom_id') is-invalid @enderror" name="Classroom_id"
            id="Classroom_id">
            <option selected disabled>{{ trans('Students_trans.classrooms') }}</option>
            @if ($Student->user)
                <option value="{{ $Student->Classroom_id }}" selected>
                    {{ $Student->classroom->Name_Class }}
                </option>
            @endif
        </select>
        @error('Classroom_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <select class="form-select custom-select @error('section_id') is-invalid @enderror" name="section_id"
            id="section_id">
            <option selected disabled>{{ trans('Students_trans.section') }}</option>
            @if ($Student->user)
                <option value="{{ $Student->section_id }}" selected>
                    {{ $Student->section->Name_Section }}
                </option>
            @endif
        </select>
        @error('section_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@if ($formMode === 'create')
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="photos">{{ trans('Students_trans.Attachments') }}</label>
            <input type="file" accept="image/*" name="photos[]" multiple
                class="form-control custom-input @error('photos') is-invalid @enderror" id="photos">
            @error('photos')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endif

<div class="text-end">
    <button type="submit" class="btn save-btn">{{ trans('Students_trans.submit') }}</button>
</div>
