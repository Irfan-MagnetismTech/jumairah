@extends('layouts.backend-layout')
@section('title', 'Letter')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Letters
@endsection


@section('breadcrumb-button')
    <a href="{{ url('csd/letter/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Letter Title</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Letter Title</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($letters as $key => $letter)
                <tr>
                    <td>{{  $loop->iteration}}</td>
                    <td> {{ $letter->letter_title }}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url('csd/csd-letter-pdf') }}/{{ $letter->id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-file-pdf"></i></a>
                                <a href="{{ url("csd/letter/$letter->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ url("csd/letter/$letter->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "csd/letter/$letter->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                                <a href="{{ url("csdletterLog/$letter->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-sm btn-dark"><i class="fas fa-history"></i></a>

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
