<!-- Super Admin Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="{{ Auth('admin')->User()->dashboard_style ?? 'dark' }}">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="info">
                    <a data-toggle="collapse" href="#superadminProfile" aria-expanded="true">
                        <span>
                            {{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}
                            <span class="user-level text-warning font-weight-bold"><i class="fas fa-crown mr-1"></i> Super Admin</span>
                        </span>
                    </a>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Super Admin Controls</h4>
                </li>

                <li class="nav-item {{ request()->routeIs('superadmin.dashboard') || request()->routeIs('superadmin.home') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.dashboard') }}">
                        <i class="fas fa-tachometer-alt text-warning"></i>
                        <p>Super Admin Overview</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('superadmin.users*') ? 'active' : '' }}">
                    <a href="{{ route('superadmin.users') }}">
                        <i class="fas fa-user-shield text-info"></i>
                        <p>User Security & Currencies</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Standard Admin</h4>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-arrow-left text-muted"></i>
                        <p>Back to Regular Admin</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
