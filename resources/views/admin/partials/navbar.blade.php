<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <!-- <a class="navbar-brand ps-3" href="{{ route('dashboard') }}">Admin Panel</a> -->
    
    <a class="navbar-brand ps-3" href="">
    <img class="my-2" src="{{ asset('admin/image/school-logo.png') }}" alt="Logo" style="height:40px; width:50px; margin-left:50px;">
    </a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i
            class="fas fa-bars"></i></button>

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <!-- Update Profile -->
                <li>
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="fas fa-user-edit"></i> Update Profile
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <!-- Logout -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>

</nav>