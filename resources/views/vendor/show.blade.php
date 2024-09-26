@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
		<!--begin::Toolbar container-->
		<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<!--begin::Title-->
				<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Vendor Details</h1>
				<!--end::Title-->
				<!--begin::Breadcrumb-->
				<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
					<!--begin::Item-->
					<!-- <li class="breadcrumb-item text-muted">
												<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
											</li> -->
					<!--end::Item-->
					<!--begin::Item-->
					<!-- <li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li> -->
					<!--end::Item-->
					<!--begin::Item-->
					<!-- <li class="breadcrumb-item text-muted">Customers</li> -->
					<!--end::Item-->
				</ul>
				<!--end::Breadcrumb-->
			</div>
		</div>
		<!--end::Toolbar container-->
	</div>
	<!--end::Toolbar-->
	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-xxl">
			<!--begin::Layout-->
			<div class="d-flex flex-column flex-row">
				<!--begin::Sidebar-->
				<div class="flex-lg-row-auto w-100 mb-0">
					<!--begin::Card-->
					<div class="card mb-5 mb-xl-8">
						<!--begin::Card body-->
						<div class="card-body d-flex flex-center">
							<!--begin::Summary-->
							<div class="d-flex flex-center flex-column me-10 br-right pe-10">
								<!--begin::Avatar-->
								<div class="symbol symbol-100px symbol-circle mb-7">
									<span class="symbol-label bg-blue text-white fs-2tx"> AS</span>
								</div>
								<!--end::Avatar-->
								<!--begin::Name-->
								<a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{$vendor->vendor_name}}</a>
								<!--end::Name-->
								<!--begin::Position-->
								<div class="fs-5 fw-semibold text-muted mb-6">{{$vendor->company->company_name}}</div>
								<!--end::Position-->
								<!--begin::Info-->
								<div class="d-flex flex-row flex-center">
									<!--begin::Stats-->
									@php
									$totalProposalAmount = $vendor->proposals->first()->total_proposal_amount ?? 0;
									$totalPaidAmount = $vendor->invoices->first()->total_paid_amount ?? 0;

									// Calculate the balance amount
									$balanceAmount = $totalProposalAmount - $totalPaidAmount;
									@endphp
									<div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
										<div class="fs-6 fw-bold text-gray-700">
											<span class="w-75px">&#x20b9;{{ number_format($totalProposalAmount, 2) }}</span>
										</div>
										<div class="fw-semibold text-muted text-center color-blue">Total</div>
									</div>
									<!--end::Stats-->
									<!--begin::Stats-->
									<div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
										<div class="fs-6 fw-bold text-gray-700">
											<span class="w-50px">&#x20b9;{{ number_format($totalPaidAmount, 2) }}</span>
										</div>
										<div class="fw-semibold text-muted text-center color-green">Paid</div>
									</div>
									<!--end::Stats-->
									<!--begin::Stats-->
									<div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
										<div class="fs-6 fw-bold text-gray-700">
											<span class="w-50px">&#x20b9;{{ number_format($balanceAmount, 2) }}</span>
										</div>
										<div class="fw-semibold text-muted text-center color-orange">Balance</div>
									</div>
									<!--end::Stats-->
								</div>
								<!--end::Info-->
							</div>
							<!--end::Summary-->

							<div class="separator separator-dashed my-3"></div>
							<!--begin::Details content-->
							<div id="kt_customer_view_details" class="collapse show">
								<div class="pb-5 fs-6">
									<!--begin::Badge-->
									<!-- <div class="badge badge-light-info d-inline">Premium user</div> -->
									<!--begin::Badge-->
									<div class="d-flex justify-content-md-start fs-6 py-3">

										<!--begin::Details item-->
										<!--begin::Details item-->
										<div class="flex-column mb-0 w-300px">
											<div class="fw-bold mt-5">Email</div>
											<div class="text-gray-600">
												<a href="#" class="text-gray-600 text-hover-primary">{{$vendor->email}}</a>
											</div>
										</div>
										<div class="flex-column mb-0">
											<div class="fw-bold mt-5">Phone</div>
											<div class="text-gray-600">
												<a href="#" class="text-gray-600 text-hover-primary">{{$vendor->phone}}</a>
											</div>
										</div>
									</div>
									<div class="d-flex justify-content-md-start fs-6 py-3">
										<!--begin::Details item-->
										<div class="flex-column mb-0  w-300px">
											<div class="fw-bold mt-0">GST #</div>
											<div class="text-gray-600">{{$vendor->gst}}</div>
										</div>
										<!--begin::Details item-->
										<!--begin::Details item-->
										<div class="flex-column mb-0">
											<div class="fw-bold mt-0">PAN #</div>
											<div class="text-gray-600">
												<a href="#" class="text-gray-600 text-hover-primary">{{$vendor->pan}}</a>
											</div>
										</div>

									</div>
									<!--begin::Details item-->
									<!--begin::Details item-->
									<div class="fw-bold mt-5 ">Address</div>
									<div class="text-gray-600">
										{{$vendor->address}}</br>
										@if($vendor->address_2){{$vendor->address_2}}<br>@endif
										{{$vendor->city}},
										{{$vendor->states[0]->name}}.
										{{$vendor->postcode}}
									</div>
									<!--begin::Details item-->
								</div>
							</div>
							<!--end::Details content-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
					<!--begin::Connected Accounts-->

					<!--end::Connected Accounts-->
				</div>
				<!--end::Sidebar-->
				<!--begin::Content-->
				<div class="flex-lg-row-fluid">
					<!--begin:::Tabs-->
					<!--end:::Tabs-->
					<!--begin:::Tab content-->
					<div class="tab-content" id="myTabContent">
						<!--begin:::Tab pane-->
						<div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
							<!--begin::Card-->
							<div class="card pt-4 mb-6 mb-xl-9">
								<!--begin::Card header-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2 class="fs-3">Payment Details</h2>
									</div>
									<!--end::Card title-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body pt-0 pb-5">
									<!--begin::Table-->
									<div id="kt_table_customers_payment_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
										<div class="table-responsive">

											<!--begin::Table-->
											<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="proposal-table">
												<!--begin::Table head-->
												<thead>
													<tr class="fw-bold">
														<th class="min-w-50px">#</th>
														<th class="min-w-100px">ID</th>
														<th class="min-w-100px">Date</th>
														<th class="min-w-100px">Total</th>
														<th class="min-w-100px">Paid</th>
														<th class="min-w-100px">Balance</th>

													</tr>
												</thead>
												<!--end::Table head-->
												<!--begin::Table body-->
												<tbody>
													@forelse($proposalWiseTotals as $key => $proposal)
													@php
													$paidPercentage = $proposal['total_proposal_amount'] > 0 ? ($proposal['total_paid_amount'] / $proposal['total_proposal_amount']) * 100 : 0;

													if (floor($paidPercentage) == $paidPercentage) {
													$paidPercentage = number_format($paidPercentage, 0);
													} else {
													$paidPercentage = number_format($paidPercentage, 2);
													}
													@endphp
													<tr>
														<td class="min-w-50px">{{ $key+1 }}</td>
														<td>
															<div class="d-flex align-items-center">
																<div class="fw-400 d-block fs-6">
																	#{{ $proposal['proposal_id']}}
																	<div class="text-gray-400 fw-semibold fs-9">
																		<span class="badge badge-light-success fs-8">
																			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
																			<span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
																				<i class="fa-solid fa-arrow-up light-green fs-8 me-1 "></i>
																			</span>
																			<!--end::Svg Icon-->{{$paidPercentage}}%</span>
																	</div>
																</div>
															</div>


														<td>
															<div class="d-flex align-items-center">
																<div class="fw-400 d-block fs-6">
																	{{ \Carbon\Carbon::parse($proposal['proposal_date'])->format('d-M-Y') }}
																</div>
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<div class="fw-400 d-block fs-6">
																	&#x20b9;{{ number_format($proposal['total_proposal_amount'], 2) }}
																</div>
															</div>
														</td>
														<td>
															<div class="d-flex align-items-center">
																<div class="fw-400 d-block fs-6">
																	&#x20b9;{{ number_format($proposal['total_paid_amount'], 2) }}
																</div>
															</div>
														</td>
														<td>
															@php
															$probalanceAmount = $proposal['total_proposal_amount'] - $proposal['total_paid_amount'];
															@endphp
															<div class="d-flex align-items-center">
																<div class="fw-400 d-block fs-6">
																	&#x20b9;{{ number_format($probalanceAmount, 2) }}
																</div>
															</div>
														</td>

													</tr>
													@empty
													<tr>
														<td colspan="4">No data found</td>
													</tr>
													@endforelse

												</tbody>
												<!--end::Table body-->
											</table>
											<!--end::Table-->

										</div>

									</div>
									<!--end::Table-->
								</div>
								<!--end::Card body-->
							</div>
							<!--end::Card-->
							<!--begin::Card-->

							<!--end::Card-->
							<!--begin::Card-->

							<!--end::Card-->
							<!--begin::Card-->

							<!--end::Card-->
						</div>
						<!--end:::Tab pane-->
						<!--begin:::Tab pane-->

						<!--end:::Tab pane-->
						<!--begin:::Tab pane-->
						<!--end:::Tab pane-->
					</div>
					<!--end:::Tab content-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Layout-->
			<!--begin::Modals-->
			<!--begin::Modal - Add Payment-->
			<div class="modal fade" id="kt_modal_add_payment" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog mw-650px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2 class="fw-bold">Add a Payment Record</h2>
							<!--end::Modal title-->
							<!--begin::Close-->
							<div id="kt_modal_add_payment_close" class="btn btn-icon btn-sm btn-active-icon-primary">
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
								<span class="svg-icon svg-icon-1">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
										<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Close-->
						</div>
						<!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
							<!--begin::Form-->
							<form id="kt_modal_add_payment_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
								<!--begin::Input group-->
								<div class="fv-row mb-7 fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="fs-6 fw-semibold form-label mb-2">
										<span class="required">Invoice Number</span>
										<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="The invoice number must be unique." data-kt-initialized="1"></i>
									</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" name="invoice" value="">
									<!--end::Input-->
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row mb-7 fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold form-label mb-2">Status</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select class="form-select form-select-solid fw-bold select2-hidden-accessible" name="status" data-control="select2" data-placeholder="Select an option" data-hide-search="true" data-select2-id="select2-data-10-7x1n" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
										<option data-select2-id="select2-data-12-9btc"></option>
										<option value="0">Approved</option>
										<option value="1">Pending</option>
										<option value="2">Rejected</option>
										<option value="3">In progress</option>
										<option value="4">Completed</option>
									</select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-11-mu62" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-status-xv-container" aria-controls="select2-status-xv-container"><span class="select2-selection__rendered" id="select2-status-xv-container" role="textbox" aria-readonly="true" title="Select an option"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									<!--end::Input-->
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row mb-7 fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold form-label mb-2">Invoice Amount</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid" name="amount" value="">
									<!--end::Input-->
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row mb-15">
									<!--begin::Label-->
									<label class="fs-6 fw-semibold form-label mb-2">
										<span class="required">Additional Information</span>
										<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Information such as description of invoice or product purchased." data-kt-initialized="1"></i>
									</label>
									<!--end::Label-->
									<!--begin::Input-->
									<textarea class="form-control form-control-solid rounded-3" name="additional_info"></textarea>
									<!--end::Input-->
								</div>
								<!--end::Input group-->
								<!--begin::Actions-->
								<div class="text-center">
									<button type="reset" id="kt_modal_add_payment_cancel" class="btn btn-light me-3">Discard</button>
									<button type="submit" id="kt_modal_add_payment_submit" class="btn btn-primary">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Modal body-->
					</div>
					<!--end::Modal content-->
				</div>
				<!--end::Modal dialog-->
			</div>
			<!--end::Modal - New Card-->
			<!--begin::Modal - Adjust Balance-->
			<div class="modal fade" id="kt_modal_adjust_balance" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-650px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2 class="fw-bold">Adjust Balance</h2>
							<!--end::Modal title-->
							<!--begin::Close-->
							<div id="kt_modal_adjust_balance_close" class="btn btn-icon btn-sm btn-active-icon-primary">
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
								<span class="svg-icon svg-icon-1">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
										<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Close-->
						</div>
						<!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
							<!--begin::Balance preview-->
							<div class="d-flex text-center mb-9">
								<div class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
									<div class="fs-6 fw-semibold mb-2 text-muted">Current Balance</div>
									<div class="fs-2 fw-bold" kt-modal-adjust-balance="current_balance">US&#x20b9; 32,487.57</div>
								</div>
								<div class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
									<div class="fs-6 fw-semibold mb-2 text-muted">New Balance
										<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Enter an amount to preview the new balance." data-kt-initialized="1"></i>
									</div>
									<div class="fs-2 fw-bold" kt-modal-adjust-balance="new_balance">--</div>
								</div>
							</div>
							<!--end::Balance preview-->
							<!--begin::Form-->
							<form id="kt_modal_adjust_balance_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
								<!--begin::Input group-->
								<div class="fv-row mb-7 fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold form-label mb-2">Adjustment type</label>
									<!--end::Label-->
									<!--begin::Dropdown-->
									<select class="form-select form-select-solid fw-bold select2-hidden-accessible" name="adjustment" aria-label="Select an option" data-control="select2" data-dropdown-parent="#kt_modal_adjust_balance" data-placeholder="Select an option" data-hide-search="true" data-select2-id="select2-data-13-zqig" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
										<option data-select2-id="select2-data-15-w3a7"></option>
										<option value="1">Credit</option>
										<option value="2">Debit</option>
									</select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-14-mc3o" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-adjustment-0m-container" aria-controls="select2-adjustment-0m-container"><span class="select2-selection__rendered" id="select2-adjustment-0m-container" role="textbox" aria-readonly="true" title="Select an option"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									<!--end::Dropdown-->
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row mb-7 fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold form-label mb-2">Amount</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input id="kt_modal_inputmask" type="text" class="form-control form-control-solid" name="amount" value="" inputmode="text">
									<!--end::Input-->
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row mb-7">
									<!--begin::Label-->
									<label class="fs-6 fw-semibold form-label mb-2">Add adjustment note</label>
									<!--end::Label-->
									<!--begin::Input-->
									<textarea class="form-control form-control-solid rounded-3 mb-5"></textarea>
									<!--end::Input-->
								</div>
								<!--end::Input group-->
								<!--begin::Disclaimer-->
								<div class="fs-7 text-muted mb-15">Please be aware that all manual balance changes will be audited by the financial team every fortnight. Please maintain your invoices and receipts until then. Thank you.</div>
								<!--end::Disclaimer-->
								<!--begin::Actions-->
								<div class="text-center">
									<button type="reset" id="kt_modal_adjust_balance_cancel" class="btn btn-light me-3">Discard</button>
									<button type="submit" id="kt_modal_adjust_balance_submit" class="btn btn-primary">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Modal body-->
					</div>
					<!--end::Modal content-->
				</div>
				<!--end::Modal dialog-->
			</div>
			<!--end::Modal - New Card-->
			<!--begin::Modal - New Address-->
			<div class="modal fade" id="kt_modal_update_customer" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-650px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Form-->
						<form class="form" action="#" id="kt_modal_update_customer_form">
							<!--begin::Modal header-->
							<div class="modal-header" id="kt_modal_update_customer_header">
								<!--begin::Modal title-->
								<h2 class="fw-bold">Update Customer</h2>
								<!--end::Modal title-->
								<!--begin::Close-->
								<div id="kt_modal_update_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
									<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
									<span class="svg-icon svg-icon-1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
											<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Close-->
							</div>
							<!--end::Modal header-->
							<!--begin::Modal body-->
							<div class="modal-body py-10 px-lg-17">
								<!--begin::Scroll-->
								<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_customer_header" data-kt-scroll-wrappers="#kt_modal_update_customer_scroll" data-kt-scroll-offset="300px" style="max-height: 307px;">
									<!--begin::Notice-->
									<!--begin::Notice-->
									<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
										<!--begin::Icon-->
										<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
										<span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
												<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
												<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
											</svg>
										</span>
										<!--end::Svg Icon-->
										<!--end::Icon-->
										<!--begin::Wrapper-->
										<div class="d-flex flex-stack flex-grow-1">
											<!--begin::Content-->
											<div class="fw-semibold">
												<div class="fs-6 text-gray-700">Updating customer details will receive a privacy audit. For more info, please read our
													<a href="#">Privacy Policy</a>
												</div>
											</div>
											<!--end::Content-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Notice-->
									<!--end::Notice-->
									<!--begin::User toggle-->
									<div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_customer_user_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_customer_user_info">User Information
										<span class="ms-2 rotate-180">
											<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
											<span class="svg-icon svg-icon-3">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
									</div>
									<!--end::User toggle-->
									<!--begin::User form-->
									<div id="kt_modal_update_customer_user_info" class="collapse show">
										<!--begin::Input group-->
										<div class="mb-7">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">
												<span>Update Avatar</span>
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Allowed file types: png, jpg, jpeg." data-kt-initialized="1"></i>
											</label>
											<!--end::Label-->
											<!--begin::Image input wrapper-->
											<div class="mt-1">
												<!--begin::Image input-->
												<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
													<!--begin::Preview existing avatar-->
													<div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
													<!--end::Preview existing avatar-->
													<!--begin::Edit-->
													<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-kt-initialized="1">
														<i class="bi bi-pencil-fill fs-7"></i>
														<!--begin::Inputs-->
														<input type="file" name="avatar" accept=".png, .jpg, .jpeg">
														<input type="hidden" name="avatar_remove">
														<!--end::Inputs-->
													</label>
													<!--end::Edit-->
													<!--begin::Cancel-->
													<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-kt-initialized="1">
														<i class="bi bi-x fs-2"></i>
													</span>
													<!--end::Cancel-->
													<!--begin::Remove-->
													<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-kt-initialized="1">
														<i class="bi bi-x fs-2"></i>
													</span>
													<!--end::Remove-->
												</div>
												<!--end::Image input-->
											</div>
											<!--end::Image input wrapper-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="fv-row mb-7">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">Name</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" placeholder="" name="name" value="Sean Bean">
											<!--end::Input-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="fv-row mb-7">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">
												<span>Email</span>
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Email address must be active" data-kt-initialized="1"></i>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="email" class="form-control form-control-solid" placeholder="" name="email" value="sean@dellito.com">
											<!--end::Input-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="fv-row mb-15">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">Description</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" placeholder="" name="description">
											<!--end::Input-->
										</div>
										<!--end::Input group-->
									</div>
									<!--end::User form-->
									<!--begin::Billing toggle-->
									<div class="fw-bold fs-3 rotate collapsible collapsed mb-7" data-bs-toggle="collapse" href="#kt_modal_update_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_customer_billing_info">Shipping Information
										<span class="ms-2 rotate-180">
											<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
											<span class="svg-icon svg-icon-3">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
									</div>
									<!--end::Billing toggle-->
									<!--begin::Billing form-->
									<div id="kt_modal_update_customer_billing_info" class="collapse">
										<!--begin::Input group-->
										<div class="d-flex flex-column mb-7 fv-row">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">Address Line 1</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input class="form-control form-control-solid" placeholder="" name="address1" value="101, Collins Street">
											<!--end::Input-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="d-flex flex-column mb-7 fv-row">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">Address Line 2</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input class="form-control form-control-solid" placeholder="" name="address2">
											<!--end::Input-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="d-flex flex-column mb-7 fv-row">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">Town</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input class="form-control form-control-solid" placeholder="" name="city" value="Melbourne">
											<!--end::Input-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row g-9 mb-7">
											<!--begin::Col-->
											<div class="col-md-6 fv-row">
												<!--begin::Label-->
												<label class="fs-6 fw-semibold mb-2">State / Province</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input class="form-control form-control-solid" placeholder="" name="state" value="Victoria">
												<!--end::Input-->
											</div>
											<!--end::Col-->
											<!--begin::Col-->
											<div class="col-md-6 fv-row">
												<!--begin::Label-->
												<label class="fs-6 fw-semibold mb-2">Post Code</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input class="form-control form-control-solid" placeholder="" name="postcode" value="3000">
												<!--end::Input-->
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="d-flex flex-column mb-7 fv-row">
											<!--begin::Label-->
											<label class="fs-6 fw-semibold mb-2">
												<span>Country</span>
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" aria-label="Country of origination" data-kt-initialized="1"></i>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<select name="country" aria-label="Select a Country" data-control="select2" data-placeholder="Select a Country..." data-dropdown-parent="#kt_modal_update_customer" class="form-select form-select-solid fw-bold select2-hidden-accessible" data-select2-id="select2-data-16-cddz" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
												<option value="" data-select2-id="select2-data-18-htca">Select a Country...</option>
												<option value="AF">Afghanistan</option>
												<option value="AX">Aland Islands</option>
												<option value="AL">Albania</option>
												<option value="DZ">Algeria</option>
												<option value="AS">American Samoa</option>
												<option value="AD">Andorra</option>
												<option value="AO">Angola</option>
												<option value="AI">Anguilla</option>
												<option value="AG">Antigua and Barbuda</option>
												<option value="AR">Argentina</option>
												<option value="AM">Armenia</option>
												<option value="AW">Aruba</option>
												<option value="AU">Australia</option>
												<option value="AT">Austria</option>
												<option value="AZ">Azerbaijan</option>
												<option value="BS">Bahamas</option>
												<option value="BH">Bahrain</option>
												<option value="BD">Bangladesh</option>
												<option value="BB">Barbados</option>
												<option value="BY">Belarus</option>
												<option value="BE">Belgium</option>
												<option value="BZ">Belize</option>
												<option value="BJ">Benin</option>
												<option value="BM">Bermuda</option>
												<option value="BT">Bhutan</option>
												<option value="BO">Bolivia, Plurinational State of</option>
												<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
												<option value="BA">Bosnia and Herzegovina</option>
												<option value="BW">Botswana</option>
												<option value="BR">Brazil</option>
												<option value="IO">British Indian Ocean Territory</option>
												<option value="BN">Brunei Darussalam</option>
												<option value="BG">Bulgaria</option>
												<option value="BF">Burkina Faso</option>
												<option value="BI">Burundi</option>
												<option value="KH">Cambodia</option>
												<option value="CM">Cameroon</option>
												<option value="CA">Canada</option>
												<option value="CV">Cape Verde</option>
												<option value="KY">Cayman Islands</option>
												<option value="CF">Central African Republic</option>
												<option value="TD">Chad</option>
												<option value="CL">Chile</option>
												<option value="CN">China</option>
												<option value="CX">Christmas Island</option>
												<option value="CC">Cocos (Keeling) Islands</option>
												<option value="CO">Colombia</option>
												<option value="KM">Comoros</option>
												<option value="CK">Cook Islands</option>
												<option value="CR">Costa Rica</option>
												<option value="CI">Côte d'Ivoire</option>
												<option value="HR">Croatia</option>
												<option value="CU">Cuba</option>
												<option value="CW">Curaçao</option>
												<option value="CZ">Czech Republic</option>
												<option value="DK">Denmark</option>
												<option value="DJ">Djibouti</option>
												<option value="DM">Dominica</option>
												<option value="DO">Dominican Republic</option>
												<option value="EC">Ecuador</option>
												<option value="EG">Egypt</option>
												<option value="SV">El Salvador</option>
												<option value="GQ">Equatorial Guinea</option>
												<option value="ER">Eritrea</option>
												<option value="EE">Estonia</option>
												<option value="ET">Ethiopia</option>
												<option value="FK">Falkland Islands (Malvinas)</option>
												<option value="FJ">Fiji</option>
												<option value="FI">Finland</option>
												<option value="FR">France</option>
												<option value="PF">French Polynesia</option>
												<option value="GA">Gabon</option>
												<option value="GM">Gambia</option>
												<option value="GE">Georgia</option>
												<option value="DE">Germany</option>
												<option value="GH">Ghana</option>
												<option value="GI">Gibraltar</option>
												<option value="GR">Greece</option>
												<option value="GL">Greenland</option>
												<option value="GD">Grenada</option>
												<option value="GU">Guam</option>
												<option value="GT">Guatemala</option>
												<option value="GG">Guernsey</option>
												<option value="GN">Guinea</option>
												<option value="GW">Guinea-Bissau</option>
												<option value="HT">Haiti</option>
												<option value="VA">Holy See (Vatican City State)</option>
												<option value="HN">Honduras</option>
												<option value="HK">Hong Kong</option>
												<option value="HU">Hungary</option>
												<option value="IS">Iceland</option>
												<option value="IN">India</option>
												<option value="ID">Indonesia</option>
												<option value="IR">Iran, Islamic Republic of</option>
												<option value="IQ">Iraq</option>
												<option value="IE">Ireland</option>
												<option value="IM">Isle of Man</option>
												<option value="IL">Israel</option>
												<option value="IT">Italy</option>
												<option value="JM">Jamaica</option>
												<option value="JP">Japan</option>
												<option value="JE">Jersey</option>
												<option value="JO">Jordan</option>
												<option value="KZ">Kazakhstan</option>
												<option value="KE">Kenya</option>
												<option value="KI">Kiribati</option>
												<option value="KP">Korea, Democratic People's Republic of</option>
												<option value="KW">Kuwait</option>
												<option value="KG">Kyrgyzstan</option>
												<option value="LA">Lao People's Democratic Republic</option>
												<option value="LV">Latvia</option>
												<option value="LB">Lebanon</option>
												<option value="LS">Lesotho</option>
												<option value="LR">Liberia</option>
												<option value="LY">Libya</option>
												<option value="LI">Liechtenstein</option>
												<option value="LT">Lithuania</option>
												<option value="LU">Luxembourg</option>
												<option value="MO">Macao</option>
												<option value="MG">Madagascar</option>
												<option value="MW">Malawi</option>
												<option value="MY">Malaysia</option>
												<option value="MV">Maldives</option>
												<option value="ML">Mali</option>
												<option value="MT">Malta</option>
												<option value="MH">Marshall Islands</option>
												<option value="MQ">Martinique</option>
												<option value="MR">Mauritania</option>
												<option value="MU">Mauritius</option>
												<option value="MX">Mexico</option>
												<option value="FM">Micronesia, Federated States of</option>
												<option value="MD">Moldova, Republic of</option>
												<option value="MC">Monaco</option>
												<option value="MN">Mongolia</option>
												<option value="ME">Montenegro</option>
												<option value="MS">Montserrat</option>
												<option value="MA">Morocco</option>
												<option value="MZ">Mozambique</option>
												<option value="MM">Myanmar</option>
												<option value="NA">Namibia</option>
												<option value="NR">Nauru</option>
												<option value="NP">Nepal</option>
												<option value="NL">Netherlands</option>
												<option value="NZ">New Zealand</option>
												<option value="NI">Nicaragua</option>
												<option value="NE">Niger</option>
												<option value="NG">Nigeria</option>
												<option value="NU">Niue</option>
												<option value="NF">Norfolk Island</option>
												<option value="MP">Northern Mariana Islands</option>
												<option value="NO">Norway</option>
												<option value="OM">Oman</option>
												<option value="PK">Pakistan</option>
												<option value="PW">Palau</option>
												<option value="PS">Palestinian Territory, Occupied</option>
												<option value="PA">Panama</option>
												<option value="PG">Papua New Guinea</option>
												<option value="PY">Paraguay</option>
												<option value="PE">Peru</option>
												<option value="PH">Philippines</option>
												<option value="PL">Poland</option>
												<option value="PT">Portugal</option>
												<option value="PR">Puerto Rico</option>
												<option value="QA">Qatar</option>
												<option value="RO">Romania</option>
												<option value="RU">Russian Federation</option>
												<option value="RW">Rwanda</option>
												<option value="BL">Saint Barthélemy</option>
												<option value="KN">Saint Kitts and Nevis</option>
												<option value="LC">Saint Lucia</option>
												<option value="MF">Saint Martin (French part)</option>
												<option value="VC">Saint Vincent and the Grenadines</option>
												<option value="WS">Samoa</option>
												<option value="SM">San Marino</option>
												<option value="ST">Sao Tome and Principe</option>
												<option value="SA">Saudi Arabia</option>
												<option value="SN">Senegal</option>
												<option value="RS">Serbia</option>
												<option value="SC">Seychelles</option>
												<option value="SL">Sierra Leone</option>
												<option value="SG">Singapore</option>
												<option value="SX">Sint Maarten (Dutch part)</option>
												<option value="SK">Slovakia</option>
												<option value="SI">Slovenia</option>
												<option value="SB">Solomon Islands</option>
												<option value="SO">Somalia</option>
												<option value="ZA">South Africa</option>
												<option value="KR">South Korea</option>
												<option value="SS">South Sudan</option>
												<option value="ES">Spain</option>
												<option value="LK">Sri Lanka</option>
												<option value="SD">Sudan</option>
												<option value="SR">Suriname</option>
												<option value="SZ">Swaziland</option>
												<option value="SE">Sweden</option>
												<option value="CH">Switzerland</option>
												<option value="SY">Syrian Arab Republic</option>
												<option value="TW">Taiwan, Province of China</option>
												<option value="TJ">Tajikistan</option>
												<option value="TZ">Tanzania, United Republic of</option>
												<option value="TH">Thailand</option>
												<option value="TG">Togo</option>
												<option value="TK">Tokelau</option>
												<option value="TO">Tonga</option>
												<option value="TT">Trinidad and Tobago</option>
												<option value="TN">Tunisia</option>
												<option value="TR">Turkey</option>
												<option value="TM">Turkmenistan</option>
												<option value="TC">Turks and Caicos Islands</option>
												<option value="TV">Tuvalu</option>
												<option value="UG">Uganda</option>
												<option value="UA">Ukraine</option>
												<option value="AE">United Arab Emirates</option>
												<option value="GB">United Kingdom</option>
												<option value="US">United States</option>
												<option value="UY">Uruguay</option>
												<option value="UZ">Uzbekistan</option>
												<option value="VU">Vanuatu</option>
												<option value="VE">Venezuela, Bolivarian Republic of</option>
												<option value="VN">Vietnam</option>
												<option value="VI">Virgin Islands</option>
												<option value="YE">Yemen</option>
												<option value="ZM">Zambia</option>
												<option value="ZW">Zimbabwe</option>
											</select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-17-rlhk" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid fw-bold" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-country-68-container" aria-controls="select2-country-68-container"><span class="select2-selection__rendered" id="select2-country-68-container" role="textbox" aria-readonly="true" title="Select a Country..."><span class="select2-selection__placeholder">Select a Country...</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
											<!--end::Input-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="fv-row mb-7">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack">
												<!--begin::Label-->
												<div class="me-5">
													<!--begin::Label-->
													<label class="fs-6 fw-semibold">Use as a billing adderess?</label>
													<!--end::Label-->
													<!--begin::Input-->
													<div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
													<!--end::Input-->
												</div>
												<!--end::Label-->
												<!--begin::Switch-->
												<label class="form-check form-switch form-check-custom form-check-solid">
													<!--begin::Input-->
													<input class="form-check-input" name="billing" type="checkbox" value="1" id="kt_modal_update_customer_billing" checked="checked">
													<!--end::Input-->
													<!--begin::Label-->
													<span class="form-check-label fw-semibold text-muted" for="kt_modal_update_customer_billing">Yes</span>
													<!--end::Label-->
												</label>
												<!--end::Switch-->
											</div>
											<!--begin::Wrapper-->
										</div>
										<!--end::Input group-->
									</div>
									<!--end::Billing form-->
								</div>
								<!--end::Scroll-->
							</div>
							<!--end::Modal body-->
							<!--begin::Modal footer-->
							<div class="modal-footer flex-center">
								<!--begin::Button-->
								<button type="reset" id="kt_modal_update_customer_cancel" class="btn btn-light me-3">Discard</button>
								<!--end::Button-->
								<!--begin::Button-->
								<button type="submit" id="kt_modal_update_customer_submit" class="btn btn-primary">
									<span class="indicator-label">Submit</span>
									<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!--end::Button-->
							</div>
							<!--end::Modal footer-->
						</form>
						<!--end::Form-->
					</div>
				</div>
			</div>
			<!--end::Modal - New Address-->
			<!--begin::Modal - New Card-->
			<div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-dialog-centered mw-650px">
					<!--begin::Modal content-->
					<div class="modal-content">
						<!--begin::Modal header-->
						<div class="modal-header">
							<!--begin::Modal title-->
							<h2>Add New Card</h2>
							<!--end::Modal title-->
							<!--begin::Close-->
							<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
								<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
								<span class="svg-icon svg-icon-1">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
										<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Close-->
						</div>
						<!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
							<!--begin::Form-->
							<form id="kt_modal_new_card_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
								<!--begin::Input group-->
								<div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
										<span class="required">Name On Card</span>
										<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Specify a card holder's name" data-kt-initialized="1"></i>
									</label>
									<!--end::Label-->
									<input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe">
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
									<!--begin::Label-->
									<label class="required fs-6 fw-semibold form-label mb-2">Card Number</label>
									<!--end::Label-->
									<!--begin::Input wrapper-->
									<div class="position-relative">
										<!--begin::Input-->
										<input type="text" class="form-control form-control-solid" placeholder="Enter card number" name="card_number" value="4111 1111 1111 1111">
										<!--end::Input-->
										<!--begin::Card logos-->
										<div class="position-absolute translate-middle-y top-50 end-0 me-5">
											<img src="assets/media/svg/card-logos/visa.svg" alt="" class="h-25px">
											<img src="assets/media/svg/card-logos/mastercard.svg" alt="" class="h-25px">
											<img src="assets/media/svg/card-logos/american-express.svg" alt="" class="h-25px">
										</div>
										<!--end::Card logos-->
									</div>
									<!--end::Input wrapper-->
									<div class="fv-plugins-message-container invalid-feedback"></div>
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="row mb-10">
									<!--begin::Col-->
									<div class="col-md-8 fv-row">
										<!--begin::Label-->
										<label class="required fs-6 fw-semibold form-label mb-2">Expiration Date</label>
										<!--end::Label-->
										<!--begin::Row-->
										<div class="row fv-row fv-plugins-icon-container">
											<!--begin::Col-->
											<div class="col-6">
												<select name="card_expiry_month" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Month" data-select2-id="select2-data-19-670l" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
													<option data-select2-id="select2-data-21-o1g0"></option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
												</select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-20-0bal" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-card_expiry_month-j9-container" aria-controls="select2-card_expiry_month-j9-container"><span class="select2-selection__rendered" id="select2-card_expiry_month-j9-container" role="textbox" aria-readonly="true" title="Month"><span class="select2-selection__placeholder">Month</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
												<div class="fv-plugins-message-container invalid-feedback"></div>
											</div>
											<!--end::Col-->
											<!--begin::Col-->
											<div class="col-6">
												<select name="card_expiry_year" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Year" data-select2-id="select2-data-22-indi" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
													<option data-select2-id="select2-data-24-aby4"></option>
													<option value="2022">2022</option>
													<option value="2023">2023</option>
													<option value="2024">2024</option>
													<option value="2025">2025</option>
													<option value="2026">2026</option>
													<option value="2027">2027</option>
													<option value="2028">2028</option>
													<option value="2029">2029</option>
													<option value="2030">2030</option>
													<option value="2031">2031</option>
													<option value="2032">2032</option>
												</select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-23-0wac" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-card_expiry_year-dp-container" aria-controls="select2-card_expiry_year-dp-container"><span class="select2-selection__rendered" id="select2-card_expiry_year-dp-container" role="textbox" aria-readonly="true" title="Year"><span class="select2-selection__placeholder">Year</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
												<div class="fv-plugins-message-container invalid-feedback"></div>
											</div>
											<!--end::Col-->
										</div>
										<!--end::Row-->
									</div>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-md-4 fv-row fv-plugins-icon-container">
										<!--begin::Label-->
										<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
											<span class="required">CVV</span>
											<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" aria-label="Enter a card CVV code" data-kt-initialized="1"></i>
										</label>
										<!--end::Label-->
										<!--begin::Input wrapper-->
										<div class="position-relative">
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" minlength="3" maxlength="4" placeholder="CVV" name="card_cvv">
											<!--end::Input-->
											<!--begin::CVV icon-->
											<div class="position-absolute translate-middle-y top-50 end-0 me-3">
												<!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
												<span class="svg-icon svg-icon-2hx">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M22 7H2V11H22V7Z" fill="currentColor"></path>
														<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z" fill="currentColor"></path>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
											<!--end::CVV icon-->
										</div>
										<!--end::Input wrapper-->
										<div class="fv-plugins-message-container invalid-feedback"></div>
									</div>
									<!--end::Col-->
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="d-flex flex-stack">
									<!--begin::Label-->
									<div class="me-5">
										<label class="fs-6 fw-semibold form-label">Save Card for further billing?</label>
										<div class="fs-7 fw-semibold text-muted">If you need more info, please check budget planning</div>
									</div>
									<!--end::Label-->
									<!--begin::Switch-->
									<label class="form-check form-switch form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" value="1" checked="checked">
										<span class="form-check-label fw-semibold text-muted">Save Card</span>
									</label>
									<!--end::Switch-->
								</div>
								<!--end::Input group-->
								<!--begin::Actions-->
								<div class="text-center pt-15">
									<button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3">Discard</button>
									<button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Modal body-->
					</div>
					<!--end::Modal content-->
				</div>
				<!--end::Modal dialog-->
			</div>
			<!--end::Modal - New Card-->
			<!--end::Modals-->
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>
@endsection
@section('pageScripts')
<script>
    $(document).ready(function() {
        $('#proposal-table').DataTable({
            "pageLength": 10,
            "ordering": false,
            "searching": false,
            "lengthChange": false,
            "autoWidth": false,
        });
    });
</script>

@endsection