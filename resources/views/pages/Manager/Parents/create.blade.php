@extends('layouts.main.manager_dashboard')
@section('manager_content')
    @if ($errors->any())
        <div class="error">{{ $errors->first('Name') }}</div>
    @endif
    <div id="mainContent" class="transition-all with-sidebar" style="transition: margin-inline-end 0.3s ease-in-out;">
        <h3 class="manager-header-form">اضافة ولي أمر</h3>

        <div class="container mt-4">
            <div class="card custom-form-card">
                <div class="card-body">
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form class="subject-form" action="{{ route('Parents.store') }}" method="POST">
                        @csrf

                        @include('forms._form-parent')

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
