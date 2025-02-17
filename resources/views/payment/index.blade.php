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
                    Request
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
                                    <th class="min-w-250px">Invoice & Proposal</th>


                                    <th class="min-w-150px">Program</th>

                                    <th class="min-w-150px">Category</th>
                                    <th class="min-w-150px">Amount</th>
                                    <th class="min-w-150px text-center">Actions</th>
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
                                                <a href="{{ $paymentrequestUrl }}" target="_blank"
                                                    class="text-dark fw-bold text-hover-primary fs-6">
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
                                                        <!--end::Svg Icon-->Payment Completed
                                                    </span>
                                                    @if($request->utr_number)
                                                    <div>
                                                        <span class="text-muted fw-semibold text-muted d-block fs-8">UTR
                                                            :
                                                            {{$request->utr_number}} </span>
                                                        <span
                                                            class="text-muted fw-semibold text-muted d-block fs-8">Date
                                                            :
                                                            {{ \Carbon\Carbon::parse($request->transaction_date)->format('d-M-Y') }}</span>
                                                    </div>
                                                    @endif
                                                    @elseif($request->payment_status == "initiated")

                                                    <span class="badge badge-light-warning fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-warning ms-n1">
                                                            <i class="fa-solid fa-spinner light-orange fs-8 me-2 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Payment Initiated
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <a href="{{ route('invoice.show',encrypt($request->invoice->id)) }}"
                                                    class="text-dark text-hover-primary fs-6 fw-bold ">
                                                    {{$request->invoice->invoice_id}} |
                                                    {{$request->invoice->milestone->milestone_title}}
                                                </a>

                                                <div class="d-flex justify-content-start flex-column">
                                                    @php
                                                    $releaseorder = 'RO_' .
                                                    $request->invoice->proposalro->proposal_ro.'.pdf';
                                                    $releaseorderPath = 'release_orders/' . $releaseorder;
                                                    $releaseorderUrl = asset('storage/' . $releaseorderPath);
                                                    @endphp
                                                    <a href="{{ $releaseorderUrl }}" download="{{ $releaseorder }}"
                                                        class="text-dark fw-bold text-muted text-hover-primary fs-8">RO#:{{$request->invoice->proposalro->proposal_ro}}</a>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <a href="{{ route('lead.show',encrypt($request->invoice->proposal->id)) }}"
                                                    class="text-dark fw-bold text-muted text-hover-primary fs-8">
                                                    {{$request->invoice->proposal->proposal_title}}</a>

                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('vendor.show',$request->invoice->vendor->id) }}"
                                                    class="text-dark fw-bold text-muted text-hover-primary fs-8">{{$request->invoice->vendor->vendor_name}}</a>

                                            </div>
                                        </div>
                                    </td>


                                    <td>

                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                @if($request->stream)
                                                <span
                                                    class="d-flex justify-content-start fw-semibold fs-7">{{$request->stream->stream_name}}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>

                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                @if($request->category)
                                                @if($request->category->parent){{$request->category->parent->category_name}}@else{{$request->category->category_name}}@endif
                                                @if($request->category->parent) </br> <span
                                                    class="d-flex justify-content-start text-muted fs-7">
                                                    {{$request->category->category_name}}</span>
                                                @endif

                                                @endif
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

                                            @if(!Auth::user()->isvendor() && ($request->payment_status == "initiated" || $request->payment_status == "completed"))
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
                                                <a href="{{ $paymentrequestUrl }}" target="_blank"
                                                    class="menu-link px-3">
                                                    Download PDF</a>
                                            </div>


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

                                            <div class="input-group">
                                                <!-- Prefix (non-editable) -->
                                                <span class="input-group-text"
                                                    style="background: #cccdcf;color: #000000;">P2</span>

                                                <!-- Editable UTR Number input -->
                                                <input type="hidden" name="reqid" id="reqid" value="">
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="UTR Number" name="utrnumber" id="utrnumber" value=""
                                                    required>
                                            </div>

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
            "ordering": false
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
    /*function updatepaymentstatus(rid) {

    $('#kt_modal_new_card').modal('show');
    $('#reqid').val(rid);
}*/
    function updatepaymentstatus(rid) {

        $.ajax({
            url: "{{ route('getPaymentDetails') }}",
            type: "GET",
            data: {
                reqid: rid
            },
            success: function(response) {
                $('#reqid').val(rid);

              if(response.utr_number != null){
                let utrNumber = response.utr_number;

                if (utrNumber.startsWith('P2')) {
                    utrNumber = utrNumber.replace(/^P2/, ''); // Remove 'P2' from the beginning
                }


                $('#utrnumber').val(utrNumber);
            }else{
                $('#utrnumber').val('');
            }

                let transactionDate = response.transaction_date;

                // Format the date to day-month-year (dd-mm-yyyy)
                let dateParts = transactionDate.split('-'); // Assuming input format is dd-mm-yyyy
                if (dateParts.length === 3) {
                    // If the date is in dd-mm-yyyy format, no change needed, but let's ensure it's consistent
                    let formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
                    $('#transactiondate').val(formattedDate); // Update the date input field
                }


               // $('#transactiondate').val(response.transaction_date);


                $('#kt_modal_new_card').modal('show');
            },
            error: function(xhr) {
                console.error("Error fetching payment details:", xhr);
                alert("Failed to fetch payment details. Please try again.");
            }
        });
    }

    $(document).ready(function() {
        $('#update_pay_status').on('submit', function(e) {
            e.preventDefault();

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
                    swal('This UTR number already used.', {
                        icon: "warning",
                        buttons: false,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);

                }
            });

        });
    });
</script>



@endsection