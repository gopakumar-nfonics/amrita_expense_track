@extends('layouts.admin')

@section('content')
<style>
@media print {
    body * {
        visibility: hidden;
    }

    #printableArea,
    #printableArea * {
        visibility: visible;
    }

    #printableArea {
        position: absolute;
        left: 0;
        top: 0;
    }
}
</style>
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">View
                    Proposal</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Proposal</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{$proposal->proposal_id}}</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <div class="card-toolbar">
                @if(!Auth::user()->isvendor() && $proposal->proposal_status ==0)
                <!-- begin::Pint-->
                <button type="button" class="btn btn-sm btn-success me-5" onclick="approve('{{$proposal->id}}')"><i
                        class="fa-solid fa-check "></i> Approve & Generate RO</button>
                <!-- end::Pint-->
                @endif
                <!-- begin::Pint-->
                <button type="button" class="btn btn-sm btn-info me-5" onclick="window.print();"><i
                        class="fa-solid fa-print"></i> Print</button>
                <!-- end::Pint-->


                <!-- end::Actions-->
                <a href="{{ route('lead.index') }}" class="btn btn-sm btn-primary">
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
                            <div class="text-sm-start">
                                <!--begin::Logo-->
                                <a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue txt-uppercase">
                                    {{$proposal->proposal_id}} | {{$proposal->proposal_title}}
                                </a>
                                <!--end::Logo-->

                            </div>
                            <!--begin::Text-->
                            <div class="d-flex  justify-content-between text-sm-start fw-semibold fs-7 text-muted">
                                <div class="d-flex flex-column">
                                    <span class="fs-5 text-gray-900">{{$proposal->vendor->vendor_name}}</span>
                                    <span class="fs-7 text-gray-700">{{$proposal->vendor->address}},
                                        {{$proposal->vendor->city}},{{$proposal->vendor->states ? $proposal->vendor->states[0]['name'] : ''}}-{{$proposal->vendor->postcode}}
                                        <br>{{$proposal->vendor->email}} | {{$proposal->vendor->phone}}
                                        <br>GSTIN : {{$proposal->vendor->gst}} | PAN NO:
                                        {{$proposal->vendor->pan}}</span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-muted">Date</span>
                                    <span
                                        class="fs-5 text-gray-700">{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>

                                    @if($proposal->file_path)

                                    <div class="symbol symbol-20px mt-5">
                                        <img alt="Icon" src="{{ url('/') }}/assets/media/svg/files/pdf.svg">
                                        <a href="{{ Storage::url($proposal->file_path) }}"
                                            download="{{ basename($proposal->file_path) }}" class="fw-semibold ms-2">
                                            <u>Reference Document</u>
                                        </a>
                                    </div>

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

                                <!--begin::Separator-->
                                <div class="separator"></div>
                                <!--begin::Separator-->

                                <!--begin::Billing & shipping-->
                                <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                    <div class="flex-root d-flex flex-column">
                                        <span class="fs-6 text-gray-700 fw-bold txt-uppercase">Scope &
                                            Services</span>
                                        <div class="m-5"> {!! $proposal->proposal_description !!}
                                        </div>
                                    </div>

                                </div>
                                <!--end::Billing & shipping-->
                                <!--begin:Order summary-->
                                <div class="d-flex justify-content-between flex-column">
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-9">
                                        <span class="fs-6 text-gray-700 fw-bold txt-uppercase">Cost & Payments</span>
                                        <div class="m-5">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                                        <th class="min-w-175px pb-2">Milestone</th>
                                                        <!--<th class="min-w-70px text-start pb-2">Date</th>-->
                                                        <th class="min-w-70px text-end pb-2">Amount</th>
                                                        <th class="min-w-80px text-end pb-2">GST(%)</th>
                                                        <th class="min-w-100px text-end pb-2">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                    @foreach ($proposal->paymentMilestones as $milestone)
                                                    <!--begin::Products-->
                                                    <tr>
                                                        <!--begin::Product-->
                                                        <td>
                                                            <div class="d-flex align-items-center">

                                                                
                                                                <div class="ms-0">
                                                                    <div class="fw-bold">
                                                                        {{ $milestone->milestone_title }}
                                                                    </div>
                                                                </div>
                                                              
                                                            </div>
                                                        </td>
                                                        <!--end::Product-->
                                                        <!--begin::Date-->
                                                        <!--<td class="text-start">
                                                            {{ \Carbon\Carbon::parse($milestone->milestone_date)->format('d-M-Y') }}
                                                        </td>-->
                                                        <!--end::SKU-->
                                                        <!--begin::SKU-->
                                                        <td class="text-end">&#x20b9;<span
                                                                class="total-cost-span">{{ $milestone->milestone_amount }}</span>
                                                        </td>
                                                        <!--end::SKU-->
                                                        <!--begin::Quantity-->
                                                        <td class="text-end">{{ $milestone->milestone_gst }}</td>
                                                        <!--end::Quantity-->
                                                        <!--begin::Total-->
                                                        <td class="text-end">
                                                            &#x20b9;<span
                                                                class="total-cost-span">{{ $milestone->milestone_total_amount }}</span>
                                                        </td>
                                                        <!--end::Total-->
                                                    </tr>

                                                    <!--end::Products-->

                                                    @endforeach

                                                    <!--begin::Grand total-->
                                                    <tr>
                                                        <td class="text-dark fw-bolder text-sm-start fs-2"> <span
                                                                class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2 txt-uppercase">Total
                                                                Cost :</span></td>
                                                        <td colspan="5" class="text-dark fw-bolder text-end fs-2 "
                                                            style="font-size:18px !important;">
                                                            <div>
                                                                <span
                                                                    class="fs-2 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                                                <span id="total-cost-span"
                                                                    class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                                                                    data-kt-element="sub-total">{{$proposal->proposal_total_cost}}</span>

                                                                <div class="text-muted fs-5 text-gray-600">Rupees
                                                                    {{$amounwords}}
                                                                    rupees only.</div>
                                                            </div>
                                                        </td>
                                                    </tr>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    <!--end::Content-->
</div>
@endsection
@section('pageScripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
function approve(proid) {
    swal({
            title: "Are you sure, you want to approve this proposal?",
            text: "Once the approval process is completed, the RO will be generated and sent to the vendor's registered email address.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                document.getElementById('loaderOverlay').style.display = 'flex';
                $.ajax({
                    url: "{{ route('lead.approve') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: proid,
                    },
                    success: function(response) {
                        document.getElementById('loaderOverlay').style.display = 'none';
                        if (response.success) {
                            swal(response.success, {
                                icon: "success",
                                buttons: false,
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('lead.index') }}";
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
                        document.getElementById('loaderOverlay').style.display = 'none';
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
$(document).ready(function() {

    setCurrencyFormattingHTML('#total-cost-span');




});
</script>
@endsection