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
            margin: 10px;
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

        .customers td, .customers th {
            border: 1px solid rgb(180, 177, 177);
            padding: 8px;
        }

        .customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        .approval {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .approval td, .approval th {
            border: 1px solid #fff;
            padding: 5px;
        }

        /*header - position: fixed */
        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }

        /*fixed_footer - position: fixed */
        #fixed_footer {
            position: fixed;
            width: 94.4%;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .page_break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    @php
        $iteration1 = 1;
        $iteration2 = 1;
    @endphp
@foreach ($materialPlan->materialPlanDetails->chunk(15) as $chunk_data )

            <div>
                <div class="container" id="fixed_header">
                    <div class="row">
                        <div class="head1" style="padding-left: 280px; text-align: center">
                            <img src="{{ asset(config('company_info.logo')) }}" alt="Rangsfc">
                            <p>
                                JHL Address.<br>
                                Phone: JHL Phone Number<br>
                                <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                            </p>
                            <h3>
                                Material Budget for The Month of {{ DateTime::createFromFormat('!m', $month)->format('F') . ', ' . $year }}<br>
                                {{ $materialPlan->projects->name }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>


            <div class="container" >
                <table class="customers">
                    <thead>
                        <tr>
                            <th rowspan="2" >Material Name</th>
                            <th rowspan="2">Unit</th>
                            <th colspan="3">Week-1</th>
                            <th colspan="3">Week-2</th>
                            <th colspan="3">Week-3</th>
                            <th colspan="3">Week-4</th>
                            <th rowspan="2">Remarks</th>
                            <th rowspan="2">Grand Total<br>Amount(BDT.)</th>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Value (BDT.)</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Value (BDT.)</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Value (BDT.)</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Value (BDT.)</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @php
                            $weekOneTotal = 0; $weekTwoTotal = 0; $weekThreeTotal = 0; $weekFourTotal = 0; $week_grand_total = 0;
                        @endphp

                        @foreach ($chunk_data as $data)
                            @php
                                $weekOneTotal += $weekOne = $data->week_one * $data->week_one_rate;
                                $weekTwoTotal += $weekTwo = $data->week_two * $data->week_two_rate;
                                $weekThreeTotal += $weekThree = $data->week_three * $data->week_three_rate;
                                $weekFourTotal += $weekFour = $data->week_four * $data->week_four_rate;
                                $week_grand_total += $totalAmount = $weekOne + $weekTwo + $weekThree + $weekFour;
                            @endphp
                           <tr>
                                <td>{{ $data->nestedMaterials->name }}</td>
                                <td>{{ $data->nestedMaterials->unit->name }}</td>
                                <td>{{ $data->week_one }}</td>
                                <td>{{ $data->week_one_rate ?? 0 }}</td>
                                <td>@money($data->week_one * $data->week_one_rate)</td>
                                <td>{{ $data->week_two }}</td>
                                <td>{{ $data->week_two_rate ?? 0 }}</td>
                                <td>@money($data->week_two * $data->week_two_rate)</td>
                                <td>{{ $data->week_three }}</td>
                                <td>{{ $data->week_three_rate ?? 0 }}</td>
                                <td>@money($data->week_three * $data->week_three_rate)</td>
                                <td>{{ $data->week_four }}</td>
                                <td>{{ $data->week_four_rate ?? 0 }}</td>
                                <td>@money($data->week_four * $data->week_four_rate)</td>
                                <td>{{ $data->remarks }}</td>
                                <td>@money($totalAmount) </td>
                            </tr>
                        @endforeach
                            <tr>
                                <td class="align-middle">
                                    <p>Total</p>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> @money($weekOneTotal) </td>
                                <td></td>
                                <td></td>
                                <td> @money($weekTwoTotal) </p></td>
                                <td></td>
                                <td></td>
                                <td> @money($weekThreeTotal) </td>
                                <td></td>
                                <td></td>
                                <td> @money($weekFourTotal) </td>
                                <td></td>
                                <td> @money($week_grand_total)</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

    <script type="text/javascript">
        $(document).ready(function() {
        var a = 0;
         $('.value').each(function() {
                         let qty = $(this).parent('td').prev().find('.rate').val();
                         let rate = $(this).parent('td').prev().prev().find('.qty').val();
                         $(this).val(qty * rate);
                     });

         $('.rate').on('change keyup', function() {
             let qty = $(this).parent('td').prev().find('.qty').val();
             let rate = $(this).val();
             $(this).parent('td').next().find('.value').val(qty*rate);
             Get_total();
         })
         function Get_total(){

             let week1 = 0;
             let week2 = 0;
             let week3 = 0;
             let week4 = 0;
             $('.week1').each(function() {
                         week1 += Number($(this).val());
                     });
             $('.week2').each(function() {
                         week2 += Number($(this).val());
                     });
             $('.week3').each(function() {
                         week3 += Number($(this).val());
                     });
             $('.week4').each(function() {
                         week4 += Number($(this).val());
                     });
             $('.total_week1').text(week1);
             $('.total_week2').text(week2);
             $('.total_week3').text(week3);
             $('.total_week4').text(week4);
             $('.grand').text(week1 + week2 + week3 + week4);
             $('.total_quantity').each(function() {
                         let row_week1= Number($(this).closest('tr').find('.week1').val());
                         let row_week2= Number($(this).closest('tr').find('.week2').val());
                         let row_week3= Number($(this).closest('tr').find('.week3').val());
                         let row_week4= Number($(this).closest('tr').find('.week4').val());
                         $(this).text(row_week1 + row_week2 + row_week3 + row_week4);
                     });
         }
         Get_total();
         })
        </script>
</body>
</html>
