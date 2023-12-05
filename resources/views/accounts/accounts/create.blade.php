@extends('layouts.backend-layout')
@section('title', 'Accounts')

@section('breadcrumb-title')
    @if(!empty($account))
        Edit Account
    @else
        Add New Account
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('accounts.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if(!empty($account))
        {!! Form::open(array('url' => route('accounts.update', $account->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($account->id) ? $account->id : null)}}">
    @else
        {!! Form::open(array('url' => route('accounts.store'),'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="balance_and_income_line_id">Balance or Income<span class="text-danger">*</span></label>
                    {{Form::select('balance_and_income_line_id', $balanceIncomeLines, old('balance_and_income_line_id') ? old('balance_and_income_line_id') : (!empty($account) ? $account->balance_and_income_line_id : null),['class' => 'form-control select2','id' => 'balance_and_income_line_id', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="account_code">Account Code</label>
                    {{Form::text('account_code', old('account_code') ? old('account_code') : (!empty($account->account_code) ? $account->account_code : null),['class' => 'form-control','id' => 'account_code', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="account_name">Account Name<span class="text-danger">*</span></label>
                    {{Form::text('account_name', old('account_name') ? old('account_name') : (!empty($account->account_name) ? $account->account_name : null),['class' => 'form-control','id' => 'account_name', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="parent_account_id">Parent Account<span class="text-danger">*</span></label>
                    {{Form::select('parent_account_id', $parentAccounts, old('parent_account_id') ? old('parent_account_id') : (!empty($account) ? $account->parent_account_id : null),['class' => 'form-control select2','id' => 'parent_account_id', 'autocomplete'=>"off", 'placeholder'=>"Select Parent"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="account_type">Account Type <span class="text-danger">*</span></label>
                    {{Form::select('account_type', $accountTypes, old('account_type') ? old('account_type') : (!empty($account) ? $account->account_type : null),['class' => 'form-control','id' => 'account_type', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="account_type">Group <span class="text-danger">*</span></label>
                    {{Form::select('group', $groups, old('group') ? old('group') : (!empty($account) ? $account->group : null),['class' => 'form-control','id' => 'group', 'placeholder'=>"Select Group", 'autocomplete'=>"off"])}}
                </div>
            </div>

            <!-- <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="is_archived">Is Archived<span class="text-danger">*</span></label>
                    <div class="form-radio px-1 d-flex" style="width: 100%">
                        <div class="radio radiofill radio-warning radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="is_archived" value="1" {{old('is_archived') && old('is_archived') == 1 ? "Checked" : (!empty($account) && $account->is_archived == 1 ? "Checked" : null)}} required>
                                <i class="helper"></i> Yes
                            </label>
                        </div>
                        <div class="radio radiofill radio-danger radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="is_archived" value="0" {{old('is_archived') && old('is_archived') == 0 ? "Checked" : (!empty($account) && $account->is_archived == 0 ? "Checked" : null)}} required>
                                <i class="helper"></i> No
                            </label>
                        </div>
                    </div>
                </div>
            </div> -->

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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $("#balance_and_income_line_id").on('change', function(){
                getAccountCode();
            });
            function getAccountCode(){
                let account_id = $("#balance_and_income_line_id").val();
                const url = '{{url("accounts-ref-generator")}}/' + account_id ;
                fetch(url).then((resp) => resp.json())
                .then(function(data) {
                    $("#account_code").val(data);
                }).catch(function () {
                    // $("#account_code").val(null);
                });
            }

            @if(old())
                loadParentAccount();
            @endif

            $("#balance_and_income_line_id").on('change', function(){
                loadParentAccount();
            });

        });//

        function loadParentAccount(){
            let dropdown = $('#parent_account_id');
            let oldSelectedItem = "{{old('parent_account_id') ? old('parent_account_id') : null}}";
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Parent </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("parent-account")}}/' + $("#balance_and_income_line_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (items) {
                $.each(items, function (key, entry) {
                    let select=(oldSelectedItem == entry.id) ? "selected" : null;
                    console.log(entry.account_name);
                    dropdown.append($(`<option ${select}></option>`).attr('value', entry.id).text(entry.account_name));
                })
            });
        }// document.ready()

        $('.select2').select2();

    </script>
@endsection
