@extends('bd.feasibility.layout.app')
@section('title', 'Sub & Generator')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Sub & Generator for {{ $bd_lead_location_name[0]->land_location }}
@endsection


@section('breadcrumb-button')
    @can('employee-create')
        <a href="{{ route('feasibility.location.sub-and-generator.create',[ $bd_lead_location_name[0]->id]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>KVA</th>
                    <th>Generator Rate</th>
                    <th>Sub Station Rate</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>KVA</th>
                    <th>Generator Rate</th>
                    <th>Sub Station Rate</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
               @foreach($Bd_sub_and_generators as $Bd_sub_and_generator)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $Bd_sub_and_generator->kva}}</td>
                        <td>{{ $Bd_sub_and_generator->generator_rate }}</td>
                        <td>{{ $Bd_sub_and_generator->sub_station_rate }}</td>
                        <td>{{ $Bd_sub_and_generator->remarks }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("feasibility/location/$BdLeadGeneration_id/sub-and-generator/$Bd_sub_and_generator->id/edit")}}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                   {!! Form::open(array('url' => "feasibility/location/$BdLeadGeneration_id/sub-and-generator/$Bd_sub_and_generator->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
