@extends('layouts.admin')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main" data-select2-id="select2-data-kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid" data-select2-id="select2-data-122-9irx">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<!--begin::Title-->
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Create Payment Request</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="" class="text-muted text-hover-primary">Payment</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Manage Payment</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<!--end::Actions-->
								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-xxl">
									<!--begin::Layout-->
									<div class="d-flex flex-column flex-lg-row">
										<!--begin::Content-->
										<div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
											<!--begin::Card-->
											<div class="card">
												<!--begin::Card body-->
												<div class="card-body p-12">
													<!--begin::Form-->
													<form action="" id="kt_invoice_form">
													<!--begin::Wrapper-->
														<div class="mb-0">
															<!--begin::Row-->
															<div class="row gx-10 mb-5">
																															
															<!--end::Row-->
															<div class="col-lg-3">
															<div class="w-100 flex-lg-row-auto w-lg-300px mb-7 me-7 me-lg-10">
											<!--begin::Order details-->
											<div class="card card-flush py-4 br-right">
												<!--begin::Card body-->
												<div class="card-body pt-0">
													<div class="d-flex flex-column gap-10">
														<!--begin::Input group-->
														<div class="fv-row">
															<!--begin::Label-->
															<label class="form-label">Request ID</label>
															<!--end::Label-->
															<!--begin::Auto-generated ID-->
															<div class="fw-bold fs-3">#2324-569</div>
															<!--end::Input-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="fv-row">
															<!--begin::Label-->
															<label class="required form-label">Category</label>
															<!--end::Label-->
															<!--begin::Select2-->
															<select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select Category" name="payment_method" id="kt_ecommerce_edit_order_payment">
																<option></option>
																<option value="cod">Cash on Delivery</option>
																<option value="visa">Credit Card (Visa)</option>
																<option value="mastercard">Credit Card (Mastercard)</option>
																<option value="paypal">Paypal</option>
															</select>
															<!--end::Select2-->
															<!--begin::Description-->
															<div class="d-flex flex-column">
															<div class="d-flex justify-content-between w-100 fs-9 fw-bold mb-3">
																<span>Budget</span>
																<span>&#x20b9;22,300 of 36,000 Used</span>
															</div>
															<div class="h-8px bg-light rounded mb-3">
																<div class="bg-success rounded h-8px" role="progressbar" style="width: 68%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
															<div class="fw-semibold text-gray-600 fs-7">14% remaining</div>
														</div>
															<!--end::Description-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="fv-row">
															<!--begin::Label-->
															<label class="required form-label">Vendor</label>
															<!--end::Label-->
															<!--begin::Select2-->
															<select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select Vendor" name="shipping_method" id="kt_ecommerce_edit_order_shipping">
																<option></option>
																<option value="none">N/A - Virtual Product</option>
																<option value="standard">Standard Rate</option>
																<option value="express">Express Rate</option>
																<option value="speed">Speed Overnight Rate</option>
															</select>
															<!--end::Select2-->
															<!--begin::Description-->
															<div class="text-muted fs-7">Select Vendor to process request.</div>
															<!--end::Description-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="fv-row">
															<!--begin::Label-->
															<label class="required form-label">Request Date</label>
															<!--end::Label-->
															<!--begin::Editor-->
															<!--begin::Input group-->
															<div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row" data-bs-toggle="tooltip" data-bs-trigger="hover" data-kt-initialized="1">
																<!--begin::Date-->
																<!--end::Date-->
																<!--begin::Input-->
																<div class="position-relative d-flex align-items-center">
																	<!--begin::Datepicker-->
																	<input class="form-control fw-bold pe-5 flatpickr-input" placeholder="Select date" name="invoice_due_date" type="text" readonly="readonly">
																	<!--end::Datepicker-->
																	<!--begin::Icon-->
																	<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
																	<span class="svg-icon svg-icon-2 position-absolute end-0 me-4">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
																		</svg>
																	</span>
																	<!--end::Svg Icon-->
																	<!--end::Icon-->
																</div>
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															
															<!--end::Editor-->
															<!--begin::Description-->
															<div class="text-muted fs-7">Select date the request date.</div>
															<!--end::Description-->
														</div>
														<!--end::Input group-->

														<!--begin::Input group-->
														<div class="fv-row">
															<!--begin::Label-->
															<label class="required form-label">Reference #</label>
															<!--end::Label-->
															<!--begin::Editor-->
															<input id="" name="order_date" placeholder="Reference Invoice #" class="form-control mb-2" value="" />
															<!--end::Editor-->
															<div class="text-center">
															<button type="button" class="btn btn-sm btn-info w-100 mt-5 mb-1" data-bs-toggle="modal" data-bs-target="#kt_modal_upload">
													<!--begin::Svg Icon | path: icons/duotune/files/fil018.svg-->
													<span class="svg-icon svg-icon-2">
													<i class="fa-solid fa-upload"></i>
													</span>
													<!--end::Svg Icon-->Upload File</button>
													</div>

														<!--begin::Description-->
														<div class="text-muted fs-7">Upload reference Invoice.</div>
															<!--end::Description-->
														</div>
														<!--end::Input group-->
													</div>
												</div>
												<!--end::Card header-->
											</div>
											<!--end::Order details-->
										</div>
																</div>
															<!--begin::Table wrapper-->
															<div class="table-responsive mb-10 col-lg-9">
																<!--begin::Table-->
																<table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
																	<!--begin::Table head-->
																	<thead>
																		<tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
																			<th class="min-w-300px w-475px">Item</th>
																			<th class="min-w-100px w-100px">QTY</th>
																			<th class="min-w-150px w-150px">Price</th>
																			<th class="min-w-100px w-150px text-end">Total</th>
																			<th class="min-w-75px w-75px text-end">Action</th>
																		</tr>
																	</thead>
																	<!--end::Table head-->
																	<!--begin::Table body-->
																	<tbody>
																		<tr class="border-bottom border-bottom-dashed" data-kt-element="item">
																			<td class="pe-7">
																				<input type="text" class="form-control form-control-solid mb-2" name="name[]" placeholder="Item name">
																				<input type="text" class="form-control form-control-solid" name="description[]" placeholder="Description">
																			</td>
																			<td class="ps-0">
																				<input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity">
																			</td>
																			<td>
																				<input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price">
																			</td>
																			<td class="pt-8 text-end text-nowrap">$
																			<span data-kt-element="total">0.00</span></td>
																			<td class="pt-5 text-end">
																				<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
																					<!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
																					<span class="svg-icon svg-icon-3">
																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
																							<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
																							<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
																						</svg>
																					</span>
																					<!--end::Svg Icon-->
																				</button>
																			</td>
																		</tr>
																	</tbody>
																	<!--end::Table body-->
																	<!--begin::Table foot-->
																	<tfoot>
																		<tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
																			<th class="text-primary">
																				<button class="btn btn-link py-1" data-kt-element="add-item">Add item</button>
																			</th>
																			<th colspan="2" class="border-bottom border-bottom-dashed ps-0">
																				<div class="d-flex flex-column align-items-start">
																					<div class="fs-5">Subtotal</div>
																					<button class="btn btn-link py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-kt-initialized="1">Add tax</button>
																					<button class="btn btn-link py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-kt-initialized="1">Add discount</button>
																				</div>
																			</th>
																			<th colspan="2" class="border-bottom border-bottom-dashed text-end">$
																			<span data-kt-element="sub-total">0.00</span></th>
																		</tr>
																		<tr class="align-top fw-bold text-gray-700">
																			<th></th>
																			<th colspan="2" class="fs-4 ps-0">Total</th>
																			<th colspan="2" class="text-end fs-4 text-nowrap">$
																			<span data-kt-element="grand-total">0.00</span></th>
																		</tr>
																	</tfoot>
																	<!--end::Table foot-->
																</table>
															</div>
															
															<!--end::Table-->
															<!--begin::Item template-->
															<table class="table d-none" data-kt-element="item-template">
																<tbody><tr class="border-bottom border-bottom-dashed" data-kt-element="item">
																	<td class="pe-7">
																		<input type="text" class="form-control form-control-solid mb-2" name="name[]" placeholder="Item name">
																		<input type="text" class="form-control form-control-solid" name="description[]" placeholder="Description">
																	</td>
																	<td class="ps-0">
																		<input class="form-control form-control-solid" type="number" min="1" name="quantity[]" placeholder="1" data-kt-element="quantity">
																	</td>
																	<td>
																		<input type="text" class="form-control form-control-solid text-end" name="price[]" placeholder="0.00" data-kt-element="price">
																	</td>
																	<td class="pt-8 text-end">$
																	<span data-kt-element="total">0.00</span></td>
																	<td class="pt-5 text-end">
																		<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
																			<!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
																			<span class="svg-icon svg-icon-3">
																				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																					<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
																					<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
																					<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
																				</svg>
																			</span>
																			<!--end::Svg Icon-->
																		</button>
																	</td>
																</tr>
															</tbody></table>
															<table class="table d-none" data-kt-element="empty-template">
																<tbody><tr data-kt-element="empty">
																	<th colspan="5" class="text-muted text-center py-10">No items</th>
																</tr>
															</tbody></table>
															
															<!--end::Item template-->
													
											
															</div>
														</div>
														<!--end::Wrapper-->
													</form>
													<!--end::Form-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->
										</div>
										<!--end::Content-->
										<!--begin::Sidebar-->
										
										<!--end::Sidebar-->
									</div>
									<!--end::Layout-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<!--end::Footer-->
					</div>
@endsection
@section('pageScripts')
<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->

<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->

<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Global Stylesheets Bundle-->

<script>var hostUrl = "{{ asset('assets/') }}";</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/custom/apps/invoices/create.js') }}"></script>
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endsection