<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spark Education</title>
    <link rel="icon" href="{{ asset('assets/images/logo-dark.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet" />

    <!-- Font Awesome & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Rubik:ital,wght@0,300..900;1,300..900&family=Square+Peg&display=swap"
        rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.App = {
            userId: {{ auth()->id() ?? 'null' }}
        }
    </script>
    @vite(['resources/js/app.js'])


    <!-- Custom CSS -->
    @if (App::getLocale() == 'en')
        <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">
    @else
        <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
    @endif
</head>

<body>
    <!-- header -->
    <header class="header-page bg-white shadow fixed-top">
        <div class="top-header-dashboard">
            <div class=" d-flex flex-wrap justify-content-between align-items-center ">
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
        <div class="header-row container-fluid d-flex align-items-center justify-content-between py-3 ">
            <!-- الشعار والقائمة الجانبية -->
            <div class="d-flex align-items-center logo-spark">
                <a href="{{ route('manager.dashboard') }}">
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
                            aria-expanded="false" title="{{ trans('Sidebar_trans.Notifications') }}"
                            class="position-relative">
                            <i class="fas fa-bell icon-header"></i>
                            <!-- النقطة الحمراء على الأيقونة -->
                            <span id="notif-dot"
                                class="notification-dot @if (auth()->user()->unreadNotifications()->count() == 0) d-none @endif"></span>
                        </a>
                        <div class="dropdown-menu notification-dropdown text-end"
                            aria-labelledby="notificationsDropdown">
                            <h6 class="notification-title d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="d-flex align-items-center gap-2">
                                    {{ trans('Sidebar_trans.Notifications') }}
                                    <span class="badge badge-number text-white"
                                        id="notif-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
                                </div>
                                <form action="{{ route('notifications.readAll') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm btn-link  mark-read-btn mark-all-read">{{ trans('main_trans.mark_all_read') }}</button>
                                </form>
                            </h6>

                            <div id="notif-list" class="notification-list">
                                @forelse (auth()->user()->unreadNotifications as $notification)
                                    <div class="notification-content">
                                        <a href="{{ $notification->data['url'] ?? '#' }}"
                                            class="notification-info text-end">
                                            <p class="mb-0">{{ $notification->data['message'] ?? 'Notification' }} -
                                                {{ $notification->data['title'] ?? '' }}</p>
                                        </a>
                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <div class="notification-footer">{{ trans('main_trans.no_notifications') }}</div>
                                @endforelse
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
                                <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="avatar"
                                    class="rounded-circle user-img" style="width: 40px; height: 40px;">
                                <p class="user-name">{{ Auth::user()->name }}</p>
                                <p class="user-type">{{ trans('main_trans.manager') }}</p>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
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
            </nav>
        </div>
    </header>

    <div id="sidebar" class="sidebar bg-white shadow position-fixed end-0 vh-100 p-4">
        <ul class="list-unstyled">

            <li>
                <a href="{{ route('manager.dashboard') }}">
                    <span>{{ trans('main_trans.Dashboard') }}</span>
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <!-- عنصر الطلاب مع قائمة تظهر وتختفي -->
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
                    <li><a href="{{ route('Students.index') }}">{{ trans('main_trans.Students') }}</a></li>
                    <li><a href="{{route('Promotion.index')}}">{{trans('main_trans.Students_Promotions')}}</a></li>
                    <li><a href="manager-graduated.html">الخريجين</a></li>
                    {{-- <li><a href="manager-std-record.html">السجل</a></li> --}}
                </ul>
            </li>

            <li class="dropdown-sidebar">
                <a href="#" class="dropdown-toggle-custom d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#techaersMenu" aria-expanded="false">

                    <i class="toggle-icon fas fa-plus"></i>
                    <div class="d-flex align-items-center gap-2">
                        <span>{{ trans('main_trans.Teachers') }}</span>
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </a>

                <ul id="techaersMenu" class="collapse list-unstyled ps-4 mt-2">
                    <li><a href="{{ route('Teachers.index') }}">{{ trans('main_trans.Current_Teachers') }}</a></li>
                    <li><a href="manager-teacher.html">{{ trans('main_trans.All_Teachers') }}</a></li>
                    <li><a href="manager-teacher-record.html">{{ trans('main_trans.history') }}</a></li>
                </ul>
            </li>


            <li>
                <a href="{{ route('Parents.index') }}">
                    <span>{{ trans('main_trans.Parents') }}</span>
                    <i class="fas fa-user-shield"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('Subjects.index') }}">
                    <span>{{ trans('main_trans.subjects') }}</span>
                    <i class="fas fa-book"></i>
                </a>
            </li>

            <li>
                <a href="{{ route('Grades.index') }}">
                    <span>{{ trans('main_trans.Academic_stages') }}</span>
                    <i class="fas fa-graduation-cap"></i>
                </a>
            </li>

            <li>
                <a href="manager-study-content.html">
                    <span>المحتوى الدراسي</span>
                    <i class="fas fa-book-reader"></i>
                </a>
            </li>

            <li class="dropdown-sidebar">
                <a href="#" class="dropdown-toggle-custom d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#questionMenu" aria-expanded="false">

                    <i class="toggle-icon fas fa-plus"></i>
                    <div class="d-flex align-items-center gap-2">
                        <span>الاسئلة</span>
                        <i class="fas fa-question-circle"></i>
                    </div>
                </a>

                <ul id="questionMenu" class="collapse list-unstyled ps-4 mt-2">
                    <li><a href="manager-question-bank.html">بنك الاسئلة</a></li>
                    <li><a href="manager-question-category.html">اقسام الاسئلة</a></li>
                </ul>
            </li>


            <li>
                <a href="manager-meet.html">
                    <span>اللقاءات المباشرة</span>
                    <i class="fas fa-video"></i>
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

    <!--- footer start-->
    <footer class="footer bg-white shadow fixed-bottom">
        {!! trans('main_trans.footer_rights', ['brand' => '<span>Spark Education</span>']) !!}
    </footer>
    <!--- footer ends-->

    <script>
        function relTime(ts) {
            const d = new Date(ts);
            const diff = Math.floor((Date.now() - d.getTime()) / 1000);
            if (diff < 60) return `${diff}s`;
            if (diff < 3600) return `${Math.floor(diff/60)}m`;
            if (diff < 86400) return `${Math.floor(diff/3600)}h`;
            return `${Math.floor(diff/86400)}d`;
        }

        function refreshTimes() {
            document.querySelectorAll('#notif-list time').forEach((t) => {
                const ts = t.getAttribute('data-ts') || t.getAttribute('title');
                if (ts) t.textContent = relTime(ts);
            });
        }
        setInterval(refreshTimes, 60_000);
        document.addEventListener('DOMContentLoaded', refreshTimes);
    </script>

    <!-- Bootstrap JS (includes Popper) -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- jQuery (only if really needed, before any DOM manipulation scripts) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    @yield('js')

</body>

</html>
