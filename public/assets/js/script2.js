// { { --auto select grade, classes, and sections by default --} }
$(document).ready(function () {
    $('select[name="Grade_id"]').on('change', function () {
        var Grade_id = $(this).val();
        if (Grade_id) {
            $.ajax({
                url: "{{ URL::to('Get_classrooms') }}/" + Grade_id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="Classroom_id"]').empty();
                    $('select[name="Classroom_id"]').append(
                        "<option selected disabled >{{ trans('Parent_trans.Choose') }}...</option>"
                    );
                    $.each(data, function (key, value) {
                        $('select[name="Classroom_id"]').append(
                            '<option value="' + key + '">' + value +
                            '</option>');
                    });

                },
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
});


$(document).ready(function () {
    $('select[name="Classroom_id"]').on('change', function () {
        var Classroom_id = $(this).val();
        if (Classroom_id) {
            $.ajax({
                url: "{{ URL::to('Get_Sections') }}/" + Classroom_id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="section_id"]').empty();
                    $('select[name="section_id"]').append(
                        "<option selected disabled >{{ trans('Parent_trans.Choose') }}...</option>"
                    );
                    $.each(data, function (key, value) {
                        $('select[name="section_id"]').append(
                            '<option value="' + key + '">' + value +
                            '</option>');
                    });

                },
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
});
// { { --end --} }


// { { --auto select grade, classes, and sections by default for promotinos page--} }
$(document).ready(function () {
    $('select[name="Grade_id_new"]').on('change', function () {
        var Grade_id = $(this).val();
        if (Grade_id) {
            $.ajax({
                url: "{{ URL::to('Get_classrooms') }}/" + Grade_id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="Classroom_id_new"]').empty();
                    $('select[name="Classroom_id_new"]').append(
                        "<option selected disabled >{{ trans('Parent_trans.Choose') }}...</option>"
                    );
                    $.each(data, function (key, value) {
                        $('select[name="Classroom_id_new"]').append(
                            '<option value="' + key + '">' + value +
                            '</option>');
                    });

                },
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
});

$(document).ready(function () {
    $('select[name="Classroom_id_new"]').on('change', function () {
        var Classroom_id = $(this).val();
        if (Classroom_id) {
            $.ajax({
                url: "{{ URL::to('Get_Sections') }}/" + Classroom_id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="section_id_new"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="section_id_new"]').append(
                            '<option value="' + key + '">' + value +
                            '</option>');
                    });

                },
            });
        } else {
            console.log('AJAX load did not work');
        }
    });
});
// { { --end --} }


// { { --auto reload students table when search using selects  --} }
// Get references
const gradeSelect = document.getElementById('gradeSelect');
const classroomSelect = document.getElementById('classroomSelect');
const sectionSelect = document.getElementById('sectionSelect');
const table = document.getElementById('datatable');
const tbody = table.querySelector('tbody');

// Collect all student rows and their data for filtering
const students = Array.from(tbody.querySelectorAll('tr')).map(row => {
    return {
        row: row,
        grade: row.cells[4].textContent.trim(),
        classroom: row.cells[5].textContent.trim(),
        section: row.cells[6].textContent.trim(),
    };
});

// Utility to get unique sorted values from students for dropdown options
function getUniqueValues(items, key, filter = {}) {
    return [...new Set(
        items
            .filter(s => {
                // apply filter keys if provided
                return Object.keys(filter).every(k => filter[k] === '' || s[k] === filter[k]);
            })
            .map(s => s[key])
    )].sort();
}

// Fill classroom options based on selected grade
function updateClassrooms() {
    const selectedGrade = gradeSelect.options[gradeSelect.selectedIndex].text;
    if (!gradeSelect.value) {
        classroomSelect.innerHTML = '<option value="">-- Select Classroom --</option>';
        classroomSelect.disabled = true;
        sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
        sectionSelect.disabled = true;
        return;
    }
    // Get classrooms that belong to selected grade
    const classrooms = getUniqueValues(students, 'classroom', {
        grade: selectedGrade
    });
    classroomSelect.innerHTML = '<option value="">-- Select Classroom --</option>' +
        classrooms.map(c => `<option value="${c}">${c}</option>`).join('');
    classroomSelect.disabled = false;
    sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
    sectionSelect.disabled = true;
}

// Fill sections based on selected grade and classroom
function updateSections() {
    const selectedGrade = gradeSelect.options[gradeSelect.selectedIndex].text;
    const selectedClassroom = classroomSelect.value;
    if (!selectedClassroom) {
        sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
        sectionSelect.disabled = true;
        return;
    }
    const sections = getUniqueValues(students, 'section', {
        grade: selectedGrade,
        classroom: selectedClassroom
    });
    sectionSelect.innerHTML = '<option value="">-- Select Section --</option>' +
        sections.map(s => `<option value="${s}">${s}</option>`).join('');
    sectionSelect.disabled = false;
}

// Filter table rows based on selections
function filterTable() {
    const gradeVal = gradeSelect.options[gradeSelect.selectedIndex].text;
    const classroomVal = classroomSelect.value;
    const sectionVal = sectionSelect.value;

    students.forEach(s => {
        let show = true;
        if (gradeSelect.value && s.grade !== gradeVal) show = false;
        if (classroomSelect.value && s.classroom !== classroomVal) show = false;
        if (sectionSelect.value && s.section !== sectionVal) show = false;
        s.row.style.display = show ? '' : 'none';
    });
}

// Event Listeners
gradeSelect.addEventListener('change', () => {
    updateClassrooms();
    filterTable();
});

classroomSelect.addEventListener('change', () => {
    updateSections();
    filterTable();
});

sectionSelect.addEventListener('change', () => {
    filterTable();
});
// { { --end --} }


// { { --filter grades & classes for create a new section--} }
$(document).ready(function () {
    $('#gradeSelect').on('change', function () {
        var selectedGrade = $(this).val();

        // Show only list_Classes with matching grade
        $('#classSelect option').each(function () {
            var gradeId = $(this).data('grade');
            if (!gradeId) return; // skip the placeholder option
            if (gradeId == selectedGrade) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Reset Class select to default
        $('#classSelect').val('');
    });
});
// { { --end --} }
