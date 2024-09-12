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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Create Payment Request</h1>
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
                <div class="card-toolbar">
               
                <!-- end::Actions-->
                <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-primary">
                    Back to List
                </a>

            </div>
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
                                <form id="kt_invoice_form" method="POST" action="{{route('payment.store')}}"
                                    enctype="multipart/form-data">
                                    @csrf


                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!--begin::Row-->
                                        <div class="row gx-10 mb-5">
                                            <div class="row pe-0 pb-5">

                                                <div class="w-100">

                                                    <!--begin::Body-->
                                                    <div class="pb-12">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column">

                                                            <div class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                                                {{$invoice->proposal->proposal_title}}
                                                            </div>
                                                            <div class="text-muted fs-5">{{$invoice->vendor->vendor_name}}</div>

                                                            <!--begin::Separator-->
                                                            <div class="separator my-5"></div>
                                                            <!--begin::Separator-->
                                                            <!--begin::Order details-->
                                                            <div
                                                                class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                                                <div class="flex-root d-flex flex-column">
                                                                    <span class="text-muted">RO#</span>
                                                                    <span class="fs-5">#{{$invoice->proposalro->proposal_ro}}</span>
                                                                </div>
                                                                <div class="flex-root d-flex flex-column">
                                                                    <span class="text-muted">Invoice Date</span>
                                                                    <span class="fs-5">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d F, Y') }}</span>
                                                                </div>
                                                                <div class="flex-root d-flex flex-column">
                                                                    <span class="text-muted">Invoice #</span>
                                                                    <span class="fs-5">#{{$invoice->invoice_number}}</span>
                                                                </div>
                                                                <div class="flex-root d-flex flex-column">
                                                                    <div class="symbol symbol-30px me-5">
                                                                        <img alt="Icon"
                                                                            src="{{ url('/') }}/assets/media/svg/files/pdf.svg">
                                                                        <a class="fs-7 text-muted border-bottom color-blue ms-2"
                                                                            href="{{ Storage::url($invoice->invoice_file) }}" download="{{ basename($invoice->invoice_file) }}">{{$invoice->milestone->milestone_title}}</a>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <!--end::Order details-->
                                                            <!--begin::Billing & shipping-->
                                                            <div
                                                                class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold my-5">
                                                                <div class="flex-root d-flex flex-column">
                                                                    <span class="text-muted">Vendor Details</span>
                                                                    <span class="fs-5">{{$invoice->vendor->vendor_name}}</span>
                                                                    <span class="fs-7">{{$invoice->vendor->address}},
                                                                        <br>{{$invoice->vendor->city}},{{$invoice->vendor->states[0]->name}} | {{$invoice->vendor->postcode}}
                                                                        <br>GSTIN : {{$invoice->vendor->gst}} | PAN NO:
                                                                        {{$invoice->vendor->pan}}</span>
                                                                </div>
                                                                <div class="flex-root d-flex flex-column">
                                                                    <span class="text-muted">Bank Details</span>
                                                                    <span class="fs-5">{{$invoice->vendor->banckaccount->beneficiary_name}}</span>
                                                                    <span class="fs-7">Account NO. : {{$invoice->vendor->banckaccount->account_no}}
                                                                        <br>IFSC Code : {{$invoice->vendor->banckaccount->ifsc_code}}
                                                                        <br> {{$invoice->vendor->banckaccount->bank_name}}, {{$invoice->vendor->banckaccount->branch_name}} </span>
                                                                </div>
                                                            </div>
                                                            <!--end::Billing & shipping-->
                                                            <!--begin:Order summary-->
                                                            <div class="d-flex justify-content-between flex-column">
                                                                <!--begin::Table-->
                                                                <div class="table-responsive border-bottom mb-9">
                                                                    <table
                                                                        class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                                        <thead>
                                                                            <tr
                                                                                class="border-bottom fs-6 fw-bold text-muted">
                                                                                <th class="min-w-175px pb-2">Milestone
                                                                                </th>
                                                                                <th class="min-w-70px text-end pb-2">
                                                                                    Cost</th>
                                                                                <th class="min-w-80px text-end pb-2">
                                                                                    GST(%)
                                                                                </th>
                                                                                <th class="min-w-80px text-end pb-2">GST Amount
                                                                                </th>
                                                                                <th class="min-w-100px text-end pb-2">
                                                                                    Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="fw-semibold text-gray-600">
                                                                            <!--begin::Products-->
                                                                            <tr>
                                                                                <!--begin::Product-->
                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex align-items-center">

                                                                                        <!--begin::Title-->
                                                                                        <div class="ms-0">
                                                                                            <div
                                                                                                class="fw-bold fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">
                                                                                                {{$invoice->milestone->milestone_title}}
                                                                                            </div>
                                                                                        </div>
                                                                                        <!--end::Title-->
                                                                                    </div>
                                                                                </td>
                                                                                <!--end::Product-->
                                                                                <!--begin::SKU-->
                                                                                <td class="text-end">
                                                                                    <div
                                                                                        class="d-flex justify-content-end">
                                                                                        <div
                                                                                            class="fw-400 d-block fs-6">
                                                                                            <span
                                                                                                class="fs-2 fw-semibold text-gray-500 me-0">&#x20b9;</span>
                                                                                            <span
                                                                                                class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$invoice->milestone->milestone_amount}}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <!--end::SKU-->
                                                                                <!--begin::Quantity-->
                                                                                <td class="text-end">
                                                                                    <div
                                                                                        class="d-flex justify-content-end">
                                                                                        <div
                                                                                            class="fw-400 d-block fs-6">

                                                                                            <span
                                                                                                class=" fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">@if($invoice->milestone->milestone_gst == floor($invoice->milestone->milestone_gst))
                                                                                                {{ number_format($invoice->milestone->milestone_gst, 0) }} {{-- No decimal places --}}
                                                                                                @else
                                                                                                {{ number_format($invoice->milestone->milestone_gst, 2) }} {{-- Two decimal places --}}
                                                                                                @endif
                                                                                                %</span>

                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <!--end::Quantity-->
                                                                                <!--begin::Quantity-->
                                                                                <td class="text-end">
                                                                                    <div
                                                                                        class="d-flex justify-content-end">
                                                                                        <div
                                                                                            class="fw-400 d-block fs-6">
                                                                                            <span
                                                                                                class="fs-2 fw-semibold text-gray-500 me-0">&#x20b9;</span>
                                                                                            @php
                                                                                            $milestoneAmount=$invoice->milestone->milestone_amount; // Base amount before GST
                                                                                            $milestoneGstRate = $invoice->milestone->milestone_gst; // GST rate (percentage)

                                                                                            // Calculate GST Amount
                                                                                            $gstAmount = $milestoneAmount * ($milestoneGstRate / 100);
                                                                                            @endphp
                                                                                            <span
                                                                                                class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$gstAmount}}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <!--end::Quantity-->
                                                                                <!--begin::Total-->
                                                                                <td class="text-end">
                                                                                    <div
                                                                                        class="d-flex justify-content-end">
                                                                                        <div
                                                                                            class="fw-400 d-block fs-6">
                                                                                            <span
                                                                                                class="fs-2 fw-semibold text-gray-500 me-0">&#x20b9;</span>
                                                                                            <span
                                                                                                class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$invoice->milestone->milestone_total_amount}}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <!--end::Total-->
                                                                            </tr>

                                                                            <!--end::Products-->

                                                                            <!--begin::Products-->


                                                                            <!--end::Products-->
                                                                            <!--begin::Subtotal-->


                                                                            <!--begin::Grand total-->
                                                                            <tr>

                                                                                <td colspan="5"
                                                                                    class="text-dark fw-bolder text-end fs-2 "
                                                                                    style="font-size:18px !important;">



                                                                                    <div
                                                                                        class="text-muted fs-5 text-gray-600">
                                                                                        Rupees
                                                                                        {{$amounwords}}
                                                                                        rupees only.
                                                                                    </div>

                                                                                </td>
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
                                                <div class="col-lg-12 d-flex justify-content-between">
                                                    <div class="fs-6 fw-bold text-gray-700 text-nowrap col-lg-3">
                                                        <!--begin::Label-->
                                                        <label class="form-label">Request ID</label>
                                                        <!--end::Label-->
                                                        <!--begin::Auto-generated ID-->
                                                        <div class="fw-bold fs-3">#{{$paymentrequest->payment_request_id}}</div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="fs-6 fw-bold text-gray-700 col-lg-4 me-15">

                                                    <input type="hidden" value="{{$invoice->id}}" name="invoid">
                                                        <!--begin::Label-->
                                                        <label class="required form-label">Programme</label>
                                                        <!--end::Label-->
                                                        <!--begin::Select2-->
                                                        <select class="form-select mb-2 @error('programme') is-invalid @enderror" data-control="select2"
                                                            data-hide-search="true" data-placeholder="Select Stream"
                                                            name="programme" id="programme">
                                                            <option></option>
                                                            @foreach ($stream as $strm)
                                                            <option value="{{$strm->id}}"  @if(old('programme')==$strm->id) selected
                                                                    @endif>{{$strm->stream_name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('programme')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        <!--end::Select2-->
                                                    </div>
                                                    <div class="fs-6 fw-bold text-gray-700 col-lg-4">


                                                        <!--begin::Label-->
                                                        <label class="required form-label">Category</label>
                                                        <!--end::Label-->
                                                        <!--begin::Select2-->
                                                        <select class="form-select mb-2 @error('category') is-invalid @enderror" data-control="select2"
                                                            data-hide-search="true" data-placeholder="Select Category"
                                                            name="category" id="category"
                                                            onchange="getallocatedbudget()">
                                                            <option></option>
                                                            @foreach ($main_categories as $main_category)
                                                            @if ($main_category->children->isNotEmpty())
                                                            <optgroup label="{{ $main_category->category_name }}">
                                                                @foreach ($main_category->children as $subcategory)
                                                                <option class="sub-category"
                                                                    value="{{ $subcategory->id }}" @if(old('category')==$subcategory->id) selected
                                                                    @endif>
                                                                    {{ $subcategory->category_name }}
                                                                </option>
                                                                @endforeach
                                                            </optgroup>
                                                            @else
                                                            <!-- Print the main category as a standalone option if no children exist -->
                                                            <option class="main-category"
                                                                value="{{ $main_category->id }}"  @if(old('category')==$main_category->id) selected
                                                                    @endif>
                                                                {{ $main_category->category_name }}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                        <!--end::Select2-->
                                                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                                    </div>



                                                </div>
                                                <!--begin::Description-->
                                                <div class="d-flex flex-column pt-5" id="allocate_status"
                                                    style="display:none !important;">
                                                    <div class="d-flex justify-content-between w-100 fs-7 fw-bold mb-3">
                                                        <span>Budget allocated for <span
                                                                id="catname">Travel</span></span>

                                                    </div>
                                                    <div class="h-8px bg-light rounded mb-3">
                                                        <div class="bg-success rounded h-8px" role="progressbar"
                                                            style="width: 68%;" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <div
                                                        class="fw-semibold text-gray-600 fs-7 d-flex justify-content-between w-100">
                                                        <span class="color-blue">14% remaining </span><span
                                                            class="color-orange">&#x20b9;22,300 of 36,000 Used</span>
                                                    </div>
                                                </div>
                                                <!--end::Description-->

                                                <div class="separator separator-solid mt-7 mb-2"></div>
                                            </div>



                                            <!--end::Row-->



                                        </div>
                                        <!--end::Wrapper-->
                                        <div class="d-flex justify-content-end border-top mt-0 pt-5">
                                            <!--begin::Button-->
                                            <a href="../../demo1/dist/apps/ecommerce/catalog/products.html"
                                                id="kt_ecommerce_edit_order_cancel"
                                                class="btn btn-light me-5">Cancel</a>
                                            <!--end::Button-->
                                            <!--begin::Button-->
                                            <button type="submit" id="kt_ecommerce_edit_order_submit"
                                                class="btn btn-primary">
                                                <span class="indicator-label">Generate Payment Request</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                            <!--end::Button-->
                                        </div>

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

<script>
    var hostUrl = "{{ asset('assets/') }}";
</script>

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

<script>
    function getallocatedbudget() {
        $('#allocate_status').show();
        const selectElement = document.getElementById("pay_category");
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        // Find the optgroup (parent category)
        const optgroupElement = selectedOption.closest('optgroup');
        let parentCategoryName = '';

        // Check if the option belongs to an optgroup (subcategory)
        if (optgroupElement) {
            parentCategoryName = optgroupElement.label; // Get the parent category name
        } else {
            parentCategoryName = selectedOption.text; // If no parent, it's a main category
        }

        document.getElementById("catname").innerText = parentCategoryName;
    }
</script>
@endsection