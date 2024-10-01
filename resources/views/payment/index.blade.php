@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Payment
                    Listing</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <!-- <ul class="breadcrumb fw-semibold fs-7 my-0 pt-1">
											
										</ul> -->
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Button-->
            <!--<div class="card-toolbar">
                <a href="{{ route('payment.create') }}" class="btn btn-sm btn-primary">
                    Create
                </a>
            </div>-->
            <!--end::Button-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <!-- <div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold fs-3 mb-1">Category List</span>
											</h3>
										</div> -->
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <div class="overlay" id="loaderOverlay">
                            <div class="loader"></div>
                        </div>
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="budgettable">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bold">
                                    <th class="min-w-100px">ID</th>
                                    <th class="min-w-200px">Vendor</th>
                                    <th class="min-w-200px">Proposal & Category</th>
                                    <th class="min-w-100px">RO#</th>
                                    <th class="min-w-100px">Invoice</th>
                                    <th class="min-w-100px">Amount</th>
                                    <th class="min-w-50px text-center">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>

                                @forelse($payrequest as $key => $request)

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                @php
                                                $paymentrequest = 'PR_' . $request->payment_request_id.'.pdf';
                                                $paymentrequestPath = 'payment_request/' . $paymentrequest;
                                                $paymentrequestUrl = asset('storage/' . $paymentrequestPath);
                                                @endphp
                                                <a href="{{ $paymentrequestUrl }}" download="{{ $paymentrequest }}"
                                                    target="_blank" class="text-dark fw-bold text-hover-primary fs-6">
                                                    #{{$request->payment_request_id}}
                                                </a>
                                                <div class="text-gray-400 fw-semibold fs-9">
                                                    @if($request->payment_status == "pending")
                                                    <span class="badge badge-light-info fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i
                                                                class="fa-regular fa-circle-dot color-blue fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Payment Pending
                                                    </span>
                                                    @elseif($request->payment_status == "completed")

                                                    <span class="badge badge-light-success fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i class="fa-solid fa-check light-green fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Payment Processed
                                                    </span>
                                                    <div>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-7">UTR
                                                            :
                                                            #{{$request->utr_number}} </span>
                                                        <span
                                                            class="text-muted fw-semibold text-muted d-block fs-7">Date
                                                            :
                                                            {{ \Carbon\Carbon::parse($request->transaction_date)->format('d-M-Y') }}</span>
                                                    </div>
                                                    @elseif($request->payment_status == "initiated")

                                                    <span class="badge badge-light-warning fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-warning ms-n1">
                                                            <i class="fa-solid fa-spinner light-orange fs-8 me-2 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Payment initiated
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-2">
                                                <span class="symbol-label bg-blue text-white">
                                                    {{strtoupper($request->invoice->vendor->vendor_name[0])}}{{strtoupper($request->invoice->vendor->vendor_name[1])}}</span>

                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('vendor.show',$request->invoice->vendor->id) }}"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{$request->invoice->vendor->vendor_name}}</a>
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{$request->invoice->vendor->phone}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <a href="{{ route('lead.show',$request->invoice->proposal->id) }}"
                                                    class="text-dark fw-bold  text-hover-primary fs-6">
                                                    {{$request->invoice->proposal->proposal_title}}</a>
                                                <span
                                                    class="d-flex justify-content-start text-muted fw-semibold text-muted d-block fs-7">Submitted
                                                    On :
                                                    {{ \Carbon\Carbon::parse($request->invoice->proposal->created_at)->format('d-M-Y') }}

                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                Train Ticket | Travel
                                                <span class="d-flex justify-content-start fw-semibold fs-7">MCA
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="d-flex justify-content-start flex-column">
                                                @php
                                                $releaseorder = 'RO_' .
                                                $request->invoice->proposalro->proposal_ro.'.pdf';
                                                $releaseorderPath = 'release_orders/' . $releaseorder;
                                                $releaseorderUrl = asset('storage/' . $releaseorderPath);
                                                @endphp
                                                <a href="{{ $releaseorderUrl }}" download="{{ $releaseorder }}"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{$request->invoice->proposalro->proposal_ro}}</a>
                                                <span class="text-muted fw-semibold text-muted d-block fs-7">Issued On :
                                                    {{ \Carbon\Carbon::parse($request->invoice->proposalro->created_at)->format('d-M-Y') }}</span>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <a href="{{ route('invoice.show',$request->invoice->id) }}"
                                                    class="text-dark text-hover-primary fs-6 fw-bold ">
                                                    {{$request->invoice->milestone->milestone_title}}</a>
                                                <span class="text-muted fw-semibold text-muted d-block fs-7">Submitted
                                                    On :
                                                    {{ \Carbon\Carbon::parse($request->invoice->created_at)->format('d-M-Y') }}</span>
                                            </div>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span
                                                    class="fs-2 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                <span
                                                    class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$request->invoice->milestone->milestone_total_amount}}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <i class="fa-solid fa-angle-down"></i></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                            data-kt-menu="true">


                                            <!--begin::Menu item-->

                                            @if(!Auth::user()->isvendor() && $request->payment_status == "initiated")
                                            <div class="menu-item px-3">
                                                <a href="#" onclick="updatepaymentstatus('{{$request->id}}');"
                                                    class="menu-link px-3">Update Payment Status</a>
                                            </div>
                                            @endif
                                            <div class="menu-item px-3">
                                                @php
                                                $paymentrequest = 'PR_' . $request->payment_request_id.'.pdf';
                                                $paymentrequestPath = 'payment_request/' . $paymentrequest;
                                                $paymentrequestUrl = asset('storage/' . $paymentrequestPath);
                                                @endphp
                                                <a href="{{ $paymentrequestUrl }}" download="{{ $paymentrequest }}"
                                                    target="_blank" class="menu-link px-3">
                                                    Download PDF</a>
                                            </div>

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="" class="menu-link px-3"
                                                    data-kt-customer-table-filter="delete_row">Delete</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
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
                    <!--end::Table container-->

                    <!--begin::Modal - New Card-->
                    <div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2>Update Payment Status</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                    transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y m-5">
                                    <!--begin::Form-->
                                    <form id="update_pay_status" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                        action="#" method="POST">
                                        <!--begin::Input group-->
                                        <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">UTR Number</span>

                                            </label>
                                            <!--end::Label-->
                                            <input type="hidden" name="reqid" id="reqid" value="">
                                            <input type="text" class="form-control form-control-solid"
                                                placeholder="UTR Number" name="utrnumber" id="utrnumber" value=""
                                                required>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Transaction Date</span>

                                            </label>
                                            <!--end::Label-->
                                            <input type="text" class="form-control form-control-solid" placeholder=""
                                                name="transactiondate" id="transactiondate" value="" required>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Actions-->
                                        <div class="text-end pt-1 pb-3">
                                            <button type="reset" id="kt_modal_new_card_cancel"
                                                class="btn btn-light me-3">Cancel</button>
                                            <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary">
                                                <span class="indicator-label">Update</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                <!--begin::Body-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('pageScripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$(document).ready(function() {

    $('#budgettable').DataTable({
        "iDisplayLength": 10,
        "searching": true,
        "recordsTotal": 3615,
        "pagingType": "full_numbers"
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#transactiondate", {
        defaultDate: new Date(), // Sets the default date to the current date
        dateFormat: "d-m-Y", // Use a standard format for backend compatibility
        placeholder: "Select date" // Placeholder text
    });
});
</script>

