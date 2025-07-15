@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">جدول الطلاب</h3>
        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    <div class="header-table">
                        <div class="select-std d-flex gap-2 flex-wrap">
                            <select class="form-select std-select" id="gradeSelect">
                                <option value="">-- Select Grade --</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->Name }}</option>
                                @endforeach
                            </select>
                            <select class="form-select std-select" id="classroomSelect">
                                <option value="">-- Select Classroom --</option>
                                <!-- Options filled dynamically -->
                            </select>
                            <select class="form-select std-select" id="sectionSelect">
                                <option value="">-- Select Section --</option>
                                <!-- Options filled dynamically -->
                            </select>
                        </div>

                        <input type="text" id="studentSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>


                    <div class="table-responsive">
                        <table class="table text-center custom-user-table" id="datatable">
                            <thead class="thead-user">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('Students_trans.name') }}</th>
                                    <th>{{ trans('Students_trans.email') }}</th>
                                    <th>{{ trans('Students_trans.gender') }}</th>
                                    <th>{{ trans('Students_trans.Grade') }}</th>
                                    <th>{{ trans('Students_trans.classrooms') }}</th>
                                    <th>{{ trans('Students_trans.section') }}</th>
                                    <th>{{ trans('Students_trans.Processes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>{{ $student->gender->Name }}</td>
                                        <td>{{ $student->grade->Name }}</td>
                                        <td>{{ $student->classroom->Name_Class }}</td>
                                        <td>{{ $student->section->Name_Section }}</td>
                                        <td class="position-relative">
                                            <div class="dropdown">
                                                <button class="btn operations-btn dropdown-toggle" type="button"
                                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-dropdown text-end"
                                                    aria-labelledby="operationsDropdown">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="{{ route('students.show', $student->id) }}">
                                                            <i class="fa-solid fa-eye text-success"></i>
                                                            {{ trans('main_trans.Student_information') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <!-- Modal حذف الطالب -->
                                        <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <!-- يجعل المودال بالنص -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="إغلاق"></button>
                                                    </div>

                                                    <form action="{{ route('Students.destroy', $student->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-body text-center">
                                                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                            <p>هل أنت متأكد أنك تريد حذف هذا الطالب؟</p>
                                                            <p>{{ $student->user->name }}</p>
                                                        </div>

                                                        <div class="modal-footer justify-content-center">
                                                            <button type="submit" class="btn btn-del">تأكيد
                                                                الحذف</button>
                                                            <button type="button" class="btn btn-cancel"
                                                                data-bs-dismiss="modal">إلغاء</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>


    <script>
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
    </script>

    {{-- search input code --}}
    <script>
        document.getElementById('studentSearch').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('datatable');
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = Array.from(row.cells).map(td => td.textContent.toLowerCase());
                const match = cells.some(cell => cell.includes(searchValue));
                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
