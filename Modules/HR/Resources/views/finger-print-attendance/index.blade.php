@extends('layouts.backend-layout')
@section('title', 'Fingerprint Attendance')

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

    <div id="fingerprint-attendance-page-content">
        <div class="fingerprint-attendance-filtes row my-2">
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label for="" class="input-group-addon">Select Device</label>
                    {{ Form::select('device_id', $devices, old('device_id'), ['class' => 'form-control', 'id' => 'device_id']) }}
                </div>
            </div>
            {{-- <div class="col-md-4">
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
            </div> --}}
        </div>

        <div class="fingerprint-attendance-actions row mb-5 mt-2">
            <div class="col-12">
                @can('process-fingerprint-attendance')
                    <button class="btn-primary btn-sm rounded rounded-3 btn" id="get_attendance_log_btn">
                        Get & Process Attendance Log
                    </button>
                @endcan
                @can('show-device-users')
                    <button class="btn-info btn-sm rounded rounded-3 btn" id="get_device_users_btn">Get Users</button>
                @endcan
                @can('clear-fingerpint-attendance')
                    <button class="btn-danger btn-sm rounded rounded-3 btn" id="clear_attendance">Clear All Attendance</button>
                @endcan
                {{-- <a class="btn-outline-primary btn-sm rounded rounded-3 btn" href="{{ route('finger-print-device-users.create') }}">
                   <span class="mr-2">Add new device user</span>
                    <i class="fas fa-plus"></i>
                </a> --}}
            </div>
        </div>

        <div id="table_container">

        </div>
    </div>

@endsection

<style>
    .page-item {
        cursor: pointer;
    }
