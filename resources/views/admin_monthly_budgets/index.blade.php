@extends('layouts.backend-layout')
@section('title', 'Monthly Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of admin monthly budget
@endsection


@section('breadcrumb-button')
    @can('admin-monthly-budget-create')
        <a href="{{ route('admin-monthly-budgets.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
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
                <th>Month</th>
                <th>Week One</th>
                <th>Week Two</th>
                <th>Week Three</th>
                <th>Week Four</th>
                <th>Week Five</th>
                <th>Amount</th>
                <th>Entry By</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($budgets as $key => $budget)
                @php($rows = $budget->adminMonthlyBudgetDetails->count())
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">{{$budget->date}}</td>
                    <td class="">{{$budget->month}}</td>
                    <td class=" ">
                        @foreach($budget->adminMonthlyBudgetDetails as $key => $week_one)
                            {{ $week_one->week_one }} <br>
                        @endforeach
                            @if($rows > 1)
                                <hr class="m-0 p-0">
                                <strong class="text-right">Total</strong>
                            @endif
                    </td>
                    <td class=" ">
                        @foreach($budget->adminMonthlyBudgetDetails as $key => $week_two)
                            {{ $week_two->week_two }} <br>
                        @endforeach
                            @if($rows > 1)
                                <hr class="m-0 p-0">
                                <strong class="text-right">Total</strong>
                            @endif
                    </td>
                    <td class=" ">
                        @foreach($budget->adminMonthlyBudgetDetails as $key => $data)
                            {{ $data->week_three }} <br>
                        @endforeach
                            @if($rows > 1)
                                <hr class="m-0 p-0">
                                <strong class="text-right">Total</strong>
                            @endif
                    </td>
                    <td class=" ">
                        @foreach($budget->adminMonthlyBudgetDetails as $key => $data)
                            {{ $data->week_four }} <br>
                        @endforeach
                            @if($rows > 1)
                                <hr class="m-0 p-0">
                                <strong class="text-right">Total</strong>
                            @endif
                    </td>
                    <td class=" ">
                        @foreach($budget->adminMonthlyBudgetDetails as $key => $data)
                            {{ $data->week_five }} <br>
                        @endforeach
                            @if($rows > 1)
                                <hr class="m-0 p-0">
                                <strong class="text-right">Total</strong>
                            @endif
                    </td>
                    <td class="text-right">
                        @foreach($budget->adminMonthlyBudgetDetails as $key => $data)
                           @money($data->amount) <br>
                        @endforeach
                        @if($rows > 1)
                            <hr class="m-0 p-0">
                            <strong class="text-right">@money($totalSV = $budget->adminMonthlyBudgetDetails->flatten()->sum('amount'))</strong>
                        @endif
                    </td>
                    <td class="text-right"> {{$budget->user->name}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
{{--                                <a href="{{ url("admin-monthly-budgets/$budget->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>--}}
                                <a href="{{ url("admin-monthly-budgets/$budget->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "admin-monthly-budgets/$budget->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
