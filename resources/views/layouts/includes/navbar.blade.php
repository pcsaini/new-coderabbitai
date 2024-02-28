<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container">
                <ul class="navbar-nav">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="#" >
                            <span class="nav-link-icon">
                                <i class="ti ti-home icon"></i>
                            </span>
                            <span class="nav-link-title">Home</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('deposit') ? 'active' : '' }}">
                        <a class="nav-link" href="#" >
                            <span class="nav-link-icon">
                                <i class="ti ti-cloud-upload icon"></i>
                            </span>
                            <span class="nav-link-title">Deposit</span>
                        </a>
                    </li>

                    <li class="nav-item" {{ request()->routeIs('withdraw') ? 'active' : '' }}>
                        <a class="nav-link" href="#" >
                            <span class="nav-link-icon">
                                <i class="ti ti-cloud-download icon"></i>
                            </span>
                            <span class="nav-link-title">Withdraw</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('transfer') ? 'active' : '' }}">
                        <a class="nav-link" href="#" >
                            <span class="nav-link-icon">
                                <i class="ti ti-transfer icon"></i>
                            </span>
                            <span class="nav-link-title">Transfer</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('statement') ? 'active' : '' }}">
                        <a class="nav-link" href="#" >
                            <span class="nav-link-icon">
                                <i class="ti ti-file-text icon"></i>
                            </span>
                            <span class="nav-link-title">Statement</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.logout') }}" >
                            <span class="nav-link-icon">
                                <i class="ti ti-logout icon"></i>
                            </span>
                            <span class="nav-link-title">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
