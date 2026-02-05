<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small"
                   placeholder="Search for...">
            <div class="input-group-append">
                <button class="btn btn-dark" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- User Dropdown -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
               role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>

                <img class="img-profile rounded-circle"
                     src="{{ Auth::user()->photo
                            ? asset('storage/profile/' . Auth::user()->photo)
                            : asset('sbadmin2/img/undraw_profile.svg') }}"
                     style="object-fit: cover; width: 32px; height: 32px;">
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item text-danger" id="logoutButton">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End Topbar -->

<!-- Logout Form -->
<form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none;">
    @csrf
</form>

<script>
    document.getElementById('logoutButton').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('logoutForm').submit();
    });
</script>
