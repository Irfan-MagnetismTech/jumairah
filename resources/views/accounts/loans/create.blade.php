@extends('layouts.backend-layout')
@section('title', 'Loan')

@section('breadcrumb-title')
    @if(!empty($loan))
        Edit Loan
    @else
        Add New Loan
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('loans.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')

    @if(!empty($loan))
        {!! Form::open(array('url' => route('loans.update', $loan->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => route('loans.store'), 'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($loan->id) ? $loan->id : null)}}">
            <div class="col-xl-4 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type">Source Type <span class="text-danger">*</span></label>
                    <select name="loanable_type" id="loanable_type" class="form-control">
                        <option value="">Select Source</option>
                            <option value="Bank" @if(!empty($loan->loanable_type) && $loan->loanable_type == 'App\Accounts\BankAccount') selected  @endif >Bank</option>
                            <option value="Inter Company" @if(!empty($loan->loanable_type) && $loan->loanable_type != 'App\Accounts\BankAccount') selected  @endif >Inter Company</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-8 col-md-8">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_id">Source Name<span class="text-danger">*</span></label>
                    {{Form::select('loanable_id', $sourcenames, old('loanable_id') ? old('loanable_id') : (!empty($loan->loanable_id) ? $loan->loanable_id : null),['class' => 'form-control','id' => 'loanable_id', 'placeholder'=>"Select Source"])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loan_type">Loan Type<span class="text-danger">*</span></label>
                    {{Form::select('loan_type',$loanTypes, old('loan_type') ? old('loan_type') : (!empty($loan->loan_type) ? $loan->loan_type : null),['class' => 'form-control','placeholder' => 'Select Loan Type ','id' => 'loan_type', 'autocomplete'=>"off"])}}
                </div>
            </div>
<!--            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="available_fund">Available Fund<span class="text-danger">*</span></label>
{{--                    {{Form::number('available_fund', old('available_fund') ? old('available_fund') : (!empty($loan->available_fund) ? $loan->available_fund : null),['class' => 'form-control','id' => 'available_fund', 'min' => 0,'step' => 0.5, 'autocomplete'=>"off"])}}--}}
                </div>
            </div>-->
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="total_sanctioned">Total Sanctioned <span class="text-danger">*</span></label>
                    {{Form::text('total_sanctioned', old('total_sanctioned') ? old('total_sanctioned') : (!empty($loan->total_sanctioned) ? number_format($loan->total_sanctioned,2) : null),['class' => 'form-control text-right','id' => 'total_sanctioned', 'min' => 0,'step' => 0.5, 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sanctioned_limit">Sanctioned Limit <span class="text-danger">*</span></label>
                    {{Form::text('sanctioned_limit', old('sanctioned_limit') ? old('sanctioned_limit') : (!empty($loan->sanctioned_limit) ? number_format($loan->sanctioned_limit,2) : null),['class' => 'form-control text-right','id' => 'sanctioned_limit', 'min' => 0,'step' => 0.5, 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="interest_rate">Interest Rate<span class="text-danger">*</span></label>
                    {{Form::number('interest_rate', old('interest_rate') ? old('interest_rate') : (!empty($loan->interest_rate) ? $loan->interest_rate : null),['class' => 'form-control','id' => 'interest_rate', 'autocomplete'=>"off", 'min' => 0,'step' => 0.5])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="opening_date">Opening Date<span class="text-danger">*</span></label>
                    {{Form::text('opening_date', old('opening_date') ? old('opening_date') : (!empty($loan->opening_date) ? $loan->opening_date : null),['class' => 'form-control','id' => 'opening_date', 'autocomplete'=>"off"])}}
                </div>
            </div>
<!--            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="start_date">Start Date<span class="text-danger">*</span></label>
{{--                    {{Form::text('start_date', old('start_date') ? old('start_date') : (!empty($loan->start_date) ? $loan->start_date : null),['class' => 'form-control','id' => 'start_date', 'autocomplete'=>"off"])}}--}}
                </div>
            </div>-->
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="maturity_date">Maturity Date<span class="text-danger">*</span></label>
                    {{Form::text('maturity_date', old('maturity_date') ? old('maturity_date') : (!empty($loan->maturity_date) ? $loan->maturity_date : null),['class' => 'form-control','id' => 'maturity_date', 'autocomplete'=>"off"])}}
                </div>
            </div>

<!--            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Installment Size <span class="text-danger">*</span></label>
{{--                    {{Form::number('installment_size', old('installment_size') ? old('installment_size') : (!empty($loan->installment_size) ? $loan->installment_size : null),['class' => 'form-control','id' => 'installment_size', 'autocomplete'=>"off", 'min' => 0,'step' => 0.5])}}--}}
                </div>
            </div>-->

            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loan_number">Loan Number<span class="text-danger">*</span></label>
                    {{Form::number('loan_number', old('loan_number') ? old('loan_number') : (!empty($loan->loan_number) ? $loan->loan_number : null),['class' => 'form-control','id' => 'loan_number', 'autocomplete'=>"off", 'min' => 0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="total_installment">Total Installment<span class="text-danger">*</span></label>
                    {{Form::number('total_installment', old('total_installment') ? old('total_installment') : (!empty($loan->total_installment) ? $loan->total_installment : null),['class' => 'form-control','id' => 'total_installment', 'autocomplete'=>"off", 'min' => 0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loan_purpose">Loan Purpose<span class="text-danger">*</span></label>
                    {{Form::text('loan_purpose', old('loan_purpose') ? old('loan_purpose') : (!empty($loan->loan_purpose) ? $loan->loan_purpose : null),['class' => 'form-control','id' => 'loan_purpose', 'autocomplete'=>"off", 'min' => 0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Mortgage <span class="text-danger">*</span></label>
                    {{Form::select('project_id',$projects, old('project_id') ? old('project_id') : (!empty($loan->project_id) ? $loan->project_id : null),['class' => 'form-control','id' => 'project_id', 'placeholder' => 'Select', 'autocomplete'=>"off", 'min' => 0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="emi_date">EMI Date <span class="text-danger">*</span></label>
                    {{Form::text('emi_date', old('emi_date') ? old('emi_date') : (!empty($loan->emi_date) ? $loan->emi_date : null),['class' => 'form-control','id' => 'emi_date', 'autocomplete'=>"off", 'min' => 0])}}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="emi_amount">EMI Amount <span class="text-danger">*</span></label>
                    {{Form::text('emi_amount', old('emi_amount') ? old('emi_amount') : (!empty($loan->emi_amount) ? $loan->emi_amount : null),['class' => 'form-control','id' => 'emi_amount', 'autocomplete'=>"off", 'min' => 0])}}
                </div>
            </div>
            <div class="col-xl-12 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="description">Description<span class="text-danger">*</span></label>
                    {{Form::text('description', old('description') ? old('description') : (!empty($loan->description) ? $loan->description : null),['class' => 'form-control','id' => 'description', 'autocomplete'=>"off", 'min' => 0])}}
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
            $('#opening_date,#start_date, #maturity_date, #emi_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            function loadLoanSourceNames(){
                let dropdown = $('#loanable_id');
                let oldSelectedItem = "{{old('loanable_id') ? old('loanable_id') : (!empty($loan->loanable_id) ? $loan->loanable_id : null)}}";
                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select Type </option>');
                dropdown.prop('selectedIndex', 0);
                const url = '{{url("loadLoanSourceNames")}}/' + $("#loanable_type").val();
                // Populate dropdown with list of provinces
                $.getJSON(url, function (sources) {
                    $.each(sources, function (key, source) {
                        let select=(oldSelectedItem == key) ? "selected" : null;
                        dropdown.append($(`<option ${select}></option>`).attr('value', key).text(`${source}`));
                    });
                });
            }
            @if(!old('loanable_type'))
                loadLoanSourceNames();
            @endif

            $("#loanable_type").on('change', function(){
                loadLoanSourceNames();
            });

            $(document).on('keyup','#total_sanctioned, #sanctioned_limit ',function (){
                addComma(this)
            });

            function addComma (thisVal){
                $(thisVal).keyup(function(event) {
                    if(event.which >= 37 && event.which <= 40) return;
                    $(this).val(function(index, value) {
                        return value .replace(/[^0-9\.]/g, "") .replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
                    });
                });
            }

        });//document.ready()


    </script>
@endsection
