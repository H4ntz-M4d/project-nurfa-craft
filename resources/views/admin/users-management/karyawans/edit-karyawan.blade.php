<x-admin.layout>
	<x-slot:title>{{ $title }}</x-slot:title>
	<x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Navbar-->
            <div class="card card-flush mb-9" id="kt_user_profile_panel">
                <!--begin::Hero nav-->
                <div class="card-header rounded-top bgi-size-cover h-200px" style="background-position: 100% 50%; background-image:url({{ asset('assets/media/misc/profile-head-bg.jpg') }})"></div>
                <!--end::Hero nav-->
                <!--begin::Body-->
                <div class="card-body mt-n19">
                    <!--begin::Details-->
                    <div class="m-0">
                        <!--begin: Pic-->
                        <div class="d-flex flex-stack align-items-end pb-4 mt-n19">
                            <div class="symbol symbol-125px symbol-lg-150px symbol-fixed position-relative mt-n3">
                                <img src="{{ asset('assets/media/avatars/300-3.jpg') }}" alt="image" class="border border-white border-4" style="border-radius: 20px" />
                                <div class="position-absolute translate-middle bottom-0 start-100 ms-n1 mb-9 bg-success rounded-circle h-15px w-15px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="d-flex flex-stack flex-wrap align-items-end">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $vk->nama }}</a>
                                    <a href="#" class="" data-bs-toggle="tooltip" data-bs-placement="right" title="Account is verified">
                                        <i class="ki-duotone ki-verify fs-1 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Text-->
                                <span class="fw-bold text-gray-600 fs-6 mb-2 d-block">Design is like a fart. If you have to force it, it’s probably shit.</span>
                                <!--end::Text-->
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap fw-semibold fs-7 pe-2">
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary">UI/UX Design</a>
                                    <span class="bullet bullet-dot h-5px w-5px bg-gray-500 mx-3"></span>
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary">Austin, TX</a>
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
            <div id="kt_user_profile_nav" class="rounded bg-gray-200 d-flex flex-stack flex-wrap mb-9 p-2"
            data-kt-page-scroll-position="400" data-kt-sticky="true" data-kt-sticky-name="sticky-profile-navs"
            data-kt-sticky-offset="{default: false, lg: '500px'}"
            data-kt-sticky-width="{target: '#kt_user_profile_panel'}" data-kt-sticky-left="auto"
            data-kt-sticky-top="70px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                <!--begin::Nav-->
                <ul class="nav flex-wrap border-transparent">
                    <!--begin::Nav item-->
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 "
                            href="/karyawan-view/{{ $vk->slug }}">Overview</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item my-1">
                        <a class="btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active"
                            href="/karyawan-settings/{{ $vk->slug }}">Settings</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--end::Nav-->
            </div>
            <!--end::Nav items-->
            <!--begin::Basic info-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_profile_details" aria-expanded="true"
                    aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_account_profile_details_form" class="form" method="POST" enctype="multipart/form-data" data-slug="{{ $vk->slug }}" >
                        @csrf
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline" data-kt-image-input="true"
                                        style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change avatar">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove avatar">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                    <!--begin::Hint-->
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                    <!--end::Hint-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Lengkap</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="nama"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Isi nama lengkap" value="{{ $vk->nama }}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        placeholder="cont: example@gmail.com" value="{{ $vk->users->email }}" disabled/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Nomor Handphone</span>
                                    <span class="ms-1" data-bs-toggle="tooltip"
                                        title="Phone number must be active">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="number" name="no_telp"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Phone number" value="{{ $vk->no_telp }}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Alamat</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <textarea class="form-control form-control-solid" placeholder="Isi alamat rumah anda di sini" id="floatingTextarea2"
                                    style="height: 100px" name="alamat">{{ $vk->alamat }}</textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tempat Lahir</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="tempat_lahir"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Company name" value="{{ $vk->tempat_lahir }}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tempat Lahir</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input class="form-control form-control-solid" placeholder="Pick a date"
                                            id="kt_datepicker_1" name="tgl_lahir" value="{{ $vk->tgl_lahir }}"/> <!--end::Input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset"
                                class="btn btn-light btn-active-light-primary me-2">Discard</button>
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Basic info-->
            <!--begin::Sign-in Method-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_signin_method">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Sign-in Method</h3>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_signin_method" class="collapse show">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!--begin::Email Address-->
                        <div class="d-flex flex-wrap align-items-center">
                            <!--begin::Label-->
                            <div id="kt_signin_email">
                                <div class="fs-6 fw-bold mb-1">Email Address</div>
                                <div class="fw-semibold text-gray-600">support@keenthemes.com</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Edit-->
                            <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                                <!--begin::Form-->
                                <form id="kt_signin_change_email" class="form" novalidate="novalidate">
                                    <div class="row mb-6">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <div class="fv-row mb-0">
                                                <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter
                                                    New Email Address</label>
                                                <input type="email"
                                                    class="form-control form-control-lg form-control-solid"
                                                    id="emailaddress" placeholder="Email Address"
                                                    name="emailaddress" value="support@keenthemes.com" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-0">
                                                <label for="confirmemailpassword"
                                                    class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="confirmemailpassword" id="confirmemailpassword" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button id="kt_signin_submit" type="button"
                                            class="btn btn-primary me-2 px-6">Update Email</button>
                                        <button id="kt_signin_cancel" type="button"
                                            class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Edit-->
                            <!--begin::Action-->
                            <div id="kt_signin_email_button" class="ms-auto">
                                <button class="btn btn-light btn-active-light-primary">Change Email</button>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--end::Email Address-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-6"></div>
                        <!--end::Separator-->
                        <!--begin::Password-->
                        <div class="d-flex flex-wrap align-items-center mb-10">
                            <!--begin::Label-->
                            <div id="kt_signin_password">
                                <div class="fs-6 fw-bold mb-1">Password</div>
                                <div class="fw-semibold text-gray-600">************</div>
                            </div>
                            <!--end::Label-->
                            <!--begin::Edit-->
                            <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                <!--begin::Form-->
                                <form id="kt_signin_change_password" class="form" novalidate="novalidate">
                                    <div class="row mb-1">
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="currentpassword"
                                                    class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="currentpassword" id="currentpassword" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New
                                                    Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="newpassword" id="newpassword" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fv-row mb-0">
                                                <label for="confirmpassword"
                                                    class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    name="confirmpassword" id="confirmpassword" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-text mb-5">Password must be at least 8 character and contain
                                        symbols</div>
                                    <div class="d-flex">
                                        <button id="kt_password_submit" type="button"
                                            class="btn btn-primary me-2 px-6">Update Password</button>
                                        <button id="kt_password_cancel" type="button"
                                            class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Edit-->
                            <!--begin::Action-->
                            <div id="kt_signin_password_button" class="ms-auto">
                                <button class="btn btn-light btn-active-light-primary">Reset Password</button>
                            </div>
                            <!--end::Action-->
                        </div>
                        <!--end::Password-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Sign-in Method-->
            <!--begin::Deactivate Account-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_deactivate" aria-expanded="true"
                    aria-controls="kt_account_deactivate">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Deactivate Account</h3>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_deactivate" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_account_deactivate_form" class="form">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Notice-->
                            <div
                                class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                                <!--begin::Icon-->
                                <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <!--end::Icon-->
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-grow-1">
                                    <!--begin::Content-->
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">You Are Deactivating Your Account</h4>
                                        <div class="fs-6 text-gray-700">For extra security, this requires you to
                                            confirm your email or phone number when you reset yousignr password.
                                            <br />
                                            <a class="fw-bold" href="#">Learn more</a>
                                        </div>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Notice-->
                            <!--begin::Form input row-->
                            <div class="form-check form-check-solid fv-row">
                                <input name="deactivate" class="form-check-input" type="checkbox" value=""
                                    id="deactivate" />
                                <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">I confirm my
                                    account deactivation</label>
                            </div>
                            <!--end::Form input row-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card footer-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button id="kt_account_deactivate_account_submit" type="submit"
                                class="btn btn-danger fw-semibold">Deactivate Account</button>
                        </div>
                        <!--end::Card footer-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Deactivate Account-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    @push('scripts')
        <script src="{{ asset('assets/js/custom/account/settings/signin-methods.js') }}"></script>
        <script src="{{ asset('assets/js/custom/account/settings/profile-details.js') }}"></script>
        <script src="{{ asset('assets/js/custom/account/settings/deactivate-account.js') }}"></script>
        <script src="{{ asset('assets/js/custom/pages/user-profile/general.js') }}"></script>
    @endpush
</x-admin.layout>
