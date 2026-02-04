<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
                        
                        
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->user()->avatar ?? 'default/avatar.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                {{-- <a href="{{ route('admin.settings.index') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a> --}}
                <div class="dropdown-divider"></div>
    {{-- Clear Cache --}}
    {{-- <form method="POST" action="{{ route('admin.clear.cache') }}">
        @csrf
        <button type="submit" class="dropdown-item has-icon text-warning">
            <i class="fas fa-broom"></i> Clear Cache
        </button>
    </form> --}}

    {{-- Optimize Clear --}}
    {{-- <form method="POST" action="{{ route('admin.optimize.clear') }}">
        @csrf
        <button type="submit" class="dropdown-item has-icon text-info">
            <i class="fas fa-sync-alt"></i> Optimize Clear
        </button>
    </form> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        {{-- <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard.index') }}">{{ config('settings.site_name') }}</a>
        </div> --}}
        {{-- <div class="sidebar-brand sidebar-brand-sm">
            <a
                href="{{ route('admin.dashboard.index') }}">{{ truncate(config('settings.site_name') ?? 'My Site', 2) }}</a>
        </div> --}}
        <ul class="sidebar-menu">

            <li class="menu-header">Starter</li>
            <li class="{{ setSidebarActive(['admin.dashboard.index']) }}"><a class="nav-link"
                    href="{{ route('admin.dashboard.index') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>


           {{-- @can('user management index')
                            <li class="{{ setSidebarActive(['admin.user-management.index']) }}"><a class="nav-link"
                                    href="{{ route('admin.user-management.index') }}"><i class="fas fa-fingerprint"></i>
                        <span>User Approvals</span></a></li>
                        @endcan --}}
            {{-- @canany(['access management index', 'user management index'])
                <li class="dropdown {{ setSidebarActive(['admin.hero.index']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-fingerprint"></i>
                        <span>Approvals</span></a>

                    <ul class="dropdown-menu"> --}}
                        {{-- @can('access management index')
                            <li class="{{ setSidebarActive(['admin.role-user.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.role-user.index') }}">Roles Users</a></li>

                            <li class="{{ setSidebarActive(['admin.role.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.role.index') }}">Roles and Permissions</a></li>
                        @endcan --}}
{{-- 
                        @can('user management index')
                            <li class="{{ setSidebarActive(['admin.user-management.index']) }}"><a class="nav-link"
                                    href="{{ route('admin.user-management.index') }}">User Approvals</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany --}}

            {{-- @can('message index')
                <li class="{{ setSidebarActive(['admin.messages.index']) }}"><a class="nav-link"
                        href="{{ route('admin.messages.index') }}"><i class="fas fa-comment-alt"></i>
                        <span>Messages</span></a></li>
            @endcan --}}

            
            {{-- @can('footer index')
             <li class="{{ setSidebarActive(['admin.footer-info.index']) }}"><a class="nav-link"
                                href="{{ route('admin.footer-info.index') }}"><i class="fas fa-info"></i><span>Footer Info</span></a></li>
                
            @endcan --}}

{{-- 
            @can('settings index')
                <li class="{{ setSidebarActive(['admin.settings.index']) }}"><a class="nav-link"
                        href="{{ route('admin.settings.index') }}"><i class="fas fa-cogs"></i> <span>Settings</span></a>
                </li>
            @endcan --}}

            {{-- @can('settings index')
                <li class="{{ setSidebarActive(['admin.clear-database.index']) }}"><a class="nav-link"
                        href="{{ route('admin.clear-database.index') }}"><i class="fas fa-skull-crossbones"></i> <span>Wipe
                            Database</span></a></li>
            @endcan --}}

        </ul>
    </aside>
</div>