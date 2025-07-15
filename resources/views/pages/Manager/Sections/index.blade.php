<div class="tab-pane fade" id="sections" role="tabpanel">
    <div class="header-table">
        <a href="#" data-bs-toggle="modal" data-bs-target="#addSectionModal">
            {{ trans('main_trans.add_section') }}
        </a>
        <input type="search" class="form-control search-input" placeholder="{{ trans('main_trans.search') }}">
    </div>

    <div class="container my-4">
        <div class="accordion" id="stageAccordion">

            <!-- المرحلة الابتدائية -->
            @foreach ($Grades as $Grade)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPrimary{{ $Grade->id }}">
                        <button
                            class="accordion-button collapsed accordion-grade d-flex justify-content-between flex-row-reverse"
                            type="button" data-bs-toggle="collapse" data-bs-target="#StageName{{ $Grade->id }}"
                            aria-expanded="false" aria-controls="StageName" style="direction: ltr;">
                            <span class="w-100 text-end" style="direction: rtl;">{{ $Grade->Name }}</span>
                        </button>
                    </h2>


                    <div id="StageName{{ $Grade->id }}" class="accordion-collapse collapse"
                        aria-labelledby="headingPrimary{{ $Grade->id }}" data-bs-parent="#stageAccordion">
                        <div class="accordion-body p-0">
                            <div class="table-responsive">
                                <table class="table text-center custom-user-table mb-0">
                                    <thead class="thead-user">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('Sections_trans.Name_Section') }}</th>
                                            <th>{{ trans('Sections_trans.Name_Class') }}</th>
                                            <th>{{ trans('Sections_trans.Status') }}</th>
                                            <th>{{ trans('Sections_trans.Processes') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Grade->Classrooms as $Classroom)
                                            @foreach ($Classroom->sections as $Section)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $Section->Name_Section }}</td>
                                                    <td>{{ $Section->My_classs->Name_Class }}</td>
                                                    <td>
                                                        @if ($Section->Status === 1)
                                                            <label
                                                                class="badge badge-success text-success">{{ trans('Sections_trans.Status_Section_AC') }}</label>
                                                        @else
                                                            <label
                                                                class="badge badge-danger text-danger">{{ trans('Sections_trans.Status_Section_No') }}</label>
                                                        @endif

                                                    </td>
                                                    </td>
                                                    <td class="position-relative">
                                                        <div class="dropdown">
                                                            <button class="btn operations-btn dropdown-toggle"
                                                                type="button" id="operationsDropdown1"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                {{ trans('main_trans.operations') }}
                                                            </button>
                                                            <ul class="dropdown-menu operations-dropdown text-end"
                                                                aria-labelledby="operationsDropdown1">
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                                                        href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#editSectionModal{{ $Section->id }}">
                                                                        <i class="fas fa-edit text-primary"></i>
                                                                        {{ trans('main_trans.edit') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('teachersSection', $Section->id) }}"
                                                                        class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn">
                                                                        <i class="fa-solid fa-eye text-success"></i>
                                                                        {{ trans('main_trans.view_teachers') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('studentsSection', $Section->id) }}"
                                                                        class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn">
                                                                        <i class="fa-solid fa-eye text-success"></i>
                                                                        {{ trans('main_trans.view_students') }}
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                                                        href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#deleteModalSection{{ $Section->id }}">
                                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                                        {{ trans('main_trans.delete') }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    @foreach ($Grades as $Grade)
        @foreach ($Grade->Classrooms as $Classroom)
            @foreach ($Classroom->sections as $Section)
                {{--  edit section modal  --}}
                <div class="modal fade custom-modal" id="editSectionModal{{ $Section->id }}" tabindex="-1"
                    aria-labelledby="editSectionModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                        <div class="modal-content custom-modal-content">

                            <div class="modal-header custom-modal-header">
                                <h5 class="modal-title custom-modal-title" id="editSectionModalLabel">
                                    {{ trans('Sections_trans.edit_Section') }}</h5>
                            </div>

                            <div class="modal-body custom-modal-body">
                                <form id="editClassForm" class="custom-form"
                                    action="{{ route('Sections.update', $Section->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @include('forms._form-section', [
                                        'formMode' => 'edit',
                                        'section' => $Section,
                                    ])

                                    <div class="modal-footer custom-modal-footer">
                                        <button type="submit"
                                            class="btn btn-primary custom-save-btn">{{ trans('Grades_trans.submit') }}</button>
                                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                                            data-bs-dismiss="modal">{{ trans('main_trans.close') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  delete section modal  --}}
                <div class="modal fade" id="deleteModalSection{{ $Section->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="{{ trans('main_trans.close') }}"></button>
                            </div>

                            <form action="{{ route('Sections.destroy', $Section->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <div class="modal-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit"
                                        class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                                    <button type="button" class="btn btn-cancel"
                                        data-bs-dismiss="modal">{{ trans('main_trans.close') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    @endforeach



</div>

<!-- add new section modal -->
<div class="modal fade custom-modal" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
        <div class="modal-content custom-modal-content">

            <!-- رأس المودال -->
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title custom-modal-title" id="addSectionModalLabel">
                    {{ trans('main_trans.add_section') }}</h5>
            </div>

            <!-- جسم المودال -->
            <div class="modal-body custom-modal-body">
                <form class="custom-form" action="{{ route('Sections.store') }}" method="POST">
                    @csrf

                    @include('forms._form-section', ['formMode' => 'create', 'section' => null])

                    <!-- تذييل المودال -->
                    <div class="modal-footer custom-modal-footer">
                        <button type="submit" class="btn btn-primary custom-save-btn">اضافة</button>
                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                            data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('select[name="Grade_id"]').on('change', function() {
            var Grade_id = $(this).val();
            if (Grade_id) {
                $.ajax({
                    url: "{{ URL::to('Get_classrooms') }}/" + Grade_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="Class_id"]').empty();
                        $('select[name="Class_id"]').append(
                            "<option selected disabled >{{ trans('Parent_trans.Choose') }}...</option>"
                        );
                        $.each(data, function(key, value) {
                            $('select[name="Class_id"]').append(
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
</script>
