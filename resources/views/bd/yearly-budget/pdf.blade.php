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
    @foreach ( $bd_yearly_budget_details as $chunk )

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
                        January to December {{ $chunk->year }}
                    </h3>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>

    </div>
    

    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <tr>
                <td colspan="17" style="text-align: center"> Project in Progress </td>
            </tr>
            <thead>
                <tr>
                    <th>SL No</th>
                    <th width="150px">Project Name</th>
                    <th>Particulers</th>
                    <th>Remarks</th>
                    <th>January</th>
                    <th>February</th>
                    <th>March</th>
                    <th>April</th>
                    <th>May</th>
                    <th>June</th>
                    <th>July</th>
                    <th>August</th>
                    <th>September</th>
                    <th>October</th>
                    <th>November</th>
                    <th>December</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @php 
                    $costCenterGroups = $chunk->BdProgressYearlyBudget->groupBy('progress_cost_center_id');
                @endphp
                    @foreach ($costCenterGroups as $groupkey => $bdProgressBudgets)
                    @php $rows = count($bdProgressBudgets); @endphp
                        @foreach ($bdProgressBudgets as $bdProgressBudget)
                        <tr>
                            <td> {{ $iteration++ }}</td>
                            @if($loop->first)
                             <td rowspan= "{{ $rows }}"> {{ $bdProgressBudget->costCenter->name }}     
                            </td>
                            @endif
                            
                            <td >{{ $bdProgressBudget->progress_particulers }} </td> 
                            <td> {{ $bdProgressBudget->progress_remarks }} </td>
                            <td> {{ $bdProgressBudget->progress_january }} </td>
                            <td> {{ $bdProgressBudget->progress_february }} </td>
                            <td> {{ $bdProgressBudget->progress_march }} </td>
                            <td> {{ $bdProgressBudget->progress_april }} </td>
                            <td> {{ $bdProgressBudget->progress_may }} </td>
                            <td> {{ $bdProgressBudget->progress_june }} </td>
                            <td> {{ $bdProgressBudget->progress_july }} </td>
                            <td> {{ $bdProgressBudget->progress_august }} </td>
                            <td> {{ $bdProgressBudget->progress_september }} </td>
                            <td> {{ $bdProgressBudget->progress_october }} </td>
                            <td> {{ $bdProgressBudget->progress_november }} </td>
                            <td> {{ $bdProgressBudget->progress_december }} </td>
                            <td> {{ $bdProgressBudget->progress_amount }} </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center">Total cost of projects in progress:</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_january') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_february') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_march') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_april') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_may') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_june') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_july') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_august') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_september') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_october') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_november') }}</td>
                    <td style="text-align: center">{{ $chunk->BdProgressYearlyBudget->sum('progress_december') }}</td>
                    <td style="text-align: center">{{ $bd_yearly_budget_details[0]->progress_total_amount }}</td>
                </tr>
            </tfoot>
        </table>
    </div>


    <div class="container" style="margin-top: 25px;">
        <table class="customers">
            <tr>
                <td colspan="17" style="text-align: center"> Project in Future </td>
            </tr>
            <thead>
                <tr>
                    <th>SL No</th>
                    <th width="150px">Project Name</th>
                    <th >Particulers</th>
                    <th>Remarks</th>
                    <th>January</th>
                    <th>February</th>
                    <th>March</th>
                    <th>April</th>
                    <th>May</th>
                    <th>June</th>
                    <th>July</th>
                    <th>August</th>
                    <th>September</th>
                    <th>October</th>
                    <th>November</th>
                    <th>December</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                @php 
                    $futureCostCenterGroups = $chunk->BdFutureYearlyBudget->groupBy('future_cost_center_id');
                    $i =1;
                @endphp
                @foreach ($futureCostCenterGroups as $groupkey => $bdFutureBudgets)
                @php $rows = count($bdFutureBudgets);  @endphp
                    @foreach ($bdFutureBudgets as $bdFutureBudget)
                <tr>
                    <td> {{ $i++ }}</td>
                    @if($loop->first)
                        <td rowspan= "{{ $rows }}"> {{ $bdFutureBudget->costCenter->name }} </td>
                    @endif
                    <td> {{ $bdFutureBudget->future_particulers }} </td>
                    <td> {{ $bdFutureBudget->future_remarks }} </td>
                    <td> {{ $bdFutureBudget->future_january }} </td>
                    <td> {{ $bdFutureBudget->future_february }} </td>
                    <td> {{ $bdFutureBudget->future_march }} </td>
                    <td> {{ $bdFutureBudget->future_april }} </td>
                    <td> {{ $bdFutureBudget->future_may }} </td>
                    <td> {{ $bdFutureBudget->future_june }} </td>
                    <td> {{ $bdFutureBudget->future_july }} </td>
                    <td> {{ $bdFutureBudget->future_august }} </td>
                    <td> {{ $bdFutureBudget->future_september }} </td>
                    <td> {{ $bdFutureBudget->future_october }} </td>
                    <td> {{ $bdFutureBudget->future_november }} </td>
                    <td> {{ $bdFutureBudget->future_december }} </td>
                    <td> {{ $bdFutureBudget->future_amount }} </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center">Total cost of projects in future:</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_january') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_february') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_march') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_april') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_may') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_june') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_july') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_august') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_september') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_october') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_november') }}</td>
                    <td style="text-align: center">{{ $chunk->BdFutureYearlyBudget->sum('future_december') }}</td>
                    <td style="text-align: center">{{ $bd_yearly_budget_details[0]->future_total_amount }}</td>
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
                            {{ $bd_yearly_budget_details[0]->total_amount }} 
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
