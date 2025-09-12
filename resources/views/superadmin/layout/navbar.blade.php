<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="dashboardsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
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
    <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="icon-database nav-icon"></i>
        Masterdata
    </a>
    <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('admin-user.index') }}">Data User</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin-kategori.index') }}">Data Kegiatan</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin-formasi_tim.index') }}">Data Formasi Tim</a>
        </li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="icon-database nav-icon"></i>
        Arsip Data
    </a>
    <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('admin-kinerja.index') }}">Data Kinerja</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin-absensi.index') }}">Data Absensi</a>
        </li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-calendar-times nav-icon"></i>
        Cuti
    </a>
    <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('admin-konfigurasi_cuti.index') }}">Konfigurasi Cuti</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin-cuti.index') }}">Data Pengajuan Cuti/Izin</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin-cuti.approval_page') }}">Halaman Approval</a>
        </li>
    </ul>
</li>
