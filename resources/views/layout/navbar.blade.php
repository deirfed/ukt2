<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="dashboardsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-devices_other nav-icon"></i>
        Dashboard
    </a>
    <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a>
        </li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-package nav-icon"></i>
        Masterdata
    </a>
    <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('data_essentials.index') }}">Data Essentials</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('data_assets.index') }}">Data Assets</a>
        </li>
    </ul>
</li>
