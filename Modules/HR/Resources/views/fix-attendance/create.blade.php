@extends('layouts.backend-layout') @section('title', 'Fix Attendance')
@section('breadcrumb-title') @if ($formType == 'edit')
    Edit
@else
    Create
@endif
Fix Attendance @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 140px !important;
    }

    .submit_btn {
        cursor: auto;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('fix-attendances.index') }}"><i
        class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')

<div class="row px-4 py-2">
    <div class="col-md-6">
        <input type="hidden" id="holiday" value='{{ !empty($holidays) ? 1 : 0 }}'>
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="year">From Date <span class="text-danger">*</span></label>
            {{ Form::date('from_date', old('from_date') ? old('from_date') : null, [
                'class' => 'form-control',
                'id' => 'from_date',
                'placeholder' => 'Enter Date Here',
                'required',
            ]) }}

            @error('from_date')
                <p class="text-danger">{{ $errors->first('from_date') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="year">To Date <span class="text-danger">*</span></label>
            {{ Form::date('to_date', old('to_date') ? old('to_date') : null, [
                'class' => 'form-control',
                'id' => 'to_date',
                'placeholder' => 'Enter Date Here',
                'disabled',
            ]) }}

            @error('to_date')
                <p class="text-danger">{{ $errors->first('to_date') }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="row px-4 py-2">
    <div class="col-md-12 py-2">
        <div class="input-group input-group-sm input-group-primary type_of_select"
            style="display:flex;  flex-wrap: wrap;
            justify-content: space-around;font-size: 14px;">
            <div>
                <input class="checkbox cri_type emp_wise" type="checkbox" name="all_emp" id="all_emp"
                    value="all" checked> All Employee
            </div>
            <div>
                <input class="checkbox cri_type department_wise section_wise designation_wise shift_wise all_emp"
                    type="checkbox" name="emp_wise" id="emp_wise" value="employee_wise"> Employee Wise
            </div>
            <div>
                <input class="checkbox cri_type emp_wise" type="checkbox" name="department" id="department"
                    value="department"> Department Wise
            </div>
            <div>
                <input class="checkbox cri_type emp_wise" type="checkbox" name="section" id="section"
                    value="section"> Section Wise
            </div>
            <div>
                <input class="checkbox cri_type emp_wise" type="checkbox" name="designation" id="designation"
                    value="designation"> Designation Wise
            </div>
            <div>
                <input class="checkbox cri_type emp_wise" type="checkbox" name="shift" id="shift"
                    value="shift"> Shift
            </div>
        </div>
    </div>
</div>
<div class="row px-4 py-2">
    <div class="col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="employee_id">Employee<span class="text-danger">*</span></label>
            <select name="employee_id"
                class="form-control select2  dept_active desig_active section_active shift_active employee_all"
                id="employee_id" required disabled>
                <option value="All" selected>All</option>
                <option value="">Select employee</option>
                @foreach ($employees as $key => $data)
                    <option value="{{ $key }}">{{ $data }}</option>
                @endforeach
            </select>
            @error('employee_id')
                <p class="text-danger">{{ $errors->first('employee_id') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="department_id">Designations<span
                    class="text-danger">*</span></label>
            {{ Form::select('designation_id', $designations, old('designation_id') ? old('designation_id') : null, [
                'class' => 'form-control select2 employee_active',
                'id' => 'designation_id',
                'placeholder' => 'Select Bank',
                'required',
                'disabled',
            ]) }}
            @error('designation_id')
                <p class="text-danger">{{ $errors->first('designation_id') }}</p>
            @enderror
        </div>
    </div>
</div>
<div class="row px-4 py-2">
    <div class="col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="section_id">Section<span class="text-danger">*</span></label>
            {{ Form::select('section_id', $sections, old('section_id') ? old('section_id') : null, [
                'class' => 'form-control select2 employee_active',
                'id' => 'section_id',
                'placeholder' => 'Select Bank',
                'required',
                'disabled',
            ]) }}
            @error('section_id')
                <p class="text-danger">{{ $errors->first('section_id') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="department_id">Department<span
                    class="text-danger">*</span></label>
            {{ Form::select('department_id', $departments, old('department_id') ? old('department_id') : null, [
                'class' => 'form-control select2 employee_active',
                'id' => 'department_id',
                'placeholder' => 'Select Bank',
                'required',
                'disabled',
            ]) }}
            @error('department_id')
                <p class="text-danger">{{ $errors->first('department_id') }}</p>
            @enderror
        </div>
    </div>
</div>
<div class="row px-4 py-2">
    <div class="col-md-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="shift_id">Shift<span class="text-danger">*</span></label>
            {{ Form::select('shift_id', $shifts, old('shift_id') ? old('shift_id') : null, [
                'class' => 'form-control select2 employee_active',
                'id' => 'shift_id',
                'placeholder' => 'Select Bank',
                'required',
                'disabled',
            ]) }}
            @error('shift_id')
                <p class="text-danger">{{ $errors->first('shift_id') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="offset-md-4 col-md-5 my-2">
            <div class="input-group input-group-sm">
                <button id="refreshBtn" class="btn btn-warning btn-round btn-block py-2">
                    Refresh List
                </button>
            </div>
        </div>
    </div>
</div>

{!! Form::open([
    'url' => 'hr/fix-attendances',
    'method' => 'POST',
    'class' => 'custom-form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
    'url' => "hr/fix-attendances/$fix_attendance->id",
    'method' => 'PUT',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row px-4 py-2">
<div class="col-md-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="time_in">Time In<span class="text-danger">*</span></label>
        <input type="time" name="time_in" id="time_in" class="form-control">
        @error('time_in')
            <p class="text-danger">{{ $errors->first('time_in') }}</p>
        @enderror
    </div>
</div>
<div class="col-md-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="time_out">Time Out<span class="text-danger">*</span></label>
        <input type="time" name="time_out" id="time_out" class="form-control">
        @error('time_out')
            <p class="text-danger">{{ $errors->first('time_out') }}</p>
        @enderror
    </div>
</div>
</div>

<div class="row px-4">
<div class="col-md-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="status">Status<span class="text-danger">*</span></label>
        {{ Form::select(
            'status',
            [
                'p' => 'Present',
                'a' => 'Absent',
                'l' => 'Late',
                'w' => 'Weekend',
                'h' => 'Holiday',
                'sl' => 'Sick Leave',
                'cl' => 'Casual Leave',
                'el' => 'Earn Leave',
                'ml' => 'Maternity Leave',
            ],
            old('status') ? old('status') : null,
            [
                'class' => 'form-control select2 section_active employee_active',
                'id' => 'status',
                'placeholder' => 'Select Bank',
            ],
        ) }}
        @error('status')
            <p class="text-danger">{{ $errors->first('status') }}</p>
        @enderror
    </div>
</div>
</div>
<div class="row p-4">
<div class="col-md-6">
    <div class="offset-md-4 col-md-6 mt-2">
        <div class="input-group input-group-sm">
            <a class="btn btn-warning btn-round btn-block py-2 text-white" name="auto_fill_btn"
                style="font-size: 14px;" onclick="fetchDataFillup()">Auto Fill</a>
        </div>
    </div>
</div>
</div>

<!-- table list -->
<div class="row mx-4">
<table id="employeeTable" class="table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th width="5%"><input type="checkbox" id="all_check" value="1" onclick="AllChecked(this)">
            </th>
            <th width="5%">Emp. Info</th>
            <th width="10%">Shift</th>
            <th width="10%">Punch Date</th>
            <th width="6%">Late Hour</th>
            <th width="12%">Time In</th>
            <th width="12%">Time Out</th>
            <th width="5%">OT Hour</th>
            <th width="10%">Status</th>
            <th width="15%">Remarks</th>
            <th width="10%">Action</th>
        </tr>
    </thead>
    <tbody id="table_content">
        <tr>
            <td colspan='11'>
                No Data Found.
            </td>
        </tr>
    </tbody>
</table>
</div>

<div class="row p-4">
<div class="offset-md-4 col-md-4 mt-2 ">
    <div class="input-group input-group-sm ">
        <button class="btn btn-success btn-round btn-block py-2 submit_btn" disabled>Submit</button>
    </div>
</div>
</div>


<!-- end row -->
{!! Form::close() !!}
@endsection
@section('script')

<script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $('#employeeTable').DataTable({
        stateSave: true,
        bPaginate: false,
    });
    $('.dataTables_info').css('display', 'none');
</script>

<script>
    function get_day(date) {
        let currentDate = new Date(date);
        let formattedDate = currentDate.toDateString();
        return formattedDate;
    }

    // get checked key value
    function getCheckedKeys() {
        var checkedKeys = [];
        $('.table_check:checked').each(function() {
            var key = $(this).data('key');
            checkedKeys.push(key);
        });
        return checkedKeys;
    }


    //  for using to_date field disabled false when fill up from_date
    $(document).on('change', '#from_date', function() {
        let from_date = $('#from_date').val();
        console.log(from_date);
        let fromDate = new Date(from_date);
        const yyyy = fromDate.getFullYear();
        const mm = String(fromDate.getMonth() + 1).padStart(2, '0');
        const dd = String(fromDate.getDate()).padStart(2, '0');
        const formattedToday = `${yyyy}-${mm}-${dd}`;
        // Set the min attribute of the input element to today's date
        const todateInput = document.getElementById('to_date');
        todateInput.min = formattedToday;
        if (from_date != null) {
            $('#to_date').prop('disabled', false);
            $('#to_date').prop('required', true);
        }
    });

    $(document).on('change', '#time_in', function() {
        let time_in = $(this).val();
        if (time_in != null) {
            $(`#status option[value="p"]`).prop('selected', true);
        }
    });

    // check required when from date fillup and to date has data required field mendatory.
    function validateFromDate() {
        var isValid = true;
        if ($('#to_date').prop('required')) {
            if ($('#to_date').val().trim() === '') {
                isValid = false;
                $('#to_date').addClass('error');
            } else {
                $('#to_date').removeClass('error');
            }
        }
        return isValid;
    }
    //  for using get data when click to refresh button
    $(document).on('click', '#refreshBtn', function() {
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let employee_id = $('#employee_id').val();
        let designation_id = $('#designation_id').val();
        let section_id = $('#section_id').val();
        let department_id = $('#department_id').val();
        let shift_id = $('#shift_id').val();

        var fromDate = 0;
        var toDate = 0;
        if (from_date != 0 && to_date != 0) {
            fromDate = new Date(from_date);
            toDate = new Date(to_date);
        }
        // Check if fromDate is before toDate
        if (!validateFromDate()) {
            event.preventDefault();
            alert("To date field is required.");
        } else {
            $.ajax({
                url: "{{ route('getDatewiseAttendance') }}",
                type: "POST",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    employee_id: employee_id,
                    designation_id: designation_id,
                    section_id: section_id,
                    department_id: department_id,
                    shift_id: shift_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(rowData) {
                    var proceed_attendances = rowData.proceed_attendances;
                    var employees = rowData.employees;

                    // console.log(proceed_attendances);
                    $('table tbody tr').hide();
                    if (proceed_attendances.length != 0) {
                        // for showing proccessed attandence table data when not null
                        $.each(proceed_attendances, function(index, data) {
                            appendRowAttendance(index, data);
                        });
                    } else if (employees.length != 0) {
                        // for showing proccessed attandence table data when null
                        $.each(employees, function(index, data) {
                            appendRowEmployee(index, data);
                        });
                    } else {
                        appendNoData();
                    }
                },
            });
        }


        // for showing proccessed attandence table data when not null
        function appendRowAttendance(index, data) {
            let lateHours = 0;
            // for late hour
            if (data.time_in != null) {
                //  call time difference calculate function
                lateHours = timedifferenceCalculate(((data.time_in != 0) ? data.time_in : "00:00"), data.shift
                    .shift_late);
            } else {
                lateHours = "00:00";
            }
            // console.log(data.shift.name);

            var rowHtml = `<tr class="tr_${index}">
                    <td>
                        <input class="table_check" type="checkbox" name="emp_id[]" data-key="${index}" id="emp_id_${index}" value="${data.employee.id}"  onclick="handleFieldActive(this,${index})">
                        <input type="hidden" id="shift_id_${index}" name='shift_id[]' value="${data.shift.id}"/>
                        <input type="hidden" id="shift_in_${index}"  value="${data.shift.shift_in}"/>
                        <input type="hidden" id="shift_out_${index}"  value="${data.shift.shift_out}"/>
                        <input type="hidden" id="shift_late_${index}"  value="${data.shift.shift_late}"/>
                    </td>
                    <td>${data.employee.emp_code} - ${data.employee.emp_name}</td>
                    <td>${data.shift.name}</td>
                    <td>
                    <input type="hidden" id='check_holiday_table_${index}' value='0'/>
                    <input style="max-width: 100px;" type="date" class="table_punch_date_${index} table_punch_date" name="table_punch_date[]" value="${data.punch_date}" onChange="getHolidayOrLeave(this,${index})" readonly required/></td>
                    <td>
                        <input style="max-width: 50px;" type="text" class="table_late_${index} table_late" name="table_late[]" value="${lateHours}" disabled readonly/>
                    </td>
                    <td>
                        <input style="max-width: 100px; box-sizing: border-box;" type="time" class="table_time_in table_time_in_${index}" name="table_time_in[]" value="${data.time_in}" onChange="lateAttendance(${index})" disabled/>
                    </td>
                    <td>
                        <input style="max-width: 100px; box-sizing: border-box;" type="time" class="table_time_out table_time_out_${index}" name="table_time_out[]" value="${data.time_out}" disabled/>
                    </td>
                    <td>
                        <input style="max-width: 50px;" type="text" class="table_ot_hour_${index} table_ot_hour" name="table_ot_hour[]" value="${data.ot_hour}" readonly/>
                    </td>
                    <td>
                        <select name="table_status[]" class="table_status table_status_${index}" style="width: 80px;" onChange="tableStatusCheck(this,${index})" disabled required>
                            <option value="p" ${((data.status=='p') || (data.time_in!=0))?'selected':''}>Present</option>
                            <option value="a" ${(data.status=='a')?'selected':''}>Absent</option>
                            <option value="l" ${(data.status=='l')?'selected':''}>Late</option>
                            <option value="w" ${(data.status=='w')?'selected':''}>Weekend</option>
                            <option value="h" ${(data.status=='h')?'selected':''}>Holiday</option>
                            <option value="sl" ${(data.status=='sl')?'selected':''}>Sick Leave</option>
                            <option value="cl" ${(data.status=='cl')?'selected':''}>Casual Leave</option>
                            <option value="el" ${(data.status=='el')?'selected':''}>Earn Leave</option>
                            <option value="ml" ${(data.status=='ml')?'selected':''}>Maternity Leave</option>
                            <option value="others" ${(data.status=='others')?'selected':''}>Others</option>
                        </select>
                    </td>
                    <td>
                        <input style="max-width: 100px;" type="text" class="table_remarks_${index} table_remarks" name="table_remarks[]" placeholder="Enter remarks note" disabled/>
                    </td>
                    <td>
                        <a style="max-width: 100px; border:#FFB64D;border-radius:5px; background-color:#FFB64D;color:white; cursor:pointer;" class="table_btn_${index} text-center px-2 py-1 d-none table_btn" name="table_btn" value="Update" onclick="handleDataStore(this,${index})">Update</a>
                    </td>
                    </tr>`;

            $('#table_content').append(rowHtml);
        }

        // for showing proccessed attandence table data when null
        function appendRowEmployee(index, data) {

            var rowHtml = `<tr class="tr_${index}">
                    <td>
                        <input class="table_check" type="checkbox" name="emp_id[]" id="emp_id_${index}" value="${data.id}" data-key="${index}" onclick="handleFieldActive(this,${index})">
                        <input type="hidden" id="shift_id_${index}" name='shift_id[]' value="${data.shift_id}"/>
                        <input type="hidden" id="shift_in_${index}" value="${data.shift_in}"/>
                        <input type="hidden" id="shift_out_${index}" value="${data.shift_out}"/>
                        <input type="hidden" id="shift_late_${index}" value="${data.shift_late}"/>
                    </td>
                    <td>${data.emp_code} - ${data.emp_name}</td>
                    <td>${data.shift_name}</td>

                    <td>
                    <input type="hidden" id='check_holiday_table_${index}' value='0'/>
                    <input style="max-width: 100px;" type="date" class="table_punch_date_${index} table_punch_date" name="table_punch_date[]" onChange="getHolidayOrLeave(this,${index})"  disabled required/></td>
                    <td>
                        <input style="max-width: 50px;" type="text" class="table_late_${index} table_late" name="table_late[]" value="00:00" disabled readonly/>
                    </td>
                    <td>
                        <input style="max-width: 100px;" type="time" class="table_time_in_${index} table_time_in" name="table_time_in[]" onChange="lateAttendance(${index})" disabled/>
                    </td>
                    <td>
                        <input style="max-width: 100px;" type="time" class="table_time_out_${index} table_time_out" name="table_time_out[]" onChange="otHour(${index})" disabled/>
                    </td>
                    <td>
                        <input style="max-width: 50px;" type="text" class="table_ot_hour_${index} table_ot_hour" name="table_ot_hour[]" value="" readonly/>
                    </td>
                    <td>
                        <select style="max-width: 100px;" class="table_status_${index} table_status" name="table_status[]" onChange="tableStatusCheck(this,${index})" disabled required>
                            <option>---Select one---</option>
                            <option value="p">Present</option>
                            <option value="a" selected>Absent</option>
                            <option value="l">Late</option>
                            <option value="w">Weekend</option>
                            <option value="h">Holiday</option>
                            <option value="sl">Sick Leave</option>
                            <option value="cl">Casual Leave</option>
                            <option value="el">Earn Leave</option>
                            <option value="ml">Maternity Leave</option>
                            <option value="others">Others</option>
                        </select>
                    </td>
                    <td><input style="max-width: 100px; " type="text" class="table_remarks_${index} table_remarks" name="table_remarks[]" placeholder="Enter remarks note" disabled/></td>
                    <td>
                        <a style="max-width: 100px; border:#FFB64D;border-radius:5px; background-color:#FFB64D; color:white; cursor:pointer;" class="table_btn_${index} text-center px-2 py-1 d-none table_btn" name="table_btn" value="Submit" onclick="handleDataStore(this,${index})">Submit</a>
                    </td>
                    </tr>`;

            $('#table_content').append(rowHtml);
        }

        // for showing no data found in the table
        function appendNoData() {
            var rowHtml = `<tr>
                            <td colspan='11'>
                                No Data Found.
                            </td>
                        </tr>`;
            $('#table_content').append(rowHtml);
        }

    });

    // for table field activation
    function handleFieldActive(checkbox, index) {
        let trElement = $(checkbox).closest("tr");
        let dataId = getCheckedKeys();
        if (dataId.length != 0) {
            $(`.submit_btn`).prop('disabled', false);
            $(`.submit_btn`).css("cursor", "pointer");
        } else {
            $(`.submit_btn`).css("cursor", "auto");
            $(`.submit_btn`).prop('disabled', true);
        }
        let checkboxID = $(checkbox).attr("value");
        if ($(checkbox).prop("checked")) {
            trElement.find(".table_punch_date").prop('disabled', false);
            trElement.find(".table_time_in").prop('disabled', false);
            trElement.find(".table_late").prop('disabled', false);
            trElement.find(".table_time_out").prop('disabled', false);
            trElement.find(".table_status").prop('disabled', false);
            trElement.find(".table_remarks").prop('disabled', false);
            trElement.find(".table_btn").removeClass("d-none");
        } else {
            trElement.find(".table_punch_date").prop('disabled', true);
            trElement.find(".table_time_in").prop('disabled', true);
            trElement.find(".table_late").prop('disabled', true);
            trElement.find(".table_time_out").prop('disabled', true);
            trElement.find(".table_status").prop('disabled', true);
            trElement.find(".table_remarks").prop('disabled', true);
            trElement.find(".table_btn").addClass("d-none");
        }
        // alert(checkboxID);

    }

    function tableStatusCheck(selectThis, index) {

        let trElement = $(selectThis).closest("tr");
        let status = trElement.find('.table_status').val();
        let time_in = trElement.find('.table_time_in').val();

        if (time_in == 0 && status == 'p') {
            trElement.find('.table_time_in').prop("required", true);
        } else if (status == 'l' || status == 'a' || status == 'w' || status == 'h') {
            trElement.find('.table_late').val("00:00");
            trElement.find('.table_time_in').val("");
            trElement.find('.table_time_out').val("");
            trElement.find('.table_time_in').prop("required", false);
        } else {
            trElement.find('.table_time_in').prop("required", false);
        }
    }
    // only for using to check late status
    // function latecalculate(in_time, shift_late){
    //     let value= "Late";
    //     let value_not= "Not Late";

    //     var date1 = new Date("1970-01-01 " + in_time);
    //     var date2 = new Date("1970-01-01 " + shift_late);

    //     if (date1.getTime() > date2.getTime()) {
    //         return value;
    //     } else if (date1.getTime() < date2.getTime()) {
    //         return value_not;
    //     } else {
    //         return value;
    //     }
    // }

    // get late attendace when input in time
    function lateAttendance(index) {
        let in_time = $(`.table_time_in_${index}`).val();
        let status = $(`.table_status_${index}`).val();

        let shift_late = $(`#shift_late_${index}`).val();
        let holiday = $(`#check_holiday_table_${index}`).val();

        let lateHours = 0;
        if (in_time != null && holiday == 0) {
            lateHours = timedifferenceCalculate(((in_time != 0) ? in_time : "00:00"), shift_late);
        } else {
            lateHours = "00:00";
        }
        $(`.table_late_${index}`).val(lateHours);
        if (status != 'h') {
            $(`.table_status_${index} option[value="${status}"]`).prop('selected', true);
        } else if (in_time != null) {
            $(`.table_status_${index} option[value="p"]`).prop('selected', true);
        }


    }

    // individual table tr field required validation
    function validateForm(index) {
        var isValid = true;
        // Check each required input field
        $(`.tr_${index} [required]`).each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
            }
        });

        return isValid;
    }


    // for individual data update and store
    function handleDataStore(action, index) {
        const firstConfirmation = confirm("Are you sure! you want to insert this data?");

        // var regular_hour = $(`#regular_hour`).val();
        var emp_id = $(`#emp_id_${index}`).val();
        var shift_id = $(`#shift_id_${index}`).val();
        var table_late = $(`.table_late_${index}`).val();
        var punch_date = $(`.table_punch_date_${index}`).val();
        var time_in = $(`.table_time_in_${index}`).val();
        var time_out = $(`.table_time_out_${index}`).val();
        var ot_hour = $(`.table_ot_hour_${index}`).val();
        var status = $(`.table_status_${index}`).val();
        var remarks = $(`.table_remarks_${index}`).val();

        if (!validateForm(index)) {
            event.preventDefault();
            alert("Please fill in all required fields.");
        } else {
            if (firstConfirmation) {
                $.ajax({
                    url: "{{ route('singleInsertOrUpdate') }}",
                    type: "POST",
                    data: {
                        emp_id: emp_id,
                        // regular_hour: regular_hour,
                        shift_id: shift_id,
                        late: table_late,
                        punch_date: punch_date,
                        time_in: time_in,
                        time_out: time_out,
                        ot_hour: ot_hour,
                        status: status,
                        remarks: remarks,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        // console.log(response);
                        alert(((response.success != null) ? response.success : response.error));
                    },
                });
            }
        }
    }


    // for check holiday when select individual date
    function getHolidayOrLeave(action, index) {
        // let punch_date = $(action).attr("value");
        let punch_date = $(`.table_punch_date_${index}`).val();
        let employee_id = $(`#emp_id_${index}`).val();
        let in_time = $(`.table_time_in_${index}`).val();
        let out_time = $(`.table_out_time_${index}`).val();
        let status = $(`.table_status_${index}`).val();
        // alert(employee_id);
        $.ajax({
            url: `{{ route('getHolidayOrLeave') }}`,
            type: "POST",
            data: {
                date: punch_date,
                employee_id: employee_id,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                // console.log(response.leave);
                // console.log(response.leave?.leave_type.short_name.toLowerCase());
                $(`#check_holiday_table_${index}`).val(0);
                $(`.table_time_in_${index}`).val("");
                $(`.table_time_out_${index}`).val("");

                $(`.table_late_${index}`).val("00:00");
                $(`.table_status_${index} option[value="a"]`).prop('selected', true);

                if ($.isEmptyObject(response.holiday) && $.isEmptyObject(response.leave)) {
                    // alert('holiday');
                    if (in_time != '') {
                        $(`.table_status_${index} option[value="p"]`).prop('selected', true);
                    } else {
                        $(`.table_status_${index} option[value="a"]`).prop('selected', true);
                    }
                } else if (response.leave !== null) {
                    $(`.table_status_${index} option[value="${response.leave?.leave_type.short_name.toLowerCase()}"]`)
                        .prop('selected', true);
                } else {
                    $(`#check_holiday_table_${index}`).val(1);
                    if (in_time != '') {
                        $(`.table_status_${index} option[value="p"]`).prop('selected', true);
                    } else {
                        $(`.table_status_${index} option[value="h"]`).prop('selected', true);
                    }
                }
            },
        });

    }


    // for fetch data when click auto fill
    function fetchDataFillup() {
        let time_in = $('#time_in').val();
        let time_out = $('#time_out').val();
        let status = $('#status').val();
        let holiday = $('#holiday').val();
        let dataId = getCheckedKeys();
        let date = new Date();
        const todayDate = new Date().toISOString().slice(0, 10);
        let day = get_day(date);

        if (dataId.length != 0) {
            let i = 0;
            for (i = 0; i < dataId.length; i++) {
                let shift_out = $(`#shift_out_${dataId[i]}`).val();
                let shift_late = $(`#shift_late_${dataId[i]}`).val();


                // for late hour
                let lateHours = 0;
                if (time_in != null && holiday == 0) {
                    lateHours = timedifferenceCalculate(((time_in != 0) ? time_in : "00:00"), shift_late);
                } else {
                    lateHours = "00:00";
                }

                $(`.table_late_${dataId[i]}`).val(lateHours);
                $(`.table_punch_date_${dataId[i]}`).val(todayDate);
                if (time_in != 0) {
                    $(`.table_time_in_${dataId[i]}`).val(time_in);
                }
                if (time_out != 0) {
                    $(`.table_time_out_${dataId[i]}`).val(time_out);
                }


                if (day.includes('fri') || day.includes('Sat')) {
                    $(`.table_status_${dataId[i]} option[value="h"]`).prop("selected", true);
                } else if (holiday != 0 && time_in == '') {
                    $(`.table_status_${dataId[i]} option[value="h"]`).prop("selected", true);
                } else if (time_in != '') {
                    $(`.table_status_${dataId[i]} option[value="p"]`).prop("selected", true);
                } else {
                    $(`.table_status_${dataId[i]} option[value="a"]`).prop("selected", true);
                }

                // console.log(holiday);
            }
        } else {
            alert('Please checked table data.')
        }



    }


    // for all check table checkbox
    function AllChecked(action) {
        var value = $(action).attr("value");
        if ($(action).prop("checked")) {
            $(`.submit_btn`).prop('disabled', false);
            $(`.submit_btn`).css("cursor", "pointer");
            $('.table_check').prop('checked', true);
            $(`.table_punch_date`).prop('disabled', false);
            $(`.table_late`).prop('disabled', false);
            $('.table_time_in').prop('disabled', false);
            $('.table_time_out').prop('disabled', false);
            $('.table_status').prop('disabled', false);
            $('.table_remarks').prop('disabled', false);
            $('.table_btn').removeClass("d-none");

        } else {
            $(`.submit_btn`).prop('disabled', true);
            $(`.submit_btn`).css("cursor", "auto");
            $('.table_check').prop('checked', false);
            $(`.table_punch_date`).prop('disabled', true);
            $(`.table_late`).prop('disabled', true);
            $('.table_time_in').prop('disabled', true);
            $('.table_time_out').prop('disabled', true);
            $('.table_status').prop('disabled', true);
            $('.table_remarks').prop('disabled', true);
            $(`.table_btn`).addClass("d-none");
        }
    }

    // calculate time difference related with shift table
    function timedifferenceCalculate(time_form, shift_time) {
        // console.log(time_form + "," + shift_time);
        var split_endtime = time_form.split(":");
        var split_shift_out_hour = shift_time.split(":");

        var dif_hour_reg = "00";
        var dif_mnt_reg = "00";
        if (split_endtime[0] >= split_shift_out_hour[0]) {
            if (split_endtime[1] > split_shift_out_hour[1]) {
                dif_hour_reg = split_endtime[0] - split_shift_out_hour[0];
                dif_mnt_reg = split_endtime[1] - split_shift_out_hour[1];
            } else {
                if ((split_endtime[1] >= split_shift_out_hour[1]) && (split_endtime[0] >= split_shift_out_hour[0])) {
                    dif_hour_reg = split_endtime[0] - split_shift_out_hour[0];
                    dif_mnt_reg = split_endtime[1] - split_shift_out_hour[1];
                } else {
                    if ((split_endtime[0] == split_shift_out_hour[0]) && (split_endtime[1] <= split_shift_out_hour[
                            1])) {
                        dif_hour_reg = "00";
                        dif_mnt_reg = "00";
                    } else if ((split_endtime[0] == split_shift_out_hour[0]) && (split_endtime[1] >
                            split_shift_out_hour[1])) {
                        dif_hour_reg = "00";
                        dif_mnt_reg = split_endtime[1] - split_shift_out_hour[1];
                    } else {
                        dif_hour_reg = split_endtime[0] - split_shift_out_hour[0] - 1;
                        dif_mnt_reg = (60 + parseInt(split_endtime[1])) - split_shift_out_hour[1];
                    }
                }
            }

        }
        var timeDiffernece = (((dif_hour_reg == '00') ? '00' : ((dif_hour_reg < 10) ? "0" + dif_hour_reg :
            dif_hour_reg))) + ":" + (((dif_mnt_reg == '00') ? '00' : ((dif_mnt_reg < 10) ? "0" + dif_mnt_reg :
            dif_mnt_reg)));
        return timeDiffernece;
    }


    // for using all criteria check box
    $(document).on('change', '.cri_type', function() {
        let cri_type = $(this).val();
        $('#employee_id option[value="All"]').attr('disabled', 'disabled');

        if (cri_type == "employee_wise") {

            if ($(this).prop("checked")) {
                console.log('check emp wise');
                $('.emp_wise').prop('checked', false);
                $(".employee_active option:selected").prop("selected", false);
                $('.employee_active').prop('disabled', true);
                $('#employee_id').prop('disabled', false);
            } else {
                $('#employee_id').prop('disabled', true);
            }
        } else if (cri_type == "department") {
            if ($(this).prop("checked")) {
                $('.department_wise').prop('checked', false);
                $("employee_id option").prop("selected", false);
                $('#department_id').prop('disabled', false);
                $('.dept_active').prop('disabled', true);
                $(".dept_active option:selected").prop("selected", false);
            } else {
                $('#department_id').prop('disabled', true);
            }
        } else if (cri_type == "designation") {
            if ($(this).prop("checked")) {
                $('.designation_wise').prop('checked', false);
                $("employee_id option").prop("selected", false);
                $('#designation_id').prop('disabled', false);
                $('.desig_active').prop('disabled', true);
                $(".desig_active option:selected").prop("selected", false);
            } else {
                $('#designation_id').prop('disabled', true);
            }
        } else if (cri_type == "section") {
            if ($(this).prop("checked")) {
                $('.section_wise').prop('checked', false);
                $("employee_id option").prop("selected", false);
                $('#section_id').prop('disabled', false);
                $('.section_active').prop('disabled', true);
                $(".section_active option:selected").prop("selected", false);
            } else {
                $('#section_id').prop('disabled', true);
            }

        } else if (cri_type == "shift") {
            if ($(this).prop("checked")) {
                $('.shift_wise').prop('checked', false);
                $("employee_id option").prop("selected", false);
                $('#shift_id').prop('disabled', false);
                $('.shift_active').prop('disabled', true);
                $(".shift_active option:selected").prop("selected", false);
            } else {
                $('#shift_id').prop('disabled', true);
            }

        } else if (cri_type == "all") {
            $('.all_emp').prop('checked', false);
            $('.employee_all').prop('disabled', true);
            $("select[name='employee_id'] option:first").prop("selected", true);
            $('#employee_id option[value="All"]').prop('disabled', false);
        } else {
            // $('.dept_active').prop('disabled', true);
            // $('.employee_active').prop('disabled', true);
            // $('.section_active').prop('disabled', true);
        }

    });
</script>

@endsection
