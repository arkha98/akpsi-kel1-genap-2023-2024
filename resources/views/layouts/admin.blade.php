<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrator | Dashboard</title>

    <link href="{{ asset('_asset/_icon/favicon.ico') }}" rel="icon">

    @include('layouts.sub-layout-admin.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('_asset/_logo/logo.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        @include('layouts.sub-layout-admin.header')

        <!-- Main Sidebar Container -->
        @include('layouts.sub-layout-admin.menu_sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        @include('layouts.sub-layout-admin.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('layouts.sub-layout-admin.js')

    @yield('javascripts')


</body>

</html>
