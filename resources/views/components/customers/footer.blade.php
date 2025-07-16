<div>
    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Categories
                    </h4>

                    <ul>
                        @foreach ($kategori_footer as $kategori)
                            <li class="p-b-10">
                                <a href="{{ route('product.sort-by-category', $kategori->id_ktg_produk) }}"
                                    class="stext-107 cl7 hov-cl1 trans-04">
                                    {{ $kategori->nama_kategori }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>


                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        ADDRESS
                    </h4>

                    <p class="stext-107 cl7 size-201">
                        Nurfa Craft Badan, RT.02, Badan, Panjangrejo, Kec. Pundong, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55771
                    </p>
                </div>


                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        SOCIAL MEDIA
                    </h4>

                    <div class="p-t-10">
                        <a href="https://web.facebook.com/tasrajutjogjanurfa" 
                        class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="https://www.instagram.com/nurfacraft_jogja/" 
                        class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-instagram"></i>
                        </a>

                        <a href="https://wa.me/62089697000760" 
                        class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
                <p class="stext-107 cl6 txt-center">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> Nurfa Craft 
                </p>
            </div>
        </div>
    </footer>
</div>
