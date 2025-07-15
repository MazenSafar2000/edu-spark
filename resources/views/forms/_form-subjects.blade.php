<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="name[ar]" class="form-control custom-input float-input"
            value="{{ old('name.ar', $Subject?->getTranslation('name', 'ar') ?? '') }}" />
        <label class="float-label">{{ trans('main_trans.Subjects_name_ar') }}</label>
    </div>
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="name[en]" class="form-control custom-input float-input"
            value="{{ old('name.en', $Subject?->getTranslation('name', 'en') ?? '') }}" />
        <label class="float-label">{{ trans('main_trans.Subjects_name_ar') }}</label>
    </div>
</div>
