<!DOCTYPE html>
<html lang="en">
<head>

    <title>@yield('title')</title>
    @include('Dashboard.css')
    @yield('css')
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        @include('Dashboard.sidebar')

        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            @include('Dashboard.header')

            <div class="d-flex flex-column-fluid" id="kt_content">
                <div class="container">
                    @yield('content')
                </div>
            </div>

            @include('Dashboard.footer')

        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->
@include('Dashboard.js')
@yield('js')

<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
