<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('index') }}"><img src="{{ asset('images/icon/logo.png') }}" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{request()->is('/') ? ' active' : '' }}">
                        <a href="{{ route('index') }}">
                            <i class="ti-dashboard"></i><span>Dashboard</span>
                        </a>
                    </li>

                    <li class="{{request()->is('pencatatan/*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="ti-receipt"></i><span>Pencatatan Surat</span>
                        </a>
                    </li>
                    <li class="{{request()->is('pencatatan/*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="ti-receipt"></i><span>Laporan Dinas</span>
                        </a>
                    </li>
                    <li class="{{request()->is('pencatatan/*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="ti-receipt"></i><span>Berkunjung</span>
                        </a>
                    </li>
                    <li class="{{request()->is('pencatatan/*') ? ' active' : '' }}">
                        <a href="#">
                            <i class="ti-receipt"></i><span>User Management</span>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </div>
    </div>
</div>