<!DOCTYPE html>
<html>

<head>
    <title>{{config('app.name')}}</title>
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
                style="background-color:#ffffff; padding: 20px 0 10px 0; border-radius: 15px; margin:40px auto; max-width: 600px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
                    style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 30px">
                                <div style="text-align:center; margin:0 15px 0px 15px">
                                    <!--begin:Logo-->
                                    <div style="margin-bottom: 30px; border-bottom:1px solid #e2e2e2">
                                        <img src="https://doabuet.amrita.edu/assets/media/logos/logo_purple_mail.png"
                                            style="height: 80px" />
                                    </div>
                                    <!--end:Logo-->

                                    <!--begin:Text-->
                                    <div
                                        style="font-size: 15px; font-weight: 500; margin-bottom: 7px; font-family:Arial,Helvetica,sans-serif; text-align: left;"
                                    >
                                        <p style="margin:0 20px 10px 15px; color:#333">
                                            Hi Admin,
                                        </p>
                                        <p style="margin:0 20px 10px 15px; color:#333">
                                            Just a quick heads-up — a few budget categories have dipped below the 10% remaining mark. You might want to take a look and see if any action is needed.
                                            The details are listed below in the email.
                                        </p>
                                    </div>

                                    <div style="padding:10px 20px;">
                                        @if (count($categorybudgetused) === 0)
                                            <p style="text-align:center;">
                                                No category falls below the 10% budget threshold.
                                            </p>
                                        @else
                                        <table align="center" cellpadding="10" cellspacing="0" border="0" width="100%" style="border-collapse: collapse; border-radius: 10px; overflow: hidden;">
                                            <thead>
                                                <tr style="border-bottom: 1px solid #ddd;">
                                                    <th style="text-align:left;">
                                                        Category
                                                    </th>
                                                    <th style="text-align:left;">
                                                        Remaining Budget
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categorybudgetused as $category)
                                                <tr style="border-bottom: 1px solid #ddd;">
                                                    <td style="text-align:left;">
                                                        {{ $category['parent_category_name'] }}
                                                    </td>
                                                    <td style="text-align:left;">
                                                        {{ $category['remaining_percent'] }}%
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 5px 10px 5px 10px; font-weight: 500; color: #93949b;border-top:1px solid #e2e2e2; font-family:Arial,Helvetica,sans-serif">

                                <p style="margin:2px">
                                    For Inquiries or Support, Call Us: +91 94899 32973
                                </p>
                                <p style="margin-bottom:4px">
                                    You may reach us at 
                                    <a href="#" rel="noopener" target="_blank" style="font-weight: 600; padding-bottom:20px"
                                    >
                                        directoradmissions@amrita.edu
                                    </a>.
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #93949b;font-family:Arial,Helvetica,sans-serif;  border-top:1px solid #e2e2e2;margin-top:20px">
                                <p>
                                    &copy; 2024. Amrita Vishwa Vidyapeetham
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