@extends('layouts.backend-layout') @section('title', 'Employee Transfer')
@section('breadcrumb-title') @if ($formType == 'edit')
    Edit
@else
    Create
@endif
Employee Transfer @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>

@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-transfers.index') }}"><i
        class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
    'url' => 'hr/employee-transfers',
    'method' => 'POST',
    'class' => 'custom-form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
    'url' => "hr/employee-transfers/$employee_transfers->id",
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
            old('employee_id') ? old('employee_id') : (!empty($employee_transfers) ? $employee_transfers->employee_id : null),
            ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => 'Select Employee', 'required'],
        ) }}
        @error('employee_id')
            <p class="text-danger">{{ $errors->first('employee_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="transfer_type">Transfer Type</label>
        {{ Form::select(
            'transfer_type',
            [
                'Department' => 'Department',
                'Designation' => 'Designation',
                'Section' => 'Section',
                'Employee Type' => 'Employee Type',
            ],
            old('transfer_type')
                ? old('transfer_type')
                : (!empty($employee_transfers->transfer_type)
                    ? $employee_transfers->transfer_type
                    : null),
            [
                'class' => 'form-control select2 required-field',
                'id' => 'transfer_type',
                'placeholder' => 'Select Increment Type',
            ],
        ) }}
        @error('transfer_type')
            <p class="text-danger">{{ $errors->first('transfer_type') }}</p>
        @enderror
    </div>
</div>


<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
        {{ Form::date('date', old('from_date') ?? now()->format('Y-m-d'), [
            'class' => 'form-control',
            'id' => 'date',
            'placeholder' => 'Enter Date Here',
            'required',
        ]) }}

        @error('date')
            <p class="text-danger">{{ $errors->first('date') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="join_date">Join Date </label>
        <input type="hidden" name="join_date" id="emp_join_date">
        <input type="text" class="form-control"
            value="{{ !empty($employee_transfers->join_date) ? date('m/d/Y', strtotime($employee_transfers->join_date)) : null }}"
            id="join_date" disabled>
        @error('join_date')
            <p class="text-danger">{{ $errors->first('join_date') }}</p>
        @enderror
    </div>
</div>


<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="department">Department </label>
        <input type="text" class="form-control"
            value="{{ old('department')
                ? old('department')
                : (!empty($employee_transfers->old_department->name)
                    ? $employee_transfers->old_department->name
                    : null) }} "
            id="department" disabled>
        @error('department')
            <p class="text-danger">{{ $errors->first('department') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="designation">Designation </label>
        <input type="text" class="form-control"
            value="{{ old('designation')
                ? old('designation')
                : (!empty($employee_transfers->old_designation->name)
                    ? $employee_transfers->old_designation->name
                    : null) }} "
            id="designation" disabled>
        @error('designation')
            <p class="text-danger">{{ $errors->first('designation') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="section">Section </label>
        <input type="text" class="form-control"
            value="{{ old('section')
                ? old('section')
                : (!empty($employee_transfers->old_section->name)
                    ? $employee_transfers->old_section->name
                    : null) }}"
            id="section" disabled>
        @error('section')
            <p class="text-danger">{{ $errors->first('section') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="emp_type">Employee Type </label>
        <input type="text" class="form-control"
            value="{{ old('emp_type')
                ? old('emp_type')
                : (!empty($employee_transfers->old_emp_type->name)
                    ? $employee_transfers->old_emp_type->name
                    : null) }}"
            id="emp_type" disabled>
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
        <input type="hidden" class="form-control"
            value="{{ !empty($employee_transfers->old_designation_id) ? $employee_transfers->old_designation_id : null }}"
            id="old_designation_id" name="old_designation_id">
        <input type="text" class="form-control"
            value="{{ !empty($employee_transfers->old_designation->name) ? $employee_transfers->old_designation->name : null }} "
            id="old_designation" disabled>

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
                : (!empty($employee_transfers->new_designation_id)
                    ? $employee_transfers->new_designation_id
                    : null),
            [
                'class' => 'form-control select2 designation-class only-department only-section only-emp-type',
                'id' => 'new_designation_id',
                'placeholder' => 'Select Employee',
                'required',
                !empty($employee_transfers->new_designation_id) ? '' : 'disabled',
            ],
        ) }}
        @error('new_designation_id')
            <p class="text-danger">{{ $errors->first('new_designation_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-12 my-3 border-primary ">
    <h6>Department</h6>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="old_department_id">Old Department</label>
        <input type="hidden" class="form-control"
            value="{{ !empty($employee_transfers->old_department_id) ? $employee_transfers->old_department_id : null }}"
            id="old_department_id" name="old_department_id">
        <input type="text" class="form-control"
            value="{{ !empty($employee_transfers->old_department->name) ? $employee_transfers->old_department->name : null }} "
            id="old_department" disabled>

        @error('old_department_id')
            <p class="text-danger">{{ $errors->first('old_department_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="new_department_id">New Department</label>

        {{ Form::select(
            'new_department_id',
            $departments,
            old('new_department_id')
                ? old('new_department_id')
                : (!empty($employee_transfers->new_department_id)
                    ? $employee_transfers->new_department_id
                    : null),
            [
                'class' => 'form-control select2 department-class only-designation only-section only-emp-type',
                'id' => 'new_department_id',
                'placeholder' => 'Select Employee',
                'required',
                !empty($employee_transfers->new_department_id) ? '' : 'disabled',
            ],
        ) }}
        @error('new_department_id')
            <p class="text-danger">{{ $errors->first('new_department_id') }}</p>
        @enderror
    </div>
</div>
<div class="col-12 my-3 border-primary ">
    <h6>Section</h6>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="old_section_id">Old section</label>
        <input type="hidden" class="form-control" id="old_section_id"
            value="{{ !empty($employee_transfers->old_section_id) ? $employee_transfers->old_section_id : null }}"
            name="old_section_id">
        <input type="text" class="form-control"
            value="{{ !empty($employee_transfers->old_section->name) ? $employee_transfers->old_section->name : null }}"
            id="old_section" disabled>

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
                : (!empty($employee_transfers->new_section_id)
                    ? $employee_transfers->new_section_id
                    : null),
            [
                'class' => 'form-control select2 section-class only-designation only-department only-emp-type',
                'id' => 'new_section_id',
                'placeholder' => 'Select Employee',
                'required',
                !empty($employee_transfers->new_section_id) ? '' : 'disabled',
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
        <label class="input-group-addon" for="old_emp_type_id">Old Employee Type</label>
        <input type="hidden" class="form-control"
            value="{{ !empty($employee_transfers->old_emp_type_id) ? $employee_transfers->old_emp_type_id : null }}"
            id="old_emp_type_id" name="old_emp_type_id">
        <input type="text" class="form-control"
            value="{{ !empty($employee_transfers->old_emp_type->name) ? $employee_transfers->old_emp_type->name : null }}"
            id="old_emp_type" disabled>

        @error('old_emp_type_id')
            <p class="text-danger">{{ $errors->first('old_emp_type_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="new_emp_type_id">New Employee type</label>

        {{ Form::select(
            'new_emp_type_id',
            $employee_types,
            old('new_emp_type_id')
                ? old('new_emp_type_id')
                : (!empty($employee_transfers->new_emp_type_id)
                    ? $employee_transfers->new_emp_type_id
                    : null),
            [
                'class' => 'form-control select2 emp-type-class only-designation only-department only-section',
                'id' => 'new_emp_type_id',
                'placeholder' => 'Select Employee',
                'required',
                empty($employee_transfers->new_emp_type_id) ? '' : 'disabled',
            ],
        ) }}
        @error('new_emp_type_id')
            <p class="text-danger">{{ $errors->first('new_emp_type_id') }}</p>
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
                // console.log(data);

                // $('#employee_name').val(data.employee.emp_name);
                $('#emp_join_date').val(data.employee.join_date);
                $('#join_date').val(data.employee.join_date.slice(0, 10).split('-').reverse().join(
                    '/'));
                $('#department').val(data.employee.department?.name);
                $('#designation').val(data.employee.designation?.name);
                $('#emp_type').val(data.employee.employee_type?.name);
                $('#section').val(data.employee.section?.name);

                $('#old_designation_id').val(data.employee.designation?.id);
                $('#old_designation').val(data.employee.designation?.name);
                $('#old_department_id').val(data.employee.department?.id);
                $('#old_department').val(data.employee.department?.name);
                $('#old_emp_type_id').val(data.employee.employee_type?.id);
                $('#old_emp_type').val(data.employee.employee_type?.name);
                $('#old_section_id').val(data.employee.section?.id);
                $('#old_section').val(data.employee.section?.name);

                employee_info = data['employee'];
            },
        });
    })


    $(document).on('change', 'select[name="transfer_type"]', function() {
        let inc_type = $(this).val();
        if (inc_type == "Department") {
            $('.department-class').prop('disabled', false);
            // $('.only-department').prop('disabled', false);
            $('.only-department').prop('disabled', true);
        } else if (inc_type == "Designation") {
            $('.designation-class').prop('disabled', false);
            // $('.new_designation_id').prop('disabled', false);
            $('.only-designation').prop('disabled', true);
        } else if (inc_type == "Section") {
            $('.section-class').prop('disabled', false);
            $('.only-section').prop('disabled', true);
        } else if (inc_type == "Employee Type") {
            $('.emp-type-class').prop('disabled', false);
            $('.only-emp-type').prop('disabled', true);
        } else {
            $('.only-transfer').prop('disabled', true);
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
