<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-server"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'NoMa') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ url()->current() == route('dashboard') ? "active" : "" }}">
        <a class="nav-link"  href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manage
    </div>

    <li class="nav-item {{ str_contains(url()->current(), "node") ? "active" : "" }}">
        <a class="nav-link"  href="{{ route('node.index') }}">
            <i class="fas fa-fw fa-server"></i>
            <span>Nodes</span>
        </a>
    </li>

    <li class="nav-item {{ str_contains(url()->current(), "site") ? "active" : "" }}">
        <a class="nav-link"  href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Sites</span>
        </a>
    </li>

    <li class="nav-item {{ str_contains(url()->current(), "database") ? "active" : "" }}">
        <a class="nav-link"  href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Databases</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>