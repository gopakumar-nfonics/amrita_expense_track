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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Update Payment</h1>
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
                        <li class="breadcrumb-item text-muted">Update Payment</li>
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
                
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <!--begin::Wrapper-->
                                <div class="mb-0">
                                    <!--begin::Row-->

                                    <!-- Subtitle for Bill Section -->
                                    <div class="row mb-5">
                                        <h5 class="text-muted fw-bold border-bottom pb-2 color-theme">Payment Request Details</h5>
                                    </div>

                                    <div class="row gx-10 mb-5">
                                        <div class="row ps-15 pe-0 pb-9">
                                            <div class="col-lg-12 d-flex justify-content-between">
                                                <!-- Bill Section Columns -->
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                    <label class="form-label fw-bold fs-6">PR #</label>
                                                    <div class="fw-bold fs-8">2324-569</div>
                                                </div>
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                    <label class="form-label fw-bold fs-6">Vendor</label>
                                                    <div class="fw-bold fs-8">Ana Simmons</div>
                                                </div>
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                    <label class="form-label fw-bold fs-6">Company</label>
                                                    <div class="fw-bold fs-8">Intertico Solutions</div>
                                                </div>
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                    <label class="form-label fw-bold fs-6">Request Date</label>
                                                    <div class="fw-bold fs-8">22-Aug-2024</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row ps-15 pe-0 pb-9">
                                            <div class="col-lg-12 d-flex">
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                    <label class="form-label fw-bold fs-6">Total Amount</label>
                                                    <div class="fw-bold fs-8">₹13482.00</div>
                                                </div>
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                    <label class="form-label fw-bold fs-6">Paid Amount</label>
                                                    <div class="fw-bold fs-8">₹0.00</div>
                                                </div>
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                    <label class="form-label fw-bold fs-6">Balance Amount</label>
                                                    <div class="fw-bold fs-8">₹13482.00</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Subtitle for Form Section -->
                                        <div class="row mb-5">
                                            <h5 class="text-muted fw-bold border-bottom pb-2 color-theme">Payment Details</h5>
                                        </div>

                                        <!--begin::Content-->
                                        <div id="kt_account_settings_profile_details" class="collapse show">
                                            <!--begin::Form-->
                                            <form id="kt_account_profile_details_form" class="form" method="POST" action="{{ route('vendor.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <!--begin::Card body-->
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <!--begin::First Column-->
                                                        <div class="col-lg-6">
                                                            <!--begin::Input group: Payment Date-->
                                                            <div class="mb-6">
                                                                <label class="form-label fw-semibold fs-6">Payment Date</label>
                                                                <input type="date" name="payment_date" class="form-control form-control-lg form-control-solid @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}" />
                                                                @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                            </div>
                                                            <!--end::Input group-->

                                                            <!--begin::Input group: Payment Amount-->
                                                            <div class="mb-6">
                                                                <label class="form-label fw-semibold fs-6">Payment Amount</label>
                                                                <input type="number" name="payment_amount" class="form-control form-control-lg form-control-solid @error('payment_amount') is-invalid @enderror" placeholder="Payment Amount" value="{{ old('payment_amount') }}" />
                                                                @error('payment_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                            </div>
                                                            <!--end::Input group-->

                                                            <!--begin::Input group: Cheque Number-->
                                                            <div class="mb-6">
                                                                <label class="form-label fw-semibold fs-6">Transaction Number</label>
                                                                <input type="text" name="cheque_number" class="form-control form-control-lg form-control-solid @error('cheque_number') is-invalid @enderror" placeholder="Transaction Number" value="{{ old('cheque_number') }}" />
                                                                @error('cheque_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::First Column-->

                                                        <!--begin::Second Column-->
                                                        <div class="col-lg-6">
                                                            <!--begin::Input group: Remarks-->
                                                            <div class="mb-6">
                                                                <label class="form-label fw-semibold fs-6">Notes</label>
                                                                <textarea name="remarks" class="form-control form-control-lg form-control-solid @error('remarks') is-invalid @enderror" rows="9" placeholder="Enter Notes">{{ old('remarks') }}</textarea>
                                                                @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::Second Column-->
                                                    </div>
                                                </div>
                                                <!--end::Card body-->

                                                <!--begin::Actions-->
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Payment</button>
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
@endsection
