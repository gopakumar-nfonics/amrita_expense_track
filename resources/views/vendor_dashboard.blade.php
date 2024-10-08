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
                                <div class="px-9 pt-7 card-rounded h-200px w-100 bg-blue">
                                    <!--begin::Heading-->
                                    <div class="d-flex flex-stack">
                                        <h3 class="m-0 text-white fw-bold fs-3">Proposal</h3>

                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Balance-->
                                    <div class="d-flex text-center flex-column text-white pt-8">
                                        <span class="fw-semibold fs-7">Proposed Amount</span>
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
                    <div class="col-xl-4">
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
                    <div class="col-xl-4">
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


                    <div class="card mb-5 pb-5 pt-4 px-10">
                        <div class="d-flex flex-column w-100 me-2">
                            <div class="d-flex flex-stack mb-0">
                                <span class=" color-blue  me-2 fs-7 ">{{$paid_percentage}}% of Amount Disbursed</span>
                            </div>
                            <div class="progress h-6px w-100">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{$paid_percentage}}%;"
                                    aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
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
                                <span class="text-muted mt-1 fw-semibold fs-7">Over {{count($proposal)}} Proposals</span>
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

                                        $total_paid_amount = $pro->invoices->isNotEmpty() ? $pro->invoices[0]->total_paid_amount : 0;
                                        $total_milestone_count =  $pro->paymentMilestones->count();
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
                                        @endphp

                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="{{ route('lead.show',$pro->id) }}"
                                                            class="text-dark fw-bold text-hover-primary fs-6">{{$pro->proposal_title}}</a>
                                                        <span
                                                            class="text-muted fw-semibold text-muted d-block fs-8">Submitted
                                                            on {{ \Carbon\Carbon::parse($pro->created_at)->format('d-M-Y') }}</span>

                                                        <span class="fw-semibold d-block text-gray-600 fs-8">No. of
                                                            Milestones
                                                            : {{$total_milestone_count}}</span>

                                                            <div class="text-gray-400 fw-semibold fs-9">
                                                    @if($pro->proposal_status == 0)
                                                    <span class="badge badge-light-info fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
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
                                                        <i class="fa-solid fa-close color-red fs-8 me-2 "></i>Rejected

                                                    </span>
                                           

                                                    @else
                                                    <span class="badge badge-light-success fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i class="fa-solid fa-check light-green fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Approved
                                                    </span>
                                                    @endif
                                                </div>


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
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($total_paid_amount, 2) }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        <span
                                                            class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                        <span
                                                            class="total-cost-span fs-5 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ number_format_indian($balanceAmount, 2) }}</span>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="text-end">
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
function number_format_indian(float $num, int $decimals = 2, string $decimal_separator = ".", string $thousands_separator = ","): string
{
    // Split the integer and decimal parts
    $parts = explode('.', number_format($num, $decimals, $decimal_separator, ''));

    // Format the integer part for Indian numbering system
    $integer_part = $parts[0];

    // Check if the number is negative
    $negative = ($num < 0) ? "-" : "";

    // Remove negative sign from the integer part for formatting
    $integer_part = ltrim($integer_part, '-');

    // Reverse the integer part to process it
    $last_three = substr($integer_part, -3); // Extract the last three digits
    $remaining = substr($integer_part, 0, -3); // Extract the remaining part

    // Add thousands separator in Indian format
    if (strlen($remaining) > 0) {
        $remaining = preg_replace("/\B(?=(\d{2})+(?!\d))/", $thousands_separator, $remaining);
        $formatted_integer = $remaining . $thousands_separator . $last_three;
    } else {
        $formatted_integer = $last_three;
    }

    // Combine integer part and decimal part
    $result = $negative . $formatted_integer;
    if (isset($parts[1])) {
        $result .= $decimal_separator . $parts[1];
    }

    return $result;
}

?>
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