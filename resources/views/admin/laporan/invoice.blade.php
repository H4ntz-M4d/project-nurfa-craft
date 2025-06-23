<x-admin.layout>
	<x-slot:title>{{ $title }}</x-slot:title>
	<x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!-- begin::Invoice 3-->
            <div class="card">
                <!-- begin::Body-->
                <div class="card-body py-20">
                    <!-- begin::Wrapper-->
                    <div class="mw-lg-950px mx-auto w-100">
                        <!-- begin::Header-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                            <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">INVOICE</h4>
                            <!--end::Logo-->
                            <div class="text-sm-end">
                                <!--begin::Logo-->
                                <a href="#" class="d-block mw-150px ms-sm-auto">
                                    <img alt="Logo" src="{{ asset('assets/media/logos/icon-logo-nurfa.png') }}"
                                        class="w-100" />
                                </a>
                                <!--end::Logo-->
                                <!--begin::Text-->
                                <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                                    <div>Badan, RT.02, Badan, Panjangrejo, Kec. Pundong, Kabupaten Bantul</div>
                                    <div>Daerah Istimewa Yogyakarta 55771</div>
                                </div>
                                <!--end::Text-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="pb-12">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column gap-7 gap-md-10">
                                <!--begin::Message-->
                                <div class="fw-bold fs-2">{{ $user->customers->nama }}
                                    <span class="fs-6">({{ $user->email }})</span>,
                                    <br />
                                    <span class="text-muted fs-5">Here are your order details. We thank you for your
                                        purchase.</span>
                                </div>
                                <!--begin::Message-->
                                <!--begin::Separator-->
                                <div class="separator"></div>
                                <!--begin::Separator-->
                                <!--begin::Order details-->
                                <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">Order ID</span>
                                        <span class="fs-5">#{{ $transaksi->order_id }}</span>
                                    </div>
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">Date</span>
                                        <span class="fs-5">{{ Carbon\Carbon::parse($transaksi->tanggal)->timezone('Asia/Jakarta')->format('d F Y, H:i T') }}</span>
                                    </div>
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">Billing Address</span>
                                        <span class="fs-6">{{ $transaksi->alamat_pengiriman }},
                                            <br />{{ $transaksi->kota }},
                                            <br />{{ $transaksi->provinsi }}.</span>
                                    </div>
                                </div>
                                <!--end::Order details-->
                                <!--begin:Order summary-->
                                <div class="d-flex justify-content-between flex-column">
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-9">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                            <thead>
                                                <tr class="border-bottom fs-6 fw-bold text-muted">
                                                    <th class="min-w-175px pb-2">Products</th>
                                                    <th class="min-w-80px text-end pb-2">Jumlah</th>
                                                    <th class="min-w-100px text-end pb-2">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @foreach ($transaksi->details as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Thumbnail-->
                                                                <a href="#" class="symbol symbol-50px">
                                                                    <span class="symbol-label" 
                                                                        style="background-image:url('{{ asset('storage/'.$detail->produk->gambar) }}');"></span>
                                                                </a>
                                                                <!--end::Thumbnail-->

                                                                <!--begin::Title-->
                                                                <div class="ms-5">
                                                                    <div class="fw-bold">{{ $detail->nama_produk }}</div>
                                                                    <div class="fs-7 text-muted">
                                                                        @if ($detail->variants->isNotEmpty()) 
                                                                            @foreach ($detail->variants as $variant)
                                                                                {{ $variant->nama_atribut }}: {{ $variant->nilai_variant }}
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                        </td>
                                                        <td class="text-end">{{ $detail->jumlah }}</td>
                                                        <td class="text-end">Rp{{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach

                                                <!-- Ringkasan -->
                                                <tr>
                                                    <td colspan="2" class="text-end">Subtotal</td>
                                                    <td class="text-end">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="fs-3 text-gray-900 fw-bold text-end">Grand Total</td>
                                                    <td class="text-gray-900 fs-3 fw-bolder text-end">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end:Order summary-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->
                        <!-- begin::Footer-->
                        <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                            <!-- begin::Actions-->
                            <div class="my-1 me-5">
                                <!-- begin::Print-->
                                <button type="button" class="btn btn-success my-1 me-12"
                                    onclick="window.print();">Print Invoice</button>
                                <!-- end::Print-->
                            </div>
                            <!-- end::Actions-->
                        </div>
                        <!-- end::Footer-->
                    </div>
                    <!-- end::Wrapper-->
                </div>
                <!-- end::Body-->
            </div>
            <!-- end::Invoice 1-->
        </div>
        <!--end::Content container-->
    </div>

</x-admin.layout>
