@extends('layouts.landingPageHead')
@section('landing-content')
    <div class="landing-page">

        {{-- Page Header --}}
        <div class="header-landing">
            <div class="top-header">
                <div class="container d-flex flex-wrap justify-content-between align-items-center ">
                    <div class="d-flex gap-3 flex-wrap">
                        <span class="info-item-location">{{ trans('main_trans.palestine_gaza') }}<i
                                class="fas fa-map-marker-alt"></i></span>

                        <span class="info-item-hour">{{ trans('main_trans.working_hours') }}<i class="fas fa-clock"></i>
                        </span>
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
                    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                        <img src="{{ asset('assets/images/spark.png') }}" alt="Logo">
                    </a>

                    <button class="navbar-toggler" type="button" aria-controls="mainNavbar" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="fas fa-bars fa-lg"></span>
                    </button>



                    <div class="navbar-collapse-item" id="mainNavbar">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link active"
                                    href="#">{{ trans('main_trans.home') }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#offer">{{ trans('main_trans.offers') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#about">{{ trans('main_trans.About_us') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link"
                                    href="#contact">{{ trans('main_trans.Contact_us') }}</a></li>


                            <li class="nav-item-lang dropdown lang-switcher">
                                <a class="nav-link lang-dropdown d-flex align-items-center gap-1" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if (App::getLocale() == 'ar')
                                        <img src="{{ asset('assets/images/ar.png') }}" alt="arabic" width="20"
                                            class="lang-flag">
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
                                            <img src="{{ asset('assets/images/ar.png') }}" alt="ar" width="20">
                                            العربية
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item dropdown-item-lang d-flex align-items-center"
                                            href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                                            <img src="{{ asset('assets/images/en.png') }}" alt="en" width="20">
                                            English
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

        </div>

        <section class="hero-section">
            <div class="container">
                <div class="row hero-row">
                    <!-- الصورة -->
                    <div class="col-lg-6 text-center hero-image-box">
                        <img src="{{ asset('assets/images/child-index.webp') }}" alt="طالبة تحمل جهاز لوحي">
                    </div>

                    <!-- النص -->
                    <div class="col-lg-6 hero-text-box">
                        <p class="hero-text mb-2">{{ trans('main_trans.Comprehensive_Sys') }}</p>
                        <h1 class="hero-title">{!! trans('main_trans.hero_title', [
                            'highlight' => '<span class="highlight">' . trans('main_trans.smart_learning') . '</span>',
                        ]) !!}</h1>
                        <p class="hero-description">
                            {!! trans('main_trans.hero_description', ['brand' => '<span>Spark Education</span>']) !!}
                        </p>
                        <a href="{{ route('login.student_parent') }}" class="btn hero-btn">
                            <span>{{ trans('main_trans.start_now') }}</span>
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!-- الإحصائيات مدمجة بصريًا -->
            <div class="stats-boxes">
                <div class="container">
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-3 col-6">
                            <div class="stats-item d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/manager.png') }}" alt="manager" class="stats-icon">
                                <div class="stats-content">
                                    <h5>10k+</h5>
                                    <p>{{ trans('main_trans.School_Principals') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-item d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/teacher.png') }}" alt="treacher" class="stats-icon">
                                <div class="stats-content">
                                    <h5>10k+</h5>
                                    <p>{{ trans('main_trans.Teachers') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-item d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/std-on.png') }}" alt="student" class="stats-icon">
                                <div class="stats-content">
                                    <h5>10k+</h5>
                                    <p>{{ trans('main_trans.Students') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-item d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/par-on.png') }}" alt="parent" class="stats-icon">
                                <div class="stats-content">
                                    <h5>10k+</h5>
                                    <p>{{ trans('main_trans.Parents') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>

        <section class="feature-section" id="offer">
            <div class="container">
                <div class="row align-items-center g-4">

                    <!-- النص -->
                    <div class="col-lg-5">
                        <div class="paragraph-box  p-5 rounded ms-auto my-3 me-5">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <img src="{{ asset('assets/images/question.png') }}" alt="أيقونة" width="35">
                                <h3>{{ trans('main_trans.what_we_offer') }}</h3>
                            </div>
                            <ul>
                                <li>{{ trans('main_trans.Interactive_live') }}</li>
                                <li>{{ trans('main_trans.Advanced_tools') }}</li>
                                <li>{{ trans('main_trans.dedicated_parent_portal') }}</li>
                                <li>{{ trans('main_trans.simple_and_intuitive') }}</li>
                                <li>{{ trans('main_trans.secure_and_flexible') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- البطاقات -->
                    <div class="col-lg-7">
                        <div class="row g-3">

                            <div class="col-lg-5 col-md-4 col-sm-6">
                                <div class="card feature-card-bg">
                                    <i class="fas fa-laptop-code feature-icon"></i>
                                    <div class="feature-content">
                                        <h5>{{ trans('main_trans.Smart_Environment') }}</h5>
                                        <p>{{ trans('main_trans.Live_and_recorded') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-4 col-sm-6">
                                <div class="card feature-card">
                                    <i class="fas fa-chalkboard-teacher feature-icon"></i>
                                    <div class="feature-content">
                                        <h5>{{ trans('main_trans.Comprehensive_Teacher_Platform') }}</h5>
                                        <p>{{ trans('main_trans.Advanced_tools_create_content') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-4 col-sm-6">
                                <div class="card feature-card">
                                    <i class="fas fa-user-shield feature-icon"></i>
                                    <div class="feature-content">
                                        <h5>{{ trans('main_trans.Parental_Engagement') }}</h5>
                                        <p>{{ trans('main_trans.dedicated_portal') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-4 col-sm-6">
                                <div class="card feature-card-bg">
                                    <i class="fas fa-shield-alt feature-icon"></i>
                                    <div class="feature-content">
                                        <h5>{{ trans('main_trans.Simple_Secure_Interface') }}</h5>
                                        <p>{{ trans('main_trans.intuitive_platform') }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="team-section" id="about">
            <div class="container text-center">
                <h2 class="team-title">{{ trans('main_trans.work_team') }}</h2>

                <p class="team-description">{{ trans('main_trans.work_team_paragrpah') }}</p>

                <div class="team-card row justify-content-center g-4">
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">{{ trans('main_trans.noor') }}</h5>
                            <small class="member-job">{{ trans('main_trans.Interface_design') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">{{ trans('main_trans.mazen') }}</h5>
                            <small class="member-job">{{ trans('main_trans.System_programming') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">{{ trans('main_trans.mostafa') }}</h5>
                            <small class="member-job">{{ trans('main_trans.System_programming') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">{{ trans('main_trans.muntaha') }}</h5>
                            <small class="member-job">{{ trans('main_trans.System_analysis') }}</small>
                        </div>
                    </div>

        </section>

        <section class="contact-modern" id="contact">
            <div class="container">
                <div class="row align-items-center g-4 contact-box">

                    <div class="col-md-7 pe-md-5">
                        <h2 class="fw-bold contact-title">{{ trans('main_trans.Contact_us') }}</h2>
                        <p class="contact-description">{{ trans('main_trans.Do_not_hesitate') }}</p>
                        <form>
                            <input type="text" class="form-control contact-input"
                                placeholder="{{ trans('main_trans.name') }}">
                            <input type="email" class="form-control contact-input"
                                placeholder="{{ trans('main_trans.email') }}">
                            <textarea class="form-control contact-textarea" placeholder="{{ trans('main_trans.Write_your_message') }}"
                                rows="3"></textarea>
                            <button class="send-btn">{{ trans('main_trans.send') }}</button>
                        </form>
                    </div>
                    <div class="col-md-5 position-relative info-box d-flex justify-content-between ">
                        <div class="info-box-text">
                            <h5 class="mb-4">معلومات عن النظام</h5>
                            <p><i class="fas fa-envelope"></i> sparkEducation@edu</p>
                            <p><i class="fas fa-phone"></i> +24 56 89 146</p>
                            <p><i class="fas fa-map-marker-alt"></i>{{ trans('main_trans.palestine_gaza') }}</p>
                            <p><i class="fas fa-clock"></i>{{ trans('main_trans.working_hours') }}</p>
                        </div>

                        <div class="info-box-img">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" width="120">
                        </div>

                    </div>

                </div>
            </div>
        </section>


        <!--- footer start-->
        <footer class="footer-index">
            <h1>{!! trans('main_trans.footer_rights', ['brand' => '<span>Spark Education</span>']) !!}</h1>
            <img src="{{ asset('assets/images/s.png') }}" alt="">
        </footer>
        <!--- footer ends-->

    </div>
@endsection
