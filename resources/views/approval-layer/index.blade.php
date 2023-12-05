@extends('layouts.backend-layout')
@section('title', 'Approval Layer')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Approval Layer
@endsection


@section('breadcrumb-button')
    <a href="{{ url('approval-layer/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Layer For</th>
                <th>Layer For (Department)</th>
                <th>Layer Name</th>
                <th>Department</th>
                <th>Approval Body</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($approval_leyar_data as $key => $details)
                <tr>
                    <td> {{ $loop->iteration}} </td>
                    <td> {{$details->name}} </td>
                    <td> {{$details?->department?->name}} </td>
                    <td>
                        @foreach ($details->approvalLeyarDetails as $detail)
                            {{ $detail->name }} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($details->approvalLeyarDetails as $detail)
                            {{ $detail->department->name ?? ' - '}} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($details->approvalLeyarDetails as $detail)
                            {{ $detail->designation->name ?? ''}} <br/>
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                {{-- <a href="{{ url("approval-layer/$details->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a> --}}
                                <a href="{{ url("approval-layer/$details->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "approval-layer/$details->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
