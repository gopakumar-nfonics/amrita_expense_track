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
                    Reports | Programme
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
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="d-flex align-items-center me-3 py-3">
                                    <label for="start-date" class="me-1 w-100px text-dark fw-bold fs-7">
                                        <i class="fa-solid fa-filter me-1 text-dark fs-8 fw-bold"></i> Filter By :

                                    </label>
                                </div>


                                <div class="d-flex align-items-center me-6 ms-3">
                                    <label for="category" class="me-1 w-75px text-muted fs-7 me-4">
                                        Programme
                                    </label>
                                    <select class="form-select form-select-solid fw-bold  p-2 px-4  fs-7">
                                        <option value="">Select Programme </option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center ms-20">
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
                                            placeholder="Start Date" name="due_date" type="text">
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
                                            placeholder="End Date" name="due_date" type="text">
                                        <!--end::Datepicker-->
                                    </div>
                                </div>

                            </div>

                            <!-- Right Side (Download Button) -->
                            <div class="d-flex ms-auto">
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
                                    <th>Programme</th>
                                    <th>Category</th>
                                    <th class="text-end">Expense</th>
                                    <th class="text-end pe-5">Total Expense</th>

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
            url: "{{ route('reports.programmedata') }}", // The route to your server-side code
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
            },
        },
        columns: [{
                data: null,
                render: function(data, type, row, meta) {

                    return '<p style="width:30px;">' + (meta.row + 1) +
                        '</p>';
                }
            }, // Row number
            {
                data: 'stream_name',
                name: 'stream_name',
                render: function(data, type, row, meta) {
                    // return data; // Display vendor name
                    return '<span class="fs-6 fw-bold m-0 p-0">' + data + '</span>';
                }
            }, // Program name
            {


                data: 'categories',
                name: 'sub_categories',
                render: function(data) {
                    return Array.isArray(data) && data.length > 0 ?
                        data.map(category => '<p class="sub-cat-disp fs-7">' + category
                            .category_name +
                            '</p>')
                        .join(' ') : '<p class="sub-cat-disp fs-7">NIL</p>';
                }




            },
            {
                data: 'categories', // Use categories to calculate total expense
                render: function(data) {
                    return Array.isArray(data) && data.length > 0 ?
                        data.map(category =>
                            '<p class="sub-expense-disp fs-7 fw-bold lh-1 ls-n1 text-end">&#x20b9;' +
                            category
                            .total_expense +
                            '</p>')
                        .join(' ') : '';
                }
            },
            {
                data: 'total_program_expense', // Total expense for program
                name: 'total_program_expense',
                className: 'text-end pe-5',
                render: function(data) {
                    return '<span class="fs-5 fw-bold lh-1 ls-n1 text-end me-3">&#x20b9;' +
                        data + '</span>';
                }
            },
        ],
        columnDefs: [{
                orderable: false,
                targets: 2
            } // Make the categories column not orderable
        ],

        rowId: function(row) {
            return row.stream_name; // Assign a unique identifier for each row
        },
        pageLength: 10,
        lengthChange: false,
        ordering: false,
        searching: false
    });
});
</script>







@endsection