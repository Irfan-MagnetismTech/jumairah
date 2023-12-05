<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 10px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
        }

        td,
        th {
            border: 1px solid black;
            padding: 5px;
            border-collapse: collapse;
        }

        th {
            background-color: #227447;
            color: white;
        }


        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #0e2b4e;
            color: white;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <img src="{{asset('images/ranksfc_log.png')}}" alt="">
        <h1 style="margin:0; padding:0">Income Statement</h1>
        <strong>December 31, {{now()->format('Y')}}</strong>
    </div>
    <br>
    @if(!empty($account))
    <div style="justify-content: center;">
        <table id="dataTable" class="table" style="border-collapse:collapse; width: 100%">
            <thead>
                <tr>
                    <th> Date </th>
                    <th> Cost Center </th>
                    <th> Particular </th>
                    <th> Type </th>
                    <th> Bill / MR </th>
                    <th> Voucher No </th>
                    <th> Transaction Info </th>
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
                    @php $absOpAmount = $obAmount ? abs($obAmount) :0; @endphp
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
                if($account->balance_and_income_line_id == 14 || $account->balance_and_income_line_id == 86 ){ //Working in progress
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
                }elseif($account->balance_and_income_line_id == 11 ){ // inventory
                $opositeAccounts = \App\LedgerEntry::where('transaction_id', $opData->first()->transaction_id)
                ->whereHas('account',function ($q){
                $q->where('balance_and_income_line_id','!=',11);
                })
                ->get();
                $ledgerIsItem = 1;
                }elseif ($account->balance_and_income_line_id == 35){ // Advance Againest Sales
                $opositeAccounts = \App\LedgerEntry::where('transaction_id', $opData->first()->transaction_id)
                ->whereHas('account',function ($q){
                $q->whereIn('account_type',[1])->orWhereIn('balance_and_income_line_id',[8,31,107,34]);
                })
                ->get();
                $ledgerIsItem = 1;
                }elseif ($account->balance_and_income_line_id == 63){ // dealy charge
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
                $billNo = $voucherType == 'Receipt' ? $ledger->transaction->mr_no : $ledger->transaction->bill_no ;
                $drTotalAmount += $ledgerIsItem == 1 ? $ledger->dr_amount : $opositeAccount->cr_amount;
                $crTotalAmount += $ledgerIsItem == 1 ? $ledger->cr_amount : $opositeAccount->dr_amount;
                @endphp
                <tr>
                    @if($loop->first)
                    <td rowspan="{{$rows}}">{{$ledger->transaction->transaction_date }} </td>
                    <td rowspan="{{$rows}}" class="text-left"> {{$ledger->costCenter->name ?? '' }} </td>
                    @endif
                    <td class="text-left">{{$opositeAccount->account->account_name ?? ''}}
                        @if($ledgerIsItem == 1)
                        {{$ledger->pourpose ? '( ' .$ledger->pourpose . ' )' : ''}}
                        @else
                        {{$opositeAccount->pourpose ? '( ' .$opositeAccount->pourpose . ' )' : ''}}
                        @endif
                    </td>
                    @if($loop->first)
                    <td rowspan="{{$rows}}"> {{ $voucherType}} </td>
                    <td rowspan="{{$rows}}">{{$voucherType == 'Receipt' ? "$billNo" :($voucherType == 'Payment' ? $ledger->ref_bill : "$billNo")}} </td>
                    <td rowspan="{{$rows}}"> {{$ledger->transaction_id}} </td>
                    <td rowspan="{{$rows}}"> {{$ledger->transaction->cheque_type}} - {{$ledger->transaction->cheque_number}} </td>
                    @endif
                    <td class="text-right">
                        @if($ledgerIsItem == 1)
                        @php $drRawAmount = !empty($ledger->dr_amount) ? $ledger->dr_amount : 0.00; @endphp
                        @else
                        @php $drRawAmount = !empty($opositeAccount->cr_amount) ? $opositeAccount->cr_amount : 0.00; @endphp
                        @endif
                        @money($drRawAmount)
                    </td>
                    <td class="text-right">
                        @if($ledgerIsItem == 1)
                        @php $crRawAmount = !empty($ledger->cr_amount) ? $ledger->cr_amount : 0.00; @endphp
                        @else
                        @php $crRawAmount = !empty($opositeAccount->dr_amount) ? $opositeAccount->dr_amount : 0.00; @endphp
                        @endif
                        @money($crRawAmount)
                    </td>
                    @if ($loop->first && $loop->parent->first)
                    @php
                    $balance += $drType == 'dr' ? $drRawAmount - $crRawAmount + $absOpAmount : $crRawAmount - $drRawAmount + $absOpAmount;
                    @endphp
                    @else
                    @php
                    $balance += $drType == 'dr' ? $drRawAmount - $crRawAmount : $crRawAmount - $drRawAmount;
                    @endphp
                    @endif
                    @php
                    // $absOpAmount;

                    //$balance += $drType == 'dr' ? $drRawAmount - $crRawAmount : $crRawAmount - $drRawAmount;
                    //$balance += abs($balanceAbs);
                    //dump($balance);
                    @endphp
                    <td class="text-right"> @money($balance) </td>
                </tr>
                @endforeach
                @endif
                @endforeach

                <tr>
                    <td colspan="7" class="text-right"><strong>Total</strong> </td>
                    <td class="text-right">
                        @php $opTotalDrAmount = $drType == 'dr' ? $drTotalAmount + $absOpAmount : $drTotalAmount @endphp
                        <b>@money($opTotalDrAmount)</b>
                    </td>
                    <td class="text-right">
                        @php $opTotalCrAmount = $drType == 'cr' ? $crTotalAmount + $absOpAmount : $crTotalAmount @endphp
                        <b>@money($opTotalCrAmount)</b>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right"><strong>Closing Balance</strong> </td>
                    @php $closingTotalBalance = $drClosing == 'dr' ? $opTotalDrAmount - $opTotalCrAmount : $opTotalCrAmount - $opTotalDrAmount @endphp
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


    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script>
        $(function() {
            $(document).on('click', '.balance_line', function() {
                let currentLine = $(this).attr('id');
                $(".balance_account_" + currentLine).toggle();
            });
        });
    </script>

</body>

</html>