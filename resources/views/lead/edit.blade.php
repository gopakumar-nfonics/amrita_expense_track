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
                        Edit Proposal</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="" class="text-muted text-hover-primary">Proposal</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Edit Proposal</li>

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

                                <form id="kt_invoice_form" method="POST"
                                    action="{{ $proposal->proposal_status == 2 ? route('lead.store') : route('lead.update', $proposal->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if($proposal->proposal_status != 2)
                                    @method('PUT')
                                    @endif

                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!--begin::Row-->
                                        <div class="row gx-10 mb-5">
                                            <div class="row pe-0 pb-5">
                                                <div class="col-lg-12">
                                                    <div class="fv-row  d-flex justify-content-between">
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-3">
                                                            <!--begin::Input group-->

                                                            <!--begin::Label-->
                                                            <label class="required form-label">Date</label>
                                                            <!--end::Label-->
                                                            <!--begin::Editor-->
                                                            <!--begin::Input group-->
                                                            <div class="d-flex align-items-center justify-content-start flex-equal order-3 fw-row"
                                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                data-kt-initialized="1">
                                                                <!--begin::Date-->
                                                                <!--end::Date-->
                                                                <!--begin::Input-->
                                                                <div
                                                                    class="position-relative d-flex align-items-center">
                                                                    <!--begin::Datepicker-->
                                                                    <input
                                                                        class="form-control fw-bold pe-5 @error('invoice_due_date') is-invalid @enderror"
                                                                        placeholder="Select date" id="invoice_due_date"
                                                                        name="invoice_due_date"
                                                                        value="{{ old('invoice_due_date', $proposal->proposal_date) }}"
                                                                        type="text">
                                                                    @error('invoice_due_date')<div
                                                                        class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                    <!--end::Datepicker-->
                                                                    <!--begin::Icon-->
                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                                    <span
                                                                        class="svg-icon svg-icon-2 position-absolute end-0 me-4">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                    <!--end::Icon-->
                                                                </div>

                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->


                                                        </div>
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-9">


                                                            <!--begin::Label-->
                                                            <label class="required form-label">Title</label>
                                                            <!--end::Label-->
                                                            <!--begin::Select2-->
                                                            <!--begin::Editor-->
                                                            <input id="" name="ptitle" placeholder="Proposal Title"
                                                                class="form-control mb-2 @error('ptitle') is-invalid @enderror"
                                                                value="{{ old('ptitle', $proposal->proposal_title) }}" />
                                                            @error('ptitle')<div class="invalid-feedback">{{ $message }}
                                                            </div> @enderror
                                                            <!--end::Editor-->
                                                            <!--end::Select2-->

                                                        </div>
                                                    </div>
                                                    <div class="fv-row mt-5">
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-12">


                                                            <!--begin::Label-->
                                                            <label class="required form-label">Scope & Service
                                                                Description</label>
                                                            <!--end::Label-->

                                                            <!--begin::Editor-->
                                                            <textarea id="summernote" name="description"
                                                                class="form-control mb-2 @error('description') is-invalid @enderror">{{$proposal->proposal_description}}</textarea>
                                                            @error('description')<div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div> @enderror
                                                            <!--end::Editor-->


                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="mt-10 border-bottom">
                                                    <label class="form-label color-blue">Cost and Tax</label>
                                                    <div class="text-muted fs-7">Mention Cost and Tax associated with
                                                        this proposal. Also upload the reference document, if any</div>

                                                </div>
                                            </div>

                                            <!--end::Row-->
                                            <div class="col-lg-12">
                                                <div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">

                                                    <div class="d-flex flex-row gap-6">

                                                        <!--begin::Input group-->
                                                        <div class="fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Cost
                                                                (INR)</label>
                                                            <!--end::Label-->
                                                            <!--begin::Editor-->
                                                            <input id="order_cost" name="order_cost" placeholder="Cost"
                                                                class="form-control mb-2 @error('order_cost') is-invalid @enderror"
                                                                value="{{ old('order_cost', $proposal->proposal_cost) }}"
                                                                oninput="calculateTotalCost()" />
                                                            @error('order_cost')<div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div> @enderror
                                                            <!--end::Editor-->


                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Input group-->
                                                        <div class="fv-row">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">GST (%)</label>
                                                            <!--end::Label-->
                                                            <!--begin::Editor-->
                                                            <input id="order_gst" name="order_gst" placeholder="GST %"
                                                                class="form-control mb-2 @error('order_gst') is-invalid @enderror"
                                                                value="{{ old('order_gst', number_format($proposal->proposal_gst, (int) $proposal->proposal_gst == $proposal->proposal_gst ? 0 : 2)) }}"
                                                                oninput="calculateTotalCost()" />
                                                            @error('order_gst')<div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div> @enderror
                                                            <!--end::Editor-->
                                                        </div>
                                                        <!--end::Input group-->


                                                        <!--begin::Input group-->
                                                        <div class="fv-row pt-0">
                                                            <!--begin::Label-->
                                                            <label class="required form-label">Total Cost
                                                                (INR)</label>
                                                            <!--end::Label-->
                                                            <!--begin::Editor-->

                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Currency-->
                                                                <span
                                                                    class="fs-2 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                                                <!--end::Currency-->
                                                                <!--begin::Value-->
                                                                <input id="total_cost" name="total_cost"
                                                                    placeholder="0.00"
                                                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2 border-0 w-100 disabled-input @error('total_cost') is-invalid @enderror"
                                                                    value="{{ old('total_cost', $proposal->proposal_total_cost) }}" readonly />
                                                                @error('total_cost')<div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div> @enderror
                                                                <!--end::Editor-->
                                                                <!--end::Value-->

                                                            </div>

                                                        </div>

                                                        <!--begin::Input group-->
                                                        <div class="fv-row pt-0">
                                                            <div class="text-center">
                                                                <label for="file-upload"
                                                                    class="btn btn-sm btn-info w-100 mt-5 mb-1">
                                                                    <!--begin::Svg Icon | path: icons/duotune/files/fil018.svg-->
                                                                    <span class="svg-icon svg-icon-2">
                                                                        <i class="fa-solid fa-upload"></i>
                                                                    </span>
                                                                    <!--end::Svg Icon-->Upload File
                                                                    <input type="file" id="file-upload" name="file"
                                                                        class="d-none @error('file') is-invalid @enderror"
                                                                        onchange="updateFileName()" />
                                                                </label>
                                                            </div>

                                                            <!-- Display the selected file name here -->
                                                            <div class="text-muted fs-7" id="file-name">
                                                                @if(!empty($proposal->file_path))
                                                                {{ basename($proposal->file_path) }}
                                                                @else
                                                                Upload reference document.
                                                                @endif
                                                            </div>
                                                            @error('file')<div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div> @enderror
                                                            <!--end::Description-->
                                                        </div>

                                                        <!--end::Input group-->
                                                    </div>


                                                </div>
                                            </div>
                                            <!--begin::Table wrapper-->
                                            <div class="table-responsive mb-10 col-lg-12">

                                                <!--begin::Input group-->

                                                <!--begin::Table-->
                                                <div class="min-h-300px me-10 ">
                                                    <label class="form-label color-blue">Payment Milestones</label>
                                                    <div class="text-muted fs-7 border-bottom">Mention the
                                                        specific points where payments are made, typically aligned with
                                                        the completion of key deliverables or phases.</div>
                                                    <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700"
                                                        data-kt-element="items">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <tr
                                                                class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                                <th class="min-w-200px w-275px">Milestone</th>
                                                                <th class="min-w-200px w-200px">Amount</th>
                                                                <th class="min-w-100px w-100px">GST (%) </th>
                                                                <th class="min-w-200px w-200px text-end">Total</th>
                                                                <th class="min-w-75px w-75px text-end">Remove</th>
                                                            </tr>
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody data-kt-element="item-template">
                                                            @foreach ($proposal->paymentMilestones as $milestone)
                                                            <tr class="border-bottom border-bottom-dashed"
                                                                data-kt-element="item">
                                                                <td class="pe-7">
                                                                    <input type="text"
                                                                        class="form-control form-control-solid mb-2"
                                                                        name="name[]" placeholder="Milestone Title" value="{{ old('name', $milestone->milestone_title) }}">

                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-solid text-end"
                                                                        name="amount[]" data-kt-element="price"
                                                                        placeholder="Amount" value="{{ old('amount', $milestone->milestone_amount) }}">
                                                                </td>
                                                                <td class="ps-0">
                                                                    <input class="form-control form-control-solid"
                                                                        type="decimal" name="gst[]"
                                                                        data-kt-element="quantity" placeholder="GST %" value="{{ old('gst', number_format($milestone->milestone_gst, (int) $milestone->milestone_gst == $milestone->milestone_gst ? 0 : 2)) }}">
                                                                </td>

                                                                <td class="pt-8 text-end text-nowrap">&#x20b9;
                                                                    <span class="total-cost-span" data-kt-element="total">{{$milestone->milestone_total_amount}}</span>
                                                                </td>
                                                                <td class="pt-5 text-end">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-icon btn-active-color-primary"
                                                                        data-kt-element="remove-item">
                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                                        <span class="svg-icon svg-icon-3">
                                                                            <svg width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                    fill="currentColor"></path>
                                                                                <path opacity="0.5"
                                                                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                    fill="currentColor"></path>
                                                                                <path opacity="0.5"
                                                                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                    fill="currentColor"></path>
                                                                            </svg>
                                                                        </span>
                                                                        <!--end::Svg Icon-->
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <!--end::Table body-->
                                                        <!--begin::Table foot-->
                                                        <tfoot>
                                                            <tr
                                                                class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                                <th class="text-primary">
                                                                    <button
                                                                        class="btn btn-sm btn-success w-150px mt-0 mb-1"
                                                                        data-kt-element="add-item">Add
                                                                        Milestone</button>
                                                                </th>
                                                                <th colspan="4"
                                                                    class="border-bottom border-bottom-dashed ps-0">
                                                                    <div class="d-flex flex-column align-items-end">
                                                                        <div>
                                                                            <span
                                                                                class="fs-2 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                                                            <span
                                                                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                                                                                data-kt-element="sub-total">0.00</span>
                                                                        </div>


                                                                    </div>
                                                                </th>
                                                                <!-- <th colspan="2" class="border-bottom border-bottom-dashed text-end">
																<span data-kt-element="sub-total">0.00</span>
															</th> -->
                                                            </tr>

                                                        </tfoot>
                                                        <!--end::Table foot-->
                                                    </table>
                                                    <span class="invalid-feedback" id="error-message"></span>

                                                </div>
                                                <!--end::Order details-->
                                                <div class="d-flex justify-content-end border-top mt-0 pt-5">
                                                    <!--begin::Button-->
                                                    <a href="../../demo1/dist/apps/ecommerce/catalog/products.html"
                                                        id="kt_ecommerce_edit_order_cancel"
                                                        class="btn btn-light me-5">Cancel</a>
                                                    <!--end::Button-->
                                                    <!--begin::Button-->
                                                    <button type="submit" id="kt_ecommerce_edit_order_submit"
                                                        class="btn btn-primary">
                                                        <span class="indicator-label">Submit Proposal</span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                    <!--end::Button-->
                                                </div>
                                            </div>

                                            <!--end::Table-->
                                            <!--begin::Item template-->

                                            <table class="table d-none" data-kt-element="empty-template">
                                                <tbody>
                                                    <tr data-kt-element="empty">
                                                        <th colspan="5" class="text-muted text-center py-10">No items
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>

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
<!-- Summernote CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 125, // Set the editor height
            placeholder: 'Add service description...',
            tabsize: 2,
            toolbar: [
                // [groupName, [list of buttons]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
            ]
        });

    });




    function calculateTotalCost() {
        const costInput = document.getElementById('order_cost');
        const gstInput = document.getElementById('order_gst');
        const totalCostInput = document.getElementById('total_cost');

        // Get values from the input fields
        const cost = parseFloat(costInput.value) || 0;
        const gstPercentage = parseFloat(gstInput.value) || 0;

        // Calculate the total cost
        const totalCost = cost + (cost * gstPercentage) / 100;


        // Update the total cost field
        totalCostInput.value = totalCost.toFixed(2); // Set the value with two decimal places

        setCurrencyFormatting('#total_cost');
    }
</script>
<script>
    function updateFileName() {
        var input = document.getElementById('file-upload');
        var fileName = input.files.length > 0 ? input.files[0].name : 'Upload reference document.';
        document.getElementById('file-name').textContent = fileName;
    }
</script>
@endsection