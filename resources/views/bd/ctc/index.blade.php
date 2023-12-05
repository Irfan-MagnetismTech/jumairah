@extends('layouts.backend-layout')
@section('title', 'CTC')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Cost Of Company
@endsection


@section('breadcrumb-button')
    <a href="{{ route('ctc.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($bd_ctc) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>#User</th>
                <th>Location</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Total Payable</th>
                <th>Total Effect</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>#User</th>
                    <th>Location</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Total Payable</th>
                    <th>Total Effect</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($bd_ctc as $key => $bd)
                    <tr>
                        <td rowspan="{{count($bd->BdFeasiCtcDetail)}}">{{$loop->iteration}}</td>
                        <td rowspan="{{count($bd->BdFeasiCtcDetail)}}"><strong>{{$bd->user->name}}</strong></td>
                        <td rowspan="{{count($bd->BdFeasiCtcDetail)}}"><strong>{{$bd->BdLeadGeneration->land_location}}</strong></td>
                        @foreach ($bd->BdFeasiCtcDetail as $detals_key => $details_value )
                                <td>{{$details_value->department_id}}</td>
                                <td>{{$details_value->designation->name}}</td>
                                <td>{{$details_value->total_payable}}</td>
                                <td>{{$details_value->total_effect}}</td>
                                @if ($loop->first)
                                    <td rowspan="{{count($bd->BdFeasiCtcDetail)}}">
                                        <div class="icon-btn">
                                            <nobr>
                                                <a href="{{ route("ctc.edit", $bd->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                                {!! Form::open(array('url' => "ctc/$bd->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                                {!! Form::close() !!}
                                            </nobr>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
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
