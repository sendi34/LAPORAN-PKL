<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route(Auth::user()->role.'.dashboard') }}">
    <div class="sidebar-brand-text mx-3">DLH Dashboard</div>
  </a>

  @if(Auth::user()->role == 'admin')
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Manajemen Pengguna</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.lokasi.index') }}">Data Lokasi</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.indikator.index') }}">Indikator Uji</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.laporan.show', 'tahunan') }}">Laporan</a></li>
  @endif

  @if(Auth::user()->role == 'petugas')
    <li class="nav-item"><a class="nav-link" href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('petugas.observasi.index') }}">Observasi</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('petugas.hasiluji.index') }}">Hasil Uji</a></li>
  @endif
</ul>
