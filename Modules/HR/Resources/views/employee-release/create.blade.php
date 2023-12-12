@extends('layouts.backend-layout') @section('title', 'Employee Release')
@section('breadcrumb-title') @if ($formType == 'edit')
Edit
@else
Create
@endif
Employee Release @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-releases.index') }}"><i class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
'url' => 'hr/employee-releases',
'method' => 'POST',
'class' => 'custom-form',
'files' => true,
'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
'url' => "hr/employee-releases/$employee_release->id",
'method' => 'PUT',
'files' => true,
'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row">
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="employee_id">Employee<span class="text-danger">*</span></label>
            {{Form::select('employee_id',$employees, old('employee_id') ? old('employee_id') : (!empty($employee_release)
            ? $employee_release->employee_id : null),['class' => 'form-control select2','id' => 'employee_id', 'placeholder' =>
            'Select Bank', 'required',  ($formType != 'create') ? 'disabled' : '' ] )}}
            @error('employee_id') <p class="text-danger">{{ $errors->first('employee_id') }}</p> @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="released_type_id">Release Type</label>
            {{ Form::select(
             'released_type_id',
             $released_types,
            old('released_type_id')? old('released_type_id')
            : (!empty($employee_release->released_type_id)
            ? $employee_release->released_type_id : null),
            ['class' => 'form-control select2 required-field', 'id' => 'released_type_id', 'placeholder' => 'Select Release Type'],
            ) }}
            @error('released_type_id')
            <p class="text-danger">{{ $errors->first('released_type_id') }}</p>
            @enderror
        </div>
    </div>


    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="release_date">Release Date <span class="text-danger">*</span></label>
            {{ Form::date(
            'release_date',
            old('release_date')
            ? old('release_date')
            : (!empty($employee_release->release_date)
            ? $employee_release->release_date
            : null),
            ['class' => 'form-control', 'id' => 'release_date', 'placeholder' => 'Enter Release Date Here', 'required'],
            ) }}

            @error('release_date')
            <p class="text-danger">{{ $errors->first('release_date') }}</p>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="last_present_day">Last Present Day <span class="text-danger">*</span></label>
            {{ Form::date(
            'last_present_day',
            old('last_present_day')
            ? old('last_present_day')
            : (!empty($employee_release->last_present_day)
            ? $employee_release->last_present_day
            : null),
            ['class' => 'form-control', 'id' => 'last_present_day', 'placeholder' => 'Enter Last Present Date Here', 'required'],
            ) }}

            @error('last_present_day')
            <p class="text-danger">{{ $errors->first('last_present_day') }}</p>
            @enderror
        </div>

    </div>

    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="remarks">Remarks <span class="text-danger">*</span></label>
            <textarea class="form-control" id="remarks" name="remarks">{{ old('remarks') ? old('remarks') : (!empty($employee_release->remarks) ? $employee_release->remarks: null) }}</textarea>
            @error('remarks')
            <p class="text-danger">{{ $errors->first('remarks') }}</p>
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

                salary_ratios =  data['employee_salary'];

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

    $(document).on("change", "#other_allowance,#mobile_allowance,#grade_bonus, #skill_bonus, #management_bonus ", function() {
        CalculateTotalSalary();
    })

    function CalculateTotalSalary() {

        let gross_salary = $('#gross_salary').val();
        let other_allowance = $('#other_allowance').val();
        let mobile_allowance = $('#mobile_allowance').val();
        let grade_bonus = $('#grade_bonus').val();
        let skill_bonus = $('#skill_bonus').val();
        let management_bonus = $('#management_bonus').val();
        let total_salary = Number(gross_salary) + Number(other_allowance) + Number(mobile_allowance) + Number(grade_bonus) +
            Number(skill_bonus) + Number(management_bonus);
        $('#total_salary').val(total_salary);

    }
</script>

@endsection
