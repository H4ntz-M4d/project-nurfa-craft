<x-admin.layout>
	<x-slot:title>{{ $title }}</x-slot:title>
	<x-slot:sub_title>{{ $sub_title }}</x-slot:sub_title>
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-fluid">
			<!--begin::Row-->
			<div class="row gx-5 gx-xl-10 mb-xl-10">
				<!--begin::Col-->
				<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-10">
					<!--begin::Card widget 4-->
					<div class="card card-flush h-md-50 mb-5 mb-xl-10">
						<!--begin::Header-->
						<div class="card-header pt-5">
							<!--begin::Title-->
							<div class="card-title d-flex flex-column">
								<!--begin::Info-->
								<div class="d-flex align-items-center">
									<!--begin::Amount-->
									<span id="total-produk" class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">0</span>
									<!--end::Amount-->
								</div>
								<!--end::Info-->
								<!--begin::Subtitle-->
								<span class="text-gray-500 pt-1 fw-semibold fs-6">Total Produk</span>
								<!--end::Subtitle-->
							</div>
							<!--end::Title-->
						</div>
						<!--end::Header-->
						<!--begin::Card body-->
						<div class="card-body pt-2 pb-4 d-flex align-items-center">
							<!--begin::Chart-->
							<div class="d-flex flex-start me-5 pt-2">
								<div id="produk_total_count"></div>
							</div>
							<!--end::Chart-->

						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card widget 4-->
					<!--begin::Card widget 5-->
					<div class="card card-flush h-md-50 mb-xl-10">
						<!--begin::Header-->
						<div class="card-header pt-5">
							<!--begin::Title-->
							<div class="card-title d-flex flex-column">
								<!--begin::Info-->
								<div class="d-flex align-items-center">
									<!--begin::Amount-->
									<span id="order-this-month" class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">0</span>
									<!--end::Amount-->
									<!--begin::Badge-->
									<span id="percentage-order" class="badge badge-light-info fs-base">
									<i class="ki-duotone ki-arrow-up fs-5 text-info ms-n1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>0%</span>
									<!--end::Badge-->
								</div>
								<!--end::Info-->
								<!--begin::Subtitle-->
								<span class="text-gray-500 pt-1 fw-semibold fs-6">Order Bulan Ini</span>
								<!--end::Subtitle-->
							</div>
							<!--end::Title-->
						</div>
						<!--end::Header-->
						<!--begin::Card body-->
						<div class="card-body d-flex align-items-end pt-0">
							<!--begin::Progress-->
							<div class="d-flex align-items-center flex-column mt-3 w-100">
								<div class="d-flex justify-content-between w-100 mt-auto mb-2">
									<span id="goal-text" class="fw-bolder fs-6 text-gray-900">0 to Goal</span>
									<span id="progress-percent" class="fw-bold fs-6 text-gray-500">0%</span>
								</div>
								<div class="h-8px mx-3 w-100 bg-light-success rounded">
									<div id="progress-bar" class="bg-success rounded h-8px" role="progressbar" style="width: 1%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
							<!--end::Progress-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card widget 5-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-10">
					<!--begin::Card widget 6-->
					<div class="card card-flush h-md-50 mb-5 mb-xl-10">
						<!--begin::Header-->
						<div class="card-header pt-5">
							<!--begin::Title-->
							<div class="card-title d-flex flex-column">
								<!--begin::Info-->
								<div class="d-flex align-items-center">
									<!--begin::Currency-->
									<span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">Rp</span>
									<!--end::Currency-->
									<!--begin::Amount-->
									<span id="total-pendapatan-hari-ini" class="fs-2x fw-bold text-gray-900 me-2 lh-1 ls-n2">0</span>
									<!--end::Amount-->
									<!--begin::Badge-->
									<span id="pendapatan-percentage" class="badge badge-light-success fs-base">
									<i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>0%</span>
									<!--end::Badge-->
								</div>
								<!--end::Info-->
								<!--begin::Subtitle-->
								<span class="text-gray-500 pt-1 fw-semibold fs-6">Average Daily Sales</span>
								<!--end::Subtitle-->
							</div>
							<!--end::Title-->
						</div>
						<!--end::Header-->
						<!--begin::Card body-->
						<div class="card-body d-flex align-items-end px-0 pb-0">
							<!--begin::Chart-->
							<div id="daily_sales_chart" class="w-100" style="height: 80px"></div>
							<!--end::Chart-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card widget 6-->
					<!--begin::Card widget 7-->
					<div class="card card-flush h-md-50 mb-xl-10">
						<!--begin::Header-->
						<div class="card-header pt-5">
							<!--begin::Title-->
							<div class="card-title d-flex flex-column">
								<!--begin::Amount-->
								<span id="total-customers" class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">0</span>
								<!--end::Amount-->
								<!--begin::Subtitle-->
								<span class="text-gray-500 pt-1 fw-semibold fs-6">All Customers</span>
								<!--end::Subtitle-->
							</div>
							<!--end::Title-->
						</div>
						<!--end::Header-->
						<!--begin::Card body-->
						<div class="card-body d-flex flex-column justify-content-end pe-0">
							<!--begin::Title-->
							<span class="fs-6 fw-bolder text-gray-800 d-block mb-2">New Customer</span>
							<!--end::Title-->
							<!--begin::Users group-->
							<div id="latest-users-group" class="symbol-group symbol-hover flex-nowrap">
								<a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
									<span class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+42</span>
								</a>
							</div>
							<!--end::Users group-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card widget 7-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
					<!--begin::Chart widget 3-->
					<div class="card card-flush overflow-hidden h-md-100">
						<!--begin::Header-->
						<div class="card-header py-5">
							<!--begin::Title-->
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label fw-bold text-gray-900">Pendapatan bulan ini</span>
								<span class="text-gray-500 mt-1 fw-semibold fs-6">Grafik pendapatan hasik penjualan bulan ini</span>
							</h3>
							<!--end::Title-->
							<!--begin::Toolbar-->
							<div class="card-toolbar">
								<!--begin::Menu-->
								<button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
									<i class="ki-duotone ki-dots-square fs-1">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
									</i>
								</button>
								<!--begin::Menu 2-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator mb-3 opacity-75"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link px-3">New Ticket</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link px-3">New Customer</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
										<!--begin::Menu item-->
										<a href="#" class="menu-link px-3">
											<span class="menu-title">New Group</span>
											<span class="menu-arrow"></span>
										</a>
										<!--end::Menu item-->
										<!--begin::Menu sub-->
										<div class="menu-sub menu-sub-dropdown w-175px py-4">
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="#" class="menu-link px-3">Admin Group</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="#" class="menu-link px-3">Staff Group</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="#" class="menu-link px-3">Member Group</a>
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::Menu sub-->
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link px-3">New Contact</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator mt-3 opacity-75"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content px-3 py-3">
											<a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
										</div>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::Menu 2-->
								<!--end::Menu-->
							</div>
							<!--end::Toolbar-->
						</div>
						<!--end::Header-->
						<!--begin::Card body-->
						<div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
							<!--begin::Statistics-->
							<div class="px-9 mb-5">
								<!--begin::Statistics-->
								<div class="d-flex mb-2">
									<span class="fs-4 fw-semibold text-gray-500 me-1">Rp</span>
									<span id="pendapatan-perbulan" class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">0</span>
								</div>
								<!--end::Statistics-->
								<!--begin::Description-->
								<span class="fs-6 fw-semibold text-gray-500">Total pendapatan bulan ini</span>
								<!--end::Description-->
							</div>
							<!--end::Statistics-->
							<!--begin::Chart-->
							<div id="month-sales-chart" class="min-h-auto ps-4 pe-6" style="height: 300px"></div>
							<!--end::Chart-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Chart widget 3-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
			<!--begin::Row-->
			<div class="row gy-5 g-xl-10">
				<!--begin::Col-->
				<div class="col-xl-12 mb-5 mb-xl-10">
					<!--begin::Table Widget 4-->
					<div class="card card-flush h-xl-100">
						<!--begin::Card header-->
						<div class="card-header pt-7">
							<!--begin::Title-->
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label fw-bold text-gray-800">Product Orders</span>
							</h3>
							<!--end::Title-->
							<!--begin::Actions-->
							<div class="card-toolbar">
								<!--begin::Filters-->
								<div class="d-flex flex-stack flex-wrap gap-4">
									<!--begin::Status-->
									<div class="d-flex align-items-center fw-bold">
										<!--begin::Label-->
										<div class="text-gray-500 fs-7 me-2">Status</div>
										<!--end::Label-->
										<!--begin::Select-->
										<select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="Select an option" data-kt-table-widget-4="filter_status">
											<option></option>
											<option value="Show All" selected="selected">Show All</option>
											<option value="Proses">Proses</option>
											<option value="Dikirim">Dikirim</option>
											<option value="Selesai">Selesai</option>
										</select>
										<!--end::Select-->
									</div>
									<!--end::Status-->
									<!--begin::Search-->
									<div class="position-relative my-1">
										<i class="ki-duotone ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<input type="text" data-kt-table-widget-4="search" class="form-control w-150px fs-7 ps-12" placeholder="Search" />
									</div>
									<!--end::Search-->
								</div>
								<!--begin::Filters-->
							</div>
							<!--end::Actions-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-2">
							<!--begin::Table-->
							<div class="table-responsive">
								<table id="kt_table_orders" class="table align-middle table-row-dashed fs-6 gy-3">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
											<th>Order ID</th>
											<th>Created</th>
											<th>Customer</th>
											<th>Total</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody class="fw-bold text-gray-600"></tbody>
									<!--end::Table body-->
								</table>
							</div>
							<!--end::Table-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Table Widget 4-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
		</div>
		<!--end::Content container-->
	</div>

	@push('scripts')
		<script src="{{ asset('assets/js/custom/dashboard/daily-sales.js') }}"></script>
		<script src="{{ asset('assets/js/custom/dashboard/month-sales.js') }}"></script>
		<script src="{{ asset('assets/js/custom/dashboard/orders-month.js') }}"></script>
		<script src="{{ asset('assets/js/custom/dashboard/chart-produk.js') }}"></script>
		<script src="{{ asset('assets/js/custom/dashboard/total-customers.js') }}"></script>
		<script src="{{ asset('assets/js/custom/dashboard/table-order.js') }}"></script>
	@endpush
</x-admin.layout>
