@extends('layouts.backend-layout')
@section('title', 'Opening Material')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Opening Materials
@endsection


@section('breadcrumb-button')
    <a href="{{ url('opening-material/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Material Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Material Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($OpeningRawMaterials as $key => $data)
                <tr>
                    <td>{{  $loop->iteration}}</td>
                    <td> {{ $data->costCenter->name }}</td>
                    <td>
                        @foreach ($data->OpeningRawMaterialDetails as $key => $value )
                            {{$value->nestedMaterial->name}}
                            @if (!$loop->last)
                               <br /> 
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @if($data->statuts == 1)
                                @else
                                <a href="{{ url("opening-material/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "opening-material/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
