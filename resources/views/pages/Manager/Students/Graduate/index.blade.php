@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">{{ trans('main_trans.list_Graduate') }}</h3>
        <div class="title-underline-manager"></div>


        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    <div class="header-table">
                        <div class="select-std d-flex gap-2 flex-wrap">
                            <input type="search" id="graduateSearch" class="form-control search-input"
                                placeholder="{{ trans('main_trans.search') }}">
                        </div>
                    </div>

                    <div class="table-responsive manager-table-wrapper">
                        <table class=" text-center manager-grade-table" id="datatable">
                            <thead class="thead-manager">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('main_trans.student_name') }}</th>
                                    <th>{{ trans('main_trans.National_ID') }}</th>
                                    <th>{{ trans('main_trans.Date_of_Birth') }}</th>
                                    <th>{{ trans('main_trans.graduate_year') }}</th>
                                    <th>{{ trans('main_trans.reason') }}</th>
                                    <th>{{ trans('main_trans.operations') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($graduates as $graduate)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $graduate->name }}</td>
                                        <td>{{ $graduate->National_ID }}</td>
                                        <td>{{ $graduate->Date_Birth }}</td>
                                        <td>{{ $graduate->academic_year }}</td>
                                        <td style="max-width: 50px; max-width: 70px;">{{ $graduate->reason }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle operations-btn" data-bs-toggle="dropdown">
                                                    {{ trans('main_trans.operations') }}
                                                </button>
                                                <ul class="dropdown-menu operations-btn-item">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editGraduateModal{{ $graduate->id }}">
                                                            <i class="fas fa-edit action-icon edit-icon-action"></i>
                                                            {{ trans('main_trans.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $graduate->id }}">
                                                            <i class="fas fa-trash-alt action-icon delete-icon-action"></i>
                                                            {{ trans('main_trans.delete') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>

                                    <!-- Edit Graduate Modal -->
                                    <div class="modal fade" id="editGraduateModal{{ $graduate->id }}" tabindex="-1"
                                        aria-labelledby="editGraduateModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="{{ trans('main_trans.close') }}"></button>
                                                </div>
                                                <form id="editGraduateReason{{ $graduate->id }}"
                                                    action="{{ route('Graduate.update', $graduate->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body text-center">
                                                        <div class="mb-3">
                                                            <label for="reason{{ $graduate->id }}" class="form-label h3">
                                                                {{ trans('main_trans.reason') }}
                                                            </label>
                                                            <textarea name="reason" id="reason{{ $graduate->id }}" class="form-control" rows="3">{{ $graduate->reason }}</textarea>
                                                        </div>
                                                    </div>

                                                </form>
                                                <div class="modal-footer custom-modal-footer-manager">
                                                    <button type="submit" form="editGraduateReason{{ $graduate->id }}"
                                                        class="btn btn-primary custom-save-btn">
                                                        {{ trans('main_trans.submit') }}
                                                    </button>
                                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                        data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- delete Graduate Modal -->
                                    <div class="modal fade" id="deleteModal{{ $graduate->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="{{ trans('main_trans.close') }}"></button>
                                                </div>
                                                <form id="deleteGraduateForm{{ $graduate->id }}"
                                                    action="{{ route('Graduate.destroy', $graduate->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-body text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                        <p>{{ trans('main_trans.sure_delete_this_graduate') }}</p>
                                                    </div>
                                                </form>
                                                <div class="modal-footer custom-modal-footer-manager">
                                                    <button type="submit" class="btn btn-primary custom-save-btn"
                                                        form="deleteGraduateForm{{ $graduate->id }}">{{ trans('main_trans.submit') }}</button>
                                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                        data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $graduates->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- search input code --}}
    <script>
        document.getElementById('graduateSearch').addEventListener('input', function() {
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
