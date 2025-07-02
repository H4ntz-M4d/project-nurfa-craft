<x-admin.layout>
	<x-slot:title>{{ $title }}</x-slot:title>
	<x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!-- begin::Invoice 3-->
            <style>
                @media print {
                    body * {
                        visibility: hidden !important;
                    }
                    #print-area, #print-area * {
                        visibility: visible !important;
                    }
                    #print-area {
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                    }
                    .no-print {
                        display: none !important;
                    }
                }
                

            </style>
            <div class="card">
                <!-- begin::Body-->
                <div class="card-body py-20">
                    <!-- begin::Wrapper-->
                    <div class="mw-lg-950px mx-auto w-100" id="print-area">
                        <!-- begin::Header-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                            <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">LAPORAN OMSET TAHUNAN</h4>
                            <!--end::Logo-->
                            <div class="text-sm-end">
                                <!--begin::Logo-->
                                <a href="#" class="d-block mw-150px ms-sm-auto">
                                    <img alt="Logo" src="{{ asset('assets/media/logos/icon-logo-nurfa.png') }}"
                                        class="w-100" />
                                </a>
                                <!--end::Logo-->
                                <!--begin::Text-->
                                <div class="text-sm-end fw-semibold fs-5 text-muted mt-7">
                                    <div>Badan, RT.02, Badan, Panjangrejo, Kec. Pundong, Kabupaten Bantul</div>
                                    <div>Daerah Istimewa Yogyakarta 55771</div>
                                </div>
                                <!--end::Text-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="pb-12">
                            <div class="d-flex justify-content-between flex-column mb-10">
                                <h2>Grafik Keuangan</h2>
                                <div class="col-12" id="kt_apexcharts_5" style="height: 350px;"></div>
                            </div>
                            <div class="d-flex justify-content-between flex-column mb-10">
                                <h2>Grafik Produk Terlaris</h2>
                                <div class="col-12" id="produk-terlaris" style="height: 350px;"></div>
                            </div>
                            <p style="page-break-after: always"></p>
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column gap-7 gap-md-10 mt-20">
                                <div class="d-flex justify-content-between flex-column">
                                    <h2>Data Laporan Keuangan</h2>
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-9">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                            <thead>
                                                <tr class="border-bottom fs-6 fw-bold text-muted">
                                                    <th>Bulan</th>
                                                    <th>Pemasukan</th>
                                                    <th>Ongkir</th>
                                                    <th>Pengeluaran</th>
                                                    <th class="text-end">Omzet</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @foreach ($data as $row)
                                                <tr>
                                                    <td>{{ $row['bulan'] }}</td>
                                                    <td>Rp {{ $row['pemasukan'] }}</td>
                                                    <td>Rp {{ $row['ongkir'] }}</td>
                                                    <td>Rp {{ $row['pengeluaran'] }}</td>
                                                    <td class="text-end"><strong>Rp {{ $row['omzet'] }}</strong></td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="4" class="fs-3 text-gray-900 fw-bold text-end">Total Omzet Tahun 2025:</td>
                                                    <td class="text-gray-900 fs-3 fw-bolder text-end">Rp{{ $totalOmzetTahunIni }}</td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column gap-7 gap-md-10 mt-20">
                                <div class="d-flex justify-content-between flex-column">
                                    <h2>Data Laporan Produk Terlaris</h2>
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-9">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                            <thead>
                                                <tr class="border-bottom fs-6 fw-bold text-muted">
                                                    <th>Nama Produk</th>
                                                    <th>Produk dibeli</th>
                                                    <th>Harga Barang</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @foreach ($produkTerlaris as $produk)
                                                <tr>
                                                    <td>{{ $produk['nama_produk'] }}</td>
                                                    <td>{{ $produk['jum_produk_dibeli'] }}</td>
                                                    <td>Rp{{ $produk['harga_brng'] }}</td>
                                                    <td>Rp{{ $produk['total'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->
                        <!-- begin::Footer-->
                        <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                            <!-- begin::Actions-->
                            <div class="my-1 me-5">
                                <!-- begin::Print-->
                                <button type="button" class="btn btn-success my-1 me-12 no-print"
                                    onclick="window.print();">Print Reports</button>
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

    @push('scripts')
        <script src="{{ asset('assets/js/custom/apps/ecommerce/reports/omset-report/grafik-tahunan.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/ecommerce/reports/omset-report/grafik-produk-terlaris.js') }}"></script>
        <script>
            KTUtil.onDOMContentLoaded(function () {
                KTCardsReport.init({{ $tahun }});
            });
            KTUtil.onDOMContentLoaded(function () {
                KTCardsProdukTerlaris.init({{ $tahun }});
            });
        </script>
    @endpush

</x-admin.layout>
