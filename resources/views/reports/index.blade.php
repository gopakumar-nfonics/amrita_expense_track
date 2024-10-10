@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Budget &
                    Usage Report</h1>
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
                                    <th>Category</th>
                                    <th class="text-end">Budget Allocated</th>
                                    <th>Sub-Category</th>
                                    <th class="text-end pe-5">Used Amount</th>
                                    <th class="text-end">Total Usage</th>
                                    <th class="text-end pe-5">Balance</th>
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
    $('#categorytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('reports.reportdata') }}", // The route to your server-side code
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
        },
        columns: [{
                data: null,
                name: 'row_number',
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Display row number
                }
            },
            {
                data: 'category',
                name: 'category',
                render: function(data) {
                    return '<p class="allocated fs-6 text-gray-800 py-2">' + data + '</p>';
                }
            },
            {
                data: 'allocated',
                name: 'allocated',
                render: function(data) {
                    return '<p class="allocated fs-6 fw-bold text-gray-800 me-5 lh-1 ls-n1 text-end"> &#x20b9;' +
                        data + '</p>';
                }
            },
            {
                data: 'sub_categories',
                name: 'sub_categories',
                render: function(data) {
                    return Array.isArray(data) && data.length > 0 ?
                        data.map(sub => '<p class="sub-cat-disp fs-7">' + sub.name + '</p>')
                        .join(' ') : '<p class="sub-cat-disp fs-7">NIL</p>';
                }
            },
            {
                data: 'sub_categories',
                name: 'sub_expenses',
                render: function(data) {
                    return Array.isArray(data) && data.length > 0 ?
                        data.map(sub =>
                            '<p class="sub-expense-disp fs-7 fw-bold lh-1 ls-n1 text-end">&#x20b9;' +
                            sub.expense + '</p>'
                        ).join('') : '<p class="sub-cat-disp fs-7 text-end">NIL</p>';
                }
            },
            {
                data: 'total_expense',
                name: 'total_expense',
                render: function(data) {
                    return '<p class="allocated fs-6 fw-bold text-gray-800 me-5 lh-1 ls-n1  text-end"> &#x20b9;' +
                        data + '</p>';
                }
            },
            {
                data: 'balance',
                name: 'balance',
                render: function(data, type, row) {
                    // Convert allocated to a number by removing currency symbol and commas
                    var allocatedStr = row.allocated; // Example: '10,000.00'
                    var allocated = parseFloat(allocatedStr.replace(/[^0-9.-]+/g,
                        "")); // Convert to number

                    // Convert balance to a number similarly
                    var balanceStr = data; // Assuming 'data' is in the same format
                    var balance = parseFloat(balanceStr.replace(/[^0-9.-]+/g,
                        "")); // Convert to number

                    // Calculate percentage
                    var percentage = allocated > 0 ? ((balance / allocated) * 100).toFixed(2) :
                        0;

                    // Determine badge class based on percentage
                    var badgeClass = 'badge-light-success'; // Default class
                    if (percentage < 25) {
                        badgeClass = 'badge-light-danger';
                    } else if (percentage < 50) {
                        badgeClass = 'badge-light-warning';
                    } else if (percentage < 75) {
                        badgeClass = 'badge-light-info';
                    }

                    return '<p class="allocated fs-6 fw-bold text-gray-800 me-5 lh-1 ls-n1 text-end my-3 "> &#x20b9;' +
                        data + // Display original balance value
                        '<br><span class="badge badge-sm ' + badgeClass +
                        ' align-self-center px-2">' +
                        percentage + '%</span></p>';
                }
            }
        ],
        order: [
            [1, 'asc']
        ], // Set initial order by the 'category' column
        pageLength: 10, // Set default page length if needed
        lengthChange: false, // Disable length menu
        searching: false // Disable the search box
    });
});
</script>




@endsection