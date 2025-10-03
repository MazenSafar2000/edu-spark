<!-- الاسم بالعربي والانجليزي -->
<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="text" name="name_ar"
                class="form-control custom-input float-input @error('name_ar') custom-input-error @enderror"
                id="studentNameAr" placeholder=" "
                value="{{ old('name_ar', $Student->user?->getTranslation('name', 'ar')) }}" />
            <label for="studentNameAr" class="float-label">{{ trans('main_trans.name_ar') }}</label>
        </div>
        @error('name_ar')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror

    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="text" name="name_en"
                class="form-control custom-input float-input @error('name_en') custom-input-error @enderror"
                id="studentNameEn" placeholder=" "
                value="{{ old('name_en', $Student->user?->getTranslation('name', 'en')) }}" />
            <label for="studentNameEn" class="float-label">{{ trans('main_trans.name_en') }}</label>
        </div>
        @error('name_en')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<!-- الهوية وكلمة المرور -->
<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="number" name="National_ID"
                class="form-control custom-input float-input @error('National_ID') custom-input-error @enderror"
                id="studentID" autocomplete="off" placeholder=" "
                value="{{ old('National_ID', $Student->user->National_ID ?? '') }}" />
            <label for="studentID" class="float-label">{{ trans('main_trans.National_ID') }}</label>
        </div>
        @error('National_ID')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="password" name="password"
                class="form-control custom-input float-input @error('password') custom-input-error @enderror"
                id="studentPass" autocomplete="new-password" placeholder=" " />
            <label for="studentPass" class="float-label">{{ trans('main_trans.Password') }}</label>
        </div>
        @error('password')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="form-group-float position-relative ">
            <input type="email" name="email"
                class="form-control custom-input float-input @error('email') custom-input-error @enderror"
                id="subjectEmail" placeholder="" value="{{ old('email', $Student->user->email ?? '') }}"
                placeholder=" " />
            <label for="email" class="float-label">{{ trans('Students_trans.email') }}</label>
        </div>
        @error('email')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="" class="text-danger">{{ trans('main_trans.Date_of_Birth') }}</label>
        <input type="date" name="Date_Birth"
            class="form-control custom-input @error('Date_Birth') custom-input-error @enderror" id="subjectAr"
            placeholder="" value="{{ old('Date_Birth', $Student->Date_Birth) }}" />
        @error('Date_Birth')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="" class="text-danger">{{ trans('Teacher_trans.Gender') }}</label>
        <select class="form-select custom-select @error('gender_id') custom-select-error @enderror" name="gender_id">
            <option selected disabled>{{ trans('main_trans.Choose') }}</option>
            @foreach ($Genders as $Gender)
                <option value="{{ $Gender->id }}"
                    {{ old('gender_id', $Student->gender_id ?? '') == $Gender->id ? 'selected' : '' }}>
                    {{ $Gender->Name }}
                </option>
            @endforeach
        </select>
        @error('gender_id')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="" class="text-danger">{{ trans('Students_trans.parent') }}</label>
        <select class="form-select custom-select @error('parent_id') custom-select-error @enderror" name="parent_id">
            <option selected disabled>{{ trans('main_trans.Choose') }}</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}"
                    {{ old('parent_id', $Student->parent_id) == $parent->id ? 'selected' : '' }}>
                    {{ $parent->user->name }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="" class="text-danger">{{ trans('Students_trans.academic_year') }}*</label>
        <select class="form-select custom-select @error('academic_year') custom-select-error @enderror"
            name="academic_year" id="academic_year">
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
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <label for="" class="text-danger">{{ trans('main_trans.Grade') }}*</label>
        <select class="form-select custom-select @error('Grade_id') custom-select-error @enderror" name="Grade_id"
            id="Grade_id" data-selected-grade="{{ old('Grade_id', $Student->Grade_id ?? '') }}">
            <option selected disabled>{{ trans('main_trans.select_grade') }}</option>
            @foreach ($my_classes as $c)
                <option value="{{ $c->id }}"
                    {{ old('Grade_id', $Student->Grade_id ?? '') == $c->id ? 'selected' : '' }}>
                    {{ $c->Name }}
                </option>
            @endforeach
        </select>
        @error('Grade_id')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="" class="text-danger">{{ trans('main_trans.classroom') }}*</label>
        <select class="form-select custom-select @error('Classroom_id') custom-select-error @enderror"
            id="Classroom_id" name="Classroom_id"
            data-selected-classroom="{{ old('Classroom_id', $Student->Classroom_id ?? '') }}">
            <option selected disabled>{{ trans('main_trans.select_class') }}</option>
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
            name="section_id" id="section_id"
            data-selected-section="{{ old('section_id', $Student->section_id ?? '') }}">
            <option selected disabled>{{ trans('main_trans.select_section') }}</option>
        </select>
        @error('section_id')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

@if ($formMode === 'create')
    <div class="row mb-3">
        <div class="col-md-12">
            <label for="" class="text-danger">{{ trans('Students_trans.Attachments') }}</label>
            <input type="file" accept="image/*" name="photos[]" multiple
                class="form-control custom-input @error('photos[]') custom-input-error @enderror" id="photos">
            @error('photos[]')
                <div class="error-message" id="error-bookNameArabic">
                    <i class="fas fa-exclamation-triangle"></i>{{ $message }}
                </div>
            @enderror
        </div>
    </div>
@endif

<div class="text-end">
    <button type="submit" class="btn save-btn">{{ trans('Students_trans.submit') }}</button>
</div>
