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
                    RELEASE ORDER</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">RELEASE ORDER</a>
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
                <div class="card-body py-10">
                    <!-- begin::Wrapper-->
                    <div class="mw-lg-950px mx-auto w-100" id="printableArea">
                        <!-- begin::Header-->
                        <div class="flex-sm-row mb-2">
                            <!--end::Logo-->
                            <div class="text-sm-start">
                                <!--begin::Logo-->
                                <a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                    <img alt="Logo" src="{{ url('/') }}/assets/media/logos/avv-head-logo.jpg"
                                        class="w-100">
                                </a>
                                <!--end::Logo-->

                            </div>

                            <div class="text-center py-10">
                                <!--begin::Logo-->
                                <span class="fs-3 text-gray-700"><u>RELEASE ORDER</u></span>

                            </div>
                            <!--begin::Text-->
                            <div class="d-flex  justify-content-between text-sm-start fw-semibold fs-7 text-muted">
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-bold text-hover-primary fs-4">RO#:
                                        AVV-0924-RO-003</span>

                                </div>
                                <div class="d-flex flex-column">

                                    <span
                                        class="fs-5 text-gray-700">{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>
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
                                        <span class="fs-6 text-gray-700 fw-bold txt-uppercase">To
                                            <div class="m-5"><span>Mr. Arunraj</span>
                                                </br>{{$proposal->vendor->vendor_name}}
                                            </div>
                                    </div>

                                </div>

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
                                        <div>
                                            <span class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2 txt-uppercase">Total
                                                Cost :</span>
                                            <span
                                                class="fs-2 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                            <span id="total-cost-span"
                                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                                                data-kt-element="sub-total">{{$proposal->proposal_total_cost}}
                                            </span>
                                            <span>[Inclusive of GST]</span>

                                            <div class="text-muted fs-5 text-gray-600">Rupees
                                                {{$amounwords}}
                                                rupees only.</div>
                                        </div>


                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end:Order summary-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->

                        <div class="text-sm-start">
                            <!--begin::Logo-->
                            <a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                <img alt="Logo" src="{{ url('/') }}/assets/media/logos/avv-footer-logo.jpg"
                                    class="w-100">
                            </a>
                            <!--end::Logo-->

                        </div>
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
            title: "Are you sure?",
            text: "You want to approve this proposal",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('lead.approve') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: proid,
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
$(document).ready(function() {

    setCurrencyFormattingHTML('#total-cost-span');




});
</script>
@endsection