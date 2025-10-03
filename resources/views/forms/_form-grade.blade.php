<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name[ar]"
            class="form-control custom-input float-input @error('Name[ar]') custom-input-error @enderror"
            value="{{ old('Name.ar', $Grade?->getTranslation('Name', 'ar') ?? '') }}" placeholder=" " />
        <label class="float-label">{{ trans('main_trans.stage_name_ar') }}</label>
    </div>
    @error('Name.ar')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name[en]"
            class="form-control custom-input float-input @error('Name[en]') custom-input-error @enderror"
            value="{{ old('Name.en', $Grade?->getTranslation('Name', 'en') ?? '') }}" placeholder=" " />
        <label class="float-label">{{ trans('main_trans.stage_name_en') }}</label>
    </div>
    @error('Name.en')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <textarea name="Notes" class="form-control custom-textarea @error('Notes') custom-textarea-error @enderror"
            rows="3" placeholder="{{ trans('main_trans.Notes') }}">{{ old('Notes', $Grade?->Notes ?? '') }}</textarea>
    </div>
    @error('Notes')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>
