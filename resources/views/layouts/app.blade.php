<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>Trusmi Group</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
    {{-- <body class="hold-transition skin-blue sidebar-collapse sidebar-mini"> --}}
    <div id="app">
        
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ asset('css/images.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            </a>
            {{-- <center> --}}
                <span class="brand-text" style="color: white; font-weight: bolder;">{{ Auth::user() ? Auth::user()->name : 'AdminLTE 3' }}</span>
            {{-- </center> --}}
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="/home" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/kpi" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>KPI</p>
                            </a>
                        </li>
                        @if(Auth::user())
                            <li class="nav-item">
                                <a href="#" class="nav-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>
        
        
        <div class="content-wrapper">
            <br>
            <section class="content">
                @yield('content')
            </section>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>

    <script>
        $(document).ready(function() {
            
            let isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed) {
                $('.main-sidebar').addClass('sidebar-collapse');
            }
    
            $('.nav-link').click(function() {
                $('.main-sidebar').toggleClass('sidebar-collapse');
                localStorage.setItem('sidebar-collapsed', $('.main-sidebar').hasClass('sidebar-collapse'));
            });
        });
    </script>
</body>
</html>
