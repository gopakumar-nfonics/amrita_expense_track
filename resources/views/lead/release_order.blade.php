<style>
.certificate-container {
    background-color: #fff;
    border: 8px solid #ffa400;
    padding: 40px;
    width: 900px;
    height: 590px;
    text-align: center;
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.6);
    /* Inner shadow */
    margin: 0px auto;
    overflow: hidden;
}

.certificate-header {
    font-family: 'Felix Titling', serif;
    /* Use the Felix Titling font */
    font-size: 56px;
    margin-bottom: 10px;
    letter-spacing: 8px;
}

.certificate-header-first {
    font-family: 'Felix Titling', serif;
    font-size: 20px;
    margin: 0px !important;
    letter-spacing: 1px;
    margin-bottom: 10px !important;
    color: #ea0029 !important;
    font-weight: 600;
    margin-top: 40px !important;
}

.certificate-header-second {
    font-family: 'Felix Titling', serif;
    /* Use the Felix Titling font */
    font-size: 34px;
    margin-top: 0px !important;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    text-transform: uppercase;
}

.header-border {
    width: 30%;
    height: 2px;
    background-color: #ffa400;
    margin: 0 auto 20px auto;
}

.certificate-body {
    font-size: 18px;
    margin-bottom: 20px;
}

.certificate-footer {
    font-size: 16px;
}

.recipient-name {
    font-family: 'Great Vibes', cursive;
    font-size: 40px;
    margin: 15px 0px 0px;
    padding: 0px;
}

.recipient-border {
    width: 70%;
    height: 2px;
    margin: 0 auto;
    border-bottom: 2px dotted #ffa400;
    margin-top: -30px;
}

.txt-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    text-transform: uppercase;
}

.course-details {
    text-transform: uppercase;
}
</style>



