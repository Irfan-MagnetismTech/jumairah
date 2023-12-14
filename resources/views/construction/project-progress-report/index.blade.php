@extends('layouts.backend-layout')
@section('title', 'Project Duration')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Project Duration List
@endsection

@section('breadcrumb-button')
    <a href="{{ url('construction.monthly_progress_report.index') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection


    @section('content')

            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Date of inception</th>
                    <th>Date of Completion</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Date of inception</th>
                    <th>Date of Completion</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @if (!empty($progress_data[0]))
            @foreach($progress_data[0]->ProjectProgressReportDetails as $key => $ProjectProgressReportDetail)
                @php($id= $progress_data[0]->id)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $ProjectProgressReportDetail->costCenter->name }} </td>
                    <td> {{ $ProjectProgressReportDetail->date_of_inception }} </td>
                    <td> {{ $ProjectProgressReportDetail->date_of_completion }} </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("construction/monthly_progress_report/$id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "construction/monthly_progress_report/$id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}

                                <a href="{{ url("monthlyProgressReportLog/$id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-sm btn-dark"><i class="fas fa-history"></i></a>

                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            @endif
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
