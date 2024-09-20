 @extends('layouts.blank')


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
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
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
                        <form id="kt_account_profile_details_form" class="form" method="POST"
                            action="{{route('profileupdate')}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="vid" value="{{ old('vid', $vendor['id']) }}" />
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <div class="d-flex flex-column gap-5 gap-md-7">
                                    <!--begin::Title-->
                                    <div class="separator separator-solid mt-5 mb-4 blue-border-bottom"><label
                                            class="form-label legend-label">Business Information</label></div>
                                    <!--end::Title-->


                                    <!--begin::Input group-->
                                    <div class="row mb-6">

                                        <!--begin::Label-->
                                        <label class="col-lg-2 col-form-label required fw-semibold fs-6">Name</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-4 fv-row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row">
                                                <input type="text" name="name"
                                                    class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                                                    placeholder="Name"
                                                    value="{{ old('name', $vendor['vendor_name']) }}" />
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Label-->
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">Organisation</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-4 fv-row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row">
                                                <input type="text" name="company"
                                                    class="form-control form-control-lg form-control-solid @error('company') is-invalid @enderror"
                                                    placeholder="Organisation"
                                                    value="{{ old('company', $companies['company_name'] ?? '') }}" />
                                                @error('company')<div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Col-->

                                    </div>


                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-2 col-form-label fw-semibold fs-6">Email</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-4 fv-row">
                                            <!--begin::Col-->
                                            <div class="col-lg-12 fv-row">
                                                <input type="text" name="email"
                                                    class=" border-0 w-100 disabled-input fs-3 py-2 text-muted @error('email') is-invalid @enderror"
                                                    placeholder="Email" value="{{ old('email', $vendor['email']) }}"
                                                    readonly />
                                                @error('email')<div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                <input type="text" name="phone"
                                                    class="form-control form-control-lg form-control-solid @error('phone') is-invalid @enderror"
                                                    placeholder="Phone Number"
                                                    value="{{ old('phone', $vendor['phone']) }}" />
                                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                <input type="text" name="gst"
                                                    class="form-control form-control-lg form-control-solid @error('gst') is-invalid @enderror"
                                                    placeholder="GST #" value="{{ old('gst', $vendor['gst']) }}" />
                                                @error('gst')<div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
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
                                                <input type="text" name="pan"
                                                    class="form-control form-control-lg form-control-solid @error('pan') is-invalid @enderror"
                                                    placeholder="PAN #" value="{{ old('pan', $vendor['pan']) }}" />
                                                @error('pan')<div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                    </div>

                                    <!--end::Input group-->

                                </div>
                                <div class="d-flex flex-column gap-5 gap-md-7">
                                    <!--begin::Title-->
                                    <div class="separator separator-solid my-10 blue-border-bottom"><label
                                            class="form-label legend-label">Address Information</label></div>
                                    <!--end::Title-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column flex-md-row gap-5">
                                        <div class="fv-row flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="required form-label">Contact Person</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('cn_person') is-invalid @enderror"
                                                name="cn_person" placeholder="Contact Person"
                                                value="{{ old('cn_person', $vendor['contact_person']) }}" />
                                            @error('cn_person')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <div class="fv-row flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="required form-label">Address Line 1</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('address') is-invalid @enderror"
                                                name="address" placeholder="Address Line 1"
                                                value="{{ old('address', $vendor['address']) }}" />
                                            @error('address')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <div class="flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="form-label">Address Line 2</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('address_2') is-invalid @enderror"
                                                name="address_2" placeholder="Address Line 2"
                                                value="{{ old('address_2', $vendor['address_2']) }}" />
                                            @error('address_2')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column flex-md-row gap-5">
                                        <div class="flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="required form-label">City</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('city') is-invalid @enderror
