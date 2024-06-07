<div class="min-height-300 bg-primary position-absolute w-100"></div>

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <!-- Header sidenav -->
    <div class="sidenav-header">
        <!-- Tombol untuk menutup sidenav -->
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <!-- Logo dan nama perpustakaan -->
      <a class="navbar-brand m-0" href="{{ url('admin/dashboard') }}" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <img src="{{ asset('/') }}assets/img/icon perpustakaan.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Perpustakaan Jaya Abadi</span>
      </a>
    </div>

    {{-- Info user --}}
    <div class="info text-center">
        @if(Auth::check())
            <!-- Nama dan email user yang login -->
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            <a href="#" class="d-block">{{ Auth::user()->email }}</a>
        @endif
    </div>
    {{-- Info user --}}

    {{-- Menu navigasi sidenav --}}
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <!-- Anggota -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/anggota') ? 'active' : '' }}" href="{{ url('admin/anggota') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Anggota</span>
          </a>
        </li>
        <!-- Buku -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/buku') ? 'active' : '' }}" href="{{ url('admin/buku') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Buku</span>
          </a>
        </li>
        <!-- Peminjaman -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/peminjaman') ? 'active' : '' }}" href="{{ url('admin/peminjaman') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Peminjaman</span>
          </a>
        </li>
        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/laporan') ? 'active' : '' }}" href="{{ url('admin/laporan') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-chart-pie-35 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Laporan</span>
            </a>
        </li>
        <!-- Logout -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('logout') ? 'active' : '' }}" href="{{ url('logout') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-user-run text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
    {{-- Menu navigasi sidenav --}}

  </aside>
