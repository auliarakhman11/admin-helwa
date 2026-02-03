<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                {{-- <li>
                    <a href="index.html" class="waves-effect">
                        <div class="d-inline-block icons-sm me-1"><i class="uim uim-airplay"></i></div><span
                            class="badge rounded-pill text-bg-success float-end">3</span>
                        <span>Dashboard</span>
                    </a>
                </li> --}}

                <li class="{{ Request::is(['penjualan', '/', 'member', 'diskon']) ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow waves-effect {{ Request::is(['penjualan', '/', 'member', 'diskon']) ? 'mm-active' : '' }}">
                        <div class="d-inline-block icons-sm me-1"><i class="fas fa-address-book"></i>
                        </div>
                        <span>Penjualan</span>
                    </a>
                    <ul class="sub-menu {{ Request::is(['penjualan', '/', 'member', 'diskon']) ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="false">
                        <li class="{{ Request::is('/') ? 'mm-active' : '' }}"><a href="{{ route('dashboard') }}"
                                class="{{ Request::is('/') ? 'active' : '' }}">Dashboard</a></li>
                        <li class="{{ Request::is('penjualan') ? 'mm-active' : '' }}"><a href="{{ route('penjualan') }}"
                                class="{{ Request::is('penjualan') ? 'active' : '' }}">List Penjualan</a></li>
                        <li class="{{ Request::is('member') ? 'mm-active' : '' }}"><a href="{{ route('member') }}"
                                class="{{ Request::is('member') ? 'active' : '' }}">List Member</a></li>
                        <li class="{{ Request::is('diskon') ? 'mm-active' : '' }}"><a href="{{ route('diskon') }}"
                                class="{{ Request::is('diskon') ? 'active' : '' }}">List Diskon</a></li>

                    </ul>
                </li>

                <li class="{{ Request::is(['akunPengeluaran', 'pengeluaran']) ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow waves-effect {{ Request::is(['akunPengeluaran', 'pengeluaran']) ? 'mm-active' : '' }}">
                        <div class="d-inline-block icons-sm me-1"><i class="fas fa-calculator"></i>
                        </div>
                        <span>Pengeluaran</span>
                    </a>
                    <ul class="sub-menu {{ Request::is(['akunPengeluaran', 'pengeluaran']) ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="false">
                        <li class="{{ Request::is('akunPengeluaran') ? 'mm-active' : '' }}"><a
                                href="{{ route('akunPengeluaran') }}"
                                class="{{ Request::is('akunPengeluaran') ? 'active' : '' }}">List Akun</a></li>
                        <li class="{{ Request::is('pengeluaran') ? 'mm-active' : '' }}"><a
                                href="{{ route('pengeluaran') }}"
                                class="{{ Request::is('pengeluaran') ? 'active' : '' }}">List Pengeluaran</a></li>

                    </ul>
                </li>


                <li class="{{ Request::is(['bahan', 'products']) ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow waves-effect {{ Request::is(['bahan', 'products']) ? 'mm-active' : '' }}">
                        <div class="d-inline-block icons-sm me-1"><i class="fas fa-box-open"></i>
                        </div>
                        <span>Produk</span>
                    </a>
                    <ul class="sub-menu {{ Request::is(['ukuran', 'products', 'cluster']) ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="false">
                        <li class="{{ Request::is('ukuran') ? 'mm-active' : '' }}"><a href="{{ route('ukuran') }}"
                                class="{{ Request::is('ukuran') ? 'active' : '' }}">Ukuran</a></li>
                        <li class="{{ Request::is('cluster') ? 'mm-active' : '' }}"><a href="{{ route('cluster') }}"
                                class="{{ Request::is('cluster') ? 'active' : '' }}">Cluster</a></li>
                        {{-- <li class="{{ Request::is('bahan') ? 'mm-active' : '' }}"><a href="{{ route('bahan') }}"
                                class="{{ Request::is('bahan') ? 'active' : '' }}">Bahan</a></li> --}}
                        <li class="{{ Request::is('products') ? 'mm-active' : '' }}"><a href="{{ route('products') }}"
                                class="{{ Request::is('products') ? 'active' : '' }}">Produk</a></li>
                    </ul>
                </li>

                <li class="{{ Request::is(['investor', 'pengeluaranInvestor']) ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow waves-effect {{ Request::is(['investor', 'pengeluaranInvestor']) ? 'mm-active' : '' }}">
                        <div class="d-inline-block icons-sm me-1"><i class="fas fa-user-tie"></i>
                        </div>
                        <span>Investor</span>
                    </a>
                    <ul class="sub-menu {{ Request::is(['investor', 'pengeluaranInvestor']) ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="false">
                        <li class="{{ Request::is('investor') ? 'mm-active' : '' }}"><a href="{{ route('investor') }}"
                                class="{{ Request::is('investor') ? 'active' : '' }}">List Investor</a></li>
                        <li class="{{ Request::is('pengeluaranInvestor') ? 'mm-active' : '' }}"><a
                                href="{{ route('pengeluaranInvestor') }}"
                                class="{{ Request::is('pengeluaranInvestor') ? 'active' : '' }}">Pengeluaran
                                Investor</a></li>
                    </ul>
                </li>

                <li class="{{ Request::is(['karyawan', 'absen']) ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow waves-effect {{ Request::is(['karyawan', 'absen']) ? 'mm-active' : '' }}">
                        <div class="d-inline-block icons-sm me-1"><i class="fas fa-address-book"></i>
                        </div>
                        <span>Karyawan</span>
                    </a>
                    <ul class="sub-menu {{ Request::is(['karyawan', 'absen']) ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="false">
                        <li class="{{ Request::is('karyawan') ? 'mm-active' : '' }}"><a href="{{ route('karyawan') }}"
                                class="{{ Request::is('karyawan') ? 'active' : '' }}">List Karyawan</a></li>
                        <li class="{{ Request::is('absen') ? 'mm-active' : '' }}"><a href="{{ route('absen') }}"
                                class="{{ Request::is('absen') ? 'active' : '' }}">List Absen</a></li>
                    </ul>
                </li>

                <li class="{{ Request::is(['user']) ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow waves-effect {{ Request::is(['user']) ? 'mm-active' : '' }}">
                        <div class="d-inline-block icons-sm me-1"><i class="fas fa-users-cog"></i>
                        </div>
                        <span>User</span>
                    </a>
                    <ul class="sub-menu {{ Request::is(['user']) ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="false">
                        <li class="{{ Request::is('user') ? 'mm-active' : '' }}"><a href="{{ route('user') }}"
                                class="{{ Request::is('user') ? 'active' : '' }}">List User</a></li>
                    </ul>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
