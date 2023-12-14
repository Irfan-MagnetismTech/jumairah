@extends('layouts.backend-layout')
@section('title', 'Lead Generations')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Sales Yearly Plan
@endsection


@section('breadcrumb-button')
    @can('sales-yearly-budget-create')
        <a href="{{ route('sales-yearly-budgets.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($budgets) }}
@endsection


@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Project Name</th>
                <th>Year</th>
                <th>Month</th>
                <th>Sales Value</th>
                <th>Booking Money</th>
                <th>Total</th>
                <th>Entry By</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($budgets as $key => $budget)
                @php($rows = $budget->salesYearlyBudgetDetails->count())
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">{{$budget->project->name}}</td>
                    <td class="">{{$budget->year}}</td>
                    <td class=" ">
                        @foreach($budget->salesYearlyBudgetDetails as $key => $data)
                            {{date('M Y', strtotime("$data->month"))}} <br>
                        @endforeach
                            @if($rows > 1)
                                <hr class="m-0 p-0">
                                <strong class="text-right">Total</strong>
                            @endif
                    </td>
                    <td class="text-right">
                        @foreach($budget->salesYearlyBudgetDetails as $key => $data)
                           @money($data->sales_value) <br>
                        @endforeach
                        @if($rows > 1)
                            <hr class="m-0 p-0">
                            <strong class="text-right">@money($totalSV = $budget->salesYearlyBudgetDetails->flatten()->sum('sales_value'))</strong>
                        @endif
                    </td>
                    <td class="text-right">
                        @foreach($budget->salesYearlyBudgetDetails as $key => $data)
                           @money($data->booking_money) <br>
                        @endforeach
                        @if($rows > 1)
                            <hr class="m-0 p-0">
                            <strong class="text-right">@money($totalBM = $budget->salesYearlyBudgetDetails->flatten()->sum('booking_money'))</strong>
                        @endif
                    </td>
                    <td class="text-right">@money($totalSV + $totalBM)</td>
                    <td class="text-right"> {{$budget->user->name}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
{{--                                <a href="{{ url("sales-yearly-budgets/$budget->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>--}}
                                <a href="{{ url("sales-yearly-budgets/$budget->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "sales-yearly-budgets/$budget->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
