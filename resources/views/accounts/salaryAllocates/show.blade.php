@extends('layouts.backend-layout')
@section('title', 'Client')

@section('breadcrumb-title')
    Voucher Details {{strtoupper($voucher->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/vouchers/') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')
    <form class="col-md-12 p-1 custom-form" id="voucher_preview" style="border: 1px solid #8a8a8a">
        <div class="text-center">
            <h5 class="text-center" id="voucher_title" style="display:inline-block; text-align: center; padding: 5px 10px; border: 1px solid #000000; border-radius: 30px">{{$voucher->voucher_type }} Voucher</h5>
        </div>
        <div class="row py-2">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="bill_no"> {{$voucher->voucher_type  == 'Receipt' ? 'MR No' : 'Bill No'}}</label>
                    @php $billMr =  $voucher->voucher_type == 'Receipt' ? $voucher->mr_no : $voucher->bill_no @endphp
                    {{Form::text('bill_no',  $billMr ,['class' => 'form-control','id' => 'bill_no', 'list' => 'bill_no_list', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6">
            </div>

            <div class=""></div>
            <div class="col-md-3" align="center">
                <table>
                    <tr>
                        <td style="text-align: left">Voucher No :</td>
                        <th class="text-right">#{{$voucher->id }}</th>
                    </tr>
                    <tr>
                        <td style="text-align: left">Date :</td>
                        <th class="text-right">{{$voucher->transaction_date}}</th>
                    </tr>
                </table>
            </div>
        </div>
    <table class="table table-bordered text-right" id="voucherTable">
        <thead class="text-center">
            <tr class="bg-dark">
                <th>Accounts</th>
                <th>Cost Center</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody class="text-right">
        @foreach ($voucher->ledgerEntries as $key => $account)
            <tr>
                <td class="text-left ">
                    <div >
                        {{$account->account->account_name ?? ''}}<br>
                        <b>{{$account->pourpose ?? ''}}</b>
                    </div>
                </td>
                <td>
                    {{Form::text('project[]', $account->costCenter->name ?? '' ,['class' => 'form-control project','id' => 'project', 'placeholder'=>" Project Name", 'autocomplete'=>"off"])}}
                </td>
                <td>
                    {{Form::text('dr_amount[]', number_format($account->dr_amount,2),['class' => 'form-control dr_amount text-right','id' => 'dr_amount', 'step' => '0.05', 'autocomplete'=>"off"])}}
                </td>
                <td>
                    {{Form::text('cr_amount[]', number_format($account->cr_amount,2),['class' => 'form-control cr_amount text-right','id' => 'cr_amount', 'step' => '0.05', 'autocomplete'=>"off"])}}
                </td>
                <td>
                    {{Form::textarea('remarks[]', $account->remarks,['class' => 'form-control','id' => 'remarks', 'autocomplete'=>"off", 'rows'=>1])}}
                </td>
            </tr>
        @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2" class="text-right">TOTAL TK.</td>
                <td>
                    {{Form::text('total_dr_amount', number_format($voucher->ledgerEntries->sum('dr_amount'),2),['class' => 'form-control total_dr_amount text-right','id' => 'total_dr_amount', "readonly"])}}
                </td>
                <td>
                    {{Form::text('total_cr_amount', number_format($voucher->ledgerEntries->sum('cr_amount'),2), ['class' => 'form-control total_cr_amount text-right','id' => 'total_cr_amount', "readonly"])}}
                </td>
                <td colspan=""></td>
            </tr>
            <tr>
                <td colspan="5" class="text-center text-uppercase"><b>In word : </b>{{$f->format($voucher->ledgerEntries->sum('dr_amount'))}} Taka Only.</td>
            </tr>
            <tr>
                <td colspan="">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="cheque_number">Cheque Number<span class="text-danger">*</span></label>
                        {{Form::text('cheque_number', $voucher->cheque_number,['class' => 'form-control','id' => 'cheque_number', 'autocomplete'=>"off", 'rows'=>2])}}
                    </div>
                </td>
                <td colspan="2">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="cheque_type">Cheque Type<span class="text-danger">*</span></label>
                        {{Form::text('cheque_type',$voucher->cheque_type,['class' => 'form-control','id' => 'cheque_type', 'autocomplete'=>"off", 'rows'=>2])}}
                    </div>
                </td>

                <td colspan="2">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="cheque_type">Cheque Date <span class="text-danger">*</span></label>
                        {{Form::text('cheque_date', $voucher->cheque_date, ['class' => 'form-control','id' => 'cheque_date', 'autocomplete'=>"off", 'rows'=>2])}}
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <div class="input-group input-group-sm input-group-primary">
                        <u>Narration : </u>
                        <b> &nbsp;&nbsp;&nbsp;
{{--                            @if(!empty($account->transaction->transactionable->salecollection))--}}
{{--                                @foreach( $account->transaction->transactionable->salecollection->salesCollectionDetails as $collectionDtl)--}}
{{--                                    {{$collectionDtl->particular}} - {{$collectionDtl->installment_no}},--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
                            {{$account->transaction->transactionable->salecollection->source_name ?? ''}}
                            {{$voucher->narration }}
                        </b>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="5" class="text-center"> Prepaired By : <b> {{$account->transaction->user->name ?? ''}}</b></td>
            </tr>
        </tfoot>
    </table>
    </form>
@endsection

@section('script')

@endsection
