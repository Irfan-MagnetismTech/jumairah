@extends('layouts.backend-layout') @section('title', 'Employee Leave Entry')
@section('breadcrumb-title') @if ($formType == 'edit')
Edit
@else
Create
@endif
Employee Leave Entry @endsection
@section('style')
<style>
    .input-group-addon {
        min-width: 115px !important;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('leave-entries.index') }}"><i class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
'url' => 'hr/leave-entries',
'method' => 'POST',
'class' => 'custom-form',
'files' => true,
'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
'url' => "hr/leave-entries/$leave_entry->id",
'method' => 'PUT',
'files' => true,
'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row">
    <div class="col-7" id="leave_details">
        <div>
            <h6 class="text-center">Leave Balance</h6>
        </div>
        <table id="shift-table" class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <th width="25%" class="text-left  px-2">Employee Name</th>
                    <td id="get_emp_name" class="text-left px-2" width="25%" colspan="2">{{($formType == 'create')?'':(!empty($leave_balance->employee)? $leave_balance->employee->emp_name:'0')}}</td>
                </tr>
                <tr>
                    <th width="25%" class="text-left  px-2">Code</th>
                    <td id="get_emp_code" width="25%">{{($formType == 'create')?'':(!empty($leave_balance->employee)? $leave_balance->employee?->emp_code:'0')}}</td>
                    <th class="text-left px-2">Year</th>
                    <td id="get_year">{{($formType == 'create')?'':(!empty($leave_balance)? $leave_balance->year:'0')}}</td>
                </tr>
                <tr>
                    <th width="25%" class="text-left  px-2">Casual Leave(Total)</th>
                    <td id="get_cl_total" width="25%">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details)? $leave_balance->leave_balance_details->cl:'0')}}</td>
                    <th width="25%" class="text-left  px-2">Casual Leave(Enjoy)</th>
                    <td id="get_cl_enjoy" width="25%">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details->cl_enjoyed)? $leave_balance->leave_balance_details->cl_enjoyed:'0')}}</td>

                </tr>
                <tr>
                    <th class="text-left  px-2">Sick Leave(Total)</th>
                    <td id="get_sl_total">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details)? $leave_balance->leave_balance_details->sl:'0')}}</td>
                    <th class="text-left px-2">Sick Leave(Enjoy)</th>
                    <td id="get_sl_enjoy">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details->sl_enjoyed)? $leave_balance->leave_balance_details->sl_enjoyed:'0')}}</td>
                </tr>
                <tr>
                    <th class="text-left px-2">Earned Leave(Total)</th>
                    <td id="get_el_total">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details)? $leave_balance->leave_balance_details->el:'0')}}</td>
                    <th class="text-left px-2">Earned Leave(Enjoy)</th>
                    <td id="get_el_enjoy">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details->el_enjoyed)? $leave_balance->leave_balance_details->el_enjoyed:'0')}}</td>
                </tr>

                <tr>
                    <th class="text-left px-2">Maternity Leave(Total)</th>
                    <td id="get_ml_total">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details)? $leave_balance->leave_balance_details->ml:'0')}}</td>
                    <th class="text-left px-2">Maternity Leave(Enjoy)</th>
                    <td id="get_ml_enjoy">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details->ml_enjoyed)? $leave_balance->leave_balance_details->ml_enjoyed:'0')}}</td>
                </tr>
                <tr>
                    <th class="text-left px-2">Others</th>
                    <td id="get_other">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details->other)? $leave_balance->leave_balance_details->other:'0')}}</td>
                    <th class="text-left px-2">Others(Enjoy)</th>
                    <td id="get_other_enjoy">{{($formType == 'create')?'':(!empty($leave_balance->leave_balance_details->other_enjoyed)? $leave_balance->leave_balance_details->other_enjoyed:'0')}}</td>
                </tr>

            </tbody>
        </table>
        @if ($formType == 'create')
            <div>
                <h6 class="text-center">Latest Leave Application</h6>
            </div>
            <table id="shift-table" class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th width="25%" class="text-left  px-2">Code</th>
                        <td id="get_avail_emp_code" width="25%"></td>
                        <th width="25%" class="text-left  px-2">Employee Name</th>
                        <td id="get_avail_emp_name" width="25%"></td>
                    </tr>
                    <tr>
                        <th width="25%" class="text-left  px-2">From Date</th>
                        <td id="get_from_date" width="25%"></td>
                        <th width="25%" class="text-left  px-2">To Date</th>
                        <td id="get_to_date" width="25%"></td>
                    </tr>
                    <tr>
                        <th class="text-left px-2">Days</th>
                        <td id="get_day"></td>
                        <th width="25%" class="text-left  px-2">Leave Type</th>
                        <td id="get_leave_type" width="25%"></td>
                    </tr>
                    <tr>
                        <th class="text-left px-2">Status</th>
                        <td id="get_status"></td>
                        <th class="text-left px-2">Remarks</th>
                        <td id="get_remark"></td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
    <div class="col-5">
        <div class="input-group input-group-sm input-group-primary mb-2 mt-3">
            <label class="input-group-addon" for="date">Apply Date <span class="text-danger">*</span></label>
            {{ Form::date(
            'apply_date',
            old('apply_date')
            ? old('apply_date')
            : (!empty($leave_entry)
            ? $leave_entry->apply_date : null),
            ['class' => 'form-control disable', 'id' => 'apply_date', 'placeholder' => 'Enter Date Here', 'required', ($formType == 'create') ? 'disabled' : ''],
            ) }}

            @error('apply_date')
                <p class="text-danger">{{ $errors->first('apply_date') }}</p>
            @enderror
        </div>
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="year">Leave Balance Year <span class="text-danger">*</span></label>
            {{ Form::selectYear(
                'leave_year',
                date('Y'),
                date('Y') + 1,
                old('leave_year') ? old('year') : (!empty($leave_entry)
            ? $leave_entry->leave_year : null),
                ['class' => 'form-control', 'id' => 'leave_year', 'placeholder' => 'Select Leave Year', 'required']
            ) }}

            @error('leave_year')
                <p class="text-danger">{{ $errors->first('leave_year') }}</p>
            @enderror
        </div>
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="emp_id">Employee<span class="text-danger">*</span></label>
            {{Form::select('emp_id',$employees, old('emp_id') ? old('emp_id') : (!empty($leave_entry)
            ? $leave_entry->emp_id : null),['class' => 'form-control select2','id' => 'emp_id', 'placeholder' =>
            'Select Employee', 'required'] )}}
            @error('emp_id') <p class="text-danger">{{ $errors->first('emp_id') }}</p> @enderror
        </div>
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="leave_id">Leave Type<span class="text-danger">*</span></label>
            {{Form::select('leave_type_id',$leave_types, old('leave_type_id') ? old('leave_type_id') : (!empty($leave_entry)
            ? $leave_entry->leave_type_id : null),['class' => 'form-control select2 disable','id' => 'leave_type_id', 'placeholder' =>
            'Select Leave', 'required', ($formType == 'create') ? 'disabled' : ''] )}}
            <input type="hidden" name="leave_type_name" id="leave_type_name" value="{{(!empty($leave_entry->leave_type)
            ? $leave_entry->leave_type->name : null)}}">
            @error('leave_type_id') <p class="text-danger">{{ $errors->first('leave_type_id') }}</p> @enderror
        </div>

        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="date">From Date <span class="text-danger">*</span></label>
            {{ Form::date(
            'from_date',
            old('from_date')
            ? old('from_date')
            : (!empty($leave_entry)
            ? $leave_entry->from_date : null),
            ['class' => 'form-control', 'id' => 'from_date', 'placeholder' => 'Enter Date Here', 'required',($formType == 'create') ? 'disabled' : ''],
            ) }}

            @error('from_date')
                <p class="text-danger">{{ $errors->first('from_date') }}</p>
            @enderror
        </div>


        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="date">To Date <span class="text-danger">*</span></label>
            {{ Form::date(
            'to_date',
            old('to_date')
            ? old('to_date')
            : (!empty($leave_entry)
            ? $leave_entry->to_date : null),
            ['class' => 'form-control', 'id' => 'to_date', 'placeholder' => 'Enter Date Here', 'required',($formType == 'create') ? 'disabled' : ''],
            ) }}

            @error('to_date')
                <p class="text-danger">{{ $errors->first('to_date') }}</p>
            @enderror
        </div>
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="date">Total Days <span class="text-danger">*</span></label>
            {{ Form::text(
            'total_day',
            old('total_day')
            ? old('total_day')
            : (!empty($leave_entry)
            ? $leave_entry->total_day : null),
            ['class' => 'form-control', 'id' => 'total_day', 'placeholder' => '', 'required','readonly'],
            ) }}

            @error('total_day')
                <p class="text-danger">{{ $errors->first('total_day') }}</p>
            @enderror
        </div>
        <p class='show_message' style="display:none;color:red;"></p>
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="date">Leave Reason <span class="text-danger">*</span></label>
            {{ Form::textarea(
            'reason',
            old('reason')
            ? old('reason')
            : (!empty($leave_entry)
            ? $leave_entry->reason : null),
            ['class' => 'form-control disable', 'id' => 'reason', 'placeholder' => '', 'required','rows' => 3,($formType == 'create') ? 'disabled' : ''],
            ) }}

            @error('reason')
                <p class="text-danger">{{ $errors->first('reason') }}</p>
            @enderror
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="">
                    <div class="input-group input-group-sm">
                        <button name="save" value="save" class="btn btn-success btn-round btn-block py-2 disable_btn">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="">
                    <div class="input-group input-group-sm">
                        <button name="approve_save" value="approved and save" class="btn btn-success btn-round btn-block py-2 disable_btn">
                            Save and Approved
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- end row -->
{!! Form::close() !!} @endsection @section('script')
<script>



        $(document).ready(function(){
            $(document).on('change', '#from_date', function() {
                $('#to_date').prop('disabled', false);
                var from_date=$(this).val();
                var to_date=$('#to_date').val();
                const todateInput = document.getElementById('to_date');
                let oneMonthLater = new Date(from_date);
                oneMonthLater.setMonth(oneMonthLater.getMonth());
                let minDate = oneMonthLater.toISOString().split("T")[0];
                todateInput.setAttribute("min", minDate);

                if(to_date){
                    var fromDateObj = new Date(from_date);
                    var toDateObj = new Date(to_date);
                    var timeDifferenceMs = toDateObj - fromDateObj;
                    var total_days = (timeDifferenceMs / (1000 * 60 * 60 * 24))+1;
                    $("#total_day").val(total_days);
                    leaveCheck();
                }

            });
            $(document).on('change', '#leave_year', function() {
                $("#emp_id option").prop("selected", false);
            });

            $(document).on('change', '#emp_id', function() {

                $('#leave_details').waitMe({ effect: 'ios'  });

                let emp_id = $(this).val();
                let year = $('#leave_year').val();
                const fromdateInput = document.getElementById("from_date");
                const todateInput = document.getElementById("to_date");

                $.ajax({
                    url: "{{ route('getEmployeeLeaves') }}",
                    type: "POST",
                    data: {
                        employee_id: $(this).val(),
                        year: year,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#leave_details').waitMe('hide');
                        // for leave balance table
                            $("#get_emp_code").text(data.leave_balance?.employee.emp_code || '');
                            $("#get_emp_name").text(data.leave_balance?.employee.emp_name || '');
                            $("#get_cl_total").text(data.leave_balance?.leave_balance_details.cl || '');
                            $("#get_sl_total").text(data.leave_balance?.leave_balance_details.sl || '');
                            $("#get_el_total").text(data.leave_balance?.leave_balance_details.el || '');
                            $("#get_ml_total").text(data.leave_balance?.leave_balance_details.ml || '');
                        if(data.leave_balance!=null){
                            $("#get_cl_enjoy").text(((data.leave_balance?.leave_balance_details.cl_enjoyed!=null)?data.leave_balance?.leave_balance_details.cl_enjoyed : '0'));
                            $("#get_sl_enjoy").text(((data.leave_balance?.leave_balance_details.sl_enjoyed!=null)?data.leave_balance?.leave_balance_details.sl_enjoyed:'0'));
                            $("#get_el_enjoy").text(((data.leave_balance?.leave_balance_details.el_enjoyed!=null)?data.leave_balance?.leave_balance_details.el_enjoyed:'0'));
                            $("#get_ml_enjoy").text(((data.leave_balance?.leave_balance_details.ml_enjoyed!=null)?data.leave_balance.leave_balance_details.ml_enjoyed:'0'));
                            $("#get_other").text(((data.leave_balance?.other!=null)?data.leave_balance?.other:'0'));
                            $("#get_other_enjoy").text(((data.leave_balance?.other_enjoyed!=null)?data.leave_balance?.other_enjoyed:'0'));
                            $('.disable').prop('disabled', false);
                        }else{
                            $("#leave_year option").prop("selected", false);
                            $("#get_cl_enjoy").text('');
                            $("#get_sl_enjoy").text('');
                            $("#get_el_enjoy").text('');
                            $("#get_ml_enjoy").text('');
                            $("#get_other").text('');
                            $("#get_other_enjoy").text('');
                            $('.disable').prop('disabled', true);
                            alert('Your can not apply for this year');
                        }
                        $("#get_year").text(data.leave_balance?.year || '');


                        // for leave avail table
                        if(data.leave_entry!=null){
                            $("#get_avail_emp_code").text(data.leave_balance?.employee.emp_code);
                            $("#get_avail_emp_name").text(data.leave_balance?.employee.emp_name);
                        }else{
                            $("#get_avail_emp_code").text('');
                            $("#get_avail_emp_name").text('');
                        }

                        $("#get_from_date").text(data.leave_entry?.from_date.slice(0,10).split('-').reverse().join('/') || '');
                        $("#get_to_date").text(data.leave_entry?.to_date.slice(0,10).split('-').reverse().join('/')  || '');
                        $("#get_day").text(data.leave_entry?.total_day);
                        $("#get_status").text(((data.leave_entry?.total_day==0)?'Pending':((data.leave_entry?.is_approved==1)?'Approved':((data.leave_entry?.is_reject==1)?'Rejected':''))));
                        $("#get_remark").text(data.leave_entry?.remarks || '');
                        $("#get_leave_type").text(data.leave_entry?.leave_type.name || '');

                        leaveCheck();
                        fromdateInput.min = `${year}-01-01`;
                        fromdateInput.max = `${year}-12-31`;
                        todateInput.min = `${year}-01-01`;
                        todateInput.max = `${year}-12-31`;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    $('#leave_balance').waitMe("hide");
                    console.log(textStatus + ': ' + errorThrown);
                }
                });


            });


            $(document).on('change', '#to_date', function() {
                var to_date=$(this).val();
                var from_date=$('#from_date').val();

                var fromDateObj = new Date(from_date);
                var toDateObj = new Date(to_date);

                var timeDifferenceMs = toDateObj - fromDateObj;
                var total_days = (timeDifferenceMs / (1000 * 60 * 60 * 24))+1;
                $("#total_day").val(total_days);
                leaveCheck();
            });

            $(document).on('change', 'select[name="leave_type_id"]', function() {
                $('#from_date').prop('disabled', false);
                leaveCheck();

            });

            function leaveCheck() {
                var leave_type = $('select[name="leave_type_id"] option:selected').text();

                var total_days = parseInt($("#total_day").val(), 10);

                var total_cl = parseInt($("#get_cl_total").text(), 10);
                var cl_enjoy = parseInt($("#get_cl_enjoy").text(), 10);
                var cl_sub = total_cl - cl_enjoy;

                var total_sl = parseInt($("#get_sl_total").text(), 10);
                var sl_enjoy = parseInt($("#get_sl_enjoy").text(), 10);
                var sl_sub = total_sl - sl_enjoy;

                var total_el = parseInt($("#get_el_total").text(), 10);
                var el_enjoy = parseInt($("#get_el_enjoy").text(), 10);
                var el_sub = total_el - el_enjoy;

                var total_ml = parseInt($("#get_ml_total").text(), 10);
                var ml_enjoy = parseInt($("#get_ml_enjoy").text(), 10);
                var ml_sub = total_ml - ml_enjoy;

                var total_other = parseInt($("#get_other").text(), 10);
                var other_enjoy = parseInt($("#get_other_enjoy").text(), 10);
                var others = total_other - other_enjoy;

                $('#leave_type_name').val(leave_type);

                $('.disable_btn').prop('disabled', false);
                $('.show_message').hide();
                var message= 'You have ';
                if(leave_type!="Select Leave"){
                    if (leave_type == 'Casual Leave') {
                        if (cl_sub < total_days) {
                            $('.show_message').text(message + cl_sub + ' available casual leaves.');
                            $('.show_message').show();
                            $('.disable_btn').prop('disabled', true);
                        }
                    } else if (leave_type == 'Sick Leave') {
                        if (sl_sub < total_days) {
                            $('.show_message').text(message + sl_sub + ' available sick leaves.');
                            $('.show_message').show();
                            $('.disable_btn').prop('disabled', true);
                        }
                    } else if (leave_type == 'Earned Leave') {
                        if (el_sub < total_days) {
                            $('.show_message').text(message + el_sub + ' available earned leaves.');
                            $('.show_message').show();
                            $('.disable_btn').prop('disabled', true);
                        }
                    } else if (leave_type == 'Maternity Leave') {
                        if (ml_sub < total_days) {
                            $('.show_message').text(message + ml_sub + ' available maternity leaves.');
                            $('.show_message').show();
                            $('.disable_btn').prop('disabled', true);
                        }
                    } else{
                        if (others < total_days) {
                            $('.show_message').text(message + others + ' available others leaves.');
                            $('.show_message').show();
                            $('.disable_btn').prop('disabled', true);
                        }
                    }
                }
            }
        });

</script>

@endsection
