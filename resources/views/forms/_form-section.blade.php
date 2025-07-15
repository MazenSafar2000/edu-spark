@php
    $isEdit = isset($formMode) && $formMode === 'edit';
@endphp

{{-- الاسم بالعربية --}}
<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Section_Ar" class="form-control custom-input float-input"
            value="{{ old('Name_Section_Ar', $isEdit ? $section->getTranslation('Name_Section', 'ar') : '') }}" />
        <label class="float-label">{{ trans('Sections_trans.Section_name_ar') }}</label>
    </div>
</div>

{{-- الاسم بالانجليزية --}}
<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <input type="text" name="Name_Section_En" class="form-control custom-input float-input"
            value="{{ old('Name_Section_En', $isEdit ? $section->getTranslation('Name_Section', 'en') : '') }}" />
        <label class="float-label">{{ trans('Sections_trans.Section_name_en') }}</label>
    </div>
</div>

<div class="mb-3 custom-form-group">
    <div class="form-check">

        @if ($Section->Status === 1)
            <input type="checkbox" checked class="form-check-input" name="Status" id="exampleCheck1">
        @else
            <input type="checkbox" class="form-check-input" name="Status" id="exampleCheck1">
        @endif
        <label class="form-check-label" for="exampleCheck1">{{ trans('Sections_trans.Status') }}</label><br>

    </div>
</div>


{{-- المرحلة --}}
<div class="mb-3 custom-form-group">
    <select class="form-select custom-select" name="Grade_id" id="grade-select">
        <option value="" disabled selected>{{ trans('Sections_trans.Select_Grade') }}</option>
        @foreach ($Grades as $list_Grade)
            <option value="{{ $list_Grade->id }}"
                {{ old('Grade_id', $isEdit ? $section->My_classs->Grade_id : '') == $list_Grade->id ? 'selected' : '' }}>
                {{ $list_Grade->Name }}
            </option>
        @endforeach
    </select>
</div>

{{-- الصف --}}
<div class="mb-3 custom-form-group">
    <select class="form-select custom-select" name="Class_id" id="class_id">
        <option value="" selected disabled>
            {{ trans('Teacher_trans.select_class') }}
        </option>
        @foreach ($Classes as $class)
            <option value="{{ $class->id }}" data-grade="{{ $class->Grade_id }}"
                {{ old('Class_id', $isEdit ? $section->Class_id : '') == $class->id ? 'selected' : '' }}>
                {{ $class->getTranslation('Name_Class', app()->getLocale()) }}
            </option>
        @endforeach
    </select>
</div>
