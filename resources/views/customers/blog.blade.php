<x-customers.layout>
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('customers-asset/images/bg-02.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            Blog
        </h2>
    </section>


    <!-- Content page -->
    <section class="bg0 p-t-62 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        <div id="blog-container">
                            @include('customers.blog-data')
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 p-b-80">
                    <div class="side-menu">
                        <div class="p-t-55">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Categories
                            </h4>

                            <ul>
                                @foreach ($kategori as $kategorie)
                                    <li class="bor18">
                                        <a href="{{ route('product.sort-by-category', $kategorie->id_ktg_produk) }}"
                                            class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                            {{ $kategorie->nama_kategori }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="p-t-65">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Featured Products
                            </h4>

                            <ul>
                                @foreach ($product_featured as $produks)
                                    <li class="flex-w flex-t p-b-30">
                                        <a href="/produk-shop-detail/{{ $produks->slug }}"
                                            class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                            <img src="{{ asset('storage/' . $produks->gambar) }}" alt="PRODUCT"
                                                style="width: 90px; height: 120px; object-fit: cover;">
                                        </a>

                                        <div class="size-215 flex-col-t p-t-8">
                                            <a href="/produk-shop-detail/{{ $produks->slug }}"
                                                class="stext-116 cl8 hov-cl1 trans-04">
                                                {{ $produks->nama_produk }}
                                            </a>

                                            <span class="stext-116 cl6 p-t-20">
                                                Rp{{ number_format($produks->harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).on('click', '.custom-pagination a', function(e) {
                e.preventDefault();
                let page = $(this).data('page');

                $.ajax({
                    url: "{{ url('/blog') }}?page=" + page,
                    type: "GET",
                    success: function(data) {
                        $('#blog-container').html(data);
                        $('html, body').animate({
                            scrollTop: $("#blog-container").offset().top
                        }, 500);
                    },
                    error: function() {
                        alert("Gagal memuat data.");
                    }
                });
            });
        </script>
    @endpush
</x-customers.layout>
