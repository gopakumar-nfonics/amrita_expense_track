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
                    Expense Report</h1>
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
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 report-table"
                            id="categorytable">
                            <!--begin::Table head-->
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th class="text-end">Allocated</th>
                                    <th>Sub-Category</th>
                                    <th class="text-end pe-5">Expense</th>
                                    <th class="text-end">Total Expense</th>
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
                _token: "{{ csrf_token() }}"
            },
        },
        columns: [{
                data: null,
                name: 'row_number',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row + 1; // Display row number
                }
            },
            {
                data: 'category',
                name: 'category',
                render: function(data) {
                    return '<p class="allocated fs-5 fw-bold text-gray-800 py-2">' +
                        data + '</p>';
                }
            },
            {
                data: 'allocated',
                name: 'allocated',
                render: function(data) {
                    return '<p class="allocated fs-5 fw-bold text-gray-800 me-5 lh-1 ls-n1 text-end"> &#x20b9;' +
                        data + '</p>';
                }
            },
            {
                data: 'sub_categories',
                name: 'sub_categories',
                render: function(data) {
                    return Array.isArray(data) && data.length > 0 ?
                        data.map(sub => '<p class="sub-cat-disp fs-6">' + sub.name +
                            '</p>')
                        .join(' ') : '-';
                }
            },
            {
                data: 'sub_categories',
                name: 'sub_expenses',
                render: function(data) {
                    return Array.isArray(data) && data.length > 0 ?
                        data.map(sub => '<p class="sub-expense-disp fs-6  text-end">&#x20b9;' +
                            sub
                            .expense +
                            '</p>').join('') : '-';
                }
            },
            {
                data: 'total_expense',
                name: 'total_expense',
                render: function(data) {
                    return '<p class="allocated fs-5 fw-bold text-gray-800 me-5 lh-1 ls-n1  text-end"> &#x20b9;' +
                        data + '</p>';
                }
            },
            {
                data: 'balance',
                name: 'balance',
                render: function(data) {
                    return '<p class="allocated fs-5 fw-bold text-gray-800 me-5 lh-1 ls-n1  text-end"> &#x20b9;' +
                        data + '</p>';
                }
            }
        ],
        order: [
            [1, 'asc']
        ], // Set initial order by the 'category' column
        pageLength: 10, // Set default page length if needed
        lengthMenu: [10, 25, 50, 100] // Customize length menu
    });
});
</script>



@endsection