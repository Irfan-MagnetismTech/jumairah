@extends('layouts.backend-layout')
@section('title', 'Yearly Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of admin yearly budget
@endsection


@section('breadcrumb-button')
    @can('admin-yearly-budget-create')
        <a href="{{ route('admin-yearly-budgets.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
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
                <th>Date</th>
                <th>Year</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Entry By</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($budgets as $key => $budget)
                @php($rows = $budget->adminYearlyBudgetDetails->count())
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">{{$budget->date}}</td>
                    <td class="">{{$budget->year}}</td>
                    <td class=" ">
                        @foreach($budget->adminYearlyBudgetDetails as $key => $data)
                            {{date('M Y', strtotime("$data->month"))}} <br>
                        @endforeach
                            @if($rows > 1)
                                <hr class="m-0 p-0">
                                <strong class="text-right">Total</strong>
                            @endif
                    </td>
                    <td class="text-right">
                        @foreach($budget->adminYearlyBudgetDetails as $key => $data)
                           @money($data->amount) <br>
                        @endforeach
                        @if($rows > 1)
                            <hr class="m-0 p-0">
                            <strong class="text-right">@money($totalSV = $budget->adminYearlyBudgetDetails->flatten()->sum('amount'))</strong>
                        @endif
                    </td>
                    <td class="text-right"> {{$budget->user->name}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
{{--                                <a href="{{ url("admin-yearly-budgets/$budget->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>--}}
                                <a href="{{ url("admin-yearly-budgets/$budget->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "admin-yearly-budgets/$budget->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
