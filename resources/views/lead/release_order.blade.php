<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

<style>
* {
    font-family: Inter, Helvetica, sans-serif;
    font-size: 14px;
}

.ro-container-a4-page {
    width: 794px;
    /* width for legal page */
    height: 1123px;
    /* height for legal page */
    margin: 0 auto;
    background-color: #fff;
    text-align: center;
    position: relative;
    padding: 10px;
}

.certificate-header {}

.certificate-header-first {
    font-family: 'Verdana', serif;
    font-size: 20px;
    margin: 0px !important;
    letter-spacing: 1px;
    margin-bottom: 10px !important;
    color: #ea0029 !important;
    font-weight: 600;
    margin-top: 40px !important;
}

.certificate-header-second {
    font-family: 'Verdana', serif;
    /* Use the Felix Titling font */
    font-size: 34px;
    margin-top: 0px !important;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    text-transform: uppercase;
}

.header-border {
    width: 100%;
    height: 1px;
    background-color: #ccc;
    margin: 10px auto 20px auto;
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
        <img alt="Logo" src="{{ url('/') }}/assets/media/logos/a4-avv-head-logo.jpg" class="header-logo">
    </div>



    <table style="width:100%;margin:20px auto 10px;">
        <tr>

            <td style="width:100%;text-align:center;padding: 20px 0px 0px;" colspan="3">

                <div> <span class="ro-head">RELEASE ORDER
                    </span></div>
            </td>

        </tr>

        <tr>
            <td style="width:30%;text-align:left;">
                <p class="ro-no"> <span>RO#:
                        {{$proposal->proposalro->proposal_ro}}</span></p>
            </td>
            <td style="width:40%;text-align:center;"></td>
            <td style="width:30%;text-align:right;">
                <p class="ro-no"><span>{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>
                </p>
            </td>
        </tr>
    </table>

    <div class="header-border"></div>
    <table style="width:100%;margin:0px auto;">
        <tr>
            <td>TO</td>
        </tr>
        <tr>
            <td style="padding-top:10px;">
                <span style="margin-left:20px;"><b>{{$proposal->vendor->contact_person}}</b></span>
                </br>
                <span style="margin-left:20px;"> {{$proposal->vendor->vendor_name}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;">SUBJECT</td>
        </tr>
        <tr>
            <td>
                <p style="margin:10px 20px;">Issue of Release order for <b>{{$proposal->proposal_title}}
                        [{{$proposal->proposal_id}}]</b></p>
            </td>
        </tr>

        <!-- <tr>
            <td style="padding-top:20px;text-transform:uppercase;">Scope &
                Services</td>
        </tr> -->


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
                <div style="margin-top:20px;"> <span class="outlay">OUTLAY
                        :</span>
                    <span class="outlay">&#x20b9;</span>
                    <span class="amount">{{number_format($proposal->proposal_total_cost,2)}}
                    </span>
                    <span>[Inclusive of GST]</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin-bottom:20px;">Rupees
                    {{$amounwords}}
                    rupees only.</p>
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;text-transform:uppercase;"><u>Billing Address</u></td>
        </tr>
        <tr>
            <td>
                <div style="margin:10px 20px;">

                    DIRECTORATE OF ADMISSIONS,
                    <br>AMRITA SCHOOL OF ENGINEERING,
                    AMRITA VISHWA VIDYAPEETHAM, AMRITA NAGAR(PO),
                    ETTIMADAI, COIMBATORE - 641112


                </div>
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;text-transform:uppercase;"><u>Notes</u></td>
        </tr>
        <tr>
            <td>
                <ul style="margin:10px 0px 20px;">
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
        <img alt="Logo" src="{{ url('/') }}/assets/media/logos/a4-avv-sign.jpg" style="margin:20px 0px">
        <img alt="Logo" src="{{ url('/') }}/assets/media/logos/a4-avv-footer-logo.jpg" class="header-logo">
    </div>

</div>