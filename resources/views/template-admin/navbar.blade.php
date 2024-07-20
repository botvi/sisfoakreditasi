<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('env') }}/mts.png" width="30px" srcset="">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">SISFO AKREDITAS</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        @if(Auth::user()->role == 'guru' || Auth::user()->role == 'kepalasekolah' || Auth::user()->role == 'admin')
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'kepalasekolah' || Auth::user()->role == 'admin')
        <li class="menu-item {{ Request::is('kepala-sekolah') ? 'active' : '' }}">
            <a href="/kepala-sekolah" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-crown"></i>
                <div data-i18n="Analytics">Kepala Sekolah</div>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'admin')
        <li class="menu-item {{ Request::is('data-gurus') ? 'active' : '' }}">
            <a href="/data-gurus" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Data Guru</div>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'guru' || Auth::user()->role == 'kepalasekolah' || Auth::user()->role == 'admin')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">STANDAR AKREDITASI</span>
        </li>
        <li class="menu-item {{ Request::is('standar-isis') ? 'active' : '' }}">
            <a href="/standar-isis" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Isi</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('standar-proses') ? 'active' : '' }}">
            <a href="/standar-proses" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Proses</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('standar-kompetensi-lulusan') ? 'active' : '' }}">
            <a href="/standar-kompetensi-lulusan" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Kompetensi Lulusan</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('standar-pendidikan') ? 'active' : '' }}">
            <a href="/standar-pendidikan" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Pendidik & Tenpen</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('standar-sarana') ? 'active' : '' }}">
            <a href="/standar-sarana" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Sarana & Pra</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('standar-pengelolaan') ? 'active' : '' }}">
            <a href="/standar-pengelolaan" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Pengelolaan</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('standar-pembiayaan') ? 'active' : '' }}">
            <a href="/standar-pembiayaan" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Pembiayaan</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('standar-penilaian') ? 'active' : '' }}">
            <a href="/standar-penilaian" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                <div data-i18n="Analytics">Standar Penilaian</div>
            </a>
        </li>
        @endif

        @if(Auth::user()->role == 'kepalasekolah' || Auth::user()->role == 'admin')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">LAPORAN</span>
        </li>
        <li class="menu-item {{ Request::is('laporan') ? 'active' : '' }}">
            <a href="/laporan" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-printer"></i>
                <div data-i18n="Analytics">Laporan</div>
            </a>
        </li>
        @endif
    </ul>
</aside>
