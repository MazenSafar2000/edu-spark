<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="name[ar]" class="form-control custom-input float-input"
            value="{{ old('name.ar', $Subject?->getTranslation('name', 'ar') ?? '') }}" placeholder=" " />
        <label class="float-label">{{ trans('main_trans.Subjects_name_ar') }}</label>
    </div>
    @error('name.ar')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="name[en]" class="form-control custom-input float-input"
            value="{{ old('name.en', $Subject?->getTranslation('name', 'en') ?? '') }}" placeholder=" " />
        <label class="float-label">{{ trans('main_trans.Subjects_name_en') }}</label>
    </div>
    @error('name.en')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="file" name="image" class="form-control custom-input float-input" value="" />
        @if (isset($Subject) && $Subject->image)
            <img src="{{ asset('storage/attachments/subjects' . $Subject->image) }}" alt="Subject Image" width="100"
                class="mt-2">
        @endif
        <label class="float-label">{{ trans('main_trans.subject_image') }}</label>
    </div>
    @error('image')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>
