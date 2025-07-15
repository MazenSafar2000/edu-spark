<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" name="name_ar" class="form-control custom-input @error('name_ar') is-invalid @enderror"
            id="subjectAr" placeholder="{{ trans('Parent_trans.Name_Father') }}"
            @if ($Parent->user) value="{{ old('name_ar', $Parent->user->getTranslation('name', 'ar')) }}" @else value="{{ old('name_ar') }}" @endif>
        @error('name_ar')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

    </div>
    <div class="col-md-6">
        <input type="text" name="name_en" class="form-control custom-input @error('name_en') is-invalid @enderror"
            id="subjectEn" placeholder="{{ trans('Parent_trans.Name_Father_en') }}"
            @if ($Parent->user) value="{{ old('name_en', $Parent->user->getTranslation('name', 'en')) }}" @else value="{{ old('name_en') }}" @endif>
        @error('name_en')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
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
        <input type="password" name="password" class="form-control custom-input @error('password') is-invalid @enderror"
            id="subjectEn" placeholder="{{ trans('Parent_trans.Password') }}">
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" name="Job_Father[ar]"
            class="form-control custom-input @error('Job_Father') is-invalid @enderror" id="subjectAr"
            placeholder="{{ trans('Parent_trans.Job_Father') }}"
            value="{{ old('Job_Father.ar', $Parent->getTranslation('Job_Father', 'ar')) }}">
        @error('Job_Father.ar')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <input type="text" name="Job_Father[en]"
            class="form-control custom-input @error('Job_Father') is-invalid @enderror" id="subjectEn"
            placeholder="{{ trans('Parent_trans.Job_Father_en') }}"
            value="{{ old('Job_Father.en', $Parent->getTranslation('Job_Father', 'en')) }}">
        @error('Job_Father.en')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" name="Phone_Father"
            class="form-control custom-input @error('Phone_Father') is-invalid @enderror" id="subjectAr"
            placeholder="{{ trans('Parent_trans.Phone_Father') }}"
            @if ($Parent->user) value="{{ old('Phone_Father', $Parent->Phone_Father) }}" @else value="{{ old('Phone_Father') }}" @endif>
        @error('Phone_Father')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror"
            id="subjectAr" placeholder="{{ trans('Parent_trans.Email') }}"
            @if ($Parent->user) value="{{ old('email', $Parent->user->email) }}" @else value="{{ old('email') }}" @endif>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="">
        <textarea type="text" name="Address_Father" rows="3"
            class="form-control custom-input @error('Address_Father') is-invalid @enderror" id="subjectAr">
@if ($Parent->user)
{{ old('Address_Father', $Parent->Address_Father) }}
@else
{{ old('Address_Father') }}
@endif
</textarea>
        @error('Address_Father')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="text-end">
    <button type="submit" class="btn save-btn">{{ trans('Grades_trans.submit') }}</button>
</div>
