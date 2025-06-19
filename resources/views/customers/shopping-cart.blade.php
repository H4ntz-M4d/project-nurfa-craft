<x-customers.layout>
    <!-- Shoping Cart -->
    <div class="bg0 p-t-75 p-b-85">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl m-b-50">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Quantity</th>
                                    <th class="column-5">Total</th>
                                    <th class="column-5">Hapus</th>
                                </tr>

                                @foreach ($keranjangAda as $cart)
                                    @php
                                        $produk = $cart->produk_master;
                                        $variantText = '';
                                        $selectedVariantValueIds = $cart->keranjang_variant
                                            ->pluck('produk_variant_value.id_variant_value')
                                            ->sort()
                                            ->values();

                                        if ($cart->keranjang_variant->isNotEmpty()) {
                                            $variantText = $cart->keranjang_variant
                                                ->map(function ($v) {
                                                    return $v->produk_variant_value->variantAttribute->nama_variant .
                                                        ': ' .
                                                        $v->produk_variant_value->variantValues->value;
                                                })
                                                ->implode(', ');
                                        }

                                        $harga = $produk->detailProduk->first()->harga ?? 0;

                                        if ($produk->variant->isNotEmpty()) {
                                            foreach ($produk->variant as $variant) {
                                                $variantValueIds = $variant->variantValues
                                                    ->pluck('id_variant_value')
                                                    ->sort()
                                                    ->values();

                                                if ($variantValueIds->toJson() === $selectedVariantValueIds->toJson()) {
                                                    $harga = $variant->harga;
                                                    break;
                                                }
                                            }
                                        }

                                        $total = $harga * $cart->jumlah;
                                    @endphp
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">
                                            {{ $produk->nama_produk }} <br>
                                            @if ($variantText)
                                                <small class="text-muted">{{ $variantText }}</small>
                                            @endif
                                        </td>
                                        <td class="column-3">Rp{{ number_format($harga, 0, ',', '.') }}</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    min="1" name="num-product1" value="{{ $cart->jumlah }}"
                                                    data-slug="{{ $cart->slug }}" disabled>

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5 tot-item">
                                            Rp{{ number_format($total, 0, ',', '.') }}
                                        </td>
                                        <td class="column-5">
                                            <a href="#" class="btn btn-sm btn-danger btn-delete-cart"
                                                data-slug="{{ $cart->slug }}">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach


                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w flex-m m-r-20 m-tb-5">
                                <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                    name="coupon" placeholder="Coupon Code">

                                <div
                                    class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    Apply coupon
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($keranjangHabis->isNotEmpty())
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <h3 class="stext-110 cl2 text-danger">Produk Telah Habis</h3>
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <tr class="table_head">
                                        <th class="column-1">Product</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Price</th>
                                        <th class="column-5">Hapus</th>
                                    </tr>
                                    @foreach ($keranjangHabis as $item)
                                        @php
                                            $produk = $item->produk_master;
                                            $variantText = '';
                                            $selectedVariantValueIds = $item->keranjang_variant
                                                ->pluck('produk_variant_value.id_variant_value')
                                                ->sort()
                                                ->values();
                                            if ($item->keranjang_variant->isNotEmpty()) {
                                                $variantText = $item->keranjang_variant
                                                    ->map(function ($v) {
                                                        return $v->produk_variant_value->variantAttribute
                                                            ->nama_variant .
                                                            ': ' .
                                                            $v->produk_variant_value->variantValues->value;
                                                    })
                                                    ->implode(', ');
                                            }
                                            $harga = $produk->detailProduk->first()->harga ?? 0;
                                            if ($produk->variant->isNotEmpty()) {
                                                foreach ($produk->variant as $variant) {
                                                    $variantValueIds = $variant->variantValues
                                                        ->pluck('id_variant_value')
                                                        ->sort()
                                                        ->values();
                                                    if (
                                                        $variantValueIds->toJson() ===
                                                        $selectedVariantValueIds->toJson()
                                                    ) {
                                                        $harga = $variant->harga;
                                                        break;
                                                    }
                                                }
                                            }
                                            $total = $harga * $item->jumlah;
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <div class="how-itemcart1">
                                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="IMG"
                                                        style="opacity: 50%">
                                                </div>
                                            </td>
                                            <td class="column-2" style="opacity: 50%">
                                                {{ $produk->nama_produk }} <br>
                                                @if ($variantText)
                                                    <small class="text-muted">{{ $variantText }}</small>
                                                @endif
                                            </td>
                                            <td class="column-3" style="opacity: 50%">
                                                Rp{{ number_format($harga, 0, ',', '.') }}</td>
                                            <td class="column-5">
                                                <a href="#" class="btn btn-sm btn-danger btn-delete-cart"
                                                    data-slug="{{ $item->slug }}">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
                </div>


                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <form id="form-checkout" action="{{ route('checkout') }}" method="POST">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Cart Totals
                            </h4>
                            <div class="flex-w flex-t bor12 p-b-13">
                                <div class="size-208">
                                    <span class="stext-110 cl2">
                                        Subtotal:
                                    </span>
                                </div>
                                <div class="size-209 mtext-110 d-flex">
                                    Rp<input class="mtext-110 cl2 cart-subtotal" name="subtotal" type="text"
                                        value="{{ number_format($subtotal, 0, ',', '.') }}" readonly>
                                </div>
                            </div>

                            <div class="bor12 p-t-27 p-b-13">
                                <div class="size-209 m-b-10">
                                    <span class="stext-110 cl2">
                                        Alamat Pengiriman:
                                    </span>
                                </div>
                                <div class="p-t-10">
                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="js-select2" name="provinsi" id="provinsi">
                                            <option>Pilih Provinsi</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                        @error('provinsi')
                                            <small class="form-text text-danger error-message"
                                                data-for="provinsi">{{ $message }}</small>
                                        @enderror

                                    </div>
                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="js-select2" name="kota" id="kabupaten">
                                            <option>Pilih Kabupaten</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                        @error('kabupaten')
                                            <small class="form-text text-danger error-message"
                                                data-for="kabupaten">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <input class="form-control m-b-12" placeholder="No.Handphone" name="telepon"
                                        type="text" value="">

                                </div>
                                <div class="bor8 m-b-30">
                                    <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="alamat_pengiriman"
                                        placeholder="Add your address"></textarea>
                                </div>
                            </div>
                            <div class="flex-w flex-t p-t-27 p-b-33">
                                <div class="size-208">
                                    <span class="mtext-101 cl2">
                                        Total:
                                    </span>
                                </div>
                                <div class="size-209 p-t-1">
                                    Rp<input class="mtext-110 cl2 cart-total" name="total" type="text"
                                        value="{{ number_format($subtotal, 0, ',', '.') }}" readonly>

                                    <!-- Untuk dikirim ke backend -->
                                    <input type="hidden" name="total" value="{{ $subtotal }}">
                                </div>
                            </div>
                            <button id="btn-checkout" type="button"
                                class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Checkout
                            </button>

                            <div id="snap-container" class="m-t-30"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/get-provinsi.js') }}"></script>
        <script src="{{ asset('assets/js/custom/checkout-produk.js') }}"></script>

        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
        </script>
       

        <script>
            var oldJenisKelamin = "{{ old('jenis_kelamin') }}";
            var oldProvinsi = "{{ old('provinsi') }}";
            var oldKabupaten = "{{ old('kabupaten') }}";
        </script>

        <script>
            $(document).ready(function() {
                $('.table-shopping-cart').on('click', '.btn-delete-cart', function(e) {
                    e.preventDefault();
                    let slug = $(this).data('slug');
                    let $row = $(this).closest('tr');

                    $.ajax({
                        url: '/delete-shopping-cart/' + slug,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                $row.remove(); // Hapus baris item dari tabel
                                $('.cart-subtotal').val(res.formatted_subtotal);
                                $('.cart-total').text('Rp' + res.formatted_subtotal);

                            } else {
                                alert('Gagal menghapus item');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus item');
                        }
                    });
                });
            });
        </script>
    @endpush

</x-customers.layout>
