@extends('modules.Staff.layouts.staff')

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
                <div class="row g-5 g-xl-10 mb-0 px-5 ">


                    <div class="card mb-5">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-10">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Staff Statistics</span>
                                <span class="text-muted mt-1 fw-semibold fs-7"></span>
                            </h3>
                            <!--begin::Card toolbar-->
                            <div class="ms-1">
                                <a type="button" title="View Report" href="{{route('vendorreport')}}"
                                    class="btn btn-sm btn-icon color-blue btn-active-primary btn-active-color-white border-0 me-n3">
                                    <i class="fa-solid fa-arrow-right fs-4"></i>
                                </a>
                            </div>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-0">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                                    id="vendor-table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bold text-muted">

                                            <th class="min-w-300px">Vendor</th>
                                            <th class="min-w-150px">Total</th>
                                            <th class="min-w-150px">Paid</th>
                                            <th class="min-w-150px">Balance</th>
                                            <th class="min-w-100px">Payment (%)</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                       
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>




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
                        <h3 class="card-title align-items-start flex-column">
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