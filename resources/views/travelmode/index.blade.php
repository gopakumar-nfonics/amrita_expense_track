@extends('layouts.admin')

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
                        Travel Mode Listing
                    </h1>
                    <!--end::Title-->

                </div>
                <!--end::Page title-->
                <div class="card-toolbar">
                    <a href="{{ route('travelmode.create') }}" class="btn btn-sm btn-primary">
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
                    <!-- <div class="card-header border-0 pt-5">
                                                   <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold fs-3 mb-1">User List</span>
                                                   </h3>
                                                  </div> -->

                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="userstable">
                                <thead>
                                    <tr class="fw-bold">
                                        <th class="w-50px">#</th>
                                        <th class="min-w-200px">Name</th>
                                        <th class="min-w-150px">Code</th>
                                        <th class="min-w-150px">Parent Mode</th>
                                        <th class="min-w-150px text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($travelmodes as $key => $modes)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        {{ $key + 1 }}
                                                    </div>
                                                </div>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        {{ ucfirst($modes->name) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        {{ $modes->code }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="fw-400 d-block fs-6">
                                                        {{ ucfirst($modes->parent ? $modes->parent->name : ' ') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    Actions <i class="fa-solid fa-angle-down"></i>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('travelmode.edit', $modes->id) }}"
                                                            class="menu-link px-3">
                                                            Edit
                                                        </a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)"
                                                            onclick="removeMode('{{ $modes->id }}')"
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

    <script>
        function removeMode(modeId) {
            swal({
                    title: "Are you sure?",
                    text: "You want to remove this travel mode",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "/travelmode/" + modeId,
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
    </script>
@endsection
