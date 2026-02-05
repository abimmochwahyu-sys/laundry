<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- SB Admin 2 -->
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

            <!-- Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>
        <!-- End Main Content -->

        {{-- Footer --}}
        @include('layouts.footer')

    </div>
    <!-- End Content Wrapper -->

</div>
<!-- End Page Wrapper -->


{{-- ================= MODAL PROFIL ADMIN ================= --}}
<div class="modal fade" id="profilAdminModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Profil Admin</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th>Nama</th>
                        <td>{{ Auth::user()->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ Auth::user()->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <th>No Telepon</th>
                        <td>{{ Auth::user()->karyawan->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ Auth::user()->karyawan->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
{{-- ====================================================== --}}

<!-- Scripts -->
<script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

</body>
</html>
