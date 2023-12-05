@extends('layouts.backend-layout')
@section('title', 'Cash Accounts')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Cash Account
    @else
        Add New Cash Account
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/cashAccounts') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => route('cashAccounts.update', $cashAccount->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($cashAccount->id) ? $cashAccount->id : null)}}">
    @else
        {!! Form::open(array('url' => route('cashAccounts.store'),'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Cash Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($cashAccount->name) ? $cashAccount->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"])}}
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
            // $('#opening_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready()

    </script>
@endsection
