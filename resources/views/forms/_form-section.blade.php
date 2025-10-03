@php
    $isEdit = isset($formMode) && $formMode === 'edit';
@endphp

{{-- الاسم بالعربية --}}
<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Section_Ar"
            class="form-control custom-input float-input @error('Name_Section_Ar') custom-input-error @enderror"
            value="{{ old('Name_Section_Ar', $isEdit ? $section->getTranslation('Name_Section', 'ar') : '') }}"
            placeholder=" " />
        <label class="float-label">{{ trans('main_trans.Section_name_ar') }}</label>
    </div>
    @error('Name_Section_Ar')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

{{-- الاسم بالانجليزية --}}
<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Section_En"
            class="form-control custom-input float-input @error('Name_Section_En') custom-input-error @enderror"
            value="{{ old('Name_Section_En', $isEdit ? $section->getTranslation('Name_Section', 'en') : '') }}"
            placeholder=" " />
        <label class="float-label">{{ trans('main_trans.Section_name_en') }}</label>
    </div>
    @error('Name_Section_En')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

{{-- grade --}}
<div class="mb-3 custom-form-group">
    <select class="form-select custom-select" name="Grade_id" id="grade-select">
        <option value="" disabled selected>{{ trans('main_trans.select_grade') }}</option>
        @foreach ($Grades as $list_Grade)
            <option value="{{ $list_Grade->id }}"
                {{ old('Grade_id', $isEdit ? $section->My_classs->Grade_id : '') == $list_Grade->id ? 'selected' : '' }}>
                {{ $list_Grade->Name }}
            </option>
        @endforeach
    </select>
    @error('Grade_id')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

{{-- classroom --}}
<div class="mb-3 custom-form-group">
    <select class="form-select custom-select" name="Class_id" id="class_id">
        @if ($isEdit)
            <option value="{{ $section->My_classs->id }}">
                {{ $section->My_classs->Name_Class }}
            </option>
        @endif
    </select>
    @error('class_id')
        <div class="error-message" id="error-bookNameArabic">
            <i class="fas fa-exclamation-triangle"></i>{{ $message }}
        </div>
    @enderror
</div>

{{-- status --}}
<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <div class="form-check">

            @if ($Section->Status === 1)
                <input type="checkbox" checked class="form-check-input" name="Status" id="StatusCheck">
            @else
                <input type="checkbox" class="form-check-input" name="Status" id="StatusCheck">
            @endif
            <label class="form-check-label" for="StatusCheck">{{ trans('main_trans.status') }}</label><br>

        </div>
        @error('Status')
            <div class="error-message" id="error-bookNameArabic">
                <i class="fas fa-exclamation-triangle"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>
