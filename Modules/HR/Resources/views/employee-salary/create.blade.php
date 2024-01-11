@extends('layouts.backend-layout') @section('title', 'Employee Salary')
@section('breadcrumb-title') @if ($formType == 'edit')
    Edit
@else
    Create
@endif
Employee Salary @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-salaries.index') }}"><i
        class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
    'url' => 'hr/employee-salaries',
    'method' => 'POST',
    'class' => 'custom-form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
    'url' => "hr/employee-salaries/$employee_salary->id",
    'method' => 'PUT',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row">
<div class="col-12">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="employee_id">Employee<span class="text-danger">*</span></label>
        {{ Form::select(
            'employee_id',
            $employees,
            old('employee_id') ? old('employee_id') : (!empty($employee_salary) ? $employee_salary->employee_id : null),
            ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => 'Select Employee', 'required'],
        ) }}
        @error('employee_id')
            <p class="text-danger">{{ $errors->first('employee_id') }}</p>
        @enderror
    </div>
</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="gross_salary">Gross Salary <span class="text-danger">*</span></label>
        {{ Form::text(
            'gross_salary',
            old('gross_salary')
                ? old('gross_salary')
                : (!empty($employee_salary->gross_salary)
                    ? $employee_salary->gross_salary
                    : null),
            ['class' => 'form-control', 'id' => 'gross_salary', 'placeholder' => 'Enter gross salary Here', 'required'],
        ) }}

        @error('gross_salary')
            <p class="text-danger">{{ $errors->first('gross_salary') }}</p>
        @enderror
    </div>

</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="basic_salary">Basic Salary <span class="text-danger">*</span></label>
        {{ Form::text(
            'basic_salary',
            old('basic_salary')
                ? old('basic_salary')
                : (!empty($employee_salary->basic_salary)
                    ? $employee_salary->basic_salary
                    : null),
            [
                'class' => 'form-control',
                'id' => 'basic_salary',
                'placeholder' => 'Enter basic salary Here',
                'readonly',
                'required',
            ],
        ) }}

        @error('basic_salary')
            <p class="text-danger">{{ $errors->first('basic_salary') }}</p>
        @enderror
    </div>

</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="house_rent">House Rent <span class="text-danger">*</span></label>
        {{ Form::text(
            'house_rent',
            old('house_rent')
                ? old('house_rent')
                : (!empty($employee_salary->house_rent)
                    ? $employee_salary->house_rent
                    : null),
            ['class' => 'form-control', 'id' => 'house_rent', 'placeholder' => 'Enter house rent Here', 'readonly', 'required'],
        ) }}

        @error('house_rent')
            <p class="text-danger">{{ $errors->first('house_rent') }}</p>
        @enderror
    </div>

