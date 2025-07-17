<div>
    <header class="header-v2">
        <!-- Header desktop -->
        <div class="container-menu-desktop trans-03">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop p-l-45">

                    <!-- Logo desktop -->
                    <a href="#" class="logo">
                        <img alt="Logo" src="{{ asset('assets/media/logos/icon-logo-nurfa.png') }}" />
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            @auth
                                <li class="{{ Route::is('home') ? 'active-menu' : '' }}">
                                    <a href="/home">Home</a>
                                </li>

                                <li class="{{ Route::is('product.index') ? 'active-menu' : '' }}">
                                    <a href="/product">Shop</a>
                                </li>

                                <li class="{{ Route::is('blog') ? 'active-menu' : '' }}">
                                    <a href="/blog">Blog</a>
                                </li>

                                <li class="{{ Route::is('about') ? 'active-menu' : '' }}">
                                    <a href="/about">About</a>
                                </li>

                                <li class="{{ Route::is('contact') ? 'active-menu' : '' }}">
                                    <a href="/contact">Contact</a>
                                </li>

                                <li class="{{ Route::is('history.orders') ? 'active-menu' : '' }}">
                                    <a href="/history-order/{{ Auth::user()->slug }}">Histori Belanja</a>
                                </li>
                            @else
                                <li class="{{ Route::is('home') ? 'active-menu' : '' }}">
                                    <a href="/home">Home</a>
                                </li>

                                <li class="{{ Route::is('product.index') ? 'active-menu' : '' }}">
                                    <a href="{{ route('product.index') }}" class="modal-login">Shop</a>
                                </li>

                                <li class="{{ Route::is('blog') ? 'active-menu' : '' }}">
                                    <a href="/blog">Blog</a>
                                </li>

                                <li class="{{ Route::is('about') ? 'active-menu' : '' }}">
                                    <a href="/about">About</a>
                                </li>

                                <li class="{{ Route::is('contact') ? 'active-menu' : '' }}">
                                    <a href="/contact">Contact</a>
                                </li>
                            @endauth
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m h-full">

                        @if (Auth::check())
                            {{-- <div class="flex-c-m h-full p-lr-19">
                                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                            </div> --}}
                            <div class="flex-c-m h-full p-l-18 p-r-25 bor5">
                                <a href="/shopping/{{ Auth::user()->slug }}" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 {{-- icon-header-noti --}} 
                                    {{ Route::is('shoping') ? 'active-menu' : '' }} "
                                    {{-- data-notify="2" --}}>
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </a>
                            </div>

                            <div class="mx-2">
                                <form method="POST" action="{{ route('logout') }}"
                                    class="btn btn-active-light-success">
                                    @csrf
                                    <a :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11">
                                        <i class="zmdi zmdi-sign-in"></i>
                                    </a>
                                </form>
                            </div>
                        @else
                            <div class="flex-c-m h-full p-l-18 p-r-25 bor5">
                                <a href="{{ route('login') }}" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 {{-- icon-header-noti --}} 
                                    {{ Route::is('shoping') ? 'active-menu' : '' }} "
                                    {{-- data-notify="2" --}}>
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </a>
                            </div>
                            <div class="mx-2">
                                <a href="{{ route('login') }}" class="btn btn-active-light-success">Login</a>
                            </div>
                            <div class="mx-2">
                                <a href="{{ route('register') }}" class="btn btn-active-light-success">Sign Up</a>
                            </div>
                        @endif
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="index.html">
                    <img alt="Logo" src="{{ asset('assets/media/logos/icon-logo-nurfa.png') }}" />
                </a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">

                <div class="flex-c-m h-full p-lr-10 bor5">
                    @if (Auth::check()) 
                        <a href="/shopping/{{ Auth::user()->slug }}" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 {{-- icon-header-noti --}} 
                            {{ Route::is('shoping') ? 'active-menu' : '' }} "
                            {{-- data-notify="2" --}}>
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>
                    @else 
                        <a href="{{ route('login') }}" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 {{-- icon-header-noti --}} 
                            {{ Route::is('shoping') ? 'active-menu' : '' }} "
                            {{-- data-notify="2" --}}>
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="main-menu-m">
                @auth
                    <li class="{{ Route::is('home') ? 'active-menu' : '' }}">
                        <a href="/home">Home</a>
                    </li>

                    <li class="{{ Route::is('product.index') ? 'active-menu' : '' }}">
                        <a href="/product">Shop</a>
                    </li>

                    <li class="{{ Route::is('blog') ? 'active-menu' : '' }}">
                        <a href="/blog">Blog</a>
                    </li>

                    <li class="{{ Route::is('about') ? 'active-menu' : '' }}">
                        <a href="/about">About</a>
                    </li>

                    <li class="{{ Route::is('contact') ? 'active-menu' : '' }}">
                        <a href="/contact">Contact</a>
                    </li>
                    <li class="{{ Route::is('history.orders') ? 'active-menu' : '' }}">
                        <a href="/history-order/{{ Auth::user()->slug }}">Histori Belanja</a>
                    </li>
                    
                    <li class="{{ Route::is('logout') ? 'active-menu' : '' }}">
                        <form method="POST" action="{{ route('logout') }}" style="margin-left: 21px; margin-top: 7px;">
                            @csrf
                            <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    </li>
                @else
                    <li class="{{ Route::is('home') ? 'active-menu' : '' }}">
                        <a href="/home">Home</a>
                    </li>

                    <li class="{{ Route::is('product.index') ? 'active-menu' : '' }}">
                        <a href="{{ route('product.index') }}" class="modal-login">Shop</a>
                    </li>

                    
                    <li class="{{ Route::is('blog') ? 'active-menu' : '' }}">
                        <a href="/blog">Blog</a>
                    </li>
                    
                    <li class="{{ Route::is('about') ? 'active-menu' : '' }}">
                        <a href="/about">About</a>
                    </li>
                    
                    <li class="{{ Route::is('contact') ? 'active-menu' : '' }}">
                        <a href="/contact">Contact</a>
                    </li>

                    <li class="{{ Route::is('login') ? 'active-menu' : '' }}" {{-- class="label1" data-label1="hot" --}}>
                        <a href="{{ route('login') }}" class="modal-login">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </header>
</div>
