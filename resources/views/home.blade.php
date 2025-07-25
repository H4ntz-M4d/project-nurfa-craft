<x-customers.layout>
    <div>
        <!-- Slider -->
        <section class="section-slide">
            <div class="wrap-slick1 rs1-slick1">
                <div class="slick1">
                    <div class="item-slick1"
                        style="background-image: url({{ asset('assets/media/misc/layout/auth-bg-1.png') }});">
                        <div class="container h-full">
                            <div class="flex-col-l-m h-full p-t-100 p-b-30">
                                <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                    <span class="ltext-202 cl2 respon2">
                                        Hi Customers
                                    </span>
                                </div>

                                <div class="layer-slick1 animated visible-false" data-appear="fadeInUp"
                                    data-delay="800">
                                    <h2 class="ltext-105 cl2 p-t-19 p-b-43 respon1">
                                        Welcome to Our Store
                                    </h2>
                                </div>

                                <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                    <a href="/product"
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                        Shop Now
                                    </a>
                                </div>
                                <style>
                                    .content-banner {
                                        position: absolute;
                                        height: 65%;
                                        top: 50%;
                                        right: 10%;
                                        transform: translateY(-50%);
                                        margin-right: 20px;
                                        max-width: 75%;
                                        border-radius: 0.5rem;
                                        box-shadow: 0 10px 12px rgba(0, 0, 0, 0.1);
                                    }
                                </style>
                                <div class="flex">
                                    <img class="d-none d-xl-block content-banner"
                                        src="{{ asset('assets/media/logos/logo-project.png') }}" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($banner as $banners)
                        <div class="item-slick1"
                            style="background-image: url({{ asset('storage/' . $banners->gambar) }});">
                            <div class="container h-full">
                                <div class="flex-col-l-m h-full p-t-100 p-b-30">
                                    <div class="layer-slick1 animated visible-false" data-appear="fadeInDown"
                                        data-delay="0">
                                        <span class="ltext-202 cl2 respon2">
                                            {{ $banners->judul }}
                                        </span>
                                    </div>

                                    <div class="layer-slick1 animated visible-false" data-appear="fadeInUp"
                                        data-delay="800">
                                        <h2 class="ltext-105 cl2 p-t-19 p-b-43 respon1">
                                            {{ $banners->label }}
                                        </h2>
                                    </div>

                                    <div class="layer-slick1 animated visible-false" data-appear="zoomIn"
                                        data-delay="1600">
                                        <a href="product.html"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                            Shop Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        <!-- Banner -->
        <div class="sec-banner bg0">
            <div class="flex-w flex-c-m">

                @foreach ($kategori as $ktg)
                    <div class="size-202 m-lr-auto respon4">
                        <!-- Block1 -->
                        <div class="block1 wrap-pic-w">
                            <img style="object-fit: cover" height="350px" src="{{ asset('storage/' . $ktg->gambar) }}" alt="{{ $ktg->nama_kategori }}">
                            <a href="{{ route('product.sort-by-category', ['id' => $ktg->id_ktg_produk]) }}"
                                class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                <div class="block1-txt-child1 flex-col-l">
                                    <span class="block1-name ltext-102 trans-04 p-b-8">
                                        {{ $ktg->nama_kategori }}
                                    </span>
                                </div>

                                <div class="block1-txt-child2 p-b-4 trans-05">
                                    <div class="block1-link stext-101 cl0 trans-09">
                                        Shop Now
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>


        <!-- Product -->
        <section class="sec-product bg0 p-t-100 p-b-50">
            <div class="container">
                <div class="p-b-32">
                    <h3 class="ltext-105 cl5 txt-center respon1">
                        Store Overview
                    </h3>
                </div>

                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#best-seller" role="tab">Best
                                Seller</a>
                        </li>

                        {{-- <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#featured" role="tab">Featured</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#sale" role="tab">Sale</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#top-rate" role="tab">Top Rate</a>
                        </li> --}}
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-50">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="best-seller" role="tabpanel">
                            <!-- Slide2 -->
                            <div class="wrap-slick2">
                                <div class="slick2">
                                    @foreach ($product_best as $item)
                                        <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                            <!-- Block2 -->
                                            <div class="block2">
                                                <div class="block2-pic hov-img0">
                                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                                        alt="IMG-PRODUCT">

                                                    <a href="/produk-shop-detail/{{ $item->slug }}"
                                                        class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                                        Quick View
                                                    </a>
                                                </div>

                                                <div class="block2-txt flex-w flex-t p-t-14">
                                                    <div class="block2-txt-child1 flex-col-l ">
                                                        <a href="product-detail.html"
                                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                            {{ $item->nama_produk }}
                                                        </a>

                                                        <span class="stext-105 cl3">
                                                            {{ $item->formatted_harga }}
                                                        </span>
                                                    </div>

                                                    {{-- <div class="block2-txt-child2 flex-r p-t-3">
                                                        <a href="#"
                                                            class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                            <img class="icon-heart1 dis-block trans-04"
                                                                src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                                alt="ICON">
                                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                                src="{{ asset('customers-asset/images/icons/icon-heart-02.png') }}"
                                                                alt="ICON">
                                                        </a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- - -->
                        {{-- <div class="tab-pane fade" id="featured" role="tabpanel">
                            <!-- Slide2 -->
                            <div class="wrap-slick2">
                                <div class="slick2">
                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-09.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Converse All Star Hi Plimsolls
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $75.00
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-10.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Femme T-Shirt In Stripe
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $25.85
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-11.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Herschel supply
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $63.16
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-12.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Herschel supply
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $63.15
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-13.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        T-Shirt with Sleeve
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $18.49
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-14.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Pretty Little Thing
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $54.79
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-02.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-15.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Mini Silver Mesh Watch
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $86.85
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-16.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Square Neck Back
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $29.64
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="sale" role="tabpanel">
                            <!-- Slide2 -->
                            <div class="wrap-slick2">
                                <div class="slick2">
                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-02.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Herschel supply
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $35.31
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-04.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Classic Trench Coat
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $75.00
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-06.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Vintage Inspired Classic
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $93.20
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-09.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Converse All Star Hi Plimsolls
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $75.00
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-11.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Herschel supply
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $63.16
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-13.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        T-Shirt with Sleeve
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $18.49
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-15.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Mini Silver Mesh Watch
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $86.85
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="top-rate" role="tabpanel">
                            <!-- Slide2 -->
                            <div class="wrap-slick2">
                                <div class="slick2">
                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-03.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Only Check Trouser
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $25.50
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-06.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Vintage Inspired Classic
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $93.20
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-07.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Shirt in Stretch Cotton
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $52.66
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-08.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Pieces Metallic Printed
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $18.96
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-02.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-09.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Converse All Star Hi Plimsolls
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $75.00
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-10.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Femme T-Shirt In Stripe
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $25.85
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <<img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                                src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                                alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-11.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Herschel supply
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $63.16
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-12.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Herschel supply
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $63.15
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-13.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        T-Shirt with Sleeve
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $18.49
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('customers-asset/images/product-16.jpg') }}"
                                                    alt="IMG-PRODUCT">

                                                <a href="#"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        Square Neck Back
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        $29.64
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('customers-asset/images/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>


        <!-- Blog -->
        <section class="sec-blog bg0 p-t-60 p-b-90">
            <div class="container">
                <div class="p-b-66">
                    <h3 class="ltext-105 cl5 txt-center respon1">
                        Our Blogs
                    </h3>
                </div>

                <div class="row">
                    @foreach ($blog as $blogs)
                        <div class="col-sm-6 col-md-4 p-b-40">
                            <div class="blog-item">
                                <div class="hov-img0">
                                    <a href="blog-detail/{{ $blogs->id_blog }}">
                                        <img height="300px" src="{{ asset('storage/' . $blogs->gambar) }}"
                                            alt="IMG-BLOG">
                                    </a>
                                </div>

                                <div class="p-t-15">
                                    <div class="stext-107 flex-w p-b-14">
                                        <span class="m-r-3">
                                            <span class="cl4">
                                                By
                                            </span>

                                            <span class="cl5">
                                                Nancy Ward
                                            </span>
                                        </span>

                                        <span>
                                            <span class="cl4">
                                                on
                                            </span>

                                            <span class="cl5">
                                                {{ \Carbon\Carbon::parse($blogs->created_at)->format('M d Y') }}
                                            </span>
                                        </span>
                                    </div>

                                    <h4 class="p-b-12">
                                        <a href="blog-detail/{{ $blogs->id_blog }}"
                                            class="mtext-101 cl2 hov-cl1 trans-04">
                                            {!! $blogs->judul !!}
                                        </a>
                                    </h4>

                                    <p class="stext-108 cl6">
                                        {!! Str::words(strip_tags($blogs->deskripsi), 30, '...') !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>
</x-customers.layout>
