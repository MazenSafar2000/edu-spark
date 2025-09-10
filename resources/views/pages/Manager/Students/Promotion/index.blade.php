@extends('layouts.main.manager_dashboard')
@section('manager_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header">الترقيات</h3>
        <div class="title-underline-manager"></div>


        <div class="table-users mt-5">
            <!-- المحتوى -->
            <div class="table-content tab-content" id="myTabContent">
                <!-- الطلاب -->
                <div class="tab-pane fade show active" id="students" role="tabpanel">
                    <div class="add-std">
                        <a href="{{ route('Promotion.create') }}" class="add-std-btn">ترقية صف</a>
                        <a href="#" class="rollback-std-btn" data-bs-toggle="modal"
                            data-bs-target="#rollbackAllStdModal">استعادة</a>


                        <!-- Modal استعادة كل الطالب -->
                        <div class="modal fade" id="rollbackAllStdModal" tabindex="-1"
                            aria-labelledby="rollbackAllStdModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="إغلاق"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                        <p>هل أنت متأكد أنك تريد استعادة جميع الطلاب ؟</p>
                                    </div>
                                    <div class="modal-footer custom-modal-footer-manager">
                                        <button type="submit" class="btn btn-primary custom-save-btn"
                                            form="stageForm">استعادة</button>
                                        <button type="button" class="btn btn-secondary custom-cancel-btn"
                                            data-bs-dismiss="modal">إلغاء</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="header-table">
                        <div class="select-std d-flex gap-2 flex-wrap">
                            <select class="form-select std-select" id="stage">
                                <option selected disabled>الصف السابق ...</option>
                            </select>
                            <select class="form-select std-select" id="class">
                                <option selected disabled> الصف الحالي ...</option>
                            </select>

                        </div>

                        <input type="search" class="form-control search-input" placeholder="ابحث ...">
                    </div>

                    <div class="table-responsive manager-table-wrapper">
                        <table class="text-center manager-grade-table">
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
                                    <th>{{ trans('Students_trans.Processes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotions as $promotion)
                                    <tr>
                                        <td><input type="checkbox"></td>
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
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu operations-btn-item">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#graduateStdModal">
                                                            <i
                                                                class="fas fa-user-graduate action-icon edit-icon-action"></i>
                                                            تخريج الطالب
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#rollbackStdModal">
                                                            <i
                                                                class="fas fa-rotate-right action-icon delete-icon-action"></i>
                                                            استعادة الطالب
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                    <!-- Modal استعادة الطالب -->
                                    <div class="modal fade" id="rollbackStdModal" tabindex="-1"
                                        aria-labelledby="rollbackStdModal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="إغلاق"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                    <p>هل أنت متأكد أنك تريد استعادة هذا الطالب؟ <span>محمد محمد</span></p>
                                                </div>
                                                <div class="modal-footer custom-modal-footer-manager">
                                                    <button type="submit" class="btn btn-primary custom-save-btn"
                                                        form="stageForm">استعادة</button>
                                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal تخريج الطالب -->
                                    <div class="modal fade" id="graduateStdModal" tabindex="-1"
                                        aria-labelledby="graduateStdModal" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"> <!-- يجعل المودال بالنص -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="إغلاق"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                                    <p>هل أنت متأكد أنك تريد تخريج هذا الطالب؟ <span>محمد محمد</span></p>
                                                </div>
                                                <div class="modal-footer custom-modal-footer-manager">
                                                    <button type="submit" class="btn btn-primary custom-save-btn"
                                                        form="stageForm">تأكيد</button>
                                                    <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                        data-bs-dismiss="modal">إلغاء</button>
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
@endsection
