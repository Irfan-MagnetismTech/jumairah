@extends('layouts.backend-layout')
@section('title', 'Balancesheet')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>

        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #a09e9e;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold; text-align: left;}
        .balance_header{font-weight: bold; padding-left:10px; text-align: left; }
        .balance_line{ font-weight: bold; padding-left:25px; text-align: left; }
        .balance_line:hover{ background: #c5c5c5;}
        .parent_account_line{ padding-left:50px;  text-align: left; }
        .parent_account_line:hover{ background: #afecec;}
        .child_account_line{ padding-left:80px;  text-align: left; }
        .child_account_line:hover{ background: #afdcec;}
        .account_line{ padding-left:100px;  text-align: left; }
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
    {{--    Breakup of Cost Center--}}
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')

    <div>
        <h2 class="text-center">Balance Sheet -  {{date('Y', strtotime(now()))}}</h2>
        <hr>
        <form action="" method="get">
            <div class="row px-2">
                <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
                    <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                        <option value="list" selected> List </option>
                        <option value="pdf"> PDF </option>
                    </select>
                </div>
                <div class="col-md-2 px-1 my-1" id="fromDateArea">
                    {{ Form::text('year', old('year') ? old('year') : (!empty(request()->year) ? request()->year : now()->format('Y')), ['class' => 'form-control form-control-sm', 'id' => 'applied_date', 'autocomplete' => 'off', 'required', 'placeholder' => 'Date', 'readonly']) }}
                </div>
                <div class="col-md-1 px-1 my-1">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div><!-- end row -->
        </form>
        <div class="table-responsive">
            <table style="width: 100%">
                <tr>
                    <td style="vertical-align: top;" colspan="3">
                        <table style="width: 100%; ">
                            <thead style="background:#116A7B; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Liabilities</td>
                            </tr>
                            </thead>
                            <tbody>
                            @php $totalLiabilities=0;
                            @endphp
                            @foreach($liabilities as $liabilityHeader)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header">{{$liabilityHeader->line_text}}</td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: right">
                                        <strong>
                                            @php
                                                $liabilityHeaderOB = $liabilityHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten();
                                                $liabilityHeaderOBAmount = $liabilityHeaderOB->sum('cr_amount') - $liabilityHeaderOB->sum('dr_amount');
                                                $liabilityHeaderAmount = $liabilityHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                                                $liabilityHeaderCls = $liabilityHeaderAmount->sum('cr_amount') - $liabilityHeaderAmount->sum('dr_amount') + $liabilityHeaderOBAmount;
                                            @endphp
                                            @money(abs($liabilityHeaderCls))
                                            @php
                                                $totalLiabilities += $liabilityHeaderCls;
                                            @endphp
                                        </strong>
                                    </td>
                                </tr>
                                @foreach($liabilityHeader->descendants as $balanceLine)
                                    <tr >
                                        <td class="balance_line" id="{{$balanceLine->id}}">
                                            {{$balanceLine->line_text}}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $balanceLineOB = $balanceLine->accounts->flatten()->pluck('previousYearLedger')->flatten();
                                                $balanceLineOBAmount = $balanceLineOB->sum('cr_amount') - $balanceLineOB->sum('dr_amount');
                                                $balanceLineAmount = $balanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount') -
                                                                      $balanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount') ;
                                                $balanceLineCls = $balanceLineAmount + $balanceLineOBAmount;
                                            @endphp
                                            @money(abs($balanceLineCls))
                                        </td>
                                    </tr>
                                    @php $parentAccounts = $balanceLine->accounts()->whereNull('parent_account_id')->get() @endphp
                                    @foreach ($parentAccounts as $parentAaccount)
                                        @php
                                            if ($parentAaccount->accountChilds->pluck('accountChilds')->collapse()->isNotEmpty()){
                                                $parentAaccountOB = $parentAaccount->accountChilds->pluck('accountChilds')->collapse()->pluck('previousYearLedger')->flatten();
                                                $parentAaccountAmount = $parentAaccount->accountChilds->pluck('accountChilds')->collapse()->pluck('currentYearLedger')->flatten();                                                    $test = 'two child';
                                            }elseif ($parentAaccount->accountChilds()->exists()){
                                                $parentAaccountOB = $parentAaccount->accountChilds->pluck('previousYearLedger')->flatten();
                                                $parentAaccountAmount = $parentAaccount->accountChilds->pluck('currentYearLedger')->flatten();
                                            }else{
                                                $parentAaccountOB = $parentAaccount->previousYearLedger;
                                                $parentAaccountAmount = $parentAaccount->currentYearLedger;
                                            }
                                            $parentAaccountOBAmount = $parentAaccountOB->sum('cr_amount') - $parentAaccountOB->sum('dr_amount');
                                            $parentAaccountCls = $parentAaccountAmount->sum('cr_amount') - $parentAaccountAmount->sum('dr_amount') + $parentAaccountOBAmount;
                                            $childAccounts = $parentAaccount->where('parent_account_id',$parentAaccount->id)->get();
                                        @endphp
                                        <tr class="account_row balance_account_{{$balanceLine->id}}">
                                            <td class="account_name parent_account_line" id="{{$parentAaccount->id}}">
                                                {{$parentAaccount->account_name}}
                                            </td>
                                            <td style="text-align: right"> @money(abs($parentAaccountCls))</td>
                                        </tr>
                                        @foreach($childAccounts as $childAccount)
                                            @php $accounts = $childAccount->where('parent_account_id',$childAccount->id)->get();
                                                if ($childAccount->accountChilds()->exists()){
                                                    $childAccountOB = $childAccount->accountChilds->pluck('previousYearLedger')->flatten();
                                                    $childAccountAmount = $childAccount->accountChilds->pluck('currentYearLedger')->flatten();
                                                }else{
                                                    $childAccountOB = $childAccount->previousYearLedger;
                                                    $childAccountAmount = $childAccount->currentYearLedger;
                                                }
                                                $childAccountOBAmount = $childAccountOB->sum('cr_amount') - $childAccountOB->sum('dr_amount');
                                                $childAccountCls = $childAccountOB->sum('cr_amount') -  $childAccountOB->sum('dr_amount') + $childAccountOBAmount;
                                            @endphp
                                            @if($childAccount->currentYearLedger()->exists())
                                                <tr class="account_row parent_account_{{$parentAaccount->id}} hide_balance_account_{{$balanceLine->id}}">
                                                    <td class="account_name child_account_line">
                                                        @if($childAccount->accountChilds()->exists())
                                                            {{$childAccount->account_name}}
                                                        @else
                                                            <a href="{{url("ledgers?account_id=$childAccount->id")}}" target="blank">{{$childAccount->account_name}} </a>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: right"> @money(abs($childAccountAmount->sum('cr_amount') - $childAccountAmount->sum('dr_amount')))</td>
                                                </tr>
                                            @endif
                                            @foreach($accounts as $account)
                                                @php
                                                    $accountOB = $account->accounts->flatten()->pluck('previousYearLedger')->flatten();
                                                    $accountOBAmount = $account->previousYearLedger->sum('cr_amount') - $account->previousYearLedger->sum('dr_amount');
                                                    $accountAmount = $account->currentYearLedger->sum('cr_amount') - $account->currentYearLedger->sum('dr_amount') ;
                                                    $accountCls = $accountAmount + $accountOBAmount;
                                                @endphp
                                                <tr class="account_row account_{{$childAccount->id}} hide_balance_account_{{$balanceLine->id}} hide_parent_account_{{$parentAaccount->id}}">
                                                    <td class="account_name account_line">
                                                        <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                                                    </td>
                                                    <td style="text-align: right"> @money(abs($account->currentYearLedger->sum('cr_amount') - $account->currentYearLedger->sum('dr_amount')))</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
{{--                                {{die()}}--}}
                            @php
                                $directIncomeOPB = $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                                    - $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount');

                                $indirectIncomeOPB = $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                                    - $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount');


                                $directExpensesOPB = $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount')
                                    - $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                                    ;

                                $indirectExpensesOPB = $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount')
                                    - $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount')
                                    ;
                                $grossProfitOPB = $directIncomeOPB - $directExpensesOPB;
                                $netProfitOPB = $grossProfitOPB +  $indirectIncomeOPB - $indirectExpensesOPB;

                                $directIncome = $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                                    - $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount');

                                $indirectIncome = $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                                    - $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount');

                                $directExpenses = $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount')
                                    - $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                                    ;

                                $indirectExpenses = $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount')
                                    - $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount')
                                    ;

                                $grossProfit = $directIncome - $directExpenses;
                                $netProfit = $grossProfit +  $indirectIncome - $indirectExpenses;
                            @endphp
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="balance_line" id=""> Opening </th>

                                <td></td>
                                <th style="text-align: right"><b>@money(abs($netProfitOPB)) </b> </th>
                            </tr>
                            <tr>
                                <th class="balance_line" id=""> <b>{{$netProfit >= 0 ? 'Profit' : 'Loss'}} </b> </th>
                                <td></td>
                                <th style="text-align: right"><b>@money(abs($netProfit)) </b> </th>
                            </tr>
                            </tfoot>
                        </table>
                    </td>
                    <td style="vertical-align: top" colspan="3">
                        <table style="width: 100%">
                            <thead style="background:#116A7B; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Assets</td>
                            </tr>
                            </thead>
                            <tbody>
                            @php $totalAssests=0 @endphp
                            @foreach($assets as $assetHeader)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header" colspan="">{{$assetHeader->line_text}}</td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: right">
                                        <strong>
                                            @php
                                                $assetHeaderOB = $assetHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten();
                                                $assetHeaderOBAmount = $assetHeaderOB->sum('dr_amount') -$assetHeaderOB->sum('cr_amount');
                                                $assetHeaderAmount = $assetHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten();
                                                $assetHeaderCls = $assetHeaderAmount->sum('dr_amount') - $assetHeaderAmount->sum('cr_amount') + $assetHeaderOBAmount;
                                            @endphp
                                                @money(abs($assetHeaderCls))
                                            @php  $totalAssests += $assetHeaderCls; @endphp
                                        </strong>
                                    </td>
                                </tr>
                                @foreach($assetHeader->descendants as $assetBalanceLine)
                                    @php
                                        $assetBalanceLineOB = $assetBalanceLine->accounts->flatten()->pluck('previousYearLedger')->flatten();
                                        $assetBalanceLineOBAmount = $assetBalanceLineOB->sum('dr_amount') - $assetBalanceLineOB->sum('cr_amount');
                                        $assetBalanceLineAmount = $assetBalanceLine->accounts->flatten()->pluck('currentYearLedger')->flatten();
                                        $assetBalanceLineCls = $assetBalanceLineAmount->sum('dr_amount') - $assetBalanceLineAmount->sum('cr_amount') + $assetBalanceLineOBAmount;
                                    @endphp
                                    <tr>
                                        <td class="balance_line" id="{{$assetBalanceLine->id}}"> {{$assetBalanceLine->line_text}} </td>
                                        <td style="text-align: right"> @money(abs($assetBalanceLineCls)) </td>
                                    </tr>
                                    @php $assetParentAccounts = $assetBalanceLine->accounts()->whereNull('parent_account_id')->get() @endphp
                                    @foreach ($assetParentAccounts as $assetParentAccount)
                                        @php
                                            if ($assetParentAccount->accountChilds->pluck('accountChilds')->collapse()->isNotEmpty()){
                                                $assetParentAccountOB = $assetParentAccount->accountChilds->pluck('accountChilds')->collapse()->pluck('previousYearLedger')->flatten();                                                    $test = 'two child';
                                                $assetParentAccountAmount = $assetParentAccount->accountChilds->pluck('accountChilds')->collapse()->pluck('currentYearLedger')->flatten();                                                    $test = 'two child';
                                            }elseif ($assetParentAccount->accountChilds()->exists()){
                                                $assetParentAccountOB = $assetParentAccount->accountChilds->pluck('previousYearLedger')->flatten();
                                                $assetParentAccountAmount = $assetParentAccount->accountChilds->pluck('currentYearLedger')->flatten();
                                            }else{
                                                $assetParentAccountOB = $assetParentAccount->previousYearLedger;
                                                $assetParentAccountAmount = $assetParentAccount->currentYearLedger;
                                            }
                                            $assetParentAccountOBAmount = $assetParentAccountOB->sum('dr_amount') - $assetParentAccountOB->sum('cr_amount');
                                            $assetParentAccountCls = $assetParentAccountAmount->sum('dr_amount') - $assetParentAccountAmount->sum('cr_amount') + $assetParentAccountOBAmount;
                                            $childAccounts = $assetParentAccount->where('parent_account_id',$assetParentAccount->id)->get();
                                        @endphp
                                        <tr class="account_row  balance_account_{{$assetBalanceLine->id}}" >
                                            <td class="account_name parent_account_line" id="{{$assetParentAccount->id}}">{{$assetParentAccount->account_name}} </td>
                                            <td style="text-align: right">  @money(abs($assetParentAccountCls)) </td>
                                        </tr>
                                        @foreach($childAccounts as $childAccount)
                                            @php $accounts = $childAccount->where('parent_account_id',$childAccount->id)->get();
                                                if ($childAccount->accountChilds()->exists()){
                                                    $childAccountOB = $childAccount->accountChilds->pluck('previousYearLedger')->flatten();
                                                    $childAccountAmount = $childAccount->accountChilds->pluck('currentYearLedger')->flatten();
                                                }else{
                                                    $childAccountOB = $childAccount->previousYearLedger;
                                                    $childAccountAmount = $childAccount->currentYearLedger;
                                                }
                                                $childAccountOBAmount = $childAccountOB->sum('dr_amount') - $childAccountOB->sum('cr_amount');
                                                $childAccountCls = $childAccountAmount->sum('dr_amount') - $childAccountAmount->sum('cr_amount') + $childAccountOBAmount;
                                                //$childAccountAmount = abs($childAccount->ledgers->sum('dr_amount') - $childAccount->ledgers->sum('cr_amount'))
                                            @endphp
{{--                                            @if($childAccount->ledgers()->exists())--}}
                                                <tr class="account_row parent_account_{{$assetParentAccount->id}} hide_balance_account_{{$assetBalanceLine->id}}">
                                                    <td class="account_name child_account_line" id="{{$childAccount->id}}">
                                                        @if($childAccount->accountChilds()->exists())
                                                            {{$childAccount->account_name}}
                                                        @else
                                                            <a href="{{url("ledgers?account_id=$childAccount->id")}}" target="blank">{{$childAccount->account_name}} </a>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: right"> @money(abs($childAccountCls))  </td>
                                                </tr>
{{--                                            @endif--}}

                                            @foreach($accounts as $account)
                                                @php
                                                    $accountOB = $account->previousYearLedger->sum('dr_amount') - $account->previousYearLedger->sum('cr_amount');
                                                    $accountAmount =  $account->currentYearLedger->sum('dr_amount') - $account->currentYearLedger->sum('cr_amount');
                                                    $accountCls = $accountAmount + $accountOB ;
                                                @endphp
                                                <tr class="account_row account_{{$childAccount->id}} hide_balance_account_{{$assetBalanceLine->id}} hide_parent_account_{{$assetParentAccount->id}}">
                                                    <td class="account_name account_line">
                                                        <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                                                    </td>
                                                    <td style="text-align: right"> @money(abs($accountCls))</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr style="background:#e3e3e3">
                    <th colspan="2" class="text-right" style="width: 60%; border-right: none"> Total Liabilities</th>
                    <th class="text-right" style="border-left: none">
{{--                        @money(abs($netProfit > 0 ? $totalLiabilities + $netProfit : $totalLiabilities - $netProfit ))--}}
                        @money(abs($totalLiabilities + $netProfit + $netProfitOPB))
                    </th>
                    <th colspan="2" class="text-right" style="width: 60%; border-right: none">Total Assets</th>
                    <th class="text-right" style="border-left: none">
                        @money(abs($totalAssests))
                    </th>
                </tr>
            </table>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function(){
            $(document).on('click', '.balance_line', function(){
                let currentLine = $(this).attr('id');
                $(".balance_account_"+currentLine).toggle();
                $(".hide_balance_account_"+currentLine).hide();
            });
            $(document).on('click', '.parent_account_line', function(){
                let parentAccountLine = $(this).attr('id');
                $(".parent_account_"+parentAccountLine).toggle();
                $(".hide_parent_account_"+parentAccountLine).hide();
            });
            $(document).on('click', '.child_account_line', function(){
                let childAccountLine = $(this).attr('id');
                $(".account_"+childAccountLine).toggle();
            });
            $('#applied_date').datepicker({
                format: "yyyy",
                autoclose: true,
                todayHighlight: false,
                showOtherMonths: false,
                minViewMode: 2
            });
        });
    </script>
@endsection
