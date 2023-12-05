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
            font-size:9px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even){
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #0e2b4e;
            color: white;
        }
        .tableHead{
            text-align: center;
            font-weight: bold;
            font-size: 13px;
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
        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }
        #client{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }
        #apartment{
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }
        .infoTable{
            font-size: 12px;
            width: 100%;
        }
        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }
        .pdflogo a{
            font-size: 18px;
            font-weight: bold;
        }
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        @page { margin: 30px 0 0 30px; }
    </style>
</head>

<body>

<div id="logo" class="pdflogo">
    <img src="{{ asset('images/ranksfc_log.png')}}" alt="Logo" class="pdfimg">
    <div class="clearfix"></div>
    <h5>Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, Agrabad C/A, Chattogram.</h5>
</div>

<div id="pageTitle" style="display: block; width: 100%;">
    <h2 style="text-align: center; width: 25%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">Purchase order Form</h2>
</div>


<div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
    <div class="row">

                <div>
                    <p>To</p>
                    <p>CEM Ready Mix Concrete Limited</p>
                    <p> 302,Solashahar 1/A, Nasirabad</p>
                    <p>01712345670</p>
                </div>
                <div>
                <table style="font-size: 12px">
                    <tbody>
                    <tr>
                        <td>P.O No.</td>
                        <td>:479</td>
                    </tr>
                    <tr>
                        <td>P.O Date.</td>
                        <td>:06/06/2021</td>
                    </tr>
                    <tr>
                        <td>Project Name</td>
                        <td>:RFPL WHITE OAK</td>
                    </tr>
                    <tr>
                        <td>Project Mobile</td>
                        <td>:01715234567</td>
                    </tr>
                    <tr>
                        <td>Project Address</td>
                        <td>:Shaheed Mirza Lane,Mehdibag,Chittagong,Chittagong</td>
                    </tr>

                    </tbody>
                </table>

                </div>
            </div>

    <table id="table">
        <thead>
        <tr style="vertical-align: middle">

            <th width="20px">SL</th>
            <th width="60px">MPR</th>
            <th width="60px">Material Code</th>
            <th width="70px">Material Name</th>
            <th width="60px">Unit</th>
            <th width="70px">Material Type</th>
            <th width="70px">Material Size</th>
            <th width="60px">Brand</th>
            <th width="60px">Qty</th>
            <th width="60px">Rate</th>
            <th width="60px">Amount</th>
            <th width="60px">Required.Date</th>
        </tr>
        </thead>
        <tbody>
        {{--        @forelse($projects as $key => $project)--}}
        <tr class="text-right">
            <td class="text-center">3</td>
            <td class="text-left"> <nobr></nobr>3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>
            <td class="text-center">3</td>

        </tr>
{{--                @empty--}}
{{--                    <tr>--}}
{{--                        <td colspan="29"> <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5> </td>--}}
{{--                    </tr>--}}
{{--                    @endforeach--}}
        </tbody>
        <tfoot>

                        <tr>
                            <td colspan="8" class="text-right">Sub Total:</td>
                            <td colspan="2">4444</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-right">Carrying Charge:</td>
                            <td colspan="2">3333</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-right">Labour Charge:</td>
                            <td colspan="2">3435</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-right">Discount:</td>
                            <td colspan="2">3434</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-right">Total Amount:</td>
                            <td colspan="2">34344</td>
                        </tr>
                        </tfoot>
                    </table>
    <br>
    <div class="row">

            <div>
                <h5>CS Ref: 2334</h5>
                <p>Remarks</p>
            </div>


    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="row">
        <div class="col-md-6" style="border: 1px solid #000000">
            <p>1.Please send all your bells in duplicate</p>
            <p>2.Payment shall be made after (00) days of receipt of all materials in good conditions.</p>
            <p>3.Please enclose a copy of receipted delivary challan with your bill.</p>
            <p>4.Company may have the right to alter/change/reject the PO at any time</p>
            <p>5.Source TAX: Applicable| Not Applicable</p>
            <p>6.Source VAT: Applicable| Not Applicable</p>
            <p>Print Date: {{date('d-M-y h:i:s a', strtotime(now()))}};</p>
            <p>This form is activated on September 01,2011 and expires on August 31,2014//Issue status # 001</p>
        </div>
        <div class="col-md-6">
            <br>
            <span>----------------------</span>
            <p>Prepared By</p>
            <br>
            <span>----------------------</span>
            <p>Authorised By</p>
            <br>
            <span>----------------------</span>
            <p>Approved By</p>

        </div>
    </div>
</div>


</body>
</html>