" name="city" placeholder="" value="{{ old('city', $vendor['city']) }}" />

                                            @error('city')<div class="invalid-feedback">{{ $message }}</div> @enderror

                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="required form-label">State</label>
                                            <!--end::Label-->
                                            <select
                                                class="form-control form-control-lg form-control-solid @error('state') is-invalid @enderror"
                                                id="state" name="state">
                                                <option value="">--Select State--</option>
                                                @foreach($states as $state)
                                                <option value="{{ $state->id }}" @if(old('state',$vendor->state) ==
                                                    $state->id) selected @endif>{{ $state->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="fv-row flex-row-fluid w-100px">
                                            <!--begin::Label-->
                                            <label class="required form-label">Postcode</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('postcode') is-invalid @enderror
" name="postcode" placeholder="" value="{{ old('postcode', $vendor['postcode']) }}" />

                                            @error('postcode')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                    </div>




                                </div>


                                <div class="d-flex flex-column gap-5 gap-md-7 mt-5">
                                    <!--begin::Title-->
                                    <div class="separator separator-solid my-10 blue-border-bottom"><label
                                            class="form-label legend-label">Bank Account Details</label></div>
                                    <!--end::Title-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column flex-md-row gap-5">
                                        <div class="fv-row flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="required form-label">Bank Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('bank_name') is-invalid @enderror"
                                                name="bank_name" placeholder="Bank Name"
                                                value="{{ old('bank_name', $account_details['bank_name'] ?? '') }}" />
                                            @error('bank_name')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <div class="flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="form-label required">Branch Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('branch_name') is-invalid @enderror"
                                                name="branch_name" placeholder="Branch Name"
                                                value="{{ old('branch_name', $account_details['branch_name'] ?? '') }}" />
                                            @error('branch_name')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column flex-md-row gap-5">
                                        <div class="flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="required form-label">Beneficiary Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('beneficiary_name') is-invalid @enderror
" name="beneficiary_name" placeholder="Beneficiary Name"
                                                value="{{ old('beneficiary_name', $account_details['beneficiary_name'] ?? '') }}" />

                                            @error('beneficiary_name')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <!--end::Input-->
                                        </div>

                                        <div class="flex-row-fluid">
                                            <!--begin::Label-->
                                            <label class="required form-label">Account Number</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('account_no') is-invalid @enderror
" name="account_no" placeholder="Account Number"
                                                value="{{ old('account_no', $account_details['account_no'] ?? '') }}" />

                                            @error('account_no')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <!--end::Input-->
                                        </div>

                                        <div class="fv-row flex-row-fluid w-100px">
                                            <!--begin::Label-->
                                            <label class="required form-label">IFSC Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control @error('ifsc_code') is-invalid @enderror
" name="ifsc_code" placeholder="IFSC Code" value="{{ old('ifsc_code', $account_details['ifsc_code'] ?? '') }}" />

                                            @error('ifsc_code')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                    </div>




                                </div>
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('dashboard') }}" id="kt_ecommerce_edit_order_cancel"
                                    class="btn btn-light me-5">Cancel</a>
                                <button type="submit" class="btn btn-primary"
                                    id="kt_account_profile_details_submit">Save</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const useCompanyDetailsCheckbox = document.querySelector('input[name="use_company_details"]');
        const companySelect = document.getElementById('company');

        useCompanyDetailsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                const selectedOption = companySelect.options[companySelect.selectedIndex];
                document.querySelector('input[name="email"]').value = selectedOption.getAttribute(
                    'data-email');
                document.querySelector('input[name="phone"]').value = selectedOption.getAttribute(
                    'data-phone');
                document.querySelector('input[name="gst"]').value = selectedOption.getAttribute(
                    'data-gst');
                document.querySelector('input[name="pan"]').value = selectedOption.getAttribute(
                    'data-pan');
                document.querySelector('textarea[name="address"]').value = selectedOption.getAttribute(
                    'data-address');
            } else {
                // Optionally clear the fields if the checkbox is unchecked
                document.querySelector('input[name="email"]').value = '';
                document.querySelector('input[name="phone"]').value = '';
                document.querySelector('input[name="gst"]').value = '';
                document.querySelector('input[name="pan"]').value = '';
                document.querySelector('textarea[name="address"]').value = '';
            }
        });
    });
    </script>
    @endsection