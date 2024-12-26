@extends('layouts.admin')

@section('content')
<style>
	.input-group-text{
		border: none !important;
	}
</style>
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
												<h3 class="fw-bold m-0">Update Profile</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
											<!--begin::Form-->
											<form id="kt_account_profile_details_form" class="form" method="POST" action="{{route('userupdate')}}" enctype="multipart/form-data">
                                            @csrf
											@method('PUT')
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8">
															<!--begin::Row-->
															<div class="row">
																<!--begin::Col-->
																<div class="col-lg-6 fv-row">
																	<input type="text" name="fname" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('fname') is-invalid @enderror" placeholder="First name" value="{{ old('fname', $user->first_name) }}" />
																    @error('fname')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
																<!--begin::Col-->
																<div class="col-lg-6 fv-row">
																	<input type="text" name="lname" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="{{ old('lname', $user->last_name) }}" />
																</div>
																<!--end::Col-->
															</div>
															<!--end::Row-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                                                        <div class="col-lg-8 fv-row">
                                                            <p class="form-control form-control-lg form-control-solid text-muted">{{ $user->email }}</p>
                                                        </div>
														<!--end::Label-->
														<!--begin::Col-->
														
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Password</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
														<div class="input-group">
															<input type="password" id="password" name="password" class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') }}" />
															<span class="input-group-text" onclick="togglePasswordVisibility()">
												            <i class="fas fa-eye" id="togglePasswordIcon"></i>
											                </span>
										                </div>
															@error('password')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													
													<!--begin::Input group-->
													
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">
															<span>Campus</span></label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
                                                            <p class="form-control form-control-lg form-control-solid text-muted">
                                                                {{ $campus->firstWhere('id', $user->campus_id)->campus_name ?? 'N/A' }}
                                                            </p>
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
    function togglePasswordVisibility() {
        const passwordField = document.getElementById("password");
        const toggleIcon = document.getElementById("togglePasswordIcon");
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>
@endsection