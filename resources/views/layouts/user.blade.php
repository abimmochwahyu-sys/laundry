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
                href="{{ route('user.dashboard') }}">
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
            <li class="nav-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">Layanan</div>
            <!-- Transaksi -->
            <li class="nav-item {{ request()->is('user/transaksi*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('user/transaksi') }}">
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
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ Auth::user()->username }}
                                </span>
                                <i class="fas fa-dragon logo-naga-animated"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item nav-link {{ request()->is('user/profile') ? 'active' : '' }}" href="{{  url('/user/profile') }}">
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
</body>

</html>