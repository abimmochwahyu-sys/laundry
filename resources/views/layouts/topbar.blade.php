<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search position-relative" id="menuSearchForm">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" id="menuSearchInput"
                placeholder="Cari menu... (misal: Transaksi)" aria-label="Search" aria-describedby="basic-addon2" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
        <!-- Search Results Container -->
        <div id="menuSearchResults" class="dropdown-menu shadow animated--fade-in" style="width: 100%; top: 45px; display: none; background: white !important; z-index: 9999;">
            <!-- Results will be injected here -->
        </div>
    </form>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
 
         <!-- User Dropdown -->
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-3 d-none d-lg-inline text-gray-700 font-weight-bold small" style="font-family: 'Outfit', sans-serif;">
                    {{ Auth::user()->name }}
                </span>
                <div class="user-initials-avatar">
                    {{ Auth::user()->initials }}
                </div>
            </a>

            <style>
                .user-initials-avatar {
                    width: 42px;
                    height: 42px;
                    background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
                    color: white;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 700;
                    font-size: 15px;
                    font-family: 'Outfit', sans-serif;
                    letter-spacing: 0.5px;
                    box-shadow: 0 10px 15px -3px rgba(2, 132, 199, 0.3), 0 4px 6px -2px rgba(2, 132, 199, 0.05);
                    border: 3px solid #ffffff;
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    cursor: pointer;
                }
                
                .nav-link:hover .user-initials-avatar {
                    transform: scale(1.1) rotate(5deg);
                    box-shadow: 0 20px 25px -5px rgba(2, 132, 199, 0.4);
                }

                .nav-link:active .user-initials-avatar {
                    transform: scale(0.95);
                }
            </style>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <a class="dropdown-item" href="{{ 
                    Auth::user()->role === 'admin' ? route('admin.profile.index') : 
                    (Auth::user()->role === 'karyawan' ? route('karyawan.profile') :
                    (Auth::user()->role === 'owner' ? route('owner.profile') : route('pelanggan.profile')))
                }}">
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
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan keluar dari sesi ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });

    // Enhanced Menu Search Logic (Topbar looking into Sidebar)
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('menuSearchInput');
        const resultsContainer = document.getElementById('menuSearchResults');
        
        if (!searchInput || !resultsContainer) return;

        function getMenuItems() {
            // Index links from sidebar
            const sidebarLinks = document.querySelectorAll('#accordionSidebar .nav-link, #accordionSidebar .dropdown-item');
            let items = [];
            sidebarLinks.forEach(link => {
                const textSpan = link.querySelector('span');
                const text = textSpan ? textSpan.innerText.trim() : link.innerText.trim();
                const href = link.getAttribute('href');
                
                if (text && href && href !== '#' && !href.includes('javascript')) {
                    items.push({ text: text, href: href });
                }
            });
            return items;
        }

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            resultsContainer.innerHTML = '';
            
            if (query.length < 1) {
                resultsContainer.style.display = 'none';
                return;
            }

            const menuItems = getMenuItems();
            const filtered = menuItems.filter(item => 
                item.text.toLowerCase().includes(query)
            );

            if (filtered.length > 0) {
                // Unique results based on text
                const uniqueResults = Array.from(new Set(filtered.map(i => JSON.stringify(i)))).map(s => JSON.parse(s));
                
                uniqueResults.forEach(item => {
                    const a = document.createElement('a');
                    a.className = 'dropdown-item d-flex align-items-center py-2';
                    a.href = item.href;
                    a.innerHTML = `<i class="fas fa-link mr-2 text-primary small"></i> <span>${item.text}</span>`;
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
</script>
