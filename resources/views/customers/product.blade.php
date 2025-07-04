<x-customers.layout>
    <div class="bg0 m-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    @php
                        $currentKategoriId = request()->segment(3); // ambil segment kategori
                    @endphp

                    <a href="{{ route('product.index') }}">
                        <button
                            class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ request()->is('product') ? 'how-active1' : '' }}"
                            data-id="all">
                            All Products
                        </button>
                    </a>

                    @foreach ($kategori as $item)
                        <a href="{{ route('product.sort-by-category', $item->id_ktg_produk) }}">
                            <button
                                class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $currentKategoriId == $item->id_ktg_produk ? 'how-active1' : '' }}"
                                data-id="{{ $item->id_ktg_produk }}">
                                {{ $item->nama_kategori }}
                            </button>
                        </a>
                    @endforeach

                </div>
            </div>

            <div class="row isotope-grid" id="product-container">
                @foreach ($product_all as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $item->id_ktg_produk }}">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="IMG-PRODUCT">

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
                                        <strong>{{ $item->formatted_harga ?? '0' }}</strong>
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-45">
                <form method="GET" action="{{ url()->current() }}">
                    <input type="hidden" name="limit" value="{{ $limit + 16 }}">
                    <button type="submit" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                        Load More
                    </button>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.btn-filter-category').on('click', function() {
                    var kategoriId = $(this).data('id');
                    var url = kategoriId === 'all' ? '/product' : '/product/kategori/' + kategoriId;

                    // Tambahkan animasi fade-out
                    $('#product-container').fadeOut(200);

                    // Ambil data pakai AJAX
                    $.get(url, function(data) {
                        // Ambil hanya bagian produk dari response
                        var html = $(data).find('#product-container').html();

                        // Masukkan ke container & animasi fade-in
                        $('#product-container').html(html).fadeIn(200);
                    });

                    // Highlight tombol yang aktif
                    $('.btn-filter-category').removeClass('how-active1');
                    $(this).addClass('how-active1');
                });
            });
        </script>
    @endpush
</x-customers.layout>
