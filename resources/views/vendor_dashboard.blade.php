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
    background-color: rgb(243 240 240 / 92%); /* or any bg color you want */
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
    margin:0px 3px !important;
    background-color: #d63384; /* dot color */
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
                        @if(Auth::user()->isvendor())

                        Dashboard | {{ strtoupper(Auth::user()->first_name);}}


                        @endif
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="../../demo1/dist/index.html" class="text-info">Overview of {{$currentfinancialYear->year}} : Proposal &
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
                        @foreach($financialyears as $year)
                        <option value="{{ $year->year }}" {{  $year->year == $currentfinancialYear->year ? 'selected' : '' }}>
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
                                <div class="px-9 pt-7 card-rounded h-200px w-100 bg-blue">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">Proposal</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-8">
                                        <span class="fw-semibold fs-7">Approved Amount</span>
                                        <span
                                            class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format_indian($total_proposal_amount, 2) }}</span>
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
                                <div class="px-9 pt-7 card-rounded h-200px w-100 bg-danger">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">Payment</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-8">
                                        <span class="fw-semibold fs-7">Disbursed Amount</span>
                                        <span
                                            class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format_indian($total_paid_amount, 2) }}</span>
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
                                <div class="px-9 pt-7 card-rounded h-200px w-100 bg-success">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">Balance</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-8">
                                        <span class="fw-semibold fs-7">Due Amount</span>
                                        <span
                                            class="fw-bold fs-2 pt-1">&#x20b9;{{ number_format_indian($remainingBudget, 2) }}</span>
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
                <div class="row g-5 g-xl-10 mb-3 px-5 ">


                    <div class="card mb-5 pb-5 pt-5 px-10" style="background-color: #00bcd4;">
                        <div class="d-flex flex-column w-100 me-2">
                            <div class="d-flex flex-stack mb-0">
                                <span class=" color-white  me-2 fs-4 ">{{$paid_percentage}}% <span class="fs-7 ">of
                                        Amount Disbursed</span></span>
                            </div>
                            <div class="progress h-6px w-100 bg-white bg-opacity-50">
                                <div class="progress-bar bg-white" role="progressbar"
                                    style="width: {{$paid_percentage}}%;" aria-valuenow="90" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-0 px-5 ">


                    <div class="card mb-5">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-10 px-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Proposal Statistics</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Over {{count($proposal)}}
                                    Proposals</span>
                            </h3>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <a href="{{ route('lead.create') }}" class="btn btn-sm btn-primary">
                                    Create Proposal
                                </a>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body py-0  px-5 pb-5">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                                    id="vendor-table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bold text-muted">

                                            <th class="min-w-250px">Proposal</th>
                                            <th class="min-w-150px">Total</th>
                                            <th class="min-w-150px">Paid</th>
                                            <th class="min-w-150px">Balance</th>
                                            <th class="min-w-100px">Payment (%)</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @forelse($proposal as $key => $pro)

                                        @php

                                        $total_paid_amount = $pro->invoices->isNotEmpty() ?
                                        $pro->invoices[0]->total_paid_amount : 0;
                                        $total_milestone_count = $pro->paymentMilestones->count();
                                        $totlacost = $pro->proposal_total_cost;

                                        $balanceAmount = $totlacost - $total_paid_amount;
                                        $paidPercentage = 22;
                                        $paidPercentage = $totlacost > 0 ? ($total_paid_amount /
                                        $totlacost) * 100 : 0;

                                        if (floor($paidPercentage) == $paidPercentage) {
                                        $paidPercentage = number_format($paidPercentage, 0);
                                        } else {
                                        $paidPercentage = number_format($paidPercentage, 2);
                                        }

                                        $progressBarClass = 'bg-warning'; // Default class
                                        $progressBarText='color-orange';
                                        if ($paidPercentage >= 75) {
                                        $progressBarClass = 'bg-success';
                                        $progressBarText='color-green';
                                        } elseif ($paidPercentage >= 25) {
                                        $progressBarClass = 'bg-info';
                                        $progressBarText='color-blue';
                                        }

                                        $voutput = strtoupper(substr($pro->proposal_title, 0, 2));

                                        // Define an array of color classes
                                        $colors = ['bg-red', 'bg-cyan', 'bg-orange-dark',
                                        'bg-blue','bg-green','bg-blue-dark','bg-purple-dark','bg-cyan-dark'];
                                        @endphp

                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-45px symbol-circle me-5">
                                                        <span
                                                            class="symbol-label {{ $colors[array_rand($colors)] }} text-white">
                                                            {{$voutput}}</span>

                                                    </div>

                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="{{ route('lead.show',encrypt($pro->id)) }}"
                                                            class="text-dark fw-bold text-hover-primary fs-6">{{$pro->proposal_title}}</a>
                                                        <div class="text-gray-400 fw-semibold fs-9 my-1">
                                                            @if($pro->proposal_status == 0)
                                                            <span class="badge badge-light-info fs-8">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                                <span
                                                                    class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                                    <i
                                                                        class="fa-regular fa-circle-dot color-blue fs-8 me-1 "></i>
                                                                </span>
                                                                <!--end::Svg Icon-->Pending Review
                                                            </span>
                                                            @elseif($pro->proposal_status == 2)
                                                            <span class="badge badge-light-danger fs-8 rejected-span"
                                                                title="View Comments"
                                                                onclick="rejectionreason('{{$pro->id}}');">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->

                                                                <!--end::Svg Icon-->
                                                                <i
                                                                    class="fa-solid fa-close color-red fs-8 me-2 "></i>Rejected

                                                            </span>


                                                            @else
                                                            <span class="badge badge-light-success fs-8">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                                <span
                                                                    class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                                    <i
                                                                        class="fa-solid fa-check light-green fs-8 me-1 "></i>
                                                                </span>
                                                                <!--end::Svg Icon-->Approved
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <span class="text-muted fw-semibold text-muted d-block fs-8">No.
                                                            of
                                                            Payment Schedules
                                                            : {{$total_milestone_count}}</span>





                                                    </div>

                                                </div>
                                            </td>

                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($pro->proposal_total_cost, 2) }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                @if($pro->proposal_status != 2)
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($total_paid_amount, 2) }}</span>
                                                    </div>
                                                </div>

                                                @else
                                                <span class="fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2">NA</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($pro->proposal_status != 2)
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($balanceAmount, 2) }}</span>
                                                    </div>
                                                </div>
                                                @else
                                                <span class="fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2">NA</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if($pro->proposal_status != 2)
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-0">
                                                        <span
                                                            class=" {{ $progressBarText }}  me-2 fs-5 fw-bold">{{ number_format($paidPercentage, 2) }}%</span>
                                                    </div>
                                                    <div class="progress h-6px w-100">
                                                        <div class="progress-bar {{ $progressBarClass }}"
                                                            role="progressbar"
                                                            style="width: {{ floor($paidPercentage) }}%;"
                                                            aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <span
                                                    class="fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2 text-start">NA</span>
                                                @endif
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
<?php


?>
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

<script>
 window.addEventListener('load', function () {
        document.getElementById('page-loader').style.display = 'none';
    });
</script>

@endsection