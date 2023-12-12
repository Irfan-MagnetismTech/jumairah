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
    @foreach ( $bd_budget_details as $chunk )
    {{-- @dd($chunk->BdProgressBudget); --}}

    <div>
        <div class="container" id="fixed_header">
            <div class="row">
                <div class="head1" style="padding-left: 180px; text-align: center">
                    <img src="{{ asset(config('company_info.logo')) }}" alt="{!! htmlspecialchars(config('company_info.altText')) !!}">
                    <p>
                        Atlas Rangs Plaza (Level- 9 & 10), 7, SK Mujib Road,<br> Agrabad C/A, Chattogram.
                        Phone: {!! htmlspecialchars(config('company_info.company_phone')) !!}<br>
                        <a style="color:#000;" target="_blank">{!! htmlspecialchars(config('company_info.company_email')) !!}</a>
                    </p>
                    <h3>
                        Budget of Business Development (Aproximate) <br>
                        {{ DateTime::createFromFormat('!m', $chunk->month)->format('F') . ', ' . $chunk->year }}
                    </h3>
                </div>
            </div>
        </div>

        <div style="clear: both"></div>

    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <tr>
                <td colspan="5" style="text-align: center"> Project in Progress </td>
            </tr>
            <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Project Name</th>
                    <th>Particulers</th>
                    <th>Budget<br>Amount</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody style="text-align: center">

                {{-- @php
                    $group_cost_ceneter_id = $chunk->BdProgressBudget->groupBy('progress_cost_center_id')
                @endphp --}}
                @foreach ($chunk->BdProgressBudget as  $Bd_progress_budget_details)
                <tr>
                    <td> {{$iteration++}} </td>

                    <td> {{ $Bd_progress_budget_details->costCenter->name }} </td>
                    <td> {{ $Bd_progress_budget_details->progress_particulers }} </td>
                    <td> {{ $Bd_progress_budget_details->progress_amount }} </td>
                    <td> {{ $Bd_progress_budget_details->progress_remarks }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: center">Monthly cost of projects in progress:</td>
                    <td style="text-align: center">{{ $bd_budget_details[0]->progress_total_amount }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <tr>
                <td colspan="5" style="text-align: center"> Project in Future </td>
            </tr>
            <thead>
                <tr>
                    <th>SL No.</th>
                    <th>Project Name</th>
                    <th>Particulers</th>
                    <th>Budget<br>Amount</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody style="text-align: center">

                @foreach ($chunk->BdFutureBudget as $Bd_future_budget_details)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $Bd_future_budget_details->costCenter->name }} </td>
                    <td> {{ $Bd_future_budget_details->future_particulers }} </td>
                    <td> {{ $Bd_future_budget_details->future_amount }} </td>
                    <td> {{ $Bd_future_budget_details->future_remarks }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: center">Monthly cost of projects in future:</td>
                    <td style="text-align: center">{{ $bd_budget_details[0]->future_total_amount }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div    >
            <div  style="margin-top: 30px;">
                <table class="customers">
                    <tr style="text-align: center">
                        <td >
                            Total Payable Amount:
                        </td>
                        <td >
                            {{ $bd_budget_details[0]->total_amount }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach

</body>
</html>
