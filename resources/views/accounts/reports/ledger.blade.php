@extends('layouts.backend-layout')
@section('title', 'Ledger-')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Ledger
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1">
                <input type="text" id="account_name" name="account_name" class="form-control form-control-sm" value="{{!empty($account) ? $account->account_name : null}}" placeholder="Enter Account Name" autocomplete="off">
                <input type="hidden" id="account_id" name="account_id" class="form-control form-control-sm" value="{{$request->account_id ?? $request->account_id}}">
            </div>
            <div class="col-md-2 px-1 my-1" id="fromDateArea">
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d-m-Y', strtotime($fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1" id="tillDateArea">
                <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : ''}}" placeholder="Till Date" autocomplete="off">
            </div>

            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if(!empty($account))
        <h4 class="text-center mt-3">Ledger : {{$account->account_name ?? ''}}</h4>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th> Date </th>
                    <th> Cost Center </th>
                    <th> Particular </th>
                    <th>  Type  </th>
                    <th> Bill / MR  </th>
                    <th> Voucher No </th>
                    <th> Transaction Info  </th>
                    <th> Debit </th>
                    <th> Credit </th>
                    <th> Balance </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="7" class="text-left"><strong>Opening Balance</strong></td>

                    @php
                        $crAmount = $accountOpeningBalance->ledgers->sum('cr_amount');
                        $drAmount = $accountOpeningBalance->ledgers->sum('dr_amount');
                        $drClosingBalance = $account->ledgers->sum('dr_amount');
                        $crClosingBalance = $account->ledgers->sum('cr_amount');
                        $drTotalAmount = 0;
                        $crTotalAmount = 0;
                        $openingBalanceCr = $openingBalance->sum('cr_amount') ;
                        $openingBalanceDr = $openingBalance->sum('dr_amount');
                         $balance=0;
                        //dd($openingBalanceCr, $openingBalanceDr)
                    @endphp

                    @if(in_array($accountOpeningBalance->account_type, [1, 5]))
                        @php
                            $obAmount = $drAmount - $crAmount + $openingBalanceDr;
                            $closingBalance = $drClosingBalance - $crClosingBalance ;
                            $drClosing = $closingBalance > 0 ? 'dr' : 'cr';
                            $drType = $obAmount >= 0 ? 'dr' : 'cr';
                        @endphp
                    @endif

                    @if(in_array($accountOpeningBalance->account_type, [2, 4]))
                        @php
                            $obAmount = $crAmount - $drAmount + $openingBalanceCr;
                            $closingBalance = $crClosingBalance - $drClosingBalance ;
                            $drClosing = $closingBalance > 0 ? 'cr' : 'dr';
                            $drType = $obAmount >= 0 ? 'cr' : 'dr';
                        @endphp
                    @endif

                    @if ($drType == 'dr')
                        <td class="text-right">@money(abs($obAmount))</td>
                        <td></td>
                        @php  $absOpAmount = $obAmount ? abs($obAmount) :0;  @endphp
                    @else
                        <td></td>
                        <td class="text-right">@money(abs($obAmount))</td>
                        @php $absOpAmount = $obAmount ? abs($obAmount) : 0; @endphp
                    @endif
                    <td></td>
                </tr>
                @foreach($account->ledgers as $key => $ledger)
                    @php
                        //dump($account->toArray());
                            $opData = $ledger->transaction->ledgerEntries->where('account_id', '!=', $account->id)->whereNotIn('pourpose',['Movement Out','Movement In']);
                            //dump($account->balance_and_income_line_id);
                            if($account->balance_and_income_line_id == 14 || $account->balance_and_income_line_id == 86 ){  //Working in progress
                                if(count($opData) > 0){
                                    $opositeAccounts = \App\LedgerEntry::where('transaction_id', $opData->first()->transaction_id)
                                        ->whereHas('account',function ($q){
                                          $q->whereNotIn('balance_and_income_line_id',[14, 86]);
                                        })
                                        ->with('account',function ($q){
                                            $q->whereNotIn('balance_and_income_line_id',[14, 86]);
                                        })
                                        ->latest('id')->get();    
                                }
                                
                                $ledgerIsItem = 1;
                            }elseif($account->balance_and_income_line_id == 11 ){  // inventory
                                $opositeAccounts = \App\LedgerEntry::where('transaction_id', $opData->first()->transaction_id)
                                        ->whereHas('account',function ($q){
                                            $q->where('balance_and_income_line_id','!=',11);
                                        })
                                        ->get();
                                $ledgerIsItem = 1;
                            }elseif ($account->balance_and_income_line_id == 35){  // Advance Againest Sales
                                $opositeAccounts = \App\LedgerEntry::where('transaction_id', $opData->first()->transaction_id)
                                        ->whereHas('account',function ($q){
                                            $q->whereIn('account_type',[1])->orWhereIn('balance_and_income_line_id',[8,31,107,34]);
                                        })
                                        ->get();
                                $ledgerIsItem = 1;
                            }elseif ($account->balance_and_income_line_id == 63){  // dealy charge
                                $opositeAccounts = \App\LedgerEntry::where('transaction_id', $opData->first()->transaction_id)
                                        ->whereHas('account',function ($q){
                                            $q->whereNotIn('balance_and_income_line_id',[63,35]);
                                        })
                                        ->get();
                                $ledgerIsItem = 1;
                            }
                            else{
                                $opositeAccounts = $ledger->transaction->ledgerEntries->where('account_id', '!=', $account->id);
                                $ledgerIsItem = 0;
                            }
                            $rows = $opositeAccounts->count();
                            //dump($opositeAccounts->toArray());
                    @endphp

                    @if(!empty($opositeAccounts))
                    @foreach($opositeAccounts as $opositeAccount)
                        @php
                            //dump($opositeAccount->account->toArray());
                            $voucherType = $ledger->transaction->voucher_type;
                            $billNo = $voucherType == 'Receipt' ?  $ledger->transaction->mr_no  : $ledger->transaction->bill_no ;
                            $drTotalAmount += $ledgerIsItem == 1 ?  $ledger->dr_amount : $opositeAccount->cr_amount;
                            $crTotalAmount += $ledgerIsItem == 1 ?  $ledger->cr_amount : $opositeAccount->dr_amount;
                        @endphp
                        <tr>
                            @if($loop->first)
                                <td rowspan="{{$rows}}">{{$ledger->transaction->transaction_date }} </td>
                                <td rowspan="{{$rows}}" class="text-left"> {{$ledger->costCenter->name ?? '' }} </td>
                            @endif
                            <td class="text-left"><a href="{{route('vouchers.show',$ledger->transaction->id)}}">{{$opositeAccount->account->account_name ?? ''}}</a>
                                @if($ledgerIsItem == 1)
                                    {{$ledger->pourpose ? '( ' .$ledger->pourpose . ' )' : ''}}
                                @else
                                    {{$opositeAccount->pourpose ? '( ' .$opositeAccount->pourpose . ' )' : ''}}
                                @endif
                            </td>
                            @if($loop->first)
                                <td rowspan="{{$rows}}"> {{ $voucherType}} </td>
                                <td rowspan="{{$rows}}" >{{$voucherType == 'Receipt' ? "$billNo" :($voucherType == 'Payment' ? $ledger->ref_bill : "$billNo")}} </td>
                                <td rowspan="{{$rows}}"> {{$ledger->transaction_id}} </td>
                                <td rowspan="{{$rows}}"> {{$ledger->transaction->cheque_type}} - {{$ledger->transaction->cheque_number}} </td>
                            @endif
                            <td class="text-right">
                                @if($ledgerIsItem == 1)
                                    @php $drRawAmount =  !empty($ledger->dr_amount) ?  $ledger->dr_amount : 0.00; @endphp
                                @else
                                    @php $drRawAmount =  !empty($opositeAccount->cr_amount) ?  $opositeAccount->cr_amount : 0.00; @endphp
                                @endif
                                @money($drRawAmount)
                            </td>
                            <td class="text-right">
                                @if($ledgerIsItem == 1)
                                    @php $crRawAmount =  !empty($ledger->cr_amount) ?  $ledger->cr_amount : 0.00; @endphp
                                @else
                                    @php $crRawAmount =  !empty($opositeAccount->dr_amount) ?  $opositeAccount->dr_amount : 0.00; @endphp
                                @endif
                                @money($crRawAmount)
                            </td>
                                @if ($loop->first && $loop->parent->first)
                                    @php
                                        $balance += $drType == 'dr' ? $drRawAmount - $crRawAmount + $absOpAmount  : $crRawAmount - $drRawAmount + $absOpAmount;
                                    @endphp
                                @else
                                    @php
                                        $balance += $drType == 'dr' ? $drRawAmount - $crRawAmount  : $crRawAmount - $drRawAmount;
                                    @endphp
                                @endif
                            @php
                                // $absOpAmount;

                                //$balance += $drType == 'dr' ? $drRawAmount - $crRawAmount  : $crRawAmount - $drRawAmount;
                                  //$balance +=  abs($balanceAbs);
                                //dump($balance);
                            @endphp
                            <td class="text-right">  @money($balance) </td>
                        </tr>
                    @endforeach
                    @endif 
                @endforeach

                <tr>
                    <td colspan="7" class="text-right"><strong>Total</strong> </td>
                    <td class="text-right">
                        @php $opTotalDrAmount = $drType == 'dr' ? $drTotalAmount + $absOpAmount :  $drTotalAmount @endphp
                        <b>@money($opTotalDrAmount)</b>
                    </td>
                    <td class="text-right">
                        @php $opTotalCrAmount = $drType == 'cr' ? $crTotalAmount + $absOpAmount :  $crTotalAmount @endphp
                        <b>@money($opTotalCrAmount)</b>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right"><strong>Closing Balance</strong> </td>
                    @php $closingTotalBalance = $drClosing == 'dr' ? $opTotalDrAmount - $opTotalCrAmount : $opTotalCrAmount -  $opTotalDrAmount @endphp
                    @if ($drClosing == 'dr')
                        <td class="text-right">
                            <b>@money(abs($closingTotalBalance))</b>
                        </td>
                        <td></td>
                    @else
                        <td></td>
                        <td class="text-right"> <b>@money(abs($closingTotalBalance))</b> </td>
                    @endif
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    @endif
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $('#fromDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
            $('#tillDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});

            $("#dateType").change(function(){
                let type = $(this).val();
                if(type === 'custom'){
                    $("#fromDateArea, #tillDateArea").show('slow');
                    $("#fromDate, #tillDate").attr('required', true);
                }else{
                    $("#fromDateArea, #tillDateArea").hide('slow');
                    $("#fromDate, #tillDate").removeAttr('required');
                }
            });

            $("#account_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{url('api/account-name')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#account_name').val(ui.item.label);
                    $('#account_id').val(ui.item.value);
                    return false;
                }
            }).change(function(){
                if(!$(this).val()){
                    $('#account_id').val(null);
                }
            });

        });//document.ready
    </script>
@endsection
