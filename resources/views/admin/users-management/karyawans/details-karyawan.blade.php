<x-layout>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Navbar-->
            <div class="card card-flush mb-9" id="kt_user_profile_panel">
                <!--begin::Hero nav-->
                <div class="card-header rounded-top bgi-size-cover h-200px"
                    style="background-position: 100% 50%; background-image:url({{ asset('assets/media/misc/profile-head-bg.jpg') }})">
                </div>
                <!--end::Hero nav-->
                <!--begin::Body-->
                <div class="card-body mt-n19">
                    <!--begin::Details-->
                    <div class="m-0">
                        <!--begin: Pic-->
                        <div class="d-flex flex-stack align-items-end pb-4 mt-n19">
                            <div class="symbol symbol-125px symbol-lg-150px symbol-fixed position-relative mt-n3">
                                <img src="{{ asset('assets/media/avatars/300-3.jpg') }}" alt="image"
                                    class="border border-white border-4" style="border-radius: 20px" />
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 ms-n1 mb-9 bg-success rounded-circle h-15px w-15px">
                                </div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="d-flex flex-stack flex-wrap align-items-end">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#"
                                        class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $vk->nama }}</a>
                                    <a href="#" class="" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Account is verified">
                                        <i class="ki-duotone ki-verify fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Text-->
                                <span class="fw-bold text-gray-600 fs-6 mb-2 d-block">Design is like a fart. If you have
                                    to force it, it’s probably shit.</span>
                                <!--end::Text-->
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap fw-semibold fs-7 pe-2">
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary">UI/UX
                                        Design</a>
                                    <span class="bullet bullet-dot h-5px w-5px bg-gray-500 mx-3"></span>
                                    <a href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary">Austin,
                                        TX</a>
                                    <span class="bullet bullet-dot h-5px w-5px bg-gray-500 mx-3"></span>
                                    <a href="#" class="text-gray-500 text-hover-primary">3,450 Followers</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Nav items-->
            <div id="kt_user_profile_nav" class="rounded bg-gray-200 d-flex flex-stack flex-wrap mb-9 p-2">
                <!--begin::Nav-->
                <ul class="nav flex-wrap border-transparent">
                    <!--begin::Nav item-->
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active"
                            href="/karyawan-view/{{ $vk->slug }}">Overview</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1"
                            href="/karyawan-settings/{{ $vk->slug }}">Settings</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--end::Nav-->
            </div>
            <!--end::Nav items-->
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Action-->
                    <a href="account/settings.html" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
                    <!--end::Action-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $vk->nama }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">email</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800 fs-6">{{ $vk->users->email }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">No. Handphone
                            <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
                                <i class="ki-duotone ki-information fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span></label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <span class="fw-bold fs-6 text-gray-800 me-2">{{ $vk->no_telp }}</span>
                            <span class="badge badge-success">Verified</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <a href="#"class="fw-semibold fs-6 text-gray-800 text-hover-primary">{{ $vk->alamat }}</a>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">
                            Tempat Lahir
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $vk->tempat_lahir }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Tanggal Lahir</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span
                                class="fw-bold fs-6 text-gray-800">{{ \Carbon\Carbon::parse($vk->tgl_lahir)->format('d-m-Y') }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::details View-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</x-layout>
