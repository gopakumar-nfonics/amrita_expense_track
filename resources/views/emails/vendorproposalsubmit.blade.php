<!DOCTYPE html>
<html>

<head>
    <title>User Created | {{config('app.name')}}</title>
</head>

<body>
    <!--begin::Body-->
    <div class="scroll-y flex-column-fluid px-10 py-10 my-20" data-kt-scroll="true" data-kt-scroll-activate="true"
        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px"
        data-kt-scroll-save-state="true"
        style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <!--begin::Email template-->
        <style>
        html,
        body {
            padding: 0;
            margin: 0;
            font-family: Inter, Helvetica, "sans-serif";
        }

        a:hover {
            color: #009ef7;
        }
        </style>
        <div id="#kt_app_body_content"
            style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:20px 0px; width:100%;">
            <div
                style="background-color:#ffffff; padding: 30px 0 10px 0; border-radius: 15px; margin:40px auto; max-width: 600px;">

                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
                    style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">

                                <!--begin:Email content-->
                                <div style="text-align:center; margin:0 15px 0px 15px">
                                    <!--begin:Logo-->
                                    <div style="margin-bottom: 20px; border-bottom:1px solid #e2e2e2">

                                        <img src="https://doabuet.amrita.edu/assets/media/logos/logo_purple_mail.png"
                                            style="height: 80px" />

                                    </div>
                                    <!--end:Logo-->

                                    <!--begin:Text-->
                                    <div
                                        style="font-size: 14px; font-weight: 500; margin-bottom: 7px; font-family:Arial,Helvetica,sans-serif;text-align:left;">
                                        <p
                                            style="margin-bottom:20px; color:#525252; font-weight:700;text-align: left;margin-left: 10px;">
                                            Dear<span style="text-transform: uppercase;">{{$details['name']}},</span>
                                        <p style="margin:20px 15px 0px; color:#333;">
                                            We have received the proposal from you.</p>

                                        <p style="margin:20px 15px; color:#333;">
                                            Statement of Work: <span
                                                style="text-transform: uppercase;font-weight:700;">{{$details['proposal_title']}}</span>
                                        </p>
                                        <p style="margin:20px 15px; color:#333;">
                                            We have successfully received your details and is being reviewed for
                                            approval. We will carefully evaluate your proposal to ensure it aligns with
                                            our project requirements. Once the review is complete, you will receive the
                                            notification via email.
                                        </p>
                                        <p style="margin:20px 15px; color:#333;">We appreciate the effort you put into
                                            this proposal and look forward to the opportunity to potentially work
                                            together.</p>
                                        <p
                                            style="margin:30px 0px 0px; color:#525252; font-weight:700;text-align: left;margin-left: 10px;">
                                            Director (Admissions) <br>
                                            Amrita Vishwa Vidyapeetham
                                        </p>


                                    </div>
                                    <!--end:Text-->

                                </div>
                                <!--end:Email content-->
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="center"
                                style="font-size: 13px; text-align:center; padding: 5px 10px 5px 10px; font-weight: 500; color: #93949b;border-top:1px solid #e2e2e2; font-family:Arial,Helvetica,sans-serif">

                                <p style="margin:2px">For Inquiries or Support, Call Us: +91 94899 32973</p>
                                <p style="margin-bottom:4px">You may reach us at
                                    <a href="#" rel="noopener" target="_blank"
                                        style="font-weight: 600; padding-bottom:20px">directoradmissions@amrita.edu</a>.
                                </p>

                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="center"
                                style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #93949b;font-family:Arial,Helvetica,sans-serif;  border-top:1px solid #ccc;margin-top:20px">
                                <p>&copy; {{ date('Y') }}. Amrita Vishwa Vidyapeetham
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!--end::Email template-->
    </div>
    <!--end::Body-->
</body>

</html>