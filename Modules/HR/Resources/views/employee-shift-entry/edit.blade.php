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
    'url' => "hr/employee-shifts/$employee_shift->id",
    'method' => 'PUT',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row">

<div class="col-4">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="date" name="date"
            value="{{ date('d/m/Y', strtotime($employee_shift->date)) }}" readonly>

        @error('date')
            <p class="text-danger">{{ $errors->first('date') }}</p>
        @enderror
    </div>

    <div class="row mt-2">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">
                    Save
                </button>
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
                    <td><input type="checkbox" name="shift_id" id="shift_id_{{ $key }}"
                            value="{{ $data->id }}" {{ $data->id == $employee_shift->shift_id ? 'checked' : '' }}>
                    </td>
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
<div class="row mt-4">
<table id="shift-table" class="table table-striped table-bordered">
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
            @if ($data->id != $employee_shift->employee_id)
                @continue
            @endif
            <tr>
                <td>
                    <input type="hidden" name="emplyee_id" value="{{ $data->id }}">
                    <input type="checkbox" value="{{ $data->id }}" id="emplyee_id"
                        {{ $data->id == $employee_shift->employee_id ? 'checked' : '' }}
                        {{ $data->id == $employee_shift->employee_id ? 'disabled' : '' }}>
                </td>
                <td>{{ $data->emp_name }}</td>
                <td>{{ $data->emp_code }}</td>
                <td>{{ $data->shift?->name }}</td>
                <td>{{ $data->department?->name }}</td>
                <td>{{ $data->designation?->name }}</td>
                <td>{{ $data->section?->name }}</td>
            </tr>
            @if ($data->id != $employee_shift->employee_id)
            @break
        @endif
    @endforeach
</tbody>
</table>
</div>




<!-- end row -->
{!! Form::close() !!} @endsection @section('script')
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
</script>

@endsection
