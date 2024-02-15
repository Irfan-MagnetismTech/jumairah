


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Receiving Form</title>
    <style>
        .textUpper{
        text-transform: uppercase;
    }
    .textCenter{
        text-align: center;
    }
    .textRight{
        text-align:right;
    }
    p{
        margin: 0;
    }
    .pullLeft{
        float:left;
        width:55%;
        display: block;
    }
    .pullRight{
        float:none;
        width: 25%;
        display: block;
    }
    .pullLeft, .pullRight{
        margin-top: 10px;
        margin-bottom: 10px;
    }
    table, table th, table td {
        border-spacing: 0;
        padding-bottom: 0;
    }
    .terms li{
        word-wrap: break-word;
    }

    #rate_table, #rate_table th, #rate_table td,
    #payment_schedule, #payment_schedule th, #payment_schedule td {
        border-spacing: 0;
        padding-bottom: 0;
        border: 1px solid #000;
        font-size: 12px;
        vertical-align: middle;
        border-collapse: collapse;
    }

    .wo_pages {
        position: absolute;
        top: 100px;
        right: 15px;
        background: black;
        color: #fff;
        display:inline-block;
        line-height: 18px;
        font-weight: 14px;
        padding: 3px 5px;
    }

    .pdflogo{
        margin-top: 130px;
        text-align: center;
    }

    .page_break { page-break-after: always; }
    @page {
        margin: 80px 30px 80px 30px;
    }
    html body{
        /* background: green!important;  */
    }

    header {
        position: fixed;
        top: -60px;
        left: 0;
        right: 0;
    }

    footer{
        position: fixed;
        bottom: -40px;
        left: 0;
        right: 0;
        height: 30px;
        width: 100%;
        display: block;
        font-size: 11px;
    }
    </style>
</head>
<body>
    <header>
        <div id="logo" class="pdflogo">
            <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg pullRight">
        </div>
    </header>

    <div class="container" style="margin-bottom:90px">
        <div style= "width:100%; margin-top: 150px; margin-bottom: 60px">
            <h1 class="textCenter">{{ $sell->apartment->project->name }}</h1>
            <h2 class="textCenter" style="margin-bottom: 30px"><u>Key Receiving Form</u></h2>
            <br>
            <div class="text-center" style="float:left; width:75%; margin-left: 50px">
                Flat / Land Owner Name: <strong>{{ $sell->sellClients->first()->client->name }}</strong>
            </div>
            <div class="text-center" style="float:left; width:25%;">
                Date:{{ \Carbon\Carbon::now()->format('d-m-Y') }}
            </div>
        </div>

        <div style="margin-left: 50px; margin-right: 50px">
            <table style="margin-top: 5px; width: 100%;" id="rate_table">
                <tr>
                    <th style="width: 50%">Flat No: </th>
                    <th style="width: 20%">Unit</th>
                    <th style="width: 15%">Quantity</th>
                    <th style="width: 15%">Remarks</th>
                </tr>
                <tr>
                    <td style="padding: 5px">Main Door Key</td>
                    <td style="padding: 5px; text-align: center"> Nos</td>
                    <td style="padding: 5px"></td>
                    <td style="padding: 5px"></td>
                </tr>
                <tr>
                    <td style="padding: 5px">Internal Door Key</td>
                    <td style="padding: 5px; text-align: center"> Nos</td>
                    <td style="padding: 5px"></td>
                    <td style="padding: 5px"></td>
                </tr>
                <tr>
                    <td style="padding: 5px">Total Key</td>
                    <td style="padding: 5px; text-align: center"> Nos</td>
                    <td style="padding: 5px"></td>
                    <td style="padding: 5px"></td>
                </tr>
            </table>
        </div>

        <div style= "width:100%; margin-top: 50px; margin-left: 50px;">
            <div class="text-left" style="float:left; width:65%;">
                <p style="text-decoration: overline;">Receiver Signature</p>
                <p>{{ $sell->sellClients->first()->client->name }}</p>
                <p>{{ $sell->apartment->project->name }}</p>
                <p>{{ $sell->apartment->name }}</p>
            </div>
            <div class="text-center" style="float:left; width:35%;">
                <p style="text-decoration: overline;">Giver Signature</p>
                <p> Manager, Customer Care </p>
                <p class="text-center">{!! htmlspecialchars(config('company_info.company_fullname')) !!}</p>
            </div>
        </div>
    </div>

    <footer>
        {!! htmlspecialchars(config('company_info.company_address')) !!}<br>
        Phone: {!! htmlspecialchars(config('company_info.company_mobile')) !!} <br>
        {!! htmlspecialchars(config('company_info.company_email')) !!}
    </footer>
</body>
</html>
