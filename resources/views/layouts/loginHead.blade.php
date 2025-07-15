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
    <header class="header-page bg-white shadow fixed-top">
        <div class="header-row container-fluid d-flex align-items-center justify-content-between py-3">

            <!-- القائمة اليسرى (أيقونات) -->
            <nav class="d-flex gap-4 ms-4">
                <a href="{{ LaravelLocalization::getLocalizedURL(App::getLocale() == 'ar' ? 'en' : 'ar', null, [], true) }}"
                    title="{{ trans('main_trans.change_lang') }}"><i class="fas fa-language icon-header"></i></a>
                <a href="{{ route('aboutUs') }}" title="{{ trans('main_trans.Contact_us') }}"><i
                        class="fas fa-question icon-header {{ request()->routeIs('aboutUs') ? 'active' : '' }}"></i></a>
                <a href="#" title="{{ trans('main_trans.Contact_us') }}"><i
                        class="fas fa-phone icon-header"></i></a>

            </nav>

            <!-- الشعار على اليمين -->
            <a href="{{ route('loginpage') }}">
                <img src="{{ asset('assets/images/spark.png') }}" alt="spark education">
            </a>
        </div>
    </header>


    @yield('content')


    <!--- footer start-->
    <footer class="footer">

        &copy; جميع الحقوق محفوظة | <span>spark eucation</span> حقوق الطبع والنشر بواسطة

    </footer>
    <!--- footer ends-->


    <!-- ربط ملف bootstrap JS المحلي -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
