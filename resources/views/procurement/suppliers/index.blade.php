@extends('layouts.backend-layout')
@section('title', 'Suppliers')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Suppliers
@endsection


@section('breadcrumb-button')
    <a href="{{ url('suppliers/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($suppliers) }}
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Type</th>
                <th>Country</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Type</th>
                <th>Country</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($suppliers as $key => $supplier)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="breakWords"> {{ $supplier->name ?? '' }}</td>
                    <td> {{ $supplier->type ?? ''}}</td>
                    <td> {{ $supplier->country ?? '' }}</td>
                    <td> {{ $supplier->contact ??''}}</td>
                    <td> {{ $supplier->email ??''}}</td>
                    <td style="text-align:left; white-space: normal"> {{ $supplier->address ??''}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("suppliers/$supplier->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "suppliers/$supplier->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
