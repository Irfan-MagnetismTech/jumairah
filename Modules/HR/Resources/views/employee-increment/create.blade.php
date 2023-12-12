@extends('layouts.backend-layout') @section('title', 'Employee Increment')
@section('breadcrumb-title') @if ($formType == 'edit')
    Edit
@else
    Create
@endif
Employee Increment @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-increments.index') }}"><i
        class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
    'url' => 'hr/employee-increments',
    'method' => 'POST',
    'class' => 'custom-form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
    'url' => "hr/employee-increments/$employee_increments->id",
    'method' => 'PUT',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row">
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="employee_id">Employee<span class="text-danger">*</span></label>
        {{ Form::select(
            'employee_id',
            $employees,
            old('employee_id') ? old('employee_id') : (!empty($employee_increments) ? $employee_increments->employee_id : null),
            ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => 'Select Employee', 'required'],
        ) }}
        @error('employee_id')
            <p class="text-danger">{{ $errors->first('employee_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="incement_type">Increment Type</label>
        {{ Form::select(
            'incement_type',
            [
                'Increment' => 'Increment',
                'Increment with Promotion' => 'Increment with Promotion',
                'Promotion' => 'Promotion',
                'Demotion' => 'Demotion',
            ],
            old('incement_type')
                ? old('incement_type')
                : (!empty($employee_increments->incement_type)
                    ? $employee_increments->incement_type
                    : null),
            [
                'class' => 'form-control select2 required-field',
                'id' => 'incement_type',
                'placeholder' => 'Select Increment Type',
            ],
        ) }}
        @error('incement_type')
            <p class="text-danger">{{ $errors->first('incement_type') }}</p>
        @enderror
    </div>
</div>


<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
        {{ Form::date(
            'date',
            old('date') ? old('date') : (!empty($employee_increments->date) ? $employee_increments->date : null),
            ['class' => 'form-control', 'id' => 'date', 'placeholder' => 'Enter Date Here', 'required'],
        ) }}

        @error('date')
            <p class="text-danger">{{ $errors->first('date') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="join_date">Join Date </label>
        <input type="text" class="form-control" id="join_date" disabled>
        @error('join_date')
            <p class="text-danger">{{ $errors->first('join_date') }}</p>
        @enderror
    </div>
</div>


<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="employee_name">Employee Name </label>
        <input type="text" class="form-control" id="employee_name" disabled>
        @error('employee_name')
            <p class="text-danger">{{ $errors->first('employee_name') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="designation">Designation </label>
        <input type="text" class="form-control" id="designation" disabled>
        @error('designation')
            <p class="text-danger">{{ $errors->first('designation') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="section">Section </label>
        <input type="text" class="form-control" id="section" disabled>
        @error('section')
            <p class="text-danger">{{ $errors->first('section') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="emp_type">Employee Type </label>
        <input type="text" class="form-control" id="emp_type" disabled>
        @error('emp_type')
            <p class="text-danger">{{ $errors->first('emp_type') }}</p>
        @enderror
    </div>
</div>

<div class="col-12 my-3 border-primary ">
    <h6>Designation</h6>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="old_designation_id">Old Designation</label>
        <input type="hidden" class="form-control" id="old_designation_id" name="old_designation_id">
        <input type="text" class="form-control" id="old_designation" disabled>

        @error('old_designation_id')
            <p class="text-danger">{{ $errors->first('old_designation_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="new_designation_id">New Designation</label>

        {{ Form::select(
            'new_designation_id',
            $designations,
            old('new_designation_id')
                ? old('new_designation_id')
                : (!empty($employee_increments)
                    ? $employee_increments->new_designation_id
                    : null),
            [
                'class' => 'form-control select2 increment-class only-promotion',
                'id' => 'new_designation_id',
                'placeholder' => 'Select Employee',
                'required',
                'disabled',
            ],
        ) }}
        @error('new_designation_id')
            <p class="text-danger">{{ $errors->first('new_designation_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-12 my-3 border-primary ">
    <h6>Section</h6>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="old_section_id">Old section</label>
        <input type="hidden" class="form-control" id="old_section_id" name="old_section_id">
        <input type="text" class="form-control" id="old_section" disabled>

        @error('old_section_id')
            <p class="text-danger">{{ $errors->first('old_section_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="new_section_id">New section</label>

        {{ Form::select(
            'new_section_id',
            $sections,
            old('new_section_id')
                ? old('new_section_id')
                : (!empty($employee_increments)
                    ? $employee_increments->new_section_id
                    : null),
            [
                'class' => 'form-control select2 increment-class only-promotion',
                'id' => 'new_section_id',
                'placeholder' => 'Select Employee',
                'disabled',
            ],
        ) }}
        @error('new_section_id')
            <p class="text-danger">{{ $errors->first('new_section_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-12 my-3 border-primary ">
    <h6>Emp Type</h6>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="old_emp_type_id">Old Emp Type</label>
        <input type="hidden" class="form-control" id="old_emp_type_id" name="old_emp_type_id">
        <input type="text" class="form-control" id="old_emp_type" disabled>

        @error('old_emp_type_id')
            <p class="text-danger">{{ $errors->first('old_emp_type_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="new_emp_type_id">New emp type</label>

        {{ Form::select(
            'new_emp_type_id',
            $employee_types,
            old('new_emp_type_id')
                ? old('new_emp_type_id')
                : (!empty($employee_increments)
                    ? $employee_increments->new_emp_type_id
                    : null),
            [
                'class' => 'form-control select2 increment-class only-promotion',
                'id' => 'new_emp_type_id',
                'placeholder' => 'Select Employee',
                'required',
                'disabled',
            ],
        ) }}
        @error('new_emp_type_id')
            <p class="text-danger">{{ $errors->first('new_emp_type_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-12 my-3 border-primary ">
    <h6>Previous Salary Amount</h6>
</div>

<div class="col-12">
    <table>
        <tr>
            <td class="text-center">
                GS
                <input type="text" class="form-control" id="old_gs" name="old_gs" readonly>
            </td>
            <td class="text-center">
                BS
                <input type="text" class="form-control" id="old_bs" name="old_bs" readonly>
            </td>
            <td class="text-center">
                HR
                <input type="text" class="form-control" id="old_hr" name="old_hr" readonly>
            </td>
            <td class="text-center">
                TA
                <input type="text" class="form-control" id="old_ta" name="old_ta" readonly>
            </td>
            <td class="text-center">
                FA
                <input type="text" class="form-control" id="old_fa" name="old_fa" readonly>
            </td>
            <td class="text-center">
                MA
                <input type="text" class="form-control" id="old_ma" name="old_ma" readonly>
            </td>
        </tr>
    </table>
</div>

<div class="col-12 my-3 border-primary ">
    <h6>Increment</h6>
</div>

<div class="col-12">
    <table>
        <tr>
            <td class="text-center">
                Amount
                <input type="text" class="form-control increment-class only-increment" disabled
                    id="increment_amount" name="increment_amount">
            </td>
            <td class="text-center">
                %
                <input type="text" class="form-control increment-class only-increment" disabled
                    id="increment_percentage" name="increment_percentage">
            </td>

        </tr>
        <tr class="mt-3">
            <td class="text-center">
                New GS
                <input type="text" class="form-control" id="new_gs" name="new_gs" readonly>
            </td>
            <td class="text-center">
                New BS
                <input type="text" class="form-control" id="new_bs" name="new_bs" readonly>
            </td>
            <td class="text-center">
                New HR
                <input type="text" class="form-control" id="new_hr" name="new_hr" readonly>
            </td>
            <td class="text-center">
                New TA
                <input type="text" class="form-control" id="new_ta" name="new_ta" readonly>
            </td>
            <td class="text-center">
                New FA
                <input type="text" class="form-control" id="new_fa" name="new_fa" readonly>
            </td>
            <td class="text-center">
                New MA
                <input type="text" class="form-control" id="new_ma" name="new_ma" readonly>
            </td>
        </tr>
    </table>
</div>


</div>
<!-- end row -->



<div class="row">
<div class="offset-md-4 col-md-4 mt-2">
    <div class="input-group input-group-sm">
        <button class="btn btn-success btn-round btn-block py-2">
            Submit
        </button>
    </div>
</div>
</div>
<!-- end row -->
{!! Form::close() !!} @endsection @section('script')
<script>
    var salary_ratios = null;
    var gross_salary = null;
    var employee_info = null;

    $(document).on('change', '#employee_id', function() {
        // let emp_id = $(this).val();
        // alert(emp_id)
        $.ajax({
            url: "{{ route('getEmployeeTypeSalary') }}",
            type: "POST",
            data: {
                employee_id: $(this).val(),
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                // console.log(data.employee.section);
                // console.log(data);

                $('#employee_name').val(data.employee.emp_name);
                $('#join_date').val(data.employee.join_date.slice(0, 10).split('-').reverse().join(
                    '/'));
                // $('#join_date').val(moment(data.employee.join_date).format("DD-MM-YYYY"));
                $('#designation').val(data.employee.designation?.name);
                $('#emp_type').val(data.employee.employee_type?.name);
                $('#section').val(data.employee.section?.name);

                $('#old_designation_id').val(data.employee.designation?.id);
                $('#old_designation').val(data.employee.designation?.name);
                $('#old_emp_type_id').val(data.employee.employee_type?.id);
                $('#old_emp_type').val(data.employee.employee_type?.name);
                $('#old_section_id').val(data.employee.section?.id);
                $('#old_section').val(data.employee.section?.name);

                if (data.employee.employee_salary != null) {
                    $('#old_gs').val(data.employee.employee_salary?.gross_salary);
                    $('#old_bs').val(data.employee.employee_salary?.basic_salary);
                    $('#old_hr').val(data.employee.employee_salary?.house_rent);
                    $('#old_ta').val(data.employee.employee_salary?.tansport_allowance);
                    $('#old_fa').val(data.employee.employee_salary?.food_allowance);
                    $('#old_ma').val(data.employee.employee_salary?.medical_allowance);
                }

                salary_ratios = data['employee_salary'];
                gross_salary = data.employee.employee_salary.gross_salary;
                employee_info = data['employee'];
            },
        });
    })

    // for increment salary ammount
    $(document).on('change', '#increment_amount', function() {
        let increment_ammount = $(this).val();
        let inc_gross_percent = (increment_ammount / gross_salary) * 100;
        $("#increment_percentage").val(inc_gross_percent);
        grossSalaryCalculate(increment_ammount);
    });
    // for increment salary percentage
    $(document).on('change', '#increment_percentage', function() {
        let inc_percant = $(this).val();
        let increment_ammount = (gross_salary * inc_percant) / 100;
        $("#increment_amount").val(increment_ammount);
        grossSalaryCalculate(increment_ammount);
    });
    // for increment salary function
    function grossSalaryCalculate(increment_ammount) {
        // alert(increment_ammount);
        let inc_gross_salary = Number(gross_salary) + Number(increment_ammount);
        var basic_salary = inc_gross_salary * (Number(salary_ratios.basic) / 100);
        var house_rent = inc_gross_salary * (Number(salary_ratios.house_rent) / 100);
        var medical_allowance = inc_gross_salary * (Number(salary_ratios.medical_allowance) / 100);
        var conveyance_allowance = inc_gross_salary * (Number(salary_ratios.conveyance_allowance) / 100);
        var food_allowance = inc_gross_salary * (Number(salary_ratios.food_allowance) / 100);

        $("#new_gs").val(inc_gross_salary);
        $("#new_bs").val(basic_salary);
        $("#new_hr").val(house_rent);
        $("#new_ma").val(medical_allowance);
        $("#new_ta").val(conveyance_allowance);
        $("#new_fa").val(food_allowance);
    }

    $(document).on('change', 'select[name="incement_type"]', function() {
        let inc_type = $(this).val();
        if (inc_type == "Increment") {
            $('.increment-class').prop('disabled', true);
            $('.only-increment').prop('disabled', false);
        } else if (inc_type == "Increment with Promotion") {
            $('.increment-class').prop('disabled', false);
            // $('.new_designation_id').prop('disabled', false);
            //$('.only-increment').prop('disabled', false);
        } else if (inc_type == "Promotion") {
            $('.increment-class').prop('disabled', true);
            $('.only-promotion').prop('disabled', false);
        } else {
            $('.increment-class').prop('disabled', true);
            $('.only-promotion').prop('disabled', false);
        }

    })

    $(document).on("change", "#gross_salary", function() {

        var basic_salary = $(this).val() * (Number(salary_ratios.basic) / 100);
        var house_rent = $(this).val() * (Number(salary_ratios.house_rent) / 100);
        var medical_allowance = $(this).val() * (Number(salary_ratios.medical_allowance) / 100);
        var conveyance_allowance = $(this).val() * (Number(salary_ratios.conveyance_allowance) / 100);
        var food_allowance = $(this).val() * (Number(salary_ratios.food_allowance) / 100);

        $("#basic_salary").val(basic_salary);
        $("#house_rent").val(house_rent);
        $("#medical_allowance").val(medical_allowance);
        $("#tansport_allowance").val(conveyance_allowance);
        $("#food_allowance").val(food_allowance);

        CalculateTotalSalary();
    });

    $(document).on("change", "#other_allowance,#mobile_allowance,#grade_bonus, #skill_bonus, #management_bonus ",
        function() {
            CalculateTotalSalary();
        })

    function PutEmployeeData() {

    }

    function CalculateTotalSalary() {

        let gross_salary = $('#gross_salary').val();
        let other_allowance = $('#other_allowance').val();
        let mobile_allowance = $('#mobile_allowance').val();
        let grade_bonus = $('#grade_bonus').val();
        let skill_bonus = $('#skill_bonus').val();
        let management_bonus = $('#management_bonus').val();
        let total_salary = Number(gross_salary) + Number(other_allowance) + Number(mobile_allowance) + Number(
                grade_bonus) +
            Number(skill_bonus) + Number(management_bonus);
        $('#total_salary').val(total_salary);

    }
</script>

@endsection
