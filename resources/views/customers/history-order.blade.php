<x-customers.layout>

    @push('css')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <style>
        .btn-cream {
            color: #f9f9f9;
            background-color: #e5c497;
            padding: 12px 0px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
        }

        .btn-cream:hover {
            color: #f9f9f9;
            background-color: #e3ccab;
            padding: 12px 0px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
        }
    </style>

    <div class="container py-15">

        @foreach ($transaksi as $trans)
            <div class="card my-10">
                <div class="card-body">
                    @foreach ($trans->details as $details)
                        <div class="d-flex align-items-center justify-content-between py-5">
                            <div class="d-flex align-items-center">
                                <!--begin::Thumbnail-->
                                <a href="#" class="symbol symbol-50px">
                                    <img src="{{ asset('storage/' . $details->produk->gambar) }}"
                                        style="width: 50px; height: 50px; object-fit: cover;" />
                                </a>
                                <!--end::Thumbnail-->
                                <!--begin::Title-->
                                <div class="ms-5">
                                    <div class="fs-4">{{ $details->nama_produk }}</div>
                                    <div class="fs-7 text-muted">
                                        @if ($details->variants->isNotEmpty())
                                            @foreach ($details->variants as $variant)
                                                {{ $variant->nama_atribut }}: {{ $variant->nilai_variant }}
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <!--end::Title-->
                            </div>
                            <div class="col-4">
                                <div class="d-md-flex justify-content-between">
                                    <div class="fs-6 text-end">Jumlah: {{ $details->jumlah }}</div>
                                    <div class="fs-6 text-end">
                                        Rp{{ number_format($details->jumlah * $details->harga, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="text-gray-400">
                    @endforeach
                    <div class="d-flex align-items-end justify-content-end flex-column mt-12">
                        <div class="d-flex">
                            <div colspan="2" class="fs-3 text-gray-900 fw-bold ms-5">Total Pesanan:</div>
                            <div class="text-gray-900 fs-3 fw-bolder ms-5">
                                Rp{{ number_format($trans->total, 0, ',', '.') }}
                            </div>
                        </div>
                        <a href="/invoice-order/{{ Auth::user()->slug }}/{{ $trans->order_id }}"
                            class="btn-cream px-10 py-5 mt-8">
                            Lihat Invoice
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        <!--end::Table-->
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    @endpush

</x-customers.layout>
