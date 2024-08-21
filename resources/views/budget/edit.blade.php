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
							<h3 class="fw-bold m-0">Edit Budget</h3>
						</div>
						<!--end::Card title-->
					</div>
					<!--begin::Card header-->
					<!--begin::Content-->
					<div id="kt_account_settings_profile_details" class="collapse show">
						<!--begin::Form-->
						<form id="kt_account_profile_details_form" class="form" method="POST" action="{{route('budget.update',$budget->id)}}" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<!--begin::Card body-->
							<div class="card-body border-top p-9">
								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label required fw-semibold fs-6">Financial Year</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<select class="form-control form-control-lg form-control-solid @error('financialyear') is-invalid @enderror" id="financialyear" name="financialyear">
											<option value="">--Select Year--</option>
											@foreach($financialyears as $years)
											<option value="{{ $years->id }}" @if(old('financialyear',$budget->financial_year_id) == $years->id) selected @endif>{{ $years->year }}</option>
											@endforeach
										</select>
										@error('financialyear')<div class="invalid-feedback">{{ $message }}</div>@enderror
									</div>
									<!--end::Col-->
								</div>
								<!--begin::Input group-->

								<!--end::Input group-->
								<div class="row mb-6">
									<!--begin::Label-->
									<label class="col-lg-4 col-form-label required fw-semibold fs-6">Category</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<select class="form-control form-control-lg form-control-solid @error('category') is-invalid @enderror" id="category" name="category">
											<option value="">--Select Category--</option>
											@foreach($category as $cat)
											<option value="{{ $cat->id }}" @if(old('category',$budget->category_id) == $cat->id) selected @endif>{{ $cat->category_name }}</option>
											@endforeach
										</select>
										@error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
									</div>
									<!--end::Col-->
								</div>
								<div class="row mb-6">
									<!--begin::Col-->
									<label class="col-lg-4 col-form-label required fw-semibold fs-6">Amount</label>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-lg-8">
										<!--begin::Dialer-->
										<div class="position-relative w-md-300px" data-kt-dialer="true" data-kt-dialer-prefix="&#x20b9; " data-kt-dialer-decimals="0">
											<!--begin::Decrease control-->
											<button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
												<!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
												<span class="svg-icon svg-icon-1">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"></rect>
														<rect x="6.0104" y="10.9247" width="12" height="2" rx="1" fill="currentColor"></rect>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</button>
											<!--end::Decrease control-->
											<!--begin::Input control-->
											<input type="text"
												class="form-control form-control-solid border-0 ps-12 @error('amount') is-invalid @enderror"
												data-kt-dialer-control="input"
												placeholder="Amount"
												name="amount"
												value="{{ old('amount', $budget->amount) }}">

											@error('amount')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror


											<!--end::Input control-->
											<!--begin::Increase control-->
											<button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
												<!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
												<span class="svg-icon svg-icon-1">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"></rect>
														<rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor"></rect>
														<rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor"></rect>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</button>
											<!--end::Increase control-->
										</div>
										<!--end::Dialer-->
									</div>
									<!--end::Col-->
								</div>
								<div class="row mb-6">
									<!--begin::Col-->
									<div class="col-lg-4">
										<div class="fs-6 fw-semibold mt-2 mb-3">Notes</div>
									</div>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-lg-8">
										<textarea name="notes" class="form-control form-control-solid" rows="5">{{ old('notes', $budget->notes) }}</textarea>
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