<div class="tab-pane fade" id="classrooms" role="tabpanel">
    <div class="header-table">
        <a href="#" data-bs-toggle="modal" data-bs-target="#addClassModal">
            {{ trans('main_trans.add_class') }}
        </a>

        <input type="search" class="form-control search-input" placeholder="ابحث ...">
    </div>
    <div class="table-responsive">
        <table class="table text-center custom-user-table">
            <thead class="thead-user">
                <tr>
                    <th>#</th>
                    <th>{{ trans('My_Classes_trans.Name_class') }}</th>
                    <th>{{ trans('My_Classes_trans.Name_Grade') }}</th>
                    <th>{{ trans('My_Classes_trans.Processes') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Classes as $Classroom)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $Classroom->Name_Class }}</td>
                        <td>{{ $Classroom->Grades->Name }}</td>
                        <td class="position-relative">
                            <div class="dropdown">
                                <button class="btn operations-btn dropdown-toggle" type="button"
                                    id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ trans('main_trans.operations') }}
                                </button>
                                <ul class="dropdown-menu operations-dropdown text-end"
                                    aria-labelledby="operationsDropdown">

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 custom-edit-btn"
                                            href="#" data-bs-toggle="modal"
                                            data-bs-target="#editClassModal{{ $Classroom->id }}">
                                            <i class="fas fa-edit text-primary"></i> {{ trans('main_trans.edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModalClassroom{{ $Classroom->id }}">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                            {{ trans('main_trans.delete') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($Classes as $Classroom)
        <!-- مودال تعديل الصف -->
        <div class="modal fade custom-modal" id="editClassModal{{ $Classroom->id }}" tabindex="-1"
            aria-labelledby="editClassModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                <div class="modal-content custom-modal-content">

                    <!-- رأس المودال -->
                    <div class="modal-header custom-modal-header">
                        <h5 class="modal-title custom-modal-title" id="editClassModalLabel">
                            {{ trans('My_Classes_trans.edit_class') }}</h5>
                    </div>

                    <!-- جسم المودال -->
                    <div class="modal-body custom-modal-body">
                        <form id="editClassForm" class="custom-form"
                            action="{{ route('Classrooms.update', $Classroom->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            @include('forms._form-classroom', ['formMode' => 'edit', 'classroom' => $Classroom])
                            <!-- التذييل -->
                            <div class="modal-footer custom-modal-footer">
                                <button type="submit"
                                    class="btn btn-primary custom-save-btn">{{ trans('main_trans.edit') }}</button>
                                <button type="button" class="btn btn-secondary custom-cancel-btn"
                                    data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>

        <!-- Modal حذف الصف -->
        <div class="modal fade" id="deleteModalClassroom{{ $Classroom->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                <form action="{{ route('Classrooms.destroy', $Classroom->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="{{ trans('Grades_trans.Close') }}"></button>
                        </div>
                        <div class="modal-body text-center">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <p>{{ trans('Grades_trans.Delete_Warning') }}</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-del">{{ trans('Grades_trans.submit') }}</button>
                            <button type="button" class="btn btn-cancel"
                                data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- add new class modal -->
    <div class="modal fade custom-modal" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
            <div class="modal-content custom-modal-content">

                <!-- رأس المودال -->
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title custom-modal-title" id="addClassModalLabel">
                        {{ trans('My_Classes_trans.add_class') }}
                    </h5>
                </div>

                <!-- جسم المودال -->
                <div class="modal-body custom-modal-body">
                    <form class="custom-form" action="{{ route('Classrooms.store') }}" method="POST">
                        @csrf

                        @include('forms._form-classroom', ['formMode' => 'create', 'classroom' => null])

                        <!-- تذييل المودال -->
                        <div class="modal-footer custom-modal-footer">
                            <button type="submit"
                                class="btn btn-primary custom-save-btn">{{ trans('Grades_trans.submit') }}</button>
                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                data-bs-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                        </div>

                    </form>
                </div>



            </div>
        </div>
    </div>

</div>
