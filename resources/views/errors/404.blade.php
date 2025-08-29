@extends('layouts.errorPageHead')
@section('errorPage-content')

<div class="error-page">
    <div class="container">
        <div class="row align-items-center custom-section">

            <div class="col-md-8 text-center custom-image-container">
                <img src="{{ asset('assets/images/Asset.png') }}" alt="صورة" class="img-fluid custom-image">
            </div>

            <div class="col-md-4 custom-text-container">
                <h3 class="custom-title">للأسف !!!</h3>
                <div class="title-underline"></div>
                <p class="custom-paragraph">
                    هذه الصفحة غير متوفرة يمكنك العودة إلى الخلف
                </p>
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary custom-back-btn">
                    رجوع <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
