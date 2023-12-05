@extends('layouts.backend-layout')
@section('title', 'salary')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Salaries
@endsection


@section('breadcrumb-button')
    <a href="{{ route('salaries.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($salaries) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Month</th>
                <th>Department </th>
                <th>Gross Salary </th>
                <th>Net Salary </th>
                <th>Total Salary</th>
                <th>Entry By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Month</th>
                <th>Department </th>
                <th>Gross Salary </th>
                <th>Net Salary </th>
                <th>Total Salary</th>
                <th>Entry By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($salaries as $key => $data)
                <tr>
                    <td>{{1+$key}}</td>
                    <td> {{ $data->month }}</td>
                    <td class="text-left">
                        @foreach($data->salaryDetails as $detail)
                            {{$detail->salaryHeads->name ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($data->salaryDetails as $detail)
                            @money($detail->gross_salary) <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($data->salaryDetails as $detail)
                            @money($detail->net_payable) <br>
                        @endforeach
                    </td>
                    <td>@money($data->salaryDetails->flatten()->sum('gross_salary'))</td>
                    <td>{{$data->user->name}}</td>
                    <td> <span class="badge @if($data->status == 'Approved') bg-success @else bg-warning @endif badge-sm"> {{$data->status}} </span> </td>
                    <td rowspan="">
                        <div class="icon-btn">
                            <nobr>
{{--                                @if($data->status == 'Pending')--}}
                                    <a href="{{ url("salary-approval/$data->id")}}" data-toggle="tooltip" title="Approval" class="btn btn-outline-info"><i class="fas fa-check"></i></a>
{{--                                @endif--}}

                                <a href="{{ route('salaries.show',$data->id)}}" data-toggle="tooltip" title="View" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

{{--                                @if($data->status == 'Pending')--}}
                                        <a href="{{ route("salaries.edit", $data->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                        {!! Form::open(array('url' => "accounts/salaries/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
{{--                                @endif--}}
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
