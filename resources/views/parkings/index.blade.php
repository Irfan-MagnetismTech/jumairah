@extends('layouts.backend-layout')
@section('title', 'parkings')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Parking
@endsection

@section('breadcrumb-button')
    @can('parking-create')
        <a href="{{ url('parkings/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($parkings) }}
@endsection

    @section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Project</th>
                    <th>Location</th>
                    <th>Level</th>
                    <th>Total Parking</th>
                    <th>Parking Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Project</th>
                    <th>Location</th>
                    <th>Level</th>
                    <th>Total Parking</th>
                    <th>Parking Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($parkings as $key => $parking)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left"><strong>{{$parking->project->name}}</strong></td>
                    <td>{{$parking->location}}</td>
                    <td>{{$parking->level}}</td>
                    <td>{{$parking->total_parking}}</td>
                    <td class="text-left">
                        @foreach($parking->parkingDetails as $parkingDetail)
                            <span class="label  parkingBadge tableBadge text-center" style="font-size: 11px;background-color: #116A7B;">{{$parkingDetail->parking_name}}<br>{{$parkingDetail->parking_owner}}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('parking-edit')
                                <a href="{{ url("parkings/$parking->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                    @can('parking-delete')
                                {!! Form::open(array('url' => "parkings/$parking->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                               @endcan
                                {!! Form::close() !!}
                                <a href="{{ url("parkings/{$parking->id}/log") }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
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
