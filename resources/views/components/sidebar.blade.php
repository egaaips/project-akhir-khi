<div>
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="../dashboard/index.html" class="b-brand text-primary">
                    <span>E-Presensi</span>
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                  
                    <x-sidebar.links title="Home" icon="ti ti-home" url="home" />
                    @if (Auth::user()->role_id == 1)                        
                    <x-sidebar.links title="Data User" icon="ti ti-users" url="users.index" />
                    <x-sidebar.links title="Data Pegawai" icon="ti ti-list" url="pegawai.index" />
                    <x-sidebar.links title="Data Departemen" icon="ti ti-tree" url="departemen.index" />
                    <x-sidebar.links title="Jadwal Kerja" icon="ti ti-calendar" url="jadwal.index" />
                    <x-sidebar.links title="Laporan" icon="ti ti-report" url="laporan.index" />
                    @endif
                    @if (Auth::user()->role_id == 2)                      
                    <x-sidebar.links title="Absensi" icon="ti ti-list" url="absensi.index" />
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
