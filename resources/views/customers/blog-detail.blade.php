<x-customers.layout>
    <!-- Content page -->
    <section class="bg0 p-t-52 p-b-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        <!--  -->
                        <div class="wrap-pic-w how-pos5-parent">
                            <img src="{{ asset('storage/' . $data->gambar) }}" alt="IMG-BLOG">

                            <div class="flex-col-c-m size-123 bg9 how-pos5">
                                <span class="ltext-107 cl2 txt-center">
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d') }}
                                </span>

                                <span class="stext-109 cl3 txt-center">
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('M Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="p-t-32">
                            <span class="flex-w flex-m stext-111 cl2 p-b-19">
                                <span>
                                    <span class="cl4">By</span> Admin
                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                </span>

                                <span>
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                </span>

                                <span>
                                    StreetStyle, Fashion, Couple
                                    <span class="cl12 m-l-4 m-r-6">|</span>
                                </span>

                                <span>
                                    8 Comments
                                </span>
                            </span>

                            <h4 class="ltext-109 cl2 p-b-28">
                                {!! $data->judul !!}
                            </h4>

                            {{ html_entity_decode(strip_tags($data->deskripsi)) }}
                        </div>

                        <div class="flex-w flex-t p-t-16">
                            <span class="size-216 stext-116 cl8 p-t-4">
                                Tags
                            </span>

                            <div class="flex-w size-217">
                                @foreach (json_decode($data->tag, true) as $tag)
                                    <span
                                        class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                        {{ $tag['value'] }}
                                    </span>
                                @endforeach

                                <a href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Crafts
                                </a>
                            </div>
                        </div>

                        <!--  -->
                        <div class="p-t-40">
                            <h5 class="mtext-113 cl2 p-b-12">
                                Leave a Comment
                            </h5>

                            <p class="stext-107 cl6 p-b-40">
                                Your email address will not be published. Required fields are marked *
                            </p>

                            <form id="commentForm">
                                @csrf
                                <input type="hidden" name="id_blog" value="{{ $data->id_blog }}">
                                <div class="bor19 m-b-20">
                                    <textarea id="commentText" class="stext-111 cl2 plh3 size-124 p-lr-18 p-tb-15" name="comment" placeholder="Comment..."></textarea>
                                </div>

                                <button type="submit"
                                    class="flex-c-m stext-101 cl0 size-125 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-30">
                                    Post Comment
                                </button>
                            </form>
                            <div id="commentList" class="comment-list">
                                @foreach ($komentar as $komen)
                                    <div class="m-b-32 ">
                                        <strong>{{ $komen->username }}</strong><br>
                                        <p>{{ $komen->comment }}</p>
                                        <small>{{ \Carbon\Carbon::parse($komen->created_at)->diffForHumans() }}</small>
                                        <hr>
                                    </div>
                                @endforeach
                            </div>
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
                                @foreach ($kategori as $kategoris)
                                    <li class="bor18">
                                        <a href="{{ route('product.sort-by-category', $kategoris->id_ktg_produk) }}"
                                            class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                            {{ $kategoris->nama_kategori }}
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
                                @foreach ($product_featured as $produk)
                                    <li class="flex-w flex-t p-b-30">
                                        <a href="/produk-shop-detail/{{ $produk->slug }}"
                                            class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="PRODUCT"
												style="width: 90px; height: 120px; object-fit: cover;">
                                        </a>

                                        <div class="size-215 flex-col-t p-t-8">
                                            <a href="/produk-shop-detail/{{ $produk->slug }}"
                                                class="stext-116 cl8 hov-cl1 trans-04">
                                                {{ $produk->nama_produk }}
                                            </a>

                                            <span class="stext-116 cl6 p-t-20">
                                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
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
</x-customers.layout>
