@extends('layouts.backend-layout')
@section('title', 'Existing Budget')

@section('breadcrumb-title')
   Materail-wise Summary for {{$projectName->name}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url("supreme-budget-show/$budgetFor/$project_id") }}" data-toggle="tooltip" title="Floor Wise Summery" class="btn btn-out-dashed btn-sm btn-primary"><i class="ti-list"></i></a>
    @can('boqSupremeBudgets-edit')
    <a href="{{ url("supreme-budget-edit/$budgetFor/$project_id") }}" data-toggle="tooltip" title="Edit" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i></a>
    @endcan
    <a href="{{ url("supreme-budget-list/$budgetFor") }}" data-toggle="tooltip" title="Projects" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>

@endsection


@section('content-grid','offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-center">
                        <tr  style="background-color: #0C4A77;color: white">
                            <td> <strong>{{ $projectName->name }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Material Name</th>
                    <th>Floor Name</th>
                    <th>Floor Wise <br>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach( $boq_supreme_budget_data as $key => $boq_supreme_budget)
                @php
                    $sum = 0;
                @endphp
                @foreach($boq_supreme_budget as $value)
                    <tr>
                        @if ($loop->first)
                        <td rowspan="{{count($boq_supreme_budget)}}">{{ $loop->parent->iteration }}</td>
                        <td rowspan="{{count($boq_supreme_budget)}}">  {{$value->nestedMaterial->name}} </td>
                        @endif
                        <td> {{$value->boqFloorProject->floor->name}} </td>
                        <td> {{$value->quantity}} </td>
                        @php
                            $sum += $value->quantity;
                        @endphp
                        @if ($loop->first)
                            <td rowspan="{{count($boq_supreme_budget)}}"> {{$boq_supreme_budget->sum('quantity')}} </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
