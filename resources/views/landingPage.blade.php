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
                        <p class="hero-text mb-2">نظام تعليمي متكامل</p>
                        <h1 class="hero-title">نصنع تجربة <span class="highlight">تعليم ذكية</span></h1>
                        <p class="hero-description">
                            منصة <span>Spark Education </span>تربط بين الطالب والمعلم وولي الأمر والمدير ضمن بيئة رقمية
                            سهلة وآمنة لإدارة كافة تفاصيل التعليم الحديث
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
                                <img src="{{ asset('assets/images/manager.png') }}" alt="مدير" class="stats-icon">
                                <div class="stats-content">
                                    <h5>10k+</h5>
                                    <p>{{ trans('main_trans.School_Principals') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-item d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/teacher.png') }}" alt="معلم" class="stats-icon">
                                <div class="stats-content">
                                    <h5>10k+</h5>
                                    <p>{{ trans('main_trans.Teachers') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-item d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/std-on.png') }}" alt="طالب" class="stats-icon">
                                <div class="stats-content">
                                    <h5>10k+</h5>
                                    <p>{{ trans('main_trans.Students') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stats-item d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/par-on.png') }}" alt="ولي أمر" class="stats-icon">
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
                                <h3>ماذا نقدم ؟</h3>
                            </div>
                            <ul>
                                <li>دروس تفاعلية مباشرة ومسجلة تتيح للطلاب التعلم في أي وقت ومن أي مكان.</li>
                                <li>أدوات متقدمة للمعلمين لإعداد المحتوى، إدارة الاختبارات، وتصحيحها بسهولة.</li>
                                <li>منصة أولياء الأمور لمتابعة تقدم أبنائهم ومشاركتهم في العملية التعليمية.</li>
                                <li>واجهة بسيطة وسهلة الاستخدام تدعم اللغة العربية، وتناسب مختلف الأعمار.</li>
                                <li>نظام آمن ومرن يعمل حتى في ظل ضعف الاتصال بالإنترنت أو الظروف الصعبة.</li>
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
                                        <h5>بيئة تعليمية ذكية</h5>
                                        <p>دروس تفاعلية مباشرة ومسجلة تتيح للطلبة التعلم من أي مكان وفي أي وقت.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-4 col-sm-6">
                                <div class="card feature-card">
                                    <i class="fas fa-chalkboard-teacher feature-icon"></i>
                                    <div class="feature-content">
                                        <h5>منصة متكاملة للمعلمين</h5>
                                        <p>أدوات إعداد المحتوى، إدارة الاختبارات وتصحيحها بسهولة واحترافية.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-4 col-sm-6">
                                <div class="card feature-card">
                                    <i class="fas fa-user-shield feature-icon"></i>
                                    <div class="feature-content">
                                        <h5>دعم أولياء الأمور</h5>
                                        <p>منصة تتيح للآباء متابعة أبنائهم والمشاركة في العملية التعليمية.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-4 col-sm-6">
                                <div class="card feature-card-bg">
                                    <i class="fas fa-shield-alt feature-icon"></i>
                                    <div class="feature-content">
                                        <h5>واجهة سهلة وآمنة</h5>
                                        <p>واجهة بسيطة تعمل حتى في ظل ضعف الإنترنت أو الظروف الصعبة.</p>
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

                <p class="team-description">
                    تم تطوير نظام <span> Spark Education</span> بأيدٍ شابة مبدعة من خريجي تخصص تكنولوجيا الويب وأمن
                    المعلومات، ضمن مشروع تخرج جامعي تحت إشراف نُخبة من أساتذة الجامعة.

                    عمل الفريق على تصميم نظام تعليمي ذكي يجمع بين الكفاءة التقنية وسهولة الاستخدام، بهدف إحداث نقلة
                    نوعية في بيئة التعليم الرقمي.

                    نحن لا نقدّم مجرد نظام إلكتروني، بل نضع بين أيديكم رؤية جيلٍ يؤمن بأن المعرفة حقّ، وأن التكنولوجيا
                    بوابتنا نحو تعليم أكثر عدالة وفاعلية.
                </p>

                <div class="team-card row justify-content-center g-4">
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">نور تمراز</h5>
                            <small class="member-job">تصميم الواجهات</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">مازن أبو صفر</h5>
                            <small class="member-job">برمجة النظام</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">مصطفى أبو مهادي</h5>
                            <small class="member-job">برمجة النظام</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="team-member rounded">
                            <h5 class="member-name">منتهى دوحان</h5>
                            <small class="member-job">تحليل النظام</small>
                        </div>
                    </div>

        </section>

        <section class="contact-modern" id="contact">
            <div class="container">
                <div class="row align-items-center g-4 contact-box">

                    <div class="col-md-7 pe-md-5">
                        <h2 class="fw-bold contact-title">{{ trans('main_trans.Contact_us') }}</h2>
                        <p class="contact-description">لا تترددوا في التواصل معنا في أي وقت. سنرد عليكم في أقرب وقت ممكن!
                        </p>
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
                            <p><i class="fas fa-clock"></i> 08:00 am - 03:00 pm</p>
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
            <h1>&copy; جميع الحقوق محفوظة | <span>spark eucation</span> حقوق الطبع والنشر بواسطة </h1>
            <img src="{{ asset('assets/images/s.png') }}" alt="">
        </footer>
        <!--- footer ends-->

    </div>
@endsection
