@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">{{ trans('main_trans.list_Promotions') }}</h3>
        <div class="title-underline-manager"></div>


        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    <div class="add-std">
                        <a href="{{ route('Promotion.create') }}"
                            class="btn add-std-btn">{{ trans('main_trans.add_Promotion') }}</a>
                        <a href="#" class="btn rollback-std-btn" data-bs-toggle="modal"
                            data-bs-target="#rollbackAllStdModal">{{ trans('main_trans.rollback_selected') }}</a>

                        <!-- rollback selected modal-->
                        <div class="modal fade" id="rollbackAllStdModal" tabindex="-1"
                            aria-labelledby="rollbackAllStdModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="{{ trans('main_trans.close') }}"></button>
                                    </div>
                                    <form id="rollbackAllForm" action="{{ route('Promotion.rollbackSelected') }}"
                                        method="post">
                                        @csrf

                                        <input type="hidden" name="promotion_ids" id="selectedPromotions">
                                        <div class="modal-body text-center">
                                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                            <p>{{ trans('main_trans.sure_rollback_all') }}</p>
                                        </div>
                                    </form>
                                    <div class="modal-footer custom-modal-footer-manager">
                                        <button type="submit" class="btn btn-primary custom-save-btn"
                                            form="rollbackAllForm">{{ trans('main_trans.rollback') }}</button>
                                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                                            data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="header-table">
                        <div class="select-std d-flex gap-2 flex-wrap">
                        </div>

                        <input type="search" id="promotionsSearch" class="form-control search-input"
                            placeholder="{{ trans('main_trans.search') }}">
                    </div>

                    <div class="table-responsive manager-table-wrapper">
                        @include('components.error-field')
                        <table class="text-center manager-grade-table" id="datatable">
                            <thead class="thead-manager">
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>#</th>
                                    <th class="alert-info">{{ trans('Students_trans.name') }}</th>
                                    <th class="alert-danger">{{ trans('main_trans.Old_school_stage') }}</th>
                                    <th class="alert-danger">{{ trans('main_trans.old_classroom') }}</th>
                                    <th class="alert-danger">{{ trans('main_trans.old_section') }}</th>
                                    <th class="alert-danger">{{ trans('main_trans.old_academic_year') }}</th>
                                    <th class="alert-success">{{ trans('main_trans.current_grade') }}</th>
                                    <th class="alert-success"> {{ trans('main_trans.current_classroom') }}</th>
                                    <th class="alert-success">{{ trans('main_trans.current_section') }}</th>
                                    <th class="alert-success">{{ trans('main_trans.current_academic_year') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotions as $promotion)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_promotions[]"
                                                value="{{ $promotion->id }}" class="selectItem">
                                        </td>

                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $promotion->student->user->name }}</td>
                                        <td>{{ $promotion->f_grade?->Name }}</td>
                                        <td>{{ $promotion->f_classroom?->Name_Class }}</td>
                                        <td>{{ $promotion->f_section?->Name_Section }}</td>
                                        <td>{{ $promotion->academic_year }}</td>
                                        <td>{{ $promotion->t_grade?->Name }}</td>
                                        <td>{{ $promotion->t_classroom?->Name_Class }}</td>
                                        <td>{{ $promotion->t_section?->Name_Section }}</td>
                                        <td>{{ $promotion->academic_year_new }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle operations-btn" data-bs-toggle="dropdown">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-btn-item">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#graduateStdModal{{ $promotion->student->id }}">
                                                            <i
                                                                class="fas fa-user-graduate action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.graduate_student') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#rollbackStdModal{{ $promotion->id }}">
                                                            <i
                                                                class="fas fa-rotate-right action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.rollback_student') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal تخريج الطالب -->
                                    <div class="modal fade" id="graduateStdModal{{ $promotion->student->id }}"
                                        tabindex="-1" aria-labelledby="graduateStdModal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="{{ trans('main_trans.close') }}"></button>
                                                </div>
                                                <form id="gradeuateForm{{ $promotion->student->id }}"
                                                    action="{{ route('Graduated.one', $promotion->student->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('main_trans.sure_graduate_this_std') }}
                                                            <span>{{ $promotion->student->user->name }}</span>
                                                        </p>
                                                    </div>
                                                </form>
                                                <div class="modal-footer custom-modal-footer-manager">
                                                    <button type="submit" class="btn btn-primary custom-save-btn"
                                                        form="gradeuateForm{{ $promotion->student->id }}">{{ trans('main_trans.submit') }}</button>
                                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                        data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- rollback student modal -->
                                    <div class="modal fade" id="rollbackStdModal{{ $promotion->id }}" tabindex="-1"
                                        aria-labelledby="rollbackStdModal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="{{ trans('main_trans.close') }}"></button>
                                                </div>
                                                <form id="rollbackStdForm{{ $promotion->id }}"
                                                    action="{{ route('Promotion.destroy', $promotion->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('main_trans.sure_rollback_this_std') }}
                                                            <span>{{ $promotion->student->user->name }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </form>
                                                <div class="modal-footer custom-modal-footer-manager">
                                                    <button type="submit" class="btn btn-primary custom-save-btn"
                                                        form="rollbackStdForm{{ $promotion->id }}">{{ trans('main_trans.rollback') }}</button>
                                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                        data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                                </div>
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

    {{-- search input code --}}
    <script>
        document.getElementById('promotionsSearch').addEventListener('input', function() {
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

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.selectItem');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
    <script>
        document.querySelector('[data-bs-target="#rollbackAllStdModal"]').addEventListener('click', function() {
            let selected = [];
            document.querySelectorAll('.selectItem:checked').forEach(cb => {
                selected.push(cb.value);
            });
            document.getElementById('selectedPromotions').value = selected.join(',');
        });
    </script>
@endsection
