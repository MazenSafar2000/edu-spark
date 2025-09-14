<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="text" name="Name_ar"
                class="form-control custom-input float-input @error('Name_ar') custom-input-error @enderror"
                id="Name_ar" placeholder=" "
                value="{{ old('Name_ar', $Teacher->user?->getTranslation('name', 'ar')) }}" />
            <label for="teacherNameAr" class="float-label">{{ trans('Teacher_trans.Name_ar') }}</label>
        </div>
        @error('Name_ar')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="text" name="Name_en"
                class="form-control custom-input float-input @error('Name_en') custom-input-error @enderror"
                id="Name_en" placeholder=" "
                value="{{ old('Name_en', $Teacher->user?->getTranslation('name', 'en')) }}" />
            <label for="teacherNameEn" class="float-label">{{ trans('Teacher_trans.Name_en') }}</label>
        </div>
        @error('Name_en')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="text" name="National_ID"
                class="form-control custom-input float-input @error('National_ID') custom-input-error @enderror"
                id="National_ID" placeholder=" " value="{{ old('National_ID', $Teacher->user?->National_ID ) }}" />
            <label for="teacherID" class="float-label">{{ trans('main_trans.National_ID') }}</label>
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
                id="password" placeholder=" " />
            <label for="teacherPass" class="float-label">{{ trans('Teacher_trans.Password') }}</label>
        </div>
        @error('password')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="" class="text-danger">{{ trans('Teacher_trans.Gender') }}*</label>
        <select class="form-select custom-select @error('Gender_id') custom-select-error @enderror" id="Gender_id"
            name="Gender_id">
            @foreach ($genders as $gender)
                <option value="{{ $gender->id }}"
                    {{ old('Gender_id', $Teacher->Gender_id ?? '') == $gender->id ? 'selected' : '' }}>
                    {{ $gender->Name }}
                </option>
            @endforeach
        </select>
        @error('Gender_id')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="" class="text-danger">{{ trans('Teacher_trans.specialization') }}*</label>
        <select class="form-select custom-select @error('Specialization_id') custom-select-error @enderror"
            name="Specialization_id" id="Specialization_id">
            @foreach ($specializations as $specialization)
                <option value="{{ $specialization->id }}"
                    {{ old('Specialization_id', $Teacher->Specialization_id ?? '') == $specialization->id ? 'selected' : '' }}>
                    {{ $specialization->Name }}
                </option>
            @endforeach
        </select>
        @error('Specialization_id')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="date" name="Joining_Date"
                class="form-control custom-input float-input @error('Joining_Date') custom-input-error @enderror"
                id="Joining_Date" placeholder=" " value="{{ old('Joining_Date', $Teacher->Joining_Date ?? '') }}" />
            <label for="teacherNameAr" class="float-label">{{ trans('Teacher_trans.Joining_Date') }}</label>
        </div>
        @error('Joining_Date')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative ">
            <input type="email" name="email"
                class="form-control custom-input float-input @error('email') custom-input-error @enderror"
                id="email" placeholder=" " value="{{ old('email', $Teacher->user->email ?? '') }}" />
            <label for="teacherNameEn" class="float-label">{{ trans('Teacher_trans.Email') }}</label>
        </div>
        @error('email')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="form-group-float position-relative ">
            <textarea id="Address" name="Address" class="form-control custom-textarea float-input @error('Address') custom-textarea-error @enderror" rows="3"
                placeholder=" ">{{ old('Address', $Teacher->Address) }}</textarea>
            <label for="teacherAddress" class="float-label">{{ trans('Teacher_trans.Address') }}</label>
        </div>
        @error('Address')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="text-end">
    <button type="submit" class="btn save-btn">{{ trans('main_trans.submit') }}</button>
</div>
