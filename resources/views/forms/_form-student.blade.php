{{-- <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header-form">{{ trans('main_trans.add_student') }}</h3>

<div class="container mt-4">
    <div class="card custom-form-card">
        <div class="card-body">
            @include('components.error-field')
            <form class="subject-form" method="post" action="{{ route('Students.store') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf

                @include('forms._form-student', ['formMode' => 'create'])

            </form>
        </div>
    </div>

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
                <label for="studentPass" class="float-label"></label>
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
                     name="gender_id">
                    <option selected disabled>{{ trans('Parent_trans.Choose') }}</option>
                    @foreach ($Genders as $Gender)
                    <option value="{{ $Gender->id }}"
                        {{ old('gender_id', $Student->gender_id ?? '') == $Gender->id ? 'selected' : '' }}>
                        {{ $Gender->Name }}
                    </option>
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
                    $academicYear=$year . '/' . ($year + 1);
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
</div>

</div> --}}

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
                value="{{ old('National_ID', $Student->National_ID ?? '') }}" />
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
            <option selected disabled>{{ trans('Parent_trans.Choose') }}</option>
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
            <option selected disabled>{{ trans('Parent_trans.Choose') }}</option>
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
