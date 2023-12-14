@extends('layouts.backend-layout')
@section('title', 'Loan')

@section('breadcrumb-title')
    @if(!empty($loanReceipt))
        Edit Loan
    @else
         Loan Receipt
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('loan-receipts.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')

    @if(!empty($loanReceipt))
        {!! Form::open(array('url' => route('loan-receipts.update', $loanReceipt->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => route('loan-receipts.store'), 'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($loanReceipt->id) ? $loanReceipt->id : null)}}">
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type">Loan <span class="text-danger">*</span></label>
                    {{Form::select('loan_id', $loans, old('loan_id') ? old('loan_id') : (!empty($loanReceipt->loan_id) ? $loanReceipt->loan_id : null),['class' => 'form-control','id' => 'loan_id', 'placeholder'=>"Select Source"])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Date<span class="text-danger">*</span></label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($loanReceipt->date) ? $loanReceipt->date : null),['class' => 'form-control','id' => 'date', 'autocomplete'=>"off", 'min' => 0,'step' => 0.5])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sanction_amount">Sanction Amount<span class="text-danger">*</span></label>
                    {{Form::text('sanction_amount', old('sanction_amount') ? old('sanction_amount') : (!empty($loanReceipt) ? number_format($loanReceipt->loan->sanctioned_limit, 2) : null),['class' => 'form-control text-right','id' => 'sanction_amount', 'autocomplete'=>"off", 'min' => 0,'step' => 0.5, 'readonly'])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="total_received_amount">Total Received Amount<span class="text-danger">*</span></label>
                    {{Form::text('total_received_amount', old('total_received_amount') ? old('total_received_amount') : (!empty($loanReceipt) ? number_format($loanReceipt->loan->loanReceives->flatten()->sum('receipt_amount'), 2) : null),['class' => 'form-control text-right','id' => 'total_received_amount', 'autocomplete'=>"off", 'min' => 0,'step' => 0.5, 'readonly'])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="receipt_amount">Receipt Amount<span class="text-danger">*</span></label>
                    {{Form::text('receipt_amount', old('receipt_amount') ? old('receipt_amount') : (!empty($loanReceipt->receipt_amount) ? number_format($loanReceipt->receipt_amount ,2): null),['class' => 'form-control text-right','id' => 'receipt_amount', 'autocomplete'=>"off", 'min' => 0,'step' => 0.5, ''])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="account_id">Bank Account <span class="text-danger">*</span></label>
                    {{Form::select('account_id', $bankAccounts, old('account_id') ? old('account_id') : (!empty($loanReceipt->account_id) ? $loanReceipt->account_id : null),['class' => 'form-control','id' => 'account_id', 'placeholder'=>"Select Source"])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type">Cheque Number<span class="text-danger">*</span></label>
                    {{Form::text('cheque_number', old('cheque_number') ? old('cheque_number') : (!empty($loanReceipt) ? $loanReceipt->cheque_number : null),['class' => 'form-control','id' => 'cheque_number', 'autocomplete'=>"off", 'rows'=>2])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type">Payment Type<span class="text-danger">*</span></label>
                    {{Form::select('cheque_type',['A/C Payee' => 'A/C Payee','Cheque' => 'Cheque','Pay Order' =>'Pay Order','Draft' =>'Draft','Same / Inter Bank' => 'Same / Inter Bank'], old('cheque_type') ? old('cheque_type') :
                        (!empty($loanReceipt) ? $loanReceipt->transaction->cheque_type : null),['class' => 'form-control','id' => 'cheque_type', 'placeholder' => 'Payment Type', 'autocomplete'=>"off", 'rows'=>2])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="loanable_type">Cheque Date<span class="text-danger">*</span></label>
                    {{Form::text('cheque_date', old('cheque_date') ? old('cheque_date') : (!empty($loanReceipt) ? $loanReceipt->transaction->cheque_date : null),['class' => 'form-control','id' => 'cheque_date', 'autocomplete'=>"off", 'rows'=>2])}}
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
            $("#loan_id").on('change', function (){
                getLoanInfo();
            })

            function getLoanInfo() {
                const loan_id = $("#loan_id").val();
                if (loan_id != '') {
                    const url = '{{ url('loan-info') }}/' + loan_id;
                    $.getJSON(url, function(loan, receivedAmount) {
                        $("#sanction_amount").val((loan.sanctioned_limit).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
                        $("#total_received_amount").val((loan.received_amount).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
                    });
                }
            }

            $('#date, #cheque_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            $(document).on('keyup','#receipt_amount',function (){
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
