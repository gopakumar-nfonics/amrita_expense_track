@extends('layouts.admin')
<style>
.swal-modal {
    min-width: 600px;
    padding: 40px 20px;

}

select#programSelect {
    margin: 30px auto 15px;
    cursor: pointer;
}
</style>

@if(!Auth::user()->isvendor())
<style>
#budgettable_wrapper .dataTables_filter {
    display: flex;
    align-items: center;
    justify-content: end;
}
</style>
@endif

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Proposal
                    Listing</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <!-- <ul class="breadcrumb fw-semibold fs-7 my-0 pt-1">
											
										</ul> -->
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Button-->
            @if (Auth::user()->isvendor())
            <div class="card-toolbar">
                <a href="{{ route('lead.create') }}" class="btn btn-sm btn-primary">
                    Create Proposal
                </a>
            </div>
            @endif
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
                        @if(!Auth::user()->isvendor())
                        <select id="programmeFilter" class="form-select" style="width: 200px;">
                            <option value="">All Programmes</option>
                            @foreach($programmes as $programme)
                            <option value="{{ $programme->stream_name }}">{{ $programme->stream_name }}</option>
                            @endforeach
                        </select>
                        @endif
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
                                    <th class="min-w-200px">Proposal Title</th>
                                    <th class="min-w-100px">RO #</th>
                                    @if(!Auth::user()->isvendor())
                                    <th class="min-w-200px">Vendor</th>
                                    @endif
                                    <th class="min-w-150px">Proposal Year</th>
                                    <th class="min-w-150px">Cost</th>
                                    <th class="min-w-150px text-center">Actions</th>
                                    <th style="display:none">Programme</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>

                                @forelse($proposal as $key => $pro)

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                {{$pro->proposal_id}}
                                                <div class="text-gray-400 fw-semibold fs-9">
                                                    @if($pro->proposal_status == 0)
                                                    <span class="badge badge-light-info fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i
                                                                class="fa-regular fa-circle-dot color-blue fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Pending Review
                                                    </span>
                                                    @elseif($pro->proposal_status == 2)
                                                    <span class="badge badge-light-danger fs-8 rejected-span"
                                                        title="View Comments"
                                                        onclick="rejectionreason('{{$pro->id}}');">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

                                                        <!--end::Svg Icon-->
                                                        <i class="fa-solid fa-close color-red fs-8 me-2 "></i>Rejected

                                                    </span>
                                                    <span class="badge badge-light-info fs-8 rejected-span"
                                                        title="View Comments"
                                                        onclick="rejectionreason('{{$pro->id}}');">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

                                                        <!--end::Svg Icon-->
                                                        <i class="fa-regular fa-comments color-blue fs-8 me-2 "></i>

                                                    </span>

                                                    @else
                                                    <span class="badge badge-light-success fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i class="fa-solid fa-check light-green fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Approved
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    <td>
                                        <div class="d-flex align-items-center">

                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('lead.show', encrypt($pro->id)) }}"
                                                    class="text-dark fw-bold text-hover-primary fs-6  txt-capitalcase">{{$pro->proposal_title}}</a>
                                                <span
                                                    class="d-flex justify-content-start text-muted fw-semibold text-muted d-block fs-8">Submitted
                                                    On :
                                                    {{ \Carbon\Carbon::parse($pro->created_at)->format('d-M-Y') }}

                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($pro->proposalro)
                                        <div class="d-flex align-items-center">

                                            <div class="d-flex justify-content-start flex-column">
                                                @php
                                                $releaseorder = 'RO_' . $pro->proposalro->proposal_ro.'.pdf';
                                                $releaseorderPath = 'release_orders/' . $releaseorder;
                                                $releaseorderUrl = asset('storage/' . $releaseorderPath);
                                                @endphp
                                                <a href="{{ $releaseorderUrl }}" target="_blank"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{$pro->proposalro->proposal_ro}}</a>
                                                <span class="text-muted fw-semibold text-muted d-block fs-8">Issued On :
                                                    {{ \Carbon\Carbon::parse($pro->proposalro->created_at)->format('d-M-Y') }}</span>
                                            </div>
                                        </div>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @if(!Auth::user()->isvendor())
                                    <td>
                                        <div class="d-flex align-items-center">

                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('vendor.show',$pro->vendor->id) }}"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{$pro->vendor->vendor_name}}
                                                </a>
                                                <span class="text-muted fw-semibold text-muted d-block fs-8">
                                                    <i
                                                        class="fa-regular fa-envelope fs-8 me-1"></i>{{$pro->vendor->email}}</span>

                                            </div>
                                        </div>
                                    </td>
                                    @endif

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{ $pro->financialYear?->year ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span
                                                    class="fs-2 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                <span
                                                    class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$pro->proposal_total_cost}}</span>
                                            </div>
                                        </div>
                                    </td>



                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <i class="fa-solid fa-angle-down"></i></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                            data-kt-menu="true">



                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('lead.show', encrypt($pro->id)) }}"
                                                    class="menu-link px-3">View
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            @if(!Auth::user()->isvendor() && $pro->proposal_status ==0)
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0)" onclick="approve('{{$pro->id}}','approve')"
                                                    class="menu-link px-3">Approve</a>
                                            </div>
                                            @endif
                                            @if(!Auth::user()->isvendor() && $pro->proposal_status ==0)
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0)"
                                                    onclick="rejectpropposal('{{$pro->id}}','rejected')"
                                                    class="menu-link px-3">Reject</a>
                                            </div>
                                            @endif
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <!--begin::Menu item-->
                                            @if(Auth::user()->isvendor() && ($pro->proposal_status ==2 &&
                                            $pro->is_resubmit != 1))
                                            <div class="menu-item px-3">
                                                <a href="{{ route('lead.resubmit',$pro->id) }}"
                                                    class="menu-link px-3">Resubmit</a>
                                            </div>
                                            @endif
                                            @if(Auth::user()->isvendor())
                                            <div class="menu-item px-3">
                                                <a href="{{ route('lead.edit',$pro->id) }}"
                                                    class="menu-link px-3">Edit</a>
                                            </div>
                                            @endif
                                            <!--end::Menu item-->
                                            <!--end::Menu item-->

                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                    <td style="display:none">{{$pro->programme->stream_name ?? ''}}</td>
                                </tr>
                                @if($pro->rejection_reason)
                                <!--<tr>
                                
                                  <td colspan="6"><div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6">
                               
                                <div class="d-flex flex-stack flex-grow-1">
                                  
                                    <div class="fw-semibold">
                                        <h4 class="text-gray-900 fw-bold">Reason For Rejection</h4>
                                        <div class="fs-6 text-gray-700">{{$pro->rejection_reason}}
                                        </div>
                                    </div>
                                   
                                </div>
                              
                            </div></td>
                                                        </tr>-->
                                @endif
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
                    <div class="modal fade" id="rejectproposal" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2>Reject Proposal</h2>
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
                                <div class="modal-body scroll-y">
                                    <!--begin::Form-->
                                    <form id="rejectproposal-form"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#"
                                        method="POST">
                                        <!--begin::Input group-->
                                        <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                                <span class="required">Rejection Comments</span>

                                            </label>
                                            <!--end::Label-->
                                            <input type="hidden" name="proposalid" id="proposalid" value="">
                                            <textarea name="reason" id="reason" class="form-control form-control-solid"
                                                rows="5"></textarea>
                                            <div class="fv-plugins-message-container invalid-feedback"
                                                id="reason-error"></div>
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Actions-->
                                        <div class="text-end pt-1 pb-3">

                                            <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary">
                                                <span class="indicator-label">Reject Proposal</span>
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

                    <div class="modal fade" id="rejectreason" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header pt-5 pb-4">
                                    <!--begin::Modal title-->
                                    <h2>Rejection Comments</h2>
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
                                <div class="modal-body scroll-y">
                                    <!--begin::Form-->

                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                        <div
                                            class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6">
                                            <span id="reasoncmt"></span>
                                        </div>


                                    </div>
                                    <!--end::Input group-->



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
    var table = $('#budgettable').DataTable({
        "iDisplayLength": 10,
        "ordering": false,
        "searching": true,
        "columnDefs": [{
            "targets": -1, // last column
            "visible": false,
            "searchable": true
        }]
    });

    $('#programmeFilter').appendTo('#budgettable_wrapper .dataTables_filter').css({
        'margin-left': '20px',
        'width': '200px',
        'height': '45px'
    });

    $('#programmeFilter').on('change', function() {
        var selectedProgramme = $(this).val();

        if (selectedProgramme) {
            table.column(-1).search('^' + selectedProgramme + '$', true, false).draw();
        } else {
            table.column(-1).search('').draw();
        }
    });
});
</script>

