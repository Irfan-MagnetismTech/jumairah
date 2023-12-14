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
    <img src="{{ asset(config('company_info.logo'))}}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}" class="pdfimg">
    <div class="clearfix"></div>
    <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
</div>

<div id="pageTitle" style="display: block; width: 100%;">
    <h2 style="text-align: center; width: 25%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">ADVANCE ADJUSTMENT</h2>
</div>


<div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">
    <div class="row">
        <div>
            <table style="font-size: 12px">
                <tbody>
                <tr>
                    <td>DATE</td>
                    <td>:21/04/2021</td>
                </tr>
                <tr>
                    <td>NAME</td>
                    <td>:Md.Gishan Ahmed</td>
                </tr>
                <tr>
                    <td>Designation</td>
                    <td>:Sr.Executive</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>:Procurement</td>
                </tr>
                <tr>
                    <td>Project</td>
                    <td>:MEMORY'71(B-1 Interior)</td>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
    <br>
    <p>Being the amount Adjusted for cash purchases of respected materials............................</p>
<br>
    <table id="table">
        <thead>
        <tr style="vertical-align: middle">

            <th width="20px">Date</th>
            <th width="60px">Bill</th>
            <th width="60px">Bill Summary<br>Description</th>
            <th width="60px">MPR</th>
            <th width="60px">MRR</th>
            <th width="60px">Amount(Tk)</th>

        </tr>
        </thead>
        <tbody>
{{--        <!--        @forelse($projects as $key => $project)-->--}}
        <tr class="text-right">
            <td class="text-center">3</td>
            <td class="text-right"> <nobr></nobr>3</td>
            <td class="text-right">3</td>
            <td class="text-right">3</td>
            <td class="text-right">3</td>
            <td class="text-right">3</td>
        </tr>

        <!--        {{--                @empty--}}-->
        <!--        {{--                    <tr>--}}-->
        <!--            {{--                        <td colspan="29"> <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5> </td>--}}-->
        <!--            {{--                    </tr>--}}-->
        <!--        {{--                    @endforeach--}}-->
        </tbody>
        <tfoot>

        <tr>
            <td colspan="5" class="text-right">Total:</td>
            <td  class="text-right">4444</td>
        </tr>
        <tr>
            <td colspan="6" class="text-left"><strong>Inwords: Thriteen Four Hundred Seventy Four Only</strong></td>
        </tr>
        </tfoot>

    </table>
    <br>
    <p><strong>Cheque Issue : Mohammed Trading</strong></p>
    <br><br><br>
    <table id="table" style="width: 50%;">
        <tbody>
        {{--        <!--        @forelse($projects as $key => $project)-->--}}
        <tr class="text-right">
            <td class="text-center">Advance Received Amount</td>
            <td class="text-right"> <nobr></nobr>=13,474/=</td>
        </tr>
        <tr class="text-right">
            <td class="text-center">Less Expenditure Inquired</td>
            <td class="text-right"> <nobr></nobr>3</td>
        </tr>
        <tr class="text-right">
            <td class="text-center">To be deposited AC dept</td>
            <td class="text-right"> <nobr></nobr>3</td>
        </tr>

        <!--        {{--                @empty--}}-->
        <!--        {{--                    <tr>--}}-->
        <!--            {{--                        <td colspan="29"> <h5 class="text-muted my-3 text-left"> No Data Found Based on your query. </h5> </td>--}}-->
        <!--            {{--                    </tr>--}}-->
        <!--        {{--                    @endforeach--}}-->
        </tbody>

    </table>
    <div class="row">
        <div class="col-md-6">
            <br>
            <span>----------------------</span>
            <p>Requisition By</p>
            <br>
            <span>----------------------</span>
            <p>Authorised By</p>
            <br>
            <span>----------------------</span>
            <p>Checked By</p>
            <span>----------------------</span>
            <p>Verified By</p>
            <span>----------------------</span>
            <p>Approved By</p>
            <span>----------------------</span>
            <p>Received By</p>
        </div>
    </div>
</div>
</body>
</html>
