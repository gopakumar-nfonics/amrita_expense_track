@extends('layouts.admin')

<style>
.bottom {
        display: flex;
        justify-content: space-between; /* Distribute space between elements */
        align-items: center; /* Align elements vertically in the center */
    }
	
</style>
<style>
        .nav-scroll {
            overflow-x: auto;
            white-space: nowrap;
        }
        .nav-item {
            display: inline-block !important;
            vertical-align: top;
        }
    </style>
@section('content')
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">


								<div class="row g-5 g-xl-8 mt-1">
										<!--begin::Col-->
										<div class="col-xl-4">
											<!--begin::Mixed Widget 1-->
											<div class="card card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body p-0">
													<!--begin::Header-->
													<div class="px-9 pt-7 card-rounded h-275px w-100 bg-blue">
														<!--begin::Heading-->
														<div class="d-flex flex-stack">
															<h3 class="m-0 text-white fw-bold fs-3">Budget Summary</h3>
															
														</div>
														<!--end::Heading-->
														<!--begin::Balance-->
														<div class="d-flex text-center flex-column text-white pt-8">
															<span class="fw-semibold fs-7">Budget Allocated</span>
															<span class="fw-bold fs-2x pt-1">&#x20b9;6,37,562.00</span>
														</div>
														<!--end::Balance-->
													</div>
													<!--end::Header-->
													<!--begin::Items-->
													<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 pb-5 position-relative z-index-1" style="margin-top: -100px">
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-plane"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Travel</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																	<span class="badge badge-light-success fs-base">
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																	<i class="fa-solid fa-arrow-up light-green fs-8 me-1 "></i>
																	</span>
																	<!--end::Svg Icon-->32.6%</span>
																</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;2,54,000</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-paperclip"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Office Supplies</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																	<span class="badge badge-light-success fs-base">
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																	<i class="fa-solid fa-arrow-up light-green fs-8 me-1 "></i>
																	</span>
																	<!--end::Svg Icon-->23.5%</span>
																</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;2,13,400</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-computer"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Technology</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																	<span class="badge badge-light-success fs-base">
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																	<i class="fa-solid fa-arrow-up light-green fs-8 me-1 "></i>
																	</span>
																	<!--end::Svg Icon-->16.4%</span>
																</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;1,63,800</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-bullhorn"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Marketing</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																	<span class="badge badge-light-success fs-base">
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																	<i class="fa-solid fa-arrow-up light-green fs-8 me-1 "></i>
																	</span>
																	<!--end::Svg Icon-->13.5%</span>
																</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;1,43,400</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Items-->
												</div>
												<!--end::Body-->
											</div>
											<!--end::Mixed Widget 1-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-xl-4">
											<!--begin::Mixed Widget 1-->
											<div class="card card-xl-stretch mb-xl-8">
												<!--begin::Body-->
												<div class="card-body p-0">
													<!--begin::Header-->
													<div class="px-9 pt-7 card-rounded h-275px w-100 bg-danger">
														<!--begin::Heading-->
														<div class="d-flex flex-stack">
															<h3 class="m-0 text-white fw-bold fs-3">Expense Summary</h3>
															
														</div>
														<!--end::Heading-->
														<!--begin::Balance-->
														<div class="d-flex text-center flex-column text-white pt-8">
															<span class="fw-semibold fs-7">Amount Spent</span>
															<span class="fw-bold fs-2x pt-1">&#x20b9;4,24,473.00</span>
														</div>
														<!--end::Balance-->
													</div>
													<!--end::Header-->
													<!--begin::Items-->
													<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 pb-5 position-relative z-index-1" style="margin-top: -100px">
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-plane"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Travel</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																		<div class="d-flex flex-column w-100 me-2">
																			<span class="text-muted me-2 fs-8 fw-bold">80%</span>
																			
																			<div class="progress h-4px w-150px p-0 m-0">
																			
																				<div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;2,14,000</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-paperclip"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Office Supplies</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																		<div class="d-flex flex-column w-100 me-2">
																			<span class="text-muted me-2 fs-8 fw-bold">70%</span>
																			
																			<div class="progress h-4px w-150px p-0 m-0">
																			
																				<div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;1,98,540</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-computer"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Technology</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																		<div class="d-flex flex-column w-100 me-2">
																			<span class="text-muted me-2 fs-8 fw-bold">50%</span>
																			
																			<div class="progress h-4px w-150px p-0 m-0">
																			
																				<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;81,900</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																	<i class="fa-solid fa-bullhorn"></i>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Marketing</a>
																	<div class="text-gray-400 fw-semibold fs-7">
																		<div class="d-flex flex-column w-100 me-2">
																			<span class="text-muted me-2 fs-8 fw-bold">44%</span>
																			
																			<div class="progress h-4px w-150px p-0 m-0">
																			
																				<div class="progress-bar bg-blue" role="progressbar" style="width: 44%" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;57,360</div>
																	
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
													</div>
													<!--end::Items-->
													
												</div>
												<!--end::Body-->
											</div>
											<!--end::Mixed Widget 1-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-xl-4">
											<!--begin::Mixed Widget 1-->
											<div class="card card-xl-stretch mb-5 mb-xl-8">
												<!--begin::Body-->
												<div class="card-body p-0">
													<!--begin::Header-->
													<div class="px-9 pt-7 card-rounded h-275px w-100 bg-success">
														<!--begin::Heading-->
														<div class="d-flex flex-stack">
															<h3 class="m-0 text-white fw-bold fs-3">Balance Summary</h3>
															
														</div>
														<!--end::Heading-->
														<!--begin::Balance-->
														<div class="d-flex text-center flex-column text-white pt-8">
															<span class="fw-semibold fs-7">You Balance</span>
															<span class="fw-bold fs-2x pt-1">&#x20b9;2,13,087.00</span>
														</div>
														<!--end::Balance-->
													</div>
													<!--end::Header-->
													<!--begin::Items-->
													<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -100px">
													<div class="card-body d-flex flex-column  py-0">
													<div class="flex-grow-1">
														<div class="mixed-widget-4-chart" data-kt-chart-color="success" style="height: 200px; min-height: 178.7px;">
															<!-- <div id="apexchartsjqk2il5bi" class="apexcharts-canvas apexchartsjqk2il5bi apexcharts-theme-light" style="width: 344px; height: 178.7px;">
																<div class="apexcharts-legend"></div>
															</div> -->
														</div>
														<div>
														<p class="text-center fs-6 pb-0 mb-0">
														<span class="badge badge-light-danger fs-8">Note :</span>&nbsp; 74% of the budget has been strategically allocated.</p>
														
														</div>
													</div>
													
												</div>
													</div>
													<!--end::Items-->
												</div>
												<!--end::Body-->
											</div>
											<!--end::Mixed Widget 1-->
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->
									<!--begin::Row-->
									<div class="row g-5 g-xl-10 mb-0 px-5 ">


									<div class="card mb-5">
										<!--begin::Header-->
										<div class="card-header border-0 pt-10">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold fs-3 mb-1">Vendor Statistics</span>
												<span class="text-muted mt-1 fw-semibold fs-7">Over 100 Vendors</span>
											</h3>
											<!--begin::Card toolbar-->
											<div class="card-toolbar flex-row-fluid justify-content-end gap-5">

											<div class="text-end">
															<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Duration
															<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
															<span class="svg-icon svg-icon-5 m-0">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
																</svg>
															</span>
															<!--end::Svg Icon--></a>
															<!--begin::Menu-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" style="">
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="../../demo1/dist/apps/user-management/users/view.html" class="menu-link px-3">Last 7 Days</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Last 30 Days</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">This Month</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Last Month</a>
																</div>
																<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Current Financial Year</a>
																</div>
																<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Last Financial Year</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu-->
														</div>
											
											</div>
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body py-3">
											<!--begin::Table container-->
											<div class="table-responsive">
												<!--begin::Table-->
												<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
													<!--begin::Table head-->
													<thead>
													<tr class="fw-bold text-muted">
													
															<th class="min-w-200px">Vendor</th>
															<th class="min-w-150px">Company</th>
															<th class="min-w-150px">Remittance</th>
															<th class="min-w-150px">Percentage</th>
														</tr>
													</thead>
													<!--end::Table head-->
													<!--begin::Table body-->
													<tbody>
														<tr>
														
															<td>
																<div class="d-flex align-items-center">
																	<div class="symbol symbol-45px me-5">
																		<span class="symbol-label bg-blue text-white"> AS</span>
																
																	</div>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="{{ route('vendor.show',1) }}" class="text-dark fw-bold text-hover-primary fs-6">Ana Simmons</a>
																		<span class="text-muted fw-semibold text-muted d-block fs-7">info@simmons.com</span>
																	</div>
																</div>
															</td>
															<td>
																<a href="#" class="text-dark fw-bold text-hover-primary d-block fs-6">Intertico Solutions</a>
																<span class="text-muted fw-semibold text-muted d-block fs-7">+91-898-589-0432</span>
															</td>
															<td>
															₹7,562.00
															</td>
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold">50%</span>
																	</div>
																	<div class="progress h-6px w-100">
																		<div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															
														</tr>
														<tr>
														
															<td>
																<div class="d-flex align-items-center">
																	<div class="symbol symbol-45px me-5">
																	<span class="symbol-label bg-primary text-white">JC</span>
																	</div>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-6">Jessie Clarcson</a>
																		<span class="text-muted fw-semibold text-muted d-block fs-7">clarcson@agoda.com</span>
																	</div>
																</div>
															</td>
															<td>
																<a href="#" class="text-dark fw-bold text-hover-primary d-block fs-6">Agoda Innovations</a>
																<span class="text-muted fw-semibold text-muted d-block fs-7">+91-998-589-0432</span>
															</td>
															<td>
															₹4,562.00
															</td>
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold">70%</span>
																	</div>
																	<div class="progress h-6px w-100">
																		<div class="progress-bar bg-danger" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															
														</tr>
														<tr>
														
															<td>
																<div class="d-flex align-items-center">
																	<div class="symbol symbol-45px me-5">
																	<span class="symbol-label bg-success text-white">LW</span>
																	</div>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-6">Lebron Wayde</a>
																		<span class="text-muted fw-semibold text-muted d-block fs-7">wayde@roadgee.com</span>
																	</div>
																</div>
															</td>
															<td>
																<a href="#" class="text-dark fw-bold text-hover-primary d-block fs-6">RoadGee Travels</a>
																<span class="text-muted fw-semibold text-muted d-block fs-7">+91-798-789-0432</span>
															</td>
															<td>
															₹1,562.00
															</td>
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold">60%</span>
																	</div>
																	<div class="progress h-6px w-100">
																		<div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															
														</tr>
														<tr>
														
															<td>
																<div class="d-flex align-items-center">
																	<div class="symbol symbol-45px me-5">
																	<span class="symbol-label bg-info text-white">NG</span>
																	</div>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-6">Natali Goodwin</a>
																		<span class="text-muted fw-semibold text-muted d-block fs-7">goodwin@thehill.com</span>
																	</div>
																</div>
															</td>
															<td>
																<a href="#" class="text-dark fw-bold text-hover-primary d-block fs-6">The Hill Resorts</a>
																<span class="text-muted fw-semibold text-muted d-block fs-7">+91-698-589-0432</span>
															</td>
															<td>
															₹8,562.00
															</td>
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold">50%</span>
																	</div>
																	<div class="progress h-6px w-100">
																		<div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															
														</tr>
														<tr>
														
															<td>
																<div class="d-flex align-items-center">
																	<div class="symbol symbol-45px me-5">
																	<span class="symbol-label bg-danger text-white">KL</span>
																	</div>
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-6">Kevin Leonard</a>
																		<span class="text-muted fw-semibold text-muted d-block fs-7">leonard@thehill.com</span>
																	</div>
																</div>
															</td>
															<td>
																<a href="#" class="text-dark fw-bold text-hover-primary d-block fs-6">RoadGee Travels</a>
																<span class="text-muted fw-semibold text-muted d-block fs-7">+91-798-789-0432</span>
															</td>
															<td>
															₹17,562.00
															</td>
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold">90%</span>
																	</div>
																	<div class="progress h-6px w-100">
																		<div class="progress-bar bg-info" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															
														</tr>
													</tbody>
													<!--end::Table body-->
												</table>
												<!--end::Table-->
											</div>
											<!--end::Table container-->
										</div>
										<!--begin::Body-->
									</div>

									
									
									
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer">
							<!--begin::Footer container-->
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<!--begin::Copyright-->
								
								<!--end::Copyright-->
								<!--begin::Menu-->
								
								<!--end::Menu-->
							</div>
							<!--end::Footer container-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
			<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen">
				<div class="modal-content">
					<div class="modal-header p-0">
						<!-- <h5 class="modal-title" id="exampleModalLabel">View Allocation</h5> -->
						<div class="card w-100">
								<div class="card-header border-0 pt-5">
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label fw-bold fs-3" id="exam-name"></span>
									</h3>
								</div>
							<div class="card-header min-h-10px border-0 mb-0 pb-0">
								<h3 class="card-title align-items-start flex-column" > 
									<span class="card-label fs-5 mb-1 text-gray-700" id="room-name"></span>
								</h3>
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fs-5 mb-1 text-gray-700" id="exam-date"></span>
								</h3>
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fs-5 mb-1 text-gray-700" id="exam-time"></span>
								</h3>
							</div>
						</div>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
					</div>
					<div class="modal-body p-0">
						<!-- Content will be loaded here -->
					</div>
				</div>
			</div>
			</div>
		</div>
		<!--end::App-->
		
		<script src="assets/js/custom/apps/ecommerce/reports/returns/returns.js"></script>
@endsection	