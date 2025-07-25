@extends('layouts.admin')

<style>
    .bottom {
        display: flex;
        justify-content: space-between;
        /* Distribute space between elements */
        align-items: center;
        /* Align elements vertically in the center */
    }
</style>
<style>
    .nav-scroll {
        overflow-x: auto;
        white-space: nowrap;
    }

    .nav-item {
        display: inline-block !important;
        vertical-align: top;
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

@section('content')
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar pt-6 ">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Admin User Dashboard</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="" class="text-info">Overview of {{ $currentfinancialYear->year }} : Budget &
                                    Expense Summary</a>
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
                            @foreach ($financialyears as $year)
                                <option value="{{ $year->year }}"
                                    {{ $year->year == $currentfinancialYear->year ? 'selected' : '' }}>
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
                <div id="kt_app_content_container" class="app-container container-fluid">


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
                                    <div class="px-9 pt-7 card-rounded h-250px w-100 bg-blue">
                                        <!--begin::Heading-->
                                        <div class="d-flex flex-stack">
                                            <h3 class="m-0 text-white fw-bold fs-3">Allocation</h3>

                                            <div class="ms-1">
                                                <a type="button" title="View Report" href="{{ route('catreport') }}"
                                                    class="btn btn-sm btn-icon btn-color-white btn-active-white btn-active-color-primary border-0 me-n3">
                                                    <i class="fa-solid fa-arrow-right fs-4"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Balance-->
                                        <div class="d-flex text-center flex-column text-white pt-4">
                                            <span class="fw-semibold fs-7">Budget Allocated</span>
                                            <span
                                                class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format_indian($budgettotalAmount, 2) }}</span>
                                        </div>
                                        <!--end::Balance-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Items-->
                                    <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 pb-0 position-relative z-index-1 h-300"
                                        style="margin-top: -100px">
                                        @foreach ($categoryWiseBudgets as $budget)
                                            @php
                                                $allocatedPercentage =
                                                    $budgettotalAmount > 0
                                                        ? ($budget->total_amount / $budgettotalAmount) * 100
                                                        : 0;

                                                $badgeClass = ' badge-light-danger'; // Default class $iconClass="color-red" ;
                                                $iconClass = 'color-red';

                                                if ($allocatedPercentage < 25) {
                                                    $badgeClass = 'badge-light-success';
                                                    $iconClass = 'color-green';
                                                } elseif ($allocatedPercentage < 50) {
                                                    $badgeClass = 'badge-light-info';
                                                    $iconClass = 'color-blue';
                                                } elseif ($allocatedPercentage < 70) {
                                                    $badgeClass = 'badge-light-warning';
                                                    $iconClass = 'color-orange';
                                                }
                                                if (floor($allocatedPercentage) == $allocatedPercentage) {
                                                    $allocatedPercentage =
                                                        number_format_indian($allocatedPercentage, 0) . '%';
                                                } else {
                                                    $allocatedPercentage =
                                                        number_format_indian($allocatedPercentage, 2) . '%';
                                                }
                                                $words = explode(' ', $budget->category->category_name);

                                                if (count($words) == 1) {
                                                    $output = strtoupper(
                                                        substr($budget->category->category_name, 0, 2),
                                                    );
                                                } else {
                                                    $output = strtoupper(
                                                        substr($words[0], 0, 1) .
                                                            substr($words[count($words) - 1], 0, 1),
                                                    );
                                                }
                                            @endphp <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-6">
                                                <!--begin::Symbol-->
                                                <!-- <div class="symbol symbol-45px w-40px me-5">
                                                <span class="symbol-label bg-lighten">
                                                    <span class="svg-icon svg-icon-1">
                                                        {{ $output }}
                                                    </span>
                                                </span>
                                            </div> -->
                                                <!--end::Symbol-->
                                                <!--begin::Description-->
                                                <div class="d-flex align-items-center flex-wrap w-100">
                                                    <!--begin::Title-->
                                                    <div class="mb-1 pe-3 flex-grow-1 w-100">
                                                        <a href="#"
                                                            class="fs-6 text-gray-800 text-hover-primary fw-bold">
                                                            {{ $budget->category->category_name }}
                                                        </a>
                                                    </div>
                                                    <!--end::Title-->
                                                    <!--begin::Label-->
                                                    <div class="d-flex w-100 align-items-center">
                                                        <span class="badge {{ $badgeClass }} fs-9 w-60px">
                                                            <!--begin::Svg Icon-->
                                                            <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                                <i
                                                                    class="fa-solid fa-arrow-up {{ $iconClass }} fs-9 me-1"></i>
                                                            </span>
                                                            <!--end::Svg Icon--> {{ $allocatedPercentage }}
                                                        </span>
                                                        <div class="fw-bold fs-6 text-gray-600 ms-auto">
                                                            &#x20b9;{{ number_format_indian($budget->total_amount, 2) }}
                                                        </div>
                                                    </div>
                                                    <!--end::Label-->
                                                </div>

                                                <!--end::Description-->
                                            </div>
                                            <!--end::Item-->
                                        @endforeach



                                    </div>
                                    <!--end::Items-->
                                    <span class="fs-7 px-6 mx-9 count-info">

                                        {{ count($categoryWiseBudgets) }} of {{ $totalcatCount }} categories allocated
                                    </span>

                                </div>
                                <!--end::Body-->

                            </div>
                            <!--end::Mixed Widget 1-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-xl-4 mt-0">
                            <!--begin::Mixed Widget 1-->
                            <div class="card card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body p-0">
                                    <!--begin::Header-->
                                    <div class="px-9 pt-7 card-rounded h-250px w-100 bg-danger">
                                        <!--begin::Heading-->
                                        <div class="d-flex flex-stack">
                                            <h3 class="m-0 text-white fw-bold fs-3">Usage</h3>
                                            <div class="ms-1">
                                                <a type="button" title="View Report" href="{{ route('catreport') }}"
                                                    class="btn btn-sm btn-icon btn-color-white btn-active-white btn-active-color-primary border-0 me-n3">
                                                    <i class="fa-solid fa-arrow-right fs-4"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Heading-->


                                        <!--begin::Balance-->
                                        <div class="d-flex text-center flex-column text-white pt-4">
                                            <span class="fw-semibold fs-7">Budget Used</span>
                                            <span
                                                class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format_indian($PaidAmount, 2) }}</span>
                                        </div>
                                        <!--end::Balance-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Items-->
                                    <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 pb-0 position-relative z-index-1 h-300"
                                        style="margin-top: -100px">
                                        <!--begin::Item-->
                                        @foreach ($categorybudgetused as $result)
                                            @php

                                                $budget_amount = $result['budget_amount'] ?? 0;
                                                $total_milestone_amount = $result['total_milestone_amount'] ?? 0;
                                                $catpaidPercentage =
                                                    $budget_amount > 0
                                                        ? ($total_milestone_amount / $budget_amount) * 100
                                                        : 0;
                                                if (floor($catpaidPercentage) == $catpaidPercentage) {
                                                    $catpaidPercentage = number_format_indian($catpaidPercentage, 0);
                                                } else {
                                                    $catpaidPercentage = number_format_indian($catpaidPercentage, 2);
                                                }

                                                $catprogressBarClass = 'bg-info'; // Default class
                                                if ($catpaidPercentage >= 90) {
                                                    $catprogressBarClass = 'bg-danger';
                                                } elseif ($catpaidPercentage >= 70) {
                                                    $catprogressBarClass = 'bg-warning';
                                                } elseif ($catpaidPercentage >= 50) {
                                                    $catprogressBarClass = 'bg-success';
                                                }

                                                $bwords = explode(' ', $result['parent_category_name']);

                                                if (count($bwords) == 1) {
                                                    $boutput = strtoupper(
                                                        substr($result['parent_category_name'], 0, 2),
                                                    );
                                                } else {
                                                    $boutput = strtoupper(
                                                        substr($bwords[0], 0, 1) .
                                                            substr($bwords[count($bwords) - 1], 0, 1),
                                                    );
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center mb-6">

                                                <div class="d-flex align-items-center flex-wrap w-100">
                                                    <!--begin::Title-->
                                                    <div class="mb-1 pe-3 w-100">
                                                        <a href="#"
                                                            class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $result['parent_category_name'] }}</a>
                                                    </div>
                                                    <!--end::Title-->
                                                    <!--begin::Label-->
                                                    <div class="d-flex align-items-center w-100">
                                                        <div class="d-flex flex-column flex-grow-1 me-2">
                                                            <span
                                                                class="text-muted me-2 fs-9 fw-bold">{{ number_format_indian($catpaidPercentage, 2) }}%</span>
                                                            <div class="progress h-4px w-50px p-0 m-0">
                                                                <div class="progress-bar {{ $catprogressBarClass }}"
                                                                    role="progressbar"
                                                                    style="width: {{ floor($catpaidPercentage) }}%"
                                                                    aria-valuenow="80" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="fw-bold fs-6 text-gray-600 ms-auto">
                                                            &#x20b9;{{ number_format_indian($result['total_milestone_amount'], 2) }}
                                                        </div>
                                                    </div>
                                                    <!--end::Label-->
                                                </div>

                                            </div>
                                            <!--end::Item-->
                                        @endforeach
                                    </div>
                                    <!--end::Items-->

                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 1-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-xl-4 mt-0">
                            <!--begin::Mixed Widget 1-->
                            <div class="card card-xl-stretch mb-5 mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body p-0">
                                    <!--begin::Header-->
                                    <div class="px-9 pt-7 card-rounded h-250px w-100 bg-success">
                                        <!--begin::Heading-->
                                        <div class="d-flex flex-stack">
                                            <h3 class="m-0 text-white fw-bold fs-3">Balance</h3>
                                            <div class="ms-1">
                                                <a type="button" title="View Report" href="{{ route('catreport') }}"
                                                    class="btn btn-sm btn-icon btn-color-white btn-active-white btn-active-color-primary border-0 me-n3">
                                                    <i class="fa-solid fa-arrow-right fs-4"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Balance-->
                                        <div class="d-flex text-center flex-column text-white pt-4">
                                            <span class="fw-semibold fs-7">Remaning Budget</span>
                                            <span
                                                class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format_indian($remainingBudget, 2) }}</span>
                                        </div>
                                        <!--end::Balance-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Items-->
                                    <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1 h-300"
                                        style="margin-top: -100px">
                                        <div class="card-body d-flex flex-column  py-0">
                                            <div class="flex-grow-1">
                                                <div class="budgetused" data-kt-chart-color="success"
                                                    style="height: 180px; min-height: 178.7px;" id="usedPercentageChart">
                                                    <!-- <div id="apexchartsjqk2il5bi" class="apexcharts-canvas apexchartsjqk2il5bi apexcharts-theme-light" style="width: 344px; height: 178.7px;">
                    <div class="apexcharts-legend"></div>
                   </div> -->
                                                </div>

                                            </div>

                                        </div>
                                        <div>
                                            <p class="text-center fs-6 pb-0 mb-0">

                                                {{ $usedPercentage }}% of the budget has been strategically used.
                                            </p>

                                        </div>
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 1-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10 mb-0 px-5 ">


                        <div class="card mb-5">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-10">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Vendor Statistics</span>
                                    <span class="text-muted mt-1 fw-semibold fs-7">Over {{ count($vendors) }}
                                        Vendors</span>
                                </h3>
                                <!--begin::Card toolbar-->
                                <div class="ms-1">
                                    <a type="button" title="View Report" href="{{ route('vendorreport') }}"
                                        class="btn btn-sm btn-icon color-blue btn-active-primary btn-active-color-white border-0 me-n3">
                                        <i class="fa-solid fa-arrow-right fs-4"></i>
                                    </a>
                                </div>

                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-0">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                                        id="vendor-table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fw-bold text-muted">

                                                <th class="min-w-300px">Vendor</th>
                                                <th class="min-w-150px">Total</th>
                                                <th class="min-w-150px">Paid</th>
                                                <th class="min-w-150px">Balance</th>
                                                <th class="min-w-100px">Payment (%)</th>
                                            </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                            @forelse($vendors as $key => $vendor)
                                                @php
                                                    // Retrieve the proposal and paid amounts
                                                    $totalProposalAmount =
                                                        $vendor->proposals->first()->total_proposal_amount ?? 0;
                                                    $totalPaidAmount =
                                                        $vendor->invoices->first()->total_paid_amount ?? 0;

                                                    // Calculate the balance amount
                                                    $balanceAmount = $totalProposalAmount - $totalPaidAmount;

                                                    // Calculate the paid percentage, ensuring no division by zero
                                                    $paidPercentage =
                                                        $totalProposalAmount > 0
                                                            ? ($totalPaidAmount / $totalProposalAmount) * 100
                                                            : 0;

                                                    if (floor($paidPercentage) == $paidPercentage) {
                                                        $paidPercentage = number_format_indian($paidPercentage, 0);
                                                    } else {
                                                        $paidPercentage = number_format_indian($paidPercentage, 2);
                                                    }

                                                    $progressBarClass = 'bg-warning'; // Default class
                                                    $progressBarText = 'color-orange';
                                                    if ($paidPercentage >= 75) {
                                                        $progressBarClass = 'bg-success';
                                                        $progressBarText = 'color-green';
                                                    } elseif ($paidPercentage >= 25) {
                                                        $progressBarClass = 'bg-info';
                                                        $progressBarText = 'color-blue';
                                                    }

                                                    $vwords = explode(' ', $vendor->vendor_name);
                                                    $voutput = strtoupper(substr($vendor->vendor_name, 0, 2));

                                                    // Define an array of color classes
                                                    $colors = [
                                                        'bg-red',
                                                        'bg-cyan',
                                                        'bg-orange-dark',
                                                        'bg-blue',
                                                        'bg-green',
                                                        'bg-blue-dark',
                                                        'bg-purple-dark',
                                                        'bg-cyan-dark',
                                                    ];

                                                @endphp
                                                <tr>

                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-45px symbol-circle me-5">
                                                                <span
                                                                    class="symbol-label {{ $colors[array_rand($colors)] }} text-white">
                                                                    {{ $voutput }}</span>

                                                            </div>
                                                            <div class="d-flex justify-content-start flex-column">
                                                                <a href="{{ route('vendor.show', $vendor->id) }}"
                                                                    class="text-dark fw-bold text-hover-primary fs-7">{{ strtoupper($vendor->vendor_name) }}</a>

                                                                <span
                                                                    class="fw-semibold d-block text-gray-600 fs-8">{{ $vendor->company->company_name ?? '' }}</span>
                                                                <span
                                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{ $vendor->email }}
                                                                    | {{ $vendor->phone }}</span>

                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="fw-400 d-block fs-6">
                                                                <span
                                                                    class="fs-4 fw-semibold text-gray-600 align-self-start me-0">&#x20b9;</span>
                                                                <span
                                                                    class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($totalProposalAmount, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="fw-400 d-block fs-6">
                                                                <span
                                                                    class="fs-4 fw-semibold text-gray-600 align-self-start me-0">&#x20b9;</span>
                                                                <span
                                                                    class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($totalPaidAmount, 2) }}</span>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="fw-400 d-block fs-6">
                                                                <span
                                                                    class="fs-4 fw-semibold text-gray-600 align-self-start me-0">&#x20b9;</span>
                                                                <span
                                                                    class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($balanceAmount, 2) }}</span>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-0">
                                                                <span
                                                                    class=" {{ $progressBarText }}  me-2 fs-7 fw-bold">{{ number_format_indian($paidPercentage, 2) }}%</span>
                                                            </div>
                                                            <div class="progress h-4px w-100">
                                                                <div class="progress-bar {{ $progressBarClass }}"
                                                                    role="progressbar"
                                                                    style="width: {{ floor($paidPercentage) }}%;"
                                                                    aria-valuenow="90" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
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
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--begin::Body-->
                        </div>




                    </div>
                    <!--end::Content container-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
            <!--begin::Footer-->
            <div id="kt_app_footer" class="app-footer">
                <!--begin::Footer container-->
                <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                    <!--begin::Copyright-->

                    <!--end::Copyright-->
                    <!--begin::Menu-->

                    <!--end::Menu-->
                </div>
                <!--end::Footer container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end:::Main-->
    </div>
    <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <!-- <h5 class="modal-title" id="exampleModalLabel">View Allocation</h5> -->
                    <div class="card w-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3" id="exam-name"></span>
                            </h3>
                        </div>
                        <div class="card-header min-h-10px border-0 mb-0 pb-0">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fs-5 mb-1 text-gray-700" id="room-name"></span>
                            </h3>
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fs-5 mb-1 text-gray-700" id="exam-date"></span>
                            </h3>
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fs-5 mb-1 text-gray-700" id="exam-time"></span>
                            </h3>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body p-0">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--end::App-->

    <script src="assets/js/custom/apps/ecommerce/reports/returns/returns.js"></script>

    <script>
        document.getElementById('financialYearSelect').addEventListener('change', function() {

            document.getElementById('page-loader').style.display = 'flex';
            const selectedYearId = this.value;
            window.location.href = '?year=' + selectedYearId;
        });
    </script>

    <script>
        var usedPercentage = {{ $usedPercentage }};
        var initMixedWidget4 = function() {
            var charts = document.querySelectorAll('.budgetused');

            [].slice.call(charts).map(function(element) {
                var height = parseInt(window.getComputedStyle(element).height);

                if (!element) {
                    return;
                }

                var color = element.getAttribute('data-kt-chart-color');

                var baseColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-' + color);
                var lightColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-' + color +
                    '-light');
                var labelColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-gray-700');

                var options = {
                    series: [usedPercentage], // Dynamically pass your used percentage here
                    chart: {
                        fontFamily: 'inherit',
                        height: height,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: "65%"
                            },
                            dataLabels: {
                                showOn: "always",
                                name: {
                                    show: false,
                                    fontWeight: '700'
                                },
                                value: {
                                    color: labelColor,
                                    fontSize: "30px",
                                    fontWeight: '700',
                                    offsetY: 12,
                                    show: true,
                                    formatter: function(val) {
                                        return val + '%';
                                    }
                                }
                            },
                            track: {
                                background: lightColor,
                                strokeWidth: '100%'
                            }
                        }
                    },
                    colors: [baseColor],
                    stroke: {
                        lineCap: "round",
                    },
                    labels: ["Progress"]
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            });
        }

        // Initialize the chart when the document is fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            initMixedWidget4();
        });
    </script>
@endsection

@section('pageScripts')
    <script>
        $(document).ready(function() {
            $('#vendor-table').DataTable({
                "pageLength": 10,
                "ordering": false,
                "searching": false,
                "lengthChange": false,
                "autoWidth": false,
            });
        });
    </script>

    <script>
        window.addEventListener('load', function() {
            document.getElementById('page-loader').style.display = 'none';
        });
    </script>
@endsection
