<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home 02</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('assets/media/logos/logo-project.png') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('customers-asset/vendor/bootstrap/css/bootstrap.min.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/fonts/iconic/css/material-design-iconic-font.min.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/fonts/linearicons-v1.0.0/icon-font.min.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('customers-asset/vendor/animate/animate.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/vendor/css-hamburgers/hamburgers.min.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/vendor/animsition/css/animsition.min.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('customers-asset/vendor/select2/select2.min.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/vendor/daterangepicker/daterangepicker.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('customers-asset/vendor/slick/slick.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/vendor/MagnificPopup/magnific-popup.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('customers-asset/vendor/perfect-scrollbar/perfect-scrollbar.css') }} ">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('customers-asset/css/util.css') }} ">
    <link rel="stylesheet" type="text/css" href="{{ asset('customers-asset/css/main.css') }} ">
    <!--===============================================================================================-->
</head>

<body class="animsition">

    <!-- Header -->
    <x-customers.header></x-customers.header>

    <!-- Sidebar -->
    <x-customers.sidebar></x-customers.sidebar>


    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Your Cart
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="{{ asset('customers-asset/images/item-cart-01.jpg') }}" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                White Shirt Pleat
                            </a>

                            <span class="header-cart-item-info">
                                1 x $19.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="{{ asset('customers-asset/images/item-cart-02.jpg') }}" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Converse All Star
                            </a>

                            <span class="header-cart-item-info">
                                1 x $39.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="{{ asset('customers-asset/images/item-cart-03.jpg') }}" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Nixon Porter Leather
                            </a>

                            <span class="header-cart-item-info">
                                1 x $17.00
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: $75.00
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="shoping-cart.html"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="shoping-cart.html"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $slot }}


    <!-- Footer -->
    <x-customers.footer></x-customers.footer>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>



    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('customers-asset/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('customers-asset/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('customers-asset/js/slick-custom.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/parallax100/parallax100.js') }}"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/isotope/isotope.pkgd.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $('.js-addwish-b2').on('click', function(e) {
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function() {
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });

        /*---------------------------------------------*/
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script>
        $('.js-pscroll').each(function() {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function() {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('customers-asset/js/main.js') }}"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    @stack('scripts')

</body>

</html>
