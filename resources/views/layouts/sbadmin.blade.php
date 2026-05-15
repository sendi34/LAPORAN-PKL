<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'SB Admin 2 - Dashboard')</title>

    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>

        /* ══════════════════════════════════════════
   RESPONSIVE TABLE - BERLAKU SEMUA HALAMAN
══════════════════════════════════════════ */

/* Semua tabel otomatis scroll horizontal di mobile */
.card .card-body .table-responsive,
.card-body table {
    width: 100%;
}

.card-body {
    overflow-x: auto;
}

/* Tombol aksi - teks hilang di mobile, ikon saja */
@media (max-width: 768px) {

    /* Semua tabel bisa scroll */
    table {
        min-width: 500px;
    }

    /* Tombol lebih kecil */
    .btn-sm {
        padding: .2rem .4rem !important;
        font-size: .75rem !important;
    }

    /* Sembunyikan teks tombol, tampilkan ikon saja */
    .btn-sm .btn-text {
        display: none;
    }

    /* Kolom aksi tidak wrap */
    td:last-child, th:last-child {
        white-space: nowrap;
    }

    /* Card header lebih kecil */
    .card-header {
        padding: .6rem 1rem;
        font-size: .85rem;
    }

    /* Heading halaman */
    .h3 { font-size: 1.1rem !important; }
    h1.h3 { font-size: 1.1rem !important; }

    /* Tombol tambah di header */
    .btn.btn-primary {
        font-size: .8rem;
        padding: .3rem .7rem;
    }

    /* Pagination lebih kecil */
    .pagination .page-link {
        padding: .25rem .5rem;
        font-size: .75rem;
    }

    /* Alert message */
    .alert {
        font-size: .82rem;
        padding: .5rem .75rem;
    }

    /* Form control */
    .form-control {
        font-size: .82rem;
    }

    /* Badge */
    .badge {
        font-size: .65rem;
    }
}

        /* ── PAGINATION ── */
        .pagination { margin-bottom: 0; }
        .pagination .page-link {
            padding: 0.375rem 0.75rem; font-size: 0.875rem;
            line-height: 1.5; display: flex;
            align-items: center; justify-content: center;
        }
        .pagination svg { width: 14px !important; height: 14px !important; vertical-align: middle; }
        .pagination .page-item { margin: 0 2px; }
        .pagination .page-item.disabled .page-link { cursor: not-allowed; opacity: 0.6; }
        .pagination .page-item.active .page-link { background-color: #4e73df; border-color: #4e73df; }

        .collapse-inner .collapse-item {
            white-space: normal !important; word-break: break-word;
            line-height: 1.4; padding-top: 6px; padding-bottom: 6px;
        }

        /* ══════════════════════════════════════════
           RESPONSIVE GLOBAL
        ══════════════════════════════════════════ */

        /* Semua tabel scroll horizontal di mobile */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
        }

        /* ── MOBILE (max 576px) ── */
        @media (max-width: 576px) {

            /* Container padding lebih kecil */
            .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Metric cards */
            .metric-card { padding: .85rem 1rem; }
            .metric-card .mc-val { font-size: 1.6rem; }
            .metric-card .mc-label { font-size: .65rem; }
            .metric-card .mc-icon { font-size: 1.2rem; }

            /* Heading */
            h4.font-weight-bold { font-size: 1.1rem !important; }
            h1.h3 { font-size: 1.2rem !important; }

            /* Tabel */
            .obs-table td, .obs-table th {
                font-size: .72rem;
                padding: .3rem .4rem;
            }

            /* Peta lebih pendek */
            #map { height: 280px !important; }

            /* Chart lebih pendek */
            #chartStoret, #chartIP { height: 220px !important; }
            #chartLokasi, #chartParam { height: 220px !important; }
            #chartTrend, #chartStatus { height: 220px !important; }

            /* AI Cards */
            .btn-ai { font-size: .75rem; padding: .4rem .75rem; }
            .ai-card .card-body { gap: .5rem; }

            /* Insight box */
            .insight-box { padding: 1rem; flex-direction: row; }
            .insight-box .ins-icon { font-size: 1.5rem; }
            .insight-box p { font-size: .82rem; }

            /* Sec label */
            .sec-label { margin: 1rem 0 .4rem; }

            /* Modal */
            .ai-modal .modal-body { padding: 1rem; max-height: 60vh; }

            /* Badge tabel */
            .badge { font-size: .65rem; }

            /* Filter form stack vertikal */
            .d-flex.align-items-center.flex-wrap { flex-direction: column; align-items: flex-start !important; }
            .d-flex.align-items-center.flex-wrap .input-group,
            .d-flex.align-items-center.flex-wrap select,
            .d-flex.align-items-center.flex-wrap button { width: 100% !important; margin-bottom: 6px; }

            /* Topbar nama user hide di mobile */
            .d-none.d-lg-inline { display: none !important; }

            /* Footer */
            .sticky-footer { padding: .5rem 0; }
            .sticky-footer span { font-size: .75rem; }

            /* Sembunyikan kolom tertentu di mobile */
            .hide-mobile { display: none !important; }
        }

        /* ── TABLET (577px - 768px) ── */
        @media (min-width: 577px) and (max-width: 768px) {

            .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .metric-card .mc-val { font-size: 1.75rem; }

            #map { height: 350px !important; }

            .insight-box p { font-size: .88rem; }
        }

        /* ── APEXCHARTS RESPONSIVE ── */
        .apexcharts-canvas { max-width: 100% !important; }
    </style>

    @stack('head')
