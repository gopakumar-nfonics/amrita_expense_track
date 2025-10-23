

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weekly Budget Utilization Report</title>
  <style>
    body {
      background: #f4f4f4;
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 1000px;
      margin: 0 auto;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 30px;
    }
    .logo {
      display: block;
      margin: 0 auto 10px auto;
      height: 80px;
      width: 295px;
    }
    .divider {
      border: none;
      border-top: 1px solid #ddd;
      margin: 10px 0;
    }
    .table-header {
      font-weight: bold;
      background-color: #efefef;
    }
    .right {
      text-align: right;
    }
    .sub-table td {
      padding-left: 10px;
      font-size: 12px;
      color: #666;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      padding: 6px;
      border: 1px solid #ddd;
      font-size: 12px;
    }
    th {
      background: #efefef;
    }
    .signature {
      font-size: 14px;
      margin-top: 20px;
    }
    .footer {
      text-align: center;
      color: #93949b;
      font-size: 12px;
      margin-top: 20px;
    }
    @media (max-width: 600px) {
      .container {
        max-width: 100% !important;
        padding: 10px;
      }
      .logo {
        width: 100%;
        height: auto;
      }
      th, td {
        font-size: 10px;
        padding: 4px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="https://doabuet.amrita.edu/assets/media/logos/logo_purple.png" alt="Amrita Logo" class="logo" />
    <hr class="divider" />
    <div style="font-size:14px; margin-bottom:10px; margin-top:20px;">Dear Admin,</div>
    <div style="font-size:14px; line-height:1.6; margin-bottom:15px;">
      Kindly find below the Weekly Budget Utilization Report for the {{ \Carbon\Carbon::now('Asia/Kolkata')->weekOfMonth == 1 ? 'first' : (\Carbon\Carbon::now('Asia/Kolkata')->weekOfMonth == 2 ? 'second' : (\Carbon\Carbon::now('Asia/Kolkata')->weekOfMonth == 3 ? 'third' : (\Carbon\Carbon::now('Asia/Kolkata')->weekOfMonth == 4 ? 'fourth' : 'fifth'))) }} week of {{ \Carbon\Carbon::now('Asia/Kolkata')->format('F') }} {{ $financialYear }}.
    </div>
    <div style="text-align:right; font-size:12px; color:#666; margin-bottom:10px;">
      Generated on : {{ \Carbon\Carbon::now('Asia/Kolkata')->format('l, F j, Y') }} at {{ \Carbon\Carbon::now('Asia/Kolkata')->format('g:i A') }}
    </div>
    <table>
      <tr class="table-header">
        <th align="center">Category</th>
        <th align="center">Allocated</th>
        <th align="center">Sub Category</th>
        <th align="center">Spent</th>
        <th align="center">Total Spent</th>
        <th align="center">Balance</th>
      </tr>
      @foreach($categories as $cat) 
        @if(!empty($cat['sub_categories']) && count($cat['sub_categories']) > 0)
          <tr>
            <td align="left" rowspan="{{ count($cat['sub_categories']) }}"  style="vertical-align: middle; font-size: 12px;">{{ $cat['category'] }}</td>
            <td align="right" rowspan="{{ count($cat['sub_categories']) }}"  style="vertical-align: middle; font-size: 12px;">₹{{ $cat['allocated'] }}</td>
            <td align="left" style="font-size: 11px;">{{ $cat['sub_categories'][0]['name'] }}</td>
            <td align="right" style="font-size: 12px;">₹{{ $cat['sub_categories'][0]['expense'] }}</td>
            <td  align="right" rowspan="{{ count($cat['sub_categories']) }}"  style="vertical-align: middle; font-size: 12px;">₹{{ $cat['total_expense'] }}</td>
            <td  align="right" rowspan="{{ count($cat['sub_categories']) }}"  style="vertical-align: middle; font-size: 12px;">₹{{ $cat['balance'] }}</td>
          </tr>
          @for($i = 1; $i < count($cat['sub_categories']); $i++)
            <tr>
              <td align="left" style="font-size: 11px;">{{ $cat['sub_categories'][$i]['name'] }}</td>
              <td align="right" style="font-size: 11px;">₹{{ $cat['sub_categories'][$i]['expense'] }}</td>
            </tr>
          @endfor
        @else
          <tr>
            <td align="left" style="font-size: 12px;">{{ $cat['category'] }}</td>
            <td align="right" style="font-size: 12px;">₹{{ $cat['allocated'] }}</td>
            <td style="font-size: 11px;">NIL</td>
            <td align="right" style="font-size: 11px;">₹0.00</td>
            <td align="right" style="font-size: 12px;">₹{{ $cat['total_expense'] }}</td>
            <td align="right" style="font-size: 12px;">₹{{ $cat['balance'] }}</td>
          </tr>
        @endif
      @endforeach
    </table>
    <div class="signature">
      Director (Admissions)<br />
      Amrita Vishwa Vidyapeetham
    </div>
    <hr class="divider" />
    <div class="footer">
      For Inquiries or Support, Call Us: +91 94899 32973<br />
      You may reach us at <a href="mailto:directoradmissions@amrita.edu" style="color: #007bff; text-decoration: none; font-weight: 600;">directoradmissions@amrita.edu</a><br />
      &copy; {{ date('Y') }} Amrita Vishwa Vidyapeetham
    </div>
  </div>
</body>
</html>
