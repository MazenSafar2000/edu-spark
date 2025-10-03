@extends('layouts.main.teacher_dashboard')
@section('teacher_content')
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="profile-card-manager text-center">
                        <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="مدير" class="profile-avatar mb-3">
                        <div class="profile-info-manager">
                            <h3>{{ $teacher->user->name }}</h3>
                            <p><strong>{{ $teacher->specializations->Name }}</strong></p>
                            <p>{{ $teacher->user->email }}</p>
                            <p>{{ $teacher->user->National_ID }}</p>
                        </div>

                        @include('components.error-field')

                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                            <a href="#" class="btn btn-custom-manager px-4" data-bs-toggle="modal"
                                data-bs-target="#editProfile">
                                <i class="fas fa-edit me-2"></i>{{ trans('main_trans.change_settings') }}
                            </a>

                            <div class="modal fade custom-modal" id="editProfile" tabindex="-1"
                                aria-labelledby="editProfile" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered custom-modal-dialog">
                                    <div class="modal-content custom-modal-content">

                                        <!-- رأس المودال -->
                                        <div class="modal-header custom-modal-header">
                                            <h5 class="modal-title custom-modal-title" id="editProfile">
                                                {{ trans('main_trans.change_settings') }}
                                            </h5>
                                        </div>

                                        <!-- جسم المودال -->
                                        <div class="modal-body custom-modal-body">
                                            <form id="editProfilForm" class="custom-form"
                                                action="{{ route('Teacher.update', $teacher->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3 custom-form-group">
                                                    <div class="form-group-float position-relative">
                                                        <input type="text" class="form-control custom-input float-input"
                                                            name="Name_ar" placeholder=" "
                                                            value="{{ old('Name_ar', $teacher->user->getTranslation('name', 'ar')) }}" />
                                                        <label class="float-label">{{ trans('main_trans.name_ar') }}</label>
                                                        @error('Name_ar')
                                                            <div class="error-message">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 custom-form-group">
                                                    <div class="form-group-float position-relative">
                                                        <input type="text" class="form-control custom-input float-input"
                                                            name="Name_en" placeholder=" "
                                                            value="{{ old('Name_en', $teacher->user->getTranslation('name', 'en')) }}" />
                                                        <label
                                                            class="float-label">{{ trans('main_trans.name_en') }}</label>
                                                        @error('Name_en')
                                                            <div class="error-message">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 custom-form-group">
                                                    <div class="form-group-float position-relative">
                                                        <input type="email" class="form-control custom-input float-input"
                                                            name="email" placeholder=" "
                                                            value="{{ old('email', $teacher->user->email) }}" />
                                                        <label class="float-label">{{ trans('main_trans.email') }}</label>
                                                        @error('email')
                                                            <div class="error-message">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 custom-form-group">
                                                    <div class="form-group-float position-relative">
                                                        <input type="password" class="form-control custom-input float-input"
                                                            name="password" placeholder=" " />
                                                        <label
                                                            class="float-label">{{ trans('main_trans.Password') }}</label>
                                                        @error('password')
                                                            <div class="error-message">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 custom-form-group">
                                                    <div class="form-group-float position-relative">
                                                        <input type="password" class="form-control custom-input float-input"
                                                            name="password_confirmation" placeholder=" " />
                                                        <label
                                                            class="float-label">{{ trans('main_trans.confirm_password') }}</label>
                                                    </div>
                                                </div>

                                                <div class="mb-3 custom-form-group">
                                                    <div class="form-group-float position-relative">
                                                        <input type="text" class="form-control custom-input float-input"
                                                            name="National_ID" placeholder=" "
                                                            value="{{ old('National_ID', $teacher->user->National_ID) }}" />
                                                        <label
                                                            class="float-label">{{ trans('main_trans.National_ID') }}</label>
                                                        @error('National_ID')
                                                            <div class="error-message">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="modal-footer custom-modal-footer-manager">
                                            <button type="submit" class="btn btn-primary custom-save-btn"
                                                form="editProfilForm">{{ trans('main_trans.save_data') }}</button>
                                            <button type="button" class="btn btn-secondary custom-cancel-btn"
                                                data-bs-dismiss="modal">{{ trans('main_trans.cancel') }}</button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
