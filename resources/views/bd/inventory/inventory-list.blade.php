@extends('layouts.backend-layout')
@section('title', 'Priority Land')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Budget List
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('bd-priority-land-pdf') }}/{{ $BdInventoryDetail->bd_inventory_id }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
    <a href="{{ url('bd-inventory-pdf') }}/{{ $bd_inventory_details[0]->bd_inventory_id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
@endsection


    @section('content')

            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr >
                    <th rowspan="2">SL No</th>
                    <th rowspan="2">Project Name</th>
                    <th rowspan="2">Land Size <br>as per Feasibility <br>(katha)</th>
                    <th rowspan="2">Ratio</th>
                    <th rowspan="2">Total Units</th>
                    <th colspan="2">L/O Portion</th>
                    <th colspan="2">RFPL Portion</th>
                    <th rowspan="2">Margin(%)</th>
                    <th rowspan="2">Rate</th>
                    <th rowspan="2">Parking</th>
                    <th rowspan="2">Utility</th>
                    <th rowspan="2">Other<br> Benefit</th>
                    <th rowspan="2">Remarks</th>
                    <th rowspan="2">Signing Money<br>(crore)</th>
                    <th rowspan="2">Inventory <br>Value</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th >Units</th>
                    <th >Space</th>
                    <th >Units</th>
                    <th >Space</th>
                </tr>
            </thead>
            <tbody>
            @foreach($bd_inventory_details as $BdInventoryDetail)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $BdInventoryDetail->costCenter->name ?? ''}} </td>
                    <td> {{ $BdInventoryDetail->land_size }} </td>
                    <td> {{ $BdInventoryDetail->ratio }} </td>
                    <td> {{ $BdInventoryDetail->total_units }} </td>
                    <td> {{ $BdInventoryDetail->lo_units }} </td>
                    <td> {{ $BdInventoryDetail->lo_space }} </td>
                    <td> {{ $BdInventoryDetail->rfpl_units }} </td>
                    <td> {{ $BdInventoryDetail->rfpl_space }} </td>
                    <td> {{ $BdInventoryDetail->margin }} </td>
                    <td> {{ $BdInventoryDetail->rate }} </td>
                    <td> {{ $BdInventoryDetail->parking }} </td>
                    <td> {{ $BdInventoryDetail->utility }} </td>
                    <td> {{ $BdInventoryDetail->other_benefit }} </td>
                    <td> {{ $BdInventoryDetail->remarks }} </td>
                    <td> {{ $BdInventoryDetail->signing_money }} </td>
                    <td> {{ $BdInventoryDetail->inventory_value }} </td>
                    @if ($loop->first)
                    <td rowspan="{{count($bd_inventory_details)}}">
                        <div class="icon-btn">
                            <nobr>
                                {{-- <a href="{{ url('bd-priority-land-pdf') }}/{{ $month->id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a> --}}
                                <a href="{{ url("bd_inventory/$BdInventoryDetail->bd_inventory_id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "bd_inventory/$BdInventoryDetail->bd_inventory_id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
                    @endif
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
