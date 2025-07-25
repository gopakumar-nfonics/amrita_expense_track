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
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center py-3">
                                    <label for="start-date" class="me-1 w-24px text-dark fw-bold fs-7">
                                        <i class="fa-solid fa-filter me-1 text-dark fs-8 fw-bold"></i>

                                    </label>
                                </div>


                                <div class="d-flex align-items-center me-6 ms-3">
                                    <label for="category" class="me-1 w-75px text-muted fs-7 me-4">
                                        Programme
                                    </label>
                                    <select class="form-select form-select-solid fw-bold  p-2 px-4  fs-7" name="stream"
                                        id="stream">
                                        <option value="">Select Programme </option>
                                        @foreach($streams as $stream)
                                        <option value="{{ $stream->id }}" @if(old('stream')==$stream->id) selected
                                            @endif>{{ $stream->stream_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex align-items-center me-6 ms-3">
                                    <label for="financial_year" class="me-1 w-100px text-muted fs-7 me-0">
                                        Year
                                    </label>
                                    <select class="form-select form-select-solid fw-bold p-2 px-4 fs-7"
                                        id="financial_year" name="financial_year">
                                        @foreach ($financialYears as $year)
                                        <option value="{{ $year->id }}" @if (old('financial_year')==$year->id) selected
                                            @endif>
                                            {{ $year->year }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <!-- Right Side (Download Button) -->
                            <div class="d-flex ms-auto">
                                <a href="{{ route('reports.programmedataexport') }}" class="btn btn-sm btn-success">
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
                                    <!-- <th class="text-end">DOP</th> -->
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
    function loadData() {
        $('#categorytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('reports.programmedata') }}", // The route to your server-side code
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.programme_id = $('#stream').val(); // Send selected program ID as a parameter
                    d.financial_year = $('#financial_year').val();
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {

                        return '<span style="width:30px;">' + (meta.row + 1) +
                            '</span>';
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
                // {
                //     data: 'categories', // Use categories to calculate total expense
                //     render: function(data) {
                //         return Array.isArray(data) && data.length > 0 ?
                //             data.map(category =>
                //                 '<p class="sub-expense-disp fs-7 fw-bold  ls-n1 text-end"><span class="total-cost-span">' +
                //                 category
                //                 .dop +
                //                 '</span></p>')
                //             .join(' ') : '';
                //     }
                // },
                {
                    data: 'categories', // Use categories to calculate total expense
                    render: function(data) {
                        return Array.isArray(data) && data.length > 0 ?
                            data.map(category =>
                                '<p class="sub-expense-disp fs-7 fw-bold ls-n1 text-end">&#x20b9;<span class="total-cost-span">' +
                                number_format_indian_js(category.total_expense) +
                                // Invoke number_format_indian here
                                '</span></p>')
                            .join(' ') : '';
                    }
                },
                {
                    data: 'total_program_expense', // Total expense for program
                    name: 'total_program_expense',
                    className: 'text-end pe-5',
                    render: function(data) {
                        return '<span class="fs-5 fw-bold  ls-n1 text-end me-3">&#x20b9;' +
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
            lengthChange: true,
            ordering: false,
            searching: false
        });
    }

    loadData(); // Initial load

    // Event listener for the vendor select and date inputs
    $('#stream, #financial_year').on('change', function() {
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

function number_format_indian_js(num, decimals = 2, decimalSeparator = ".", thousandsSeparator = ",") {
    // Check if the number is negative
    const negative = num < 0 ? "-" : "";

    // Remove the negative sign for formatting
    num = Math.abs(num);

    // Split the number into integer and decimal parts
    let parts = num.toFixed(decimals).split(".");
    let integerPart = parts[0];
    let decimalPart = parts[1] ? parts[1] : "";

    // Format the integer part for Indian numbering system
    let lastThree = integerPart.slice(-3); // Extract the last three digits
    let remaining = integerPart.slice(0, -3); // Extract the remaining part

    // Add thousands separator in Indian format
    if (remaining.length > 0) {
        remaining = remaining.replace(/\B(?=(\d{2})+(?!\d))/g, thousandsSeparator);
        integerPart = remaining + thousandsSeparator + lastThree;
    } else {
        integerPart = lastThree;
    }

    // Combine integer part and decimal part
    let result = negative + integerPart;
    if (decimals > 0) {
        result += decimalSeparator + decimalPart;
    }

    return result;
}
</script>


@endsection