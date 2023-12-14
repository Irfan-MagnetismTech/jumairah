@extends('layouts.backend-layout')
@section('title', 'Material Budget')

@section('breadcrumb-button')
    <a href="{{route('budget-deshboard-pdf',['dates'=>$dates])}}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
@endsection

@section('content')
   
    
    <div class="row">
        <div class="col-md-12">
            <div class="tableHeading">
                <h5> Material Budget for The Month of {{ DateTime::createFromFormat('!m', $month)->format('F') . ', ' . $year }} </h5>
            </div>
            <div class="table-responsive">
                <table id="Table" class="table table-striped table-sm text-center table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">SL No</th>
                            <th rowspan="2" width="200">Project Name</th>
                            <th>Week-1</th>
                            <th>Week-2</th>
                            <th>Week-3</th>
                            <th>Week-4</th>
                            <th >Total Amount</th>
                        </tr>
                        <tr>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                            <th>Required Material <br> Value (BDT.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $week_one_grand_total = 0;
                            $week_two_grand_total = 0;
                            $week_three_grand_total = 0;
                            $week_four_grand_total = 0;
                            $week_grand_total = 0;
                        @endphp
                        @foreach($materialPlans as $key => $materialPlan)
                            @php 
                                $weekOne = 0;
                                $weekTwo = 0;
                                $weekThree = 0;
                                $weekFour = 0;
                            @endphp
                            @foreach($materialPlan->materialPlanDetails as $materialPlanDetail)
                                @php 
                                    $weekOne += $materialPlanDetail->week_one * $materialPlanDetail->week_one_rate;
                                    $weekTwo += $materialPlanDetail->week_two * $materialPlanDetail->week_two_rate;
                                    $weekThree += $materialPlanDetail->week_three * $materialPlanDetail->week_three_rate;
                                    $weekFour += $materialPlanDetail->week_four * $materialPlanDetail->week_four_rate;
                                    $totalAmount = $weekOne + $weekTwo + $weekThree + $weekFour;
                                @endphp
                            @endforeach
                            @php
                                $week_one_grand_total += $weekOne;
                                $week_two_grand_total += $weekTwo;
                                $week_three_grand_total += $weekThree ;
                                $week_four_grand_total += $weekFour;
                                $week_grand_total += $totalAmount;
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $materialPlan->projects->name }}</td> 
                                <td>@money($weekOne)</td>
                                <td>@money($weekTwo)</td>
                                <td>@money($weekThree)</td>
                                <td>@money($weekFour)</td>
                                <td>@money($totalAmount)</td>
                            </tr> 
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="2">Grand Total BDT.</th>
                        <th>@money($week_one_grand_total)</th>
                        <th>@money($week_two_grand_total)</th>
                        <th>@money($week_three_grand_total)</th>
                        <th>@money($week_four_grand_total)</th>
                        <th>@money($week_grand_total)</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
