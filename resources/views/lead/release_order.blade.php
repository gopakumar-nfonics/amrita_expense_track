<style>
* {
    font-family: 'Verdana', sans-serif;
}

.ro-container-legal {
    width: 816px;
    /* width for legal page */
    height: 1344px;
    /* height for legal page */
    margin: 0 auto;
    border: 1px solid #000;
    background-color: #fff;
    text-align: center;
}

.certificate-header {
    padding: 10px;
}

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
    width: 95%;
    height: 1px;
    background-color: #ccc;
    margin: 20px auto 20px auto;
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
    font-size: 1.15rem !important;
    color: #333;
}
</style>



<div class="ro-container-legal">


    <div class="certificate-header">
        <img alt="Logo" src="{{ url('/') }}/assets/media/logos/avv-head-logo.jpg" class="header-logo">
    </div>



    <table style="width:100%;margin:0px auto;">
        <tr>

            <td style="width:90%;text-align:center;" colspan="3"><span class="ro-head"><u>RELEASE ORDER</u></span></td>

        </tr>

        <tr>
            <td style="width:30%;text-align:center;">
                <p class="ro-no"> <span>RO#:
                        {{$proposal->proposalro->proposal_ro}}</span></p>
            </td>
            <td style="width:30%;text-align:center;"></td>
            <td style="width:30%;text-align:center;">
                <p class="ro-no"><span>{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d F, Y') }}</span>
                </p>
            </td>
        </tr>
    </table>

    <div class="header-border"></div>
    <table style="width:90%;margin:0px auto;">
        <tr>
            <td>TO:</td>
        </tr>
        <tr>
            <td>
                <span style="margin-left:20px;">{{$proposal->vendor->contact_person}}</span>
                </br>
                <span style="margin-left:20px;"> {{$proposal->vendor->vendor_name}}</span>
            </td>
        </tr>
        <tr>
            <td>SUBJECT</td>
        </tr>
        <tr>
            <td>
                <p>Issue of Release order for <b>{{$proposal->proposal_title}}</b></p>
            </td>
        </tr>

        <tr>
            <td>Scope &
                Services</td>
        </tr>
        <tr>
            <td>
                <p> <span class="fs-2 fw-bold text-gray-800 me-2 lh-1 ls-n2 txt-uppercase">Outlay
                        :</span>
                    <span class="fs-1 fw-semibold text-gray-500 align-self-start me-1">&#x20b9;</span>
                    <span id="total-cost-span" class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                        data-kt-element="sub-total">{{$proposal->proposal_total_cost}}
                    </span>
                    <span>[Inclusive of GST]</span>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Rupees
                    {{$amounwords}}
                    rupees only.</p>
            </td>
        </tr>
        <tr>
            <td><u>Billing Address</u></td>
        </tr>
        <tr>
            <td>
                <p>
                <address class="mt-3">
                    DIRECTORATE OF ADMISSIONS,
                    <br>AMRITA SCHOOL OF ENGINEERING,
                    AMRITA VISHWA VIDYAPEETHAM, AMRITA NAGAR(PO),
                    ETTIMADAI, COIMBATORE - 641112

                </address>
                </p>
            </td>
        </tr>
        <tr>
            <td><u>Notes</u></td>
        </tr>
        <tr>
            <td>
                <ul class="list-disc mt-4">
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
        <img alt="Logo" src="{{ url('/') }}/assets/media/logos/avv-footer-logo.jpg" class="header-logo">
    </div>

</div>