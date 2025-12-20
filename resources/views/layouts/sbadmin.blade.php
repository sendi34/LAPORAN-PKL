<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'SB Admin 2 - Dashboard')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
    /* Fix ukuran icon pagination Laravel */
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .pagination svg {
        width: 14px !important;
        height: 14px !important;
        vertical-align: middle;
    }
    
    .pagination .page-item {
        margin: 0 2px;
    }
    
    .pagination .page-item.disabled .page-link {
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }
</style>

    @stack('head')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @auth
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center"
                    href="{{ auth()->user()->role === 'petugas' ? route('petugas.dashboard') : route('admin.dashboard') }}">

                    <div class="sidebar-brand-icon">
                        <img src="{{ asset('assets/logo-dlh.png') }}" alt="Logo DLH" style="width:46px; height:auto;">
                    </div>

                    <div class="sidebar-brand-text mx-3">DLH PROV KALSEL</div>
                </a>


                <hr class="sidebar-divider my-0">

                <!-- Dashboard -->
                <li
                    class="nav-item {{ request()->routeIs('admin.dashboard') || request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ auth()->user()->role === 'petugas' ? route('petugas.dashboard') : route('admin.dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <hr class="sidebar-divider">

                <!-- ADMIN -->
                @if (auth()->user()->role === 'admin')
                    <div class="sidebar-heading text-white">DATA MASTER</div>

                    <!-- Pengguna -->
                    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>

                    <!-- Lokasi -->
                    <li class="nav-item {{ request()->routeIs('admin.lokasi.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.lokasi.index') }}">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Lokasi</span>
                        </a>
                    </li>

                    <!-- Indikator -->
                    <li class="nav-item {{ request()->routeIs('admin.indikator.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.indikator.index') }}">
                            <i class="fas fa-list"></i>
                            <span>Parameter</span>
                        </a>
                    </li>

                    <!-- Observasi -->
                    <li class="nav-item {{ request()->routeIs('admin.observasi.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.observasi.index') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Observasi</span>
                        </a>
                    </li>

                    <!-- Hasil Uji -->
                    <li class="nav-item {{ request()->routeIs('admin.hasiluji.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.hasiluji.index') }}">
                            <i class="fas fa-vial"></i>
                            <span>Hasil Uji</span>
                        </a>
                    </li>

                    <hr class="sidebar-divider">

                    <!-- =======================
                                LAPORAN
                            ======================== -->
                    <div class="sidebar-heading text-white">LAPORAN</div>

                    <!-- Hasil uji per lokasi -->
                    <li class="nav-item {{ request()->is('admin/laporan/hasil-per-lokasi') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.laporan.show', 'hasil-per-lokasi') }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Hasil Uji per Lokasi</span>
                        </a>
                    </li>

                    <!-- Rekap tahunan -->
                    <li class="nav-item {{ request()->is('admin/laporan/rekap-tahunan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.laporan.show', 'rekap-tahunan') }}">
                            <i class="fas fa-calendar"></i>
                            <span>Rekapitulasi Kualitas Air</span>
                        </a>
                    </li>

                    <!-- Aktivitas petugas -->
                    <li class="nav-item {{ request()->is('admin/laporan/aktivitas-petugas') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.laporan.show', 'aktivitas-petugas') }}">
                            <i class="fas fa-user-check"></i>
                            <span>Aktivitas Petugas</span>
                        </a>
                    </li>

                    <!-- Lokasi SHU -->
                    <li class="nav-item {{ request()->is('admin/laporan/lokasi-rawan-pencemaran') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.laporan.show', 'lokasi-rawan-pencemaran') }}">
                            <i class="fas fa-map"></i>
                            <span>Lokasi Rawan Pencemaran</span>
                        </a>
                    </li>

                    <!-- Indikator melebihi baku -->
                    <li class="nav-item {{ request()->is('admin/laporan/indikator-melebihi-baku') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.laporan.show', 'indikator-melebihi-baku') }}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Rekap Indikator Melebihi Baku Mutu</span>
                        </a>
                    </li>

                    <hr class="sidebar-divider d-none d-md-block">
                @endif

                <!-- PETUGAS -->
                @if (auth()->user()->role === 'petugas')
                    <hr class="sidebar-divider">
                    <div class="sidebar-heading text-white">DATA MASTER</div>
                    {{-- Data Observasi --}}
                    <li class="nav-item @if (request()->routeIs('petugas.observasi.*')) active @endif">
                        <a class="nav-link" href="{{ route('petugas.observasi.index') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Data Observasi</span>
                        </a>
                    </li>

                    {{-- Hasil Uji --}}
                    <li class="nav-item @if (request()->routeIs('petugas.hasiluji.*')) active @endif">
                        <a class="nav-link" href="{{ route('petugas.hasiluji.index') }}">
                            <i class="fas fa-vial"></i>
                            <span>Hasil Uji</span>
                        </a>
                    </li>

                    <hr class="sidebar-divider">
                @endif


            </ul>
        @endauth
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    @auth
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    @endauth

                    <ul class="navbar-nav ml-auto">

                        {{-- Alerts --}}
                        @auth
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                    data-toggle="dropdown">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <span class="badge badge-danger badge-counter">{{ $alertsCount ?? '0' }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                    <h6 class="dropdown-header">Alerts Center</h6>
                                    @foreach ($alerts ?? [] as $alert)
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{ $alert['date'] ?? '' }}</div>
                                                <span class="font-weight-bold">{{ $alert['text'] ?? '' }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @endauth

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- User Dropdown -->
                        <li class="nav-item dropdown no-arrow">

                            @auth
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown">

                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                        {{ Auth::user()->nama ?? Auth::user()->name }}
                                    </span>

                                    <img class="img-profile rounded-circle"
                                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('sbadmin/img/undraw_profile.svg') }}">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>

                                </div>
                            @endauth

                            @guest
                                <a class="nav-link" href="{{ route('login') }}">
                                    <span class="text-gray-600 small">Login</span>
                                </a>
                            @endguest

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>Copyright &copy; {{ config('app.name') }} {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
