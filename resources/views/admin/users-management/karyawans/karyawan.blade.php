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
                            <input type="text" data-kt-karyawan-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Karyawan" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-karyawan-table-toolbar="base">
                            <!--begin::Export-->
                            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                            <i class="ki-duotone ki-exit-up fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>Export</button>
                            <!--end::Export-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_tambah_karyawan">
                                <i class="ki-solid ki-abstract-10 fs-5"></i>
                                Add karyawan
                            </button>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-karyawan-table-toolbar="selected">
                            <div class="fw-bold me-5">
                            <span class="me-2" data-kt-karyawan-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger" data-kt-karyawan-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table id="kt_customers_table" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_customers_table .form-check-input"
                                                value="1" />
                                        </div>
                                    </th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th>Tgl Lahir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Modals-->

            <!--end::Modals-->

            <div class="modal fade" id="kt_modal_tambah_karyawan" data-bs-focus="false" tabindex="-1">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-xl p-1">
                    <!--begin::Modal content-->
                    <div class="modal-content modal-rounded">
                        <!--begin::Modal header-->
                        <div class="modal-header py-7 d-flex justify-content-between">
                            <!--begin::Modal title-->
                            <h2>Tambah Karyawan Baru</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-kt-modal-action-type="close">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--begin::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y m-5">
                            <!--begin::Stepper-->
                            <div class="stepper stepper-links d-flex flex-column gap-5" id="kt_modal_tambah_karyawan_stepper">
                                <!--begin::Nav-->
                                <div class="stepper-nav justify-content-center py-2">
                                    <!--begin::Step 1-->
                                    <div class="stepper-item current" data-kt-stepper-element="nav">
                                        <h3 class="stepper-title">Data Pribadi</h3>
                                    </div>
                                    <!--end::Step 1-->
                                    <!--begin::Step 2-->
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <h3 class="stepper-title">Data Akun</h3>
                                    </div>
                                    <!--end::Step 2-->
                                    <!--begin::Step 3-->
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <h3 class="stepper-title">Selesai</h3>
                                    </div>
                                    <!--end::Step 3-->
                                </div>
                                <!--end::Nav-->
                                <!--begin::Form-->
                                <form class="mx-auto w-100 mw-600px pt-15 pb-10" novalidate="novalidate" id="kt_modal_tambah_karyawan_form"
                                    data-kt-redirect="{{ route('karyawan.list') }}">
                                    <!--begin::Step 1-->
                                    <div class="current" data-kt-stepper-element="content">
                                        <!--begin::Wrapper-->
                                        <div class="w-100">
                                            <!--begin::Heading-->
                                            <div class="pb-10 pb-lg-15">
                                                <!--begin::Title-->
                                                <h2 class="fw-bold d-flex align-items-center text-gray-900">Masukkan Data Pribadi Karyawan</h2>
                                                <!--end::Title-->
                                                <!--begin::Notice-->
                                                <div class="text-muted fw-semibold fs-6">Lengkapi formulir di bawah ini dengan informasi pribadi karyawan.</div>
                                                <!--end::Notice-->
                                            </div>
                                            <!--end::Heading-->
                                            
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                    <span class="required">Nama Lengkap</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-lg form-control-solid" name="nama" placeholder="Masukkan nama lengkap" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="required fw-semibold fs-6 mb-5">Jenis Kelamin</label>
                                                <!--end::Label-->
                                                <!--begin::Row-->
                                                <div class="row row-cols-1 row-cols-md-2 g-5">
                                                    <!--begin::Col-->
                                                    <div class="col">
                                                        <!--begin::Option-->
                                                        <input type="radio" class="btn-check" name="jkel" value="pria" id="kt_radio_jkel_laki" checked="checked" />
                                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center h-100" for="kt_radio_jkel_laki">
                                                            <i class="ki-duotone ki-profile-circle fs-3hx text-primary">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                            <span class="d-block fw-semibold text-start">
                                                                <span class="text-gray-900 fw-bold d-block fs-3">Laki-laki</span>
                                                            </span>
                                                        </label>
                                                        <!--end::Option-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col">
                                                        <!--begin::Option-->
                                                        <input type="radio" class="btn-check" name="jkel" value="wanita" id="kt_radio_jkel_perempuan" />
                                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center h-100" for="kt_radio_jkel_perempuan">
                                                            <i class="ki-duotone ki-profile-circle fs-3hx text-primary">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                            <span class="d-block fw-semibold text-start">
                                                                <span class="text-gray-900 fw-bold d-block fs-3">Perempuan</span>
                                                            </span>
                                                        </label>
                                                        <!--end::Option-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                    <span class="required">No. Telepon</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-lg form-control-solid" name="no_telp" placeholder="Masukkan nomor telepon" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                    <span class="required">Alamat</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea class="form-control form-control-lg form-control-solid" name="alamat" placeholder="Masukkan alamat lengkap" rows="3"></textarea>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                            <!--begin::Input group-->
                                            <div class="row mb-10">
                                                <div class="col-md-6 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label mb-3">
                                                        <span class="required">Tempat Lahir</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-lg form-control-solid" name="tempat_lahir" placeholder="Masukkan tempat lahir" value="" />
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label mb-3">
                                                        <span class="required">Tanggal Lahir</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="date" class="form-control form-control-solid" id="kt_datepicker_1" name="tgl_lahir" placeholder="Pilih tanggal lahir" value="" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Step 1-->
                                    
                                    <!--begin::Step 2-->
                                    <div data-kt-stepper-element="content">
                                        <!--begin::Wrapper-->
                                        <div class="w-100">
                                            <!--begin::Heading-->
                                            <div class="pb-10 pb-lg-12">
                                                <!--begin::Title-->
                                                <h2 class="fw-bold text-gray-900">Buat Akun Karyawan</h2>
                                                <!--end::Title-->
                                                <!--begin::Description-->
                                                <div class="text-muted fw-semibold fs-6">Masukkan informasi akun untuk karyawan ini.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Heading-->
                                            
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                    <span class="required">Username</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-lg form-control-solid" name="username" placeholder="Masukkan username" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                    <span class="required">Email</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="email" class="form-control form-control-lg form-control-solid" name="email" placeholder="Masukkan email" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                    <span class="required">Password</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="password" class="form-control form-control-lg form-control-solid" name="password" placeholder="Masukkan password" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label mb-3">
                                                    <span class="required">Konfirmasi Password</span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation" placeholder="Konfirmasi password" value="" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Step 2-->
                                    
                                    <!--begin::Step 3-->
                                    <div data-kt-stepper-element="content">
                                        <!--begin::Wrapper-->
                                        <div class="w-100">
                                            <!--begin::Heading-->
                                            <div class="pb-12 text-center">
                                                <!--begin::Title-->
                                                <h1 class="fw-bold text-gray-900">Data Karyawan Tersimpan!</h1>
                                                <!--end::Title-->
                                                <!--begin::Description-->
                                                <div class="fw-semibold text-muted fs-4">Data karyawan telah berhasil disimpan ke dalam sistem.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Actions-->
                                            <div class="d-flex flex-center pb-20">
                                                <button id="kt_modal_tambah_karyawan_create_new" type="button" class="btn btn-lg btn-light me-3" data-kt-element="complete-start">Tambah Karyawan Baru</button>
                                                <a href="" class="btn btn-lg btn-primary" data-bs-toggle="tooltip" title="Coming Soon">Lihat Data Karyawan</a>
                                            </div>
                                            <!--end::Actions-->
                                            <!--begin::Illustration-->
                                            <div class="text-center px-4">
                                                <img src="assets/media/illustrations/sketchy-1/9.png" alt="" class="mww-100 mh-350px" />
                                            </div>
                                            <!--end::Illustration-->
                                        </div>
                                    </div>
                                    <!--end::Step 3-->
                                    
                                    <!--begin::Actions-->
                                    <div class="d-flex flex-stack pt-10">
                                        <!--begin::Wrapper-->
                                        <div class="me-2">
                                            <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                            <i class="ki-duotone ki-arrow-left fs-3 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Kembali</button>
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Wrapper-->
                                        <div>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
                                                <span class="indicator-label">Simpan 
                                                <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i></span>
                                                <span class="indicator-progress">Mohon tunggu... 
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Lanjutkan 
                                            <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i></button>
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Stepper-->
                        </div>
                        <!--begin::Modal body-->
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        {{-- ecommerce !!! --}}
        <script src="{{ asset('assets/js/custom/apps/ecommerce/customers/listing/listing-karyawan.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/ecommerce/customers/listing/add-karyawan.js') }}"></script>
        <script>
            $("#kt_datepicker_1").flatpickr();
        </script>
    @endpush
</x-admin.layout>
