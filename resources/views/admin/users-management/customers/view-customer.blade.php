<x-admin.layout>
	<x-slot:title>{{ $title }}</x-slot:title>
	<x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body pt-15">
                            @php
                                $nama = $customer->users->customers->nama ?? $customer->users->username ?? 'U';
                                $inisial = strtoupper(substr($nama, 0, 1));
                                $bgColors = ['bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-dark'];
                                $bgColor = $bgColors[array_rand($bgColors)];
                            @endphp
                            <!--begin::Summary-->
                            <div class="d-flex flex-center flex-column mb-5">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-100px symbol-circle mb-7 bg-info">
                                    <span class="symbol-label {{ $bgColor }} fs-3x text-white fw-bold">{{ $inisial }}</span>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Name-->
                                <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
                                    {{ $customer->name ?? $customer->users->username}}</a>
                                </a>
                                <!--end::Name-->
                                <!--begin::Position-->
                                <div class="fs-5 fw-semibold text-muted mb-6">{{ $customer->users->role }}</div>
                                <!--end::Position-->
                            </div>
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                    href="#kt_customer_view_details" role="button" aria-expanded="false"
                                    aria-controls="kt_customer_view_details">Details
                                    <span class="ms-2 rotate-180">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </span>
                                </div>
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator separator-dashed my-3"></div>
                            <!--begin::Details content-->
                            <div id="kt_customer_view_details" class="collapse show">
                                <div class="py-5 fs-6">
                                    <!--begin::Badge-->
                                    <div class="badge badge-light-info d-inline">Premium user</div>
                                    <!--begin::Badge-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Username</div>
                                    <div class="text-gray-600">
                                        <a href="#"
                                        class="text-gray-600 text-hover-primary">{{ $customer->users->username }}</a>
                                    </div>
                                    <div class="fw-bold mt-5">Email</div>
                                    <div class="text-gray-600">
                                        <a href="#"
                                            class="text-gray-600 text-hover-primary">{{ $customer->users->email }}</a>
                                    </div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">No. Handphone</div>
                                    <div class="text-gray-600">{{ $customer->no_telp ?? 'Nomor handphone belum di isi' }}</div>
                                    <!--begin::Details item-->
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">Jenis Kelamin</div>
                                    <div class="text-gray-600">{{ $customers->jkel ?? 'Tidak diberitahu' }}</div>
                                    <!--begin::Details item-->
                                </div>
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_customer_view_overview_tab">Overview</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                            <!--begin::Earnings-->
                            <div class="card mb-6 mb-xl-9">
                                <!--begin::Header-->
                                <div class="card-header border-0">
                                    <div class="card-title">
                                        <h2>Earnings</h2>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body py-0">
                                    <!--begin::Left Section-->
                                    <div class="d-flex flex-wrap justify-content-between flex-stack mb-5">
                                        <div class="fs-5 fw-semibold text-gray-500 mb-4">
                                            Data total transaksi yang telah dilakukan oleh customer ini.
                                        </div>
                                        <!--begin::Row-->
                                        <div class="d-flex flex-wrap">
                                            <!--begin::Col-->
                                            <div class="d-flex justify-content-between border border-dashed border-gray-300 w-250px rounded my-3 p-4 me-6">
                                                <div>
                                                    <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                        <span data-kt-countup="true" data-kt-countup-value="{{ $totalTransaksi }}"
                                                            data-kt-countup-prefix="Rp">0</span>
                                                    </span>
                                                    <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">
                                                        Total transaksi
                                                    </span>
                                                </div>
                                                <i class="ki-solid ki-credit-cart fs-3x text-info"></i>

                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="d-flex justify-content-between border border-dashed border-gray-300 w-225px rounded my-3 p-4 me-6">
                                                <div>
                                                    <span class="fs-1 fw-bold text-gray-800 lh-1">
                                                        <span data-kt-countup="true"
                                                            data-kt-countup-value="{{ $totalProdukDibeli }}">0</span>
                                                    </span>
                                                    <span class="fs-6 fw-semibold text-muted d-block lh-1 pt-2">Produk dibeli</span>
                                                </div>
                                                <i class="ki-solid ki-purchase fs-3x text-success"></i>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Left Section-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Earnings-->
                            <!--begin::Card-->
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Payment Records</h2>
                                        <!--begin::Export buttons-->
                                        <div id="kt_transaksi_views_export" class="d-none"></div>
                                        <!--end::Export buttons-->
                                    </div>
                                    <!--end::Card title-->
                                    <div class="card-toolbar">
                                        <!--begin::Search-->
                                        <div class="me-3 d-flex align-items-center position-relative my-1">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" data-kt-orderView-table-filter="search" class="form-control form-control-solid w-200px ps-13" placeholder="Search Orders" />
                                        </div>
                                        <!--end::Search-->
                                        <!--begin::Export dropdown-->
                                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                            data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-exit-up fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Export Report</button>
                                        <!--begin::Menu-->
                                        <div id="kt_transaksi_views_export_menu"
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-view-transaksi-export="copy">Copy to
                                                    clipboard</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-view-transaksi-export="excel">Export as
                                                    Excel</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-view-transaksi-export="csv">Export as
                                                    CSV</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-view-transaksi-export="pdf">Export as
                                                    PDF</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                        <!--end::Export dropdown-->
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0 pb-5">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed gy-5"
                                        id="kt_orderView_table" data-id="{{ $customer->users->slug }}">
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th >Invoice No.</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th class="min-w-100px">Date</th>
                                                <th class="text-end min-w-100px pe-4">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-6 fw-semibold text-gray-600"></tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end:::Tab pane-->
                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
            <!--begin::Modals-->
        </div>
        <!--end::Content container-->
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/custom/apps/ecommerce/customers/listing/list-order-view.js') }}"></script>
    @endpush
</x-admin.layout>
