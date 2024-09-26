@extends('layouts.admin')

@section('content')

<style>
	#vendortable th:first-child::after {
		display: none !important;
	}

	.hide {
		display: none !important;
	}
</style>
<div class="d-flex flex-column flex-column-fluid">
	<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
		<!--begin::Toolbar container-->
		<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<!--begin::Title-->
				<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Vendor Listing</h1>
				<!--end::Title-->
				<!--begin::Breadcrumb-->
				<!-- <ul class="breadcrumb fw-semibold fs-7 my-0 pt-1">
											
										</ul> -->
				<!--end::Breadcrumb-->
			</div>
			<!--end::Page title-->
			<!--begin::Button-->
			@if (Auth::user()->isvendor())
			<div class="card-toolbar">
				<a href="{{ route('vendor.create') }}" class="btn btn-sm btn-primary">
					Create
				</a>
			</div>
			@endif
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
												<span class="card-label fw-bold fs-3 mb-1">Vendor List</span>
											</h3>
										</div> -->
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body py-3">
					<!--begin::Table container-->
					<div class="table-responsive">
						<!--begin::Table-->
						<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="vendortable">
							<!--begin::Table head-->
							<thead>
								<tr class="fw-bold">
									<th class="w-50px">#</th>
									<th class="min-w-100px">Vendor</th>
									<th class="min-w-200px">Tax #</th>
									<th class="min-w-250px">Address</th>
									<th class="min-w-150px text-center">Actions</th>
								</tr>
							</thead>
							<!--end::Table head-->
							<!--begin::Table body-->
							<tbody>
								@forelse($vendors as $key => $vendor)
								<tr>
									<td>
										<div class="d-flex align-items-center">
											<div class="fw-100 d-block fs-6">
												{{ $key+1 }}
											</div>
										</div>
									<td>
										<div class="d-flex align-items-center">
											<div class="symbol symbol-45px me-5">
												<span class="symbol-label color-blue w-80px"> {{$vendor->vendor_code}}</span>
											</div>
											<div class="d-flex justify-content-start flex-column">
												<a href="{{ route('vendor.show',1) }}" class="text-dark fw-bold text-hover-primary fs-6">{{$vendor->vendor_name}}</a>
												<span class="color-blue fw-semibold d-block fs-7">{{ $vendor->company->company_name ?? '' }}</span>
												<span class="text-muted fw-semibold text-muted d-block fs-7">{{$vendor->email}}</span>
												<span class="text-muted fw-semibold text-muted d-block fs-7">{{$vendor->phone}}</span>
											</div>
										</div>
									</td>
									<td>
										<div class="d-flex justify-content-start flex-column">
											<span class="text-dark fw-semibold text-dark d-block fs-7">@if(!empty($vendor->gst))GST : {{$vendor->gst}}@endif</span>
											<span class="text-dark fw-semibold text-dark d-block fs-7">@if(!empty($vendor->pan))PAN : {{$vendor->pan}}@endif</span>
										</div>
									</td>
									<td>
										<div class="d-flex justify-content-start flex-column">
											<span class="text-dark fw-semibold text-dark d-block fs-7">{{$vendor->address}}</span>
										</div>
									</td>
									<td class="text-center">
										<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
											<i class="fa-solid fa-angle-down"></i></a>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="{{route('vendor.edit',$vendor->id)}}" class="menu-link px-3">Edit</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="" class="menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
											</div>
											<!--end::Menu item-->

											<!--begin::Menu item-->
											@if($vendor->vendor_status != 'verified')
											<div class="menu-item px-3">
												<a href="javascript:void(0)" onclick="approvevendor('{{$vendor->id}}','approve')"
													class="menu-link px-3">Approve</a>
											</div>
											@endif
											@if($vendor->vendor_status != 'rejected')
											<div class="menu-item px-3">
												<a href="javascript:void(0)" onclick="approvevendor('{{$vendor->id}}','rejected')"
													class="menu-link px-3">Reject</a>
											</div>
											@endif
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
		$('#vendortable').DataTable({
			"iDisplayLength": 10,
			"searching": true,
			"recordsTotal": 3615,
			"columnDefs": [{
					"orderable": false,
					"targets": [0, 2, 3, 4]
				} // Disable sorting on specific columns (0-indexed)
			],
			"pagingType": "full_numbers"
		});
	});
</script>

<script>
function approvevendor(vid,status) {

	if (status === 'rejected') {
    var title = 'You want to reject this vendor?';
     } else if (status === 'approve') {
    var title = 'You want to approve this vendor?';
       } else {
    var title = 'Invalid status';
    }

    swal({
		    title: "Are you sure?",
			title: title,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('vendor.approve') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: vid,
						status: status,
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