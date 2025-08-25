@extends('layouts.landingPageHead')
@section('landing-content')
    <header class="header-page bg-white shadow fixed-top">

        <div class="top-header-dashboard">
            <div class=" d-flex flex-wrap justify-content-between align-items-center ">


                <div class="d-flex gap-3 flex-wrap">
                    <span class="info-item-location">{{ trans('main_trans.palestine_gaza') }}<i class="fas fa-map-marker-alt"></i></span>

                    <span class="info-item-hour"> من 8:00 ص - 3:00 م <i class="fas fa-clock"></i> </span>
                </div>
                <div class="d-flex gap-3">
                    <span class="contact-item-email">sparkEducation<i class="fas fa-envelope"></i></span>
                    <span class="contact-item-phone">0598765432<i class="fas fa-phone"></i></span>
                </div>
            </div>
        </div>
        <div class="header-row container-fluid d-flex align-items-center justify-content-between py-3">

            <!-- الشعار على اليمين -->
            <a href="index.html">
                <img src="{{ asset('assets/images/spark.png')}}" alt="spark education" class="logo">
            </a>

            <!-- القائمة اليسرى (أيقونات) -->
            <nav class="d-flex gap-4 ms-4">
                <a href="#" title="تغيير اللغة"><i class="fas fa-language icon-header"></i></a>
                <a href="index.html" title="من نحن"><i class="fas fa-question icon-header"></i></a>
                <a href="#" title="اتصل بنا"><i class="fas fa-phone icon-header"></i></a>

            </nav>
        </div>
    </header>

    <div class="error-page">

        <div class="container">
            <div class="row align-items-center custom-section">

                <!-- القسم الأيسر: الصورة -->
                <div class="col-md-6 text-center custom-image-container">
                    <img src="{{ asset('assets/images/Asset.png')}}" alt="صورة" class="img-fluid custom-image">
                </div>

                <!-- القسم الأيمن: النص والزر -->
                <div class="col-md-6 custom-text-container">
                    <h3 class="custom-title">للأسف !!!</h3>
                    <p class="custom-paragraph">
                        هذه الصفحة غير متوفرة يمكنك العودة إلى الخلف
                    </p>
                    <a href="{{ URL::previous() }}" class="btn btn-outline-primary custom-back-btn">
                        رجوع <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
