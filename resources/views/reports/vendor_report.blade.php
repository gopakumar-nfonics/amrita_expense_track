@extends('layouts.admin')

@section('content')
<style>
.sub-cat-disp {
    min-height: 40px;
}
</style>
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Payment
                    Reports | Vendor
                    Wise </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <!-- <ul class="breadcrumb fw-semibold fs-7 my-0 pt-1">
											
										</ul> -->
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Button-->
            <div class="card-toolbar">

                <a href="javascript:history.back()" class="btn btn-sm btn-primary">
                    Back
                </a>
            </div>
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

                        <div
                            class="filter-section mb-5 d-flex justify-content-between align-items-center border-bottom py-5">
                            <!-- Left Side (Filter) -->
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center py-3">
                                    <label for="start-date" class="me-1 w-24px text-dark fw-bold fs-7">
                                        <i class="fa-solid fa-filter me-1 text-dark fs-8 fw-bold"></i>

                                    </label>
                                </div>


                                <div class="d-flex align-items-center me-6 ms-3">
                                    <label for="category" class="me-1 w-75px text-muted fs-7 me-0">
                                        Vendor
                                    </label>
                                    <select class="form-select form-select-solid fw-bold  p-2 px-4  fs-7" name="vendor"
                                        id="vendor">
                                        <option value="">Select Vendor </option>
                                        @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" @if(old('vendor')==$vendor->id) selected
                                            @endif>{{ $vendor->vendor_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-center ms-2">
                                    <label for="start-date" class="me-3 w-75px text-muted fs-7">
                                        Date Period
                                    </label>
                                    <div class="position-relative d-flex align-items-center">
                                        <!--begin::Icon-->
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Icon-->
                                        <!--begin::Datepicker-->
                                        <input
                                            class="form-control form-control-solid p-2 px-4 ps-12 flatpickr-input w-150px  fs-7"
                                            placeholder="Start Date" name="start_date" id="start_date" type="text">
                                        <!--end::Datepicker-->
                                    </div>
                                    <div class="position-relative d-flex align-items-center ms-3">
                                        <!--begin::Icon-->
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Icon-->
                                        <!--begin::Datepicker-->
                                        <input
                                            class="form-control form-control-solid p-2 px-4 ps-12 flatpickr-input w-150px fs-7"
                                            placeholder="End Date" id="end_date" name="end_date" type="text">
                                        <!--end::Datepicker-->
                                    </div>
                                </div>

                            </div>

                            <!-- Right Side (Download Button) -->
                            <div class="d-flex ms-auto">
                                <a href="{{ route('reports.vendordataexport') }}" class="btn btn-sm btn-success">
                                    <i class="fa-solid fa-download"></i> Download Report
                                </a>
                            </div>
                        </div>


                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 report-table"
                            id="categorytable">
                            <!--begin::Table head-->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor</th>
                                    <th>RO#</th>
                                    <th class="pe-5">Invoice #</th>
                                    <th class="pe-5">DOP</th>
                                    <th class="text-end pe-5">Amount</th>
                                    <th class="text-end pe-5">Total</th>
                                    <th class="text-end pe-5">Balance Payable</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>



                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
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
    let currentVendor = ''; // Track the current vendor name
    let vendorSerial = 0; // Serial number for vendors

    function loadData() {
        $('#categorytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('reports.vendordata') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}"; // Include CSRF token
                    d.vendor = $('#vendor').val(); // Send selected vendor
                    d.start_date = $('#start_date').val(); // Send selected start date
                    d.end_date = $('#end_date').val(); // Send selected end date
                },
                dataSrc: function(json) {
                console.log("Data Only:", json.data); // Logs just the data array
                return json.data; // Important to return it for DataTables to work
            }
            },
            preDrawCallback: function(settings) {
                currentVendor = ''; // Reset vendor tracking
                vendorSerial = 0; // Reset serial number
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        // Only increment serial number if this is a new vendor
                        if (row.vendor_name !== currentVendor) {
                            currentVendor = row.vendor_name; // Update current vendor
                            vendorSerial++; // Increment vendor serial
                            // return vendorSerial; // Return the serial number
                            return '<span style="width:30px;">' + vendorSerial +
                                '</span>';
                        }
                        return ''; // Return empty for subsequent rows
                    }
                },
                {
                    data: 'vendor_name',
                    name: 'vendor_name',
                    render: function(data, type, row, meta) {
                        // return data; // Display vendor name
                        return '<span class="fs-6 fw-bold ">' + data + '</span>';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        // Show proposal titles for each proposal
                        return row.proposals.map(proposal => {
                            let milestoneCount = proposal.milestones.length;
                            return `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp " style="min-height:${40*milestoneCount}px;padding-top:${(40*milestoneCount/2)-10}px !important;">${proposal.proposal_ro}</p>`;
                        }).join('');
                    }
                },

                {
                    data: null,
                    render: function(data, type, row, meta) {
                        // Show milestone names for each proposal
                        return row.proposals.flatMap(proposal =>
                            proposal.milestones.map(milestone =>
                                `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp">${milestone.invoice_id}</p>`
                            )
                        ).join('');
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        // Show milestone amounts for each proposal
                        return row.proposals.flatMap(proposal =>
                            proposal.milestones.map(milestone =>
                                `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp">${milestone.transaction_date}</p>`
                            )
                        ).join('');
                    }
                },

                {
                    data: null,
                    render: function(data, type, row, meta) {
                        // Show milestone amounts for each proposal
                        return row.proposals.flatMap(proposal =>
                            proposal.milestones.map(milestone =>
                                `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp fw-bold ls-n1 text-end">&#x20b9;${milestone.milestone_amount}</p>`
                            )
                        ).join('');
                    }
                },

                {
                    data: null,
                    render: function(data, type, row, meta) {
                        // Show total milestone amount for each proposal
                        // return row.proposals.map(proposal =>
                        //     `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp fw-bold ls-n1 text-end">&#x20b9;${proposal.total_milestone_amount}</p>`
                        // ).join('');
                        return row.proposals.map(proposal => {
                            let milestoneCount = proposal.milestones.length;
                            return `<p class="allocated fs-5 text-gray-800 py-2 sub-cat-disp fw-bold ls-n1 text-end"" style="min-height:${40*milestoneCount}px;padding-top:${(40*milestoneCount/2)-10}px !important;">&#x20b9;${proposal.total_milestone_amount}</p>`;
                        }).join('');
                    }
                },
                {
                    data: 'balance_payable',
                    name: 'balance_payable',
                    render: function(data, type, row, meta) {
                        
                        return '<p class="fs-5 text-gray-800 p-2 fw-bold ls-n1 text-end sub-cat-disp">'
                            + '&#8377;' + data + '</p>';
                    }
                },
            ],
            order: [],
            pageLength: 10,
            lengthChange: true,
            ordering: false,
            searching: false
        });
    }

    loadData(); // Initial load

    // Event listener for the vendor select and date inputs
    $('#vendor, #start_date, #end_date').on('change', function() {
        $('#categorytable').DataTable().destroy(); // Destroy the old table instance
        loadData(); // Load the table again with the new filters
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate the date one month before today
        const today = new Date();
        const oneMonthAgo = new Date();
        oneMonthAgo.setMonth(today.getMonth() - 1);

        // Initialize flatpickr on start_date with default date as one month ago
        flatpickr("#start_date", {
            defaultDate: oneMonthAgo, // Sets the default date to one month ago
            dateFormat: "d-m-Y",
            placeholder: "Select date",
            maxDate: today, // Ensures the start date cannot be after today
            onChange: function(selectedDates) {
                const endPicker = document.querySelector("#end_date")._flatpickr;
                // Update the minimum date for end_date based on start_date selection
                endPicker.set('minDate', selectedDates[0]);
            }
        });

        // Initialize flatpickr on end_date with default date as today
        flatpickr("#end_date", {
            defaultDate: today, // Sets the default date to today
            dateFormat: "d-m-Y",
            placeholder: "Select date",
            minDate: oneMonthAgo, // Ensures the end date cannot be before one month ago
            maxDate: today, // Ensures the end date cannot be after today
            onChange: function(selectedDates) {
                const startPicker = document.querySelector("#start_date")._flatpickr;
                // Update the maximum date for start_date based on end_date selection
                startPicker.set('maxDate', selectedDates[0]);
            }
        });
    });
</script>

@endsection