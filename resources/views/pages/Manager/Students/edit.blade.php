@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header-form">{{ trans('main_trans.edit_student') }}</h3>

        <div class="container mt-4">
            <div class="card custom-form-card">
                <div class="card-body">
                    @include('components.error-field')
                    <form class="subject-form" method="post" action="{{ route('Students.update', $Student->id) }}"
                        autocomplete="off">
                        @method('PUT')
                        @csrf

                        @include('forms._form-student', ['formMode' => 'edit'])

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- filter classes & section --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gradeSel = document.querySelector('select[name="Grade_id"]');
            const classSel = document.querySelector('select[name="Classroom_id"]');
            const sectionSel = document.querySelector('select[name="section_id"]');

            function resetSelect(sel, placeholder) {
                sel.innerHTML = '';
                const opt = document.createElement('option');
                opt.disabled = true;
                opt.selected = true;
                opt.textContent = placeholder;
                sel.appendChild(opt);
            }

            if (gradeSel) {
                gradeSel.addEventListener('change', function() {
                    const gradeId = this.value;
                    resetSelect(classSel, "{{ trans('Parent_trans.Choose') }}...");
                    resetSelect(sectionSel, "{{ trans('Parent_trans.Choose') }}...");

                    if (!gradeId) return;

                    $.ajax({
                        url: "{{ route('ajax.classrooms', ':grade') }}".replace(':grade', gradeId),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // data is {id: "Name", ...}
                            Object.entries(data).forEach(([id, name]) => {
                                classSel.insertAdjacentHTML('beforeend',
                                    `<option value="${id}">${name}</option>`);
                            });
                        },
                        error: function(xhr) {
                            console.error('Failed to load classrooms', xhr.status, xhr
                                .responseText);
                        }
                    });
                });
            }

            if (classSel) {
                classSel.addEventListener('change', function() {
                    const classId = this.value;
                    resetSelect(sectionSel, "{{ trans('Parent_trans.Choose') }}...");

                    if (!classId) return;

                    $.ajax({
                        url: "{{ route('ajax.sections', ':classroom') }}".replace(':classroom',
                            classId),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            Object.entries(data).forEach(([id, name]) => {
                                sectionSel.insertAdjacentHTML('beforeend',
                                    `<option value="${id}">${name}</option>`);
                            });
                        },
                        error: function(xhr) {
                            console.error('Failed to load sections', xhr.status, xhr
                                .responseText);
                        }
                    });
                });
            }
        });
    </script>
@endsection
@section('js')
    <script>
        $(function() {
            const $grade = $('#Grade_id');
            const $class = $('#Classroom_id');
            const $section = $('#section_id');

            const selectedGrade = $grade.data('selected-grade') || '';
            const selectedClass = $class.data('selected-classroom') || '';
            const selectedSection = $section.data('selected-section') || '';

            function resetSelect($sel, placeholder) {
                $sel.empty().append(`<option selected disabled>${placeholder}</option>`);
            }

            function loadClassrooms(gradeId, preselectId) {
                resetSelect($class, "{{ trans('Parent_trans.Choose') }}...");
                resetSelect($section, "{{ trans('Parent_trans.Choose') }}...");

                if (!gradeId) return $.Deferred().resolve().promise();

                return $.ajax({
                    url: "{{ route('ajax.classrooms', ':grade') }}".replace(':grade', gradeId),
                    type: "GET",
                    dataType: "json"
                }).done(function(data) {
                    $.each(data, function(id, name) {
                        $class.append(`<option value="${id}">${name}</option>`);
                    });
                    if (preselectId) $class.val(String(preselectId));
                }).fail(function(xhr) {
                    console.error('Failed to load classrooms', xhr.status, xhr.responseText);
                });
            }

            function loadSections(classId, preselectId) {
                resetSelect($section, "{{ trans('Parent_trans.Choose') }}...");

                if (!classId) return $.Deferred().resolve().promise();

                return $.ajax({
                    url: "{{ route('ajax.sections', ':class') }}".replace(':class', classId),
                    type: "GET",
                    dataType: "json"
                }).done(function(data) {
                    $.each(data, function(id, name) {
                        $section.append(`<option value="${id}">${name}</option>`);
                    });
                    if (preselectId) $section.val(String(preselectId));
                }).fail(function(xhr) {
                    console.error('Failed to load sections', xhr.status, xhr.responseText);
                });
            }

            // Normal change handlers (when manager changes Grade/Classroom)
            $grade.on('change', function() {
                const gid = $(this).val();
                loadClassrooms(gid, null);
            });

            $class.on('change', function() {
                const cid = $(this).val();
                loadSections(cid, null);
            });

            // ✨ Rehydrate after validation error / on edit:
            // If we have an old/selected grade, load its classrooms, then load sections, then select both
            if (selectedGrade) {
                // Ensure the grade select shows the previous choice
                $grade.val(String(selectedGrade));

                loadClassrooms(selectedGrade, selectedClass).then(function() {
                    if (selectedClass) {
                        return loadSections(selectedClass, selectedSection);
                    }
                });
            }
        });
    </script>
@endsection
