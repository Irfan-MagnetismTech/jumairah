<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
            margin: 0;
            padding: 0;
        }
        table{
            font-size:10px;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #0e2b4e;
            color: white;
        }

        p{
            margin:0;
        }
        h1{
            margin:0;
        }
        h2{
            margin:0;
        }
        .container{
            margin: 20px;
        }
        .row{
            clear: both;
        }
        .head1{
            width: 45%;
            float: left;
            margin: 0;
        }
        .head2{
            width: 55%;
            float: right;
            margin: 0;
        }
        .head3{
            width: 45%;
            float: left;
            padding-bottom: 20px;
        }
        .head4{
            width: 45%;
            float: right;
            padding-bottom: 20px;
        }
        .textarea{
            width: 100%;
            float: left;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="head1">
            <h2>[Company Name]</h2>
            <p>[Street Address]</p>
            <p>[City. ST ZIP]</p>
            <p>Phone:(000) 000.0000</p>
            <p>Fax:(000) 000.0000</p>
            <p>Website:</p>
        </div>

        <div class="head2">
            <h1 style="font-size: 20px; text-transform: uppercase; text-align: right">Purchase Order</h1>
            <table style="width:40%; float: right;">
                <tr>
                    <th>Date:</th>
                    <td style="border: 1px solid black; text-align: center;">222222222222</td>
                </tr>
                <tr>
                    <th>PO:</th>
                    <td style="border: 1px solid black; text-align: center;">222222222222</td>
                </tr>
            </table>
        </div>

    </div>
</div>

<div class="container">
    <div class="row">
        <div class="head3">
            <h5 style="background-color: #0e2b4e; color: #ffffff; text-transform: uppercase; padding: 5px;">Vendor</h5>
            <p>[Company Name]</p>
            <p>[Contact or Department]</p>
            <p>[Street Address]</p>
            <p>[City. ST ZIP]</p>
            <p>Phone:(000) 000.0000</p>
            <p>Fax:(000) 000.0000</p>
        </div>
        <div class="head4">
            <h5 style="background-color: #0e2b4e; color: #ffffff; text-transform: uppercase; padding: 5px;">Ship To</h5>
            <p>[Name]</p>
            <p>[Company Name]</p>
            <p>[Street Address]</p>
            <p>[City. ST ZIP]</p>
            <p>[Phone:]</p>
        </div>

    </div>
</div>

{{--<div class="container">--}}
{{--<table id="customers" style="text-transform: uppercase;">--}}
{{--<tr>--}}
{{--<th style="width:20%; text-align: center;">Requisitioner</th>--}}
{{--<th style="width:25%; text-align: center;">Ship via</th>--}}
{{--<th style="width:20%; text-align: center;">F.O.B</th>--}}
{{--<th style="width:35%; text-align: center;">Shipping Terms</th>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--<td>1</td>--}}
{{--<td></td>--}}
{{--<td></td>--}}
{{--<td></td>--}}
{{--</tr>--}}
{{--</table>--}}
{{--</div>--}}
<div style="clear: both"></div>
<div class="container" style="margin-top: 30px;">
    <table id="customers">
        <thead>
        <tr>
            <th>Supplier Name</th>
            <th>Date</th>
            <th>Raw Material </th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-left"> {{ $purchasepdf->supplier->name ?? '' }}</td>
            <td> {{ $purchasepdf->date ? date('d-m-Y',strtotime($purchasepdf->date)):'' }}</td>
            <td class="text-right">
                @foreach($purchasepdf->purchaseDetails as $purchaseDtl)
                    {{$purchaseDtl->rowMetarials->name ?? ''}}<br>

                @endforeach
            </td>
            <td>
                @foreach($purchasepdf->purchaseDetails as $purchaseDtl)
                    {{$purchaseDtl->quantity ?? ''}} {{$purchaseDtl->rowMetarials->unit->name ?? ''}}<br>
                @endforeach
            </td>
            <td class="text-right">
                @foreach($purchasepdf->purchaseDetails as $purchaseDtl)
                    {{$purchaseDtl->unite_price ?? ''}}<br>
                @endforeach
            </td>
            <td class="text-right">
                @foreach($purchasepdf->purchaseDetails as $purchaseDtl)
                    {{$purchaseDtl->totalPrice ?? ''}}<br>
                @endforeach
            </td>

        </tr>
        </tbody>



    </table>
</div>

<div class="container">
    <div class="row">
        <div class="textarea">
            <p style="width: 100%; background-color: #dddddd; margin-bottom: 0px; padding: 10px 0;">Comments or Special Instructions</p>
            <textarea style="width: 100%; margin-top: 0px; height: 100px;"></textarea>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <p style="text-align: center;">If you have any questions about this purchase , Please contact <br> [Name, Phone #, E-mail]</p>
    </div>
</div>


</body>
</html>
