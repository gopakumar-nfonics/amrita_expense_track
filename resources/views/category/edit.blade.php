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
												<h3 class="fw-bold m-0">Edit Category</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
											<!--begin::Form-->
											<form id="kt_account_profile_details_form" class="form" method="POST" action="{{route('category.update',$category->id)}}" enctype="multipart/form-data">
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
																	<input type="text" name="cat_name" class="form-control form-control-lg form-control-solid @error('cat_name') is-invalid @enderror" placeholder="Name" value="{{ old('cat_name', $category->category_name) }}" />
																    @error('cat_name')<div class="invalid-feedback">{{ $message }}</div> @enderror
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
																	<input type="text" name="cat_code" class="form-control form-control-lg form-control-solid @error('cat_code') is-invalid @enderror" placeholder="Code" value="{{ old('cat_code', $category->category_code) }}" />
																    @error('cat_code')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
																<!--end::Col-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Parent Category</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
                                                            <select class="form-control form-control-lg form-control-solid @error('parent_category') is-invalid @enderror" id="parent_category" name="parent_category">
															<option value="">--Select Parent Category--</option>
															@foreach($parent_cat as $cat)
                                                                    <option value="{{ $cat->id }}" @if(old('parent_category',$category->parent_category) == $cat->id) selected @endif>{{ $cat->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('parent_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        </div>
														<!--end::Col-->
													</div>
													<!--begin::Input group-->
													<div class="row mb-6">
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Remarks</label>
														<div class="col-lg-8 fv-row">	
																<div class="col-lg-12 fv-row">
																	<input type="text" name="remarks" class="form-control form-control-lg form-control-solid @error('remarks') is-invalid @enderror" placeholder="Remarks" value="{{ old('remarks', $category->remarks) }}" />
																    @error('remarks')<div class="invalid-feedback">{{ $message }}</div> @enderror
                                                                </div>
														</div>
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
