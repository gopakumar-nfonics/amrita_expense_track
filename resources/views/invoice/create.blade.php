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
                        Submit Invoice</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="" class="text-muted text-hover-primary">Invoice</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Submit Invoice</li>
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
                                <form id="kt_invoice_form" method="POST" action="{{route('invoice.store')}}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!--begin::Row-->
                                        <div class="row gx-10 mb-5">
                                            <div class="row ps-15 pe-0 pb-5">
                                                <div class="col-lg-12">
                                                    <div class="fv-row d-flex justify-content-between">

                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-7 me-5">


                                                            <!--begin::Label-->
                                                            <label class="required form-label">Proposal</label>
                                                            <select class="form-control form-control-lg @error('proposal') is-invalid @enderror" id="proposal"
                                                                name="proposal" >
                                                                <option >--Select Proposal--</option>
                                                                @foreach($proposal as $prsl)
                                                                    <option value="{{ $prsl->id }}" @if(old('proposal') == $prsl->id) selected @endif>{{ $prsl->proposal_title }}</option>
                                                                @endforeach


                                                            </select>
                                                            @error('proposal')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                                        </div>
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-4">


                                                            <!--begin::Label-->
                                                            <label class="required form-label">Milestone</label>
                                                            <select class="form-control form-control-lg  @error('milestone') is-invalid @enderror" id="milestone"
                                                                name="milestone">
                                                                <option value="">--Select Milestone--</option>
                                                                 

                                                            </select>
                                                            @error('milestone')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                                        </div>


                                                    </div>




                                                    <div class="fv-row d-flex justify-content-between mt-10">
                                                        <div class="d-flex justify-content-between col-lg-7 me-5">
                                                            <!--begin::Input group-->
                                                            <div class="fv-row w-50">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">Cost (INR)</label>
                                                                <!--end::Label-->
                                                                <!--begin::Editor-->
                                                                <input id="milestone_cost" name="milestone_cost" placeholder="Cost"
                                                                    class="form-control mb-2 @error('milestone_cost') is-invalid @enderror"  value="{{ old('milestone_cost') }}" />
                                                                    @error('milestone_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                <!--end::Editor-->

                                                            </div>
                                                            <!--end::Input group-->

                                                            <!--begin::Input group-->
                                                            <div class="fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">GST (%)</label>
                                                                <!--end::Label-->
                                                                <!--begin::Editor-->
                                                                <input id="milestone_gst" name="milestone_gst" placeholder="GST %"
                                                                    class="form-control mb-2 @error('milestone_gst') is-invalid @enderror" value="{{ old('milestone_gst') }}"  />
                                                                    @error('milestone_gst')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                <!--end::Editor-->
                                                            </div>
                                                            <!--end::Input group-->



                                                        </div>
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-4">
                                                            <!--begin::Input group-->
                                                            <div class="fv-row pt-0">
                                                                <!--begin::Label-->
                                                                <label class="form-label">Total Cost
                                                                </label>
                                                                <!--end::Label-->
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <!--begin::Currency-->
                                                                    <span
                                                                        class="fs-2 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                                                    <!--end::Currency-->
                                                                    <!--begin::Value-->
                                                                    <span
                                                                        class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2" id="total_cost">00.00</span>
                                                                    <!--end::Value-->

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="fv-row d-flex justify-content-between mt-10">
                                                        <div class="d-flex justify-content-between col-lg-7 me-5">
                                                            <!--begin::Input group-->
                                                            <div class="fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">RO #</label>
                                                                <!--end::Label-->
                                                                <!--begin::Editor-->
                                                                <input id="proposalro" placeholder="RO #"
                                                                    class="form-control mb-2 @error('proposalro') is-invalid @enderror" name="proposalro"  value="{{ old('proposalro') }}" />
                                                                    @error('proposalro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                <!--end::Editor-->

                                                            </div>
                                                            <!--end::Input group-->

                                                            <!--begin::Input group-->
                                                            <div class="fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">Invoice #</label>
                                                                <!--end::Label-->
                                                                <!--begin::Editor-->
                                                                <input id="invoice_number" name="invoice_number" placeholder="Invoice #"
                                                                    class="form-control mb-2  @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number') }}" />
                                                                    @error('invoice_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                <!--end::Editor-->
                                                            </div>
                                                            <!--end::Input group-->


                                                            <!--begin::Input group-->
                                                            <div class="fv-row pt-0">
                                                                <!--begin::Label-->
                                                                <label class="required form-label">Invoice Date</label>
                                                                <!--end::Label-->
                                                                <!--begin::Editor-->
                                                                <input id="invoice_date" name="invoice_date"
                                                                    placeholder="Invoice Date" class="form-control mb-2  @error('invoice_date') is-invalid @enderror"
                                                                    value="{{ old('invoice_date') }}" />
                                                                    @error('invoice_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                <!--end::Editor-->
                                                            </div>
                                                        </div>
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-4">
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
                                                                            <input type="file" id="file-upload"
                                                                                name="file"
                                                                                class="d-none @error('file') is-invalid @enderror"
                                                                                onchange="updateFileName()" />
                                                                        </label>
                                                                </div>

                                                                <!--begin::Description-->
                                                                <div class="text-muted fs-7" id="file-name">Upload reference Invoice.
                                                                </div>
                                                                @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                <!--end::Description-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                    </div>

                                                </div>



                                                <div class="fv-row mt-5">


                                                    <div class="fs-6 fw-bold text-gray-700 col-lg-12">


                                                        <!--begin::Label-->
                                                        <label class="form-label">Notes</label>
                                                        <!--end::Label-->

                                                        <!--begin::Editor-->
                                                        <textarea name="invoice_note" class="form-control mb-2"></textarea>
                                                        @error('invoice_note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        <!--end::Editor-->


                                                    </div>
                                                </div>
                                                <div class="fv-row mt-5">
                                                    <div class="d-flex justify-content-end border-top mt-10 pt-5">
                                                        <!--begin::Button-->
                                                        <a href="../../demo1/dist/apps/ecommerce/catalog/products.html"
                                                            id="kt_ecommerce_edit_order_cancel"
                                                            class="btn btn-light me-5">Cancel</a>
                                                        <!--end::Button-->
                                                        <!--begin::Button-->
                                                        <button type="submit" id="kt_ecommerce_edit_order_submit"
                                                            class="btn btn-primary">
                                                            <span class="indicator-label">Submit Invoice</span>
                                                            <span class="indicator-progress">Please wait...
                                                                <span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                        <!--end::Button-->
                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <!--end::Row-->

                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive mb-10 col-lg-9">

                                            <!--begin::Input group-->

                                            <!--begin::Table-->

                                            <!--end::Order details-->

                                        </div>

                                        <!--end::Table-->
                                        <!--begin::Item template-->



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


<script>
    $(document).ready(function() {
        // Listen for changes to the proposal dropdown
        $('#proposal').change(function() {
            var proposalId = $(this).val(); // Get the selected proposal ID

            // Check if a proposal is selected
            if (proposalId) {
                $.ajax({
                    url: '/lead/get-milestones/' + proposalId, // The URL to send the AJAX request to
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Clear the milestone dropdown
                        $('#milestone').empty();
                        $('#milestone').append('<option value="">--Select Milestone--</option>');

                        // Populate the milestone dropdown with options
                        $.each(data.milestones, function(key, value) {
                            $('#milestone').append('<option value="' + value.id + '">' + value.milestone_title + '</option>');
                        });

                        if (data.proposalRo) {
                            $('#proposalro').val(data.proposalRo.proposal_ro);
                        } else {
                            $('#proposalRoDetails').html('<p>No Proposal RO details available.</p>');
                        }
                    
                    },
                    
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log errors to console
                    }
                });
            } else {
                // Clear the milestone dropdown if no proposal is selected
                $('#milestone').empty();
                $('#milestone').append('<option value="">--Select Milestone--</option>');
            }
        });


        $('#milestone').change(function() {
            var milestoneid = $(this).val(); 

            // Check if a proposal is selected
            if (milestoneid) {
                $.ajax({
                    url: '/lead/milestone-details/' + milestoneid, // The URL to send the AJAX request to
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                       
                        $('#milestone_gst').empty();
                        $('#milestone_cost').empty();

                        $('#milestone_cost').val(data.milestone_amount);
                        $('#milestone_gst').val(data.milestone_gst);
                        $('#total_cost').text(data.milestone_total_amount);

                        
                    
                    },
                    
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log errors to console
                    }
                });
            } else {
               
                $('#milestone_gst').empty();
                $('#milestone_cost').empty();
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#invoice_date", {
        defaultDate: new Date(), // Sets the default date to the current date
        dateFormat: "Y-m-d", // Use a standard format for backend compatibility
        placeholder: "Select date" // Placeholder text
    });
});
    

function updateFileName() {
    var input = document.getElementById('file-upload');
    var fileName = input.files.length > 0 ? input.files[0].name : 'Upload reference Invoice.';
    document.getElementById('file-name').textContent = fileName;
}
</script>

@endsection