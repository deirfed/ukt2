<header class="header">
    <div class="logo-wrapper">
        <a href="{{ route('dashboard.index') }}" class="logo">
            <img src="{{ asset('assets/img/fav2.png') }}" alt="" style="max-height: 200px" />
        </a>
    </div>
    <div class="header-items">
        <ul class="header-actions">
            <li class="dropdown mt-4">
                <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                    <i class="icon-bell"></i>
                    <span class="count-label">8</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
                    <div class="dropdown-menu-header">
                        Notifications (8)
                    </div>
                    <ul class="header-notifications">
                        <li>
                            <a href="#">
                                <div class="user-img away">
                                    <img src="" alt="User" />
                                </div>
                                <div class="details">
                                    <div class="user-title">Abbott</div>
                                    <div class="noti-details">Membership has been ended.</div>
                                    <div class="noti-date">Oct 20, 07:30 pm</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="dropdown mt-4">
                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="avatar">USER<span class="status busy"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <div class="header-user-profile">
                            <div class="header-user">
                                <img src="#" alt="Admin Template" />
                            </div>
                            <h5>{{ auth()->user()->name }}</h5>
                            <p>{{ auth()->user()->email }}</p>
                        </div>
                        <a href="user-profile.html"><i class="icon-user1"></i> My Profile</a>
                        <a href="account-settings.html"><i class="icon-settings1"></i> Account Settings</a>
                        <a thref="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="icon-log-out1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
