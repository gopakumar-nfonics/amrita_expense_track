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
                                    <label for="category" class="me-1 w-100px text-muted fs-7 me-0">
                                        Category
                                    </label>
                                    <select class="form-select form-select-solid fw-bold  p-2 px-4  fs-7" id="category"
                                        name="category">
                                        <option value="">Select Category </option>
                                        @foreach($category as $cat)
                                        <option value="{{ $cat->id }}" @if(old('category')==$cat->id) selected
                                            @endif>{{ $cat->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex align-items-center me-6 ms-3">
                                    <label for="financial_year" class="me-1 w-200px text-muted fs-7 me-0">
                                        Financial Year
                                    </label>
                                    <select class="form-select form-select-solid fw-bold p-2 px-4 fs-7" id="financial_year" name="financial_year">
                                        @foreach($financialYears as $year)
                                            <option value="{{ $year->id }}" @if(old('financial_year') == $year->id) selected @endif>
                                                {{ $year->year }}
                                            </option>
                                        @endforeach
                                    </select>
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

    function loadData() {
        $('#categorytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('reports.reportdata') }}", // The route to your server-side code
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}"; // Include CSRF token
                    d.category = $('#category').val(); // Send selected vendor
                    d.financial_year = $('#financial_year').val(); // Send selected vendor
                    
                }
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
                        return '<p class="allocated fs-6 fw-bold text-gray-800 me-5 ls-n1 text-end"> &#x20b9;' +
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
                                '<p class="sub-expense-disp fs-7 fw-bold ls-n1 text-end">&#x20b9;' +
                                sub.expense + '</p>'
                            ).join('') : '<p class="sub-cat-disp fs-7 text-end">NIL</p>';
                    }
                },
                {
                    data: 'total_expense',
                    name: 'total_expense',
                    render: function(data) {
                        return '<p class="allocated fs-6 fw-bold text-gray-800 me-5 ls-n1  text-end"> &#x20b9;' +
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
                        var percentage = allocated > 0 ? ((balance / allocated) * 100).toFixed(
                                2) :
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

                        return '<p class="allocated fs-6 fw-bold text-gray-800 text-end  my-3"><span class=" me-5 lh-1 ls-n1 text-end "> &#x20b9;' +
                            data + // Display original balance value
                            '</span><br><span class="badge badge-sm ' + badgeClass +
                            ' align-self-center fs-8 px-0 me-5">' +
                            percentage + '%</span></p>';
                    }
                }
            ],
            order: [
                [1, 'asc']
            ], // Set initial order by the 'category' column
            pageLength: 10, // Set default page length if needed
            lengthChange: true, // Disable length menu
            ordering: false,
            searching: false // Disable the search box
        });
    }

    loadData(); // Initial load

    // Event listener for the category select and date inputs
    $('#category, #financial_year').on('change', function() {
        $('#categorytable').DataTable().destroy(); // Destroy the old table instance
        loadData(); // Load the table again with the new filters
    });

});
</script>

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#start_date", {
        defaultDate: new Date(), // Sets the default date to the current date
        dateFormat: "d-m-Y", // Use a standard format for backend compatibility
        placeholder: "Select date" // Placeholder text
    });
});

document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#end_date", {
        defaultDate: new Date(), // Sets the default date to the current date
        dateFormat: "d-m-Y", // Use a standard format for backend compatibility
        placeholder: "Select date" // Placeholder text
    });
});
</script> -->

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