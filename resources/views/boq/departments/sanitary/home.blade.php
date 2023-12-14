@extends('boq.departments.sanitary.layout.app')
{{--@section('project-name', $project->name)--}}
@section('title', 'BOQ - Sanitary Home')
@section('style')
<style>

.cstm_table {
   display: table;
}

.cstm_row {
   display: table-row;
}

.cstm_cell {
   display: table-cell;
}

.cstm_row,
.cstm_cell {
  padding: 5px;
}
</style>
@endsection
@section('content')
        @php
            //dd($project->sanitaryBudgetSummaryIncremental()->exists());
            //$budgetIncrementalAmounts = $project->sanitaryBudgetSummaryIncremental()->exists() ?  : 0;
            $budgetIncrementalAmounts = $project->sanitaryBudgetSummaryIncremental()->exists() ?  $project->sanitaryBudgetSummaryIncremental->sum('total_amount') : 0;
            $budgetMainAmounts = $project->sanitaryBudgetSummary()->exists() ? $project->sanitaryBudgetSummary->total_amount : 0;
            $totalBudgetedamount = $budgetMainAmounts + $budgetIncrementalAmounts;
            $totalMaterial = $summariesData->flatten()->sum('amount') ?? 0;
            $totalLabor = $project->projectWiseLAborCost->sum('totalLabourAmount');
            $totalAmount = $totalMaterial + $totalLabor;
            //dd($budgetIncrementalAmounts);
        @endphp
    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="10">
                <h4>Project name - {{ $project->name }}</h4>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="9" style="width:90%">
                <h6>Total buildup area - {{ number_format($project->boqFloorProjects()->sum('area'),2) }}   Sft</h6>
                <h6>Per Sft Cost - {{ $project->sanitaryBudgetSummary()->exists() ? number_format($totalAmount / $project->boqFloorProjects()->sum('area'),2) : 0 }}</h6>
            </td>
            <td colspan="1" class="text-right" style="width:10%">
                <span class="">
                    <h6 class="cstm_row">
                      <span class="cstm_cell">Main Budget - </span>
                      <span class="cstm_cell">{{ number_format($budgetMainAmounts,2) }} </span>
                    </h6>
                    <h6 class="cstm_row">
                        <span class="cstm_cell">Incremental Budget - </span>
                        <span class="cstm_cell">{{ number_format($budgetIncrementalAmounts,2) }} </span>
                    </h6>
                    <hr class="my-0">
                    <h6 class="cstm_row">
                        <span class="cstm_cell">Total - </span>
                        <span class="cstm_cell">{{ number_format($totalBudgetedamount,2) }} </span>
                    </h6>
              </span>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered" style="font-size: 12px">
        <thead>
        <tr>
            <th>Description of Items</th>
            <th>Amount in (Tk)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($summariesData as $summaryData)
            <tr>
                <td>
                    @can('boq-sanitary')
                        <a href="{{ route('boq.project.departments.sanitary.project-wise-materials-create', ['project' => $project,'parent_id' => $summaryData->id]) }}">
                    @endcan
                        Total Cost for - <b>{{$summaryData->name ?? ''}}</b>
                    </a>
                </td>
                <td class="text-right"><b>@money($summaryData->amount)</b></td>
            </tr>
        @endforeach
            <tr>
                <td> Total Cost for - <strong>Unforseen Materials</strong></td>
                <td class="text-right"> <b>@money($totalBudgetedamount - $totalAmount)</b></td>
            </tr>
        <tr class="">
            <th colspan="">Total Materials Cost</th>
            <th colspan="" class="text-right">@money($totalBudgetedamount - $totalAmount + $totalMaterial)</th>
        </tr>
        <tr class="">
            <th colspan="">
                @can('boq-sanitary')
                <a style="color: white" href="{{ route('boq.project.departments.sanitary.project-wise-labor-cost.create', ['project' => $project]) }}">
                @endcan
                    Total Labour Cost @can('boq-sanitary')<i class="fa fa-link"></i>@endcan</a>
            </th>
            <th colspan="" class="text-right">@money($project->projectWiseLAborCost->sum('totalLabourAmount'))</th>
        </tr>
        <tr class="">
            <th colspan="">Total Cost</th>
            <th colspan="" class="text-right">@money($totalBudgetedamount - $totalAmount + $totalMaterial + $project->projectWiseLAborCost->sum('totalLabourAmount'))</th>
        </tr>

        </tbody>
    </table>
@endsection
