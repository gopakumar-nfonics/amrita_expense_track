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
    font-size: 1.15rem !important;
    text-align: right;
}

.amount {
    font-weight: 600 !important;
    font-size: 1.1rem !important;
}

.upper {
    text-transform: uppercase !important;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
    /* Ensures borders don't double up */
}

.invoice-table td,
.invoice-table th {
    border: 1px solid #666;
    padding: 8px;
    /* Optional: Adds padding for better readability */
}
</style>



<div class="ro-container-a4-page">


    <div class="certificate-header">
        <img alt="Logo" src="{{ public_path('assets/media/logos/a4-avv-head-logo.jpg') }}" class="header-logo">
    </div>



    <table style="width:100%;margin:20px auto 0px;">
        <tr>

            <td style="width:100%;text-align:center;padding: 0px 0px 0px;" colspan="3">

                <div> <span class="ro-head">PAYMENT REQUEST
                    </span></div>
            </td>

        </tr>

        <tr>
            <td style="width:30%;text-align:left;padding: 0px;">
                <p class="ro-no"> <span>Request#:
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
            <td style="padding-top:10px;">From</td>
        </tr>
        <tr>
            <td style="padding-top:5px;padding-left:20px;">
                <span><b>Maheshwara Chaitanya</b></span>
                </br>
                <span>Director Admissions, Amrita Vishwa Vidyapeetham, Coimbatore</span>
            </td>
        </tr>

        <tr>
            <td style="padding-top:15px;">To</td>
        </tr>
        <tr>
            <td style="padding-top:5px;padding-left:20px;">
                <span><b>Finance Manager</b></span>
                </br>
                <span>Amrita Vishwa Vidyapeetham, Coimbatore</span>
            </td>
        </tr>

        <tr>
            <td style="padding:15px 0px 0px;">Sir,</td>
        </tr>
        <tr>
            <td style="padding:10px 0px 10px;"><b>Subject : <span> Processing the payment of
                        NFONICS Solutions (P) Ltd</b></span></td>
        </tr>



        <tr>


            <td>
                <div style="margin:5px 0px;line-height: 20px;text-align: justify;">
                    We kindly request that you proceed with the payment as per the invoice detailed below. A signed copy
                    of the invoice is enclosed for your reference.</p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;padding-bottom: 10px;"><u><b>Vendor Details</b></u></td>
        </tr>
        <tr>
            <td>
                <div style="margin:0px 20px; font-size:14px;">
                    <b>NFONICS Solutions (P) Ltd</b><br>
                    15/22/1, First Floor, Sahithi Tower, Harisankar Road,PALAKKAD,Kerala | 679513<br>
                    GSTIN : 32AAGCD1055M1ZS | PAN NO: AAECN0826C


                </div>
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;padding-bottom: 10px;"><u><b>Invoice Details</b></u></td>
        </tr>
        <tr>
            <td>
                <table style="width:100%" class="invoice-table">

                    <tr>
                        <th>Invoice #
                        </th>
                        <th>Date
                        </th>
                        <th>Amount (INR)
                        </th>
                        <th>Remarks
                        </th>
                    </tr>

                    <tr>
                        <td>NF/2024-25/GST/7
                        </td>
                        <td>26-10-2024
                        </td>
                        <td style="text-align:right;"> <span class="outlay">82,600.00</span>
                        </td>
                        <td>Budget and Expense Tracker Web Application
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">Amount in words :
                            <span style="margin-bottom:10px;" class="amount">Rupees
                                {{$amounwords}}
                                only.</span>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

    </table>



    <div class="certificate-footer">
        <table style="width:100%">
            <tr>
                <td>Prepared By : <b>Anagha</b> </td>
                <td style="text-align:right; padding-right:90px">Approved By </td>
            </tr>
            <!-- <tr>
                <td></td>

            </tr> -->
        </table>

        <img alt="Logo" src="{{ public_path('assets/media/logos/a4-avv-sign-pr.jpg') }}" class="header-logo">
        <img alt="Logo" src="{{ public_path('assets/media/logos/a4-avv-footer-logo.jpg') }}" class="header-logo">

    </div>

</div>