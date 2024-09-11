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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">View Proposal</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Proposal</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-400 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
								
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">{{$proposal->proposal_id}}</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<div class="card-toolbar">

										<!-- begin::Pint-->
										<button type="button" class="btn btn-sm btn-success me-5" onclick="window.print();"><i class="fa-solid fa-check "></i> Approve & Generate RO</button>
														<!-- end::Pint-->
								
														<!-- begin::Pint-->
														<button type="button" class="btn btn-sm btn-info me-5" onclick="window.print();"><i class="fa-solid fa-print"></i> Print</button>
														<!-- end::Pint-->
														
										
													<!-- end::Actions-->
										<a href="{{ route('lead.index') }}" class="btn btn-sm btn-primary">
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
												<div class="flex-sm-row mb-2">
													<!--end::Logo-->
													<div class="text-sm-start">
														<!--begin::Logo-->
														<a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2">
														{{$proposal->proposal_id}} | {{$proposal->proposal_title}}
														</a>
														<!--end::Logo-->
													
													</div>
														<!--begin::Text-->
														<div class="d-flex  justify-content-between text-sm-start fw-semibold fs-7 text-muted">
																<div  class="d-flex flex-column">
																<span class="fs-5 text-gray-900">{{$proposal->vendor->vendor_name}}</span>
																<span class="fs-7">Unit 1/23 Hastings Road,	Banglore 3000,Karnataka-677593
																<br>info@nfonics.com | +91-999-345-4565</span>	
																GSTIN : 32AAN0826C1Z4 | PAN NO: A46CN0826C</span>
																</div>
																<div  class="d-flex flex-column">
																<span class="text-muted">Date</span>
																<span class="fs-5">06 October, 2024</span>
															</div>
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
														
														<!--begin::Billing & shipping-->
														<div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
															<div class="flex-root d-flex flex-column">
																<span class="text-gray-900 fs-4">Scope & Services</span>
																{!! $proposal->proposal_description !!}
															</div>
															
														</div>
														<!--end::Billing & shipping-->
														<!--begin:Order summary-->
														<div class="d-flex justify-content-between flex-column">
															<!--begin::Table-->
															<div class="table-responsive border-bottom mb-9">
															<span class="text-gray-900 fs-4">Cost & Payments</span>
																<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
																	<thead>
																		<tr class="border-bottom fs-6 fw-bold text-muted">
																			<th class="min-w-175px pb-2">Milestone</th>
																			<th class="min-w-70px text-start pb-2">Date</th>
																			<th class="min-w-70px text-end pb-2">Amount</th>
																			<th class="min-w-80px text-end pb-2">GST(%)</th>
																			<th class="min-w-100px text-end pb-2">Total</th>
																		</tr>
																	</thead>
																	<tbody class="fw-semibold text-gray-600">
																	@foreach ($proposal->paymentMilestones as $milestone)
																		<!--begin::Products-->
																		<tr>
																			<!--begin::Product-->
																			<td>
																				<div class="d-flex align-items-center">
																				
																					<!--begin::Title-->
																					<div class="ms-0">
																						<div class="fw-bold">{{ $milestone->milestone_title }}</div>																						
																					</div>
																					<!--end::Title-->
																				</div>
																			</td>
																			<!--end::Product-->
																			<!--begin::Date-->
																			<td class="text-start">{{ \Carbon\Carbon::parse($milestone->milestone_date)->format('d-M-Y') }}</td>
																			<!--end::SKU-->
																			<!--begin::SKU-->
																			<td class="text-end">&#x20b9;{{ $milestone->milestone_amount }}</td>
																			<!--end::SKU-->
																			<!--begin::Quantity-->
																			<td class="text-end">{{ $milestone->milestone_gst }}</td>
																			<!--end::Quantity-->
																			<!--begin::Total-->
																			<td class="text-end">&#x20b9;{{ $milestone->milestone_total_amount }}</td>
																			<!--end::Total-->
																		</tr>
																		
																		<!--end::Products-->

																		@endforeach
																		
																	<!--begin::Grand total-->
																		<tr>
																			<td colspan="4" class="fs-2 text-dark fw-bold text-end" style="font-size:18px !important;">Grand Total</td>
																			<td class="text-dark fw-bolder text-end fs-2 " style="font-size:18px !important;">&#x20b9;9,207.00</td>
																		</tr>
																		
																		<tr>
																			<td colspan="5" class="fw-bold text-end" style="font-size:14px !important;text-transform: uppercase; color:#009ef7 !important;" >AMOUNT IN WORDS : RUPEES Nine thousand two hundred seven rupees only </td>
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
