@extends('layouts.admin')

@section('content')



<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid mt-10">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!--begin::Basic info-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0 d-flex flex-column">
                            <h3 class="fw-bold m-0 my-0 mt-10">Support Center | Tutorial Videos</h3>
                            <p class="my-0 fs-7 text-muted br-b-1 pt-3 pb-2 mb-10">
                                Get a complete walkthrough of the features in our application.
                                These tutorial videos will guide you through setting budgets, managing payments, and
                                maximizing the app’s powerful tools for better financial control!
                            </p>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="p-10 pt-0">
                    @if(Auth::user()->isvendor())
                        <div class="video-container">
                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/vendor/signup.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Sign Up</h5>
                                <span class="description text-muted">Create your account effortlessly with our
                                    step-by-step guide.</span>
                            </div>
                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/vendor/proposal.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Proposal Submission </h5>
                                <span class="description text-muted">Submit your proposal effortlessly with our
                                    step-by-step guide.</span>
                            </div>

                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/vendor/invoice.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Invoice Submission</h5>
                                <span class="description text-muted">Submit your Invoice effortlessly with our
                                    step-by-step guide.</span>
                            </div>


                        </div>
                        <!--end::Basic info-->
                    </div>
                    <!--end::Content container-->
                    @else
                    <div class="video-container">
                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/vendor/signup.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">vendor Sign Up</h5>
                                <span class="description text-muted">Streamline the account creation process with our 
                                    comprehensive step-by-step guide for Vendors.</span>
                                    
                            </div>
                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/vendor/proposal.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">vendor proposal submission </h5>
                                <span class="description text-muted">Streamline the proposal submission process with our 
                                comprehensive step-by-step guide for Vendors.</span>
                            </div>

                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/vendor/invoice.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Vendor Invoice Submission </h5>
                                <span class="description text-muted">Streamline the Invoice Submission process with our 
                                comprehensive step-by-step guide for Vendors.</span>
                            </div>

                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin vendor report.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Vendor Report</h5>
                                <span class="description text-muted">Download your vendor report easily with 
                                    our step-by-step guide for admin.</span>
                            </div>

                        
                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin program report.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Programme Report</h5>
                                <span class="description text-muted">Download your programme report easily 
                                    with our step-by-step guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin budget report.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Budget Report</h5>
                                <span class="description text-muted">Download your budget report easily 
                                    with our step-by-step guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin payments.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Payments</h5>
                                <span class="description text-muted">Manage payments seamlessly with our 
                                    step-by-step  guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin invoice.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Invoice</h5>
                                <span class="description text-muted">Manage invoice seamlessly with our 
                                step-by-step  guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin proposal.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Proposal</h5>
                                <span class="description text-muted">Manage Proposal seamlessly with our 
                                step-by-step guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin vendor.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Vendor</h5>
                                <span class="description text-muted">Effortlessly onboard vendors with our
                                     step-by-step guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin budget.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Budget Allocation</h5>
                                <span class="description text-muted">Allocate your budget effortlessly with
                                     our step-by-step guide for admin.</span>
                            </div>

                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin category.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Category</h5>
                                <span class="description text-muted">Manage categories effortlessly
                                     with our step-by-step guide for admin.</span>
                            </div>

                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin program.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Programme</h5>
                                <span class="description text-muted">Effortlessly manage programme with our 
                                    step-by-step guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin campus.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Campus</h5>
                                <span class="description text-muted">Manage campus effortlessly 
                                    with our step-by-step guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin department.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">Department</h5>
                                <span class="description text-muted">Effortlessly manage department with
                                     our step-by-step guide for admin.</span>
                            </div>


                            <div class="video-tile">
                                <!-- Video Tile 1 -->
                                <div>
                                    <!-- Loader element -->
                                    <video width="100%" height="100%" controls>
                                        <source src="{{ asset('assets/media/videos/admin/admin user.mp4') }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <!--end::Content-->
                                <h5 class="title mt-3">User</h5>
                                <span class="description text-muted">Easily manage user profiles 
                                    with our step-by-step guide for admin.</span>
                            </div>

                        </div>
                        <!--end::Basic info-->
                    </div>
                    <!--end::Content container-->
                @endif


                </div>
                <!--end::Content-->

            </div>
            <!--end::Content wrapper-->



            @endsection