@extends('layouts.admin')

@section('content')
<style>
    table tr:first-child td:nth-child(5) button {
        display: none;
    }
</style>
<div class="app-main flex-column flex-row-fluid" id="kt_app_main" data-select2-id="select2-data-kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid" data-select2-id="select2-data-122-9irx">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Edit Non-Invoice Payment
                    </h1>
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-12">
                                <div class="overlay" id="loaderOverlay">
                                    <div class="loader"></div>
                                </div>
                                <!--begin::Form-->
                                <form id="kt_invoice_form" method="POST" action="{{route('noninvoicepayment.update', $noninvoicepayments->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <!--begin::Wrapper-->
                                    <div class="mb-0">
                                        <!--begin::Row-->
                                        <div class="row gx-10 mb-5">
                                            <div class="row pe-0 pb-5">
                                                <div class="col-lg-12">
                                                    <div class="fv-row  d-flex justify-content-start gap-10">
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-4">
                                                            <label class="required form-label">Title</label>
                                                            <input 
                                                              id=""
                                                              name="title"
                                                              placeholder="Title"
                                                              class="form-control mb-2 @error('title') is-invalid @enderror"
                                                              value="{{ old('title', $noninvoicepayments->title) }}"
                                                            />
                                                            @error('title')
                                                            <div class="invalid-feedback">{{ $message }}</div> 
                                                            @enderror
                                                        </div>

                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-3">
                                                            <label class="form-label required">Category</label>
                                                            <select
                                                              class="form-select mb-2 @error('category') is-invalid @enderror"
                                                              data-control="select2"
                                                              data-hide-search="true"
                                                              data-placeholder="Select Category" name="category"
                                                              id="category" 
                                                              onchange="getallocatedbudget()"
                                                            > 
                                                                <option></option>
                                                                @foreach ($main_categories as $main_category)
                                                                @if ($main_category->children->isNotEmpty())
                                                                <optgroup label="{{ $main_category->category_name }}">
                                                                    @foreach ($main_category->children as $subcategory)
                                                                    <option class="sub-category"
                                                                        value="{{ $subcategory->id }}"
                                                                        @if(old('category', $noninvoicepayments->category_id) ==$subcategory->id) selected
                                                                        @endif>
                                                                        {{ $subcategory->category_name }}
                                                                    </option>
                                                                    @endforeach
                                                                </optgroup>
                                                                @else
                                                                <!-- Print the main category as a standalone option if no children exist -->
                                                                <option 
                                                                    class="main-category"
                                                                    value="{{ $main_category->id }}"
                                                                    @if(old('category', $noninvoicepayments->category_id)==$main_category->id) selected
                                                                    @endif
                                                                >
                                                                    {{ $main_category->category_name }}
                                                                </option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                            @error('category')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-3">
                                                            <label class="form-label required">Program</label>
                                                            <select 
                                                              name="program"
                                                              class="form-select @error('program') is-invalid @enderror"
                                                            >
                                                                <option value="">Select Program</option>
                                                                @foreach($streams as $stream)
                                                                <option 
                                                                    value="{{ $stream->id }}"
                                                                    @if(old('program', $noninvoicepayments->stream_id) == $stream->id) selected @endif
                                                                >
                                                                    {{ $stream->stream_name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('program')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pe-0 pb-5">
                                                <div class="col-lg-12">
                                                    <div class="fv-row  d-flex justify-content-start gap-10">
                                                        
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-4">
                                                            <label class="form-label required">Year</label>
                                                            <select
                                                              name="year" 
                                                              id="year" 
                                                              class="form-select @error('year') is-invalid @enderror"
                                                              onchange="getallocatedbudget(document.getElementById('category'))"
                                                            >
                                                                <option value="">Select Year</option>
                                                                @foreach($financialyears as $year)
                                                                <option value="{{ $year->id }}" {{ old('year', $noninvoicepayments->financial_year_id) == $year->id ? 'selected' : '' }}>
                                                                    {{ $year->year }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('year')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-3">
                                                            <label class="form-label required">Date</label>
                                                            <input 
                                                              id="noninvoice_date" 
                                                              name="noninvoice_date"
                                                              placeholder=""
                                                              class="form-control mb-2  @error('noninvoice_date') is-invalid @enderror"
                                                              value="{{ old('noninvoice_date', $noninvoicepayments->transaction_date) }}"
                                                            />
                                                            @error('noninvoice_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-3">
                                                            <label class="required form-label">Amount</label>
                                                            
                                                            <input 
                                                              id="noninvoice_amount" 
                                                              name="amount" 
                                                              placeholder="Amount"
                                                              class="form-control mb-2 @error('amount') is-invalid @enderror"
                                                              value="{{ old('amount', $noninvoicepayments->amount) }}" />
                                                            @error('amount')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!--end::Row-->
                                            <div class="row pe-0 pb-5">
                                                <div class="col-lg-12">
                                                    <div class="fv-row  d-flex justify-content-start gap-10">
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-4">
                                                            <label class="form-label">UTR Number</label>
                                                            
                                                            <input 
                                                              id="" 
                                                              name="utr_number" 
                                                              placeholder="UTR Number"
                                                              class="form-control mb-2 @error('utr_number') is-invalid @enderror"
                                                              value="{{ old('utr_number', $noninvoicepayments->utr_number) }}" />
                                                            @error('utr_number')
                                                            <div class="invalid-feedback">{{ $message }}</div> 
                                                            @enderror
                                                        </div>
                                                        <div class="fs-6 fw-bold text-gray-700 col-lg-8">
                                                            <label class="form-label">Remarks</label>
                                                            <input
                                                              type="text"
                                                              name="remarks"
                                                              class="form-control form-control-lg @error('remarks') is-invalid @enderror" 
                                                              placeholder="Remarks" 
                                                              value="{{ old('remarks', $noninvoicepayments->remarks) }}"
                                                            />
																@error('remarks')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column pt-5" id="allocate_status" style="display:none !important;">
                                                        <div class="d-flex justify-content-between w-100 fs-7 fw-bold mb-3">
                                                            <span>Budget allocated for <span id="catname"></span></span>
                                                        </div>
                                                        <div class="h-8px bg-light rounded mb-3">
                                                            <div class="bg-success rounded h-8px" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="fw-semibold text-gray-600 fs-7 d-flex justify-content-between w-100">
                                                            <span class="color-blue"></span>
                                                            <span class="color-orange"></span>
                                                        </div>
                                                    </div>
                                                
                                                    <span class="invalid-feedback" id="error-balance"></span>
                                                    <input type="hidden" id="total_budget" value="">
                                                    <input type="hidden" id="used_budget" value="">

                                                    <div class="separator separator-solid mt-7 mb-2"></div>
                                                    <input type="hidden" id="noninvoicepayment_id" value="{{ $noninvoicepayments->id ?? '' }}">
                                                </div>
                                            </div>
                                            <!--begin::Table wrapper-->
                                            <div class="d-flex justify-content-end mt-0">
                                                <!--end::Order details-->
                                                <div class="d-flex justify-content-end py-6 px-9">
													<button type="submit" id="kt_ecommerce_edit_noninvoice_submit"
                                                class="btn btn-primary">
                                                <span class="indicator-label">
                                                    Save
                                                </span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
												</div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Wrapper-->

                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->

                    <!--end::Sidebar-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Content container-->
        </div>

    </div>

</div>
@endsection

@section('pageScripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#noninvoice_date", {
            // defaultDate: new Date(),
            dateFormat: "Y-m-d",
            placeholder: "Select date"
        });
    });
</script>

<script>

    let remainingBudget = 0;
    function getallocatedbudget() {
        const submitButton = document.querySelector("#kt_invoice_form").querySelector(
            '[id="kt_ecommerce_edit_noninvoice_submit"]'
        );
        submitButton.disabled = false;
        $('#error-balance').hide();
        $('#allocate_status').show();

        const selectElement = document.getElementById("category");
        const selectedOption = selectElement.options[selectElement.selectedIndex];

        // Find the optgroup (parent category)
        const optgroupElement = selectedOption.closest('optgroup');
        let parentCategoryName = optgroupElement ? optgroupElement.label : selectedOption.text;

        // Update the category name in the UI
        document.getElementById("catname").innerText = parentCategoryName;

        const categoryId = selectElement.value;
        const selectedYear = document.getElementById("year").value;
        const currentPaymentId = $('#noninvoicepayment_id').val();

        // AJAX request to get budget details
        $.ajax({
            url: '/get-budget-details',
            type: 'GET',
            data: {
                category_id: categoryId,
                proposal_year: selectedYear,
                exclude_payment_id: currentPaymentId 
            },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }

                // const totalBudget = response.total_budget;
                // const usedBudget = response.used_budget;

                const totalBudget = parseFloat(response.total_budget) || 0;
                const usedBudget = parseFloat(response.used_budget) || 0;

                $('#total_budget').val(totalBudget)
                $('#used_budget').val(usedBudget)

                // const formatedBudget = response.num_total_budget;
                // const formatedusedBudget = response.num_used_budget;

                const formatedBudget = totalBudget.toFixed(2);
                const formatedusedBudget = usedBudget.toFixed(2);

                // const usedPercentage = (usedBudget / totalBudget) * 100;
                // const remainingPercentage = 100 - usedPercentage;

                const usedPercentage = totalBudget > 0 ? (usedBudget / totalBudget) * 100 : 0;
                const remainingPercentage = totalBudget > 0 ? 100 - usedPercentage : 0;

                // Set global remaining budget
                remainingBudget = totalBudget - usedBudget;

                // Update progress bar
                // document.querySelector('#allocate_status .bg-success').style.width = `${usedPercentage}%`;
                document.querySelector('#allocate_status .bg-success').style.width = `${usedPercentage.toFixed(2)}%`;

                // Validate initially
                validateAmountAgainstBudget();

                // Update the UI
                document.querySelector('#allocate_status .color-blue').innerText =
                    `${remainingPercentage.toFixed(2)}% remaining`;
                document.querySelector('#allocate_status .color-orange').innerText =
                    `₹${formatedusedBudget.toLocaleString('en-IN')}  of  ₹${formatedBudget.toLocaleString('en-IN')} Used`;
            },
            error: function(xhr, status, error) {
                console.error('Error fetching budget details:', error);
            }
        });
    }

    function validateAmountAgainstBudget() {
        const noninvoiceAmount = parseFloat($('#noninvoice_amount').val());
        const submitButton = document.querySelector("#kt_invoice_form").querySelector(
            '[id="kt_ecommerce_edit_noninvoice_submit"]'
        );

        if (!isNaN(noninvoiceAmount) && noninvoiceAmount > remainingBudget) {
            submitButton.disabled = true;
            $('#error-balance').show().text(
                "The payment process cannot proceed as the entered amount exceeds the remaining available budget."
            );
        } else {
            submitButton.disabled = false;
            $('#error-balance').hide();
        }
    }

    // Attach input listener
    $(document).ready(function() {
        $('#noninvoice_amount').on('input', function() {
            validateAmountAgainstBudget();
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category');
        if (categorySelect && categorySelect.value) {
            // Trigger the budget-fetching function if a category is already selected
            getallocatedbudget();
        }
    });
</script>

@endsection
