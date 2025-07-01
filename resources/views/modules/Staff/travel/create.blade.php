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
                                                        placeholder="" value="{{ old('allowance_amount') }}" readonly />
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
                                                        placeholder="" value="{{ old('accommodation_amount') }}"
                                                        readonly />
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
                                                    <input type="number" name="advance_amount"
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
                                                <button type="submit" class="btn btn-primary">
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
        const perDayAllowance = {{ $allowance ? $allowance->allowance_amount : 0 }};
        const perDayAccommodation = {{ $allowance ? $allowance->accommodation_amount : 0 }};

        document.addEventListener('DOMContentLoaded', function() {
            const fromDateInput = document.querySelector('[name="from_date"]');
            const toDateInput = document.querySelector('[name="to_date"]');
            const allowanceInput = document.querySelector('[name="allowance_amount"]');
            const accommodationInput = document.querySelector('[name="accommodation_amount"]');

            const dayLabels = document.querySelectorAll('.days-count');

            function calculateAmounts() {
                const fromDate = new Date(fromDateInput.value);
                const toDate = new Date(toDateInput.value);

                if (fromDateInput.value && toDateInput.value && toDate >= fromDate) {
                    // Calculate full days difference
                    const timeDiff = toDate.getTime() - fromDate.getTime();
                    const totalDays = Math.floor(timeDiff / (1000 * 3600 * 24));

                    allowanceInput.value = perDayAllowance * totalDays;
                    accommodationInput.value = perDayAccommodation * totalDays;

                    dayLabels.forEach(label => {
                        label.innerText = `[${totalDays} Day${totalDays !== 1 ? 's' : ''}]`;
                    });

                } else {
                    allowanceInput.value = '';
                    accommodationInput.value = '';

                    dayLabels.forEach(label => {
                        label.innerText = '';
                    });
                }
            }

            fromDateInput.addEventListener('change', calculateAmounts);
            toDateInput.addEventListener('change', calculateAmounts);
        });
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
@endsection
