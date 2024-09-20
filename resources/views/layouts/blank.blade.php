<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../" />
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8" />
    <meta name="description" content="Budgeting & Expense Tracking Solution" />
    <meta name="keywords" content="Budgeting & Expense Tracking Solution" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Budgeting & Expense Tracking Solution" />
    <meta property="og:site_name" content="Budgeting & Expense Tracking Solution" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ url('/') }}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/assets/css/custom.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat bg-body-color">

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root"
        style="background-image: url(assets/media/misc/auth-bg.png)">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center py-5">
            <!--begin::Logo-->
            <a href="" class="mb-0">
                <img alt="Logo" src="assets/media/logos/logo.svg" class="h-50px" />
            </a>
            <!--end::Logo-->
        </div>
    </div>

    @yield('content')



    <!--begin::Javascript-->
    <script>
    var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ url('/') }}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{ url('/') }}/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->

    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    @yield('pageScripts')
</body>
<!--end::Body-->

</html>