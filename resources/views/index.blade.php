@extends('layouts.backend-layout')
@section('title', 'Followups')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Followup
@endsection

@section('breadcrumb-button')
    <a href="{{ url('leadgenerations') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($followups) }}
@endsection

    @section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Time From</th>
                    <th>Time Till</th>
                    <th>Prospect Name</th>
                    <th>Activity Type</th>
                    <th>Activity For</th>
                    <th>Prospect Feedback</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
            @foreach($followups as $key => $followup)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$followup->date}}</td>
                    <td>{{$followup->time_from}}</td>
                    <td>{{$followup->time_till}}</td>
                    <td class="breakWords">{{$followup->leadgeneration->name}}</td>
                    <td>{{$followup->activity_type}}</td>
                    <td>{{$followup->reason}}</td>
                    <td class="breakWords">{{$followup->feedback}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("followups/$followup->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "followups/$followup->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
