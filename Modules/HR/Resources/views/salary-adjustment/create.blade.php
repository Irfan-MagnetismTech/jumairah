@extends('layouts.backend-layout') @section('title', 'Salary Adjustment')
@section('breadcrumb-title') @if ($formType == 'edit')
Edit
@else
Create
@endif
Salary Adjustment @endsection 
@section('style')
<style>
    .input-group-addon {
        min-width: 115px !important;
    }
</style>
@endsection @section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('salary-adjustments.index') }}"><i class="fas fa-database"></i></a>
@endsection @section('sub-title')
<span class="text-danger">*</span> Marked are required. @endsection
@section('content-grid', 'col-md-12 col-lg-12 px-5')
@section('content') @if ($formType == 'create')
{!! Form::open([
'url' => 'hr/salary-adjustments',
'method' => 'POST',
'class' => 'custom-form',
'files' => true,
'enctype' => 'multipart/form-data',
]) !!}
@else
{!! Form::open([
'url' => "hr/salary-adjustments/$salary_adjustment->id",
'method' => 'PUT',
'files' => true,
'enctype' => 'multipart/form-data',
]) !!}
@endif

<div class="row">
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="month">Adjustment Month <span class="text-danger">*</span></label>
            {{ Form::month(
                'month_year',
                old('month_year')
                    ? old('month_year')
                    : (!empty($salary_adjustment->month_year)
                        ? $salary_adjustment->month_year
                        : null),
                [
                    'class' => 'form-control',
                    'id' => 'month_year',
                    'placeholder' => 'Enter Contact Person Name Here',
                    'required',
                ],
            ) }}
        </div>
        @error('month_year')
        <p class="text-danger">{{ $errors->first('month_year') }}</p>
        @enderror
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="employee_id">Employee<span class="text-danger">*</span></label>
            {{Form::select('employee_id',$employees, old('employee_id') ? old('employee_id') : (!empty($salary_adjustment)
            ? $salary_adjustment->employee_id : null),['class' => 'form-control select2','id' => 'employee_id', 'placeholder' =>
            'Select Employee', 'required'] )}}
        </div>
        @error('employee_id') <p class="text-danger">{{ $errors->first('employee_id') }}</p> @enderror


        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="date">Amount <span class="text-danger">*</span></label>
            {{ Form::text(
            'amount',
            old('amount')
            ? old('amount')
            : (!empty($salary_adjustment)
            ? $salary_adjustment->amount : null),
            ['class' => 'form-control disable', 'id' => 'amount', 'placeholder' => 'Amount', 'required'],
            ) }}

        </div>
        @error('amount')
            <p class="text-danger">{{ $errors->first('amount') }}</p>
        @enderror
            
        <div class="input-group input-group-sm input-group-primary mb-2">
            <label class="input-group-addon" for="date">Reason <span class="text-danger">*</span></label>
            {{ Form::textarea(
            'remarks',
            old('remarks')
            ? old('remarks')            
            : (!empty($salary_adjustment)
            ? $salary_adjustment->remarks : null),
            ['class' => 'form-control disable', 'id' => 'remarks', 'placeholder' => '', 'required','rows' => 3],
            ) }}

        </div>
        @error('remarks')
        <p class="text-danger">{{ $errors->first('remarks') }}</p>
        @enderror
        <div class="input-group input-group-sm input-group-primary mt-4" style="font-size:14px;">
            <input class="mx-2" type="radio" name="type" {{(!empty($salary_adjustment)
            ? (($salary_adjustment->type == 'addition')
            ? 'checked' : '') : null)}} id="type" value="addition">Addition
            <input class="mx-2"  type="radio" name="type" id="type" value="deduction" {{(!empty($salary_adjustment)
            ? (($salary_adjustment->type == 'deduction')
            ? 'checked' : '' ) : null)}}>Deduction
        </div>
        @error('type') <p class="text-danger">{{ $errors->first('type') }}</p> @enderror
        <div>
            <p class="text-danger">Note: Must be check one option!</p>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 mx-auto">
                <div class="">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-round btn-block py-2 disable_btn">
                            Save
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


</script>

@endsection
