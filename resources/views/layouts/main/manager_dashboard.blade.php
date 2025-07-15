<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

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
    <header class="header-page bg-white shadow fixed-top">
        <div class="header-row container-fluid d-flex align-items-center justify-content-between py-3 ">
            <div class="d-flex align-items-center logo-spark">
                <a href="{{ route('manager.dashboard') }}" class="logo-link">
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
    </header>

    <!-- الشريط الجانبي -->
    <div id="sidebar" class="sidebar bg-white shadow position-fixed end-0 vh-100 p-4">
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('manager.dashboard') }}" class="">
                    <span>{{ trans('main_trans.Dashboard') }}</span>
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('Subjects.index') }}">
                    <span>{{ trans('main_trans.subjects') }}</span>
                    <i class="fas fa-book"></i>
                </a>
            </li>
            <li class="dropdown-sidebar">
                <a href="#" class="dropdown-toggle-custom d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#studentsMenu" aria-expanded="false">

                    <i class="toggle-icon fas fa-plus"></i>
                    <div class="d-flex align-items-center gap-2">
                        <span>{{ trans('main_trans.Students') }}</span>
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </a>

                <ul id="studentsMenu" class="collapse list-unstyled ps-4 mt-2">
                    <li><a href="{{ route('Students.index') }}"
                            class="{{ request()->routeIs('Students.index') ? 'active' : '' }}">{{ trans('main_trans.Students') }}</a>
                    </li>
                    <li><a href="manager-graduated.html">الخريجين</a></li>
                    <li><a href="manager-promotion.html">الترقيات</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('Teachers.index') }}">
                    <span>{{ trans('main_trans.Teachers') }}</span>
                    <i class="fas fa-chalkboard-teacher"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('Parents.index') }}">
                    <span>{{ trans('main_trans.Parents') }}</span>
                    <i class="fas fa-user-shield"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('Grades.index') }}">
                    <span>{{ trans('main_trans.Grades') }}</span>
                    <i class="fas fa-graduation-cap"></i>
                </a>
            </li>
            <li>
                <a href="manager-study-content.html">
                    <span>{{ trans('main_trans.Academic_content') }}</span>
                    <i class="fas fa-book-reader"></i>
                </a>
            </li>
            <li>
                <a href="manager-meet.html">
                    <span>{{ trans('main_trans.Onlineclasses') }}</span>
                    <i class="fas fa-video"></i>
                </a>
            </li>
            <li>
                <a href="manager-setting.html">
                    <span>الاعدادات</span>
                    <i class="fa-solid fa-cogs"></i>

                </a>
            </li>
            <li>
                <a href="manager-profile.html">
                    <span>الملف الشخصي</span>
                    <i class="fa-solid fa-user"></i>

                </a>
            </li>
        </ul>

    </div>

    @yield('manager_content')


    <!-- زر فتح الرسائل باستخدام Bootstrap -->
    <button class="btn btn-primary position-fixed  m-4 d-flex align-items-center gap-2 shadow open-msg-btn"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#messagesOffcanvas"
        aria-controls="messagesOffcanvas">
        <i class="fas fa-message"></i>
        <span class="msg-label">الرسائل</span>
    </button>

    <!-- Offcanvas الرسائل -->
    <div class="offcanvas offcanvas-bottom messages-panel" tabindex="-1" id="messagesOffcanvas"
        aria-labelledby="messagesOffcanvasLabel">
        <div
            class="offcanvas-header message-title text-white d-flex flex-row-reverse justify-content-between align-items-center">
            <h5 class="offcanvas-title ms-auto">الرسائل</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="إغلاق"></button>
        </div>


        <div class="offcanvas-body d-flex flex-column p-0">
            <div class="messages-body overflow-auto flex-grow-1 p-3">
                <!-- عنصر رسالة -->
                <a href="manager_chat.html"
                    class="d-flex align-items-center border-bottom py-2 text-decoration-none text-dark message-item">
                    <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                    </div>
                    <span>٣٠٠ س</span>
                </a>

                <a href="manager_chat.html"
                    class="d-flex align-items-center border-bottom py-2 text-decoration-none text-dark message-item">
                    <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                    </div>
                    <span>٣٠٠ س</span>
                </a>


                <a href="manager_chat.html"
                    class="d-flex align-items-center border-bottom py-2 text-decoration-none text-dark message-item">
                    <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                    </div>
                    <span>٣٠٠ س</span>
                </a>

                <a href="manager_chat.html"
                    class="d-flex align-items-center border-bottom py-2 text-decoration-none text-dark message-item">
                    <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">يوجد طالب جديد يريد التسجيل في النظام</p>
                    </div>
                    <span>٣٠٠ س</span>
                </a>
                <!-- يمكنك إضافة المزيد من الرسائل هنا -->
            </div>
            <div class="message-footer text-center">
                <a href="manager_chat.html" class="text-decoration-none ">إظهار جميع الرسائل</a>
            </div>
        </div>
    </div>

    <!--- footer start-->
    <footer class="footer bg-white shadow fixed-bottom">

        &copy; جميع الحقوق محفوظة | <span>spark eucation</span> حقوق الطبع والنشر بواسطة

    </footer>
    <!--- footer ends-->

    <!-- ربط ملف bootstrap JS المحلي -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/script2.js') }}"></script> --}}
</body>

</html>
