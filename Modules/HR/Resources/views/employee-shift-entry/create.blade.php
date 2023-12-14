@extends('layouts.backend-layout') @section('title', 'Employee Shift Entry')
@section('breadcrumb-title') @if ($formType == 'edit')
    Edit
@else
    Create
@endif
Employee Shift Entry @endsection @section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-shifts.index') }}"><i
        class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
    'url' => 'hr/employee-shifts',
    'method' => 'POST',
    'class' => 'custom-form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
    'url' => "hr/employee-shifts/$employee_shifts->id",
    'method' => 'PUT',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row">

<div class="col-4">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="date">From Date <span class="text-danger">*</span></label>
        {{ Form::date('from_date', old('from_date') ? old('from_date') : null, [
            'class' => 'form-control datepicker',
            'id' => 'from_date',
            'placeholder' => 'Enter Date Here',
            'required',
        ]) }}

        @error('from_date')
            <p class="text-danger">{{ $errors->first('from_date') }}</p>
        @enderror
    </div>

    <div class="input-group input-group-sm input-group-primary mt-3">
        <label class="input-group-addon" for="date">To Date <span class="text-danger">*</span></label>
        {{ Form::date('to_date', old('to_date') ? old('to_date') : null, [
            'class' => 'form-control datepicker',
            'id' => 'to_date',
            'placeholder' => 'Enter Date Here',
            'required',
        ]) }}

        @error('to_date')
            <p class="text-danger">{{ $errors->first('to_date') }}</p>
        @enderror
    </div>
    <div class="row mt-4">
        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary" style="font-size: 16px; display:inline;">
                Main Shift <input type="checkbox" name="main_shift" id="main_shift" style="margin-left: 15px;">
                <p style="font-size: 12px; color:red;">Only for main shift change.</p>
            </div>
        </div>
        <div class="col-6">
            <div class="offset-md-4 col-md-10">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-round btn-block py-2">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-8">
    <table id="shift-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Shift Name</th>
                <th>Shift Code</th>
                <th>Shift IN</th>
                <th>Shift OUT</th>
                <th>Regular Hour</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shifts as $key => $data)
                <tr>
                    <td><input class="shift_check" type="checkbox" name="shift_id" id="shift_id_{{ $key }}"
                            value="{{ $data->id }}" onclick="handleFieldActive(this)"></td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->code }}</td>
                    <td>{{ $data->shift_in }}</td>
                    <td>{{ $data->shift_out }}</td>
                    <td>{{ $data->regular_hour }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<!-- end row -->
<div class="dt-responsive table-responsive">
<table id="employeeTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Employee Name</th>
            <th>Code</th>
            <th>Shift</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Section</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $key => $data)
            <tr>
                <td><input class="table_check" type="checkbox" name="employee_id[]" value="{{ $data->id }}"
                        id="employee_id" onclick="handleFieldActive(this)"></td>
                <td>{{ $data->emp_name }}</td>
                <td>{{ $data->emp_code }}</td>
                <td>{{ $data->shift?->name }}</td>
                <td>{{ $data->department->name }}</td>
                <td>{{ $data->designation->name }}</td>
                <td>{{ $data->section?->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>




<!-- end row -->
{!! Form::close() !!} @endsection @section('script')
<script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    // use for shift table only one item check
    const checkboxes = document.querySelectorAll('input[name="shift_id"]');
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
    // get checked key value
    function getCheckedKeys() {
        var checkedKeys = [];
        $('.table_check:checked').each(function() {
            var key = $(this).data('key');
            checkedKeys.push(key);
        });
        return checkedKeys;
    }

    $('#employeeTable').DataTable({
        // stateSave: true,
        bPaginate: false,
    });
    $('.dataTables_info').css('display', 'none');
</script>

<script>
    // Get the current date and format it as YYYY-MM-DD
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;
    // Set the min attribute of the input element to today's date
    const fromdateInput = document.getElementById('from_date');
    const todateInput = document.getElementById('to_date');
    fromdateInput.min = formattedToday;
    todateInput.min = formattedToday;
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fromdateInput = document.getElementById('from_date');
        const todateInput = document.getElementById('to_date');

        let today = new Date();
        let oneMonthLater = new Date(today);
        oneMonthLater.setMonth(oneMonthLater.getMonth() + 1);

        let maxDate = oneMonthLater.toISOString().split("T")[0];
        fromdateInput.setAttribute("max", maxDate);
        todateInput.setAttribute("max", maxDate);
    });
</script>

@endsection
