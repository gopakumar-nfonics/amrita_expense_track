@extends('layouts.admin')

@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Expense Listing
                    </h1>
                </div>
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="userstable">
                                <thead>
                                    <tr class="fw-bold">
                                        <th class="w-50px">#</th>
                                        <th class="min-w-150px">Staff</th>
                                        <th class="min-w-200px">Trip Details</th>
                                        <th class="min-w-100px">Expense (&#x20b9;)</th>
                                        <th class="min-w-200px">Payments (&#x20b9;)</th>
                                        <th class="min-w-150px text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expenses as $key => $expense)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        {{ $key + 1 }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="d-flex justify-content-start flex-column text-dark fw-bold fs-6">
                                                        {{ $expense->staff->name }}
                                                        <span class="text-muted fw-semibold text-muted d-block fs-8">
                                                            <i
                                                                class="fa-regular fa-envelope fs-8 me-1"></i>{{ $expense->staff->email }}</span>

                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6 fw-bold ">
                                                        {{ ucfirst($expense->title) }}
                                                        <div class="text-gray-400 fw-semibold fs-9">

                                                            @php
                                                                $formattedStatus = ucwords(
                                                                    str_replace('_', ' ', $expense->status),
                                                                );

                                                                $badgeClass = in_array($expense->status, [
                                                                    'advance_requested',
                                                                    'expense_submitted',
                                                                ])
                                                                    ? 'badge-light-info'
                                                                    : (in_array($expense->status, [
                                                                        'advance_received',
                                                                        'expense_settled',
                                                                    ])
                                                                        ? 'badge-light-success'
                                                                        : 'badge-light-secondary'); // fallback for unknown statuses
                                                            @endphp


                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center">

                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href=""
                                                            class="text-dark fw-bold text-hover-primary fs-7  txt-capitalcase">{{ $expense->sourceCity->name ?? 'N/A' }}
                                                            -
                                                            {{ $expense->destinationCity->name ?? 'N/A' }}</a>
                                                        <span
                                                            class="d-flex justify-content-start text-muted fw-semibold text-muted d-block fs-8">Period
                                                            :
                                                            {{ \Carbon\Carbon::parse($expense->from_date)->format('d-M-Y') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($expense->to_date)->format('d-M-Y') }}

                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="badge {{ $badgeClass }} fs-8">
                                                    {{ $formattedStatus }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        {!! $expense->amount > 0
                                                            ? '<span class="fs-2 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span><span class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">' .
                                                                $expense->amount .
                                                                '</span>'
                                                            : 'NA' !!}
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6"><span class="w-100px">Advance
                                                            &nbsp;
                                                            &nbsp;:</span>
                                                        <span
                                                            class="fs-6 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-6 fw-bold text-gray-800 me-2 lh-1 ls-n2">
                                                            {{ $expense->advance_amount }}</span>
                                                    </div>

                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span class="w-100px">
                                                            Settlement :
                                                        </span>
                                                        <span
                                                            class="fs-6 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-6 fw-bold text-gray-800 me-2 lh-1 ls-n2">
                                                            {{ $expense->final_amount }}</span>
                                                    </div>
                                                </div>

                                                @php
                                                    $totalAmount = $expense->amount;
                                                    $paidAmount = $expense->advance_amount + $expense->final_amount;

                                                    $balanceAmount = $totalAmount - $paidAmount;

                                                    $paidPercentage =
                                                        $totalAmount > 0 ? ($paidAmount / $totalAmount) * 100 : 0;

                                                    // Format percentage nicely
                                                    if (floor($paidPercentage) == $paidPercentage) {
                                                        $paidPercentage = number_format($paidPercentage, 0);
                                                    } else {
                                                        $paidPercentage = number_format($paidPercentage, 2);
                                                    }
                                                    // Set progress bar classes
                                                    $progressBarClass = 'bg-warning'; // Default
                                                    $progressBarText = 'color-orange';

                                                    if ($paidPercentage >= 75) {
                                                        $progressBarClass = 'bg-success';
                                                        $progressBarText = 'color-green';
                                                    } elseif ($paidPercentage >= 25) {
                                                        $progressBarClass = 'bg-info';
                                                        $progressBarText = 'color-blue';
                                                    }
                                                @endphp


                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-0">
                                                        <span class=" {{ $progressBarText }}  me-2 fs-8 fw-bold">
                                                            {{ number_format((float) $paidPercentage, 2) }}%
                                                        </span>
                                                    </div>
                                                    <div class="progress h-3px w-100">
                                                        <div class="progress-bar {{ $progressBarClass }}"
                                                            role="progressbar"
                                                            style="width: {{ floor((float) $paidPercentage) }}%;"
                                                            aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    Actions <i class="fa-solid fa-angle-down"></i>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                                    data-kt-menu="true">
                                                    @if ($expense->status === 'advance_requested')
                                                        <div class="menu-item px-1">
                                                            <a href="#" class="menu-link px-1" data-bs-toggle="modal"
                                                                data-bs-target="#approveRequestModal"
                                                                onclick="setExpenseId({{ $expense->id }}, '{{ $expense->advance_amount ?? '' }}')">
                                                                Approve Advance
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <div class="menu-item px-1">
                                                        <a href="javascript:void(0)" onclick="" class="menu-link px-1"
                                                            data-kt-customer-table-filter="delete_row">
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Approve Advance --}}
                        <!-- Approve Request Modal -->
                        <div class="modal fade" id="approveRequestModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered w-100">
                                <div class="modal-content">
                                    <form id="approve_form" method="POST" action="{{ route('travel.approveadvance') }}">
                                        @csrf
                                        <input type="hidden" name="expense_id" id="modal_expense_id">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Approve Advance
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    X
                                                </button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label class="form-label required">Year</label>
                                                    <select class="form-select" name="year" id="year"
                                                        onchange="getallocatedbudget(document.getElementById('category'))">
                                                        <option value="">-- Select Year --</option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year->id }}">
                                                                {{ $year->year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label required">
                                                        Category
                                                    </label>
                                                    <select
                                                        class="form-select mb-2 @error('category') is-invalid @enderror"
                                                        data-control="select2" data-hide-search="true"
                                                        data-placeholder="Select Category" name="category" id="category"
                                                        onchange="getallocatedbudget()">
                                                        <option></option>
                                                        @foreach ($main_categories as $main_category)
                                                            @if ($main_category->children->isNotEmpty())
                                                                <optgroup label="{{ $main_category->category_name }}">
                                                                    @foreach ($main_category->children as $subcategory)
                                                                        <option class="sub-category"
                                                                            value="{{ $subcategory->id }}"
                                                                            @if (old('category') == $subcategory->id) selected @endif>
                                                                            {{ $subcategory->category_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @else
                                                                <!-- Print the main category as a standalone option if no children exist -->
                                                                <option class="main-category"
                                                                    value="{{ $main_category->id }}"
                                                                    @if (old('category') == $main_category->id) selected @endif>
                                                                    {{ $main_category->category_name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label required">
                                                        Programme
                                                    </label>
                                                    <select class="form-select" name="programme" required>
                                                        <option value="">-- Select Programme --</option>
                                                        @foreach ($programmes as $programme)
                                                            <option value="{{ $programme->id }}">
                                                                {{ $programme->stream_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>



                                                <div class="mb-3">
                                                    <label class="form-label required">
                                                        Approved Amount
                                                    </label>
                                                    <input type="number" name="approved_amount" id="approved_amount"
                                                        class="form-control">
                                                </div>

                                                <div class="d-flex flex-column pt-5" id="allocate_status"
                                                    style="display:none !important;">
                                                    <div class="d-flex justify-content-between w-100 fs-7 fw-bold mb-3">
                                                        <span>Budget allocated for <span id="catname"></span></span>

                                                    </div>
                                                    <div class="h-8px bg-light rounded mb-3">
                                                        <div class="bg-success rounded h-8px" role="progressbar"
                                                            style="width: 0%;" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                    <div
                                                        class="fw-semibold text-gray-600 fs-7 d-flex justify-content-between w-100">
                                                        <span class="color-blue"></span><span class="color-orange"></span>
                                                    </div>
                                                </div>
                                                <!--end::Description-->

                                                <span class="invalid-feedback" id="error-balance"></span>

                                                <input type="hidden" id="total_budget" value="">
                                                <input type="hidden" id="used_budget" value="">

                                                <div class="separator separator-solid mt-7 mb-2"></div>
                                            </div>

                                            <div class="modal-footer">
                                                {{-- <button type="submit" class="btn btn-primary" id="approve_submit">
                                                    Approve
                                                </button> --}}
                                                <button type="submit" class="btn btn-primary" id="approve_submit">
                                                    <span class="indicator-label">Approve</span>
                                                    <span class="indicator-progress" style="display: none;">
                                                        Please wait...
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>

                                            </div>
                                        </div>
                                    </form>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#userstable').DataTable({
                "iDisplayLength": 10,
                "searching": true,
                "recordsTotal": 3615,
                "pagingType": "full_numbers"
            });
        });
    </script>
    <script>
        function setExpenseId(id, advanceAmount) {
            document.getElementById('modal_expense_id').value = id;
            document.getElementById('approved_amount').value = parseFloat(advanceAmount) || '';
        }
    </script>


    <script>
        let remainingBudget = 0;

        function getallocatedbudget() {

            var submitButton = document.querySelector("#approve_form").querySelector(
                '[id="approve_submit"]');
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

            // AJAX request to get the budget details
            $.ajax({
                url: '/get-budget-details', // Replace with your actual endpoint
                type: 'GET',
                data: {
                    category_id: categoryId,
                    proposal_year: selectedYear,
                },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    const totalBudget = parseFloat(response.total_budget) || 0;
                    const usedBudget = parseFloat(response.used_budget) || 0;

                    $('#total_budget').val(totalBudget)
                    $('#used_budget').val(usedBudget)

                    const formatedBudget = totalBudget.toFixed(2);
                    const formatedusedBudget = usedBudget.toFixed(2);

                    // Calculate the percentage used and remaining
                    const usedPercentage = totalBudget > 0 ? (usedBudget / totalBudget) * 100 : 0;
                    const remainingPercentage = totalBudget > 0 ? 100 - usedPercentage : 0;

                    // Set global remaining budget
                    remainingBudget = totalBudget - usedBudget;

                    // Update progress bar
                    // document.querySelector('#allocate_status .bg-success').style.width = `${usedPercentage}%`;
                    document.querySelector('#allocate_status .bg-success').style.width =
                        `${usedPercentage.toFixed(2)}%`;

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
            const approved_amount = parseFloat($('#approved_amount').val());
            const submitButton = document.querySelector("#approve_form").querySelector(
                '[id="approve_submit"]'
            );

            if (!isNaN(approved_amount) && approved_amount > remainingBudget) {
                submitButton.disabled = true;
                $('#error-balance').show().text(
                    "The approval cannot proceed as the entered amount exceeds the remaining available budget."
                );
            } else {
                submitButton.disabled = false;
                $('#error-balance').hide();
            }
        }

        // Attach input listener
        $(document).ready(function() {
            $('#approved_amount').on('input', function() {
                validateAmountAgainstBudget();
            });
        });
    </script>
    <script>
        document.getElementById('approve_form').addEventListener('submit', function() {
            const submitBtn = document.getElementById('approve_submit');
            submitBtn.disabled = true;

            submitBtn.querySelector('.indicator-label').style.display = 'none';
            submitBtn.querySelector('.indicator-progress').style.display = 'inline-block';
        });
    </script>
@endsection
