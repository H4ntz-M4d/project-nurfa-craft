<x-admin.layout>
	<x-slot:title>{{ $title }}</x-slot:title>
	<x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Post card-->
            <form id="kt_ecommerce_blog_post_form" data-kt-redirect="{{ route('blog-post.index') }}" enctype="multipart/form-data"
            data-store-blog-url="{{ route('blog-post.edit', $blog->id_blog) }}">
            <input type="hidden" name="id_blog" value="{{ $blog->id_blog }}">
                <div class="card mb-8">
                    <!--begin::Body-->
                    <div class="card-body p-lg-10 pb-lg-0">
                        <!--begin::Layout-->
                        <div class="d-flex flex-column flex-xl-row">
                            <!--begin::Content-->
                            <div class="flex-lg-row-fluid me-xl-15">
                                <!--begin::Post content-->
                                    <div class="mb-17">
                                        <div class="mb-8">
                                            <!--begin::Container-->
                                            <div class="d-flex justify-content-center image-input image-input-empty image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                <!--begin::Preview existing avatar-->
                                                <div class="overlay mt-0">
                                                    <div class="image-input-wrapper w-250px h-150px w-sm-550px h-sm-350px w-md-650px h-md-350px w-lg-550px h-lg-300px w-xl-750px h-xl-400px w-xxl-900px h-xxl-475px
                                                    bgi-no-repeat bgi-position-center bgi-size-cover" style="background-image: url({{ ('storage/'.$blog->gambar) }})"></div>
                                                    <!--end::Preview existing avatar-->
                                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                        <label class="btn btn-icon btn-circle btn-active-color-primary bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                                            <i class="ki-duotone ki-pencil fs-7">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            <!--begin::Inputs-->
                                                            <input type="file" name="gambar" accept=".png, .jpg, .jpeg" />
                                                            <input type="hidden" name="avatar_remove" />
                                                            <!--end::Inputs-->
                                                        </label>
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
                                                </div>
                                            </div>
                                            <!--end::Container-->
                                        </div>
                                        <!--begin::Body-->
                                        <div class="p-0">
                                            <!--begin::Info-->
                                            <div class="d-flex align-items-center justify-content-between pb-4">
                                                <!--begin::Date-->
                                                <div class="text-gray-500 fs-5">
                                                    <!--begin::Date-->
                                                    <span class="me-2 fw-bold">Posted Jan 30, 2022. by</span>
                                                    <!--end::Date-->
                                                    <!--begin::Author-->
                                                    <span class="fw-semibold">Dianne Russell</span>
                                                    <!--end::Author-->
                                                </div>
                                                <!--end::Date-->
                                                <!--begin::Action-->
                                                <span class="text-gray-500 me-2 fw-bold fs-5">5 mins read</span>
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Input group-->
                                            <div class="mb-8">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold text-gray-700">Tambahkan Judul</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <div id="kt_ecommerce_blog_judul" name="judul" data-content="{{ $blog->judul }}" class="min-h-200px mb-2"></div>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Tambahkan judul blog postingan anda</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--end::Title-->
                                            <!--begin::Text-->
                                            <div class="mb-8">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold text-gray-700">Tambahkan Deskripsi</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <div id="kt_ecommerce_blog_post_description" name="deskripsi" data-content="{{ $blog->deskripsi }}" class="min-h-200px mb-2"></div>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Tuliskan deskripsi dari judul blog anda</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Text-->
                                            <!--end::Body-->
                                            <!--begin::Input group-->
                                            <div class="mb-8">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold text-gray-700">Tag</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <input id="kt_ecommerce_blog_post_tag" name="tag" class="form-control mb-2" value="{{ $blog->tag }}" />
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Masukkan list tag yang sesuai dengan blog. Wajib pisahkan tag dengan menambahkan koma
                                                <code>,</code>di antara setiap tag.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Post content-->
                                        <!--begin::Link-->
                                        <div class="mb-17">
                                            <!--begin::Icons-->
                                            <div class="d-flex flex-center">
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="assets/media/svg/brand-logos/facebook-4.svg" class="h-20px my-2"
                                                        alt="" />
                                                </a>
                                                <!--end::Icon-->
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="assets/media/svg/brand-logos/instagram-2016.svg"
                                                        class="h-20px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="assets/media/svg/brand-logos/github.svg" class="h-20px my-2"
                                                        alt="" />
                                                </a>
                                                <!--end::Icon-->
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="assets/media/svg/brand-logos/behance.svg" class="h-20px my-2"
                                                        alt="" />
                                                </a>
                                                <!--end::Icon-->
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="assets/media/svg/brand-logos/pinterest-p.svg" class="h-20px my-2"
                                                        alt="" />
                                                </a>
                                                <!--end::Icon-->
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="assets/media/svg/brand-logos/twitter.svg" class="h-20px my-2"
                                                        alt="" />
                                                </a>
                                                <!--end::Icon-->
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="assets/media/svg/brand-logos/dribbble-icon-1.svg"
                                                        class="h-20px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->
                                            </div>
                                            <!--end::Icons-->
                                        </div>
                                    </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Layout-->
                        </div>
                    </div>
                    <!--end::Post card-->
                </div>
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <a href="/blog-post" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_blog_post_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </form>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/custom/apps/ecommerce/utilities/blog-post/add-blog.js') }}"></script>
    @endpush
</x-admin.layout>