</head>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('form.ajax-form').forEach(function (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn     = form.querySelector('[type="submit"]');
            const btnText = btn.innerHTML;

            btn.disabled  = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            clearErrors(form);

            try {
                const res = await fetch(form.action, {
                    method: form.method.toUpperCase(),
                    body: new FormData(form),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const result = await res.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: result.message ?? 'Data berhasil disimpan!',
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = result.redirect;
                    });

                } else if (result.errors) {
                    showErrors(form, result.errors);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Periksa kembali!',
                        text: 'Ada field yang belum diisi dengan benar.',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }

            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan server.' });
            } finally {
                btn.disabled  = false;
                btn.innerHTML = btnText;
            }
        });
    });

    function clearErrors(form) {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.ajax-error').forEach(el => el.remove());
    }

    function showErrors(form, errors) {
        clearErrors(form);
        for (const [field, messages] of Object.entries(errors)) {
            const input = form.querySelector(`[name="${field}"]`)
                       ?? form.querySelector(`[name="${field}[]"]`);
            if (!input) continue;
            input.classList.add('is-invalid');
            const small       = document.createElement('small');
            small.className   = 'text-danger ajax-error';
            small.textContent = messages[0];
            input.after(small);
        }
        form.querySelector('.is-invalid')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

});
</script>

