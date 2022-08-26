@guest

@yield('content')

@else

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('assets/logo-daun.png') }}" rel="icon" type="image/x-icon">
    <title>{{ config('app.name', 'Abata Dashboard') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('themes/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('themes/dist/css/adminlte.min.css') }}">

    @yield('style')
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">
                    <img src="{{ asset('assets/logo-biru.png') }}" alt="Logo" class="brand-image" style="opacity: .8">
                    <span class="brand-text font-weight-light">Dashboard Abata Group</span>
                </a>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                                <i class="fa fa-user-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a
                                class="dropdown-item"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt px-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        @yield('content')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('themes/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('themes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('themes/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('themes/dist/js/adminlte.js') }}"></script>


    @yield('script')
</body>
</html>

@endguest