<script>
function rejectpropposal(proid, status) {

    $('#rejectproposal').modal('show');
    $('#proposalid').val(proid);
}

$(document).ready(function() {

    $('#reason').on('keyup', function() {
        if ($(this).val().trim() !== '') {
            $('#reason-error').text('');
        }
    });

    $('#rejectproposal-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        let reason = $('#reason').val();

        // Check if reason is empty
        if (!reason.trim()) {
            $('#reason-error').text('Rejection reason required.');
            return;
        } else {
            $('#reason-error').text('');
        }

        let formData = {
            _token: '{{ csrf_token() }}',
            reason: reason,
            proid: $('#proposalid').val(),
        };

        document.getElementById('loaderOverlay').style.display = 'flex';

        $.ajax({
            url: "{{ route('lead.reject') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                document.getElementById('loaderOverlay').style.display = 'none';
                if (response.success) {
                    swal('The Proposal has been rejected!', {
                        icon: "success",
                        buttons: false,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    swal('Failed to reject proposal', {
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
                    icon: "error",
                    buttons: false,
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
    });
});


function approve(proid, status) {
    if (status === 'approve') {
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
                                    location.reload();
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
    } else {
        swal('Invalid status', {
            icon: "error"
        });
    }
}





function rejectionreason(proid) {

    $.ajax({
        url: '/lead/rejectionreason/' +
            proid, // The URL to send the AJAX request to
        type: 'GET',
        dataType: 'json',
        success: function(data) {


            $('#reasoncmt').text(data.reason);

            $('#rejectreason').modal('show');


        },

        error: function(xhr, status, error) {
            console.error(xhr.responseText); // Log errors to console
        }
    });
    //$('#rejectreason').modal('show');
}
</script>

@endsection