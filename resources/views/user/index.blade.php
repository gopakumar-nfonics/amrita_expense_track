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
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Manage User</h1>
										<!--end::Title-->
										
									</div>
									<!--end::Page title-->
									<div class="card-toolbar">
												<a href="{{route('user.create')}}" class="btn btn-sm btn-primary">
													Create User
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
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold fs-3 mb-1">User List</span>
											</h3>
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body py-3">
											<!--begin::Table container-->
											<div class="table-responsive">
												<!--begin::Table-->
												<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="userstable">
													<!--begin::Table head-->
													<thead>
														<tr class="fw-bold">
															<th class="w-50px">#</th>
															<th class="min-w-200px">Name</th>
															<th class="min-w-150px">Email</th>
															<th class="min-w-150px">Role</th>
															<th class="min-w-100px text-center">Actions</th>
														</tr>
													</thead>
													<!--end::Table head-->
													<!--begin::Table body-->
													<tbody>
                          								@forelse($users as $key => $user)
														<tr>
															<td>
                                								<div class="d-flex align-items-center">
																	<div class="fw-400 d-block fs-6">
                                    									{{ $key+1 }}
																	</div>
																</div>
															<td>
																<div class="d-flex align-items-center">
																	<div class="fw-400 d-block fs-6">
                                    									{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}
																	</div>
																</div>
															</td>
															<td>
                                								<div class="d-flex align-items-center">
																	<div class="fw-400 d-block fs-6">
                                    									{{$user->email}}
																	</div>
																</div>
															</td>
															<td>
																<div class="d-flex align-items-center">
																	<div class="fw-400 d-block fs-6">
																		{{ $user->role }}
                                  									</div>
																</div>
															</td>
															<td>
																<div class="d-flex justify-content-end flex-shrink-0">
																	<a href="{{route('user.edit',$user->id)}}" class="link-info mx-3">
                                  										<i class="fa-regular fa-pen-to-square mx-1 link-info"></i>Edit
																	</a>
																	<a href="javascript:void(0)" onclick="removeUser('{{$user->id}}')" class="link-danger ">
                                  										<i class="fa-regular fa-trash-can mx-1 link-danger"></i>Delete
																	</a>
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
@endsection
@section('pageScripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
  $(document).ready(function(){
    $('#userstable').DataTable( {
        "iDisplayLength":10,
        "searching": true,
        "recordsTotal":3615,
        "pagingType": "full_numbers"
    } );
  });
</script>

<script>
	function removeUser(userId) {
		swal({
			title: "Are you sure?",
			text: "You want to remove this user",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: "{{ route('user.deleteUser') }}",
					type: 'POST',
					data: {
						_token: '{{ csrf_token() }}',
						id: userId,
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


