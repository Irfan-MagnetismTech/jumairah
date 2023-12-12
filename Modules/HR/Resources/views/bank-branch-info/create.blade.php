@extends('layouts.backend-layout')
@section('title', 'Bank Branch')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Branch
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('bank-branch-info.index') }}"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/bank-branch-info', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/bank-branch-info/$bankBranchInfo->id",
'method' => 'PUT',
'class' => 'custom-form',
'files' => true,
'enctype'=>'multipart/form-data',
]) !!}
@endif

<div class="row">
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="company_name">Bank<span class="text-danger">*</span></label>
            {{Form::select('bank_id',$banks, old('bank_id') ? old('bank_id') : (!empty($bankBranchInfo)
            ? $bankBranchInfo->bank_id : null),['class' => 'form-control select2','id' => 'bank_id', 'placeholder' =>
            'Select Bank', 'required'] )}}
            @error('bank_id') <p class="text-danger">{{ $errors->first('bank_id') }}</p> @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="name">Branch Name <span class="text-danger">*</span></label>
            {{ Form::text(
            'branch',
            old('branch')
            ? old('branch')
            : (!empty($bankBranchInfo->branch)
            ? $bankBranchInfo->branch
            : null),
            ['class' => 'form-control', 'id' => 'branch', 'placeholder' => 'Enter bank branch Here', 'required'],
            ) }}
            @error('branch')
            <p class="text-danger">{{ $errors->first('branch') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="name">Address</label>
            {{ Form::text(
            'address',
            old('address')
            ? old('address')
            : (!empty($bankBranchInfo->address)
            ? $bankBranchInfo->address
            : null),
            ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Enter address Name Here'],
            ) }}
            @error('address')
            <p class="text-danger">{{ $errors->first('address') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="account_name">Account Name<span class="text-danger">*</span></label>
            {{ Form::text(
            'account_name',
            old('account_name')
            ? old('account_name')
            : (!empty($bankBranchInfo->account_name)
            ? $bankBranchInfo->account_name
            : null),
            ['class' => 'form-control', 'id' => 'account_name', 'placeholder' => 'Enter Account Name Here', 'required'],
            ) }}
            @error('account_name')
            <p class="text-danger">{{ $errors->first('account_name') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="account_number">Account Number<span class="text-danger">*</span></label>
            {{ Form::text(
                'account_number',
                old('account_number')
                ? old('account_number')
                : (!empty($bankBranchInfo->account_number)
                ? $bankBranchInfo->account_number
                : null),
                ['class' => 'form-control', 'id' => 'account_number', 'placeholder' => 'Enter Account Number Here', 'required'],
                ) }}
            @error('account_number')
            <p class="text-danger">{{ $errors->first('account_number') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="account_type">Account Type<span class="text-danger">*</span></label>
            {{Form::select('account_type',['Current'=>'Current', 'Loan' => 'Loan', 'Joint Current' => 'Joint Current'], old('account_type') ? old('account_type') : (!empty($bankBranchInfo)
            ? $bankBranchInfo->account_type : null),['class' => 'form-control','id' => 'account_type', 'placeholder' =>
            'Select Account Type', 'required'] )}}
            @error('account_type')
            <p class="text-danger">{{ $errors->first('account_type') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="name">Status<span class="text-danger">*</span></label>
            {{ Form::select(
            'status',
            [
            'Active' => 'Active',
            'Inactive' => 'Inactive',
            ],
            old('status')
            ? old('status')
            : (!empty($bankBranchInfo->status)
            ? $bankBranchInfo->status
            : null),
            ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status', 'required'],
            ) }}
            @error('status')
            <p class="text-danger">{{ $errors->first('status') }}</p>
            @enderror
        </div>
    </div>











</div><!-- end row -->

<div class="row">
    <div class="offset-md-4 col-md-4 mt-2 ">
        <div class="input-group input-group-sm ">
            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
        </div>
    </div>
</div> <!-- end row -->
{!! Form::close() !!}
@endsection
@section('script')
<script></script>

@endsection
