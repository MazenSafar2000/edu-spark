@php
    $isEdit = isset($formMode) && $formMode === 'edit';
@endphp

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Class[ar]" class="form-control custom-input float-input @error('Name_class') custom-input-error @enderror" id=""
            value="{{ old('Name_Class.ar', $isEdit ? $Classroom->getTranslation('Name_Class', 'ar') : '') }}" placeholder=" "/>
        <label for="" class="float-label">{{ trans('My_Classes_trans.Name_class_ar') }}</label>
    </div>
    @error('Name_Class.ar')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Class[en]" class="form-control custom-input float-input @error('Name_class') custom-input-error @enderror" id=""
            value="{{ old('Name_Class.en', $isEdit ? $Classroom->getTranslation('Name_Class', 'en') : '') }}" placeholder=" "/>
        <label for="" class="float-label">{{ trans('My_Classes_trans.Name_class_en') }}</label>
    </div>
    @error('Name_Class.en')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 custom-form-group">
    <select class="form-select custom-select @error('Grade_id') custom-select-error @enderror" id="grade" name="Grade_id">
        <option selected disabled>{{ trans('Sections_trans.Select_Grade') }}</option>
        @foreach ($Grades as $Grade)
            <option value="{{ $Grade->id }}"
                {{ old('Grade_id', $isEdit ? $Classroom->Grade_id : '') == $Grade->id ? 'selected' : '' }}>
                {{ $Grade->Name }}</option>
        @endforeach
    </select>
    @error('Grade_id')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>
