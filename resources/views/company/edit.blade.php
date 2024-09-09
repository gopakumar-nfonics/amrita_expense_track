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
										<!-- <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Create Company</h1> -->
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
												<h3 class="fw-bold m-0">Edit Company</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
											<!--begin::Form-->
											<form id="kt_account_profile_details_form" class="form" method="POST" action="{{route('company.update',$company->id)}}" enctype="multipart/form-data">
                                            @csrf
											@method('PUT')
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--end::Col-->
														<label class="col-lg-2 col-form-label fw-semibold fs-6">Code</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-4 fv-row">	
																<!--begin::Col-->
																<div class="col-lg-12 fv-row">
																<div class="fw-bold fs-6 pt-3">{{$company->company_code}}</div>
																	<input type="hidden" name="code"  placeholder="Code" value="{{$company->company_code}}" />
																   
                                                                </div>
																<!--end::Col-->
														</div>
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Name</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-4 fv-row">	
																<!--begin::Col-->
																<div class="col-lg-12 fv-row">
																	<input type="text" name="name" class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name', $company->company_name) }}" />
																    @error('name')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
														</div>
														<!--end::Col-->
														
													</div>

													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Email</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-4 fv-row">	
																<!--begin::Col-->
																<div class="col-lg-12 fv-row">
																	<input type="text" name="email" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', $company->email) }}" />
																	@error('email')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
														</div>
														<!--end::Col-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Phone</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-4 fv-row">	
																<!--begin::Col-->
																<div class="col-lg-12 fv-row">
																	<input type="text" name="phone" class="form-control form-control-lg form-control-solid @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{ old('phone', $company->phone) }}" />
																    @error('phone')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
														</div>
													</div>
                                                    

													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label  fw-semibold fs-6">GST #</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-4 fv-row">	
																<!--begin::Col-->
																<div class="col-lg-12 fv-row">
																	<input type="text" name="gst" class="form-control form-control-lg form-control-solid @error('gst') is-invalid @enderror" placeholder="GST #" value="{{ old('gst', $company->gst) }}" />
																	@error('gst')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
														</div>
														<!--end::Col-->
														<label class="col-lg-2 col-form-label  fw-semibold fs-6">PAN #</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-4 fv-row">	
																<!--begin::Col-->
																<div class="col-lg-12 fv-row">
																	<input type="text" name="pan" class="form-control form-control-lg form-control-solid @error('pan') is-invalid @enderror" placeholder="PAN #" value="{{ old('pan', $company->pan) }}" />
																    @error('pan')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
														</div>
													</div>
												
                                                    <div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Address</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-10 fv-row">	
																<!--begin::Col-->
																<div class="col-lg-12 fv-row">
																	<textarea name="address" class="form-control form-control-lg form-control-solid @error('address') is-invalid @enderror" placeholder="Address">{{ old('address', $company->address) }}</textarea>
																    @error('address')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
														</div>
														<!--end::Col-->
													</div>
													
													<!--begin::Input group-->
													
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