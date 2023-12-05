@extends('boq.departments.electrical.layout.app')
@section('project-name', $project->name)
@section('title', 'BOQ - EME Home')

@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="3">
                <h4>Project name - {{ $project->name }}</h4>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @php
                $perSFTCost = 0;
                $totalBuildUpArea = number_format($project->boqFloorProjects()->sum('area'),2);
                $totalCost = $BoqEmeCalculationDetails->sum('total_amount') ?? 0;
                $perSFTCost = $totalCost > 0 ? $project->boqFloorProjects()->sum('area') / $totalCost : 0;

                $boqEmeBudgetMainAmounts = $project->BoqEmeBudget->sum('amount');
                if($totalCost > $boqEmeBudgetMainAmounts){
                    $boqEmeBudgetIncrementalAmounts = $boqEmeBudgetMainAmounts - $totalCost;
                }else{
                    $boqEmeBudgetIncrementalAmounts = 0;
                }
                $totalAmount = $boqEmeBudgetMainAmounts + abs($boqEmeBudgetIncrementalAmounts);
            @endphp

            <td colspan="2" style="width:90%">
                <h6>Total buildup area - {{$totalBuildUpArea}}   Sft</h6>
                <h6>Per Sft Cost - {{number_format($perSFTCost, 4)}}</h6>
            </td>
            <td colspan="1" class="text-right" style="width:10%">
                <span class="">
                    <h6 class="cstm_row">
                      <span class="cstm_cell">Main Budget:  </span>
                      <span class="cstm_cell">{{ $boqEmeBudgetMainAmounts }}</span>
                    </h6>
                    <h6 class="cstm_row">
                        <span class="cstm_cell">Incremental Budget:</span>
                        <span class="cstm_cell">{{ abs($boqEmeBudgetIncrementalAmounts) }}</span>
                    </h6>
                    <hr class="my-0">
                    <h6 class="cstm_row">
                        <span class="cstm_cell">Total:  </span>
                        <span class="cstm_cell">{{ $totalAmount }}</span>
                    </h6>
              </span>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Description of Items</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
            @foreach($budgets as $key => $item)
                <tr>
                    <td class="text-left"><b>{{$item->EmeBudgetHead->name}}</b></td>
                    <td class="text-right">@money($item->amount)</td>
                </tr>
            @endforeach
        <tr class="">
            <th colspan="">Total</th>
            <th colspan="">@money($budgets->sum('amount'))</th>
{{--            <th colspan="">@money($BoqEmeCalculationDetails->sum('total_material_amount'))</th>--}}
{{--            <th colspan="">@money($BoqEmeCalculationDetails->sum('total_labour_amount'))</th>--}}
        </tr>
        <tr class="">
            <th colspan="">Total Cost</th>
            <th colspan="" class="text-right">@money($totalCost)</th>
        </tr>
        </tbody>
    </table>
@endsection
