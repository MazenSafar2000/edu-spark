<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="text" name="name_ar"
                class="form-control custom-input float-input @error('name_ar') custom-input-error @enderror"
                id="" placeholder=" "
                value="{{ old('name_ar', $Parent->user?->getTranslation('name', 'ar')) }}" />
            <label for="name_ar" class="float-label">{{ trans('Parent_trans.Name_Father') }}</label>
        </div>
        @error('name_ar')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="text" name="name_en"
                class="form-control custom-input float-input @error('name_en') custom-input-error @enderror"
                id="" placeholder=" "
                value="{{ old('name_en', $Parent->user?->getTranslation('name', 'en')) }}" />
            <label for="name_en" class="float-label">{{ trans('Parent_trans.Name_Father_en') }}</label>
        </div>
        @error('name_en')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="text" name="National_ID"
                class="form-control custom-input float-input @error('National_ID') custom-input-error @enderror"
                id="" placeholder=" " value="{{ old('National_ID', $Parent->user->National_ID ?? '') }}" />
            <label for="National_ID" class="float-label">{{ trans('main_trans.National_ID') }}</label>
        </div>
        @error('National_ID')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="password" name="password"
                class="form-control custom-input float-input @error('password') custom-input-error @enderror"
                id="" placeholder=" " />
            <label for="password" class="float-label">{{ trans('Parent_trans.Password') }}</label>
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
        <div class="form-group-float position-relative">
            <input type="text" name="Job_Father[ar]"
                class="form-control custom-input float-input @error('Job_Father') custom-input-error @enderror"
                id="" placeholder=" "
                value="{{ old('Job_Father.ar', $Parent->getTranslation('Job_Father', 'ar')) }}" />
            <label for="Job_Father[ar]" class="float-label">{{ trans('Parent_trans.Job_Father') }}</label>
        </div>
        @error('Job_Father.ar')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="text" name="Job_Father[en]"
                class="form-control custom-input float-input @error('Job_Father') custom-input-error @enderror"
                id="" placeholder=" "
                value="{{ old('Job_Father.en', $Parent->getTranslation('Job_Father', 'en')) }}" />
            <label for="Job_Father.en" class="float-label">{{ trans('Parent_trans.Job_Father_en') }}</label>
        </div>
        @error('Job_Father.en')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="text" name="Phone_Father"
                class="form-control custom-input float-input @error('Phone_Father') custom-input-error @enderror"
                id="" placeholder=" " value="{{ old('Phone_Father', $Parent->Phone_Father) }}" />
            <label for="Phone_Father" class="float-label">{{ trans('Parent_trans.Phone_Father') }}</label>
        </div>
        @error('Phone_Father')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group-float position-relative">
            <input type="email" name="email"
                class="form-control custom-input float-input @error('email') custom-input-error @enderror"
                id="" placeholder=" " value="{{ old('email', $Parent->user?->email) }}" />
            <label for="email" class="float-label">{{ trans('Parent_trans.Email') }}</label>
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
        <div class="form-group-float position-relative">
            <textarea name="Address_Father" class="form-control custom-textarea float-input @error('Address_Father') custom-textarea-error @enderror" id="" placeholder=" ">{{ old('Address_Father', $Parent->Address_Father) }}</textarea>
            <label for="" class="float-label">{{ trans('main_trans.Address') }}</label>
        </div>
    </div>
</div>

<div class="text-end">
    <button type="submit" class="btn save-btn">{{ trans('Grades_trans.submit') }}</button>
</div>
