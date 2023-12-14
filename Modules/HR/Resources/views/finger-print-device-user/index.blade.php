@extends('layouts.backend-layout')
@section('title', 'Device Attendance')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Fingerprint Attendance
@endsection


@section('content')
    <style>
        table th,
        table td {
            border: 1px solid #D3E7FB !important;
        }
    </style>

    <div class="fingerprint-attendance-filtes row my-2">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label for="" class="input-group-addon">Select Device</label>
                {{ Form::select('device_id', $devices, old('device_id'), ['class' => 'form-control', 'id' => 'device_id']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date"> Date From </label>
                {{ Form::date('date_from', old('date_from'), [
                    'class' => 'form-control',
                    'id' => 'date_from',
                ]) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date"> Date To </label>
                {{ Form::date('date_to', old('date_to'), [
                    'class' => 'form-control',
                    'id' => 'date_to',
                ]) }}
            </div>
        </div>
    </div>
    <div class="fingerprint-attendance-actions row mb-5 mt-2">
        <div class="col-12">
            <button class="btn-primary btn-sm rounded rounded-3 btn" id="get_attendance_log_btn">Get Attendance Log</button>
            <button class="btn-info btn-sm rounded rounded-3 btn" id="get_device_users_btn">Get Users</button>
            <button class="btn-danger btn-sm rounded rounded-3 btn" id="clear_attendance">Clear All Attendance</button>
        </div>
    </div>

    <hr>

    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>User Id</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>User Id</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>

            </tbody>
        </table>
    </div>


@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        // get device wise attendance log




    </script>
@endsection
