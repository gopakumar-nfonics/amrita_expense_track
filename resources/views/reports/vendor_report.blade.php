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

                <a href="" class="btn btn-sm btn-primary">
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

                        <div class="filter-section mb-5 d-flex justify-content-between border-bottom py-5">
                            <!-- Left Side (Filter) -->
                            <div class="d-flex flex-wrap">
                                <div class="d-flex align-items-center me-3">
                                    <label for="start-date" class="me-0 w-175px">
                                        <i class="fa-solid fa-filter me-1 text-dark fs-8"></i> Filter by Date Period :
                                    </label>
                                </div>
                                <div class="d-flex align-items-center me-3">
                                    <input class="form-control p-2 me-2 fs-7" placeholder="Start Date" type="text">
                                </div>
                                <div class="d-flex align-items-center me-3">
                                    <input class="form-control p-2 fs-7" placeholder="End Date" type="text">
                                </div>
                            </div>

                            <!-- Right Side (Download Button) -->
                            <div class="d-flex flex-wrap ms-auto">
                                <a href="{{ route('reports.exportcatreport') }}" class="btn btn-sm btn-success">
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
                                    <th>Proposal</th>
                                    <th>RO#</th>
                                    <th class="pe-5">Invoice</th>
                                    <th>Invoice #</th>
                                    <th>Payment Date</th>
                                    <th class="text-end pe-5">Amount</th>
                                    <th class="text-end pe-5">Total</th>
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

    $('#categorytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('reports.vendordata') }}",
            type: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}"; // Include CSRF token
            }
        },
        columns: [{
                data: null,
                render: function(data, type, row, meta) {
                    // Only increment serial number if this is a new vendor
                    if (row.vendor_name !== currentVendor) {
                        currentVendor = row.vendor_name; // Update current vendor
                        vendorSerial++; // Increment vendor serial
                        return vendorSerial; // Return the serial number
                    }
                    return ''; // Return empty for subsequent rows
                }
            },
            {
                data: 'vendor_name',
                name: 'vendor_name',
                render: function(data, type, row, meta) {
                    // Always display vendor name
                    return data; // Display vendor name
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    // Show proposal titles for each proposal
                    return row.proposals.map(proposal =>
                        `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp ">${proposal.proposal_title}</p>`
                    ).join('');
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    // Show RO# for each proposal
                    return row.proposals.map(proposal =>
                        `<p class="allocated fs-7 fw-bold text-gray-800 py-2 sub-cat-disp ">${proposal.proposal_ro}</p>`
                    ).join('');
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    // Show milestone names for each proposal
                    return row.proposals.flatMap(proposal =>
                        proposal.milestones.map(milestone =>
                            `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp ">${milestone.milestone_name}</p>`
                        )
                    ).join('');
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    // Show invoice IDs for each proposal
                    return row.proposals.flatMap(proposal =>
                        proposal.milestones.map(milestone =>
                            `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp ">${milestone.invoice_id}</p>`
                        )
                    ).join('');
                }
            },
            {
                data: null,
                render: function(data, type, row, meta) {
                    // Show payment dates for each proposal
                    return row.proposals.flatMap(proposal =>
                        proposal.milestones.map(milestone =>
                            `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp ">${milestone.transaction_date || 'N/A'}</p>`
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
                    return row.proposals.map(proposal =>
                        `<p class="allocated fs-7 text-gray-800 py-2 sub-cat-disp fw-bold ls-n1 text-end">&#x20b9;${proposal.total_milestone_amount}</p>`
                    ).join('');
                }
            },
        ],
        order: [
            [1, 'asc'] // Sort by vendor name
        ],
        pageLength: 10,
        lengthChange: false,
        ordering: false,
        searching: false
    });


});
</script>



@endsection