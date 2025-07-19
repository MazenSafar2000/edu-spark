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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
    <!-- الهيدر -->
    <header class="header-page bg-white shadow fixed-top">

        <div class="header-row container-fluid d-flex align-items-center justify-content-between py-3 ">

            <!-- الشعار والقائمة الجانبية -->
            <div class="d-flex align-items-center logo-spark">
                <a href="{{ route('student.dashboard') }}" class="logo-link">
                    <img src="{{ asset('assets/images/spark.png') }}" alt="spark education">
                </a>

                <a href="#" id="sidebarToggle" title="{{ trans('main_trans.menu') }}"><i
                        class="fas fa-bars fa-lg me-3"></i></a>

            </div>

            <!-- القائمة اليسرى (أيقونات) -->
            <nav class="d-flex gap-4 ms-4 align-items-center">

                <div class="dropdown">
                    <a href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        title="الاشعارات">
                        <i class="fas fa-bell icon-header"></i>
                    </a>

                    <a href="#" class="dropdown-menu notification-dropdown text-end"
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
                        title="{{ trans('main_Trans.account') }}">
                        <i class="fas fa-user icon-header"></i>
                    </a>

                    <ul class="dropdown-menu account-dropdown text-end" aria-labelledby="userDropdown">
                        <li class="text-center">
                            <img src="{{ asset('assets/images/pic-1.jpg') }}" alt="user avatar"
                                class="rounded-circle user-img" style="width: 40px; height: 40px;">
                            <p class="user-name"> {{ auth()->user()->name }} </p>
                            <p class="user-type">{{ trans('Students_trans.student') }}</p>
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
    <div id="sidebarStd" class="sidebarStd bg-white shadow position-fixed end-0 vh-100 p-4">
        <div class="sidebar-std">

            <div class="widget">
                <h3>{{ trans('Students_trans.My_courses') }}</h3>
                <ul>
                    <li><a href="student-subject-data.html">
                            <span class="course-name"> رياضيات</span>
                            <span class="instructor-name">م. ميادة مغاري </span>
                        </a></li>

                    <li><a href="student-subject-data.html">
                            <span class="course-name"> لغة عربية</span>
                            <span class="instructor-name">م. ميادة مغاري </span>
                        </a></li>

                    <li><a href="student-subject-data.html">
                            <span class="course-name"> علوم</span>
                            <span class="instructor-name">م. ميادة مغاري </span>
                        </a></li>

                    <li><a href="student-subject-data.html">
                            <span class="course-name"> تنشئة</span>
                            <span class="instructor-name">م. ميادة مغاري </span>
                        </a></li>
                </ul>
            </div>

            <div class="widget">
                <h3>الأحداث القادمة</h3>
                <a href="student-exam-preview.html">اختبار لغة عربية <span>12-2-2026</span></a>
                <br>
                <a href="student-hw-preview.html">واجب رياضيات <span>12-2-2026</span></a>
            </div>


            <div class="mini-calendar">
                <div class="calendar-header">
                    <span onclick="changeMonth(-1)">‹</span>
                    <span id="mini-month-year">مايو 2025</span>
                    <span onclick="changeMonth(1)">›</span>
                </div>
                <div class="calendar-grid" id="mini-calendar-grid"></div>
            </div>
        </div>


    </div>



    @yield('student-content')




    <!-- زر فتح الرسائل باستخدام Bootstrap -->
    <button class="position-fixed  m-4 d-flex align-items-center gap-2 shadow open-msg-btn" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#messagesOffcanvas" aria-controls="messagesOffcanvas">
        <i class="fas fa-comments"></i>
    </button>

    <!-- Offcanvas الرسائل -->
    <div class="offcanvas offcanvas-bottom messages-panel" tabindex="-1" id="messagesOffcanvas"
        aria-labelledby="messagesOffcanvasLabel">
        <div class="offcanvas-header message-title text-white d-flex  justify-content-between align-items-center">
            <h5 class="offcanvas-title ms-auto">الرسائل</h5>
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
                    <img src="{{ asset('assets/images/pic-2.jpg')}}" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">لديك مهام جديدة</p>
                    </div>
                    <span>٣٠٠ س</span>
                </div>


                <div class="d-flex align-items-center border-bottom py-2 text-dark message-item"
                    style="cursor: pointer;" onclick="openChatPopup('المعلم')">
                    <img src="{{ asset('assets/images/pic-2.jpg')}}" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">لديك مهام جديدة</p>
                    </div>
                    <span>٣٠٠ س</span>
                </div>



                <div class="d-flex align-items-center border-bottom py-2 text-dark message-item"
                    style="cursor: pointer;" onclick="openChatPopup('المعلم')">
                    <img src="{{ asset('assets/images/pic-2.jpg')}}" alt="user" class="rounded-circle me-3"
                        style="width: 45px; height: 45px; object-fit: cover;">
                    <div class="msg-info text-end">
                        <strong class="d-block">المعلم</strong>
                        <p class="mb-0">لديك مهام جديدة</p>
                    </div>
                    <span>٣٠٠ س</span>
                </div>

                <div class="d-flex align-items-center border-bottom py-2 text-dark message-item"
                    style="cursor: pointer;" onclick="openChatPopup('المعلم')">
                    <img src="{{ asset('assets/images/pic-2.jpg')}}" alt="user" class="rounded-circle me-3"
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
            <button class="chat-close-button btn btn-sm btn-close" onclick="closeChatPopup()"></button>
            <span id="chatUserName" class="chat-username">المعلم</span>
        </div>

        <div class="chat-popup-body overflow-auto" id="chatBody">
            <div class="chat-msg-bot text-muted small">مرحباً! كيف يمكنني مساعدتك؟</div>
        </div>

        <div class="chat-popup-footer">
            <input type="text" class="chat-input form-control" placeholder="اكتب رسالة..."
                onkeydown="sendMessage(event)">
        </div>

    </div>


    <!-- Footer -->
    @if (App::getLocale() == 'en')
        <footer class="footer bg-white shadow fixed-bottom">
            &copy; {{ trans('main_trans.Copyright_by') }} <span>spark education</span> |
            {{ trans('main_trans.All_rights_reserved') }}
        </footer>
    @else
        <footer class="footer bg-white shadow fixed-bottom">
            &copy; {{ trans('main_trans.All_rights_reserved') }} | <span>spark education</span>
            {{ trans('main_trans.Copyright_by') }}
        </footer>
    @endif


    <!-- ربط ملف bootstrap JS المحلي -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/script2.js') }}"></script> --}}
</body>

</html>
