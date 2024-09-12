@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Invoice
                    Listing</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <!-- <ul class="breadcrumb fw-semibold fs-7 my-0 pt-1">
											
										</ul> -->
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Button-->
            <div class="card-toolbar">
                <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-primary">
                    Create
                </a>
            </div>
            <!--end::Button-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <!-- <div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold fs-3 mb-1">Category List</span>
											</h3>
										</div> -->
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="budgettable">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bold">
                                    <th class="min-w-100px">ID</th>
                                    <th class="min-w-200px">Invoice</th>
                                    <th class="min-w-100px">RO #</th>
                                    @if(!Auth::user()->isvendor())
                                    <th class="min-w-200px">Vendor</th>
                                    @endif
                                    <th class="min-w-100px">Cost</th>
                                    <th class="min-w-150px text-center">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @forelse($invoices as $key => $inv)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                #{{$inv->invoice_id}}
                                                <div class="text-gray-400 fw-semibold fs-9">
                                                    @if($inv->invoice_status == 0)
                                                    <span class="badge badge-light-info fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i
                                                                class="fa-regular fa-circle-dot color-blue fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Pending
                                                    </span>
                                                    @else

                                                    <span class="badge badge-light-success fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i class="fa-solid fa-check light-green fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Processed
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    <td>
                                        <div class="d-flex align-items-center">

                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('invoice.show',$inv->id) }}"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{$inv->milestone->milestone_title}}</a>
                                                <span class="text-muted fw-semibold text-muted d-block fs-7">Submitted
                                                    On :
                                                    {{ \Carbon\Carbon::parse($inv->created_at)->format('d-M-Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">

                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('lead.ro',$inv->proposalro->proposal_id) }}"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{$inv->proposalro->proposal_ro}}</a>
                                                <span class="text-muted fw-semibold text-muted d-block fs-7">Issued On :
                                                    {{ \Carbon\Carbon::parse($inv->proposalro->created_at)->format('d-M-Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    @if(!Auth::user()->isvendor())
                                    <td>

                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-2">
                                                <span
                                                    class="symbol-label bg-blue text-white">{{$inv->vendor->vendor_name[0]}}{{$inv->vendor->vendor_name[strlen($inv->vendor->vendor_name) - 1]}}</span>

                                            </div>
                                            <div class="d-flex justify-content-start flex-column">
                                                <a href="{{ route('vendor.show',1) }}"
                                                    class="text-dark fw-bold text-hover-primary fs-6">{{$inv->vendor->vendor_name}}
                                                </a>
                                                <span
                                                    class="text-muted fw-semibold text-muted d-block fs-7">{{$inv->vendor->phone}}</span>
                                            </div>
                                        </div>

                                    </td>
                                    @endif


                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span
                                                    class="fs-2 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                <span
                                                    class="total-cost-span fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$inv->milestone->milestone_total_amount}}</span>
                                            </div>
                                        </div>
                                    </td>



                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <i class="fa-solid fa-angle-down"></i></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                            data-kt-menu="true">



                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('lead.show',1) }}" class="menu-link px-3">View </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            @if(!Auth::user()->isvendor() && $inv->invoice_status ==0)
                                            <div class="menu-item px-3">
                                                <a href="{{ route('payment.create',$inv->id) }}"
                                                    class="menu-link px-3">Proceed Payment</a>
                                            </div>
                                            @endif
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="" class="menu-link px-3">Edit</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="" class="menu-link px-3"
                                                    data-kt-customer-table-filter="delete_row">Delete</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
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
    </div>
</div>
@endsection

@section('pageScripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    $('#budgettable').DataTable({
        "iDisplayLength": 10,
        "searching": true,
        "recordsTotal": 3615,
        "pagingType": "full_numbers"
    });
});
</script>

@endsection