@extends('layouts.backend-layout')
@section('title', 'Final Costing')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Final Costing
@endsection

@section('sub-title')
    <span>Project Name: </span> {{ $costing->projects->name }} 
    <span style="padding-left:170px;">Owner Name: {{ $client->client->name }}</span>  
    <span style="float: right">Apartment No: {{ $costing->apartments->name }}</span> 
@endsection


@section('breadcrumb-button')
    <a href="{{ url('csd/costing/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th colspan="6">Additional/Demand Work</th>
                            
                        </tr>
                        <tr>
                            <th>SL</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($costing->csdFinalCostingDemand as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->csdMaterials->name }}</td>
                                    <td>{{ $data->csdMaterials->unit->name }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ $data->demand_rate }}</td>
                                    <td>{{ $data->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="table-responsive">
                    <table id="dataTable2" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th colspan="6">Refund Work</th>
                            
                        </tr>
                        <tr>
                            <th>SL</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                @foreach ($costing->csdFinalCostingRefund as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->csdMaterials->name }}</td>
                                        <td>{{ $data->csdMaterials->unit->name }}</td>
                                        <td>{{ $data->quantity_refund }}</td>
                                        <td>{{ $data->refund_rate }}</td>
                                        <td>{{ $data->amount_refund }}</td>
                                    </tr>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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

        // $(document).ready(function () {
        //     $('#dataTable').DataTable({
        //         stateSave: true
        //     });
        // });
    </script>
@endsection
