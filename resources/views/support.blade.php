@extends('layouts.admin')

@section('content')



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
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bold m-0 my-7 mt-10">Tutorial Video</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="p-10 pt-0">

                             
                                       <!-- Loader element -->
									   <video width="100%" height="" controls>
                                            <source src="{{ asset('EMS_Tutorial.mp4') }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
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
