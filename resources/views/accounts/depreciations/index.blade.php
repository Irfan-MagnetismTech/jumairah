@extends('layouts.backend-layout')
@section('title', 'Loans')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Depreciation
@endsection

@section('breadcrumb-button')
    <a href="{{ route('depreciations.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($depreciations) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Month</th>
                    <th>Asset Name</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($depreciations as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->month ?? ''}}</td>
                    <td class="text-left">
                        @foreach($data->depreciationDetails as $key => $detail)
                            {{$detail->asset->tag ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($data->depreciationDetails as $key => $detail)
                            {{$detail->amount ?? ''}} <br>
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route("depreciations.edit", $data->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => route('depreciations.destroy', $data->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
