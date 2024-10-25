@extends('layouts.admin')

@section('content')

<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
	<!--begin::Content wrapper-->
	<div class="d-flex flex-column flex-column-fluid">
		<!--begin::Toolbar-->
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<!--begin::Toolbar container-->
			<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
				<!--begin::Page title-->
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<!--begin::Title-->
					<!-- <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Create Stream</h1> -->
					<!--end::Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb fw-semibold fs-7 my-0 pt-1">

					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page title-->

			</div>
			<!--end::Toolbar container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Content-->
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<!--begin::Content container-->
			<div id="kt_app_content_container" class="app-container container-xxl">
				<!--begin::Basic info-->
				<div class="card mb-5 mb-xl-10">
					<!--begin::Card header-->
					<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
						<!--begin::Card title-->
						<div class="card-title m-0">
							<h3 class="fw-bold m-0">Edit Programme</h3>
						</div>
						<!--end::Card title-->
					</div>
					<!--begin::Card header-->
					<!--begin::Content-->
					<div id="kt_account_settings_profile_details" class="collapse show">
						<!--begin::Form-->
						<form id="kt_account_profile_details_form" class="form" method="POST" action="{{route('stream.update',$stream->id)}}" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<!--begin::Card body-->
							<div class="card-body border-top p-9">

								<!--begin::Input group-->
								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label required fw-semibold fs-6">Name</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<!--begin::Col-->
										<div class="col-lg-12 fv-row">
											<input type="text" name="name" class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name', $stream->stream_name) }}" />
											@error('name')<div class="invalid-feedback">{{ $message }}</div> @enderror
										</div>
										<!--end::Col-->
									</div>
									<!--end::Col-->
								</div>
								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label required fw-semibold fs-6">Code</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<!--begin::Col-->
										<div class="col-lg-12 fv-row">
											<input type="text" name="code" class="form-control form-control-lg form-control-solid @error('code') is-invalid @enderror" placeholder="Code" value="{{ old('code', $stream->stream_code) }}" />
											@error('code')<div class="invalid-feedback">{{ $message }}</div> @enderror
										</div>
										<!--end::Col-->
									</div>
									<!--end::Col-->
								</div>

								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label required fw-semibold fs-6">Campus</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<!--begin::Col-->
										<div class="col-lg-12 fv-row">
											<select class="form-select mb-2 @error('campus') is-invalid @enderror" data-control="select2" data-hide-search="true" data-placeholder="Select Campus" name="campus" id="campus">
												<option></option>
												@foreach ($campus as $cmps)
												<option value="{{$cmps->id}}" @if(old('campus',$stream->campus_id) == $cmps->id) selected @endif>{{$cmps->campus_name}}</option>
												@endforeach

											</select>
											@error('campus')<div class="invalid-feedback">{{ $message }}</div> @enderror
										</div>
										<!--end::Col-->
									</div>
									<!--end::Col-->
								</div>

								<div class="row mb-6">
									<!-- Department Selection -->
									<label class="col-lg-4 col-form-label fw-semibold fs-6">Department</label>
									<div class="col-lg-8 fv-row">
										<div class="col-lg-12 fv-row">
											<select class="form-select mb-2 @error('department') is-invalid @enderror" data-control="select2" data-hide-search="true" data-placeholder="Select Department" name="department" id="department">
												<option></option>
												@foreach ($department as $dept)
												<option value="{{$dept->id}}" data-address="{{$dept->address}}" @if(old('department',$stream->department_id ) == $dept->id) selected @endif>{{$dept->department_name}}</option>
												@endforeach

											</select>
											@error('department')<div class="invalid-feedback">{{ $message }}</div> @enderror
										</div>
									</div>
								</div>
								<!--begin::Input group-->
								<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Billing Address</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<!--begin::Col-->
															<div class="col-lg-12 fv-row">
																<textarea name="billingaddress" id="billingaddress" class="form-control form-control-lg form-control-solid @error('billingaddress') is-invalid @enderror" placeholder="Address">{{ old('billingaddress', $stream->billing_address) }}</textarea>
																@error('billingaddress')<div class="invalid-feedback">{{ $message }}</div> @enderror
															</div>
															<!--end::Col-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
							</div>
							<!--end::Card body-->
							<!--begin::Actions-->
							<div class="card-footer d-flex justify-content-end py-6 px-9">
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save</button>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Basic info-->
			</div>
			<!--end::Content container-->
		</div>
		<!--end::Content-->
	</div>
	<!--end::Content wrapper-->

	@endsection
    @section('pageScripts')
	<script>
    $(document).ready(function() {
        $('#campus').on('change', function() {
            var campusId = $(this).val();
            if(campusId) {
                $.ajax({
					url: "{{ route('campus.getdepartments', ':campusId') }}".replace(':campusId', campusId),
					type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#department').empty();
                        $('#department').append('<option></option>'); // Add the placeholder
                        $.each(data, function(key, value) {
                            $('#department').append('<option value="'+ value.id +'" data-address="'+value.address+'">'+ value.department_name +'</option>');
                        });
                    }
                });
            } else {
                $('#department').empty();
                $('#department').append('<option></option>'); // Add the placeholder
            }
        });
		$('#department').on('change', function() {
        var billingaddress = $(this).find(':selected').data('address');
		$('#billingaddress').val(billingaddress);
    });
    });
</script>
@endsection