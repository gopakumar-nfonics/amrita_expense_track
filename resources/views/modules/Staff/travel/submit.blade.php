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
                            Submit Expense
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

                                    <form id="kt_invoice_form" method="POST"
                                        action="{{ route('travel.expense.store', $expense->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row mb-6">


                                            <div class="col-lg-6">
                                                <label class="required form-label">
                                                    Title
                                                </label>
                                                <input type="text" name="title"
                                                    class="form-control form-control-solid form-control-lg mb-3 mb-lg-0 @error('title') is-invalid @enderror"
                                                    placeholder="Title" value="{{ old('title', $expense->title) }}"
                                                    readonly />
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-3">
                                                <label class="required form-label">
                                                    From Date
                                                </label>
                                                <input type="date" name="from_date" id="from_date"
                                                    class="form-control form-control-solid @error('from_date') is-invalid @enderror "
                                                    value="{{ old('from_date', \Carbon\Carbon::parse($expense->from_date)->format('Y-m-d')) }}"
                                                    readonly>
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
                                                    value="{{ old('to_date', \Carbon\Carbon::parse($expense->to_date)->format('Y-m-d')) }}"
                                                    readonly>
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
                                                    class="form-select form-select-solid @error('source_city') is-invalid @enderror"
                                                    disabled>
                                                    <option value="">--Select City--</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ old('source_city', $expense->source_city) == $city->id ? 'selected' : '' }}>
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
                                                    class="form-select form-select-solid @error('destination_city') is-invalid @enderror"
                                                    disabled>
                                                    <option value="">--Select City--</option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ old('destination_city', $expense->destination_city) == $city->id ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('destination_city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end border-top pb-3"></div>

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
                                                        placeholder="" value="{{ old('allowance_amount', $daAmount) }}"
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
                                                        placeholder=""
                                                        value="{{ old('accommodation_amount', $accAmount) }}" readonly />
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
                                                        value="{{ old('advance_amount', $expense->advance_amount) }}"
                                                        readonly />
                                                </div>
                                                @error('advance_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="table-responsive mb-10 col-lg-12">
                                                <div class="min-h-300px me-10 mt-5">
                                                    <label class="form-label color-blue">
                                                        Travel Expense
                                                    </label>

                                                    <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700"
                                                        data-kt-element="items">
                                                        <thead>
                                                            <tr
                                                                class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                                <th class="min-w-150px w-150px">
                                                                    Head
                                                                </th>
                                                                <th class="min-w-150px w-150px">
                                                                    Expenditure
                                                                </th>
                                                                <th class="min-w-150px w-150px">
                                                                    Amount
                                                                </th>
                                                                <th class="min-w-150px w-150px">
                                                                    Upload File
                                                                </th>
                                                                <th class="min-w-50px w-50px text-end">
                                                                    Remove
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody data-kt-element="item-template">
                                                            <tr class="border-bottom border-bottom-dashed"
                                                                data-kt-element="item">
                                                                <td class="">
                                                                    <select name="direction[]" data-kt-element="direction"
                                                                        class="form-select form-select-solid @error('direction.*') is-invalid @enderror">
                                                                        <option value="">--Select--</option>
                                                                    </select>
                                                                    @error('direction.*')
                                                                        <div class="invalid-feedback">
                                                                            Head is required.
                                                                        </div>
                                                                    @enderror
                                                                </td>

                                                                <td>
                                                                    <select name="travel_modes[]"
                                                                        data-kt-element="travel-mode"
                                                                        class="form-select form-select-solid @error('travel_modes.*') is-invalid @enderror">
                                                                        <option value="">--Select--</option>
                                                                        @foreach ($travelModes as $mode)
                                                                            <option value="{{ $mode->id }}"
                                                                                {{ old('travel_modes') == $mode->id ? 'selected' : '' }}>
                                                                                {{ ($mode->parent ? $mode->parent->name . ' : ' : '') . $mode->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <!-- JS will inject the additional input here -->

                                                                    {{-- @error('travel_modes.*')
                                                                    <div class="invalid-feedback">
                                                                        Expenditure is required.
                                                                    </div>
                                                                @enderror --}}
                                                                </td>

                                                                <td class="">
                                                                    <input
                                                                        class="form-control form-control-solid @error('fare.*') is-invalid @enderror"
                                                                        type="decimal" name="fare[]"
                                                                        data-kt-element="fare" placeholder="Amount">
                                                                    {{-- @error('fare.*')
                                                                    <div class="invalid-feedback">
                                                                        Amount is required.
                                                                    </div>
                                                                @enderror --}}
                                                                </td>

                                                                <td>
                                                                    <label
                                                                        class="btn btn-sm btn-info px-2 py-1 upload-label w-100px">
                                                                        <span class="svg-icon svg-icon-2 mx-0">
                                                                            <i class="fa-solid fa-upload"></i>
                                                                        </span>
                                                                        Upload
                                                                    </label>
                                                                    <input type="file" name="file[]"
                                                                        class="file-input d-none @error('file.*') is-invalid @enderror" />

                                                                    @error('file.*')
                                                                        <div class="invalid-feedback d-block">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                    <div class="text-muted fs-7 mt-1 text-truncate file-name"
                                                                        style="max-width: 100px; overflow: hidden; white-space: nowrap;">
                                                                        Document..
                                                                    </div>
                                                                </td>

                                                                <td class="pt-5 text-end">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-icon btn-active-color-primary"
                                                                        data-kt-element="remove-item">
                                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                                        <span class="svg-icon svg-icon-3">
                                                                            <svg width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                    fill="currentColor"></path>
                                                                                <path opacity="0.5"
                                                                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                    fill="currentColor"></path>
                                                                                <path opacity="0.5"
                                                                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                    fill="currentColor"></path>
                                                                            </svg>
                                                                        </span>
                                                                        <!--end::Svg Icon-->
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                        <tfoot>
                                                            <tr
                                                                class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                                <th class="text-primary">
                                                                    <button
                                                                        class="btn btn-sm btn-success w-150px mt-0 mb-1"
                                                                        data-kt-element="add-item">
                                                                        Add Expense
                                                                    </button>
                                                                </th>
                                                                <th colspan="4"
                                                                    class="border-bottom border-bottom-dashed ps-0">
                                                                    <div class="d-flex flex-column align-items-end">
                                                                        <div>
                                                                            <span
                                                                                class="fs-2 fw-semibold text-gray-500 align-self-start me-1">
                                                                                &#x20b9;
                                                                            </span>
                                                                            <span
                                                                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                                                                                data-kt-element="sub-total">
                                                                                0.00
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </th>

                                                            </tr>

                                                        </tfoot>
                                                        <!--end::Table foot-->
                                                    </table>
                                                    <span class="invalid-feedback" id="error-message"></span>

                                                </div>
                                                <!--end::Order details-->
                                                <div class="d-flex justify-content-end border-top mt-0 pt-5">

                                                </div>
                                            </div>
                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
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
                text: "Do you really want to submit this Expense?",
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
            dateFormat: "Y-m-d",
            clickOpens: false,
        });

        flatpickr("#to_date", {
            dateFormat: "Y-m-d",
            clickOpens: false,
        });
    </script>
@endsection
