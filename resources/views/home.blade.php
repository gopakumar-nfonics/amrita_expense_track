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
															<span class="fw-bold fs-2x pt-1">&#x20b9;37,562.00</span>
														</div>
														<!--end::Balance-->
													</div>
													<!--end::Header-->
													<!--begin::Items-->
													<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -100px">
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="currentColor" />
																			<path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Sales</a>
																	<div class="text-gray-400 fw-semibold fs-7">100 Regions</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;2,5b</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
																			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
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
																	<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
																			<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
																			<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
																			<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Revenue</a>
																	<div class="text-gray-400 fw-semibold fs-7">Quarter 2/3</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;1,7b</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-danger ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
																			<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
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
																	<!--begin::Svg Icon | path: icons/duotune/electronics/elc005.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path opacity="0.3" d="M15 19H7C5.9 19 5 18.1 5 17V7C5 5.9 5.9 5 7 5H15C16.1 5 17 5.9 17 7V17C17 18.1 16.1 19 15 19Z" fill="currentColor" />
																			<path d="M8.5 2H13.4C14 2 14.5 2.4 14.6 3L14.9 5H6.89999L7.2 3C7.4 2.4 7.9 2 8.5 2ZM7.3 21C7.4 21.6 7.9 22 8.5 22H13.4C14 22 14.5 21.6 14.6 21L14.9 19H6.89999L7.3 21ZM18.3 10.2C18.5 9.39995 18.5 8.49995 18.3 7.69995C18.2 7.29995 17.8 6.90002 17.3 6.90002H17V10.9H17.3C17.8 11 18.2 10.7 18.3 10.2Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Growth</a>
																	<div class="text-gray-400 fw-semibold fs-7">80% Rate</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;8,8m</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
																			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor" />
																			<rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor" />
																			<rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor" />
																			<rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor" />
																			<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Dispute</a>
																	<div class="text-gray-400 fw-semibold fs-7">3090 Refunds</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;270m</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-danger ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
																			<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
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
															<span class="fw-bold fs-2x pt-1">&#x20b9;47,562.00</span>
														</div>
														<!--end::Balance-->
													</div>
													<!--end::Header-->
													<!--begin::Items-->
													<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -100px">
														<!--begin::Item-->
														<div class="d-flex align-items-center mb-6">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/maps/map004.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="currentColor" />
																			<path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Sales</a>
																	<div class="text-gray-400 fw-semibold fs-7">100 Regions</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;2,5b</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
																			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
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
																	<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
																			<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
																			<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
																			<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Revenue</a>
																	<div class="text-gray-400 fw-semibold fs-7">Quarter 2/3</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;1,7b</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-danger ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
																			<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
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
																	<!--begin::Svg Icon | path: icons/duotune/electronics/elc005.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path opacity="0.3" d="M15 19H7C5.9 19 5 18.1 5 17V7C5 5.9 5.9 5 7 5H15C16.1 5 17 5.9 17 7V17C17 18.1 16.1 19 15 19Z" fill="currentColor" />
																			<path d="M8.5 2H13.4C14 2 14.5 2.4 14.6 3L14.9 5H6.89999L7.2 3C7.4 2.4 7.9 2 8.5 2ZM7.3 21C7.4 21.6 7.9 22 8.5 22H13.4C14 22 14.5 21.6 14.6 21L14.9 19H6.89999L7.3 21ZM18.3 10.2C18.5 9.39995 18.5 8.49995 18.3 7.69995C18.2 7.29995 17.8 6.90002 17.3 6.90002H17V10.9H17.3C17.8 11 18.2 10.7 18.3 10.2Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Growth</a>
																	<div class="text-gray-400 fw-semibold fs-7">80% Rate</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;8,8m</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
																			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</div>
																<!--end::Label-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Item-->
														<!--begin::Item-->
														<div class="d-flex align-items-center">
															<!--begin::Symbol-->
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
																	<span class="svg-icon svg-icon-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor" />
																			<rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor" />
																			<rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor" />
																			<rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor" />
																			<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																</span>
															</div>
															<!--end::Symbol-->
															<!--begin::Description-->
															<div class="d-flex align-items-center flex-wrap w-100">
																<!--begin::Title-->
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Dispute</a>
																	<div class="text-gray-400 fw-semibold fs-7">3090 Refunds</div>
																</div>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="d-flex align-items-center">
																	<div class="fw-bold fs-5 text-gray-800 pe-1">&#x20b9;270m</div>
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
																	<span class="svg-icon svg-icon-5 svg-icon-danger ms-1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
																			<path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
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
															<span class="fw-bold fs-2x pt-1">&#x20b9;37,562.00</span>
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
															<th class="min-w-150px">Expense</th>
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
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-6">Ana Simmons</a>
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