<body id="page-top">

    <div id="wrapper">

        <!-- ══ SIDEBAR ══ -->
        @auth
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ auth()->user()->role === 'petugas' ? route('petugas.dashboard') : route('admin.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('assets/logo-dlh.png') }}" alt="Logo DLH" style="width:46px;height:auto;">
                </div>
                <div class="sidebar-brand-text mx-3">DLH PROV KALSEL</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') || request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ auth()->user()->role === 'petugas' ? route('petugas.dashboard') : route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            {{-- ═══════════ ADMIN ═══════════ --}}
            @if(auth()->user()->role === 'admin')
                @php
                    $isDataMaster =
                        request()->routeIs('admin.users.*') ||
                        request()->routeIs('admin.lokasi.*') ||
                        request()->routeIs('admin.indikator.*') ||
                        request()->routeIs('admin.observasi.*') ||
                        request()->routeIs('admin.hasiluji.*');
                    $isLaporan = request()->is('admin/laporan/*');
                @endphp

                <!-- DATA MASTER -->
                <li class="nav-item">
                    <a class="nav-link {{ $isDataMaster ? '' : 'collapsed' }}" href="#"
                        data-toggle="collapse" data-target="#collapseDataMaster"
                        aria-expanded="{{ $isDataMaster ? 'true' : 'false' }}">
                        <i class="fas fa-database"></i>
                        <span>Data Master</span>
                    </a>
                    <div id="collapseDataMaster" class="collapse {{ $isDataMaster ? 'show' : '' }}"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Kelola Data:</h6>
                            <a class="collapse-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users fa-sm mr-2"></i> Pengguna
                            </a>
                            <a class="collapse-item {{ request()->routeIs('admin.lokasi.*') ? 'active' : '' }}"
                                href="{{ route('admin.lokasi.index') }}">
                                <i class="fas fa-map-marker-alt fa-sm mr-2"></i> Lokasi
                            </a>
                            <a class="collapse-item {{ request()->routeIs('admin.indikator.*') ? 'active' : '' }}"
                                href="{{ route('admin.indikator.index') }}">
                                <i class="fas fa-list fa-sm mr-2"></i> Parameter
                            </a>
                            <a class="collapse-item {{ request()->routeIs('admin.observasi.*') ? 'active' : '' }}"
                                href="{{ route('admin.observasi.index') }}">
                                <i class="fas fa-clipboard-list fa-sm mr-2"></i> Observasi
                            </a>
                            <a class="collapse-item {{ request()->routeIs('admin.hasiluji.*') ? 'active' : '' }}"
                                href="{{ route('admin.hasiluji.index') }}">
                                <i class="fas fa-vial fa-sm mr-2"></i> Hasil Uji
                            </a>
                        </div>
                    </div>
                </li>

                <hr class="sidebar-divider">

                <!-- LAPORAN -->
                <li class="nav-item">
                    <a class="nav-link {{ $isLaporan ? '' : 'collapsed' }}" href="#"
                        data-toggle="collapse" data-target="#collapseLaporan"
                        aria-expanded="{{ $isLaporan ? 'true' : 'false' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                    <div id="collapseLaporan" class="collapse {{ $isLaporan ? 'show' : '' }}"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Jenis Laporan:</h6>
                            <a class="collapse-item {{ request()->is('admin/laporan/hasil-per-lokasi') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'hasil-per-lokasi') }}">
                                <i class="fas fa-file-alt fa-sm mr-2"></i> Hasil Uji per Lokasi
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/rekap-tahunan') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'rekap-tahunan') }}">
                                <i class="fas fa-calendar fa-sm mr-2"></i> Rekapitulasi Kualitas Air
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/lokasi-rawan-pencemaran') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'lokasi-rawan-pencemaran') }}">
                                <i class="fas fa-map fa-sm mr-2"></i> Lokasi Rawan Pencemaran
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/indikator-melebihi-baku') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'indikator-melebihi-baku') }}">
                                <i class="fas fa-exclamation-triangle fa-sm mr-2"></i> Parameter Melebihi Baku Mutu
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/status-mutu-air') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'status-mutu-air') }}">
                                <i class="fas fa-water fa-sm mr-2"></i> Status Mutu Air
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/parameter-dominan') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'parameter-dominan') }}">
                                <i class="fas fa-chart-bar fa-sm mr-2"></i> Parameter Dominan Tercemar
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/perbandingan-peruntukan') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'perbandingan-peruntukan') }}">
                                <i class="fas fa-balance-scale fa-sm mr-2"></i> Perbandingan Peruntukan
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/tren-kualitas-air') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'tren-kualitas-air') }}">
                                <i class="fas fa-chart-line fa-sm mr-2"></i> Tren Kualitas Air
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/storet') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'storet') }}">
                                <i class="fas fa-calculator fa-sm mr-2"></i> Metode STORET
                            </a>
                            <a class="collapse-item {{ request()->is('admin/laporan/indeks-pencemaran') ? 'active' : '' }}"
                                href="{{ route('admin.laporan.show', 'indeks-pencemaran') }}">
                                <i class="fas fa-flask fa-sm mr-2"></i> Metode Indeks Pencemaran (IP)
                            </a>
                        </div>
                    </div>
                </li>

                <hr class="sidebar-divider d-none d-md-block">
            @endif

            {{-- ═══════════ PETUGAS ═══════════ --}}
            @if(auth()->user()->role === 'petugas')
                @php
                    $isPetugasMaster =
                        request()->routeIs('petugas.observasi.*') ||
                        request()->routeIs('petugas.hasiluji.*');
                @endphp

                <li class="nav-item">
                    <a class="nav-link {{ $isPetugasMaster ? '' : 'collapsed' }}" href="#"
                        data-toggle="collapse" data-target="#collapsePetugasMaster"
                        aria-expanded="{{ $isPetugasMaster ? 'true' : 'false' }}">
                        <i class="fas fa-database"></i>
                        <span>Data Master</span>
                    </a>
                    <div id="collapsePetugasMaster" class="collapse {{ $isPetugasMaster ? 'show' : '' }}"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Kelola Data:</h6>
                            <a class="collapse-item {{ request()->routeIs('petugas.observasi.*') ? 'active' : '' }}"
                                href="{{ route('petugas.observasi.index') }}">
                                <i class="fas fa-clipboard-list fa-sm mr-2"></i> Observasi
                            </a>
                            <a class="collapse-item {{ request()->routeIs('petugas.hasiluji.*') ? 'active' : '' }}"
                                href="{{ route('petugas.hasiluji.index') }}">
                                <i class="fas fa-vial fa-sm mr-2"></i> Hasil Uji
                            </a>
                        </div>
                    </div>
                </li>

                <hr class="sidebar-divider">
            @endif

        </ul>
        @endauth
        <!-- End of Sidebar -->

        <!-- ══ CONTENT WRAPPER ══ -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- ══ TOPBAR ══ -->
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
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown"
                                role="button" data-toggle="dropdown">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">{{ $alertsCount ?? '0' }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <h6 class="dropdown-header">Alerts Center</h6>
                                @foreach($alerts ?? [] as $alert)
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                                role="button" data-toggle="dropdown">
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
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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

                <!-- ══ PAGE CONTENT ══ -->
                <div class="container-fluid">
                    @yield('content')
                </div>

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

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>

    @stack('scripts')
</body>

</html>