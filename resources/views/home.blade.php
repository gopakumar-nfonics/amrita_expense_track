@extends('layouts.admin')

<style>
.bottom {
        display: flex;
        justify-content: space-between; /* Distribute space between elements */
        align-items: center; /* Align elements vertically in the center */
    }
	
</style>
<style>
        .nav-scroll {
            overflow-x: auto;
            white-space: nowrap;
        }
        .nav-item {
            display: inline-block !important;
            vertical-align: top;
        }
    </style>
@section('content')
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Row-->
									<div class="row g-5 g-xl-10 mb-5 mb-xl-10">

									<!--begin::Col-->
									<div class="col-lg-12 mb-xl-0">
								
														<!--begin::Row-->
														<div class="row g-3 g-lg-6 mt-3">
															<!--begin::Col-->
															<div class="col-3">			
																<div class="bg-cyan bg-opacity-100 rounded-2 px-6 py-5 d-flex align-items-center">
																<div class="symbol symbol-50px me-5">
																	<i class="text-white fa-solid fa-graduation-cap fs-1 p-0 "></i>
																</div>
																<div class="d-flex justify-content-start flex-column">
																	<span class="text-white fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">199</span>
																	<span class="text-white fw-semibold d-block fs-7">Courses</span>
																</div>
																</div>
																
															</div>
															<!--end::Col-->
															<div class="col-3">
																<div class="bg-orange bg-opacity-100 rounded-2 px-6 py-5 d-flex align-items-center">
																<div class="symbol symbol-50px me-5">
																	<i class="text-white fa-solid fa-code-branch fa-rotate-90 fs-2x p-0 "></i>
																</div>
																<div class="d-flex justify-content-start flex-column">
																	<span class="text-white fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">66</span>
																	<span class="text-white fw-semibold d-block fs-7">Branches</span>
																</div>
																</div>
															</div>
															<!--end::Col-->
															<div class="col-3">
																<div class="bg-blue bg-opacity-100 rounded-2 px-6 py-5 d-flex align-items-center">
																<div class="symbol symbol-50px me-5">
																	<i class="text-white fa-solid fa-users fs-1 p-0 "></i>
																</div>
																<div class="d-flex justify-content-start flex-column">
																	<span class="text-white fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">765</span>
																	<span class="text-white fw-semibold d-block fs-7">Students</span>
																</div>
																</div>
															</div>
															<!--end::Col-->
															<div class="col-3">
																<div class="bg-green bg-opacity-100 rounded-2 px-6 py-5 d-flex align-items-center">
																<div class="symbol symbol-50px me-5">
																	<i class="text-white fa-solid fa-person-shelter fs-1 p-0 "></i>
																</div>
																<div class="d-flex justify-content-start flex-column">
																	<span class="text-white fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">234</span>
																	<span class="text-white fw-semibold d-block fs-7">Rooms</span>
																</div>
																</div>
															</div>
															<!--end::Col-->
												<!--end::Body-->
											</div>
											<!--end::Lists Widget 19-->
										</div>
										<!--end::Col-->
									<div class="col-lg-12  mb-5 mb-xl-0">
											<!--begin::Timeline widget 3-->
											<div class="card h-md-100">
												<!--begin::Header-->
												<div class="card-header border-0 pt-5">
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark">Upcoming Examinations</span>														
													</h3>
													<!--begin::Toolbar-->
													<div class="card-toolbar">
														<a href="" class="btn btn-sm bg-blue text-white">Allocation Center</a>
													</div>
													<!--end::Toolbar-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-4 px-0">
													<!--begin::Nav-->
													<div class="nav-scroll">
														<ul class="nav-stretch nav-pills nav-pills-custom nav-pills-active-custom d-flex mb-0 px-9">
																		<li class="nav-item p-0 ms-0 mb-3">
																			<!--begin::Date-->
																			<a class="d-flex flex-column flex-center min-w-45px py-4 px-3 span-calender" data-bs-toggle="tab" href="">
																			</a>
																			<!--end::Date-->
																		</li>
																	<li class="nav-item p-0 ms-0">
																		<!--begin::Date-->
																		<a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger" data-bs-toggle="tab" href="">
																		</a>
																		<!--end::Date-->
																	</li>
														</ul>
													</div>
													<!--end::Nav-->
													<!--begin::Tab Content (ishlamayabdi)-->

													
													<div class="tab-content mb-2 px-9 mt-5">
														<!--begin::Tap pane-->
														<div class="tab-pane fade show active" id="kt_timeline_widget_3_tab_content_1">
														<ul class="download-menu-item pl-0 mt-1 d-flex align-items-center justify-content-between me-0">
														<li class="align-left color-blue"><input type="checkbox" id="select-all" class="me-5"> Select All Rooms</li>    
														<div class="d-flex align-items-center disabled-links" id="disabled-links">
															<li>
																<a id="seat-allocation-link" class="color-green me-3"><i class="fa-solid fa-chair f-15 p-0 mr-1 color-green"></i><span class="menu-title px-2">Allocation List</span></a>
															</li> 
															<!-- <li>
																<a class="color-red me-3"><i class="fa-solid fa-user f-6 p-0 mr-1 color-red"></i><span class="menu-title px-2">Student List</span></a>
															</li>     -->
															<li>
																<a id="attendance-link" class="color-orange me-3"><i class="fa-solid fa-clipboard-user f-15 p-0 mr-1 color-orange"></i><span class="menu-title px-2">Attendance Sheet</span></a>
															</li> 
															<!--<li>
																<a id="question-paper-slip-link" class="color-blue me-3"><i class="fa-solid fa-note-sticky f-15 p-0 mr-1 color-blue"></i><span class="menu-title px-2">QP Slip</span></a>
															</li>    
															 <li><a class="color-red"><i class="fa-solid fa-clipboard-question f-15 p-0 mr-1 color-red"></i><span class="menu-title px-2">QPDS</span></a></li> -->
														</div>
													</ul>
						<div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 border-bottom border-top" id="scheduletable">
						<thead>
                                <tr class="fw-bold">
                                    <th class="no-sort color-blue"></th>
                                    <th class="min-w-200px"></th>
                                </tr>
                            </thead>
                            <tbody>
							
                                <tr class="schedule-row">
                                    <!-- New checkbox in each table row -->
                                    <td class="px-0">
										
									</td>
                                    <td class="pl-0">
									<div class="d-flex align-items-top w-100 mb-1 br5-pl-15">
															
										<!--begin::Info-->
										<div class="flex-grow-1 w-100 me-5">
										<!--begin::Time-->
										<div class="text-gray-800 fw-semibold fs-4">
											<i class="fa-solid fa-house fs-4 text-gray-800"></i>
											<span class="px-1">A301</span> | 

											<span class="text-gray-700 fw-semibold fs-5">
												<i class="fa-regular fa-calendar fs-5 text-gray-700 mx-2 me-0"></i>
												<span id=""> 12-02-2024</span>
												<span id="">
												<i class="fa-regular fa-clock fs-5 text-gray-700 mx-2 me-0"></i>
												9:30 - 12:30
												</span>
											</span>

											<div class="top-right">
												<ul class="px-0 mt-1 mb-1 text-left">
													<li class="view-title">
														<a href="#" id="" class="color-blue fs-7 me-0 view-allocation">
															<i class="fa-solid fa-people-arrows fs-7 p-0 mr-1 color-blue"></i>
															<span class="px-1">500 Students</span>|<span class=" px-1">4 Subjects</span>
														</a>					
													</li>    
													
												</ul>
											</div>
										</div>
										<!--end::Time-->
										<!--begin::Description-->
										<div class="text-gray-700 fw-semibold fs-6">
											Sem Exam
										</div>
											<!--end::Description-->
											<!--begin::Link-->
											<div class="text-gray-600 fw-semibold fs-7">
												<!--begin::Name-->
												<a href="#" class="text-gray-600 opacity-75-hover fw-semibold">
													
                                                </a>
												<!--end::Name-->
											
											</div>
												<!--end::Link-->
												
											</div>
																<!--end::Info-->
														
										</div>
                                    </td>
                                                                
                                </tr> 
							                              
                            </tbody>
                        </table>
                    </div>
															
														</div>
														<!--end::Tap pane-->
														
													</div>
													<!--end::Tab Content-->
													
												</div>
												<!--end: Card Body-->
											</div>
											<!--end::Timeline widget 3-->
											
										</div>
										
									
									</div>
									<!--end::Row-->
									
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer">
							<!--begin::Footer container-->
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<!--begin::Copyright-->
								
								<!--end::Copyright-->
								<!--begin::Menu-->
								
								<!--end::Menu-->
							</div>
							<!--end::Footer container-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
			<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen">
				<div class="modal-content">
					<div class="modal-header p-0">
						<!-- <h5 class="modal-title" id="exampleModalLabel">View Allocation</h5> -->
						<div class="card w-100">
								<div class="card-header border-0 pt-5">
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label fw-bold fs-3" id="exam-name"></span>
									</h3>
								</div>
							<div class="card-header min-h-10px border-0 mb-0 pb-0">
								<h3 class="card-title align-items-start flex-column" > 
									<span class="card-label fs-5 mb-1 text-gray-700" id="room-name"></span>
								</h3>
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fs-5 mb-1 text-gray-700" id="exam-date"></span>
								</h3>
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fs-5 mb-1 text-gray-700" id="exam-time"></span>
								</h3>
							</div>
						</div>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
					</div>
					<div class="modal-body p-0">
						<!-- Content will be loaded here -->
					</div>
				</div>
			</div>
			</div>
		</div>
		<!--end::App-->
		

@endsection	
