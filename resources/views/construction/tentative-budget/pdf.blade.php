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
            border: 1px solid #ddd;
            padding: 5px;
        }

        .customers tr:nth-child(even){
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
        $iteration = 1;
        $itemCount = 0;
    @endphp

    @foreach ( $tentative_budget->tentativeBudgetDetails->chunk(10) as $key1 => $datas )

    <div>
        <div class="container" id="fixed_header">
            <div class="row">
                <div class="head1" style="padding-left: 280px; text-align: center">
                    <img src="{{ asset('images/ranksfc_log.png') }}" alt="Rangsfc">
                    <p>
                        Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road, <br>Agrabad C/A, Chattogram.
                        Phone: 2519906-8; 712023-5<br>
                        <a style="color:#000;" target="_blank">www.ranksfc.com</a>
                    </p>
                    <h3>
                        Budget of Business Development (Aproximate) <br>
                        January to December {{ date('Y', strtotime($tentative_budget->applied_date)) }}
                    </h3>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>

    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <thead>
                <tr>
                    <th width="80px" rowspan="2">Project Name</th>
                    <th colspan="2">January</th>
                    <th colspan="2">February</th>
                    <th colspan="2">March</th>
                    <th colspan="2">April</th>
                    <th colspan="2">May</th>
                    <th colspan="2">June</th>
                    <th colspan="2">July</th>
                    <th colspan="2">August</th>
                    <th colspan="2">September</th>
                    <th colspan="2">October</th>
                    <th colspan="2">November</th>
                    <th colspan="2">December</th>
                    <th rowspan="2">Total</th>
                    <th>Targeted Build <br/> up area</th>
                </tr>
                <tr>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Material</th>
                    <th>Labor</th>
                    <th>Sft</th>
                </tr>
                </thead>
            <tbody style="text-align: center">
                    @foreach ($datas as $key2 => $data)
                        <tr>
                            <td> {{$data->costCenter->name }}</td>
                            <td >{{ $data->january_material }} </td>
                            <td >{{ $data->january_labor }} </td>
                            <td> {{ $data->february_material }} </td>
                            <td> {{ $data->february_labor }} </td>
                            <td> {{ $data->march_material }} </td>
                            <td> {{ $data->march_labor }} </td>
                            <td> {{ $data->april_material }} </td>
                            <td> {{ $data->april_labor }} </td>
                            <td> {{ $data->may_material }} </td>
                            <td> {{ $data->may_labor }} </td>
                            <td> {{ $data->june_material }} </td>
                            <td> {{ $data->june_labor }} </td>
                            <td> {{ $data->july_material }} </td>
                            <td> {{ $data->july_labor }} </td>
                            <td> {{ $data->august_material }} </td>
                            <td> {{ $data->august_labor }} </td>
                            <td> {{ $data->september_material }} </td>
                            <td> {{ $data->september_labor }} </td>
                            <td> {{ $data->october_material }} </td>
                            <td> {{ $data->october_labor }} </td>
                            <td> {{ $data->november_material }} </td>
                            <td> {{ $data->november_labor }} </td>
                            <td> {{ $data->december_material }} </td>
                            <td> {{ $data->december_labor }} </td>
                            <td> {{ $data->amount }} </td>
                            <td> {{ $data->tergeted_build_up_area }} </td>
                        </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1" style="text-align: center">Total Amount <br/>
                        in Tk</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('january_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('january_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('february_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('february_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('march_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('march_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('april_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('april_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('may_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('may_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('june_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('june_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('july_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('july_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('august_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('august_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('september_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('september_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('october_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('october_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('november_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('november_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('december_material'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('december_labor'); }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('amount') }}</td>
                    <td style="text-align: center">{{ $tentative_budget->tentativeBudgetDetails->chunk(10)[$key1]->sum('tergeted_build_up_area') }}</td>

                </tr>
            </tfoot>
        </table>
    </div>



    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

</body>
</html>
