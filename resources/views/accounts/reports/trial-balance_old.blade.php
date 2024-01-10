@extends('layouts.backend-layout')
@section('title', 'Collections Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #a09e9e;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold; text-align: left;}
        .balance_header{font-weight: bold; padding-left:20px; text-align: left; }
        .balance_line_style{ font-weight: bold; padding-left:50px; text-align: left; }
        .account_line{ padding-left:80px;  text-align: left; }
        .account{ padding-left:110px;  text-align: left; }
        table tbody td:nth-child(4),table tbody td:nth-child(3){
            text-align: right;
        }
        .text-right{
            text-align: right;
        }
        .text-right{
            text-align: left;
        }
        .account_row{display: none}
    </style>

@endsection

@section('breadcrumb-title')

@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')

    <br>
    <h2 class="text-center">Trial Balance</h2>
    <br>
    <div class="table-responsive">
        <table style="width: 100%">
            <thead>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td rowspan="2"> Particulars </td>
                <td rowspan="2"> Opening Balance </td>
                <td colspan="2"> Transactions </td>
                <td rowspan="2"> Closing Balance </td>
            </tr>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td> Debit </td>
                <td> Credit </td>
            </tr>
            </thead>
            <tbody>
            @foreach ($balanceIncomeHeaders  as $balanceIncomeHeader)
                @php
                    $previousYearLedgersHeader = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten();
                    $currentYearLedgersHeader = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                    $previousYearTotalDebitHeader = $previousYearLedgersHeader->sum('dr_amount');
                    $previousYearTotalCreditHeader = $previousYearLedgersHeader->sum('cr_amount');
                    $currentYearTotalDebitHeader = $currentYearLedgersHeader->sum('dr_amount');
                    $currentYearTotalCreditHeader = $currentYearLedgersHeader->sum('cr_amount');

                    if($balanceIncomeHeader->value_type == 'D'){
                        $opHeader = $previousYearTotalDebitHeader - $previousYearTotalCreditHeader;
                        $OpHeaderType  = $opHeader >= 0 ? 'Dr' : 'Cr';
                        if ($OpHeaderType == 'Dr'){
                             $ClosingHeader = $opHeader + $currentYearTotalDebitHeader - $currentYearTotalCreditHeader;
                        }else{
                            $ClosingHeader = $opHeader + $currentYearTotalCreditHeader - $currentYearTotalDebitHeader;
                        }
                        $closingHeaderType = $ClosingHeader >=  0 ? 'Dr' : 'Cr' ;
                    }else{
                        $opHeader = $previousYearTotalCreditHeader - $previousYearTotalDebitHeader;
                        $OpHeaderType  = $opHeader >= 0 ? 'Cr' : 'Dr' ;
                        if ($OpHeaderType == 'Dr'){
                             $ClosingHeader = $opHeader + $currentYearTotalDebitHeader - $currentYearTotalCreditHeader;
                        }else{
                            $ClosingHeader = $opHeader + $currentYearTotalCreditHeader - $currentYearTotalDebitHeader;
                        }
                        $closingHeaderType = $ClosingHeader >=  0 ? 'Cr' : 'Dr' ;
                    }
                @endphp
                <tr style="background-color: #dbecdb ">
                    <td class="balance_header">{{$balanceIncomeHeader->line_text}}</td>
                    <td style="text-align: right">
                        <strong> @money($opHeader) {{$OpHeaderType}}</strong>
                    </td>
                    <td style="text-align: right">@money($currentYearTotalDebitHeader) </td>
                    <td style="text-align: right"> @money($currentYearTotalCreditHeader) </td>
                    <td style="text-align: right"> @money(abs($ClosingHeader)) {{$closingHeaderType}}</td>
                </tr>
                @foreach($balanceIncomeHeader->descendants as $balanceLine)
                    @php
                        $previousYearLedgersLine = $balanceLine->accounts->flatten()->pluck('previousYearLedger')->flatten();
                        $currentYearLedgersLine = $balanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten();
                        $previousYearTotalDebitLine = $previousYearLedgersLine->sum('dr_amount');
                        $previousYearTotalCreditLine = $previousYearLedgersLine->sum('cr_amount');
                        $currentYearTotalDebitLine = $currentYearLedgersLine->sum('dr_amount');
                        $currentYearTotalCreditLine = $currentYearLedgersLine->sum('cr_amount');

                        if($balanceLine->value_type == 'D'){
                            $opLine = $previousYearTotalDebitLine - $previousYearTotalCreditLine;
                            $OplineType  = $opLine >= 0 ? 'Dr' : 'Cr';
                            if ($OplineType == 'Dr'){
                                $ClosingLine = $opLine + $currentYearTotalDebitLine - $currentYearTotalCreditLine;
                            }else{
                                $ClosingLine = $opLine + $currentYearTotalCreditLine - $currentYearTotalDebitLine;
                            }
                        $ClosingLineType = $ClosingLine >=  0 ? 'Dr' : 'Cr' ;
                        }else{
                            $opLine = $previousYearTotalCreditLine - $previousYearTotalDebitLine;
                            $OplineType  = $opLine >= 0 ? 'Cr' : 'Dr' ;
                            if ($OplineType == 'Dr'){
                                $ClosingLine = $opLine + $currentYearTotalDebitLine - $currentYearTotalCreditLine;
                            }else{
                                $ClosingLine = $opLine + $currentYearTotalCreditLine - $currentYearTotalDebitLine;
                            }
                            $ClosingLineType = $ClosingLine >=  0 ? 'Cr' : 'Dr' ;
                        }
                    @endphp
                    <tr style="background-color: #f0f5f5 ">
                        <td class="balance_line_style balance_line" id="{{$balanceLine->id}}"> {{$balanceLine->line_text}} </td>
                        <td style="text-align: right"> @money($opLine) {{$OplineType}}</td>
                        <td style="text-align: right"> @money($currentYearTotalDebitLine)</td>
                        <td style="text-align: right"> @money($currentYearTotalCreditLine)</td>
                        <td style="text-align: right"> @money(abs($ClosingLine)) {{$ClosingLineType}}</td>
                    </tr>
                    @php $parentaccounts = $balanceLine->accounts()->with('accountChilds')->get();
                       // dump($parentaccounts->pluck('accountChilds')->flatten()->sum('dr_amount'));
                    @endphp
                    @foreach ($parentaccounts as $parentaccount)
                        <tr class="account_row balance_account_{{$balanceLine->id}}">
                            <td class="account_line parent_account" id="{{$parentaccount->id}}"> {{$parentaccount->account_name}}</td>
                            <td style="text-align: right">
                                @if(in_array($parentaccount->account_type, [1, 5]))
                                    @php $resultDebit = $parentaccount->previousYearLedger->sum('dr_amount') - $parentaccount->previousYearLedger->sum('cr_amount') ; @endphp
                                    @money(abs($resultDebit))
                                    {{($resultDebit >= 0) ? "Dr" : "Cr" }}
                                @elseif(in_array($parentaccount->account_type, [2, 4]))
                                    @php $previousYearCredit = $parentaccount->previousYearLedger->sum('cr_amount') - $parentaccount->previousYearLedger->sum('dr_amount') @endphp
                                    @money(abs($previousYearCredit))
                                    {{($previousYearCredit >= 0) ? "Cr" : "Dr" }}
                                @endif
                            </td>
                            <td style="text-align: right"> @money(abs($parentaccount->currentYearLedger->sum('dr_amount'))) </td>
                            <td style="text-align: right"> @money(abs($parentaccount->currentYearLedger->sum('cr_amount'))) </td>
                            <td style="text-align: right">
                                @if(in_array($parentaccount->account_type, [1, 5]))
                                    @php
                                        $currentYearDebit = $parentaccount->CurrentYearTotalDebit - $parentaccount->CurrentYearTotalCredit;
                                        $debitCurrentStatus = ($resultDebit >= 0) ? $currentYearDebit + $resultDebit : $currentYearDebit;
                                    @endphp
                                    @money(abs($debitCurrentStatus))
                                    {{($debitCurrentStatus >= 0) ? "Dr" : "Cr" }}

                                @elseif(in_array($parentaccount->account_type, [2, 4]))
                                    @php
                                        $currentYearCredit = $parentaccount->CurrentYearTotalCredit - $parentaccount->CurrentYearTotalDebit;
                                        $creditCurrentStatus = $previousYearCredit >= 0  ?  $currentYearCredit + $previousYearCredit : $currentYearCredit + $previousYearCredit ;
                                    @endphp
                                    @money(abs($creditCurrentStatus))
                                    {{($creditCurrentStatus >= 0) ? "Cr" : "Dr" }}
                                @endif
                            </td>
                        </tr>
                        @php
                            $accounts = $balanceLine->accounts()->where('parent_account_id', $parentaccount->id)->get();
                            //$accounts = $balanceLine->accounts()->where('parent_account_id', $parentaccount->id)->get();
                        @endphp
                        {{--@foreach($accounts as $account)
                            <tr class="account_row parent_account_{{$parentaccount->id}}"  style="background-color: #9fe5e5">
                                @if(in_array($account->account_type, [1, 5]))
                                    @php $resAccountDebit = $account->previousYearLedger->sum('dr_amount') - $account->previousYearLedger->sum('cr_amount') ; @endphp
                                    @money(abs($resAccountDebit))
                                    {{($resAccountDebit >= 0) ? "Dr" : "Cr" }}
                                @elseif(in_array($account->account_type, [2, 4]))
                                    @php $previousYearAccountCredit = $account->previousYearLedger->sum('cr_amount') - $account->previousYearLedger->sum('dr_amount') @endphp
                                    @money(abs($previousYearAccountCredit))
                                    {{($previousYearAccountCredit >= 0) ? "Cr" : "Dr" }}
                                @endif
                                <td class="account" > {{$account->account_name}} </td>
                                <td>    </td>
                                <td>    </td>
                                <td>    </td>
                                <td>    </td>
                                <td style="text-align: right"> @money($opLine) {{$OplineType}}</td>
                                <td style="text-align: right"> @money($currentYearTotalDebitLine)</td>
                                <td style="text-align: right"> @money($currentYearTotalCreditLine)</td>
                                <td style="text-align: right"> @money(abs($ClosingLine)) {{$ClosingLineType}}</td>
                            </tr>
                        @endforeach--}}
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $(document).on('click', '.balance_line', function(){
                let currentLine = $(this).attr('id');
                $(".balance_account_"+currentLine).toggle();
            });
            $(document).on('click', '.parent_account', function(){
                let parentAccount = $(this).attr('id');
                $(".parent_account_"+parentAccount).toggle();
            });
        });//document.ready
    </script>
@endsection
