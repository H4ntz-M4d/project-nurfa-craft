<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo d-none d-md-block pt-7 px-8 pt-xl-11 mb-2" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="index.html">
            <img alt="Logo" src="{{ asset('assets/media/logos/icon-logo-nurfa.png') }}" class="h-50px theme-light-show" />
            <img alt="Logo" src="{{ asset('assets/media/logos/icon-logo-nurfa-dark.png') }}" class="h-50px theme-dark-show" />
        </a>
        <!--end::Logo image-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu app-sidebar-menu-arrow overflow-hidden flex-column-fluid mb-5" id="kt_app_sidebar_menu">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention menu-active-bg" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::is('dashboard') ? 'here' : '' }}">
                    <!--begin:Menu link-->
                    <a href="/dashboard" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-black-right fs-3"></i>
                        </span>
                        <span class="menu-title">Dashboards</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::is('karyawan.*','users.index','customers.*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-black-right fs-3"></i>
                        </span>
                        <span class="menu-title">Manajemen Users</span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::is('karyawan.*') ? 'here show' : '' }}">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pegawai</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ Route::is(['karyawan.list','karyawan.view']) ? 'active' : '' }}" href="/list-karyawan">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">List Pegawai</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ Route::is('karyawan.gaji') ? 'active' : '' }}" href="/list-gaji">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">List Gaji Pegawai</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('customers.index') ? 'active' : '' }}" href="/list-customers">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Customers</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('users.index') ? 'active' : '' }}" href="/users">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Master Users</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::is('kategori.*','produk.*','stocks.*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-black-right fs-3"></i>
                        </span>
                        <span class="menu-title">Catalog</span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('kategori.*') ? 'active' : '' }}" href="/list-kategori">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Kategori</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('produk.*') ? 'active' : '' }}" href="/list-produk">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Produk</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('stocks.*') ? 'active' : '' }}" href="/list-stocks-produk">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Kelola Stok</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::is('laporan.*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-black-right fs-3"></i>
                        </span>
                        <span class="menu-title">Laporan</span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Produk dilihat</span>
                            </span>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('laporan.*') ? 'active' : '' }}" href="/list-stocks-record">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Laporan Stok</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Transaksi</span>
                            </span>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Pengeluaran</span>
                            </span>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::is('home-banner.*','blog-post.*','variant.*','about.*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-black-right fs-3"></i>
                        </span>
                        <span class="menu-title">Utilities</span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('home-banner.*') ? 'active' : '' }}" href="/home-banner">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Banner Beranda</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('blog-post.*') ? 'active' : '' }}" href="/blog-post">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Postingan Blog</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('about.*') ? 'active' : '' }}" href="/list-about">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Tentang Kami</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::is('variant.*') ? 'active' : '' }}" href="/list-variant">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Variant Produk</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                {{-- <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link" href="authentication/layouts/corporate/sign-in.html">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-entrance-right fs-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Logout</span>
                    </a>
                    <!--end:Menu link-->
                </div> --}}
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>