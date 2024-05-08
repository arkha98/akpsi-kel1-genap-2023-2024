<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard.index') }}" class="brand-link">
        <img src="{{ asset('_asset/_logo/logo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-fluid elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src=""
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ ucwords(Auth::user()->full_name) }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.index') }}"
                        class="nav-link @if(Route::is('admin.dashboard.index') ) active @endif">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                @if (
                $roleMenuMapping->contains('menu_id', EnumMenus::_USER_MANAGEMENT_ID) ||
                $roleMenuMapping->contains('menu_id', EnumMenus::_TRAINING_PLAN_ID)
                )

                <li class="nav-item
                    @if (
                            $menuOpen == EnumMenus::_USER_MANAGEMENT_ID ||
                            $menuOpen == EnumMenus::_TRAINING_PLAN_ID
                        )
                        menu-open
                    @endif">
                    <a href="#" class="nav-link
                    @if (
                            $menuOpen == EnumMenus::_USER_MANAGEMENT_ID ||
                            $menuOpen == EnumMenus::_TRAINING_PLAN_ID
                        )
                        active
                    @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Manajemen
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        @if ($roleMenuMapping->contains('menu_id', EnumMenus::_USER_MANAGEMENT_ID))
                        <li class="nav-item">
                            <a href="{{ route('admin.user-management.index') }}" class="nav-link
                            @if($menuOpen == EnumMenus::_USER_MANAGEMENT_ID)
                                active
                            @endif">
                                <i class="fa fa-user-alt nav-icon"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        @endif

                        
                    </ul>
                </li>

                @endif

                {{-- <li class="nav-header">ARSIP DATA V1</li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Rekap Soal
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Rekap Peserta
                        </p>
                    </a>
                </li> --}}

                {{-- <li class="nav-header">Penilaian</li>
                <li class="nav-item">
                    <a href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Reset Penilaian Ujian
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Penilaian Ujian
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/gallery.html" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>
                            Laporan Ujian
                        </p>
                    </a>
                </li>--}}

                <li class="nav-header">LAIN - LAIN</li>
                @if ($roleMenuMapping->contains('menu_id', EnumMenus::_PROFILE_ID))
                <li class="nav-item">
                    <a href="{{ route('admin.profile.index') }}" class="nav-link
                            @if($menuOpen == EnumMenus::_PROFILE_ID)
                                active
                            @endif">
                        <i class="fa fa-user-cog nav-icon"></i>
                        <p>Profil</p>
                    </a>
                </li>
                @endif
                @if ($roleMenuMapping->contains('menu_id', EnumMenus::_CHANGE_PASSWORD_ID))
                <li class="nav-item">
                    <a href="{{ route('admin.profile.change-password.index') }}" class="nav-link
                            @if($menuOpen == EnumMenus::_CHANGE_PASSWORD_ID)
                                active
                            @endif">
                        <i class="fa fa-key nav-icon"></i>
                        <p>Ubah Password</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('admin.logout.action-logout') }}" class="nav-link">
                        <i class="fa fa-sign-out-alt nav-icon"></i>
                        <p>Logout</p>
                    </a>
                    {{-- <a class="nav-link" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-file"></i>
                        <p>{{ __('Logout') }}</p>
                    </a>

                    <form id="logout-form" action="{{ route('admin.logout.action-logout') }}" method="POST"
                        class="d-none">
                        @csrf
                    </form> --}}
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
