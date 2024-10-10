@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Budget
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
                <a href="{{ route('budget.create') }}" class="btn btn-sm btn-primary">
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
                                    <th class="w-50px">#</th>
                                    <th class="min-w-100px">Category</th>
                                    <th class="min-w-100px">Year</th>
                                    <th class="min-w-100px">Allocated</th>
                                    <th class="min-w-100px">Used</th>
                                    <th class="min-w-100px">Balance</th>
                                    <th class="min-w-100px">Usage (%)</th>
                                    <th class="min-w-150px text-center">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @forelse($budgets as $key => $budget)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                {{ $key+1 }}
                                            </div>
                                        </div>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-5">
                                                <span class="symbol-label color-blue w-80px">
                                                    {{$budget->category->category_code}}</span>

                                            </div>
                                            <div class="fw-400 d-block fs-6">
                                                {{$budget->category->category_name}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                {{$budget->financialYear->year}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span
                                                    class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                <span
                                                    class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$budget['amount']}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span
                                                    class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                <span
                                                    class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$budget['used_amount']}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php

                                        $remaining_budget = $budget['amount'] - $budget['used_amount'];

                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span
                                                    class="fs-4 fw-semibold text-gray-500 align-self-start me-0">&#x20b9;</span>
                                                <span
                                                    class="total-cost-span fs-4 fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$remaining_budget}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php

                                        $used_budget_percentage = ($budget['used_amount'] / $budget['amount']) * 100;
                                        $used_budget_percentage = number_format($used_budget_percentage, 2);
                                        $badgeClass = 'badge-light-danger'; // Default class
                                        $iconClass="color-red";

                                        if ($used_budget_percentage < 25) { $badgeClass='badge-light-success' ;
                                            $iconClass="color-green" ;} elseif ($used_budget_percentage < 50) {
                                            $badgeClass='badge-light-info' ; $iconClass="color-blue" ;} elseif
                                            ($used_budget_percentage < 70) { $badgeClass='badge-light-warning'
                                            ;$iconClass="color-orange" ; } @endphp <div
                                            class="d-flex flex-column w-100 me-2">
                                            <div class="text-gray-400 fw-semibold fs-7">
                                                <span class="badge {{ $badgeClass }} fs-7">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                    <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                        <i class="fa-solid fa-arrow-up {{ $iconClass }} fs-7 me-1 "></i>
                                                    </span>
                                                    <!--end::Svg Icon-->{{$used_budget_percentage}}%
                                                </span>
                                            </div>
                    </div>
                    </td>


                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">Actions
                            <i class="fa-solid fa-angle-down"></i></a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{route('budget.edit',$budget['id'])}}" class="menu-link px-3">Edit</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="javascript:void(0)" onclick="removebudget('{{$budget['id']}}')"
                                    class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
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

<script>
function removebudget(budid) {
    swal({
            title: "Are you sure?",
            text: "You want to remove this Budget",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('budget.deletebudget') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: budid,
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

@endsection