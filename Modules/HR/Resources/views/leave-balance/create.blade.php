@extends('layouts.backend-layout') @section('title', 'Leave Balance')
@section('breadcrumb-title') @if ($formType == 'edit')
    Edit
@else
    Create
@endif
Leave Balance @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 140px !important;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('leave-balances.index') }}"><i
        class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
    'url' => 'hr/leave-balances',
    'method' => 'POST',
    'class' => 'custom-form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
    'url' => "hr/leave-balances/$leave_balance->id",
    'method' => 'PUT',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@endif
<div class="row p-4">
<div class="col-md-12 py-2">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="year">Leave Blance Year <span class="text-danger">*</span></label>
        {{ Form::selectYear(
            'year',
            date('Y'),
            date('Y') + 0,
            old('year') ? old('year') : (!empty($leave_balance->year) ? $leave_balance->year : null),
            ['class' => 'form-control', 'id' => 'year', 'placeholder' => 'Select Leave Year', 'required'],
        ) }}

        @error('year')
            <p class="text-danger">{{ $errors->first('year') }}</p>
        @enderror
    </div>
</div>
<div class="col-md-12 py-2">
    <strong style="font-size: 16px;">Criteria</strong>
    <div class="input-group input-group-sm input-group-primary"
        style="display:flex; justify-content: space-around; font-size: 14px;">
        <div>
            <input type="checkbox" name="all_emp" id="all_emp" value="all"
                {{ $formType != 'create' ? 'disabled' : '' }}> All Employee
        </div>
        <div>
            <input type="checkbox" name="emp_wise" id="emp_wise" value="employee_wise"
                {{ $formType != 'create' ? 'checked disabled' : '' }}> Employee Wise
        </div>
        <div>
            <input type="checkbox" name="department" id="department" value="department"
                {{ $formType != 'create' ? 'disabled' : '' }}> Department Wise
        </div>
        <div>
            <input type="checkbox" name="section" id="section" value="section"
                {{ $formType != 'create' ? 'disabled' : '' }}> Section Wise
        </div>
    </div>
</div>

<div class="col-md-12 py-2">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="employee_id">Employee<span class="text-danger">*</span></label>
        {{ Form::select(
            'employee_id',
            $employees,
            old('employee_id') ? old('employee_id') : (!empty($leave_balance) ? $leave_balance->emp_id : null),
            [
                'class' => 'form-control select2 dept_active section_active',
                'id' => 'employee_id',
                'placeholder' => 'Select Bank',
                'required',
                'disabled',
            ],
        ) }}
        @error('employee_id')
            <p class="text-danger">{{ $errors->first('employee_id') }}</p>
        @enderror
    </div>
</div>

<div class="col-md-12 py-2">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="department_id">Department<span class="text-danger">*</span></label>
        {{ Form::select('department_id', $departments, old('department_id') ? old('department_id') : null, [
            'class' => 'form-control select2 section_active employee_active',
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

<div class="col-md-12 py-2">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="section_id">Section<span class="text-danger">*</span></label>
        {{ Form::select('section_id', $sections, old('section_id') ? old('section_id') : null, [
            'class' => 'form-control select2 dept_active employee_active',
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
        <label class="input-group-addon" for="cl">Casual Leave<span class="text-danger">*</span></label>
        <input type="text" name="cl" id="cl" class="form-control"
            value="{{ !empty($leave_balance->leave_balance_details->cl) ? $leave_balance->leave_balance_details->cl : '' }}">
        @error('cl')
            <p class="text-danger">{{ $errors->first('cl') }}</p>
        @enderror
    </div>
</div>
<div class="col-md-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="sl">Sick Leave<span class="text-danger">*</span></label>
        <input type="text" name="sl" id="sl" class="form-control"
            value="{{ !empty($leave_balance->leave_balance_details->sl) ? $leave_balance->leave_balance_details->sl : '' }}">
        @error('sl')
            <p class="text-danger">{{ $errors->first('sl') }}</p>
        @enderror
    </div>
</div>
<div class="col-md-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="el">Earned Leave<span class="text-danger">*</span></label>
        <input type="text" name="el" id="el" class="form-control"
            value="{{ !empty($leave_balance->leave_balance_details->el) ? $leave_balance->leave_balance_details->el : '' }}">
        @error('el')
            <p class="text-danger">{{ $errors->first('el') }}</p>
        @enderror
    </div>
</div>
<div class="col-md-6 d-none">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="ml">Maternity Leave<span class="text-danger">*</span></label>
        <input type="text" name="ml" id="ml" class="form-control"
            value="{{ !empty($leave_balance->leave_balance_details->ml) ? $leave_balance->leave_balance_details->ml : '' }}">
        @error('ml')
            <p class="text-danger">{{ $errors->first('ml') }}</p>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="other">Others Leave(Optional)</label>
        <input type="text" name="other" id="other" class="form-control"
            value="{{ !empty($leave_balance->leave_balance_details->other) ? $leave_balance->leave_balance_details->other : '' }}">
        @error('other')
            <p class="text-danger">{{ $errors->first('other') }}</p>
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

                salary_ratios = data['employee_salary'];

            },
        });
    })


    $(document).on('change', 'input[type="checkbox"]', function() {
        let cri_type = $(this).val();
        $('#employee_id option[value="All"]').remove();
        if (cri_type == "employee_wise") {
            $('#employee_id').prop('disabled', false);
            $('.employee_active').prop('disabled', true);
        } else if (cri_type == "department") {
            $('#department_id').prop('disabled', false);
            $('.dept_active').prop('disabled', true);
        } else if (cri_type == "section") {
            $('#section_id').prop('disabled', false);
            $('.section_active').prop('disabled', true);
        } else {
            var newOption = $("<option selected>").val("All").text("All");
            $('#employee_id').append(newOption);
            $('.dept_active').prop('disabled', true);
            $('.employee_active').prop('disabled', true);
            $('.section_active').prop('disabled', true);
        }

    })

    $('#employee_id').change(() => {
        let employee_id = $('#employee_id').val();
        $.ajax({
            url: `/hr/employee-masters/${employee_id}`,
            type: 'GET',
            success: function(response) {

                if (response.employee.gender_id == 1) {
                    $('#ml').val('0');
                    $('#ml').closest('.col-md-6').addClass('d-none')
                }else{
                    $('#ml').closest('.col-md-6').removeClass('d-none')
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus + ': ' + errorThrown);
            }
        });
    });
</script>
<script>
    // use for shift table only one item check
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                uncheckOtherCheckboxes(checkbox);
            }
        });
    });

    function uncheckOtherCheckboxes(checkedCheckbox) {
        checkboxes.forEach(checkbox => {
            if (checkbox !== checkedCheckbox) {
                checkbox.checked = false;
            }
        });
    }
</script>
@endsection
