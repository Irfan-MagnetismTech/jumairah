@extends('layouts.backend-layout')
@section('title', 'Employee Overtime List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Employee Overtime
@endsection

@section('style')
    <style>
        th,
        td {
            white-space: pre-wrap !important;
        }
    </style>
@endsection

@section('content')
    <div class="ot_crud_page">
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Date</label>
                    {{ Form::date('date', now()->format('Y-m-d'), [
                        'class' => 'form-control',
                        'id' => 'date',
                    ]) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="emp_name">Department</label>
                    {{ Form::select('department_id', $departments, null, [
                        'class' => 'form-control select2',
                        'id' => 'department_id',
                    ]) }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="emp_name">Employee</label>
                    {{ Form::select('employee_id[]', $employees, null, [
                        'class' => 'form-control select2',
                        'id' => 'employee_id',
                        'multiple' 
                    ]) }}
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 bulk_select_ot_records d-none my-2 ot_hour_container">
                <input style="width:35px !important; height:33px !important; text-align:center" type="number"
                    max="8" placeholder="H" class="h_input bulk_h_input">
                :
                <input style="width:35px !important; height:33px !important; text-align:center" type="number"
                    max="59" placeholder="M" class="m_input bulk_m_input">
                <button class="ml-2 btn btn-sm btn-warning bulk_ot_hour_apply">Apply to Selected</button>
                <button class="ml-2 btn btn-sm btn-success bulk_ot_hour_save">Save Selected</button>
            </div>
            <div class="col-12">
                <table class="table table-striped table-bordered dataTable ot_records_table">

                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#department_id').val('');
            $('#employee_id').val('');

            $('#department_id, #employee_id, #date').on('change', function() {

                if ($('#department_id').val() && $('#date').val()) {

                    $('.ot_crud_page').waitMe({
                        effect: 'ios'
                    });

                    $.ajax({
                        url: "{{ route('getEmployeeOtRecords') }}",
                        method: 'GET',
                        data: {
                            date: $('#date').val(),
                            department_id: $('#department_id').val(),
                            employee_id: $('#employee_id').val(),
                        },
                        success: function(response) {
                            $('.ot_crud_page').waitMe("hide");
                            let html =
                                `
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="check_all_ot_records"></th>
                                    <th>Employee Name</th>
                                    <th>Employee Code</th>
                                    <th>Over Time Hour</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            for (const item of response) {

                                html +=
                                    `<tr employee_id="${item.employee_id}" class="ot_hour_container">
                                    <td><input type="checkbox" class="check_single_ot_record"></td>
                                    <td>${item.emp_code}</td>
                                    <td>${item.emp_name}</td>
                                    <td >
                                        <span>`;

                                if (item.ot_hour != null) {

                                    html +=
                                        `
                                    <input style="width:30px !important; height:30px !important; text-align:center"
                                        type="number" max="8" placeholder="H" class="h_input"
                                        value=${item.ot_hour.split(':')[0]}>
                                        :
                                    <input style="width:30px !important; height:30px !important; text-align:center" type="number" max="59" placeholder="M" class="m_input"
                                    value=${item.ot_hour.split(':')[1]} >
                                    `;

                                } else {
                                    html +=
                                        `
                                    <input style="width:30px !important; height:30px !important; text-align:center"
                                        type="number" max="8" placeholder="H" class="h_input">
                                        :
                                    <input style="width:30px !important; height:30px !important; text-align:center" type="number" max="59" placeholder="M" class="m_input">
                                    `;
                                }

                                html += `</span>
                                    </td>
                                    <td><button class="btn btn-sm rounded py-1 px-4 btn-success ot_single_save">save</button></td>
                                </tr>`;

                            }


                            html += `</tbody>`;

                            $('.ot_records_table').html(html);
                        },
                        error: function(error) {

                        }
                    });
                }
            });

            $(document).on('click', '.ot_single_save', function() {
                let h_input = $(this).closest('.ot_hour_container').find('.h_input').val();
                let m_input = $(this).closest('.ot_hour_container').find('.m_input').val();

                if (h_input != '' && m_input != '') {
                    $(this).waitMe({
                        effect: 'roundBounce',
                        maxSize: 30,
                    });

                    let records = [];
                    records.push({
                        employee_id: $(this).closest('.ot_hour_container').attr('employee_id'),
                        date: $('#date').val(),
                        ot_hour: h_input + ":" + m_input
                    })

                    save_ot_record(records).then(() => {
                        $(this).waitMe("hide");
                    });
                }

            })

            $(document).on('click', '.bulk_ot_hour_save', function() {
                $('.ot_records_table').waitMe({
                    effect: 'roundBounce',
                    maxSize: 60,
                });

                let records = [];

                $('.check_single_ot_record:checked').each(function(index, element) {

                    records.push({
                        employee_id: $(this).closest('.ot_hour_container').attr(
                            'employee_id'),
                        date: $('#date').val(),
                        ot_hour: $(this).closest('.ot_hour_container').find('.h_input')
                            .val() + ":" +
                            $(this).closest('tr').find('.m_input').val()
                    })

                })


                save_ot_record(records).then(() => {
                    $('.ot_records_table').waitMe("hide");
                });
            })

            function save_ot_record(records) {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: "{{ route('saveEmployeeOtRecords') }}",
                        method: 'POST',
                        data: {
                            ot_records: records,
                            date: $('#date').val(),
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Toastify({
                                text: "Over Time Records Saved",
                                close: true,
                                gravity: "top",
                                position: "right",
                                style: {
                                    background: "#2ed8b6",
                                    minWidth: '100px',
                                    fontSize: '.8rem'
                                }
                            }).showToast();
                            resolve(response);
                        },
                        error: function(error) {
                            reject(error);
                        }
                    });
                });
            }

            $(document).on('keyup', '.h_input', function() {

                $(this).off('keyup');
                if ($(this).val() > 8) {
                    $(this).val(8);
                    $(this).closest('.ot_hour_container').find('.m_input').val(0);
                }

                if ($(this).val() == 8) {
                    $(this).closest('.ot_hour_container').find('.m_input').val(0);
                }
                $(this).on('keyup', arguments.callee);
            })

            $(document).on('keyup', '.m_input', function() {
                $(this).off('keyup');
                if ($(this).closest('.ot_hour_container').find('.h_input').val() == 8) {
                    $(this).val(00)
                }
                if ($(this).val() > 59) {
                    $(this).val(59)
                }
                $(this).on('keyup', arguments.callee);
            })

            $(document).on('keyup', ".m_input, .h_input, .bulk_m_input, .bulk_h_input", function() {
                if (isNaN(parseInt($(this).val()))) {
                    $(this).val(0);
                }

            })

            $(document).on('click', '.check_all_ot_records', function() {
                if ($(this).prop('checked')) {
                    $('.check_single_ot_record').prop('checked', true);
                } else {
                    $('.check_single_ot_record').prop('checked', false);
                }

            })

            $(document).on('click', '.check_all_ot_records, .check_single_ot_record', function() {
                $('.check_single_ot_record').trigger('change')
                if ($('.check_single_ot_record:checked').length > 0) {
                    $(".bulk_select_ot_records").removeClass('d-none');
                } else {
                    $(".bulk_select_ot_records").addClass('d-none');
                }
            })

            $(document).on('click', '.bulk_ot_hour_apply', function() {

                $('.check_single_ot_record:checked').closest('.ot_hour_container').find('.h_input').val($(
                        '.bulk_h_input')
                    .val());
                $('.check_single_ot_record:checked').closest('.ot_hour_container').find('.m_input').val($(
                        '.bulk_m_input')
                    .val());
            })

            $('#department_id').change(() => {

                $('#employee_id').waitMe({
                    effect: 'ios',
                    maxSize: 25
                });

                $.ajax({
                    url: "{{ route('getDepartmentWiseEmployees') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        department_id: $('#department_id ').val()
                    },
                    success: function(response) {
                        $('#employee_id').empty();
                        $('#employee_id').append('<option value="">' + "All" + '</option>');
                        $.each(response, function(index, value) {

                            $('#employee_id').append('<option value="' + value.id +
                                '">' + value
                                .text + '</option>');
                        });
                        $('#employee_id').waitMe("hide");

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#employee_id').waitMe("hide");
                    }
                });
            });

        });
    </script>
@endsection
