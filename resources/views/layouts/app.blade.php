<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title', 'ykso | home')
    </title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Barra superior -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>
        </nav>

        <!-- Barra lateral -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <!--logo-->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('img/app/logo_sidebar.png') }}" alt="ykso" class="brand-image"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Y<span style="font-weight: bold;">K</span>SO</span>
            </a>

            <!-- barra lateral-->
            <div class="sidebar">

                <!--usuario datos-->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img' . session('user.photo')) }}" class="rounded elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('home') }}" class="d-block">{{ session('user.name') }}</a>
                    </div>
                </div>

                <!--OPCIONES ADMINISTRADOR-->
                @if (session()->has('user') && session('user.role') == 'admin')
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">

                            <li class="nav-header">ADMINISTRACIÓN</li>

                            <li class="nav-item">
                                <a href="{{ route('users') }}" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p>
                                        Gestión de usuarios
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </nav>
                @endif

                <!-- GENERAL -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-header">FUNCIONES</li>

                    </ul>
                </nav>


                @if (session()->has('user'))
                    <!--OPCIONES USUARIO-->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">

                            <li class="nav-header">OPCIONES</li>

                            <li class="nav-item">
                                <a href="{{ route('ChangePassword') }}" class="nav-link">
                                    <i class="nav-icon fa fa-key"></i>
                                    <p>
                                        Cambiar contraseña
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="nav-icon fa fa-times-circle"></i>
                                    <p>
                                        Cerrar Sesión
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </nav>
                @endif

            </div>
        </aside>

        <!-- Contenido -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </section>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <!-- Pie de página -->
        <footer class="main-footer">
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 0.0.1
            </div>
        </footer>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    {{-- <script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script> --}}

    @include('utils.alerts')
    @include('utils.modals')

    @yield('scripts')
    <!-- @vite('resources/js/app.js')  -->
</body>

</html>
