<x-admin.layout>
	<x-slot:title>{{ $title }}</x-slot:title>
	<x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::Form-->
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row"
                    data-kt-redirect="{{ route('produk.add-data') }}" enctype="multipart/form-data"
                    data-store-produk-url="{{ route('produk.store') }}">
                    <!--begin::Aside column-->
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Thumbnail</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <!--begin::Image input placeholder-->
                                <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                <!--end::Image input placeholder-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px bgi-position-center bgi-size-cover"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="gambar" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="gambar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Atur gambar mini produk. Hanya file gambar *.png, *.jpg, dan *.jpeg yang diterima</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                        <!--begin::Status-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Status</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                                </div>
                                <!--begin::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Select2-->
                                <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
                                    <option></option>
                                    <option value="published">Published</option>
                                    <option value="unpublished">Unpublished</option>
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Tambahkan status produk.</div>
                                <div class="d-none mt-10">
                                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="Pick date & time" />
                                </div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Status-->
                        <!--begin::Category & tags-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Produk Detail</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <!--begin::Label-->
                                <label class="form-label">Kategori</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select class="form-select mb-2" name="kategori_id" data-control="select2" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($kategori as $ktg) 
                                        <option value="{{ $ktg->id_ktg_produk }}">{{ $ktg->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7 mb-7">Tambahkan produk ke sebuah kategori.</div>
                                <!--end::Description-->
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Category & tags-->
                    </div>
                    <!--end::Aside column-->
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">General</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">Advanced</a>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <!--begin::General options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>General</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Nama Produk</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="nama_produk" class="form-control mb-2" placeholder="Nama Produk" value="" />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Nama produk diperlukan dan disarankan untuk unik.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div>
                                                <!--begin::Label-->
                                                <label class="form-label">Deskripsi</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <div id="kt_ecommerce_add_product_description" name="deskripsi" class="min-h-200px mb-2"></div>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Atur deskripsi pada produk agar visibilitas lebih baik.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::General options-->
                                    <!--begin::Media-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Media</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-2">
                                                <!--begin::Dropzone-->
                                                <div class="dropzone" id="kt_ecommerce_add_product_media">
                                                    <!--begin::Message-->
                                                    <div class="dz-message needsclick">
                                                        <!--begin::Icon-->
                                                        <i class="ki-duotone ki-file-up text-primary fs-3x">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <!--end::Icon-->
                                                        <!--begin::Info-->
                                                        <div class="ms-4">
                                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Letakkkan gambar di sini atau klik untuk unggah.</h3>
                                                            <span class="fs-7 fw-semibold text-gray-500">Dapat unggah hingga 10 gambar</span>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                </div>
                                                <!--end::Dropzone-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Description-->
                                            <div class="text-muted fs-7">Tambahkan media galeri produk.</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Media-->

                                    <!--begin::Variations-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Variasi</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <div class="fv-row">
                                                <!--begin::Input-->
                                                <div class="form-check form-check-custom form-check-solid mb-2">
                                                    <input class="form-check-input" name="use_variant" type="checkbox" id="kt_ecommerce_add_product_variant_checkbox" value="yes" />
                                                    <label class="form-check-label">Klik untuk menampilkan form variant</label>
                                                </div>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Klik jika product memiliki variant. Kemudian akan menampilkan form input menambahkan variant</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--begin::Repeater-->
                                            <div id="kt_ecommerce_add_product_variant" class="d-none mt-10">
                                                <div class="" data-kt-ecommerce-catalog-add-product="auto-options">
                                                    <div id="kt_docs_repeater_nested">
                                                        <!--begin::Form group-->
                                                        <div class="form-group">
                                                            <div data-repeater-list="kt_docs_repeater_nested_outer">
                                                                <div data-repeater-item>
                                                                    <div class="form-group row mb-5">
                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Variant:</label>
                                                                            <select class="form-select" name="product_option" data-kt-repeater="select2" data-placeholder="Select a variation" data-kt-ecommerce-catalog-add-product="product_option">
                                                                                <option></option>
                                                                                @foreach ($variant as $item)
                                                                                    <option value="{{ $item->id_variant_attributes }}">{{ $item->nama_variant }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12 col-md-4 d-flex">
                                                                            <div class="inner-repeater">
                                                                                <div data-repeater-list="kt_docs_repeater_nested_inner" class="mb-5">
                                                                                    <label class="form-label">Nilai:</label>
                                                                                    <div data-repeater-item class="d-flex gap-3">
                                                                                        <div class="pb-3 d-flex gap-3">
                                                                                            <input type="text" class="form-control" name="nilai_variant" placeholder="Nilai variant" />
                                                                                        </div>
                                                                                        <button class="border border-secondary btn btn-icon btn-flex btn-light-danger w-25" data-repeater-delete type="button">
                                                                                            <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                                <button class="btn btn-sm btn-flex btn-light-primary" data-repeater-create type="button">
                                                                                    <i class="ki-duotone ki-plus fs-5"></i>
                                                                                    Tambah Nilai
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-flex btn-light-danger mt-3 mt-md-9">
                                                                                <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                                Delete Row
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Form group-->
                                                        <!--begin::Form group-->
                                                        <div class="form-group">
                                                            <button type="button" data-repeater-create class="btn btn-flex btn-light-primary">
                                                                <i class="ki-duotone ki-plus fs-3"></i>
                                                                Tambah Variasi
                                                            </button>
                                                        </div>
                                                        <!--end::Form group-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Repeater-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Variations-->

                                    <!--begin::Pricing-->
                                    <div id="kt_ecommerce_add_product_pricing" class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Harga</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Harga Dasar</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" onwheel="this.blur()" name="harga" class="form-control mb-2" min="0" onkeydown="return isNumberKey(event)" placeholder="Harga Produk" value="" />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Tambahkan harga produk.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Pricing-->
                                </div>
                            </div>
                            <!--end::Tab pane-->
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <div id="kt_ecommerce_add_product_inventory" class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Inventaris</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">SKU</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="sku" class="form-control mb-2" placeholder="SKU Number" />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Masukkan SKU Produk.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Stok</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="d-flex gap-3">
                                                    <input type="number" onwheel="this.blur()" name="stok" min="0" onkeydown="return isNumberKey(event)" class="form-control mb-2" placeholder="On shelf" />
                                                </div>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Masukkan stok produk.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--begin::Meta options-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Meta Options</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label">Meta Tag Deskripsi</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <div id="kt_ecommerce_add_product_meta_description" name="meta_desc" class="min-h-100px mb-2"></div>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Tetapkan deskripsi meta tag pada produk untuk meningkatkan peringkat SEO..</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div>
                                                <!--begin::Label-->
                                                <label class="form-label">Meta Tag Keywords</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <input id="kt_ecommerce_add_product_meta_keywords" name="meta_keywords" class="form-control mb-2" />
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Atur daftar kata kunci yang terkait dengan produk. Pisahkan kata kunci dengan menambahkan koma
                                                <code>,</code>diantara kata kunci.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Meta options-->
                                </div>
                            </div>
                            <!--end::Tab pane-->
                        </div>
                        <!--end::Tab content-->
                        <div class="d-flex justify-content-end">
                            <!--begin::Button-->
                            <a href="/list-produk" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                                <span class="indicator-label">Save Changes</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Main column-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>
        <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
        <script>
            function isNumberKey(evt) {
                const invalidKeys = ["e", "E", "+", "-", ".", ","];
                if (invalidKeys.includes(evt.key)) {
                    evt.preventDefault();
                    return false;
                }
            }
        </script>
    @endpush
</x-admin.layout>