</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="medical_allowance">Medical Allowance <span
                class="text-danger">*</span></label>
        {{ Form::text(
            'medical_allowance',
            old('medical_allowance')
                ? old('medical_allowance')
                : (!empty($employee_salary->medical_allowance)
                    ? $employee_salary->medical_allowance
                    : null),
            [
                'class' => 'form-control',
                'id' => 'medical_allowance',
                'placeholder' => 'Enter medical allowance Here',
                'readonly',
                'required',
            ],
        ) }}

        @error('medical_allowance')
            <p class="text-danger">{{ $errors->first('medical_allowance') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="tansport_allowance">Transport Allowance <span
                class="text-danger">*</span></label>
        {{ Form::text(
            'tansport_allowance',
            old('tansport_allowance')
                ? old('tansport_allowance')
                : (!empty($employee_salary->tansport_allowance)
                    ? $employee_salary->tansport_allowance
                    : null),
            [
                'class' => 'form-control',
                'id' => 'tansport_allowance',
                'placeholder' => 'Enter transport allowance Here',
                'readonly',
                'required',
            ],
        ) }}

        @error('tansport_allowance')
            <p class="text-danger">{{ $errors->first('tansport_allowance') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="food_allowance">Food Allowance <span
                class="text-danger">*</span></label>
        {{ Form::text(
            'food_allowance',
            old('food_allowance')
                ? old('food_allowance')
                : (!empty($employee_salary->food_allowance)
                    ? $employee_salary->food_allowance
                    : null),
            [
                'class' => 'form-control',
                'id' => 'food_allowance',
                'placeholder' => 'Enter food allowance Here',
                'readonly',
                'required',
            ],
        ) }}

        @error('food_allowance')
            <p class="text-danger">{{ $errors->first('food_allowance') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="other_allowance">Other Allowance</label>
        {{ Form::text(
            'other_allowance',
            old('other_allowance')
                ? old('other_allowance')
                : (!empty($employee_salary->other_allowance)
                    ? $employee_salary->other_allowance
                    : null),
            ['class' => 'form-control', 'id' => 'other_allowance', 'placeholder' => 'Enter other allowance Here'],
        ) }}

        @error('other_allowance')
            <p class="text-danger">{{ $errors->first('other_allowance') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="mobile_allowance">Mobile Allowance </label>
        {{ Form::text(
            'mobile_allowance',
            old('mobile_allowance')
                ? old('mobile_allowance')
                : (!empty($employee_salary->mobile_allowance)
                    ? $employee_salary->mobile_allowance
                    : null),
            ['class' => 'form-control', 'id' => 'mobile_allowance', 'placeholder' => 'Enter mobile allowance Here'],
        ) }}

        @error('mobile_allowance')
            <p class="text-danger">{{ $errors->first('mobile_allowance') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="grade_bonus">Grade Bonus </label>
        {{ Form::text(
            'grade_bonus',
            old('grade_bonus')
                ? old('grade_bonus')
                : (!empty($employee_salary->grade_bonus)
                    ? $employee_salary->grade_bonus
                    : null),
            ['class' => 'form-control', 'id' => 'grade_bonus', 'placeholder' => 'Enter grade bonus Here'],
        ) }}

        @error('grade_bonus')
            <p class="text-danger">{{ $errors->first('grade_bonus') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="skill_bonus">Skill Bonus </label>
        {{ Form::text(
            'skill_bonus',
            old('skill_bonus')
                ? old('skill_bonus')
                : (!empty($employee_salary->skill_bonus)
                    ? $employee_salary->skill_bonus
                    : null),
            ['class' => 'form-control', 'id' => 'skill_bonus', 'placeholder' => 'Enter skill bonus Here'],
        ) }}

        @error('skill_bonus')
            <p class="text-danger">{{ $errors->first('skill_bonus') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="management_bonus">Management Bonus </label>
        {{ Form::text(
            'management_bonus',
            old('management_bonus')
                ? old('management_bonus')
                : (!empty($employee_salary->management_bonus)
                    ? $employee_salary->management_bonus
                    : null),
            ['class' => 'form-control', 'id' => 'management_bonus', 'placeholder' => 'Enter management bonus Here'],
        ) }}

        @error('management_bonus')
            <p class="text-danger">{{ $errors->first('management_bonus') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="total_salary">Total Salary </label>
        {{ Form::text(
            'total_salary',
            old('total_salary')
                ? old('total_salary')
                : (!empty($employee_salary->total_salary)
                    ? $employee_salary->total_salary
                    : null),
            ['class' => 'form-control', 'id' => 'total_salary', 'placeholder' => 'Enter total salary Here'],
        ) }}

        @error('total_salary')
            <p class="text-danger">{{ $errors->first('total_salary') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="income_tax">Income Tax </label>
        {{ Form::text(
            'income_tax',
            old('income_tax')
                ? old('income_tax')
                : (!empty($employee_salary->income_tax)
                    ? $employee_salary->income_tax
                    : null),
            ['class' => 'form-control', 'id' => 'income_tax', 'placeholder' => 'Enter income salary Here'],
        ) }}

        @error('income_tax')
            <p class="text-danger">{{ $errors->first('income_tax') }}</p>
        @enderror
    </div>

</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="casual_salary">Casual Salary </label>
        {{ Form::text(
            'casual_salary',
            old('casual_salary')
                ? old('casual_salary')
                : (!empty($employee_salary->casual_salary)
                    ? $employee_salary->casual_salary
                    : null),
            ['class' => 'form-control', 'id' => 'casual_salary', 'placeholder' => 'Enter casual salary Here'],
        ) }}

        @error('casual_salary')
            <p class="text-danger">{{ $errors->first('casual_salary') }}</p>
        @enderror
    </div>

</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="ot_calculation_basis">OT Calculation Based On </label>
        <select name="ot_calculation_basis" id="ot_calculation_basis" class="form-control">
            <option value="" disabled selected>Select OT Calculation Basis</option>
            <option value="basic"
                {{ old('ot_calculation_basis') ? (old('ot_calculation_basis') == 'basic' ? 'selected' : '') : (!empty($employee_salary->ot_calculation_basis) ? ($employee_salary->ot_calculation_basis == 'basic' ? 'selected' : '') : '') }}>
                Basic Salary</option>
            <option value="gross"
                {{ old('ot_calculation_basis') ? (old('ot_calculation_basis') == 'gross' ? 'selected' : '') : (!empty($employee_salary->ot_calculation_basis) ? ($employee_salary->ot_calculation_basis == 'gross' ? 'selected' : '') : '') }}>
                Gross Salary</option>

        </select>

        @error('ot_calculation_basis')
            <p class="text-danger">{{ $errors->first('ot_calculation_basis') }}</p>
        @enderror
    </div>
</div>
<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="ot_salary">OT Salary(per hour) % </label>

        {{ Form::text(
            'ot_salary',
            old('ot_salary') ? old('ot_salary') : (!empty($employee_salary->ot_salary) ? $employee_salary->ot_salary : null),
            ['class' => 'form-control', 'id' => 'ot_salary', 'placeholder' => 'Enter ot salary here'],
        ) }}

        @error('ot_salary')
            <p class="text-danger">{{ $errors->first('ot_salary') }}</p>
        @enderror
    </div>
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
    let salary_ratios = null;

    $(document).on('change', '#employee_id', function() {
        $.ajax({
            url: "{{ route('getEmployeeTypeSalary') }}",
            type: "POST",
            data: {
                employee_id: $(this).val(),
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                // console.log(data);
                salary_ratios = data['employee_salary'];
            },
        });
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
