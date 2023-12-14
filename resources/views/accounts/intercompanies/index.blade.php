@extends('layouts.backend-layout')
@section('title', 'Inter Companies')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Inter Companies
@endsection

@section('breadcrumb-button')
    <a href="{{ route('interCompanies.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($interCompanies) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Address</th>
                <th>Office Phone</th>
                <th>Contact Person (Mobile)</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Address</th>
                <th>Office Phone</th>
                <th>Contact Person (Mobile)</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($interCompanies as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td> {{$data->name}} </td>
                    <td> {{$data->address}} </td>
                    <td> {{$data->office_phone}} </td>
                    <td> {{$data->contact_person}} <br> ({{$data->contact_person_cell}})</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route("interCompanies.edit", $data->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => route('interCompanies.destroy', $data->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
