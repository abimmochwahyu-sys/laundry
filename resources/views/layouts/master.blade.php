<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SB Admin 2 - Laravel')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')
        

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                {{-- Topbar --}}
                @include('layouts.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            {{-- Footer --}}
            @include('layouts.footer')

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

    <!-- Tambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
