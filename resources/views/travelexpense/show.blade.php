@extends('layouts.admin')

<style>
    .swal2-textarea {
        height: 6.75em;
        padding: .75em;
        margin: 10px 0px !important;
    }

    .swal2-popup .swal2-title {
        margin-bottom: 30px
    }

    .swal2-popup .swal2-input-label {
        text-align: left;
        display: block;
        width: 100%;
        margin-bottom: 0.5rem;
    }
</style>

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Travel Expense Details
                    </h1>
                </div>
                <!--end::Page title-->
                <div class="card-toolbar">
                    {{-- <button type="button" class="btn btn-sm btn-success me-5">
                        <i class="fa-solid fa-check "></i>
                        Approve Travel Expense
                    </button> --}}

                    <a href="{{ route('travelexpense.index') }}" class="btn btn-sm btn-primary">
                        Back to List
                    </a>

                </div>
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!-- begin::Invoice 3-->
                <div class="card">
                    <!-- begin::Body-->
                    <div class="card-body py-20">

                        <div class="overlay" id="loaderOverlay">
                            <div class="loader"></div>
                        </div>
                        <!-- begin::Wrapper-->
                        <div class="mw-lg-950px mx-auto w-100" id="printableArea">
                            <!-- begin::Header-->
                            <div class="flex-sm-row mb-2">
                                <!--end::Logo-->

                                <!--begin::Text-->
                                <div class="d-flex  justify-content-between text-sm-start fw-semibold fs-7 text-muted">
                                    <div class="d-flex flex-column">
                                        <span class="d-block w-100 fs-3 ms-sm-auto color-blue txt-uppercase">
                                            {{ ucfirst($expense->title) }}
                                        </span>
                                        <span>
                                            @php
                                                $formattedStatus = ucwords(str_replace('_', ' ', $expense->status));

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
                                                        : ($expense->status === 'rejected'
                                                            ? 'badge-light-danger'
                                                            : 'badge-light-secondary')); // fallback for unknown statuses
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-8 mb-0">
                                                {{ $formattedStatus }}
                                            </span>
                                        </span>
                                        <span class="fs-5 text-gray-900">
                                            {{ $expense->staff->name }} | {{ $expense->staff->email }}
                                        </span>
                                        <span class="fs-7 text-gray-700">
                                            Trip : {{ $expense->sourceCity->name ?? 'N/A' }} -
                                            {{ $expense->destinationCity->name ?? 'N/A' }}
                                            <br>
                                            Period : {{ \Carbon\Carbon::parse($expense->from_date)->format('d-M-Y') }} -
                                            {{ \Carbon\Carbon::parse($expense->to_date)->format('d-M-Y') }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        @if ($expense->status === 'expense_submitted')
                                            <span class="d-block color-blue  fs-6 ms-0 mb-3">
                                                Settlement Date : <input
                                                    class="form-control d-inline p-2 px-4  flatpickr-input w-150px  fs-7"
                                                    placeholder="Date" name="settlement_date" id="start_date"
                                                    type="text">
                                            </span>
                                        @endif
                                        <span class="text-muted">Category :
                                            <span class="fs-6 text-gray-700">
                                                {{ $expense->category->category_name ?? 'N/A' }}
                                            </span>
                                        </span>
                                        <span class="text-muted">Programme :
                                            <span class="fs-6 text-gray-700">
                                                {{ $expense->stream->stream_name ?? 'N/A' }}
                                            </span>
                                        </span>
                                        <span class="text-muted">Associated With :
                                            <span class="fs-6 text-gray-700">
                                                {{ $expense->associated ?? 'N/A' }}
                                            </span>
                                        </span>
                                        @if ($expense->advancepayment_date)
                                            <span class="text-muted">Advance Date :
                                                <span class="fs-6 text-gray-700">
                                                    {{ \Carbon\Carbon::parse($expense->advancepayment_date)->format('d-M-Y') }}
                                                </span>
                                            </span>
                                        @endif
                                        @if ($expense->settlement_date)
                                            <span class="text-muted">Settlement Date :
                                                <span class="fs-6 text-gray-700">
                                                    {{ \Carbon\Carbon::parse($expense->settlement_date)->format('d-M-Y') }}
                                                </span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="pb-12">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column gap-7 gap-md-10">
                                    <div class="separator"></div>
                                    <!--begin:Order summary-->
                                    <div class="d-flex justify-content-between flex-column">
                                        <!--begin::Table-->
                                        <div class="table-responsive border-bottom mb-9">
                                            <span class="fs-6 text-gray-700 fw-bold txt-uppercase">
                                                Travel Expense
                                            </span>
                                            <div class="m-5">
                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                    <thead>
                                                        <tr class="border-bottom fs-6 fw-bold text-muted">
                                                            <th class="min-w-150px pb-2">
                                                                Head
                                                            </th>
                                                            <th class="min-w-150px pb-2">
                                                                Expenditure
                                                            </th>
                                                            <th class="min-w-150px pb-2">
                                                                Amount
                                                            </th>
                                                            <th class="min-w-150px pb-2">
                                                                Reference Document
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fw-semibold text-gray-600">
                                                        @foreach ($expense->details as $detail)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="ms-0">
                                                                            <div class="fw-bold">
                                                                                {{ $detail->head }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="ms-0">
                                                                            <div class="fw-bold">
                                                                                {{ $detail->expenditure }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="ms-0">
                                                                            <div class="fw-bold">
                                                                                {{ $detail->amount }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        @if ($detail->file_path)
                                                                            <div class="ms-0">
                                                                                <i
                                                                                    class="fa-regular fa-file text-primary"></i>
                                                                                <a href="{{ Storage::url($detail->file_path) }}"
                                                                                    target="_blank" class="fw-semibold">
                                                                                    <u>Reference Document</u>
                                                                                </a>
                                                                            </div>
                                                                        @else
                                                                            <div class="ms-0 text-muted fst-italic">
                                                                                <i class="fa-regular fa-file"></i>
                                                                                Not Available
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <!--begin::Grand total-->
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td class="text-dark fw-bolder text-sm-end pb-0">
                                                                <span class="fs-5 text-gray-800">
                                                                    Advance Paid :
                                                                </span>
                                                            </td>
                                                            <td colspan=""
                                                                class="text-dark fw-bolder text-end fs-5 pb-0 ">
                                                                <div>
                                                                    <span
                                                                        class="fs-5 fw-semibold text-gray-500 align-self-start me-1">
                                                                        &#x20b9;
                                                                    </span>
                                                                    <span class="fs-5 text-gray-800">

                                                                        {{ number_format((float) $expense->advance_amount, 2) }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @if ($expense->amount > 0)
                                                            <tr>
                                                                <td></td>
                                                                <td colspan="2"
                                                                    class="text-dark fw-bolder text-sm-end fs-2  py-0">
                                                                    <span class="fs-5  text-gray-800 ">
                                                                        Total Claimed :
                                                                    </span>
                                                                </td>
                                                                <td class="text-dark fw-bolder text-end fs-2  py-0">
                                                                    <div>
                                                                        <span
                                                                            class="fs-5 fw-semibold text-gray-500 align-self-start me-1">
                                                                            &#x20b9;
                                                                        </span>
                                                                        <span class="fs-5  text-gray-800">
                                                                            {{ number_format((float) $expense->amount, 2) }}
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td colspan="2"
                                                                    class="text-dark fw-bolder text-sm-end fs-3 py-0  br-0">
                                                                    <span class="fs-5 fw-bold text-info ">
                                                                        Amount to be Settled :
                                                                    </span>
                                                                </td>
                                                                <td class="text-dark fw-bolder text-end fs-2 py-0 br-0">
                                                                    <div>
                                                                        <span
                                                                            class="fs-3 fw-semibold text-info align-self-start me-1">
                                                                            &#x20b9;
                                                                        </span>
                                                                        <span class="fs-3 fw-bold text-info">
                                                                            {{ number_format((float) $settleAmount, 2) }}
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if ($settleAmount != 0)
                                                            <tr>
                                                                <td colspan="4"
                                                                    class="text-dark text-sm-end fs-3 py-0 br-0">
                                                                    <div class="fs-6 text-gray-600">
                                                                        @if ($expense->amount > 0 && $settleAmount != 0)
                                                                            [ {{ ucfirst($settle_words) }} Rupees Only.]
                                                                        @else
                                                                            [ {{ ucfirst($advance_words) }} Rupees Only.]
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        @if ($expense->status === 'expense_submitted')
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-sm btn-success me-5"
                                                    id="approveExpenseBtn" data-expense-id="{{ $expense->id }}">
                                                    {{-- <i class="fa-solid fa-check"></i> --}}
                                                    Approve
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-danger me-5"
                                                    id="rejectExpense" data-expense-id="{{ $expense->id }}">
                                                    Reject
                                                </button>
                                            </div>
                                        @endif

                                        <!--end::Table-->
                                    </div>
                                    <!--end:Order summary-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Body-->

                        </div>
                        <!-- end::Wrapper-->
                    </div>
                    <!-- end::Body-->
                </div>
                <!-- end::Invoice 1-->
            </div>
            <!--end::Content container-->
        </div>
    </div>
@endsection
@section('pageScripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('#approveExpenseBtn').on('click', function() {
            const expenseId = $(this).data('expense-id');
            let settlementDate = $('#start_date').val();

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will settle the travel expense reimbursement.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn' // Add your custom class for cancel button
                }
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('travel.settle') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            expense_id: expenseId,
                            settle_amount: {{ $settleAmount ?? 0 }},
                            settlement_date: settlementDate
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1500);
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get today's date
            const today = new Date();

            // Initialize flatpickr on #start_date
            flatpickr("#start_date", {
                defaultDate: today, // Sets default to today
                dateFormat: "d-M-Y", // Desired date format
            });
        });
    </script>

    <script>
        $('#rejectExpense').on('click', function() {
            const expenseId = $(this).data('expense-id');

            Swal.fire({
                title: 'Reject Expense',
                input: 'textarea',
                inputLabel: 'Rejection Comments',
                inputPlaceholder: 'Enter comments here...',
                inputAttributes: {
                    'aria-label': 'Type your comments here'
                },
                showCancelButton: true,
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn'
                },

                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Rejection comments is required');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('travel.reject') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            expense_id: expenseId,
                            rejection_reason: result.value
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Rejected',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1500);
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
