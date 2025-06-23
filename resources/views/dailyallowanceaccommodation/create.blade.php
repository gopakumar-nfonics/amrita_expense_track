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
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Configure DA & Accommodation
                        </h1>
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

                        <div id="kt_account_settings_profile_details" class="collapse show">
                            <!--begin::Form-->
                            <form id="kt_account_profile_details_form" class="form" method="POST"
                                action="{{ route('dailyallowanceaccommodation.store') }}" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body border-top p-9">

                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                            Designation
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <select name="designation"
                                                class="form-select form-select-solid form-select-lg fw-semibold @error('designation') is-invalid @enderror">
                                                <option value="">--Select Designation--</option>
                                                @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}"
                                                        @if (old('designation') == $designation->id) selected @endif>
                                                        {{ $designation->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('designation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                            City Tier
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <select name="tier"
                                                class="form-select form-select-solid form-select-lg fw-semibold @error('tier') is-invalid @enderror">
                                                <option value="">--Select City Tier--</option>
                                                @foreach ($tiers as $tier)
                                                    <option value="{{ $tier->id }}"
                                                        @if (old('tier') == $tier->id) selected @endif>
                                                        {{ $tier->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('tier')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                            Allowance Amount
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    &#8377;
                                                </span>
                                                <input type="number" name="allowance_amount"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('allowance_amount') is-invalid @enderror"
                                                    placeholder="Allowance Amount" value="{{ old('allowance_amount') }}" />
                                            </div>
                                            @error('allowance_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                            Accommodation Amount
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    &#8377;
                                                </span>
                                                <input type="number" name="accommodation_amount"
                                                    class="form-control form-control-lg form-control-solid @error('accommodation_amount') is-invalid @enderror"
                                                    placeholder="Accommodation Amount"
                                                    value="{{ old('accommodation_amount') }}" />
                                            </div>
                                            @error('accommodation_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <!--end::Card body-->
                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
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
