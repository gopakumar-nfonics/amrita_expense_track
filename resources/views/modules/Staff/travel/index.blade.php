@extends('modules.Staff.layouts.staff')

@section('content')
    <style>
        .table.gy-4 td,
        .table.gy-4 th {
            vertical-align: middle !important;
        }
    </style>
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(243 240 240 / 92%);
            /* or any bg color you want */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-dots {
            display: block;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .loading-dots span {
            width: 16px;
            height: 16px;
            margin: 0px 3px !important;
            background-color: #d63384;
            /* dot color */
            border-radius: 50%;
            display: inline-block;
            animation: bounce 0.6s infinite alternate;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            from {
                transform: translateY(0);
                opacity: 0.6;
            }

            to {
                transform: translateY(-10px);
                opacity: 1;
            }
        }
    </style>
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <div id="kt_app_toolbar" class="app-toolbar pt-6 ">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">


                        Expenses Overview | {{ strtoupper(Auth::user()->name) }}



                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="" class="text-info">Overview of 2026 : Travel Expenses &
                                Payment Summary</a>
                        </li>

                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="#" class="text-dark fs-6" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_create_app">Select Year :</a>
                    <!--end::Secondary button-->
                    <select id="financialYearSelect" class="form-select"
                        style="width: 90px; padding: 5px 15px; cursor: pointer;">
                        {{-- <option value="">Year</option> --}}
                        @foreach ($financialyears as $year)
                            <option value="{{ $year->year }}"
                                {{ request('year', $currentYear->year ?? '') == $year->year ? 'selected' : '' }}>
                                {{ $year->year }}
                            </option>
                        @endforeach

                    </select>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">

                <div id="page-loader">
                    <div class="loading-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div class="row g-5 g-xl-8 mt-4">
                    <!--begin::Col-->
                    <div class="col-xl-4 mt-0">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <!--begin::Header-->
                                <div class="px-9 pt-7 card-rounded h-150px w-100 bg-blue">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-5">Travel Expenses</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-3">

                                        <span class="fw-bold fs-1 pt-1">
                                            &#x20b9;{{ number_format($totalAmount) }}
                                        </span>
                                    </div>
                                    <!--end::Balance-->

                                    <span class="db-date-span">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
                                </div>
                                <!--end::Header-->

                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-4  mt-0">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <!--begin::Header-->
                                <div class="px-9 pt-7 card-rounded h-150px w-100 bg-danger">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-5">Disbursed Amount</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-3">

                                        <span class="fw-bold fs-1 pt-1">
                                            &#x20b9;{{ number_format($totalDisbursed) }}
                                        </span>
                                    </div>
                                    <!--end::Balance-->

                                    <span class="db-date-span">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
                                </div>
                                <!--end::Header-->


                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-4  mt-0">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <!--begin::Header-->
                                <div class="px-9 pt-7 card-rounded h-150px w-100 bg-success">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-5">Balance</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-3">
                                        <span class="fw-bold fs-1 pt-1">
                                            &#x20b9;{{ number_format($balance) }}
                                        </span>
                                    </div>
                                    <!--end::Balance-->

                                    <span class="db-date-span">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
                                </div>
                                <!--end::Header-->

                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                    <!--begin::Toolbar container-->
                    <div id="kt_app_toolbar_container" class="container-xxl d-flex flex-stack px-0">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <!--begin::Title-->
                            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Expense Listing
                            </h1>
                            <!--end::Title-->

                        </div>
                        <!--end::Page title-->
                        <div class="card-toolbar">
                            <a href="{{ route('travel.create') }}" class="btn btn-sm btn-primary">
                                Request Advance
                            </a>
                        </div>
                    </div>
                    <!--end::Toolbar container-->
                </div>
                <!--end::Toolbar-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="userstable">
                                <thead>
                                    <tr class="fw-bold">
                                        <th class="w-50px">#</th>
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
                                                                        : ($expense->status === 'rejected'
                                                                            ? 'badge-light-danger'
                                                                            : 'badge-light-secondary')); // fallback for unknown statuses
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
                                                @if ($expense->status === 'rejected')
                                                    <span class="badge badge-light-info fs-8 rejected-span"
                                                        title="View Comments" data-bs-toggle="modal"
                                                        data-bs-target="#rejectionReasonModal"
                                                        data-reason="{{ $expense->rejection_reason }}">
                                                        <i class="fa-regular fa-comments color-blue fs-8 me-2"></i>
                                                    </span>
                                                @endif
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
                                                    <div class="fw-400 d-block fs-6"><span class="w-100px">Advance &nbsp;
                                                            &nbsp;:</span>
                                                        <span
                                                            class="fs-6 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-6 fw-bold text-gray-800 me-2 lh-1 ls-n2">
                                                            {{ $expense->advance_amount }}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6"><span class="w-100px">Settlement
                                                            :</span>
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


                                                <div class="d-flex flex-column w-150px me-0">
                                                    <div class="d-flex flex-stack mb-0">
                                                        <span class="w-100px">Payment (%)
                                                            :</span>
                                                        <span class=" {{ $progressBarText }}  me-2 fs-8 fw-bold">
                                                            {{ number_format((float) $paidPercentage, 2) }}%
                                                        </span>
                                                    </div>
                                                    <div class="progress h-3px w-150px">
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
                                                    @if (($expense->status === 'rejected' && !$expense->is_resubmit) || $expense->status === 'expense_submitted')
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('travel.edit', $expense->id) }}"
                                                                class="menu-link px-3"
                                                                data-kt-customer-table-filter="delete_row">
                                                                {{ $expense->status === 'rejected' ? 'Resubmit' : 'Edit' }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if (in_array($expense->status, ['expense_submitted', 'expense_settled', 'rejected']))
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('travel.show', encrypt($expense->id)) }}"
                                                                class="menu-link px-3"
                                                                data-kt-customer-table-filter="delete_row">
                                                                View
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($expense->status === 'advance_received')
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('travel.submit', $expense->id) }}"
                                                                class="menu-link px-3">
                                                                Submit Expense
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if ($expense->status === 'advance_requested')
                                                        <div class="menu-item px-3">
                                                            <a href="javascript:void(0)"
                                                                onclick="removeExpense('{{ $expense->id }}')"
                                                                class="menu-link px-3"
                                                                data-kt-customer-table-filter="delete_row">
                                                                Delete
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="rejectionReasonModal" tabindex="-1"
                            aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectionReasonModalLabel">
                                            Rejection Reason
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">X</button>
                                    </div>
                                    <div class="modal-body" id="rejectionReasonContent">
                                        <!-- Reason will be injected here -->
                                    </div>
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
        document.getElementById('financialYearSelect').addEventListener('change', function() {
            document.getElementById('page-loader').style.display = 'flex';
            const selectedYearId = this.value;

            // Redirect accordingly
            if (selectedYearId) {
                window.location.href = '?year=' + selectedYearId;
            } else {
                // No year selected: load base route (no query string)
                window.location.href = window.location.pathname;
            }
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            document.getElementById('page-loader').style.display = 'none';
        });
    </script>
    <script>
        function removeExpense(expenseId) {
            swal({
                    title: "Are you sure?",
                    text: "You want to remove this Advance Request",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ route('travel.delete') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: expenseId,
                            },
                            success: function(response) {
                                if (response.success) {
                                    swal(response.success, {
                                        icon: "success",
                                        buttons: false,
                                    });
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    swal(response.error || 'Something went wrong.', {
                                        icon: "warning",
                                        buttons: false,
                                    });
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                }
                            },
                            error: function(xhr) {
                                swal('Error: Something went wrong.', {
                                    icon: "error",
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('rejectionReasonModal');
            modal.addEventListener('show.bs.modal', function(event) {
                const trigger = event.relatedTarget;
                const reason = trigger.getAttribute('data-reason');
                document.getElementById('rejectionReasonContent').textContent = reason ||
                    'No reason provided.';
            });
        });
    </script>
@endsection
