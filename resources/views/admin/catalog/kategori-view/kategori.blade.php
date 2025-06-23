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
                            <input type="text" data-kt-category-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Kategori" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-category-table-toolbar="base">
                            <!--begin::Add category-->
                            <a type="button" class="btn btn-primary" href="{{ route('kategori.add-data') }}">
                                <i class="ki-solid ki-abstract-10 fs-5"></i>
                                Add category
                            </a>
                            <!--end::Add category-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-category-table-toolbar="selected">
                            <div class="fw-bold me-5">
                            <span class="me-2" data-kt-category-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger" data-kt-category-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table id="kt_category_table" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_category_table .form-check-input"
                                                value="1" />
                                        </div>
                                    </th>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Gambar</th>
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

        </div>
    </div>

    @push('scripts')
        {{-- ecommerce !!! --}}
        <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/custom/apps/ecommerce/customers/listing/add-karyawan.js') }}"></script> --}}
        
    @endpush
</x-admin.layout>
