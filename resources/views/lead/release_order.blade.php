<style>
* {
    font-size: 15px;
}

.ro-container-a4-page {
    width: 694px;
    /* width for legal page */
    height: 1023px;
    /* height for legal page */
    margin: 0 auto;
    background-color: #fff;
    text-align: center;
    position: relative;
    padding: 0px;
}

.certificate-header {}



.header-border {
    width: 100%;
    height: 1px;
    background-color: #ccc;
    margin: 5px auto 5px auto;
}

.certificate-body {
    font-size: 18px;
    margin-bottom: 20px;
}

.certificate-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
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
    text-t ransform: uppercase;
}

.header-logo {
    width: 100%;
}

.ro-no {
    font-weight: 600 !important;
    color: #333;
    padding-top: 20px;
    font-size: 15px;
}

.ro-head {
    font-weight: 600 !important;
    font-size: 1.3rem !important;
    color: #333;
    text-decoration: underline;
    margin-top: 10px;
}

.outlay {
    font-weight: 600 !important;
    font-size: 1.5rem !important;
    color: #3F4254;
}

.amount {
    font-weight: 600 !important;
    font-size: 2.15rem !important;
    color: #3F4254;
}

.upper {
    text-transform: uppercase !important;
}
</style>



<div class="ro-container-a4-page">


    <div class="certificate-header">
        <img alt="Logo" src="{{ public_path('assets/media/logos/a4-avv-head-logo.jpg') }}" class="header-logo">
    </div>



    <table style="width:100%;margin:20px auto 0px;">
        <tr>

            <td style="width:100%;text-align:center;padding: 0px 0px 0px;" colspan="3">

                <div> <span class="ro-head">RELEASE ORDER
                    </span></div>
            </td>

        </tr>

        <tr>
            <td style="width:30%;text-align:left;padding: 0px;">
                <p class="ro-no"> <span>RO#:
                        {{$proposal->proposalro->proposal_ro}}</span></p>
            </td>
            <td style="width:40%;text-align:center;padding: 0px;"></td>
            <td style="width:30%;text-align:right;padding: 0px;">
                <p class="ro-no"><span>{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td style="width:100%;text-align:center;padding: 0px;border-bottom:1px solid #ccc" colspan="3"></td>
        </tr>
    </table>


    <table style="width:100%;margin:0px auto;">
        <tr>
            <td style="padding-top:10px;">TO</td>
        </tr>
        <tr>
            <td style="padding-top:10px;padding-left:20px;">
                <span><b>{{$proposal->vendor->contact_person}}</b></span>
                </br>
                <span> {{$proposal->vendor->vendor_name}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding:25px 0px 10px;">SUBJECT : <span> Issue of Release order for
                    <b>{{$proposal->proposal_title}}
                        [{{$proposal->proposal_id}}]</b></span></td>
        </tr>



        <tr>


            <td>
                <div style="margin:10px 0px;line-height: 20px;text-align: justify;">
                    We are pleased to issue the release order for the <b>{{$proposal->proposal_title}}</b>, as per the
                    proposal submitted. This approval marks the formal authorization to proceed
                    with the development and implementation of the proposal. The necessary budgetary allocations and
                    resources have been sanctioned in line with the proposal requirements. Your team is
                    now authorized to initiate the tasks in accordance with the approved scope, timeline, and
                    deliverables. <p>We look forward to the successful completion of the tasks and appreciate your
                        commitment to this initiative.</p>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="margin-top:0px;"> <span class="outlay">OUTLAY
                        :</span>
                    <span class="outlay">
                        <img alt="Logo" src="{{ public_path('assets/media/logos/rupee.png') }}"
                            style="height:20px; margin:0px;">
                    </span>

                    <span class="amount"
                        style="margin-left:-5px;">{{number_format_indian($proposal->proposal_total_cost,2)}}
                    </span>
                    <span>[Inclusive of GST]</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <span style="margin-bottom:10px;">Rupees
                    {{$amounwords}}
                    only.</span>
            </td>
        </tr>
        <tr>
            <td style="padding-top:30px;text-transform:uppercase;padding-bottom: 10px;"><u>Billing Address</u></td>
        </tr>
        <tr>
            <td>
                <div style="margin:0px 20px; font-size:14px;">

                    DIRECTORATE OF ADMISSIONS,
                    <br>AMRITA SCHOOL OF ENGINEERING,
                    AMRITA VISHWA VIDYAPEETHAM, AMRITA NAGAR(PO),
                    ETTIMADAI, COIMBATORE - 641112


                </div>
            </td>
        </tr>
        <tr>
            <td style="padding-top:30px;text-transform:uppercase;padding-bottom: 10px;"><u>Notes</u></td>
        </tr>
        <tr>
            <td>
                <ul style="margin:0px 0px 0px;font-size:14px;">
                    <li>Mandate to include RO No. and Bank details, billing address (mentioned above) on
                        the
                        invoice copies.</li>
                    <li>Payment will be release monthly, up on submission of the tax invoice.</li>
                    <li>Payout period is minimum of 14 working days</li>
                </ul>
            </td>
        </tr>

    </table>

    <div class="certificate-footer">
        <img alt="Logo" src="{{ public_path('assets/media/logos/a4-avv-sign.jpg') }}" class="header-logo">
        <img alt="Logo" src="{{ public_path('assets/media/logos/a4-avv-footer-logo.jpg') }}" class="header-logo">

    </div>

</div>