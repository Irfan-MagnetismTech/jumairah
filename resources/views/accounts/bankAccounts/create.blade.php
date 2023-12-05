@extends('layouts.backend-layout')
@section('title', 'Bank Accounts')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Bank Account
    @else
        Add New Bank Account
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/bankAccounts') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => route('bankAccounts.update', $bankAccount->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($bankAccount->id) ? $bankAccount->id : null)}}">
    @else
        {!! Form::open(array('url' => route('bankAccounts.store'),'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Bank Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($bankAccount->name) ? $bankAccount->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="branch_name">Branch Name<span class="text-danger">*</span></label>
                    {{Form::text('branch_name', old('branch_name') ? old('branch_name') : (!empty($bankAccount->branch_name) ? $bankAccount->branch_name : null),['class' => 'form-control','id' => 'branch_name', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="account_type">Account Type<span class="text-danger"></span></label>
                    {{Form::text('account_type', old('account_type') ? old('account_type') : (!empty($bankAccount->account_type) ? $bankAccount->account_type : null),['class' => 'form-control','id' => 'account_type', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Account Name<span class="text-danger">*</span></label>
                    {{Form::text('account_name', old('account_name') ? old('account_name') : (!empty($bankAccount->account_name) ? $bankAccount->account_name : null),['class' => 'form-control','id' => 'account_name', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="account_number">Account Number <span class="text-danger">*</span></label>
                    {{Form::text('account_number', old('account_number') ? old('account_number') : (!empty($bankAccount->account_number) ? $bankAccount->account_number : null),['class' => 'form-control','id' => 'account_number', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="opening_date">Opening Date <span class="text-danger"></span></label>
                    {{Form::text('opening_date', old('opening_date') ? old('opening_date') : (!empty($bankAccount->opening_date) ? $bankAccount->opening_date : null),['class' => 'form-control','id' => 'opening_date', 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $('#opening_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready()

    </script>
@endsection
