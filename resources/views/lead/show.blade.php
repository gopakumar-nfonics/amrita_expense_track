@extends('layouts.admin')

@section('content')
<style>
.swal-modal {
    min-width: 600px;
    padding: 40px 20px;

}

select#programSelect {
    margin: 30px auto 15px;
    cursor: pointer;
}

@media print {
    body * {
        visibility: hidden;
    }

    #printableArea,
    #printableArea * {
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">View
                    Proposal</h1>
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
                @if(!Auth::user()->isvendor() && $proposal->proposal_status ==0)
                <!-- begin::Pint-->
                <button type="button" class="btn btn-sm btn-success me-5" onclick="approve('{{$proposal->id}}')"><i
                        class="fa-solid fa-check "></i> Approve & Generate RO</button>
                <!-- end::Pint-->
                @endif
                <!-- begin::Pint-->
                <button type="button" class="btn btn-sm btn-info me-5" onclick="window.print();"><i
                        class="fa-solid fa-print"></i> Print</button>
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

                    <div class="overlay" id="loaderOverlay">
                        <div class="loader"></div>
                    </div>
                    <!-- begin::Wrapper-->
                    <div class="mw-lg-950px mx-auto w-100" id="printableArea">
                        <!-- begin::Header-->
                        <div class="flex-sm-row mb-2">
                            <!--end::Logo-->
                            <div class="text-sm-start">
                                <!--begin::Logo-->
                                <a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue txt-uppercase">
                                    {{$proposal->proposal_id}} | {{$proposal->proposal_title}}
                                </a>
                                <!--end::Logo-->

                            </div>
                            <!--begin::Text-->
                            <div class="d-flex  justify-content-between text-sm-start fw-semibold fs-7 text-muted">
                                <div class="d-flex flex-column">
                                    <span class="fs-5 text-gray-900">{{$proposal->vendor->vendor_name}}</span>
                                    <span class="fs-7 text-gray-700">{{$proposal->vendor->address}},
                                        {{$proposal->vendor->city}},{{$proposal->vendor->states ? $proposal->vendor->states[0]['name'] : ''}}-{{$proposal->vendor->postcode}}
                                        <br>{{$proposal->vendor->email}} | {{$proposal->vendor->phone}}
                                        <br>GSTIN : {{$proposal->vendor->gst}} | PAN NO:
                                        {{$proposal->vendor->pan}}</span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-muted">Date</span>
                                    <span
                                        class="fs-5 text-gray-700">{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>

                                    @if($proposal->file_path)

                                    <div class="symbol symbol-20px mt-5">
                                        <img alt="Icon" src="{{ url('/') }}/assets/media/svg/files/pdf.svg">
                                        <a href="{{ Storage::url($proposal->file_path) }}" target="_blank"
                                            class="fw-semibold ms-2">
                                            <u>Reference Document</u>
                                        </a>
                                    </div>

                                    @endif
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
                                        <span class="fs-6 text-gray-700 fw-bold txt-uppercase">Scope &
                                            Services</span>
                                        <div class="m-5"> {!! $proposal->proposal_description !!}
                                        </div>
                                    </div>

                                </div>
                                <!--end::Billing & shipping-->
                                <!--begin:Order summary-->
                                <div class="d-flex justify-content-between flex-column">
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-9">
                                        <span class="fs-6 text-gray-700 fw-bold txt-uppercase">Cost & Payments</span>
                                        <div class="m-5">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                                        <th class="min-w-175px pb-2">Payment Schedule</th>
                                                        <!--<th class="min-w-70px text-start pb-2">Date</th>-->
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


                                                                <div class="ms-0">
                                                                    <div class="fw-bold">
                                                                        {{ $milestone->milestone_title }}
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <!--end::Product-->
                                                        <!--begin::Date-->
                                                        <!--<td class="text-start">
                                                            {{ \Carbon\Carbon::parse($milestone->milestone_date)->format('d-M-Y') }}
                                                        </td>-->
                                                        <!--end::SKU-->
                                                        <!--begin::SKU-->
                                                        <td class="text-end">&#x20b9;<span
                                                                class="total-cost-span">{{ $milestone->milestone_amount }}</span>
                                                        </td>
                                                        <!--end::SKU-->
                                                        <!--begin::Quantity-->
                                                        <td class="text-end">{{ $milestone->milestone_gst }}</td>
                                                        <!--end::Quantity-->
                                                        <!--begin::Total-->
                                                        <td class="text-end">
                                                            &#x20b9;<span
                                                                class="total-cost-span">{{ $milestone->milestone_total_amount }}</span>
                                                        </td>
                                                        <!--end::Total-->
                                                    </tr>

                                                    <!--end::Products-->

                                                    @endforeach

                                                    <!--begin::Grand total-->
                                                    <tr>
                                                        <td class="text-dark fw-bolder text-sm-start fs-2"> <span
                                                                class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2 txt-uppercase">Total
                                                                Cost :</span></td>
                                                        <td colspan="5" class="text-dark fw-bolder text-end fs-2 "
                                                            style="font-size:18px !important;">
                                                            <div>
                                                                <span
                                                                    class="fs-2 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                                                <span id="total-cost-span"
                                                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                                                                    data-kt-element="sub-total">{{$proposal->proposal_total_cost}}</span>

                                                                <div class="text-muted fs-5 text-gray-600">Rupees
                                                                    {{$amounwords}}
                                                                    rupees only.</div>
                                                            </div>
                                                        </td>
                                                    </tr>



                                                </tbody>
                                            </table>
                                        </div>
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
@section('pageScripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
function approve(proid, status) {
        var title = 'Approve Proposal';
        var text =
            "Select Programme and approve proposal. Once the approval process is completed, the RO will be generated and sent to the vendor's registered email address.";

        // Create custom select dropdown
        var content = document.createElement('div');

        // Add the RO# input field and label
        var inputContainer = document.createElement('div');
        inputContainer.className = 'col-lg-12 fv-row d-flex mt-10';

        var inputLabel = document.createElement('label');
        inputLabel.className = 'col-form-label required fw-semibold fs-6 w-175px';
        inputLabel.textContent = 'RO. Number : ';
        inputLabel.style.textAlign = 'left'; // Align label content to the left

        var inputField = document.createElement('input');
        inputField.type = 'text';
        inputField.name = 'ro_number';
        inputField.className = 'form-control form-control-lg ';
        inputField.placeholder = 'RO. Number';
        inputField.value = '';

        // Append the label and input field to the container
        inputContainer.appendChild(inputLabel);
        inputContainer.appendChild(inputField);

        // Add the inputContainer to the content
        content.appendChild(inputContainer);



        // Create custom select dropdown
        var selectBox = document.createElement('select');
        selectBox.id = 'programSelect';
        selectBox.className = 'form-control form-control-lg';
        selectBox.innerHTML = `<option value="">-- Select Programme --</option>`;
        content.appendChild(selectBox);

        var errorSpan = document.createElement('span');
        errorSpan.id = 'programError';
        errorSpan.className = 'badge badge-light-danger fs-6 py-3';
        errorSpan.style.display = 'none';
        errorSpan.textContent = 'Select Programme.';
        content.appendChild(errorSpan);

        // Show the SweetAlert
        swal({
                title: title,
                text: text,
                icon: false,
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: false,
                        visible: true,
                        className: "btn btn-light",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Approve",
                        value: true,
                        visible: true,
                        className: "btn btn-success",
                        closeModal: false
                    }
                },
                dangerMode: true,
                content: content,
                closeOnConfirm: false
            })
            .then((willApprove) => {
                if (willApprove) {
                    var selectedProgram = selectBox.value;
                    var ro_number = inputField.value;
                    if (selectedProgram === "") {
                        errorSpan.style.display = 'block';
                        return;
                    } else {
                        errorSpan.style.display = 'none';
                    }

                    $.ajax({
                        url: "{{ route('lead.approve') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: proid,
                            status: status,
                            program: selectedProgram,
                            ro_number: ro_number
                        },
                        beforeSend: function() {
                            $('.swal-modal').css('opacity', 0);
                            document.getElementById('loaderOverlay').style.display = 'flex';
                        },
                        success: function(response) {
                            document.getElementById('loaderOverlay').style.display = 'none';
                            $('.swal-modal').css('opacity', 1);
                            if (response.success) {
                                swal(response.success, {
                                    icon: "success",
                                    buttons: false,
                                });
                                setTimeout(() => {
                                    //location.reload();
                                    window.location.href = '/lead';
                                }, 1000);
                            } else {
                                swal(response.error || 'Something went wrong.', {
                                    icon: "warning",
                                    buttons: false,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr) {
                            document.getElementById('loaderOverlay').style.display = 'none';
                            swal('Error: Something went wrong.', {
                                icon: "error",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });

        // Set a delay to ensure the SweetAlert modal content is loaded before accessing the Approve button
        setTimeout(function() {
            var approveButton = document.querySelector('.swal-button--confirm');
            approveButton.disabled = true; // Disable initially

            // Toggle "Approve" button based on selection
            selectBox.addEventListener('change', function() {
                approveButton.disabled = (selectBox.value === "");
            });
        }, 200);

        // Fetch programs dynamically
        $.ajax({
            url: "{{ route('getPrograms') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Received data:', data);
                data.forEach(function(program) {
                    var option = document.createElement('option');
                    option.value = program.id;
                    option.text = program.stream_name;
                    selectBox.appendChild(option);
                });
            },
            error: function(xhr) {
                console.error('Error fetching programs:', xhr);
                swal('Error fetching programs.', {
                    icon: "error",
                });
            }
        });

        $.ajax({
            url: "{{ route('getNextRoNumber') }}", // Define this route in your backend
            type: 'GET',
            success: function(data) {
                inputField.value = data.next_ro; // Set the RO number
            },
            error: function(xhr) {
                console.error('Error fetching RO number:', xhr);
                
            }
        });
   
}
</script>


<script>
$(document).ready(function() {

    setCurrencyFormattingHTML('#total-cost-span');




});
</script>
@endsection