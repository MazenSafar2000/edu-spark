<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spark Education</title>
    <link rel="icon" href="{{ asset('assets/images/logo-dark.png') }}" type="image/png">


    <!-- ربط ملف bootstrap CSS المحلي -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">


    <!-- font awsam cdn link -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Rubik:ital,wght@0,300..900;1,300..900&family=Square+Peg&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet" />



    <!-- custom css file link -->
    @if (App::getLocale() == 'en')
        <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">
    @else
        <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
    @endif

</head>

<body>
    <div class="landing-page">

        <div class="header-landing">
            <div class="top-header">
                <div class="container d-flex flex-wrap justify-content-between align-items-center ">
                    <div class="d-flex gap-3 flex-wrap">
                        <span class="info-item-location">{{ trans('main_trans.palestine_gaza') }}<i class="fas fa-map-marker-alt"></i></span>

                        <span class="info-item-hour"> من 8:00 ص - 3:00 م <i class="fas fa-clock"></i> </span>
                    </div>
                    <div class="d-flex gap-3">
                        <span class="contact-item-email"> sparkEducation.edu <i class="fas fa-envelope"></i></span>
                        <span class="contact-item-phone"> 0595838611 <i class="fas fa-phone"></i></span>
                    </div>
                </div>
            </div>

            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="container">
                    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('landingPage') }}">
                        <img src="{{ asset('assets/images/spark.png') }}" alt="Logo">
                    </a>


                    <div class="navbar-collapse-item" id="mainNavbar">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.html">{{ trans('main_trans.home') }}</a></li>
                            <li class="nav-item-lang dropdown lang-switcher">
                                <a class="nav-link lang-dropdown d-flex align-items-center gap-1" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (App::getLocale() == 'ar')
                                        <img src="{{ asset('assets/images/ar.png') }}" alt="arabic" width="20"
                                            class="lang-flag">
                                        {{-- {{ LaravelLocalization::getCurrentLocaleName() }} --}}
                                        العربية
                                    @else
                                        <img src="{{ asset('assets/images/en.png') }}" alt="english" width="20"
                                            class="lang-flag">
                                        {{ LaravelLocalization::getCurrentLocaleName() }}
                                    @endif
                                    <i class="fas fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-lang shadow-sm rounded">
                                    <li>
                                        <a class="dropdown-item dropdown-item-lang d-flex align-items-center"
                                            href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                                            <img src="{{ asset('assets/images/ar.png') }}" alt="ar"
                                                width="20"> العربية
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item dropdown-item-lang d-flex align-items-center"
                                            href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                                            <img src="{{ asset('assets/images/en.png') }}" alt="en"
                                                width="20"> English
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>

                </div>
            </nav>
        </div>

        @yield('login-content')

    </div>

    <!--- footer start-->
    <footer class="footer">

{!! trans('main_trans.footer_rights', ['brand' => '<span>Spark Education</span>']) !!}

    </footer>
    <!--- footer ends-->


    <!-- ربط ملف bootstrap JS المحلي -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
