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
@section('content')
<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">


                <div class="row g-5 g-xl-8 mt-1">
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <!--begin::Header-->
                                <div class="px-9 pt-7 card-rounded h-250px w-100 bg-blue">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">Allocation</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-8">
                                        <span class="fw-semibold fs-7">Budget Allocated</span>
                                        <span
                                            class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format($budgettotalAmount, 2) }}</span>
                                    </div>
                                    <!--end::Balance-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Items-->
                                <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 pb-0 position-relative z-index-1 h-300"
                                    style="margin-top: -100px">
                                    @foreach($categoryWiseBudgets as $budget)
                                    @php
                                    $allocatedPercentage = $budgettotalAmount > 0 ? ($budget->total_amount /
                                    $budgettotalAmount) * 100 : 0;
                                    if (floor($allocatedPercentage) == $allocatedPercentage) {
                                    $allocatedPercentage = number_format($allocatedPercentage, 0) . '%';
                                    } else {
                                    $allocatedPercentage = number_format($allocatedPercentage, 2) . '%';
                                    }



                                    $words = explode(' ', $budget->category->category_name);

                                    if (count($words) == 1) {
                                    $output = strtoupper(substr($budget->category->category_name, 0, 2));
                                    } else {
                                    $output = strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0,
                                    1));
                                    }

                                    @endphp

                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-6">
                                        <!--begin::Symbol-->
                                        <!-- <div class="symbol symbol-45px w-40px me-5">
                                            <span class="symbol-label bg-lighten">
                                                <span class="svg-icon svg-icon-1">
                                                    {{$output}}
                                                </span>
                                            </span>
                                        </div> -->
                                        <!--end::Symbol-->
                                        <!--begin::Description-->
                                        <div class="d-flex align-items-center flex-wrap w-100">
                                            <!--begin::Title-->
                                            <div class="mb-1 pe-3 flex-grow-1 w-100">
                                                <a href="#" class="fs-7 text-gray-800 text-hover-primary fw-bold">
                                                    {{$budget->category->category_name}}
                                                </a>
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Label-->
                                            <div class="d-flex w-100 align-items-center">
                                                <span class="badge badge-light-success fs-9 w-60px">
                                                    <!--begin::Svg Icon-->
                                                    <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                        <i class="fa-solid fa-arrow-up light-green fs-9 me-1"></i>
                                                    </span>
                                                    <!--end::Svg Icon--> {{$allocatedPercentage}}
                                                </span>
                                                <div class="fw-bold fs-7 text-gray-500 ms-auto">
                                                    &#x20b9;{{ number_format($budget->total_amount, 2) }}
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
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-4">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <!--begin::Header-->
                                <div class="px-9 pt-7 card-rounded h-250px w-100 bg-danger">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">Usage</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-8">
                                        <span class="fw-semibold fs-7">Budget Used</span>
                                        <span
                                            class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format($totalPaidAmount, 2) }}</span>
                                    </div>
                                    <!--end::Balance-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Items-->
                                <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 pb-0 position-relative z-index-1 h-300"
                                    style="margin-top: -100px">
                                    <!--begin::Item-->
                                    @foreach($categorybudgetused as $result)

                                    @php

                                    $budget_amount = $result['budget_amount'] ?? 0;
                                    $total_milestone_amount = $result['total_milestone_amount'] ?? 0;


                                    $catpaidPercentage = $budget_amount > 0 ? ($total_milestone_amount / $budget_amount)
                                    * 100 : 0;

                                    if (floor($catpaidPercentage) == $catpaidPercentage) {
                                    $catpaidPercentage = number_format($catpaidPercentage, 0);
                                    } else {
                                    $catpaidPercentage = number_format($catpaidPercentage, 2);
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
                                    $boutput = strtoupper(substr($result['parent_category_name'], 0, 2));
                                    } else {
                                    $boutput = strtoupper(substr($bwords[0], 0, 1) . substr($bwords[count($bwords) - 1],
                                    0, 1));
                                    }
                                    @endphp
                                    <div class="d-flex align-items-center mb-6">

                                        <div class="d-flex align-items-center flex-wrap w-100">
                                            <!--begin::Title-->
                                            <div class="mb-1 pe-3 w-100">
                                                <a href="#"
                                                    class="fs-7 text-gray-800 text-hover-primary fw-bold">{{ $result['parent_category_name'] }}</a>
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Label-->
                                            <div class="d-flex align-items-center w-100">
                                                <div class="d-flex flex-column flex-grow-1 me-2">
                                                    <span
                                                        class="text-muted me-2 fs-9 fw-bold">{{ number_format($catpaidPercentage, 2) }}%</span>
                                                    <div class="progress h-4px w-50px p-0 m-0">
                                                        <div class="progress-bar {{$catprogressBarClass}}"
                                                            role="progressbar"
                                                            style="width: {{ floor($catpaidPercentage) }}%"
                                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fw-bold fs-7 text-gray-500 ms-auto">
                                                    &#x20b9;{{ number_format($result['total_milestone_amount'], 2) }}
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
                    <div class="col-xl-4">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <!--begin::Header-->
                                <div class="px-9 pt-7 card-rounded h-250px w-100 bg-success">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">Balance</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-8">
                                        <span class="fw-semibold fs-7">Remaning Budget</span>
                                        <span
                                            class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format($remainingBudget, 2) }}</span>
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
                                            <div>
                                                <p class="text-center fs-6 pb-0 mb-0">
                                                    <span class="badge badge-light-danger fs-8">Note :</span>&nbsp;
                                                    {{ $usedPercentage }}% of the budget has been strategically used.
                                                </p>

                                            </div>
                                        </div>

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
                                <span class="text-muted mt-1 fw-semibold fs-7">Over {{count($vendors)}} Vendors</span>
                            </h3>
                            <!--begin::Card toolbar-->

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
                                        $totalProposalAmount = $vendor->proposals->first()->total_proposal_amount ?? 0;
                                        $totalPaidAmount = $vendor->invoices->first()->total_paid_amount ?? 0;

                                        // Calculate the balance amount
                                        $balanceAmount = $totalProposalAmount - $totalPaidAmount;

                                        // Calculate the paid percentage, ensuring no division by zero
                                        $paidPercentage = $totalProposalAmount > 0 ? ($totalPaidAmount /
                                        $totalProposalAmount) * 100 : 0;

                                        if (floor($paidPercentage) == $paidPercentage) {
                                        $paidPercentage = number_format($paidPercentage, 0);
                                        } else {
                                        $paidPercentage = number_format($paidPercentage, 2);
                                        }

                                        $progressBarClass = 'bg-info'; // Default class
                                        $progressBarText='color-blue';
                                        if ($paidPercentage >= 90) {
                                        $progressBarClass = 'bg-danger';
                                        $progressBarText='color-red';

                                        } elseif ($paidPercentage >= 70) {
                                        $progressBarClass = 'bg-warning';
                                        $progressBarText='color-orange';
                                        } elseif ($paidPercentage >= 50) {
                                        $progressBarClass = 'bg-success';
                                        $progressBarText='color-45ab48';
                                        }

                                        $vwords = explode(' ', $vendor->vendor_name);
                                        $voutput = strtoupper(substr($vendor->vendor_name, 0, 2));


                                        @endphp
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-45px me-5">
                                                        <span class="symbol-label bg-blue text-white">
                                                            {{$voutput}}</span>

                                                    </div>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="{{ route('vendor.show',$vendor->id) }}"
                                                            class="text-dark fw-bold text-hover-primary fs-7">{{strtoupper($vendor->vendor_name)}}</a>

                                                        <span
                                                            class="fw-semibold d-block text-gray-600 fs-8">{{ $vendor->company->company_name ?? '' }}</span>
                                                        <span
                                                            class="text-muted fw-semibold text-muted d-block fs-7">{{$vendor->email}}
                                                            | {{$vendor->phone}}</span>

                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format($totalProposalAmount, 2) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format($totalPaidAmount, 2) }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format($balanceAmount, 2) }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-0">
                                                        <span
                                                            class=" {{ $progressBarText }}  me-2 fs-3 fw-bold">{{ number_format($paidPercentage, 2) }}%</span>
                                                    </div>
                                                    <div class="progress h-6px w-100">
                                                        <div class="progress-bar {{ $progressBarClass }}"
                                                            role="progressbar"
                                                            style="width: {{ floor($paidPercentage) }}%;"
                                                            aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
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
var usedPercentage = {
    {
        $usedPercentage
    }
};
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

@endsection