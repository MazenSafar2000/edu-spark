<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <select name="teacher_id" id="teaecher_id" class="form-select custom-select">
            <option value="" disabled selected>{{ trans('main_trans.select_teacher_name') }}</option>
            @foreach ($allTeachers as $teacher)
                <option value="{{ $teacher->id }}"
                    {{ old('teacher_id', $section?->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->user->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3 custom-form-group">
    <div class="form-group-float position-relative ">
        <select name="subject_id" id="subject_id" class="form-select custom-select">
            <option value="" disabled selected>{{ trans('main_trans.select_subject') }}</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}"
                    {{ old('subject_id', $section?->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" name="section_id" value="{{ $section->id }}">
