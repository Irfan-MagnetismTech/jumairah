@extends('layouts.backend-layout')
@section('title', 'salary')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Allocations
@endsection


@section('breadcrumb-button')
    <a href="{{ route('allocations.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
{{--    Total: {{ count($allocations) }}--}}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
            <th>SL</th>
                <th>Month</th>
                <th>Project </th>
                <th>Management Fee</th>
                <th>Division Fee</th>
                <th>Construction Depreciation</th>
                <th>Architecture Fee</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Month</th>
                <th>Project </th>
                <th>Management Fee</th>
                <th>Division Fee</th>
                <th>Construction Depreciation</th>
                <th>Architecture Fee</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($allocations as $key => $allocation)
                <tr>
                    <td>{{1+$key}}</td>
                    <td> {{ $allocation->first()->month }}</td>
                    <td class="text-left">
                        @foreach($allocation->allocationDetails as $data)
                            {{$data->costCenter->name ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($allocation->allocationDetails as $data)
                            {{number_format($data->management_fee,2) ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($allocation->allocationDetails as $data)
                            {{number_format($data->division_fee,2) ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($allocation->allocationDetails as $data)
                            {{number_format($data->construction_depreciation,2) ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($allocation->allocationDetails as $data)
                            {{number_format($data->architecture_fee,2) ?? ''}} <br>
                        @endforeach
                    </td>

                    <td class="text-right">
                        @foreach($allocation->allocationDetails as $data)
                            {{number_format($data->total_allocation,2) ?? ''}} <br>
                        @endforeach
                    </td>
                    <td> <span class="badge @if($allocation->status == 'Approved') bg-success @else bg-warning @endif badge-sm"> {{$allocation->status}} </span> </td>
                    <td rowspan="">
                        <div class="icon-btn">
                            <nobr>
{{--                                @if($allocation->status == 'Pending')--}}
                                    <a href="{{ url("allocation-approval/$allocation->id")}}" data-toggle="tooltip" title="Approved" class="btn btn-outline-info"><i class="fas fa-check"></i></a>
{{--                                @endif--}}
                                <a href="{{ route('allocations.show',$allocation->id)}}" data-toggle="tooltip" title="View" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @if($allocation->status == 'Pending')
                                    <a href="{{ route("allocations.edit", $allocation->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "accounts/allocations/$allocation->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                @endif
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
