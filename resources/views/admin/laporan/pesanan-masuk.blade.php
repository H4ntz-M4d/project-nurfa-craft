<x-admin.layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" data-kt-pesanan-table-filter="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search Pesanan" />
                        </div>
                        <!--end::Search-->
                        <!--begin::Export buttons-->
                        <div id="kt_pesanan_report_views_export" class="d-none"></div>
                        <!--end::Export buttons-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Export dropdown-->
                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-exit-up fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>Export Report</button>
                        <!--begin::Menu-->
                        <div id="kt_pesanan_report_views_export_menu"
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-pesanan-export="copy">Copy to
                                    clipboard</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-pesanan-export="excel">Export as
                                    Excel</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-pesanan-export="csv">Export as
                                    CSV</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-pesanan-export="pdf">Export as
                                    PDF</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Export dropdown-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end" data-kt-pesanan-table-toolbar="base"></div>
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-pesanan-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-pesanan-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger"
                                data-kt-pesanan-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table id="kt_pesanan_table" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_pesanan_table .form-check-input"
                                                value="1" />
                                        </div>
                                    </th>
                                    <th>User</th>
                                    <th>Order id</th>
                                    <th>Status</th>
                                    <th>Tanggal dibuat</th>
                                    <th>Tanggal diubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600"></tbody>
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>

    <div class="modal fade" id="kt_modal_status_pesanan" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="kt_modal_status_pesanan_form" action="{{ route('pesanan.update') }}" data-kt-redirect="{{ route('pesanan.index') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="slug" id="slug">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_status_pesanan_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Status Pesanan</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_modal_status_pesanan_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_status_pesanan_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_status_pesanan_header"
                            data-kt-scroll-wrappers="#kt_modal_status_pesanan_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Input group-->
                                <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-5">Status Pengiriman</label>
                                    <!--end::Label-->
                                    <!--begin::Pesanan-->
                                    <!--begin::Input row-->
                                    <div class="d-flex fv-row">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input me-3" name="status" type="radio"
                                                value="proses" id="kt_modal_update_role_option_0"/>
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <label class="form-check-label" for="kt_modal_update_role_option_0">
                                                <div class="fw-bold text-gray-800">Proses</div>
                                                <div class="text-gray-600">
                                                    Produk sedang diproses oleh penjual
                                                </div>
                                            </label>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Input row-->
                                    <div class='separator separator-dashed my-5'></div>
                                    <!--begin::Input row-->
                                    <div class="d-flex fv-row">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input me-3" name="status" type="radio"
                                                value="dikirim" id="kt_modal_update_role_option_1" />
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <label class="form-check-label" for="kt_modal_update_role_option_1">
                                                <div class="fw-bold text-gray-800">Sedang Dikirim</div>
                                                <div class="text-gray-600">
                                                    Produk sedang dalam proses pengiriman
                                                </div>
                                            </label>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Input row-->
                                    <div class='separator separator-dashed my-5'></div>
                                    <!--begin::Input row-->
                                    <div class="d-flex fv-row">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input me-3" name="status" type="radio"
                                                value="selesai" id="kt_modal_update_role_option_2" />
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <label class="form-check-label" for="kt_modal_update_role_option_2">
                                                <div class="fw-bold text-gray-800">Selesai</div>
                                                <div class="text-gray-600">
                                                    Produk telah sampai ke pembeli
                                                </div>
                                            </label>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Input row-->
                                    <div class='separator separator-dashed my-5'></div>
                                    <!--end::Pesanan-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Jasa pengiriman</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi Jasa Pengiriman" name="jasa_pengiriman" id="jasa_pengiriman"
                                    required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">No. Resi</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi No. Resi" name="no_resi" id="no_resi" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Harga Pengiriman</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Harga Pengiriman" name="harga_pengiriman" id="harga_pengiriman"/>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <textarea class="form-control form-control-lg form-control-solid" name="keterangan" placeholder="Masukkan Keterangan"
                                rows="3"></textarea>


                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_status_pesanan_cancel"
                            class="btn btn-light me-3">Discard</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_modal_status_pesanan_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/custom/apps/ecommerce/reports/pesanan-masuk/list-order.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/ecommerce/reports/pesanan-masuk/add-pesanan.js') }}"></script>
    @endpush
</x-admin.layout>