<script>
function updatepaymentstatus(rid) {

    $('#kt_modal_new_card').modal('show');
    $('#reqid').val(rid);
}
$(document).ready(function() {
    $('#update_pay_status').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update this status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {

                let dateInput = $('#transactiondate')
                    .val(); // Assuming the date is in DD-MM-YYYY
                let formattedDate = dateInput.split("-").reverse().join(
                    "-"); // Convert to YYYY-MM-DD

                let formData = {
                    _token: '{{ csrf_token() }}',
                    utrnumber: $('#utrnumber').val(),
                    transactiondate: formattedDate,
                    reqid: $('#reqid').val(),
                };

                document.getElementById('loaderOverlay').style.display = 'flex';

                $.ajax({
                    url: "{{ route('update.payment.status') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        document.getElementById('loaderOverlay').style.display =
                            'none';
                        if (response.success) {
                            swal('Payment status updated successfully!', {
                                icon: "success",
                                buttons: false,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1000);

                        } else {
                            document.getElementById('loaderOverlay').style.display =
                                'none';
                            swal('Failed to update payment status', {
                                icon: "warning",
                                buttons: false,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1000);

                        }
                    },
                    error: function(xhr) {
                        swal('An error occurred. Please try again', {
                            icon: "Error",
                            buttons: false,
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);

                    }
                });
            }
        });
    });
});
</script>



@endsection