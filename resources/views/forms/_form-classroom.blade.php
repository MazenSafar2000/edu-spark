@php
    $isEdit = isset($formMode) && $formMode === 'edit';
@endphp

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Class[ar]" class="form-control custom-input float-input" id=""
            value="{{ old('Name_Class.ar',  $isEdit ? $Classroom->getTranslation('Name_Class', 'ar') : '') }}" />
        <label for="" class="float-label">{{ trans('My_Classes_trans.Name_class_ar') }}</label>
    </div>

</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Class[en]" class="form-control custom-input float-input" id=""
            value="{{ old('Name_Class.en', $isEdit ? $Classroom->getTranslation('Name_Class', 'en') : '') }}" />
        <label for="" class="float-label">{{ trans('My_Classes_trans.Name_class_en') }}</label>
    </div>
</div>

<div class="mb-3 custom-form-group">
    <select class="form-select custom-select" id="grade" name="Grade_id">
        <option selected disabled>{{ trans('Sections_trans.Select_Grade') }}</option>
        @foreach ($Grades as $Grade)
            <option value="{{ $Grade->id }}" {{ old('Grade_id', $isEdit ? $Classroom->Grade_id : '') == $Grade->id ? 'selected' : '' }}>
                {{ $Grade->Name }}</option>
        @endforeach
    </select>
</div>
