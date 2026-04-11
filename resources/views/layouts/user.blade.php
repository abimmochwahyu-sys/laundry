<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - @yield('title')</title>
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        /* Custom styles for gradient blue theme */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0277bd 0%, #4fc3f7 100%) !important;
        }

        .sidebar .nav-item.active .nav-link {
            background: linear-gradient(135deg, #0277bd 0%, #4fc3f7 100%) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0277bd 0%, #4fc3f7 100%) !important;
            border-color: #0277bd !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #025c96 0%, #3db8f5 100%) !important;
            border-color: #025c96 !important;
        }

        .sidebar-brand {
            background: linear-gradient(135deg, #0277bd 0%, #4fc3f7 100%) !important;
        }

        .logo-naga-animated {
            color: #0277bd !important;
            transition: all 0.3s ease;
        }

        .logo-naga-animated:hover {
            color: #4fc3f7 !important;
            transform: scale(1.1);
        }

        .topbar .navbar-search .input-group-append .btn-primary {
            background: linear-gradient(135deg, #0277bd 0%, #4fc3f7 100%) !important;
            border-color: #0277bd !important;
        }

        .topbar .navbar-search .input-group-append .btn-primary:hover {
            background: linear-gradient(135deg, #025c96 0%, #3db8f5 100%) !important;
            border-color: #025c96 !important;
        }

        /* Add animation to logo */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-5px) scale(1.05);
            }
        }

        .logo-naga-animated {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('pelanggan.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <div class="sidebar-brand-text mx-3 mt-2">
                    <h4><b>SICLEAN</b></h4>
                </div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Dashboard -->
            <li class="nav-item {{ request()->is('pelanggan/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pelanggan.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Layanan</div>
            <!-- Transaksi -->
            <li class="nav-item {{ request()->is('pelanggan/transaksi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('pelanggan/transaksi') }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search position-relative" id="menuSearchFormUser">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" id="menuSearchInputUser"
                                placeholder="Cari menu... (misal: Transaksi)" aria-label="Search" aria-describedby="basic-addon2" autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div id="menuSearchResultsUser" class="dropdown-menu shadow animated--fade-in" style="width: 100%; top: 45px; display: none; background: white !important; z-index: 9999;"></div>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                             <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <span class="mr-3 d-none d-lg-inline text-gray-700 font-weight-bold small" style="font-family: 'Outfit', sans-serif;">
                                     {{ Auth::user()->name }}
                                 </span>
                                 <div class="user-initials-avatar">
                                     {{ Auth::user()->initials }}
                                 </div>
                             </a>
                            <style>
                                .user-initials-avatar {
                                    width: 40px;
                                    height: 40px;
                                    background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
                                    color: white;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: 700;
                                    font-size: 14px;
                                    font-family: 'Outfit', sans-serif;
                                    box-shadow: 0 10px 15px -3px rgba(2, 132, 199, 0.3), 0 4px 6px -2px rgba(2, 132, 199, 0.05);
                                    border: 3px solid #ffffff;
                                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                                    cursor: pointer;
                                }
                                .nav-link:hover .user-initials-avatar {
                                    transform: scale(1.1) rotate(5deg);
                                    box-shadow: 0 20px 25px -5px rgba(2, 132, 199, 0.4);
                                }
                            </style>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item nav-link {{ request()->is('pelanggan/profile') ? 'active' : '' }}" href="{{  route('pelanggan.profile') }}">
                                    <i class="fas fa-user mr-2"></i>
                                    Profil Saya
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ ('/login') }}" class="dropdown-item text-danger" id="logoutButton">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
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
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Laravel SB Admin 2 {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
 
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    <!-- Logout Form -->
    <form id="logoutFormUser" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
 
    <script>
        document.getElementById('logoutButton').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan keluar dari sesi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0277bd',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutFormUser').submit();
                }
            });
        });

        // Enhanced Menu Search Logic for User (Topbar looking into Sidebar)
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('menuSearchInputUser');
            const resultsContainer = document.getElementById('menuSearchResultsUser');
            
            if (!searchInput || !resultsContainer) return;

            function getMenuItems() {
                const sidebarLinks = document.querySelectorAll('#accordionSidebar .nav-link');
                let items = [];
                sidebarLinks.forEach(link => {
                    const span = link.querySelector('span');
                    const text = span ? span.innerText.trim() : link.innerText.trim();
                    const href = link.getAttribute('href');
                    if (text && href && href !== '#' && !href.includes('javascript')) {
                        items.push({ text: text, href: href });
                    }
                });
                return items;
            }

            const menuItems = getMenuItems();

            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                resultsContainer.innerHTML = '';
                
                if (query.length < 1) {
                    resultsContainer.style.display = 'none';
                    return;
                }

                const filtered = menuItems.filter(item => 
                    item.text.toLowerCase().includes(query)
                );

                if (filtered.length > 0) {
                    const uniqueResults = Array.from(new Set(filtered.map(i => JSON.stringify(i)))).map(s => JSON.parse(s));
                    
                    uniqueResults.forEach(item => {
                        const a = document.createElement('a');
                        a.className = 'dropdown-item d-flex align-items-center py-2';
                        a.href = item.href;
                        a.innerHTML = `<i class="fas fa-link mr-2 text-info small"></i> <span>${item.text}</span>`;
                        resultsContainer.appendChild(a);
                    });
                    resultsContainer.style.display = 'block';
                } else {
                    resultsContainer.innerHTML = '<div class="dropdown-item text-muted small py-2 text-center">Menu tidak ditemukan...</div>';
                    resultsContainer.style.display = 'block';
                }
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                    resultsContainer.style.display = 'none';
                }
            });
        });
        // SweetAlert Notifications
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                timer: 4000,
                showConfirmButton: true,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: '{{ session("warning") }}',
                timer: 4000,
                showConfirmButton: true,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session("info") }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
        @endif
    </script>
 </body>

</html>