<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 10px;
        }

        #detailsTable {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #detailsTable td,
        #detailsTable th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #detailsTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #detailsTable tr:hover {
            background-color: #ddd;
        }

        #detailsTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #5387db;
            color: white;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        .row {
            clear: both;
        }

        .head1 {
            width: 45%;
            float: left;
            margin: 0;
        }

        .head2 {
            width: 55%;
            float: right;
            margin: 0;
        }

        .head3 {
            width: 45%;
            float: left;
            padding-bottom: 20px;
        }

        .head4 {
            width: 45%;
            float: right;
            padding-bottom: 20px;
        }

        .textarea {
            width: 100%;
            float: left;
        }

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .customers td,
        .customers th {
            border: 1px solid #000;
            padding: 5px;
        }

        .customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        .approval {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .approval td,
        .approval th {
            border: 1px solid #fff;
            padding: 5px;
        }

        /*header - position: fixed */


        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .text-center{
            text-align: center;
        }
        .text-bold{
            font-weight:bold;
        }
        .page_break {
            page-break-before: always;
        }
        @media print {
            #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }
        #setter,.getter{
            max-width: 100px!important;
        }
        }
    </style>
</head>

<body>
    @php
        $iteration = 1;
        $total = 0;
    @endphp
        <div >
            <div class="container" id="fixed_header">
                <div class="row">
                    <div class="head1" style="padding-left: 180px; text-align: center">
                        <img src="{{ asset(config('company_info.logo')) }}" alt="Rangsfc">
                        <p>
                            JHL Address.<br>
                            Phone: JHL Phone Number<br>
                            <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                        </p>


                    </div>
                    <div style="padding:50 0 0 50; ">
                        <h4>
                            Period No: {{ $BoqEmeUtilityBill->period }}
                        </h4>
                    </div>
                </div>
            </div>

            <div style="clear: both"></div>

            <div class="container">
                <div style="">
                    <table class="customers">
                        <tr class="text-center text-bold">
                            <td>
                                Utilities Bill of {{$BoqEmeUtilityBill->project->name}}
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr class="">
                            <td id='setter'>
                                Bill Name:
                            </td>
                            <td class="text-bold" id='setter1'>
                                Electricity </br>
                                (PDB-Individual)
                            </td>
                            <td id='setter2'>
                               Meter No:
                            </td>
                            <td class="text-bold">
                                {{ $BoqEmeUtilityBill->meter_no }}
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                                Previous Reading:
                            </td>
                            <td class="text-bold">
                                {{$BoqEmeUtilityBill->previous_reading}}
                            </td>
                           <td></td>
                           <td></td>
                        </tr>
                        <tr class="">
                            <td>
                               Present Reading:
                            </td>
                            <td class="text-bold">
                                {{$BoqEmeUtilityBill->present_reading}}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="">
                            <td>
                               Consumed Unit:
                            </td>
                            <td class="text-bold">
                                {{$BoqEmeUtilityBill->present_reading - $BoqEmeUtilityBill->previous_reading}}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="">
                            <td>
                               Electric Bill:
                            </td>
                            <td class="text-bold">
                                @php
                                    $electric_bill =($BoqEmeUtilityBill->present_reading - $BoqEmeUtilityBill->previous_reading) * $BoqEmeUtilityBill->electricity_rate;

                                @endphp
                                    {{ $electric_bill }}
                            </td>
                            <td>
                                Unit Rate:
                            </td>
                            <td>
                                {{$BoqEmeUtilityBill->electricity_rate}}
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                               Vat, Tax & Other Charge:
                            </td>
                            <td class="text-bold">
                                {{($BoqEmeUtilityBill->vat_tax_percent + $BoqEmeUtilityBill->demand_charge_percent + $BoqEmeUtilityBill->pfc_charge_percent + $BoqEmeUtilityBill->delay_charge_percent) * $electric_bill / 100 }}
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                                Electric Bill (Including Vat, Tax & Other Charge):
                            </td>
                            <td class="text-bold">
                                {{(($BoqEmeUtilityBill->vat_tax_percent + $BoqEmeUtilityBill->demand_charge_percent + $BoqEmeUtilityBill->pfc_charge_percent + $BoqEmeUtilityBill->delay_charge_percent) * $electric_bill / 100) + $electric_bill }}
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td class="getter">
                                Bill Name:
                            </td>
                            <td class="text-bold" class="getter1">
                                Electricity </br>
                                (Common Area)
                            </td>
                            <td class="getter2">
                               Meter No:
                            </td>
                            <td class="text-bold">
                                {{ $BoqEmeUtilityBill->meter_no }}
                            </td>
                        </tr>
                        <tr style="color:white;">
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                            <td>ada</td>
                        </tr>
                        <tr class="">
                            <td>
                               Bill Sharing of Com. Area
                            </td>
                            <td class="text-bold">
                                {{$BoqEmeUtilityBill->common_electric_amount}}
                            </td>
                           <td></td>
                           <td></td>
                        </tr>
                        <tr class="">
                            <td>
                               Total Electric:
                            </td>
                            <td class="text-bold">
                                {{(($BoqEmeUtilityBill->vat_tax_percent + $BoqEmeUtilityBill->demand_charge_percent + $BoqEmeUtilityBill->pfc_charge_percent + $BoqEmeUtilityBill->delay_charge_percent) * $electric_bill / 100) + $electric_bill + $BoqEmeUtilityBill->common_electric_amount }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="color:white;">
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                            <td>ada</td>
                        </tr>
                        @foreach ($BoqEmeUtilityBill->eme_utility_bill_detail as $key => $value)
                                <tr>
                                    <td class="getter">Bill Name:</td>
                                    <td class="getter1">{{ $value->other_cost_name }}</td>
                                    <td class="getter2"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    @php
                                        $iteration++
                                    @endphp
                                    <td> {{ $value->other_cost_name }} Charge (Tk)</td>
                                    <td> {{ $value->other_cost_amount }} </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="color:white;">
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>ada</td>
                                </tr>
                        @endforeach

                        <tr>
                            <td>Previous Due Bill (TK) </td>
                            <td>{{$BoqEmeUtilityBill->due_amount}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Payable</td>
                            <td>{{$BoqEmeUtilityBill->total_bill}}</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="getter">
                                Bill Name:
                            </td>
                            <td class="text-bold" class="getter1">
                                Electricity </br>
                                (Common Area)
                            </td>
                            <td class="getter2">
                               Meter No:
                            </td>
                            <td class="text-bold">
                                {{ $BoqEmeUtilityBill->meter_no }}
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                               Bill Sharing of Com. Area
                            </td>
                            <td class="text-bold">
                                {{$BoqEmeUtilityBill->common_electric_amount}}
                            </td>
                           <td></td>
                           <td></td>
                        </tr>
                        <tr class="">
                            <td>
                               Total Electric:
                            </td>
                            <td class="text-bold">
                                {{(($BoqEmeUtilityBill->vat_tax_percent + $BoqEmeUtilityBill->demand_charge_percent + $BoqEmeUtilityBill->pfc_charge_percent + $BoqEmeUtilityBill->delay_charge_percent) * $electric_bill / 100) + $electric_bill + $BoqEmeUtilityBill->common_electric_amount }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                    </table>
                </div>
                {{-- <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr>
                            <td class="getter">
                                Bill Name:
                            </td>
                            <td class="text-bold" class="getter1">
                                Electricity </br>
                                (Common Area)
                            </td>
                            <td class="getter2">
                               Meter No:
                            </td>
                            <td class="text-bold">
                                {{ $BoqEmeUtilityBill->meter_no }}
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                               Bill Sharing of Com. Area
                            </td>
                            <td class="text-bold">
                                {{$BoqEmeUtilityBill->common_electric_amount}}
                            </td>
                           <td></td>
                           <td></td>
                        </tr>
                        <tr class="">
                            <td>
                               Total Electric:
                            </td>
                            <td class="text-bold">
                                {{(($BoqEmeUtilityBill->vat_tax_percent + $BoqEmeUtilityBill->demand_charge_percent + $BoqEmeUtilityBill->pfc_charge_percent + $BoqEmeUtilityBill->delay_charge_percent) * $electric_bill / 100) + $electric_bill + $BoqEmeUtilityBill->common_electric_amount }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                    </table>
                </div> --}}
                {{-- <p>
                    Clint Name: {{ $BoqEmeUtilityBill->client->name }}
                </p>
                <br>
                <p>
                    Apartment Name: {{ $BoqEmeUtilityBill->apartment->name }}
                </p> --}}
            </div>
        </div>
        {{-- <div class="container" style="margin-top: 30px;">
            <table class="customers">
                <tbody style="text-align: center">
                    @foreach ($BoqEmeUtilityBill->eme_utility_bill_detail as $key => $value)
                            <tr>
                                <td class="getter">Bill Name:</td>
                                <td class="getter1">{{ $value->other_cost_name }}</td>
                                <td class="getter2"></td>
                                <td></td>
                            </tr>
                            <tr>
                                @php
                                    $iteration++
                                @endphp
                                <td> {{ $value->other_cost_name }} Charge (Tk)</td>
                                <td> {{ $value->other_cost_amount }} </td>
                                <td></td>
                                <td></td>
                            </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Previous Due Bill (TK) </td>
                        <td>{{$BoqEmeUtilityBill->due_amount}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total Payable</td>
                        <td>{{$BoqEmeUtilityBill->total_bill}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            {{-- <div class="container" id="fixed_footer">
                <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr>
                            <td>
                                <p>Remarks from Project/Site: {{ $requisitions[0]->remarks }} </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr>
                            <td>
                                <p>Remarks by Inventory Management: </p>
                            </td>
                            <td>
                                <p>Remarks by Construction Department: </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 30px;">
                    <table class="customers">
                        <tr>
                            <td>
                                <p>Remarks by Inventory Management: </p>
                            </td>
                            <td>
                                <p>Remarks by Construction Department: </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 30px;">
                    <table class="approval" style="text-align: center; border:none!important">
                        <tr>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Store in-charge</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Project Incharge</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Project Cordinator</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Inventory Management</p>
                            </td>
                            <td>
                                <p style="margin-top: 50px;">---------------------</p>
                                <p>Approved By</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> --}}
        {{-- @if (!$loop->last)
            <div class="page_break"></div>
        @endif --}}
        <script>
              function cssStyle(){
            let $setter = $("#setter");
                $(".getter").css("width", $setter.width()+"px");
            let $setter1 = $("#setter1");
                $(".getter1").css("width", $setter1.width()+"px");
            let $setter2 = $("#setter2");
                $(".getter2").css("width", $setter2.width()+"px");
        }
        $(document).ready(function() {
            cssStyle()
            $(document).on('click change',function(){
                cssStyle()
            })
        });
        </script>
</body>

</html>