</style>

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        // get device and date wise attendance log
        $('#get_attendance_log_btn').on('click', function() {
            processAndGetAttendanceLog(1, true);
        })

        $(document).on('click', '.att_log_page_nav', function() {

            let page = $(this).closest('li').attr('data-page');
            let lastPage = $('.page-item').eq(-2).attr('data-page');
            console.log(lastPage)
            let currentlyActiveLogPage = $('.att_log_page_nav.active').closest('li').attr('data-page');

            if (isNaN(page)) {

                if (page.includes('Previous') && (parseInt(currentlyActiveLogPage) - 1) > 0) {
                    page_to_fetch = parseInt(currentlyActiveLogPage) - 1;
                    processAndGetAttendanceLog(page_to_fetch, false);
                }
                if (page.includes('Next') && (parseInt(currentlyActiveLogPage) + 1) <= lastPage) {
                    page_to_fetch = parseInt(currentlyActiveLogPage) + 1;
                    processAndGetAttendanceLog(page_to_fetch, false);
                }
            } else if (!isNaN(page)) {
                processAndGetAttendanceLog(page, false);
            }
        });


        function processAndGetAttendanceLog(page = 1, process = false) {
            let date_from = $('#date_from').val();
            let date_to = $('#date_to').val();

            $('#fingerprint-attendance-page-content').waitMe({
                effect: 'ios'
            });

            $.ajax({
                url: '{{ route('getDeviceAndDateWiseAttendanceLog') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'device_id': $('#device_id').val(),
                    'date_from': $('#date_from').val(),
                    'date_to': $('#date_to').val(),
                    'process': process,
                    'page': page,
                },
                success: function(response) {
                    data = response.data;
                    $('#fingerprint-attendance-page-content').waitMe("hide");

                    let tableContent = '';

                    if (data.length < 1) {
                        tableContent += "<h3 class='text-danger'>No Data Found</h3>";
                        $('#table_container').append(tableContent);
                        $('#fingerprint-attendance-page-content').waitMe("hide");
                    } else {

                        tableContent +=
                            `
                        <div class="dt-responsive table-responsive" id="attendance_log_table">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Employee Name</th>
                                    <th>Punch Time</th>
                                    <th>Punch Date</th>
                                    <th>Device</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#SL</th>
                                    <th>Employee Name</th>
                                    <th>Punch Time</th>
                                    <th>Punch Date</th>
                                    <th>Device</th>
                                </tr>
                            </tfoot>
                            <tbody> `;

                        let sl = 0;
                        $.each(data, function(index, item) {

                            sl++;
                            var row = '<tr>';
                            row += '<td>' + (sl) + '</td>';
                            row += '<td>' + item.employee.emp_name ?? '' + '</td>';
                            row += '<td>' + item.punch_time + '</td>';
                            row += '<td>' + item.punch_date + '</td>';
                            row += '<td>' + (item.device ? item.device.device_location : '') +
                                '</td>';
                            tableContent += row;

                        });

                        tableContent += `</tbody></table></div>`;

                        tableContent +=
                            `<nav aria-label="Page navigation example"><ul class="pagination">`;

                        $.each(response.links, function(i, link) {
                            var page_link =
                                `<li class="page-item ${link.active==true? 'active':''}" data-page='${link.label}'>
                                    <a class="page-link att_log_page_nav ${link.active==true? 'active':''}">${link.label}</a>
                                </li>`;
                            tableContent += page_link;

                        });
                        tableContent += `</ul></nav>`;
                        $('#table_container').html('');
                        $('#table_container').append(tableContent);

                    }
                },
                error: function(jqXHR, status, error) {

                    $('#fingerprint-attendance-page-content').waitMe("hide");
                    Toastify({
                        close: true,
                        text: "Failed to get attendance log",
                        style: {
                            background: "red",
                            minWidth: '100px',
                            fontSize: '.8rem'
                        }
                    }).showToast();

                }
            });
        }


        // get device wise users
        $('#get_device_users_btn').on('click', function() {

            $('#table_container').html('');

            $('#fingerprint-attendance-page-content').waitMe({
                effect: 'ios'
            });

            $.ajax({
                url: '{{ route('getDeviceWiseUsers') }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'device_id': $('#device_id').val(),
                    'date_from': $('#date_from').val(),
                    'date_to': $('#date_to').val(),
                },
                success: function(data) {

                    let tableContent = '';
                    tableContent +=
                        `
                    <div class="dt-responsive table-responsive" id="attendance_log_table">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Employee Name</th>
                                <th>User Id</th>

                            </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#SL</th>
                                    <th>Employee Name</th>
                                    <th>User Id</th>

                                </tr>
                            </tfoot>
                        <tbody> `;


                    let sl = 0;
                    $.each(data, function(index, item) {

                        sl++;
                        var row = '<tr>';
                        row += '<td>' + (sl) + '</td>';
                        row += '<td>' + item.name + '</td>';
                        row += '<td>' + item.userid + '</td>';
                        tableContent += row;

                    });

                    tableContent += `</tbody></table></div>`;
                    $('#table_container').append(tableContent);

                    $('#fingerprint-attendance-page-content').waitMe("hide");


                },
                error: function(xhr, status, error) {
                    $('#fingerprint-attendance-page-content').waitMe("hide");
                    Toastify({
                        close: true,
                        text: error,
                        style: {
                            background: "red",
                            minWidth: '100px',
                            fontSize: '.8rem'
                        }
                    }).showToast();
                }
            });
        })


        // delete device wise attendance
        $('#clear_attendance').on('click', function() {


            $('#table_container').html('');

            $('#fingerprint-attendance-page-content').waitMe({
                effect: 'ios'
            });

            $.ajax({
                url: '{{ route('clearDeviceWiseAttendanceLog') }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'device_id': $('#device_id').val(),
                    'date_from': $('#date_from').val(),
                    'date_to': $('#date_to').val(),
                },
                success: function(data) {
                    $('#fingerprint-attendance-page-content').waitMe("hide");
                    Toastify({
                        close: true,
                        text: "Attendence Log of selected device cleared Successfully",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                            minWidth: '100px',
                            fontSize: '.8rem'
                        }
                    }).showToast();
                },
                error: function(xhr, status, error) {
                    $('#fingerprint-attendance-page-content').waitMe("hide");
                    Toastify({
                        close: true,
                        text: "Failed to delete attendance log of selected device",
                        style: {
                            background: "red",
                            minWidth: '100px',
                            fontSize: '.8rem'
                        }
                    }).showToast();
                }
            });
        })
    </script>
@endsection
