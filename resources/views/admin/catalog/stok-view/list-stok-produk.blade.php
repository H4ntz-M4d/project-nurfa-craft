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
                            <input type="text" data-kt-stocks-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Kategori" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center fw-bold">
                            <!--begin::Label-->
                            <div class="text-muted fs-7 me-2">Status</div>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="Select an option" data-kt-table-widget-5="filter_status">
                                <option></option>
                                <option value="Show All" selected="selected">Show All</option>
                                <option value="Stock Ada">Stock Ada</option>
                                <option value="Stok Rendah">Stok Rendah</option>
                                <option value="Stok Habis">Stok Habis</option>
                            </select>
                            <!--end::Select-->
                        </div>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table id="kt_stok_produk_table" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Produk</th>
                                    <th>Gunakan Variant</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
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

    <div class="modal fade" id="kt_modal_add_stocks" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="kt_modal_add_stocks_form" method="POST" action="{{ route('stocks.store') }}" 
                    data-kt-redirect="{{ route('stocks.index') }}">
                    
                    @csrf

                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_add_stocks_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Tambah Stok Produk</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_modal_add_stocks_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_stocks_scroll" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_stocks_header"
                            data-kt-scroll-wrappers="#kt_modal_add_stocks_scroll" data-kt-scroll-offset="300px">

                            <input type="hidden" name="id_master_produk" id="id_master_produk">
                            <input type="hidden" name="id_var_produk" id="id_var_produk">
                            <input type="hidden" name="id_detail_produk" id="id_detail_produk">
                        
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Stok Awal</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="Nama Variant"
                                    name="stok_awal" id="stok_awal" readonly />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Stok Masuk</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="Nama Variant"
                                    name="stok_masuk" id="stok_masuk" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">Total Stok</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="Nama Variant"
                                    name="stok_akhir" id="stok_akhir" readonly />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <textarea class="form-control form-control-lg form-control-solid" name="keterangan" placeholder="Masukkan Keterangan" rows="3"></textarea>


                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_add_stocks_cancel"
                            class="btn btn-light me-3">Discard</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_modal_add_stocks_submit" class="btn btn-primary">
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
        <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/manage-stock.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/add-stocks.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $(document).on('click', '[data-kt-produk-table-filter="add_stock_row"]', function () {
                    const button = $(this);
                    
                    $('#id_master_produk').val(button.data('id-master-produk'));
                    $('#id_var_produk').val(button.data('id-var-produk') || '');
                    $('#id_detail_produk').val(button.data('id-detail-produk') || '');
                    $('#stok_awal').val(button.data('stok') || 0);

                    // Optional: isi label nama, SKU, harga juga
                    $('#nama_produk_label').text(button.data('nama-produk'));
                    $('#sku_label').text(button.data('sku'));
                    $('#harga_label').text(button.data('harga'));
                });


                // Hitung otomatis stok_akhir
                document.querySelector("#stok_masuk").addEventListener("input", function () {
                    let stokAwal = parseInt(document.querySelector("#stok_awal").value) || 0;
                    let stokMasuk = parseInt(this.value) || 0;
                    document.querySelector("#stok_akhir").value = stokAwal + stokMasuk;
                });
            });

        </script>
    @endpush
</x-admin.layout>
