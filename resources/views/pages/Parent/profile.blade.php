@extends('layouts.main.parent_dashboard')
@section('parent_content')
    <div class="parentContent">
        <div class="container my-5 parent-info-container">
            <div class="row bg-white align-items-start parent-info-row">

                <div class="col-md-4 text-center mt-4 mt-md-0 parent-profile-section">
                    <img src="{{ asset('assets/images/pic-8.jpg')}}" alt="parent Image" class="img-fluid rounded-circle mb-3 parent-profile-img"
                        width="150">
                    <p class="fw-bold  mb-0 parent-id">{{ Auth::user()->parents->National_ID }}</p>
                    <p class="text-muted parent-role">{{ trans('main_trans.Parent') }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn px-4 mt-2 parent-logout-btn">{{ trans('main_trans.logout') }}</button>
                    </form>
                </div>

                <div class="col-md-8 parent-info-section">
                    <h5 class="mb-4 text-center fw-bold parent-info-title">
                        {{ trans('Parent_trans.parent_data') }}
                    </h5>

                    <div class="row g-3 parent-info-fields">

                        <div class="col-md-6 parent-info-field">
                            <label class="form-label parent-label">{{ trans('Parent_trans.full_father_name') }}</label>
                            <input type="text" class="form-control parent-input" value="{{ Auth::user()->name}}" readonly>
                        </div>

                        <div class="col-md-6 parent-info-field">
                            <label class="form-label  parent-label">{{ trans('main_trans.National_ID') }}</label>
                            <input type="text" class="form-control  parent-input" value="{{ Auth::user()->parents->National_ID}}" readonly>
                        </div>

                        <div class="col-md-6 parent-info-field">
                            <label class="form-label  parent-label">{{ trans('Teacher_trans.Address') }}</label>
                            <input type="text" class="form-control parent-input" value="دير البلح" readonly>
                        </div>

                        <div class="col-md-6 parent-info-field">
                            <label class="form-label parent-label">{{ trans('Parent_trans.Job') }}</label>
                            <input type="text" class="form-control parent-input" value="{{ Auth::user()->parents->Job_Father}}" readonly>
                        </div>

                        <div class="col-md-6 parent-info-field">
                            <label class="form-label parent-label">{{ trans('Parent_trans.Phone_number') }}</label>
                            <input type="text" class="form-control parent-input" value="{{ Auth::user()->parents->Phone_Father}}" readonly>
                        </div>

                        <div class="col-md-6 parent-info-field">
                            <label class="form-label  parent-label">{{ trans('main_trans.email') }}</label>
                            <input type="text" class="form-control parent-input" value="{{ Auth::user()->email}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
