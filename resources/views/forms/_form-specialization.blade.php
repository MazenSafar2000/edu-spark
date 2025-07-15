<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name[ar]" class="form-control custom-input float-input"
            value="{{ old('Name.ar', $Specialization?->getTranslation('Name', 'ar') ?? '') }}" />
        <label class="float-label">{{ trans('Grades_trans.Specialization_name_ar') }}</label>
    </div>
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name[en]" class="form-control custom-input float-input"
            value="{{ old('Name.en', $Specialization?->getTranslation('Name', 'en') ?? '') }}" />
        <label class="float-label">{{ trans('Grades_trans.Specialization_name_en') }}</label>
    </div>
</div>
