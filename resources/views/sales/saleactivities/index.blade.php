@extends('layouts.backend-layout')
@section('title', 'Sale Activity')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Sale Activities
@endsection

@section('breadcrumb-button')
    <a href="{{ url('sells') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($saleactivities) }}
@endsection

    @section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date & Time</th>
                    <th>Client Name</th>
                    <th>Activity Type</th>
                    <th>Activity For</th>
                    <th>Prospect Feedback</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($saleactivities as $key => $saleactivity)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <strong>{{$saleactivity->date}}</strong> <br>
                        {{\Carbon\Carbon::createFromFormat('H:i', $saleactivity->time_from)->format('h:i:a')}}- {{\Carbon\Carbon::createFromFormat('H:i', $saleactivity->time_till)->format('h:i:a')}}
                    </td>
                    <td class="breakWords">{{$saleactivity->sell->sellClient->client->name}}</td>
                    <td>{{$saleactivity->activity_type}}</td>
                    <td class="breakWords">{{$saleactivity->reason}}</td>
                    <td class="breakWords">{{$saleactivity->feedback}}</td>
                    <td class="breakWords">{{$saleactivity->remarks}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("saleactivities/$saleactivity->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "saleactivities/$saleactivity->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
