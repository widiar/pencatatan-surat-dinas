<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            {{-- <a href="{{ route('index') }}"><img src="{{ asset('images/icon/logo.png') }}" alt="logo"></a> --}}
            <a href="{{ route('index') }}"><h2 style="color: white">SPKD Badung</h2></a>
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
                    @can('view', App\Models\Perjalanan::class)
                    <li class="{{request()->is('perjalanan*') ? ' active' : '' }}">
                        <a href="{{ route('pencatatan.index') }}">
                            <i class="ti-book"></i><span>Perjalanan</span>
                        </a>
                    </li>
                    @endcan
                    @can('view', App\Models\LaporanDinas::class)
                    <li class="{{request()->is('laporan-dinas*') ? ' active' : '' }}">
                        <a href="{{ route('laporan-dinas.index') }}">
                            <i class="ti-agenda"></i><span>Laporan Dinas</span>
                        </a>
                    </li>
                    @endcan
                    @can('view', App\Models\Berkunjung::class)
                    <li class="{{request()->is('kunjungan*') ? ' active' : '' }}">
                        <a href="{{ route('kunjungan.index') }}">
                            <i class="ti-briefcase"></i><span>Kunjungan</span>
                        </a>
                    </li>
                    @endcan
                    <li class="{{request()->is('user-management*') ? ' active' : '' }}">
                        <a href="{{ route('user.index') }}">
                            <i class="ti-user"></i><span>User Management</span>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </div>
    </div>
</div>