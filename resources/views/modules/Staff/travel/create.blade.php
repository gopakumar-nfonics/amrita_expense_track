@extends('modules.Staff.layouts.staff')

@section('content')
    <style>
        table tr:first-child td:nth-child(5) button {
            display: none;
        }

        .read-only {
            background-color: #f5f5f5 !important;
            color: #777 !important;
            cursor: not-allowed !important;
        }
    </style>

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main" data-select2-id="select2-data-kt_app_main">
        <div class="d-flex flex-column flex-column-fluid" data-select2-id="select2-data-122-9irx">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Submit Advance Request
                        </h1>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('travel.index') }}" class="btn btn-sm btn-primary">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                            <div class="card">
                                <div class="card-body p-12">
                                    <div class="overlay" id="loaderOverlay">
                                        <div class="loader"></div>
                                    </div>

                                    <form id="kt_invoice_form" method="POST" action="{{ route('travel.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row mb-6">


                                            <div class="col-lg-6">
                                                <label class="required form-label">
                                                    Title
                                                </label>
                                                <input type="text" name="title"
                                                    class="form-control form-control-solid form-control-lg mb-3 mb-lg-0 @error('title') is-invalid @enderror"
                                                    placeholder="Title" value="{{ old('title') }}" />
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3">
                                                <label class="required form-label">
                                                    From Date
                                                </label>
                                                <input type="date" name="from_date" id="from_date"
                                                    class="form-control form-control-solid @error('from_date') is-invalid @enderror"
                                                    value="{{ old('from_date') }}">
                                                @error('from_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="required form-label">
                                                    To Date
                                                </label>
                                                <input type="date" name="to_date" id="to_date"
                                                    class="form-control form-control-solid @error('to_date') is-invalid @enderror"
                                                    value="{{ old('to_date') }}">
                                                @error('to_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Second Row: City and Amount -->
                                        <div class="row gx-10 mb-5">
                                            <div class="col-lg-6">
                                                <label class="required form-label">
                                                    Source City
                                                </label>
                                                <select name="source_city" id="source_city"
                                                    class="form-select form-select-solid @error('source_city') is-invalid @enderror">
                                                    <option value="">--Select City--</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ old('source_city') == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('source_city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="required form-label">
                                                    Destination City
                                                </label>
                                                <select name="destination_city" id="destination_city"
                                                    class="form-select form-select-solid @error('destination_city') is-invalid @enderror">
                                                    <option value="">--Select City--</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ old('destination_city') == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('destination_city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end border-top py-5"></div>

                                        <div class="row gx-10 mb-5">
                                            <div class="col-lg-4">
                                                <label class="form-label">
                                                    DA Amount
                                                    <span class="days-count color-blue" style="font-size:13px;"></span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        &#8377;
                                                    </span>
                                                    <input type="number" name="allowance_amount"
                                                        class=" read-only form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('allowance_amount') is-invalid @enderror"
                                                        placeholder="DA Amount" value="{{ old('allowance_amount') }}"
                                                        readonly />
                                                </div>
                                                @error('allowance_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">
                                                    Accommodation Amount
                                                    <span class="days-count color-blue" style="font-size:13px;"></span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        &#8377;
                                                    </span>
                                                    <input type="number" name="accommodation_amount"
                                                        class=" read-only form-control form-control-lg form-control-solid @error('accommodation_amount') is-invalid @enderror"
                                                        placeholder="Accommodation Amount"
                                                        value="{{ old('accommodation_amount') }}" readonly />
                                                </div>
                                                @error('accommodation_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="required form-label">
                                                    Advance Amount
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        &#8377;
                                                    </span>
                                                    <input type="text" name="advance_amount" id="advance_amount"
                                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('advance_amount') is-invalid @enderror"
                                                        placeholder="Advance Amount"
                                                        value="{{ old('advance_amount') }}" />
                                                </div>
                                                @error('advance_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end pt-10">
                                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                                    Submit
                                                </button>
                                            </div>
                                    </form>

                                    <!--end::Form-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageScripts')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/custom/apps/expense/create.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        let perDayAllowance = 0;
        let perDayAccommodation = 0;

        function calculateAmounts() {
            const fromDate = new Date($('#from_date').val());
            const toDate = new Date($('#to_date').val());

            if (!isNaN(fromDate) && !isNaN(toDate) && toDate >= fromDate) {
                const totalDays = Math.floor((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;

                if (totalDays > 0) {
                    const totalAllowance = perDayAllowance * totalDays;
                    const totalAccommodation = perDayAccommodation * totalDays;

                    $('[name="allowance_amount"]').val(totalAllowance);
                    $('[name="accommodation_amount"]').val(totalAccommodation);

                    $('.days-count').text(`[${totalDays} Day${totalDays !== 1 ? 's' : ''}]`);
                } else {
                    // Clear if total days is zero
                    $('[name="allowance_amount"]').val('');
                    $('[name="accommodation_amount"]').val('');
                    $('.days-count').text('');
                }

            } else {
                // Clear if dates are invalid
                $('[name="allowance_amount"]').val('');
                $('[name="accommodation_amount"]').val('');
                $('.days-count').text('');
            }
        }

        function fetchAllowance() {
            const cityId = $('#destination_city').val();
            console.log("Sending city_id to backend:", cityId);
            if (!cityId) return;

            $.ajax({
                url: "{{ route('travel.getAllowance') }}",
                type: 'GET',
                data: {
                    city_id: cityId
                },
                dataType: 'json',
                success: function(response) {
                    console.log("Response received:", response);
                    perDayAllowance = parseFloat(response.allowance_amount) || 0;
                    perDayAccommodation = parseFloat(response.accommodation_amount) || 0;

                    calculateAmounts(); // re-calculate with updated values
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch allowance data:', error);
                    perDayAllowance = 0;
                    perDayAccommodation = 0;
                    calculateAmounts();
                }
            });
        }

        $(document).ready(function() {
            $('#from_date, #to_date').on('change', function() {
                calculateAmounts();
            });

            $('#destination_city').on('change', function() {
                fetchAllowance();
            });

            // Optionally trigger calculation if fields are pre-filled
            if ($('#from_date').val() && $('#to_date').val()) {
                calculateAmounts();
            }
        });
    </script>

    <script>
        const form = document.getElementById('kt_invoice_form');
        const submitBtn = document.getElementById('submitBtn');

        const requiredFields = [
            'title',
            'from_date',
            'to_date',
            'source_city',
            'destination_city',
            'allowance_amount',
            'accommodation_amount',
            'advance_amount'
        ];

        function validateFormFields() {
            let allFilled = true;
            for (let name of requiredFields) {
                const field = form.querySelector(`[name="${name}"]`);
                if (!field || !field.value.trim()) {
                    allFilled = false;
                    break;
                }
            }
            submitBtn.disabled = !allFilled;
        }

        // Attach input event listeners
        form.addEventListener('input', validateFormFields);

        // Initial check (in case some fields are pre-filled)
        window.addEventListener('DOMContentLoaded', validateFormFields);
    </script>


    <script>
        document.getElementById('kt_invoice_form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Show the SweetAlert confirmation dialog
            swal({
                title: "Are you sure?",
                text: "Do you really want to submit this Advance Request?",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Submit",
                        value: true,
                        visible: true,
                        closeModal: true
                    }
                },
                dangerMode: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    document.getElementById('loaderOverlay').style.display = 'flex';
                    this.submit();
                }
            });
        });
    </script>
    <script>
        flatpickr("#from_date", {
            defaultDate: new Date(),
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "Y-m-d"
        });

        flatpickr("#to_date", {
            defaultDate: new Date(),
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "Y-m-d"
        });
    </script>
    <script>
        function formatIndianNumber(value) {
            value = value.replace(/,/g, ''); // remove commas

            if (!/^\d+$/.test(value)) return ''; // only allow whole numbers

            const lastThree = value.slice(-3);
            const otherNumbers = value.slice(0, -3);

            let formatted = '';
            if (otherNumbers !== '') {
                formatted = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + lastThree;
            } else {
                formatted = lastThree;
            }

            return formatted;
        }

        const input = document.getElementById('advance_amount');

        input.addEventListener('input', function(e) {
            let caret = input.selectionStart;
            const originalLength = input.value.length;

            input.value = formatIndianNumber(input.value);

            const newLength = input.value.length;
            input.setSelectionRange(caret + (newLength - originalLength), caret + (newLength - originalLength));
        });

        // Remove commas before form submission
        document.getElementById('kt_invoice_form').addEventListener('submit', function() {
            input.value = input.value.replace(/,/g, '');
        });
    </script>
@endsection
