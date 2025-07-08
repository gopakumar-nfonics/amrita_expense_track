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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Travel
                    Expense
                    Reports | Staff
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
                                        Staff
                                    </label>
                                    <select class="form-select form-select-solid fw-bold  p-2 px-4  fs-7" name="staff"
                                        id="staff">
                                        <option value="">Select Staff </option>
                                        @foreach($staff as $stf)
                                        <option value="{{ $stf->id }}" @if(old('staff')==$stf->id) selected
                                            @endif>{{ $stf->name }}</option>
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
                                <a href="{{ route('reports.staffdataexport') }}" class="btn btn-sm btn-success">
                                    <i class="fa-solid fa-download"></i> Download Report
                                </a>
                            </div>
                        </div>


                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 report-table"
                            id="categorytable">
                            <!--begin::Table head-->

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
                url: "{{ route('reports.staffdata') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.financial_year = $('#financial_year').val();
                    d.staff = $('#staff').val();
                }
            },
            columns: [{
                    data: 'serial',
                    title: "#"
                },
                {
                    data: 'name',
                    title: "Staff"
                },
                {
                    data: 'trip',
                    title: "Trip Details"
                },
                {
                    data: 'dateperiod',
                    title: "Date Period"
                },
                {
                    data: 'expense',
                    title: "Expense",
                    render: function(data, type, row) {
                        return `<p class="sub-expense-disp fs-7 fw-bold ls-n1 text-end">&#x20b9;<span class="total-cost-span">${data}</span></p>`;
                    }
                },
                {
                    data: 'paid',
                    title: "Paid",
                    render: function(data, type, row) {
                        return `<p class="sub-expense-disp fs-7 fw-bold ls-n1 text-end">&#x20b9;<span class="total-cost-span">${data}</span></p>`;
                    }
                },
                {
                    data: 'balance',
                    title: "Balance",
                    render: function(data, type, row) {
                        return `<p class="sub-expense-disp fs-7 fw-bold ls-n1 text-end">&#x20b9;<span class="total-cost-span">${data}</span></p>`;
                    },

                }
            ],
            rowCallback: function(row, data, index) {
                if (data.rowspan > 0) {
                    $('td:eq(0)', row).attr('rowspan', data.rowspan);
                    $('td:eq(1)', row).attr('rowspan', data.rowspan);
                } else {
                    $('td:eq(0)', row).remove();
                    $('td:eq(0)', row)
                        .remove(); // second remove: previous td[1] shifted to td[0]
                }
            }
        });

    }

    loadData(); // Initial load

    // Event listener for the vendor select and date inputs
    $('#staff, #financial_year').on('change', function() {
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