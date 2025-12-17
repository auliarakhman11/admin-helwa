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


                <li class="mm-active">
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

                <li class="mm-active">
                    <a href="javascript: void(0);"
                        class="has-arrow waves-effect {{ Request::is(['karyawan']) ? 'mm-active' : '' }}">
                        <div class="d-inline-block icons-sm me-1"><i class="fas fa-address-book"></i>
                        </div>
                        <span>Karyawan</span>
                    </a>
                    <ul class="sub-menu {{ Request::is(['karyawan', 'cluster']) ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="false">
                        <li class="{{ Request::is('karyawan') ? 'mm-active' : '' }}"><a href="{{ route('karyawan') }}"
                                class="{{ Request::is('karyawan') ? 'active' : '' }}">List Karyawan</a></li>
                    </ul>
                </li>

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
