<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PT. HARAPAN DUTA PERTIWI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
   @if (Auth::user()->role_id == 1)
    <div class="sidebar-heading text-center">
        Data Pengguna
    </div>

    <!-- Karyawan -->
    <li class="nav-item {{ request()->is('karyawan*') ? 'active' : '' }}">
        <a class="nav-link" href="/karyawan">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Karyawan</span>
        </a>
    </li>

    <!-- Pelanggan -->
    <li class="nav-item {{ request()->is('pelanggan*') ? 'active' : '' }}">
        <a class="nav-link" href="/pelanggan">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Pelanggan</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
@endif


    <div class="sidebar-heading text-center">
        Data Produk
    </div>

    {{-- <li class="nav-item {{ request()->is('product') ? 'active' : '' }}">
        <a class="nav-link" href="/product">
            <i class="fas fa-fw fa-box"></i>
            <span>Product</span>
        </a>
    </li> --}}

    <li class="nav-item {{ request()->is('jenis') ? 'active' : '' }}">
        <a class="nav-link" href="/jenis">
            <i class="fas fa-fw fa-box"></i>
            <span>Jenis Dump</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('type') ? 'active' : '' }}">
        <a class="nav-link" href="/type">
            <i class="fas fa-fw fa-box"></i>
            <span>Type Dump</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('chassis') ? 'active' : '' }}">
        <a class="nav-link" href="/chassis">
            <i class="fas fa-fw fa-box"></i>
            <span>Chassis</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
