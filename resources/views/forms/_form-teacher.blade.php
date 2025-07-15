<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" name="Name_ar" class="form-control custom-input @error('Name_ar') is-invalid @enderror"
            id="Name_ar" placeholder="{{ trans('Teacher_trans.Name_ar') }}"
            @if ($Teacher->user) value="{{ old('Name_ar', $Teacher->user->getTranslation('name', 'ar')) }}"
@else
    value="{{ old('Name_ar') }}" @endif>

        @error('Name_ar')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <input type="text" name="Name_en" class="form-control custom-input @error('Name_en') is-invalid @enderror"
            id="Name_en" placeholder="{{ trans('Teacher_trans.Name_en') }}"
            @if ($Teacher->user) value="{{ old('Name_en', $Teacher->user->getTranslation('name', 'en')) }}"
@else
    value="{{ old('Name_en') }}" @endif>
        @error('Name_en')
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
            id="password" placeholder="{{ trans('Teacher_trans.Password') }}">
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <select class="form-select custom-select @error('Gender_id') is-invalid @enderror" name="Gender_id"
            id="Gender_id">
            <option disabled selected>{{ trans('Teacher_trans.Gender') }}</option>
            @foreach ($genders as $gender)
                <option value="{{ $gender->id }}"
                    {{ old('Gender_id', $Teacher->Gender_id ?? '') == $gender->id ? 'selected' : '' }}>
                    {{ $gender->Name }}
                </option>
            @endforeach
        </select>
        @error('Gender_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <select class="form-select custom-select @error('Specialization_id') is-invalid @enderror"
            name="Specialization_id" id="Specialization_id">
            <option disabled selected>{{ trans('Teacher_trans.specialization') }}</option>
            @foreach ($specializations as $specialization)
                <option value="{{ $specialization->id }}"
                    {{ old('Specialization_id', $Teacher->Specialization_id ?? '') == $specialization->id ? 'selected' : '' }}>
                    {{ $specialization->Name }}
                </option>
            @endforeach
        </select>
        @error('Specialization_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="date" name="Joining_Date"
            class="form-control custom-input @error('Joining_Date') is-invalid @enderror" id="Joining_Date"
            placeholder="{{ trans('Teacher_trans.Joining_Date') }}"
            value="{{ old('Joining_Date', $Teacher->Joining_Date ?? '') }}">
        @error('Joining_Date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror"
            id="email" placeholder="{{ trans('Teacher_trans.Email') }}"
            value="{{ old('email', $Teacher->user->email ?? '') }}">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mb-3">
    <textarea name="Address" class="form-control custom-input @error('Address') is-invalid @enderror" id="Address"
        rows="3" placeholder="{{ trans('Teacher_trans.Address') }}">{{ old('Address', $Teacher->Address) }}</textarea>
    @error('Address')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>



<div class="text-end">
    <button type="submit" class="btn save-btn">{{ trans('Teacher_trans.confirm') }}</button>
</div>
