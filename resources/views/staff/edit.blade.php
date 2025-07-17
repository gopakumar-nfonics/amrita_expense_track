@extends('layouts.admin')

@section('content')
    <style>
        .input-group-text {
            border: none !important;
        }
    </style>
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
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
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Edit Staff</h3>
                            </div>
                        </div>
                        <div id="kt_account_settings_profile_details" class="collapse show">
                            <form id="kt_account_profile_details_form" class="form" method="POST"
                                action="{{ route('staffs.update', $staffs->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Name</label>

                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="name"
                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 @error('name') is-invalid @enderror"
                                                placeholder="Name" value="{{ old('name', $staffs->name) }}" />
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                            Email
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="email"
                                                class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                                                placeholder="Email" value="{{ old('email', $staffs->email) }}" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            Password
                                        </label>
                                        <div class="col-lg-8 fv-row">
                                            <div class="input-group">
                                                <input type="password" id="password" name="password"
                                                    class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                                                    placeholder="Password" value="{{ old('password') }}" />
                                                <span class="input-group-text" onclick="togglePasswordVisibility()">
                                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            <span>Designation</span></label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <select name="designation" aria-label="Select Designation"
                                                class="form-select form-select-solid form-select-lg fw-semibold @error('designation') is-invalid @enderror">
                                                <option value="">--Select Designation--</option>
                                                @foreach ($designation as $designation)
                                                    <option value="{{ $designation->id }}"
                                                        @if (old('designation', $staffs->designation_id) == $designation->id) selected @endif>
                                                        {{ $designation->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('designation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary"
                                        id="kt_account_profile_details_submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
