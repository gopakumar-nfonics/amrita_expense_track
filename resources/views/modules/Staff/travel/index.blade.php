@extends('modules.Staff.layouts.staff')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
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
                    Create
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
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="userstable">
                            <thead>
                                <tr class="fw-bold">
                                    <th class="w-50px">#</th>
                                    <th class="min-w-150px">Title</th>
                                    <th class="min-w-200px">Trip Details</th>
                                    <th class="min-w-100px">Advance Amount</th>
                                    <th class="min-w-100px">Settled Amount</th>
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
                                    <td>

                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6 fw-bold ">
                                                {{ ucfirst($expense->title) }}
                                                <div class="text-gray-400 fw-semibold fs-9">

                                                    <span class="badge badge-light-info fs-8">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                        <span class="svg-icon svg-icon-5 svg-icon-success ms-n1">
                                                            <i
                                                                class="fa-regular fa-circle-dot color-blue fs-8 me-1 "></i>
                                                        </span>
                                                        <!--end::Svg Icon-->Advance Requested
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="d-flex justify-content-start flex-column">
                                                <a href=""
                                                    class="text-dark fw-bold text-hover-primary fs-6  txt-capitalcase">{{ $expense->sourceCity->name ?? 'N/A' }} -
                                                    {{ $expense->destinationCity->name ?? 'N/A' }}</a>
                                                <span
                                                    class="d-flex justify-content-start text-muted fw-semibold text-muted d-block fs-8">Period :
                                                    {{ \Carbon\Carbon::parse($expense->from_date)->format('d-M-Y') }} -
                                                    {{ \Carbon\Carbon::parse($expense->to_date)->format('d-M-Y') }}

                                                </span>
                                            </div>
                                        </div>

                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span class="">
                                                    &#x20b9;
                                                </span>
                                                {{ $expense->amount }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-400 d-block fs-6">
                                                <span class="">
                                                    &#x20b9;
                                                </span>
                                                {{ $expense->amount }}
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
                                            <div class="menu-item px-3">
                                                <a href=""
                                                    class="menu-link px-3">
                                                    Submit Expense
                                                </a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href=""
                                                    class="menu-link px-3">
                                                    Edit
                                                </a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0)"
                                                    onclick=""
                                                    class="menu-link px-3"
                                                    data-kt-customer-table-filter="delete_row">
                                                    Delete
                                                </a>
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
                        </table>
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

{{-- <script>
        function removeDesignation(designationId) {
            swal({
                    title: "Are you sure?",
                    text: "You want to remove this Designation",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "/designation/" + designationId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
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
</script> --}}
@endsection