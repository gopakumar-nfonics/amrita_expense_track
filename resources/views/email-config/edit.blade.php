@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
	<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
		<!--begin::Toolbar container-->
		<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
			
		</div>
		<!--end::Toolbar container-->
	</div>
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-xxl">
			<!--begin::Form-->
			<form action="{{ route('email-config.update', $emailConfiguration) }}" method="POST" id="email_config_form" class="form d-flex flex-column flex-lg-row">
				@csrf
				@method('PUT')
				<!--begin::Main column-->
				<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
					<!--begin::General options-->
					<div class="card card-flush py-4">
						<!--begin::Card header-->
						<div class="card-header">
							<div class="card-title">
								<h2>Update Email Configuration Details</h2>
							</div>
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body border-top p-9">
							<!--begin::Input group-->
							<div class="mb-10 fv-row">
								<!--begin::Label-->
								<label class="form-label required">Email Type</label>
								<!--end::Label-->
								<!--begin::Input-->
								<select name="email_type" class="form-select mb-2" data-control="select2" data-hide-search="false" data-placeholder="Select email type" data-allow-clear="true">
									<option></option>
									<option value="budget_report" {{ old('email_type', $emailConfiguration->email_type) == 'budget_report' ? 'selected' : '' }}>Budget Report</option>
									<option value="expense_notification" {{ old('email_type', $emailConfiguration->email_type) == 'expense_notification' ? 'selected' : '' }}>Expense Notification</option>
									<option value="system_alerts" {{ old('email_type', $emailConfiguration->email_type) == 'system_alerts' ? 'selected' : '' }}>System Alerts</option>
									<option value="payment_updates" {{ old('email_type', $emailConfiguration->email_type) == 'payment_updates' ? 'selected' : '' }}>Payment Updates</option>
								</select>
								<!--end::Input-->
								<!--begin::Description-->
								<div class="text-muted fs-7">Select the type of email notifications this configuration will handle.</div>
								<!--end::Description-->
								@error('email_type')
									<div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="row mb-10">
								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="form-label required">Email Address</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="email" name="email_address" class="form-control mb-2" placeholder="Enter email address" value="{{ old('email_address', $emailConfiguration->email_address) }}">
									<!--end::Input-->
									<!--begin::Description-->
									<div class="text-muted fs-7">Enter a valid email address where notifications will be sent.</div>
									<!--end::Description-->
									@error('email_address')
										<div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="form-label required">Recipient Name</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="recipient_name" class="form-control mb-2" placeholder="Enter recipient name" value="{{ old('recipient_name', $emailConfiguration->recipient_name) }}">
									<!--end::Input-->
									<!--begin::Description-->
									<div class="text-muted fs-7">Enter the name of the person who will receive these emails.</div>
									<!--end::Description-->
									@error('recipient_name')
										<div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<!--end::Input group-->
							<!--begin::Hidden input for preserving current status-->
							<input type="hidden" name="is_active" value="{{ old('is_active', $emailConfiguration->is_active ? '1' : '0') }}">
							<!--end::Hidden input for preserving current status-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::General options-->
					<!--begin::Actions-->
					<div class="d-flex justify-content-end">
						<!--begin::Button-->
						<a href="{{ route('email-config.index') }}" id="email_config_cancel" class="btn btn-light me-5">Cancel</a>
						<!--end::Button-->
						<!--begin::Button-->
						<button type="submit" id="email_config_submit" class="btn btn-primary">
							<span class="indicator-label">Update</span>
							<span class="indicator-progress">Please wait...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
							</span>
						</button>
						<!--end::Button-->
					</div>
					<!--end::Actions-->
				</div>
				<!--end::Main column-->
			</form>
			<!--end::Form-->
		</div>
		<!--end::Content container-->
	</div>
</div>
@endsection

@section('pageScripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
	$(document).ready(function() {
		// Form validation
		$("#email_config_form").validate({
			rules: {
				email_type: {
					required: true
				},
				email_address: {
					required: true,
					email: true
				},
				recipient_name: {
					required: true,
					minlength: 2
				}
			},
			messages: {
				email_type: "Please select an email type",
				email_address: {
					required: "Please enter an email address",
					email: "Please enter a valid email address"
				},
				recipient_name: {
					required: "Please enter recipient name",
					minlength: "Recipient name must be at least 2 characters"
				}
			},
			submitHandler: function(form) {
				// Show loading state
				$("#email_config_submit").prop("disabled", true);
				$("#email_config_submit .indicator-label").hide();
				$("#email_config_submit .indicator-progress").show();
				
				form.submit();
			}
		});
	});
</script>

@if($errors->any())
<script>
	swal("Error!", "Please fix the validation errors and try again.", "error");
</script>
@endif
@endsection