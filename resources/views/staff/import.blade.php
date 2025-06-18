@extends('layouts.admin')

@section('content')

    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            /* Hidden by default */
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.8);
            /* Optional: to dim the background */
            z-index: 9999;
            /* Ensure it appears above other content */
        }

        .loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #990a5e;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        .label-info-span a {
            font-size: 15px;
            display: block;
            color: #2196F3 !important;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">

            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid mt-15">
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
                                <h3 class="fw-bold m-0">Import Staff</h3>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Content-->
                        <div id="kt_account_settings_profile_details" class="collapse show">

                            @if (session('failures'))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach (session('failures') as $failure)
                                            <li>Row {{ $failure->row() }}: {{ implode(', ', $failure->errors()) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- Loader element -->
                            <div class="overlay" id="loaderOverlay">
                                <div class="loader"></div>
                            </div>


                            <!--begin::Form-->
                            <form id="importdata" class="form" method="POST" action="{{ route('staffs.importproceed') }}"
                                enctype="multipart/form-data" onsubmit="showLoader(event)">
                                @csrf
                                <!--begin::Card body-->

                                <div class="card-body border-top p-9">



                                    <!--begin::Input group-->
                                    <div class="row mb-0">


                                        <div class="col-lg-6 mb-6 fv-row">
                                            <label for="formFileSm" class="form-label">
                                                <span class="required">
                                                    Import File
                                                </span>
                                            </label>
                                            <input
                                                class="form-control form-control-lg @error('importstaff') is-invalid @enderror"
                                                name="importstaff" id="formFileSm" type="file" />
                                            @error('importstaff')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6  mt-12 fv-row">
                                            <span class="font-normal color-blue">[<a
                                                    href="{{ asset('Staff_Import_Sample.csv') }}" class="mt-2 color-blue">
                                                    <u>Download Sample Excel File </u></a>]</span>
                                        </div>
                                    </div>
                                    <!--end::Input group-->

                                </div>
                                <!--end::Card body-->
                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary"
                                        id="kt_account_profile_details_submit">Import</button>
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
            function showLoader() {
                document.getElementById('loaderOverlay').style.display = 'flex';
                // Let form submit as normal
            }
        </script>
    @endsection
