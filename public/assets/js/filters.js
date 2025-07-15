// $('#grade-select').on('change', function () {
//     var gradeId = $(this).val();
//     if (gradeId) {
//         $.get(`/teacher/filter-classrooms/${gradeId}`, function (data) {
//             $('#classroom-select').empty().append(
//                 "<option>{{ trans('Teacher_trans.select_class') }}</option>");
//             $('#section-select').empty().append(
//                 "<option>{{ trans('Teacher_trans.select_section') }}</option>");
//             $('#subject-select').empty().append(
//                 "<option>{{ trans('Teacher_trans.select_subject') }}</option>");
//             $.each(data, function (key, classroom) {
//                 $('#classroom-select').append('<option value="' + classroom.id + '">' +
//                     classroom.name + '</option>');
//             });
//         });
//     }
// });

// $('#classroom-select').on('change', function () {
//     var classId = $(this).val();
//     if (classId) {
//         $.get(`/teacher/filter-sections/${classId}`, function (data) {
//             $('#section-select').empty().append(
//                 "<option>{{ trans('Teacher_trans.select_section') }}</option>");
//             $('#subject-select').empty().append(
//                 "<option>{{ trans('Teacher_trans.select_subject') }}</option>");
//             $.each(data, function (key, section) {
//                 $('#section-select').append('<option value="' + section.id + '">' + section
//                     .name + '</option>');
//             });
//         });
//     }
// });

// $('#section-select').on('change', function () {
//     let gradeID = $('#grade-select').val();
//     let classID = $('#classroom-select').val();
//     let sectionID = $(this).val();

//     if (gradeID && classID && sectionID) {
//         $.ajax({
//             url: `/teacher/filter-subjects/${gradeID}/${classID}/${sectionID}`,
//             type: 'GET',
//             success: function (data) {
//                 console.log(data);
//                 $('#subject-select').empty().append(
//                     "<option>{{ trans('Teacher_trans.select_subject') }}</option>"
//                 );
//                 $.each(data, function (key, subject) {
//                     $('#subject-select').append(
//                         `<option value="${subject.id}">${subject.name}</option>`);
//                 });
//             }
//         });
//     }
// });
