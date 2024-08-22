@extends('layouts.admin')

@section('content')
	<style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printableArea, #printableArea * {
                visibility: visible;
            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<!--begin::Title-->
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">View Payment Request</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Payment</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Payment Request</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">#2324-569</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<div class="card-toolbar">
										<a href="{{ route('payment.index') }}" class="btn btn-sm btn-primary">
											Back to List
										</a>
									</div>
								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-xxl">
									<!-- begin::Invoice 3-->
									<div class="card">
										<!-- begin::Body-->
										<div class="card-body py-20">
											<!-- begin::Wrapper-->
											<div class="mw-lg-950px mx-auto w-100" id="printableArea">
												<!-- begin::Header-->
												<div class="d-flex justify-content-between flex-column flex-sm-row mb-2">
													<!--end::Logo-->
													<div class="text-sm-end">
														<!--begin::Logo-->
														<a href="#" class="d-block mw-250px w-250px ms-sm-auto">
															<img alt="Logo"  src="{{ url('/') }}/assets/media/logos/logo_purple.png" class="w-100">
														</a>
														<!--end::Logo-->
													
													</div>
														<!--begin::Text-->
														<div class="text-sm-end fw-semibold fs-7 text-muted mt-7 ps-20">
															<address>DIRECTORATE OF ADMISSIONS 
															AMRITA SCHOOL OF ENGINEERING, </br> AMRITA VISHWA VIDYAPEETHAM, 
															AMRITA NAGAR(PO), ETTIMADAI, COIMBATORE - 641112
															</br> PHONE : 9489932973 | GSTIN : 33AAHTA3636K1ZQ</address>
														
														</div>
														<!--end::Text-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="pb-12">
													<!--begin::Wrapper-->
													<div class="d-flex flex-column gap-7 gap-md-10">
													
														<!--begin::Separator-->
														<div class="separator"></div>
														<!--begin::Separator-->
														<!--begin::Order details-->
														<div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">Request ID</span>
																<span class="fs-5">#2324-569</span>
															</div>
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">Date</span>
																<span class="fs-5">06 October, 2024</span>
															</div>
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">Invoice #</span>
																<span class="fs-5">#INV-000414</span>
															</div>
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">Category</span>
																<span class="fs-5">BE -  Travel </span>
															</div>
														</div>
														<!--end::Order details-->
														<!--begin::Billing & shipping-->
														<div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">Vendor Details</span>
																<span class="fs-5">NFONICS Solutions (P) Ltd</span>
																<span class="fs-7">Unit 1/23 Hastings Road,
																<br>Banglore 3000,Karnataka | 677593
																<br>GSTIN : 32AAN0826C1Z4 | PAN NO: A46CN0826C</span>
															</div>
															<div class="flex-root d-flex flex-column">
																<span class="text-muted">Bank Details</span>
																<span class="fs-5">NFONICS Solutions (P) Ltd</span>
																<span class="fs-7">Account NO. : 17020200000221
																<br>IFSC Code : FDRL0001702
																<br> Federal Bank, MG Road Branch, Banglore 3000,Karnataka </span>
															</div>
														</div>
														<!--end::Billing & shipping-->
														<!--begin:Order summary-->
														<div class="d-flex justify-content-between flex-column">
															<!--begin::Table-->
															<div class="table-responsive border-bottom mb-9">
																<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
																	<thead>
																		<tr class="border-bottom fs-6 fw-bold text-muted">
																			<th class="min-w-175px pb-2">ITEM</th>
																			<th class="min-w-70px text-end pb-2">Price</th>
																			<th class="min-w-80px text-end pb-2">QTY</th>
																			<th class="min-w-100px text-end pb-2">Total</th>
																		</tr>
																	</thead>
																	<tbody class="fw-semibold text-gray-600">
																		<!--begin::Products-->
																		<tr>
																			<!--begin::Product-->
																			<td>
																				<div class="d-flex align-items-center">
																				
																					<!--begin::Title-->
																					<div class="ms-0">
																						<div class="fw-bold">Hotel booking Taj Vivanta</div>																						
																					</div>
																					<!--end::Title-->
																				</div>
																			</td>
																			<!--end::Product-->
																			<!--begin::SKU-->
																			<td class="text-end">&#x20b9;2,400.00</td>
																			<!--end::SKU-->
																			<!--begin::Quantity-->
																			<td class="text-end">2</td>
																			<!--end::Quantity-->
																			<!--begin::Total-->
																			<td class="text-end">&#x20b9;4,800.00</td>
																			<!--end::Total-->
																		</tr>
																		
																		<!--end::Products-->

																		<!--begin::Products-->
																		<tr>
																			<!--begin::Product-->
																			<td>
																				<div class="d-flex align-items-center">
																				
																					<!--begin::Title-->
																					<div class="ms-0">
																						<div class="fw-bold">Train Ticket to BGLR</div>																						
																					</div>
																					<!--end::Title-->
																				</div>
																			</td>
																			<!--end::Product-->
																			<!--begin::SKU-->
																			<td class="text-end">&#x20b9;1,415.00</td>
																			<!--end::SKU-->
																			<!--begin::Quantity-->
																			<td class="text-end">3</td>
																			<!--end::Quantity-->
																			<!--begin::Total-->
																			<td class="text-end">&#x20b9;4,245.00</td>
																			<!--end::Total-->
																		</tr>
																		
																		<!--end::Products-->
																		<!--begin::Subtotal-->
																		<tr>
																			<td colspan="3" class="text-end">Subtotal</td>
																			<td class="text-end">&#x20b9;9,045.00</td>
																		</tr>
																		<!--end::Subtotal-->
																		<!--begin::VAT-->
																		<tr>
																			<td colspan="3" class="text-end">GST (18%)</td>
																			<td class="text-end">&#x20b9;162.00</td>
																		</tr>
																		<!--end::VAT-->
																	<!--begin::Grand total-->
																		<tr>
																			<td colspan="3" class="fs-2 text-dark fw-bold text-end" style="font-size:18px !important;">Grand Total</td>
																			<td class="text-dark fw-bolder text-end fs-2 " style="font-size:18px !important;">&#x20b9;9,207.00</td>
																		</tr>
																		
																		<tr>
																			<td colspan="4" class="fw-bold text-end" style="font-size:14px !important;text-transform: uppercase; color:#009ef7 !important;" >AMOUNT IN WORDS : RUPEES Nine thousand two hundred seven rupees only </td>
																			</tr>
																		<!--end::Grand total-->
																	</tbody>
																</table>
															</div>
															<!--end::Table-->
														</div>
														<!--end:Order summary-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Body-->
												<!-- begin::Footer-->
												<div class="d-flex justify-content-end mt-0 pt-0">
													<!-- begin::Actions-->
													<div class="my-1 me-0">
														<!-- begin::Pint-->
														<button type="button" class="btn btn-success my-1 me-0" onclick="window.print();">Print</button>
														<!-- end::Pint-->
														
													</div>
													<!-- end::Actions-->
													
												</div>
												<!-- end::Footer-->
											</div>
											<!-- end::Wrapper-->
										</div>
										<!-- end::Body-->
									</div>
									<!-- end::Invoice 1-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
@endsection