<div class="certificate-container">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- begin::Invoice 3-->
            <div class="card">
                <!-- begin::Body-->
                <div class="card-body py-10">
                    <!-- begin::Wrapper-->
                    <div class="mw-lg-950px mx-auto w-100 my-0 py-0" id="printableArea">
                        <!-- begin::Header-->
                        <div class="flex-sm-row mb-2">
                            <!--end::Logo-->
                            <div class="text-sm-start">
                                <!--begin::Logo-->
                                <a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                    <img alt="Logo" src="{{ url('/') }}/assets/media/logos/avv-head-logo.jpg"
                                        class="w-100">
                                </a>
                                <!--end::Logo-->

                            </div>

                            <div class="text-center py-0 mb-5 mt-10">
                                <!--begin::Logo-->
                                <span class="fs-3 text-gray-700"><u>RELEASE ORDER</u></span>

                            </div>
                            <!--begin::Text-->
                            <div class="d-flex  justify-content-between text-sm-start fw-semibold fs-7 text-muted">
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-bold text-hover-primary fs-4">RO#:
                                        {{$proposal->proposalro->proposal_ro}}</span>

                                </div>
                                <div class="d-flex flex-column">

                                    <span
                                        class="fs-5 text-gray-700">{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>
                                </div>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="pb-2">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column ">

                                <!--begin::Separator-->
                                <div class="separator mb-7"></div>
                                <!--begin::Separator-->


                                <!--begin::Billing & shipping-->
                                <div class="d-flex flex-column flex-sm-row  fw-bold">
                                    <div class="flex-root d-flex flex-column txt-uppercase">
                                        <span class="fs-6 text-gray-700 fw-bold ">To</span>
                                        <div class="m-5"><span>{{$proposal->vendor->contact_person}}</span>
                                            </br>{{$proposal->vendor->vendor_name}}
                                        </div>
                                    </div>

                                </div>

                                <!--begin::Billing & shipping-->
                                <div class="d-flex flex-column flex-sm-row  fw-bold mt-5">
                                    <div class="flex-root d-flex flex-column txt-uppercase">
                                        <span class="fs-6 text-gray-700 fw-bold ">SUBJECT</span>
                                        <div class="m-5 text-gray-500 ">Issue of Release order for <span
                                                class="fs-5 text-gray-800 ">{{$proposal->proposal_title}}</span>
                                        </div>
                                    </div>

                                </div>

                                <!--begin::Billing & shipping-->
                                <div class="d-flex flex-column flex-sm-row  fw-bold mt-5">
                                    <div class="flex-root d-flex flex-column">
                                        <span class="fs-6 text-gray-700 fw-bold txt-uppercase">Scope &
                                            Services</span>
                                        <div class="m-5"> {!! $proposal->proposal_description !!}
                                        </div>
                                    </div>

                                </div>
                                <!--end::Billing & shipping-->
                                <!--begin:Order summary-->
                                <div class="d-flex justify-content-between flex-column">
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-5 pb-3 mt-5">
                                        <div>
                                            <span
                                                class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2 txt-uppercase">Outlay
                                                :</span>
                                            <span
                                                class="fs-1 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                            <span id="total-cost-span"
                                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                                                data-kt-element="sub-total">{{$proposal->proposal_total_cost}}<div
                                                    id="kt_app_content" class="app-content flex-column-fluid">
                                                    <!--begin::Content container-->
                                                    <div id="kt_app_content_container"
                                                        class="app-container container-xxl">
                                                        <!-- begin::Invoice 3-->
                                                        <div class="card">
                                                            <!-- begin::Body-->
                                                            <div class="card-body py-10">
                                                                <!-- begin::Wrapper-->
                                                                <div class="mw-lg-950px mx-auto w-100 my-0 py-0"
                                                                    id="printableArea">
                                                                    <!-- begin::Header-->
                                                                    <div class="flex-sm-row mb-2">
                                                                        <!--end::Logo-->
                                                                        <div class="text-sm-start">
                                                                            <!--begin::Logo-->
                                                                            <a href="#"
                                                                                class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                                                                <img alt="Logo"
                                                                                    src="{{ url('/') }}/assets/media/logos/avv-head-logo.jpg"
                                                                                    class="w-100">
                                                                            </a>
                                                                            <!--end::Logo-->

                                                                        </div>

                                                                        <div class="text-center py-0 mb-5 mt-10">
                                                                            <!--begin::Logo-->
                                                                            <span class="fs-3 text-gray-700"><u>RELEASE
                                                                                    ORDER</u></span>

                                                                        </div>
                                                                        <!--begin::Text-->
                                                                        <div
                                                                            class="d-flex  justify-content-between text-sm-start fw-semibold fs-7 text-muted">
                                                                            <div class="d-flex flex-column">
                                                                                <span
                                                                                    class="text-dark fw-bold text-hover-primary fs-4">RO#:
                                                                                    {{$proposal->proposalro->proposal_ro}}</span>

                                                                            </div>
                                                                            <div class="d-flex flex-column">

                                                                                <span
                                                                                    class="fs-5 text-gray-700">{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <!--end::Text-->
                                                                    </div>
                                                                    <!--end::Header-->
                                                                    <!--begin::Body-->
                                                                    <div class="pb-2">
                                                                        <!--begin::Wrapper-->
                                                                        <div class="d-flex flex-column ">

                                                                            <!--begin::Separator-->
                                                                            <div class="separator mb-7"></div>
                                                                            <!--begin::Separator-->


                                                                            <!--begin::Billing & shipping-->
                                                                            <div
                                                                                class="d-flex flex-column flex-sm-row  fw-bold">
                                                                                <div
                                                                                    class="flex-root d-flex flex-column txt-uppercase">
                                                                                    <span
                                                                                        class="fs-6 text-gray-700 fw-bold ">To</span>
                                                                                    <div class="m-5">
                                                                                        <span>{{$proposal->vendor->contact_person}}</span>
                                                                                        </br>{{$proposal->vendor->vendor_name}}
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <!--begin::Billing & shipping-->
                                                                            <div
                                                                                class="d-flex flex-column flex-sm-row  fw-bold mt-5">
                                                                                <div
                                                                                    class="flex-root d-flex flex-column txt-uppercase">
                                                                                    <span
                                                                                        class="fs-6 text-gray-700 fw-bold ">SUBJECT</span>
                                                                                    <div class="m-5 text-gray-500 ">
                                                                                        Issue of Release order for <span
                                                                                            class="fs-5 text-gray-800 ">{{$proposal->proposal_title}}</span>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <!--begin::Billing & shipping-->
                                                                            <div
                                                                                class="d-flex flex-column flex-sm-row  fw-bold mt-5">
                                                                                <div
                                                                                    class="flex-root d-flex flex-column">
                                                                                    <span
                                                                                        class="fs-6 text-gray-700 fw-bold txt-uppercase">Scope
                                                                                        &
                                                                                        Services</span>
                                                                                    <div class="m-5"> {!!
                                                                                        $proposal->proposal_description
                                                                                        !!}
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <!--end::Billing & shipping-->
                                                                            <!--begin:Order summary-->
                                                                            <div
                                                                                class="d-flex justify-content-between flex-column">
                                                                                <!--begin::Table-->
                                                                                <div
                                                                                    class="table-responsive border-bottom mb-5 pb-3 mt-5">
                                                                                    <div>
                                                                                        <span
                                                                                            class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2 txt-uppercase">Outlay
                                                                                            :</span>
                                                                                        <span
                                                                                            class="fs-1 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                                                                                        <span id="total-cost-span"
                                                                                            class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                                                                                            data-kt-element="sub-total">{{$proposal->proposal_total_cost}}
                                                                                        </span>
                                                                                        <span>[Inclusive of GST]</span>

                                                                                        <div
                                                                                            class="text-muted fs-5 text-gray-600">
                                                                                            Rupees
                                                                                            {{$amounwords}}
                                                                                            rupees only.</div>
                                                                                    </div>


                                                                                </div>
                                                                                <!--end::Table-->
                                                                            </div>
                                                                            <!--end:Order summary-->
                                                                        </div>
                                                                        <!--end::Wrapper-->
                                                                    </div>
                                                                    <!--end::Body-->


                                                                    <!--begin:Order summary-->
                                                                    <div
                                                                        class="d-flex justify-content-between flex-column">
                                                                        <!--begin::Table-->
                                                                        <div class="table-responsive mb-5">
                                                                            <span
                                                                                class="fs-5 text-gray-700 txt-uppercase pb-4"><u>Billing
                                                                                    Address</u></span>
                                                                            <address class="mt-3">
                                                                                DIRECTORATE OF ADMISSIONS,
                                                                                <br>AMRITA SCHOOL OF ENGINEERING,
                                                                                AMRITA VISHWA VIDYAPEETHAM, AMRITA
                                                                                NAGAR(PO),
                                                                                ETTIMADAI, COIMBATORE - 641112

                                                                            </address>


                                                                        </div>
                                                                        <!--end::Table-->
                                                                    </div>

                                                                    <!--begin:Order summary-->
                                                                    <div
                                                                        class="d-flex justify-content-between flex-column">
                                                                        <!--begin::Table-->
                                                                        <div class="table-responsive mb-9">
                                                                            <span
                                                                                class="fs-5 text-gray-700 txt-uppercase "><u>Notes</u></span>
                                                                            <ul class="list-disc mt-4">
                                                                                <li>Mandate to include RO No. and Bank
                                                                                    details, billing address (mentioned
                                                                                    above) on
                                                                                    the
                                                                                    invoice copies.</li>
                                                                                <li>Payment will be release monthly, up
                                                                                    on submission of the tax invoice.
                                                                                </li>
                                                                                <li>Payout period is minimum of 14
                                                                                    working days</li>
                                                                            </ul>

                                                                        </div>
                                                                        <!--end::Table-->
                                                                    </div>


                                                                    <!--end:Order summary-->
                                                                    <div class="text-sm-start">
                                                                        <!--begin::Logo-->
                                                                        <a href="#"
                                                                            class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                                                            <img alt="Logo"
                                                                                src="{{ url('/') }}/assets/media/logos/avv-sign.jpg"
                                                                                class="w-100">
                                                                        </a>
                                                                        <!--end::Logo-->

                                                                    </div>

                                                                    <!--end:Order summary-->
                                                                    <div class="text-sm-start">
                                                                        <!--begin::Logo-->
                                                                        <a href="#"
                                                                            class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                                                            <img alt="Logo"
                                                                                src="{{ url('/') }}/assets/media/logos/avv-footer-logo.jpg"
                                                                                class="w-100">
                                                                        </a>
                                                                        <!--end::Logo-->

                                                                    </div>
                                                                </div>
                                                                <!-- end::Wrapper-->
                                                            </div>
                                                            <!-- end::Body-->
                                                        </div>
                                                        <!-- end::Invoice 1-->
                                                    </div>
                                                    <!--end::Content container-->
                                                </div>
                                            </span>
                                            <span>[Inclusive of GST]</span>

                                            <div class="text-muted fs-5 text-gray-600">Rupees
                                                {{$amounwords}}
                                                rupees only.</div>
                                        </div>


                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end:Order summary-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->


                        <!--begin:Order summary-->
                        <div class="d-flex justify-content-between flex-column">
                            <!--begin::Table-->
                            <div class="table-responsive mb-5">
                                <span class="fs-5 text-gray-700 txt-uppercase pb-4"><u>Billing Address</u></span>
                                <address class="mt-3">
                                    DIRECTORATE OF ADMISSIONS,
                                    <br>AMRITA SCHOOL OF ENGINEERING,
                                    AMRITA VISHWA VIDYAPEETHAM, AMRITA NAGAR(PO),
                                    ETTIMADAI, COIMBATORE - 641112

                                </address>


                            </div>
                            <!--end::Table-->
                        </div>

                        <!--begin:Order summary-->
                        <div class="d-flex justify-content-between flex-column">
                            <!--begin::Table-->
                            <div class="table-responsive mb-9">
                                <span class="fs-5 text-gray-700 txt-uppercase "><u>Notes</u></span>
                                <ul class="list-disc mt-4">
                                    <li>Mandate to include RO No. and Bank details, billing address (mentioned above) on
                                        the
                                        invoice copies.</li>
                                    <li>Payment will be release monthly, up on submission of the tax invoice.</li>
                                    <li>Payout period is minimum of 14 working days</li>
                                </ul>

                            </div>
                            <!--end::Table-->
                        </div>


                        <!--end:Order summary-->
                        <div class="text-sm-start">
                            <!--begin::Logo-->
                            <a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                <img alt="Logo" src="{{ url('/') }}/assets/media/logos/avv-sign.jpg" class="w-100">
                            </a>
                            <!--end::Logo-->

                        </div>

                        <!--end:Order summary-->
                        <div class="text-sm-start">
                            <!--begin::Logo-->
                            <a href="#" class="d-block w-100 fs-1 ms-sm-auto mb-2 color-blue">
                                <img alt="Logo" src="{{ url('/') }}/assets/media/logos/avv-footer-logo.jpg"
                                    class="w-100">
                            </a>
                            <!--end::Logo-->

                        </div>
                    </div>
                    <!-- end::Wrapper-->
                </div>
                <!-- end::Body-->
            </div>
            <!-- end::Invoice 1-->
        </div>
        <!--end::Content container-->
    </div>

    <!-- <div class="certificate-header">
		<p class="certificate-header-first">HOME STYLE FRIED CHICKEN</p>
            <span class="txt-shadow">Certificate</span><p class="certificate-header-second">of Completion</p>
			</p>
        </div>
		 <div class="header-border"></div>
        <div class="certificate-body">
		
		OUR COMPANY IS PLEASED <br>TO BE ABLE TO AWARD THIS CERTIFICATE TO
		<P class="recipient-name">Gopakumar<p>
		<div class="recipient-border"></div>
		
			<P class="course-details">upon the successful completion of the course <strong><u>Proposal</u></strong> ON <p>
          </div>
     
	 <table style="width:90%;margin:80px auto 0px;">
	 <tr><td style="width:30%;text-align:center;"><strong>Nfonics</strong><p class="name">[Instructor]</p></td><td style="width:30%;text-align:center;"><img src="http://friedchickenuniversity.com/assets/assets/images/logo.png" style="height:100px;"></td><td style="width:30%;text-align:center;"><strong>James Rogers</strong><p class="name">[Administrator]</p></td></tr>
	 </table> -->

</div>