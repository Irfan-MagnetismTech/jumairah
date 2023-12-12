@extends('layouts.backend-layout')
@section('title', 'Attendance Log')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
   Attendance Log
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('attendance-log.process')}}" class="btn btn-out-dashed btn-sm btn-warning">
        Process Attendance Log
    </a>
@endsection
@section('sub-title')
    Total: {{ count($attendance_logs) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Punch Time</th>
                <th>Punch Date</th>
                <th>Punch Location</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#SL</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Punch Time</th>
                <th>Punch Date</th>
                <th>Punch Location</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($attendance_logs as $key => $data)
                <tr>
                    <td>{{$key  + 1}}</td>
                    <td class="text-left">{{$data->employee?->emp_name}}</td>
                    <td class="text-left">{{$data->employee->department->name}}</td>
                    <td class="text-left">{{$data->punch_time}}</td>
                    <td class="text-left">{{$data->punch_date}}</td>
                    <td class="text-left">{{$data->device->device_location}}</td>

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
