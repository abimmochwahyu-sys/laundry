<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- BRAND --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ auth()->user()->role === 'owner' ? route('owner.dashboard') : route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3 mt-2">
            <h4><b>SICLEAN</b></h4>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- ================= ADMIN SIDEBAR ================= --}}
    @if(auth()->user()->role === 'admin')

        <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Master Data</div>

        <li class="nav-item {{ request()->is('admin/karyawan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.karyawan.index') }}">
                <i class="fas fa-users"></i>
                <span>Karyawan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('admin/layanan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.layanan.index') }}">
                <i class="fas fa-concierge-bell"></i>
                <span>Layanan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Kelola Transaksi</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Laporan</div>

        <li class="nav-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                <i class="fas fa-file-alt"></i>
                <span>Laporan</span>
            </a>
        </li>

    {{-- ================= OWNER SIDEBAR ================= --}}
    @elseif(auth()->user()->role === 'owner')

        <li class="nav-item {{ request()->is('owner/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('owner.dashboard') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Laporan</div>

        <li class="nav-item {{ request()->is('owner/laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('owner.laporan') }}">
                <i class="fas fa-file-alt"></i>
                <span>Laporan Pendapatan</span>
            </a>
        </li>

    
    @elseif(auth()->user()->role === 'karyawan')
        
        <li class="nav-item {{ request()->is('karyawan/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('karyawan.dashboard') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('karyawan/transaksi') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('karyawan.transaksi.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Kelola Transaksi</span>
            </a>
        </li>
    @endif

    @elseif(auth()->user()->role === 'pelanggan')
        
        <li class="nav-item {{ request()->is('pelanggan/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pelanggan.dashboard') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('pelanggan/transaksi') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pelanggan.transaksi.index') }}">
                <i class="fas fa-fw fa-money-bill-wave"></i>
                <span>Kelola Transaksi</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
