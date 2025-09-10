<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

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
    <!-- header -->
    {{-- <header class="header-page bg-white shadow fixed-top">
        <div class="header-row container-fluid d-flex align-items-center justify-content-between py-3 ">
            <div class="d-flex align-items-center logo-spark">
                <a href="{{ route('teacher.dashboard') }}" class="logo-link">
                    <img src="{{ asset('assets/images/spark.png') }}" alt="spark education">
                </a>
                <a href="#" id="sidebarToggle" title="menu"><i class="fas fa-bars fa-lg me-3"></i></a>
            </div>

            <nav class="d-flex gap-4 ms-4 align-items-center">

                <div class="dropdown">
                    <a href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        title="notifications">
                        <i class="fas fa-bell icon-header"></i>
                    </a>

                    <a href="manager_chat.html" class="dropdown-menu notification-dropdown text-end"
                        aria-labelledby="userDropdown">

                        <h6 class="notification-title">الاشعارات</h6>

                        <div class="notification-content">
                            <div class="notification-info text-end">
                                <strong class="d-block">المعلم</strong>
                                <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                            </div>
                            <span>٣٠٠ س</span>

                        </div>

                        <div class="notification-content">
                            <div class="notification-info text-end">
                                <strong class="d-block">المعلم</strong>
                                <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                            </div>
                            <span>٣٠٠ س</span>

                        </div>

                    </a>


                </div>

                <!-- القائمة المنسدلة للحساب -->
                <div class="dropdown">
                    <a href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        title="الحساب">
                        <i class="fas fa-user icon-header"></i>
                    </a>

                    <ul class="dropdown-menu account-dropdown text-end" aria-labelledby="userDropdown">
                        <li class="text-center">
                            <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="user avatar"
                                class="rounded-circle user-img" style="width: 40px; height: 40px;">
                            <p class="user-name"> {{ auth()->user()->name }} </p>
                            <p class="user-type">{{ trans('main_trans.manager') }}</p>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ trans('main_trans.logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <a href="{{ LaravelLocalization::getLocalizedURL(App::getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}"
                    title="{{ trans('main_trans.change_lang') }}"><i class="fas fa-language icon-header"></i></a>
            </nav>

        </div>
    </header> --}}
    <header class="header-page bg-white shadow fixed-top">

        <div class="top-header-dashboard">
            <div class=" d-flex flex-wrap justify-content-between align-items-center ">


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

        <div class="header-row container-fluid d-flex align-items-center justify-content-between py-3 ">



            <!-- الشعار والقائمة الجانبية -->
            <div class="d-flex align-items-center logo-spark">
                <a href="{{ route('teacher.dashboard') }}">
                    <img src="{{ asset('assets/images/spark.png') }}" alt="spark education" class="logo">
                </a>

                <a href="#" id="sidebarToggle" title="{{ trans('main_trans.menu') }}"><i
                        class="fas fa-bars fa-lg me-3"></i></a>

            </div>

            <!-- القائمة اليسرى (أيقونات) -->
            <nav class="d-flex gap-4 ms-4 align-items-center">

                <ul class="d-flex gap-4 ms-4 align-items-center list-unstyled m-0">
                    <!-- الإشعارات -->
                    <li class="dropdown">
                        <a href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" title="{{ trans('main_trans.notifications') }}">
                            <i class="fas fa-bell icon-header"></i>
                        </a>
                        <div class="dropdown-menu notification-dropdown text-end"
                            aria-labelledby="notificationsDropdown">
                            <h6 class="notification-title">{{ trans('main_trans.notifications') }}</h6>

                            <div class="notification-content">
                                <div class="notification-info text-end">
                                    <strong class="d-block">المعلم</strong>
                                    <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                                </div>
                                <span>٣٠٠ س</span>
                            </div>

                            <div class="notification-content">
                                <div class="notification-info text-end">
                                    <strong class="d-block">المعلم</strong>
                                    <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                                </div>
                                <span>٣٠٠ س</span>
                            </div>
                        </div>
                    </li>

                    <!-- الحساب -->
                    <li class="dropdown">
                        <a href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" title="الحساب">
                            <i class="fas fa-user icon-header"></i>
                        </a>
                        <ul class="dropdown-menu account-dropdown text-end" aria-labelledby="accountDropdown">
                            <li class="text-center">
                                <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="صورة المستخدم"
                                    class="rounded-circle user-img" style="width: 40px; height: 40px;">
                                <p class="user-name">{{ auth()->user()->name }}</p>
                                <p class="user-type">{{ trans('Teacher_trans.teacher') }}</p>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                {{-- <form action="">
                                    <button type="submit" class="dropdown-item"><i
                                            class="fas fa-sign-out-alt"></i>تسجيل الخروج</button>
                                </form> --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i
                                            class="fas fa-sign-out-alt"></i>{{ trans('main_trans.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item-lang dropdown lang-switcher">
                        <a class="nav-link lang-dropdown d-flex align-items-center gap-1" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
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


            </nav>

        </div>
    </header>

    <!-- الشريط الجانبي -->
    <div id="sidebar" class="sidebar bg-white shadow position-fixed end-0 vh-100 p-4">
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('teacher.dashboard') }}" class="">
                    <span>{{ trans('main_trans.Dashboard') }}</span>
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('students.index') }}">
                    <span>{{ trans('main_trans.Students') }}</span>
                    <i class="fas fa-book-reader"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('sections') }}">
                    <span>{{ trans('main_trans.Academic_stages') }}</span>
                    <i class="fas fa-graduation-cap"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('library.index') }}">
                    <span>{{ trans('main_trans.library') }}</span>
                    <i class="fas fa-book-reader"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('exams.index') }}">
                    <span>{{ trans('main_trans.Exams') }}</span>
                    <i class="fa fa-pen-to-square"></i>
                </a>
            </li>

            <li class="dropdown-sidebar">
                <a href="#" class="dropdown-toggle-custom d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#questionsMenu" aria-expanded="false">

                    <i class="toggle-icon fas fa-plus"></i>
                    <div class="d-flex align-items-center gap-2">
                        <span>{{ trans('main_trans.questions') }}</span>
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </a>

                <ul id="questionsMenu" class="collapse list-unstyled ps-4 mt-2">
                    <li>
                        <a href="{{ route('questionsBank.index') }}">{{ trans('Teacher_trans.questionBank') }}</a>
                    </li>
                    <li>
                        <a
                            href="{{ route('questionsCategotry.index') }}">{{ trans('Teacher_trans.questions_categories') }}</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('homeworks.index') }}">
                    <span> {{ trans('Teacher_trans.Homeworks') }}</span>
                    <i class="fa fa-tasks"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('recordedClasses.index') }}">
                    <span>{{ trans('Teacher_trans.recorded_classes') }}</span>
                    <i class="fas fa-play-circle"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('ZoomClasses.index') }}">
                    <span>{{ trans('Teacher_trans.Online_classes') }}</span>
                    <i class="fas fa-video"></i>
                </a>
            </li>

            <li>
                <a href="teacher-profile.html">
                    <span>{{ trans('Teacher_trans.profile') }}</span>
                    <i class="fa-solid fa-user"></i>

                </a>
            </li>
        </ul>
    </div>

    @yield('teacher_content')

    <!-- زر فتح الرسائل باستخدام Bootstrap -->
    <button class="position-fixed  m-4 d-flex align-items-center gap-2 shadow open-msg-btn" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#messagesOffcanvas" aria-controls="messagesOffcanvas">
        <i class="fas fa-comments"></i>
    </button>

    <!-- Offcanvas الرسائل -->
    <div class="offcanvas offcanvas-bottom messages-panel" tabindex="-1" id="messagesOffcanvas"
        aria-labelledby="messagesOffcanvasLabel">

        <div class="chat-popup-header d-flex justify-content-between align-items-center">

            <span id="chatUserName" class="chat-username">الرسائل</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="إغلاق"></button>

        </div>




        <div class="offcanvas-body d-flex flex-column p-0">
            <div>
                <input type="text" class="form-control search-msg" placeholder="ابحث ...">
            </div>

            <div class="messages-body overflow-auto flex-grow-1 p-3">
                <!-- عنصر رسالة -->
                <div class="d-flex align-items-center border-bottom py-2 text-dark message-item"
                    style="cursor: pointer;" onclick="openChatPopup('المعلم')">
                    <img src="../images/pic-2.jpg" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">لديك مهام جديدة</p>
                    </div>
                    <span>٣٠٠ س</span>
                </div>


                <div class="d-flex align-items-center border-bottom py-2 text-dark message-item"
                    style="cursor: pointer;" onclick="openChatPopup('المعلم')">
                    <img src="../images/pic-2.jpg" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">لديك مهام جديدة</p>
                    </div>
                    <span>٣٠٠ س</span>
                </div>



                <div class="d-flex align-items-center border-bottom py-2 text-dark message-item"
                    style="cursor: pointer;" onclick="openChatPopup('المعلم')">
                    <img src="../images/pic-2.jpg" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">لديك مهام جديدة</p>
                    </div>
                    <span>٣٠٠ س</span>
                </div>

                <div class="d-flex align-items-center border-bottom py-2 text-dark message-item"
                    style="cursor: pointer;" onclick="openChatPopup('المعلم')">
                    <img src="../images/pic-2.jpg" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">لديك مهام جديدة</p>
                    </div>
                    <span>٣٠٠ س</span>
                </div>

                <!-- يمكنك إضافة المزيد من الرسائل هنا -->
            </div>
        </div>
    </div>



    <!-- نافذة المحادثة المنبثقة -->
    <div class="card-message chat-popup-wrapper position-fixed bottom-0 shadow" id="chatPopup"
        style="display: none;">

        <div class="chat-popup-header d-flex justify-content-between align-items-center">

            <span id="chatUserName" class="chat-username">المعلم</span>
            <button class="chat-close-button btn btn-sm btn-close" onclick="closeChatPopup()"></button>
        </div>

        <div class="chat-popup-body overflow-auto" id="chatBody">
            <div class="chat-msg-bot text-muted small">مرحباً! كيف يمكنني مساعدتك؟</div>
        </div>

        <div class="chat-popup-footer">
            <input type="text" class="chat-input form-control" placeholder="اكتب رسالة..."
                onkeydown="sendMessage(event)">
        </div>

    </div>



    <!--- footer start-->
    <footer class="footer bg-white shadow fixed-bottom">
        {!! trans('main_trans.footer_rights', ['brand' => '<span>Spark Education</span>']) !!}
    </footer>
    <!--- footer ends-->


    <!-- ربط ملف bootstrap JS المحلي -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/filters.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/script2.js') }}"></script> --}}

    @yield('js')

</body>

</html>
