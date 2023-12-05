@extends('layouts.backend-layout')
@section('title', 'Settlements')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Final Settlements
@endsection


@section('breadcrumb-button')
    @can('client-create')
        <a href="{{ url('final-settlements/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($finalsettlements) }}
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Client</th>
                <th>Apartment</th>
                <th>Project</th>
                <th>Registration Fee</th>
                <th>Discount</th>
                <th> Action </th>
            </tr>
            </thead>
            <tbody>
            @foreach($finalsettlements as $key => $finalsettlement)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left">{{$finalsettlement->sell->sellClient->client->name}} </td>
                    <td class="">{{$finalsettlement->sell->apartment->name}} </td>
                    <td class="text-left">{{$finalsettlement->project->name}} </td>
                    <td class="text-right">@money($finalsettlement->registration_cost) </td>
                    <td class="text-right">@money($finalsettlement->discount) </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("finalsettlementreport?reportType=pdf&project_id=$finalsettlement->project_id&sell_id=$finalsettlement->sale_id") }}" data-toggle="tooltip" title="Report" class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i></a>
                                <a href="{{ url("final-settlements/$finalsettlement->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "final-settlements/$finalsettlement->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}{!! Form::close() !!}
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
