@extends('layouts.backend-layout')
@section('title', 'Suppliers')

@section('breadcrumb-title')
    @if(!empty($supplier))
        Edit Supplier
    @else
        Add Supplier
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('suppliers') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "suppliers/$supplier->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($supplier->id) ? $supplier->id : null)}}">

    @else
        {!! Form::open(array('url' => "suppliers",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
{{--            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($supplier->id) ? $supplier->id : null)}}">--}}
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="type">Supplier Type<span class="text-danger">*</span></label>
                    {{Form::select('type', ['local'=>'Local', 'foreign'=>'Foreign'], old('type') ? old('type') : (!empty($supplier->type) ? $supplier->type : null),['class' => 'form-control','id' => 'type','placeholder'=>'Select Supplier Type', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="type">Supplier Category<span class="text-danger">*</span></label>
                    {{Form::select('parent_account_id', $categories, old('parent_account_id') ? old('parent_account_id') : (!empty($supplier) ? $supplier->account->parent_account_id : null),['class' => 'form-control','id' => 'parent_account_id','placeholder'=>'Select Category', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="type">Account Ref Code<span class="text-danger">*</span></label>
                    {{Form::text('account_code', old('account_code') ? old('account_code') : (!empty($supplier) ? $supplier->account->account_code : null),['class' => 'form-control','id' => 'account_code','placeholder'=>'Select Category', 'autocomplete'=>"off",'readonly'])}}
                </div>
            </div>

            <div class="col-12 {{empty($supplier->country) ? "d-none" : null}}" id="country_area">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="country">Country</label>
                    {{Form::text('country', old('country') ? old('country') : (!empty($supplier->country) ? $supplier->country : null),['class' => 'form-control','id' => 'country', 'autocomplete'=>"off", 'list'=>'countryList'])}}
                    <datalist id="countryList">
                        @foreach($countries as $country)
                            <option value="{{$country}}">{{$country}}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Supplier Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($supplier->name) ? $supplier->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Spoke's Name</label>
                    {{Form::text('contact_person_name', old('contact_person_name') ? old('contact_person_name') : (!empty($supplier->contact_person_name) ? $supplier->contact_person_name : null),['class' => 'form-control','id' => 'contact_person_name', 'autocomplete'=>"off",'required','autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="contact">Contact </label>
                    {{Form::text('contact', old('contact') ? old('contact') : (!empty($supplier->contact) ? $supplier->contact : null),['class' => 'form-control','id' => 'contact', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="email">Email </label>
                    {{Form::email('email', old('email') ? old('email') : (!empty($supplier->email) ? $supplier->email : null),['class' => 'form-control','id' => 'email', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="address">Address </label>
                    {{Form::textarea('address', old('address') ? old('address') : (!empty($supplier->address) ? $supplier->address : null),['class' => 'form-control','id' => 'address', 'autocomplete'=>"off", 'rows'=>'2','required'])}}
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
        $(function(){
            $("#type").on('change', function(){
                let type= $(this).val();
                if(type!="local"){
                    $("#country_area").removeClass("d-none");
                    $("#country").prop('required', true);
                }else{
                    $("#country_area").addClass("d-none");
                    $("#country").removeAttr('required').val(null);

                }
            });

            $("#parent_account_id").on('change', function(){
                getAccountCode();
            });
        });

        function getAccountCode(){
            let parent_account_id = $("#parent_account_id").val();
            const url = '{{url("accountsRefCode")}}/' + parent_account_id ;
            fetch(url).then((resp) => resp.json())
                .then(function(data) {
                    $("#account_code").val(data);
                }).catch(function () {
                // $("#account_code").val(null);
            });
        }
    </script>
@endsection
